<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetTracking;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FixedAssetContoller extends Controller
{
    //

    public function index(){
        return view('superadmin.fixedAssetManagement');
    }

    // Add Data
    public function addAsset(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "quantity" => "required",
            "price" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{
            try{

                Asset::insert([
                    "name" => $request->name,
                    "quantity" => $request->quantity,
                    "price" => $request->price,
                    "gst" => $request->gst,
                    "created_at" => now(),
                ]);
                return response()->json(['success'=>'Asset Detials Added Succesfully']);

            }catch(Exception $e){
                return response()->json(['barerror'=>"Database Query Error..."]);
            }
        }
    }

    // fetch all data
    public function getAsset(){
        try{
            return response()->json(DB::table('assets')->paginate(10));
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    public function getAssetList(){
        try{
            return response()->json(Asset::all());
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    // fetch single asset
    public function fetchAsset(){
        try{
            $id = $_GET['id'];
            return response()->json(Asset::all()->where('id', $id));
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    // update asset detials
    public function updateAsset(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "quantity" => "required",
            "price" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{
            try{

                Asset::where('id', $request->assetId)
                ->update([
                    "name" => $request->name,
                    "quantity" => $request->quantity,
                    "price" => $request->price,
                    "gst" => $request->gst,
                    "updated_at" => now(),
                ]);
                return response()->json(['success'=>'Asset Detials Updated Succesfully']);

            }catch(Exception $e){
                return response()->json(['barerror'=>"Database Query Error..."]);
            }
        }        
    }

    // remove asset detials
    public function removeAsset(){
        try{
            $id = $_GET['id'];
            Asset::where('id', $id)->delete();
            return response()->json(['success'=>'Asset Detials Removed Succesfully']);
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    // get asset quantity
    public function fetchAssetQuantity(){
        try{
            $value = $_GET['value'];
            return response()->json(Asset::all()->where('name', $value));
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    // add asset traking data
    public function addAssetTrakingData(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "quantity" => "required",
            "location" => "required",
            "status" => "required"
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{
            try{

                AssetTracking::insert([
                    "name" => $request->name,
                    "quantity" => $request->quantity,
                    "location" => $request->location,
                    "status" => $request->status,
                    "created_at" => now(),
                ]);
                return response()->json(['success_stock_tracking'=>'Asset Tracking Detials Added Succesfully']);

            }catch(Exception $e){
                return response()->json(['barerror'=>"Database Query Error..."]);
            }
        }
    }

    // fetch all asset tracking detials
    public function assetTrakingDetails(){
        try{
            return response()->json(DB::table('asset_trackings')->paginate(10));
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    // fetch single asset detials
    public function fetchAssetTrakingDetails(){
        try{
            $id = $_GET['id'];
            return response()->json(AssetTracking::all()->where('id', $id));
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    // update asset detials
    public function updateAssetTrakingDetails(Request $request){
        $validator = Validator::make($request->all(),[
            "name" => "required",
            "quantity" => "required",
            "location" => "required",
            "status" => "required"
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{
            try{

                AssetTracking::where('id', $request->assetId)
                ->update([
                    "name" => $request->name,
                    "quantity" => $request->quantity,
                    "location" => $request->location,
                    "status" => $request->status,
                    "updated_at" => now(),
                ]);
                return response()->json(['update_success'=>'Asset Tracking Detials Updated Succesfully']);

            }catch(Exception $e){
                return response()->json(['barerror'=>"Database Query Error..."]);
            }
        }
    }

    // remove asset detials 
    public function removeAssetTrakingDetails(){
        try{
            $id = $_GET['id'];
            AssetTracking::where('id', $id)->delete();
            return response()->json(['success'=>'Asset Tracking Detials Removed Succesfully']);
        }catch(Exception $e){
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

}
