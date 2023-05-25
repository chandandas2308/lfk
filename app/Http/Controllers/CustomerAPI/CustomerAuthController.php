<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointshop;
use App\Models\SignInSetting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;
use File;
use Image;

class CustomerAuthController extends Controller
{
    public function test()
    {
        // $data = User::get();
        // return $data;
        $response = \GoogleMaps::load('geocoding')
        ->setParam (['address' =>'santa cruz'])
        ->get();
        dd($response);
    }
    // ===================================================================================================================
    //                                              REGISTER
    // ===================================================================================================================
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required",
                "phoneNumber" => "required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|max:15",
                "month" => "required",
                "day" => "required",
                "year" => "required",
                "gender" => "required",
                "postalCode" => "required",
                "address" => "required",
                "unitNumberName" => "required",
                "email" => "required",
                "password" => "required|min:6"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "Invalid Inputs",
                    "error" => $validator->getMessageBag()->toArray()
                ], 401);
            } else {

                $count = User::where('email', $request->email)->count();

                if ($count != 0) {
                    return response()->json([
                        "status" => false,
                        "message" => "Email already registered",
                        "email" => $request->email
                    ], 409);
                } else {
                    $user = User::create([
                        "is_admin" => "0",
                        "name" => $request->name,
                        "email" => $request->email,
                        "mobile_number" => $request->phoneNumber,
                        "month" => $request->month,
                        "day" => $request->day,
                        "year" => $request->year,
                        "gender" => $request->gender,
                        "postal_code" => $request->postalCode,
                        "address" => $request->address,
                        "unit_number" => $request->unitNumberName,
                        "password" => Hash::make($request->password)
                    ]);
                    Customer::create([
                        'customer_id' => $user->id,
                        'customer_name' => $request->name,
                        'customer_type' => 'retail',
                        'address' => $request->address,
                        "unit_number" => $request->unitNumberName,
                        "month" => $request->month,
                        "day" => $request->day,
                        "year" => $request->year,
                        "gender" => $request->gender,
                        "postal_code" => $request->postalCode,
                        'mobile_number' => $user->mobile_number,
                        'email_id' => $request->email
                    ]);
                    
                    $points = SignInSetting::first();

                    if(!empty($points)){
                        $earn_points = $points->points;
                    }else{
                        $earn_points = 0;
                    }

                    LoyaltyPointshop::create([
                        'user_id' => $user->id,
                        'loyalty_points' => $earn_points,
                        'last_transaction_id' => 1
                    ]);

                    LoyaltyPoint::create([
                        'user_id' => $user->id,
                        'gained_points' => $earn_points,
                        'spend_points' => 0,
                        'remains_points' => $earn_points,
                        'transaction_id' => 1,
                        'transaction_amount' => 0,
                        'transaction_date' => now(),
                    ]);

                    $token = $user->createToken('my-app-token')->plainTextToken;

                    return response()->json([
                        "status" => true,
                        "message" => "User successfully registered",
                        'user_details' => $user,
                        'token' => $token,
                        "earn_points" => $earn_points
                    ], 201);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // 
       // ===================================================================================================================
    //                                              Login with Facebook
    // ===================================================================================================================
    public function facebook(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required",
                "fb_id" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "Invalid Inputs",
                    "error" => $validator->getMessageBag()->toArray()
                ], 401);
            } else {
                $username = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number' ;

                $user = User::where($username, $request->username)->first();


                $count = User::where('email', $request->email)->count();
                $idTab = User::where('email', $request->email)->value('id');
                $user_email = User::where('email', $request->email)->value('name');
                $token = $user->createToken('my-app-token')->plainTextToken;

                if ($count != 0) {
                    return response()->json([
                        "status" => false,
                        "message" => "Email already registered",
                        "email" => $request->email,
                        "id" => $idTab,
                        "User_detail" => $user_email,
                        'token' => $token,
                    ], 409);
                } else {
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'fb_id' => $request->fb_id,
                        'is_admin' => '0',
                    ]);
                    Customer::create([
                        'customer_id' => $user->id,
                        'customer_name' => $user->name,
                        'email_id' => $user->email,
                        'fb_id' => $user->fb_id,
                        'customer_type' => 'retail',
                    ]);
                    
                    $points = SignInSetting::first();

                    if(!empty($points)){
                        $earn_points = $points->points;
                    }else{
                        $earn_points = 0;
                    }

                    LoyaltyPointshop::create([
                        'user_id' => $user->id,
                        'loyalty_points' => $earn_points,
                        'last_transaction_id' => 1
                    ]);


                    $token = $user->createToken('my-app-token')->plainTextToken;

                    return response()->json([
                        "status" => true,
                        "message" => "User successfully registered.",
                        'user_details' => $user,
                        'token' => $token,
                        'earn_points' => $earn_points,
                    ], 201);
                    $fb =  $user;
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    // ===================================================================================================================
    //                                              LOGIN
    // ===================================================================================================================
    public function login(Request $request)
    {
        $username = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number' ;
        $data = User::where($username, $request->username)->first();
        if (!empty($data)) {
            if ($data->status == 0) {
                return response()->json('Your account is temporarly deactivated. Contact your administrator');
            } else {
                try {
                    $validator = Validator::make($request->all(), [
                        "email" => "",
                        "mobile_number" => "",
                        "password" => "required"
                    ]);
                    if ($validator->fails()) {
                        return response()->json([
                            "status" => false,
                            "message" => "Invalid Inputs",
                            "error" => $validator->getMessageBag()->toArray()
                        ], 422);
                    } else {
                        $username = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number' ;
                        $user = User::where($username, $request->username)->first();
                        if (!$user || !Hash::check($request->password, $user->password)) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Invalid Credential'
                            ], 400);
                        }
                        $token = $user->createToken('my-app-token')->plainTextToken;
                        $response = [
                            'status' => true,
                            'message' => 'login sucessfully',
                            'user_details' => $user,
                            'token' => $token
                        ];
                        User::where($username, $request->username)->update([
                            'last_login_at' => Carbon::now()->toDateTimeString(),
                            'last_login_ip' => $request->ip(),
                        ]);
                        return response($response, 200);
                    }
                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()]);
                }
            }
        }
        return response()->json(['success' => 'Not registered yet']);
    }


    // ===================================================================================================================
    //                                              FORGOT PASSWORD
    // ===================================================================================================================
    public function forgot(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            } else {
                $user = User::where('email', $request->email)->first();

                if (!$user) {
                    return response()->json(['status' => false, 'message' => 'Email not exist!'], 200);
                }

                $credentials = request()->validate(['email' => 'required|email']);
                Password::sendResetLink($credentials);

                return response()->json(["success" => 'Reset password link sent on your email id.']);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    // ===================================================================================================================
    //                                              RESET PASSWORD
    // ===================================================================================================================
    public function reset(Request $request)
    {
        try {
            $credentials = Validator::make($request->all(), [
                "email" => "required|email",
                "token" => "required",
                "password" => "required|same:password_confirmation"
            ]);

            if ($credentials->fails()) {
                return response()->json(['error' => $credentials->getMessageBag()->toArray()]);
            } else {

                $status = Password::reset(
                    $request->only('email', 'password', 'password_confirmation', 'token'),
                    function ($user, $password) {
                        $user->forceFill([
                            'password' => Hash::make($password)
                        ])->setRememberToken(Str::random(60));

                        $user->save();

                        event(new PasswordReset($user));
                    }
                );

                if ($status == Password::INVALID_TOKEN) {
                    return response()->json(["message" => "Invalid token provided"], 400);
                }

                return response()->json(["success" => "Password has been successfully changed"]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


    // ===================================================================================================================
    //                                              CHANGE PASSWORD
    // ===================================================================================================================
    public function changepswd(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'current_password' => 'required',
                'password' => 'required|min:6|same:password_confirmation',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            }

            $user = User::find($request->id);

            $old_password = $user->password;

            if (Hash::check($request->password, $old_password)) {
                return response()->json(["error" =>  "Error! New Password and Current password can't be same."]);
            } elseif (Hash::check($request->current_password, $old_password)) {
                $obj_user = User::find($request->id);
                $obj_user->password = Hash::make($request->password);
                $obj_user->save();
                return response()->json(["success" => "Password changed successfully !"]);
            } else {
                return response()->json(["error" =>  "Error! Please enter correct current password."]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // ===================================================================================================================
    //                                              LOGOUT
    // ===================================================================================================================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['success' => 'Successfully logged out']);
    }
    public function profile($id)
    {
        $profileData = DB::table('users')
            ->join('customers', 'users.id', '=', 'customers.customer_id')
            ->where('customer_id', $id)
            ->Where('customer_type', 'retail')
            ->select('customers.*','users.*')
            ->get();
        return response($profileData, 200);
    }
    public function updateprofile(Request $request, $id)
    {
        $url = env("APP_URL", "http://lfk.sg/");
        $user = DB::table('users')
            ->join('customers', 'users.id', '=', 'customers.customer_id')
            ->where('customer_id', $id)
            ->Where('customer_type', 'retail')
            ->select('customers.*', 'users.*')
            ->first();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'mobile_number' => 'required|unique:users,mobile_number,' . $user->id,
            'address' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        if ($request->image != null) {
           
            if (!file_exists('profile')) {
                mkdir('profile', 777, true);
            }
            File::delete($user->image);
            $image_resize = Image::make($request->image->getRealPath());
            $image_resize->save(public_path('profile/' . $request->name . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));

            $path = 'profile/' . $request->name . date('d_m_y_h') . time() . "." .  $request->image->extension();
            $user = User::where('id', $id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "mobile_number" => $request->mobile_number,
                "image" => $url . $path,
            ]);
            Customer::where('customer_id', $id)->update([
                'customer_name' => $request->name,
                'address' => $request->address,
                'mobile_number' => $request->mobile_number,
                'email_id' => $request->email,
                "image" => $url . $path,
            ]);
            return response()->json(['message' => 'Profile updated successfully!'], 200);
        } else {
            $user = User::where('id', $id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "mobile_number" => $request->mobile_number,
            ]);
            Customer::where('customer_id', $id)->update([
                'customer_name' => $request->name,
                'address' => $request->address,
                'mobile_number' => $request->mobile_number,
                'email_id' => $request->email,
            ]);
            return response()->json(['message' => 'Profile updated successfully!'], 200);
        }
    }
    public function deactivateaccount($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if ($user->status == '0') {
            return response()->json(['message' => 'Account already deactivated!'], 200);
        }
        User::where('id', $user_id)->update([
            'status' => '0'
        ]);
        return response()->json(['message' => 'Account deactivated successfully!'], 200);
    }
}
