<?php

namespace App\Http\Controllers\DeliveryAPI;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Driver;
use Carbon\Carbon;
use Exception;
use Image;
use File;

class DeliveryAuthController extends Controller
{

    public function orderDeliveries($user_id)
    {
        $data = Delivery::where('customer_id', $user_id)->get();
        $response = [
            'status' => true,
            'data' => $data,
        ];
        return response($response, 200);
    }

    // ===================================================================================================================
    //                                              LOGIN
    // ===================================================================================================================
    public function deliveryLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required",
                "password" => "required"
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            } else {
                $user = User::where('email', request()->email)->where('is_admin', '5')->first();
                if ($user != null) {
                    $pass = Hash::check($request->password, $user->password);
                    if ($pass) {
                        $token = $user->createToken('my-app-token')->plainTextToken;

                        $response = [
                            'status' => true,
                            'message' => 'login sucessfully',
                            'user_details' => $user,
                            'token' => $token
                        ];
                        User::where('email', $request->email)->update([
                            'last_login_at' => Carbon::now()->toDateTimeString(),
                            'last_login_ip' => $request->ip(),
                        ]);
                        return response($response, 200);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Wrong Password'], 200);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'No Record found'], 200);
                }
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    // ===================================================================================================================
    //                                              FORGOT PASSWORD
    // ===================================================================================================================

    public function forgot(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $credentials = request()->validate(['email' => 'required|email']);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Email not exist!'], 200);
        }
        Password::sendResetLink($credentials);

        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }

    // ===================================================================================================================
    //                                              RESET PASSWORD
    // ===================================================================================================================

    public function reset(Request $request)
    { {
            $credentials = request()->validate([
                'email' => 'required|email',
                'token' => 'required|string',
                'password' => 'required|string|confirmed'
            ]);

            $reset_password_status = Password::reset($credentials, function ($user, $password) {
                $user->password = $password;
                $user->save();
            });

            if ($reset_password_status == Password::INVALID_TOKEN) {
                return response()->json(["msg" => "Invalid token provided"], 400);
            }

            return response()->json(["msg" => "Password has been successfully changed"]);
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

    public function deliveryLogout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['success' => 'Successfully logged out']);
    }
    // ===================================================================================================================
    //                                              Profile
    // ===================================================================================================================

    public function deliveryprofile($id)
    {
        try {
            $profileData = DB::table('users')
                ->join('drivers', 'users.id', '=', 'drivers.driver_id')
                ->where('driver_id', $id)
                ->select('drivers.*')
                ->get();
            return response($profileData, 200);
        } catch (Exception $e) {
            return response()->json(['error' => "Some things went wrong! Please try again"]);
        }
    }
    // ===================================================================================================================
    //                                              Update profile
    // ===================================================================================================================

    public function deliveryupdateprofile(Request $request, $id)
    {
        // $url = env("APP_URL", "http://lfk.sg/");
        // $user = DB::table('drivers')
        //     ->where('id', $id)
        //     ->select('drivers.*')
        //     ->first();
        // $validator = Validator::make($request->all(), [
        //     'driver_name' => 'required',
        //     'driver_email' => 'required|string|email|max:255|unique:drivers,driver_email,' . $user->id,
        //     'driver_mobile_no' => 'required|unique:drivers,driver_mobile_no,' . $user->id,
        //     'driver_address' => 'required'
        // ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors());
        // }
        // if ($request->image != null) {

        //     if (!file_exists('profile')) {
        //         mkdir('profile', 777, true);
        //     }

        //     $user = Driver::where('id', $id)->update([
        //         "driver_name" => $request->driver_name,
        //         "driver_email" => $request->driver_email,
        //         "driver_mobile_no" => $request->driver_mobile_no,
        //         'driver_address' => $request->driver_address,
        //     ]);
        //     User::where('id', $id)->update([
        //         "name" => $request->driver_name,
        //         "email" => $request->driver_email,
        //         "mobile_number" => $request->driver_mobile_no,
        //         'address' => $request->driver_address,
        //     ]);

        //     return response()->json(['message' => 'Profile updated successfully!'], 200);
        // } else {
        //     $user = Driver::where('id', $id)->update([
        //         "driver_name" => $request->driver_name,
        //         "driver_email" => $request->driver_email,
        //         "driver_mobile_no" => $request->driver_mobile_no,
        //         'driver_address' => $request->driver_address,
        //     ]);
        //     user::where('id', $id)->update([
        //         "name" => $request->driver_name,
        //         "email" => $request->driver_email,
        //         "mobile_number" => $request->driver_mobile_no,
        //         'address' => $request->driver_address,
        //     ]);

        //     return response()->json(['message' => 'Profile updated successfully!'], 200);
        // }

        $url = env("APP_URL", "https://lfk.sg");
        $user = DB::table('users')
            ->join('drivers', 'users.id', '=', 'drivers.driver_id')
            ->where('driver_id', $id)
            ->select('drivers.*', 'users.*','drivers.id as drivers_id')
            ->first();
        $validator = Validator::make($request->all(), [
            'driver_name' => 'required',
            'driver_email' => 'required|string|email|max:255|unique:drivers,driver_email,' . $user->drivers_id,
            'driver_mobile_no' => 'required|unique:drivers,driver_mobile_no,' . $user->drivers_id,
            'driver_address' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        if ($request->image != null) {
            if (!file_exists('profile')) {
                mkdir('profile', 777, true);
            }
            $image_resize = Image::make($request->image->getRealPath());
            $image_resize->resize(400, 400);
            $image_resize->save(public_path('profile/' . $request->name . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));
            $path = 'profile/' . $request->name . date('d_m_y_h') . time() . "." .  $request->image->extension();
            $imagepath = $path;
            File::delete($user->image);
            $user = User::where('id', $id)->update([
                "name" => $request->driver_name,
                "email" => $request->driver_email,
                "mobile_number" => $request->driver_mobile_no,
                'address' => $request->driver_address,
            ]);
            Driver::where('driver_id', $id)->update([
                "driver_name" => $request->driver_name,
                "driver_email" => $request->driver_email,
                "driver_mobile_no" => $request->driver_mobile_no,
                'driver_address' => $request->driver_address,
                "image" => $url . $imagepath,
            ]);
            return response()->json(['message' => 'Profile updated successfully!'], 200);
        } else {
            $user = User::where('id', $id)->update([
                "name" => $request->driver_name,
                "email" => $request->driver_email,
                "mobile_number" => $request->driver_mobile_no,
                'address' => $request->driver_address,
            ]);
            Driver::where('driver_id', $id)->update([
                "driver_name" => $request->driver_name,
                "driver_email" => $request->driver_email,
                "driver_mobile_no" => $request->driver_mobile_no,
                'driver_address' => $request->driver_address,
            ]);
            return response()->json(['message' => 'Profile updated successfully!'], 200);
        }
    }
}
