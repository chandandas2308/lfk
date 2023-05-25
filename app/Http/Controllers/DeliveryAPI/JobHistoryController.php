<?php

namespace App\Http\Controllers\DeliveryAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Driver;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JobHistoryController extends Controller
{
    public function jobHistory($user_id)
    {
        $driver = Driver::where('driver_id', $user_id)->first();
        $counts = DB::table('deliveries')
            ->where('delivery_man_id', $user_id)
            ->select(
                DB::raw('DATE(created_at) as created_at'),
                DB::raw('COUNT(*) as Total_Task'),
                DB::raw('COUNT(CASE delivery_status WHEN "Delivered" THEN 1 ELSE NULL END) as Completed_Task')
            )
            ->groupBy(DB::raw('DATE(created_at)', 'delivery_status', 'Delivered'))
            ->get();
        $newArr = array();
        foreach ($counts as $item) {
            $newArr[] = ['created_at' => $item->created_at, 'Total_Task' => $item->Total_Task, 'Completed_Task' => $item->Completed_Task, 'Earning' => $item->Completed_Task * $driver->commission];
        }
        return response()->json($newArr, 200);
    }

    
    public function InventoryListByOrder($user_id, $order_no)
    {
        $data = DB::table('deliveries')
            ->where('delivery_man_id', $user_id)
            ->where('order_no', $order_no)
            ->select('deliveries.product_details')
            ->first();

          
            $products = DB::table('user_order_items')->join('products','products.id','=','user_order_items.product_id')
            ->select('user_order_items.product_name','products.product_varient as product_variant',DB::raw('SUM(user_order_items.quantity) as quantity'))
            ->where('consolidate_order_no',$order_no)
            ->groupBy('product_id')
            ->get();
        return response()->json($products, 200);
    }
    public function UpdateSingleDeliveryStatus($user_id, $order_no)
    {
        Delivery::where('delivery_man_id', $user_id)->where('order_no', $order_no)->where('delivery_status', 'Packing')->update([
            'delivery_status' => 'yet_to_deliver',
        ]);
        return response()->json(['message' => 'Delivery Status updated successfully!'], 200);
    }
    public function inventorylist($user_id)
    {   
        $data = DB::table('deliveries')
        ->join('user_order_items','user_order_items.consolidate_order_no','=','deliveries.order_no')
        ->select(DB::raw('sum(user_order_items.quantity) as total_quantity'),'user_order_items.product_name')
        ->groupBy('user_order_items.product_id')
        ->where('deliveries.delivery_man_id',$user_id)
        ->where('deliveries.date',date('Y-m-d'))->get();
        return response()->json($data, 200);
        // $data = DB::table('deliveries')
        //     ->where('delivery_man_id', $user_id)
        //     ->where('delivery_status', '=', 'Packing')
        //     ->select('deliveries.product_details')
        //     ->get();
        // $arr = [];
        // foreach ($data as $k => $v) {
        //     array_push($arr, json_decode($v->product_details));
        // }

        // return response()->json($arr, 200);
    }
    public function UpdateDeliveryStatus($user_id)
    {
        $date = date('Y-m-d');
        
        Delivery::where('delivery_man_id', $user_id)->where('date',$date)->update([
            'delivery_status' => 'yet_to_deliver',
        ]);
        // Delivery::where('delivery_man_id', $user_id)->where('delivery_status', 'Packing')->where('order_no',$order_no)->update([
        //     'delivery_status' => 'yet_to_deliver',
        // ]);

        return response()->json(['message' => 'Delivery Status updated successfully!'], 200);
    }
    public function TotalJobsCompleted($user_id)
    {
        $TotalJobsCompleted = Driver::where('driver_id', $user_id)->first();
        return response()->json($TotalJobsCompleted->order_delivered, 200);
    }
    public function TotalEarning($user_id)
    {
        $TotalEarning = Driver::where('driver_id', $user_id)->first();
        return response()->json($TotalEarning->earning, 200);
    }
    public function TotalWorkingDays($user_id)
    {
        $TotalJobsCompleted = Driver::where('driver_id', $user_id)->first();
        $diff = $TotalJobsCompleted['created_at']->diffForHumans(null, true, true, 2);
        $data =  str_replace(['h', 'm'], ['hrs', 'mins'], $diff);
        return response()->json($data, 200);
    }
    public function monthly_earning($user_id)
    {
        $driver = Driver::where('driver_id', $user_id)->first();
        $orders = Delivery::select(DB::raw("DATE_FORMAT(created_at,'%M %Y') as Months"), (DB::raw('COUNT(CASE delivery_status WHEN "delivered" THEN 1 ELSE NULL END) as Completed_Task')))
            ->groupBy('months')
            ->get();
        $newArr = array();
        foreach ($orders as $item) {
            $newArr[] = ['Months' => $item->Months,'Earning' => $item->Completed_Task * $driver->commission];
        }
        return response()->json($newArr, 200);
    }


    public function get_consolidate_order_no($driver_id){
        $data = DB::table('deliveries')
        ->select('deliveries.order_no','deliveries.delivery_status')
        ->where('date',date('Y-m-d'))
        // ->where('delivery_status','Packing')
        ->where('delivery_man_id',$driver_id)->get();

        return response()->json($data, 200);
    }

    public function get_consolidate_order_details($driver_id,$consolidate_order_no){
        $data = DB::table('deliveries')
        ->join('user_order_items','user_order_items.consolidate_order_no','=','deliveries.order_no')
        ->select(DB::raw('sum(user_order_items.quantity) as total_quantity'),'user_order_items.*','deliveries.delivery_status')
        ->groupBy('user_order_items.product_id')
        ->where('deliveries.delivery_man_id',$driver_id)
        ->where('user_order_items.consolidate_order_no',$consolidate_order_no)
        ->get();
        return response()->json($data, 200);
    }


    public function packed_consolidate_order($driver_id,$consolidate_order_no){
        DB::table('deliveries')->where('delivery_man_id',$driver_id)->where('order_no',$consolidate_order_no)->update([
            'delivery_status' => 'Packed'
        ]);

        DB::table('notifications')->where('consolidate_order_no',$consolidate_order_no)->update([
            'status' => 'Packed'
        ]);
        return response()->json([
            'message' => 'Order Packed Successfully'
        ], 200);
    }


    public function start_delivery($driver_id){
        DB::table('deliveries')->where('delivery_man_id',$driver_id)
        ->where('delivery_status','Packed')
        ->where('date',date('Y-m-d'))
        ->update([
            'delivery_status' => 'yet_to_deliver'
        ]);

        $data =  DB::table('deliveries')->where('delivery_man_id',$driver_id)
        ->where('delivery_status','Packed')
        ->where('date',date('Y-m-d'))->get();

        foreach($data as $item){
            DB::table('notifications')
            ->where('status','Packed')
            ->where('consolidate_order_no',$item->order_no)->update([
                'status' => 'yet_to_deliver'
            ]);
        }

        return response()->json([
            'message' => 'Order yet_to_deliver Successfully'
        ], 200);
    }




    public function complete_delivery(Request $request){
        DB::table('deliveries')->where('delivery_man_id',$request->driver_id)
        ->where('order_no',$request->order_no)->update([
              'delivery_status' => 'delivered',
        ]);

        DB::table('notifications')
        ->where('consolidate_order_no',$request->order_no)->update([
            'status' => 'delivered'
        ]);

        return response()->json([
            'message' => 'Order Deliver Successfully'
        ], 200);

    }




}
