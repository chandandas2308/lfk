<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\PosStocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    //

    public function viewPosStockDetails()
    {

        $stockData = PosStocks::where('owner_id', Auth::user()->id)->get();

        $data1 = [];

        foreach ($stockData as $key => $value) {
            $data1[$value['product_id']]=$value;
        }

        $new_data=[];

        $i = 0;
        $action = "";
        foreach($data1 as $item){

            $action .= '<a href="javascript:void(0)" id="show-stock" data-url="'.route('Pos-StockShow',$item->id).'"><i class="bi bi-eye"></i></a>';

            $quantity = 0;

            foreach($stockData as $key => $value){
                if($value["product_id"] == $item->product_id){
                    $quantity += $value["quantity"];
                }
            }

            $new_data[] = array(
                ++$i,
                $item->product_name,
                $item->product_variant,
                $item->unit_price,
                $quantity,
                $item->barcode,
                $action
            );
            
            $action = '';
        }
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $stockData->count(),
            "recordsFiltered" 	=> $stockData->count(),
            "data" 				=> $new_data
        );

        echo json_encode($output);
    }
}
