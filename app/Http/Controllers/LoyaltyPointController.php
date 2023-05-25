<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AssetTracking;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointshop;
use App\Models\LoyaltyPointTodays;
use App\Models\product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoyaltyPointController extends Controller
{


    // fetch all loyalty points
    public function fetchAllPoints()
    {
        $data = LoyaltyPoint::join('users', 'users.id','=','loyalty_points.user_id')->get(["users.*", "loyalty_points.*"]);
        
        $new_data = array();
        $i = 0;

        foreach($data as $item){
            $new_data[] = array(
                ++$i,
                $item->name,
                $item->email,
                $item->gained_points,
                $item->spend_points,
                $item->remains_points,    
                $item->transaction_date
            );
        }
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $data->count(),
            "recordsFiltered" 	=> $data->count(),
            "data" 				=> $new_data
        );

        echo json_encode($output);
    }
    // end here

    public function index(){
        return view('superadmin.LoyaltyPointManagement');
    }
    

        // store loyalty points
        public function storeLoyaltyPoints(Request $request)
        {
            $item = LoyaltyPointTodays::updateOrCreate(
                ['amount' => $request->prevAmount, 'points' => $request->prevPoints],
                ['amount' => $request->dollor, 'points' => $request->loyaltyPoints]
            );
            return response()->json(['success' => 'Loyalty Point Added Successfully']);
        }
    
        public function fetchLoyaltyPoints()
        {
            return response()->json(LoyaltyPointTodays::all());
        }

// update loyalty point chart detials
public function GetAssetloyal(){
    try{
        return response()->json(DB::table('loyalty_points')->paginate(10));
    }catch(Exception $e){
        return response()->json(['barerror'=>"Database Query Error..."]);
    }
}
public function FetchAssetloyality(){
    try{
        $value = $_GET['id'];
        return response()->json(LoyaltyPoint::all()->where('id', $value));
    }catch(Exception $e){
        return response()->json(['barerror'=>"Database Query Error..."]);
    }
}

public function removeLoyality(){
    try{
        $id = $_GET['id'];
        LoyaltyPoint::where('id', $id)->delete();
        return response()->json(['success'=>'Loyalty Points Removed Succesfully']);
    }catch(Exception $e){
        return response()->json(['barerror'=>"Database Query Error..."]);
    }
}

 // update reward points shop detials

 public function GetAssetloyalshop(){
    try{
        return response()->json(DB::table('loyalty_pointshops')->paginate(10));
    }catch(Exception $e){
        return response()->json(['barerror'=>"Database Query Error..."]);
    }
}

public function AddloyalshopData(Request $request){

    $validator = Validator::make($request->all(),[
        "ProductName_id" => "required",
        "ProductName" => "required",
        "LoyaltyPoints" => "required"
    ]);

    if($validator->fails()){
        return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
    }else{
      
            LoyaltyPointshop::insert([
                "product_id" => $request->ProductName_id,
                "product_name" => $request->ProductName,
                "loyalty_points" => $request->LoyaltyPoints,
                "created_at" => now()
            ]);

            
            return response()->json(["success" => "Product is Added Successfully in Shop."]);
      
    }
}

public function GetNameProductsa(){
    $id = $_GET['id'];
    return response()->json(product::all()->where("id", $id));
}
public function removeLoyalityShop(){
    try{
        $id = $_GET['id'];
        LoyaltyPointshop::where('id', $id)->delete();
        return response()->json(['success'=>'Loyalty Points Removed Succesfully']);
    }catch(Exception $e){
        return response()->json(['barerror'=>"Database Query Error..."]);
    }
}
public function FetchAssetshop(){
    $id = $_GET["id"];
    $data = LoyaltyPointshop::all()->where("id", $id);
    return response()->json($data);
}

public function editoyalshopData(Request $request)
    {
      
       
        LoyaltyPointshop::where("id", $request->assetIdss)
                ->update([
                    "product_id" => $request->ProductName_id,
                    "product_name" => $request->ProductName,
                    "loyalty_points" => $request->LoyaltyPoints,
                    "updated_at" => now()
                ]);

            return response()->json(['success' => 'Loyalty Points Updated Succesfully']);
       
    }
    // update reward points detials
    public function AddLoyaltyPoints(Request $request){
       
            try{

                LoyaltyPointTodays::where('id', 1)
                ->update([
                    "loyaltypoints" => $request->loyaltypoints,
                ]);
                return response()->json(['update_success'=>'Asset Tracking Detials Updated Succesfully']);

            }catch(Exception $e){
                return response()->json(['barerror'=>"Database Query Error..."]);
            }
       
    }
    
    public function RefergetIdss()
    {
        $id = 1;
        $data = LoyaltyPointTodays::all()->where("id", $id);
        return response()->json($data);
    }
  

}
