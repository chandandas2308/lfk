<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ecredit;
use Illuminate\Support\Facades\DB;

class ECreditController extends Controller
{
    public function index(){
        return view('superadmin.ECredit');
    }

    public function store(Request $request)
    {
        Ecredit::insert([
            "price" => $request->price,
            "points" => $request->points,
            "created_at" => now()
        ]);

        return response()->json(['success' => 'E-Credit Details Added Successfully']);
    }

    public function fetchAllECredit()
    {
        $data = DB::table('ecredits')->orderBy('id', 'desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewECredit" data-toggle="modal" data-target="#viewECredit" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->customer_name,
                $item->mobile,
                $item->email,
                $item->available_balanced,
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

    public function fetchSingleECredit()
    {
        return response()->json(Ecredit::find($_GET['id']));
    }

    public function updateSingleECredit(Request $request)
    {
        Ecredit::where('id', $request->id)
        ->update([
            "price" => $request->price,
            "points" => $request->points,
            "updated_at" => now(),
        ]);
        return response()->json(['success' => 'E-Credit Details Updated Successfully']);
    }

    public function removeSingleECredit()
    {
        Ecredit::where('id', $_GET['id'])->delete();
        return response()->json(['success' => 'E-Credit Details Removed Successfully']);
    }
}
