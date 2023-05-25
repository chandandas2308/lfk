<?php

namespace App\Http\Controllers\DeliveryAPI;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\CancelRemark;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\DriverCommissionHistory;
use App\Models\Notification;
use App\Models\OrderRoutes;
use App\Models\Remark;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryTaskController extends Controller
{
    public function index($user_id)
    {
        $delivery = Delivery::join('notifications','notifications.consolidate_order_no','=','deliveries.order_no')
        ->join('user_orders','user_orders.consolidate_order_no','=','notifications.consolidate_order_no')
        ->select('deliveries.*','notifications.payment_mode','user_orders.final_price')
        ->where('deliveries.delivery_man_id', $user_id)
        ->where('deliveries.date',date('Y-m-d'))
        ->groupBy('notifications.consolidate_order_no')
        ->get();
        return response()->json($delivery, 200);
    }

    public function singleDeliveryRoute($driver_id){
            $delivery_date = date('d/m/Y');
            $line = OrderRoutes::where('driver_id',$driver_id)
            ->where('delivery_date',$delivery_date)->get();
            return response()->json($line, 200);
    }


    public function singleDeliveryTasks($user_id, $id)
    {
        $delivery = Delivery::join('notifications','notifications.consolidate_order_no','=','deliveries.order_no')
        ->join('user_orders','user_orders.consolidate_order_no','=','notifications.consolidate_order_no')
        ->select('deliveries.*','notifications.remark as customer_remark','notifications.payment_mode','user_orders.final_price')
        ->where('deliveries.delivery_man_id', $user_id)
        ->where('deliveries.id', $id)
        ->first();
        if ($delivery == null) {
            return response()->json(['Data is not available'], 200);
        }

        $product_details = DB::table('user_order_items')
        ->select('product_name',DB::raw('SUM(quantity) as total_quantity'))
        ->groupBy('product_id')
        ->where('consolidate_order_no',$delivery->order_no)
        ->get();

        return response()->json([
            'delivery_details'  => $delivery,
            'product_details'   => $product_details
        ], 200);
        // $response = \GoogleMaps::load('geocoding')
        //     ->setParam(['address' => $delivery->pickup_address])
        //     ->get();
        // $json = json_decode($delivery->pickup_address);
        // $pickup_address_lat ='';
        // $pickup_address_lng = '';
        // if(!empty($json->result)){
        //     $pickup_address_lat = $json->results[0]->geometry->location->lat;
        //     $pickup_address_lng = $json->results[0]->geometry->location->lng;
        // }
        // $response = \GoogleMaps::load('geocoding')
        //     ->setParam(['address' => $delivery->delivery_address])
        //     ->get();
        // $json = json_decode($response);
        // $delivery_address_lat = '';
        // $delivery_address_lng = '';
        // if(!empty($json->result)){
        //     $delivery_address_lat = $json->results[0]->geometry->location->lat;
        //     $delivery_address_lng = $json->results[0]->geometry->location->lng;
        // }

        // return response()->json([$delivery, 'Pickup Address Latitude ' . '' . $pickup_address_lat, 'Pickup Address Longitude ' . '' . $pickup_address_lng, 'Delivery Address Latitude ' . '' . $delivery_address_lat, 'Delivery Address Longitude ' . '' . $delivery_address_lng], 200);
    }

    public function AllPendingTasks($user_id)
    {
        $delivery = Delivery::where('delivery_man_id', $user_id)
        ->where('date',date('Y-m-d'))
        ->where('delivery_status', 'yet_to_deliver')->get();
        return response()->json($delivery, 200);
    }

    public function singlePendingDeliveryTasks($user_id, $id)
    {
        $delivery = Delivery::where('delivery_man_id', $user_id)->where('id', $id)->where('delivery_status', 'yet_to_deliver')->first();
        if ($delivery == null) {
            return response()->json(['Data is not available'], 200);
        }
        $response = \GoogleMaps::load('geocoding')
            ->setParam(['address' => $delivery->pickup_address])
            ->get();
        $json = json_decode($response);
        $pickup_address_lat ='';
        $pickup_address_lng = '';
        if(!empty($json->result)){
            $pickup_address_lat = $json->results[0]->geometry->location->lat;
            $pickup_address_lng = $json->results[0]->geometry->location->lng;
        }
        $response = \GoogleMaps::load('geocoding')
            ->setParam(['address' => $delivery->delivery_address])
            ->get();
        $json = json_decode($response);
        $delivery_address_lat = '';
        $delivery_address_lng = '';
        if(!empty($json->result)){
            $delivery_address_lat = $json->results[0]->geometry->location->lat;
            $delivery_address_lng = $json->results[0]->geometry->location->lng;
        }

        return response()->json([$delivery, 'Pickup Address Latitude ' . '' . $pickup_address_lat, 'Pickup Address Longitude ' . '' . $pickup_address_lng, 'Delivery Address Latitude ' . '' . $delivery_address_lat, 'Delivery Address Longitude ' . '' . $delivery_address_lng], 200);

    }

    public function allCompletedTasks($user_id)
    {
        $delivery = Delivery::where('delivery_man_id', $user_id)
        ->where('date',date('Y-m-d'))
        ->where('delivery_status', 'delivered')->get();
        return response()->json([$delivery], 200);
    }
    public function singleCompletedTasks($user_id, $id)
    {
        $delivery = Delivery::where('delivery_man_id', $user_id)->where('delivery_status', 'delivered')->where('id', $id)->first();
        if ($delivery == null) {
            return response()->json(['Data is not available'], 200);
        }
        $response = \GoogleMaps::load('geocoding')
            ->setParam(['address' => $delivery->pickup_address])
            ->get();
        $json = json_decode($response);

        $pickup_address_lat ='';
        $pickup_address_lng = '';
        if(!empty($json->result)){
            $pickup_address_lat = $json->results[0]->geometry->location->lat;
            $pickup_address_lng = $json->results[0]->geometry->location->lng;
        }
        $response = \GoogleMaps::load('geocoding')
            ->setParam(['address' => $delivery->delivery_address])
            ->get();
        $json = json_decode($response);
        $delivery_address_lat = '';
        $delivery_address_lng = '';
        if(!empty($json->result)){
            $delivery_address_lat = $json->results[0]->geometry->location->lat;
            $delivery_address_lng = $json->results[0]->geometry->location->lng;
        }

        return response()->json([$delivery, 'Pickup Address Latitude ' . '' . $pickup_address_lat, 'Pickup Address Longitude ' . '' . $pickup_address_lng, 'Delivery Address Latitude ' . '' . $delivery_address_lat, 'Delivery Address Longitude ' . '' . $delivery_address_lng], 200);
    }
    public function todayTasks($user_id)
    {
        $delivery = Delivery::where('delivery_man_id', $user_id)->where('delivery_status', 'yet_to_deliver')->where('created_at', '>=', Carbon::today())->get();
        if ($delivery == null) {
            return response()->json(['Data is not available'], 200);
        }
        return response()->json([$delivery], 200);
    }
    public function customerSignature(Request $request, $order_no,$driver_id)
    {
        $url = env("APP_URL", "https://lfk.sg");
        if (!file_exists('Signature')) {
            mkdir('Signature', 777, true);
        }

        $data = DB::table('deliveries')->where('id',$request->order_no)->first();

        $image_resize = Image::make($request->signature->getRealPath());
        $image_resize->save(public_path('Signature/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->signature->extension(), 100));
        $path = 'Signature/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->signature->extension();
        $imagepath = $path;
        // Delivery::where('order_no', $order_no)->update([
        Delivery::where('id', $order_no)->update([
            // 'delivery_status' => 'delivered',
            'payment_status' => 'Paid',
            'signature' =>  $url . $imagepath,
        ]);

        $driver = Driver::where('driver_id',$driver_id)->first();
        Driver::where('driver_id',$driver_id)->update([
            'earning' => $driver->earning + $driver->commission,
            'order_delivered' => $driver->order_delivered + 1
        ]);
        return response()->json(['message' => 'Signature uploaded successfully!'], 200);
    }
    // add image and remakes
    public function addRemark(Request $request)
    {
        $url = env("APP_URL", "https://lfk.sg");
        if (!file_exists('Remark')) {
            mkdir('Remark', 777, true);
        }

        $data = DB::table('deliveries')->where('id',$request->order_no)->first();
        $imagepath = '';
        if(!empty($request->image)){
            $image_resize = Image::make($request->image->getRealPath());
            $image_resize->save(public_path('Remark/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));
            $path = 'Remark/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->image->extension();
            $imagepath = $path;
        }

        

        Remark::create([
            'deliveries_id' => $request->order_no,
            'order_no'      => $data->order_no,
            'driver_id'     => $request->driver_id,
            'remark'        => $request->remark,
            'image'         =>  !empty($imagepath) ? $url . $imagepath : '',
        ]);

        
        return response()->json(['message' => 'Remark uploaded successfully!'], 200);
    }




    // new function

    public function task($date){
        $data = DB::table('deliveries')->where('date');
    }


    // inventory list 
    public function inventory_list($driver_id, $date){
        // $date = implode('/',array_reverse(explode('-',$date)));
        $data = DB::table('deliveries')->join('user_order_items','user_order_items.consolidate_order_no','=','deliveries.order_no')
        ->select('user_order_items.product_image','user_order_items.product_name',DB::raw('SUM(user_order_items.quantity) as total_quantity'),'deliveries.date')
        ->where('deliveries.date',$date)
        ->where('deliveries.delivery_man_id',$driver_id)
        ->groupBy('user_order_items.consolidate_order_no')->get();

        return response()->json($data,200);
    }

    public function consolidate_order_list($driver_id, $date){
        $data = DB::table('deliveries')->join('notifications','notifications.consolidate_order_no','=','deliveries.order_no')
        ->select('notifications.consolidate_order_no','deliveries.delivery_status')
        ->where('deliveries.date',$date)
        ->where('deliveries.delivery_man_id',$driver_id)
        ->groupBy('notifications.consolidate_order_no')->get();

        return response()->json($data,200);
    }

    public function get_consolidate_order_item_details($consolidate_order_no){
        $data = DB::table('user_order_items')->join('deliveries','deliveries.order_no','=','user_order_items.consolidate_order_no')
        ->select('user_order_items.product_image','user_order_items.product_name',DB::raw('SUM(user_order_items.quantity) as total_quantity'),'deliveries.delivery_status')
        ->where('consolidate_order_no',$consolidate_order_no)
        ->groupBy('consolidate_order_no')
        ->get();

        return response()->json($data,200);
    }

    public function change_consolidate_order_item_status_to_packed(){
        $consolidate_order_no = request()->consolidate_order_no;
         DB::table('notifications')->where('consolidate_order_no',$consolidate_order_no)->update([
            'status' => 'Packed'
        ]);

        DB::table('deliveries')->where('order_no',$consolidate_order_no)->update([
            'delivery_status' => 'Packed'
        ]);


        return response()->json('Item Packed Successfully',200);
    }


    public function change_all_consolidate_order_to_yet_to_deliver(){
        $driver_id = request()->driver_id;
        $date = request()->date;
        $data = DB::table('deliveries')->where('delivery_man_id',$driver_id)
        ->where('delivery_status','Packed')
        ->where('date',$date)
        ->get();
        foreach($data as $item){
            DB::table('notifications')->where('consolidate_order_no',$item->order_no)
            ->where('status','Packed')
            ->update([
                'status' => 'yet_to_deliver'
            ]);

            DB::table('deliveries')->where('delivery_man_id',$driver_id)
            ->where('order_no',$item->order_no)
            ->where('date',$date)
            ->where('delivery_status','Packed')->update([
                'delivery_status' => 'yet_to_deliver'
            ]);
        }
    }

    
    public function all_consolidate_order_list($driver_id, $date, $option){
        $data = DB::table('deliveries')
        ->join('notifications','notifications.consolidate_order_no','=','deliveries.order_no')
        // ->join('user_orders','user_orders.consolidate_order_no','=','deliveries.order_no')
        // ->select('notifications.consolidate_order_no','deliveries.delivery_status',DB::raw('SUM(user_orders.final_price) as final_price'),'notifications.payment_mode','deliveries.date')
        ->select('notifications.consolidate_order_no','deliveries.delivery_status','notifications.payment_mode','deliveries.date')
        ->where('deliveries.date',$date)
        ->where('deliveries.delivery_man_id',$driver_id);
        if($option == 'Pending'){
            $data = $data->whereIn('deliveries.delivery_status',['yet_to_deliver','Packing','Packed']);
        }else if($option == 'Complete'){
            $data = $data->where('deliveries.delivery_status','Delivered');
        }else{
            $data = $data->whereIn('deliveries.delivery_status',['Packing','Packed','yet_to_deliver','Delivered','Cancelled']);
        }
        $data = $data->groupBy('notifications.consolidate_order_no')
        ->get();

        $new_data = [];
        foreach($data as $item){
            $final_price = DB::table('user_orders')
            ->where('consolidate_order_no',$item->consolidate_order_no)
            ->groupBy('consolidate_order_no')->sum('final_price');
            $new_data[]=[
                'consolidate_order_no'  => $item->consolidate_order_no,
                'delivery_status'       => $item->delivery_status,
                'final_price'           => number_format($final_price,2),
                'payment_mode'          => $item->payment_mode,
                'date'                  => $item->date
            ]; 
        }

        return response()->json($new_data,200);
    }


    public function get_consolidate_order_details($consolidate_order_no){
        // $order_details = DB::table('deliveries')
        // ->join('notifications','notifications.consolidate_order_no','=','deliveries.order_no')
        // ->join('user_orders','user_orders.consolidate_order_no','=','deliveries.order_no')
        // ->join('user_order_items','user_order_items.consolidate_order_no','=','deliveries.order_no')
        // ->select('user_orders.*',DB::raw('SUM(user_orders.final_price) as total_final_price'),'notifications.payment_mode',DB::raw('SUM(user_order_items.quantity) as total_quantity'),DB::raw('SUM(user_order_items.final_price_with_coupon_offer) as total_sub_total'),DB::raw('SUM(user_orders.ship_charge) as total_shipping_charge'))
        // ->where('deliveries.order_no',$consolidate_order_no)
        // ->groupBy('user_order_items.consolidate_order_no')
        // ->get();

        $consolidate = DB::table('deliveries')->where('order_no',$consolidate_order_no)->first();
        $order_details = [];
        $product_details = [];

        if($consolidate){
            $notification = DB::table('notifications')->where('consolidate_order_no',$consolidate_order_no)->latest()->first();
            $final_price =  DB::table('user_orders')
            ->where('consolidate_order_no',$consolidate_order_no)
            ->groupBy('consolidate_order_no')->sum('final_price');

            $shipping_charge =  DB::table('user_orders')
            ->where('consolidate_order_no',$consolidate_order_no)
            ->groupBy('consolidate_order_no')->sum('ship_charge');

            $sub_total =  DB::table('user_order_items')
            ->where('consolidate_order_no',$consolidate_order_no)
            ->groupBy('consolidate_order_no')->sum('final_price_with_coupon_offer');

            $total_quantity =  DB::table('user_order_items')
            ->where('consolidate_order_no',$consolidate_order_no)
            ->groupBy('consolidate_order_no')->sum('quantity');

            $address = DB::table('user_orders')
            ->where('consolidate_order_no',$consolidate_order_no)
            ->groupBy('consolidate_order_no')->first();

            
            $product_details = DB::table('user_order_items')
            ->select('product_name','product_image','quantity')
            ->where('consolidate_order_no',$consolidate_order_no)
            ->groupBy('consolidate_order_no')->get();


            $order_details = [
                'consolidate_order_no'  => $consolidate->order_no,
                'final_price'           => $final_price,
                'shipping_charge'       => $shipping_charge,
                'sub_total'             => $sub_total,
                'total_quantity'        => $total_quantity,
                'address'               => $address->address,
                'mobile_no'             => $address->mobile_no,
                'name'                  => $address->name,
                'postcode'              => $address->postcode,
                'payment_mode'          => $notification->payment_mode,
                'delivery_id'           => $consolidate->id,
                'status'                => $consolidate->delivery_status
            ];
        }

        $check_location = DB::table('order_routes')->where('consolidate_order_no',$consolidate_order_no)->first();
        $lat = '';
        $lng = '';
        if($check_location){
            $lat = $check_location->lat;
            $lng = $check_location->lng;
        }

        return response()->json([
            'order_details'     => $order_details,
            'product_details'   => $product_details,
            'lat'               => $lat,
            'lng'               => $lng
        ],200);

    }




    public function save_signature(Request $request){

        $url = env("APP_URL", "https://lfk.sg");
        if (!file_exists('Signature')) {
            mkdir('Signature', 777, true);
        }

        $data = DB::table('deliveries')->where('order_no',$request->consolidate_order_no)->first();

        $image_resize = Image::make($request->signature->getRealPath());
        $image_resize->save(public_path('Signature/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->signature->extension(), 100));
        $path = 'Signature/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->signature->extension();
        $imagepath = $path;
        Delivery::where('order_no', $data->order_no)->update([
            'signature'     =>  $url . $imagepath,
        ]);

        
        return response()->json(['message' => 'Signature uploaded successfully!'], 200);


    }

    public function check_signature($consolidate_order_no){
        $data = DB::table('deliveries')
        ->select('deliveries.signature')
        ->where('order_no',$consolidate_order_no)->first();
        return response()->json($data, 200);
    }



    public function complete_order_delivery(Request $request){
        $consolidate_order_no = $request->consolidate_order_no;
        $date = $request->date;
        $driver_id = $request->driver_id;
        $delivery_id = $request->delivery_id;


        $driver = Driver::where('driver_id',$driver_id)->first();

        Driver::where('driver_id',$driver_id)->update([
            'earning'           => $driver->earning + $driver->commission,
            'order_delivered'   => $driver->order_delivered + 1
        ]);

        DriverCommissionHistory::create([
            'user_table_id'         => $driver->driver_id,
            'driver_table_id'       => $driver->id,
            'consolidate_order_no'  => $consolidate_order_no,
            'delivery_date'         => $date,    
            'commission'            => $driver->commission,
        ]);


        $url = env("APP_URL", "https://lfk.sg");
        if (!file_exists('Remark')) {
            mkdir('Remark', 777, true);
        }

        $data = DB::table('deliveries')->where('order_no',$request->consolidate_order_no)->first();
        $imagepath = '';
        if(!empty($request->image)){
            $image_resize = Image::make($request->image->getRealPath());
            $image_resize->save(public_path('Remark/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));
            $path = 'Remark/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->image->extension();
            $imagepath = $path;
        }


        Remark::create([
            'deliveries_id'     => $delivery_id,
            'order_no'          => $consolidate_order_no,
            'driver_id'         => $driver_id,
            'remark'            => $request->remark,
            'image'             => !empty($imagepath) ? $url.$imagepath : '',
        ]);


       


        Notification::where('consolidate_order_no',$consolidate_order_no)
        ->update([
            'status'                => 'Delivered',
            'delivered_date_time'   => now(),
            'delivered_payment_method' => $request->cash == 'true' ? 'cash' : 'online payment'
        ]);
        

        if (!file_exists('delivery_online_payment')) {
            mkdir('delivery_online_payment', 777, true);
        }
        $online_pay = '';
       
        if(!empty($request->online_payment)){
            $image_resize = Image::make($request->online_payment->getRealPath());
            $image_resize->save(public_path('delivery_online_payment/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->online_payment->extension(), 100));
            $path = 'delivery_online_payment/' . $data->order_no . date('d_m_y_h') . time() . "." .  $request->online_payment->extension();
            $online_pay = $path;
        }
        

        DB::table('deliveries')
        ->where('order_no',$consolidate_order_no)
        ->where('delivery_man_id',$driver_id)
        ->update([
            'delivery_status'       => 'Delivered',
            'delivered_date_time'   => now(),
            'delivered_payment_method'  => $request->cash == 'true' ? 'cash' : 'online payment',
            'delivered_online_payment_image' => !empty($online_pay) ? $url.$online_pay : '',
            'payment_status'        => 'Paid'
        ]);


        return response()->json(['message' => 'Order Complete Successfully'], 200);


    }


    public function check_order_complete($consolidate_order_no){
        $signature = DB::table('deliveries')
        ->select('delivered_date_time','signature','delivery_status')
        ->where('order_no',$consolidate_order_no)->first();

        $remark = Remark::where('order_no',$consolidate_order_no)->latest()->first();

        $signature_data = [
            'delivered_date_time'   => !empty($signature->delivered_date_time) ? date('d-m-Y h:i',strtotime($signature->delivered_date_time)) : '',
            'signature'             => $signature->signature ?? '',
            'delivery_status'       => $signature->delivery_status ?? ''
        ];

        return response()->json([
            'signature' => $signature_data,
            'remark'    => $remark
        ], 200);

    }



    public function cancel_order(Request $request){
        $driver_id = $request->driver_id;
        $date = $request->date;
        $consolidate_order_no = $request->consolidate_order_no;
        $remark = $request->remark;

        $url = env("APP_URL", "https://lfk.sg");
        if (!file_exists('cancel_image')) {
            mkdir('cancel_image', 777, true);
        }

        $image_path = '';
        if(!empty($request->cancel_image)){
            $image_resize = Image::make($request->cancel_image->getRealPath());
            $image_resize->save(public_path('cancel_image/' . $consolidate_order_no . date('d_m_y_h') . time() . "." .  $request->cancel_image->extension(), 100));
            $path = 'cancel_image/' . $consolidate_order_no . date('d_m_y_h') . time() . "." .  $request->cancel_image->extension();
            $image_path = $path;
        }


        Notification::where('consolidate_order_no',$consolidate_order_no)
        ->update([
            'status'                => 'Cancelled',
        ]);
        

        DB::table('deliveries')
        ->where('order_no',$consolidate_order_no)
        ->where('delivery_man_id',$driver_id)
        ->update([
            'delivery_status'       => 'Cancelled',
        ]);

        $driver_details = Driver::where('driver_id',$driver_id)->first();
        CancelRemark::create([
            'driver_table_id'       => $driver_details->id,
            'driver_user_table_id'  =>$driver_details->driver_id,
            'consolidate_order_no'  => $consolidate_order_no,
            'remark'                => $remark,
            'cancel_image'          => $url.$image_path,
        ]);


        return response()->json(['message' => 'Order Cancel'], 200);

    }


    public function show_routes($driver_id,$date){
        $data = DB::table('deliveries')
        ->join('order_routes','order_routes.consolidate_order_no','=','deliveries.order_no')
        ->select('order_routes.*')
        ->where('deliveries.delivery_man_id',$driver_id)
        ->where('date',$date)->whereIn('deliveries.delivery_status',['Delivered','yet_to_deliver'])->get();

        return response()->json($data, 200);
    }


    public function get_earning_details($driver_id,$date){

        $time=strtotime($date);
        $month=date("m",$time);
        $year=date("Y",$time);

    

        $total_earning = DriverCommissionHistory::where('user_table_id',$driver_id)
        ->whereMonth('delivery_date',$month)
        ->whereYear('delivery_date',$year)
        ->sum('commission');

        $driver_commission = DriverCommissionHistory::where('user_table_id',$driver_id)
        ->whereMonth('delivery_date',$month)
        ->whereYear('delivery_date',$year)
        ->get();

        $earning_details = Driver::where('driver_id', $driver_id)
        ->whereMonth('created_at',$month)
        ->whereYear('created_at',$year)
        ->first();

        // $diff = $earning_details->created_at->diffForHumans(null, true, true, 2);
        // $data =  str_replace(['h', 'm'], ['hrs', 'mins'], $diff);

        return response()->json([
            'total_order_deliver'       => $earning_details->order_delivered ?? 0,
            'total_earning'             => $total_earning,
            // 'total_time'                => $data,
            'month_year'                => date('F',$time).' '.date('Y',$time),
            'driver_commission_history' => $driver_commission,
            
        ], 200);
    }


    // public function TotalJobsCompleted($user_id)
    // {
    //     $TotalJobsCompleted = Driver::where('driver_id', $user_id)->first();
    //     return response()->json($TotalJobsCompleted->order_delivered, 200);
    // }
    // public function TotalEarning($user_id)
    // {
    //     $TotalEarning = Driver::where('driver_id', $user_id)->first();
    //     return response()->json($TotalEarning->earning, 200);
    // }
    // public function TotalWorkingDays($user_id)
    // {
    //     $TotalJobsCompleted = Driver::where('driver_id', $user_id)->first();
    //     $diff = $TotalJobsCompleted['created_at']->diffForHumans(null, true, true, 2);
    //     $data =  str_replace(['h', 'm'], ['hrs', 'mins'], $diff);
    //     return response()->json($data, 200);
    // }


    public function download_excel_file(Request $request){
        $driver_id = $request->driver_id;
        $date = !empty($request->date) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->date))) : '';
        $driver = DB::table('drivers')->where('driver_id',$driver_id)->first();
        return Excel::download(new UsersExport($driver->id, $request->date), $driver->driver_name.$date.'.xlsx');
       
    }


}
