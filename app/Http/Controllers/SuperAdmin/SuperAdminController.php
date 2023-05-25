<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\SalesInvoice;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superadmin.index');
    }

    public function fetchChartMonthWiseSale()
    {
        $data = SalesInvoice::select(
            DB::raw("(COUNT(*)) as count"),
            DB::raw("(sum(total)) as total"),
            DB::raw("MONTHNAME(created_at) as month_name")
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month_name')
        ->orderBy('created_at', 'asc')
        ->get()
        ->toArray();
  $arr = [
    ['Month','Sales'],
    ['January',(int)102110],
    ['February',(int)87360],
    ['March',(int)85970]
  ];
        // if(sizeof($data) > 0){
        //     $arr = [['Month', 'Sales']];
        // }else{
        //     $arr = [['Month', 'Sales'],[Carbon::now()->format('F'), 0]];
        // }

        // foreach($data as $value){
        //     array_push($arr, [$value['month_name'],(int)$value['total']]);
        // }

        return response()->json($arr);
    }

    // view profile info
    public function profile(){
        return view('superadmin.profile-modal.view');
    }

    // update page redirect (profile detials update page)
    public function updateProfileFile(){
        return view('superadmin.profile-modal.update');
    }

    // update super admin profile / other user profile 
    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "email" => "required|email:rfc,dns",
            "mobno" => "required|min:10",
            "phno" => "required|min:10",
        ],
        [
            "name" => "Name is required",
            "email" => "Email ID is required",
            "phno" => "Phone number is required",
            "mobno" => "Mobile number is required"
        ]
    );

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{
            User::where('id', $request->id)
            ->update([
                "name" => $request->name,
                "email" => $request->email,
                "phone_number" => $request->phno,
                "mobile_number" => $request->mobno,
                "updated_at" => now(),
            ]);
            return response()->json(['success'=>'Profile Updated Successfully']);
        }
    }

    // fetch updated data
    public function getProfile(){
        $id = Auth::User()->id;
        return response()->json(User::all()->where('id', $id));
    }

    // update password
    public function updatePassword(Request $request){
        $user = User::find($request->id);
        $old_password = $user->password;
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:8|same:password_confirmation',
        ],
            [
                "current_password" => "Old Password is Required",
                "password" => "New Password is required",
                "same" => "Confirm Password is required"
            ]
        );

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }

        if (Hash::check($request->password, $old_password)) {
            return response()->json(["barerror" =>  "New Password and Old pPassword can not be Same."]);
        } elseif (Hash::check($request->current_password, $old_password)) {
            $obj_user = User::find($request->id);
            $obj_user->password = Hash::make($request->password);
            $obj_user->save();
            return response()->json(["success" => "Password Changed Successfully !"]);
        } else {
            return response()->json(["barerror" =>  "Please Enter Correct Old Password."]);
        }
    }

    // fetch no of products
    public function getNoOfProducts()
    {
        return response()->json(product::all()->count());
    }

    // Total Sale
    public function totalSale()
    {
        $total = 0;

        $data = SalesInvoice::all()->count();

        // foreach($data as $value){
        //     $total += $value['total'];
        // }
        return $data;
    }

    // Total Purchase
    public function totalPurchase()
    {
        $total = 0;

        $data = PurchaseOrder::all()->count();

        // foreach($data as $value){
        //     $total += $value['total'];
        // }
        return $data;        
    }

    // Total Orders
    public function totalOrders()
    {
        return response()->json(Quotation::all()->where("status", "Confirmed")->count());
    }

}
