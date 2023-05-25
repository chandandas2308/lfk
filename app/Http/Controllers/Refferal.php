<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Refferal as ModelsRefferal;
use App\Models\RefferalpointSetting;
use Illuminate\Http\Request;

class Refferal extends Controller
{
    public function index()
    {
        return view('superadmin.refferal');
    }
    public function GetRefferals()
    {
        $data = ModelsRefferal::orderBy('id','desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="deleteGetRefferal" data-toggle="modal" data-target=".viewWarehouse" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->id,
                $item->created_at,
                $item->created_at,
                $item->customer_name,
                $item->refferal_code,
                $item->refferal_by,
                $item->points,
                $action
            );
            $action = '';
        }

        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($data),
            "recordsFiltered" 	=> sizeOf($data),
            "data" 				=> $new_data
        );
        echo json_encode($output);
    }

    public function removeRefferals()
    {
        $id = $_GET["id"];
        ModelsRefferal::where("id", $id)->delete();
        return response()->json(["success" => "Refferal deleted successfully."]);
    }
    public function RefergetId()
    {
        $id = 1;
        $data = RefferalpointSetting::all()->where("id", $id);
        return response()->json($data);
    }
    
    // =================================================================================
    // Edit EditRewardcreate
    // =================================================================================    
    public function EditRewardcreate(Request $request)
    {
      
        RefferalpointSetting::where("id", 1)
                ->update([
                    "reward_points" => $request->points,
                    "additional_points" => $request->additionalpoints,
                    "updated_at" => now()
                ]);

            return response()->json(['success' => 'Refferal Point Setting updated successfully']);
       
    }

}
