<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\ListOfPostalDistricts;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use App\Models\UserOrderPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class ConsolidateOrderController extends Controller
{
    //
    public function index()
    {

        $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());

        $data = Notification::where('delivery_date', null)->where('end_date', '<', $current_date)->get();

        return response()->json($data);

    }

    // 
    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total   ,$perPage);
    }

    // 
    public function fetchAllConsolidateOrder(Request $request)
    {
        $userData = UserOrder::distinct('order_no')->pluck('order_no');
        $arr = [];
        
        foreach($userData as $data){
            $a = UserOrder::where('order_no', $data)->get();
            array_push($arr, $a[0]);
        }

        $data = $this->paginate($arr, 4);
        $data->withPath($request->url());
        return $data;
    }

    // 
    public function view()
    {

        $data = UserOrder::where('consolidate_order_no', request()->id)->first();

        $delivery_date = Notification::where('consolidate_order_no', request()->id)->first();

        $orders = UserOrder::where('consolidate_order_no', request()->id)->get();

        $userOrderItem = UserOrderItem::where('consolidate_order_no', request()->id)->get();

        $sum = UserOrder::where('consolidate_order_no', request()->id)->sum('final_price');

        $delivery_boy = Driver::all();

        $delivery_data_if_added = Delivery::where('order_no', request()->id)->first();

        $shipping_charge = DB::table('user_orders')->where('consolidate_order_no',request()->id)->sum('ship_charge');

        $status = 0;

        if($delivery_data_if_added != null){
            $status = 1;
        }

        return view('superadmin.consolidate-order.modal.consolidate-order', [
            'data' => $data,
            'orders'=>$orders,
            'delivery_date'=>$delivery_date,
            'delivery_boy'=>$delivery_boy,
            'total_amount'=> $sum,
            'userOrderItem' => $userOrderItem,
            'status' =>$status,
            'delivery' =>$delivery_data_if_added,
            'shipping_charge'   =>$shipping_charge
        ]);

    }


    public function consolidate_Order_list_with_postal_code(){
        $data = UserOrderItem::where('consolidate_order_no', request()->consolidate_order_no)->get();

        
        $new_data = [];

        foreach($data as $item){

            $new_data[] = array(
                $item->order_no,
                '<img src="'.$item->product_image.'" height="100">',
                $item->product_name,
                $item->quantity,
                $item->final_price_with_coupon_offer,
                // $item->final_price_with_coupon_offer,
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

    // 
    public function viewCancelOrderForm()
    {

        $orders = Notification::groupBy('consolidate_order_no')->orderBy('id', 'desc')->get();

        $userOrder = UserOrder::join('notifications','notifications.consolidate_order_no','=','user_orders.consolidate_order_no')->get(['notifications.status as order_status','notifications.delivery_date as order_delivery_date', 'user_orders.*']);

        $ordersItem = UserOrderItem::get();

        return view('superadmin.cancel-orders.modal.index', [
            'orders'=>$orders,
            'userOrder' => $userOrder,
            'ordersItem' => $ordersItem,
        ]);

    }

    // cancel order
    public function CancelOrder(Request $request){

        $status1 = 0;

        if(isset($request->status1)){
            $status1 = $request->status1;
        }

        if($status1 == 1){
            Notification::where('consolidate_order_no', $request->order_no)->update([
                'status' => 'Canceled'
            ]);

            return redirect()->back()->with('success', 'Order Canceled Successfully');

        }else{
            $order_no = $request->consolidate_order_id;
            $status = $request->status;
    
            Notification::where('consolidate_order_no', $order_no)->update([
                'status' => $status
            ]);
        }
        return response()->json(['success' => 'Order Canceled Successfully']);

    }

    // Cancel order list
    public function CancelOrderList(){

        $orders = Notification::where('status','Canceled')->groupBy('consolidate_order_no')->orderBy('id', 'desc')->get();

        $new_data = [];

        foreach($orders as $item){

            $new_data[] = array(
                $item->consolidate_order_no,
                $item->postcode,
                $item->delivery_date,
                $item->remark,
                $item->status,
            );
        }
        
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $orders->count(),
            "recordsFiltered" 	=> $orders->count(),
            "data" 				=> $new_data
        );
        echo json_encode($output);
    }

    // 
    public function fetchAllOrders()
    {
        $data = Order::where('owner_id', $_GET['user_id'])->where('order_number', $_GET['order_no'])->value('products_details');
        
        return response()->json($data);
    }


    
    // =================================================================================
    // Add delivery
    // =================================================================================    
    public function addOnlineSaleDelivery(Request $request)
    {

        try {
            $delivery_man = Driver::where('driver_id',$request->delivery_man_id)->first();

            $order = UserOrder::where('consolidate_order_no', $request->consolidate_order_id)->first();

            $delivery_date = Notification::where('consolidate_order_no', $request->consolidate_order_id)->first();

            $date = explode('/', $delivery_date->delivery_date);

            $uer_orders = UserOrderItem::where('consolidate_order_no', $request->consolidate_order_id)->get();

            $delivery_data_if_added = Delivery::where('order_no', $request->consolidate_order_id)->first();

            if($delivery_data_if_added != null){
                Delivery::where('order_no', $request->consolidate_order_id)->update([
                    "owner_id" => Auth::user()->id,
                    "customer_name" => $order->name,
                    "customer_id" => $order->user_id,
                    "mobile_no" => $order->mobile_no,
                    "date" => implode('-',array_reverse($date)),
                    "delivery_man_user_id" => $delivery_man->id,
                    "delivery_man" => $delivery_man->driver_name,
                    "delivery_man_id" => $delivery_man->driver_id,
                    "delivery_address" => $order->address,
                    "description" => $request->description,
                    "pickup_address" => $request->pickupAddress,
                    "product_details" => $uer_orders,
                    "payment_status" => $request->payment_status,
                    "delivery_status" => $request->delivery_status,
                    "updated_at" => now()
                ]);
            }else{
                Delivery::insert([
                    "owner_id" => Auth::user()->id,
                    "customer_name" => $order->name,
                    "customer_id" => $order->user_id,
                    "order_no" => $request->consolidate_order_id,
                    "mobile_no" => $order->mobile_no,
                    "date" => implode('-',array_reverse($date)),
                    "delivery_man_user_id" => $delivery_man->id,
                    "delivery_man" => $delivery_man->driver_name,
                    "delivery_man_id" => $delivery_man->driver_id,
                    "delivery_address" => $order->address,
                    "description" => $request->description,
                    "pickup_address" => $request->pickupAddress,
                    "product_details" => $uer_orders,
                    "payment_status" => $request->payment_status,
                    "delivery_status" => $request->delivery_status,
                    "created_at" => now()
                ]);
            }

                return response()->json(['success' => 'Delivery Details Updated Successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    // update single driver via order no
    public function addOnlineSaleDelivery1()
    {
        // $delivery_man = Driver::where('driver_id',request()->driver_id)->first();

        // $order = UserOrder::where('consolidate_order_no', request()->order_no)->first();

        // $delivery_date = Notification::where('consolidate_order_no', request()->order_no)->first();

        // $date = explode('/', $delivery_date->delivery_date);

        // $uer_orders = UserOrderItem::where('consolidate_order_no', request()->order_no)->get();
        // // dd($uer_orders);

        // $delivery_data_if_added = Delivery::where('order_no', request()->order_no)->first();
        // // dd($delivery_data_if_added);

        // if($delivery_data_if_added != null){
        //     Delivery::where('order_no', request()->order_no)->update([
        //         "owner_id" => Auth::user()->id,
        //         "customer_name" => $order->name,
        //         "customer_id" => $order->user_id,
        //         "mobile_no" => $order->mobile_no,
        //         "date" => implode('-',array_reverse($date)),
        //         "delivery_man_user_id" => $delivery_man->id,
        //         "delivery_man" => $delivery_man->driver_name,
        //         "delivery_man_id" => $delivery_man->driver_id,
        //         "delivery_address" => $order->address,
        //         // "description" => $request->description,
        //         // "pickup_address" => $request->pickupAddress,
        //         "product_details" => $uer_orders,
        //         // "payment_status" => $request->payment_status,
        //         "delivery_status" => "Packing",
        //         "updated_at" => now()
        //     ]);
        // }else{
        //     Delivery::insert([
        //         "owner_id" => Auth::user()->id,
        //         "customer_name" => $order->name,
        //         "customer_id" => $order->user_id,
        //         "order_no" => request()->order_no,
        //         "mobile_no" => $order->mobile_no,
        //         "date" => implode('-',array_reverse($date)),
        //         "delivery_man_user_id" => $delivery_man->id,
        //         "delivery_man" => $delivery_man->driver_name,
        //         "delivery_man_id" => $delivery_man->driver_id,
        //         "delivery_address" => $order->address,
        //         // "description" => $request->description,
        //         // "pickup_address" => $request->pickupAddress,
        //         "product_details" => $uer_orders,
        //         // "payment_status" => $request->payment_status,
        //         // "delivery_status" => $request->delivery_status,
        //         "delivery_status" => "Packing",
        //         "created_at" => now()
        //     ]);
        // }


        // return request()->order_no;
        try {
            if(!empty(request()->orders_no)){
                foreach(request()->orders_no as $order_no){
                    $delivery_man = Driver::where('driver_id',request()->driver_id)->first();

                    $order = UserOrder::where('consolidate_order_no', $order_no)->first();

                    $delivery_date = Notification::where('consolidate_order_no', $order_no)->first();

                    $date = explode('/', $delivery_date->delivery_date);

                    $uer_orders = UserOrderItem::where('consolidate_order_no', $order_no)->get();
                    // dd($uer_orders);

                    $delivery_data_if_added = Delivery::where('order_no', $order_no)->first();
                    // dd($delivery_data_if_added);

                    if($delivery_data_if_added != null){
                        Delivery::where('order_no', $order_no)->where('delivery_status','!=','delivered')->update([
                            "owner_id"          => Auth::user()->id,
                            "customer_name"     => $order->name,
                            "customer_id"       => $order->user_id,
                            "address_id"        => $delivery_date->address_id,
                            "mobile_no"         => $order->mobile_no,
                            "date"              => implode('-',array_reverse($date)),
                            "delivery_man_user_id" => $delivery_man->id,
                            "delivery_man"      => $delivery_man->driver_name,
                            "delivery_man_id"   => $delivery_man->driver_id,
                            "delivery_address"  => $order->address,
                            "product_details"   => $uer_orders,
                            "payment_status"    => $delivery_date->payment_mode == 'hitpay' ? "Paid" : '',
                            "delivery_status"   => "Packing",
                            "updated_at"        => now()
                        ]);

                        DB::table('notifications')->where('consolidate_order_no',$order_no)->update([
                            'status' => 'Packing'
                        ]);

                    }else{
                        Delivery::insert([
                            "owner_id"          => Auth::user()->id,
                            "customer_name"     => $order->name,
                            "customer_id"       => $order->user_id,
                            "order_no"          => $order_no,
                            "address_id"        => $delivery_date->address_id,
                            "mobile_no"         => $order->mobile_no,
                            "date"              => implode('-',array_reverse($date)),
                            "delivery_man_user_id" => $delivery_man->id,
                            "delivery_man"      => $delivery_man->driver_name,
                            "delivery_man_id"   => $delivery_man->driver_id,
                            "delivery_address"  => $order->address,
                            "product_details"   => $uer_orders,
                            "payment_status"    => $delivery_date->payment_mode == 'hitpay' ? "Paid" : '',
                            "delivery_status"   => "Packing",
                            "created_at"        => now()
                        ]);

                        DB::table('notifications')->where('consolidate_order_no',$order_no)->update([
                            'status' => 'Packing'
                        ]);

                    }
                }
                return response()->json(['success' => 'Delivery Details Updated Successfully']);
            }else{
                return response()->json(['success' => 'Please Select Order']);
            }

               
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }



    public function list_of_postal_districts(){
        $post_code = ListOfPostalDistricts::get();

        $new_data = [];
        foreach($post_code as $item){
            $total_order = 0;
            $total_not_assign_order = 0;
            foreach(explode(',',$item->postal_sector) as $code){ 
                $Notification = Notification::where('postcode','like',$code."%");
                if(!empty(request()->date)){
                    $Notification->where('delivery_date',request()->date);
                }
                $total_order += sizeof($Notification->groupBy('consolidate_order_no')->get());

                $not_assign_order = Notification::where('postcode','like',$code."%");
                if(!empty(request()->date)){
                    $not_assign_order->where('delivery_date',request()->date);
                }
                $not_assign_order = $not_assign_order->groupBy('consolidate_order_no')->get();

                foreach($not_assign_order as $not_assign){
                    $check_in_delivery = DB::table('deliveries')
                    ->where('order_no',$not_assign->consolidate_order_no)->first();
                    $check_driver = DB::table('drivers')->where('id',$check_in_delivery->delivery_man_user_id ?? '')->first();
                    if(empty($check_driver)){
                        $total_not_assign_order +=1;
                    }
                }

            }


            $new_data[] = array(
                '<a target="_blank" href="'.route('get_order_by_post_code',['post_code'=>$item->postal_sector, 'date' => !empty(request()->date) ? request()->date : '']).'">'.$item->postal_district.'</a>',
                '<a target="_blank" href="'.route('get_order_by_post_code',['post_code'=>$item->postal_sector, 'date' => !empty(request()->date) ? request()->date : '']).'">'.$item->postal_sector.'</a>',
                '<a target="_blank" href="'.route('get_order_by_post_code',['post_code'=>$item->postal_sector, 'date' => !empty(request()->date) ? request()->date : '']).'">'.$item->general_location.'</a>',
                '<a target="_blank" href="'.route('get_order_by_post_code',['post_code'=>$item->postal_sector, 'date' => !empty(request()->date) ? request()->date : '']).'">'.$total_order.'</a>',
                $total_not_assign_order
            );
        }
        
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $post_code->count(),
            "recordsFiltered" 	=> $post_code->count(),
            "data" 				=> $new_data
        );
        echo json_encode($output);
    }


    public function get_order_by_post_code(){
        // print_r(request()->all());
        return view('superadmin.consolidate-order.show_order_by_post_code');
    }

    public function list_order_by_post_code(){
        $i = 0;
        $action = '';
        $new_data = [];
        foreach(explode(',',request()->post_code) as $code){
            // $data = DB::table('user_orders')
            //         ->join('notifications', 'notifications.consolidate_order_no', '=', 'user_orders.consolidate_order_no')
            //         ->join('user_order_payments', 'user_order_payments.id', '=', 'user_orders.payment_id')
            //         // ->leftJoin('users', 'users.id','=','user_orders.user_id')
            //         ->where('notifications.postcode','like',$code."%");
            //         if(!empty(request()->date))
            //             $data->where('notifications.delivery_date',request()->date);
            //         $data = $data->groupBy('notifications.consolidate_order_no')
            //         ->orderBy('user_orders.id', 'desc')
            //         ->get([ 'user_orders.name as recipient_name','user_orders.*','user_orders.user_id as main_user_id','user_order_payments.*','notifications.*']);

                $data = DB::table('notifications')
                    ->where('notifications.postcode','like',$code."%");
                    if(!empty(request()->date))
                        $data->where('notifications.delivery_date',request()->date);
                $data = $data->groupBy('notifications.consolidate_order_no')->get();
        
                foreach($data as $item){

                    $total_order_price = DB::table('user_orders')
                    ->where('consolidate_order_no', $item->consolidate_order_no)
                    ->sum('final_price');

                    $action .= '<a name="viewConsolidateOrder1" class="btn btn-primary"  data-toggle="modal" data-id="'.$item->consolidate_order_no.'"  data-target="#viewConsolidateOrder"> View </a>';

                    $check_assign_driver = DB::table('deliveries')
                    ->where('order_no',$item->consolidate_order_no)
                    ->first();

                    $driver_name = DB::table('drivers')
                    ->where('driver_id',$check_assign_driver->delivery_man_id ?? '')
                    ->where('id',$check_assign_driver->delivery_man_user_id ?? '')->first();

                    $user = User::find($item->user_id);


                    // check delivery status
                    $check_delivery_status = DB::table('deliveries')->where('order_no',$item->consolidate_order_no)->first();

                    $address = DB::table('addresses')->where('id',$item->address_id)->first();

                    $user_order = DB::table('user_orders')->where('consolidate_order_no',$item->consolidate_order_no)->first();
                    $user_order_payments = DB::table('user_order_payments')->where('id', $user_order->payment_id)->first();

                    $new_data[] = array(
                        $item->consolidate_order_no,
                        substr($item->consolidate_order_no,-5),
                        $user ? $user->name : '--',    /// $item->customer_name,
                        $address->name,
                        $address->address,
                        $address->mobile_number,
                        $user_order_payments->payment_type,
                        $total_order_price,
                        $user_order_payments->payment_type == "COD" ? $total_order_price : "PAID",
                        $item->delivery_date!=null?'<span class="hidden">'.implode(array_reverse(explode('/',$item->delivery_date))).'</span>'.$item->delivery_date:"--",
                        $driver_name ? $driver_name->driver_name : '--',
                        $check_delivery_status ? $check_delivery_status->delivery_status : '--',
                        $action,
                        $check_delivery_status ? ($check_delivery_status->delivery_status == 'delivered' ? true : false) : false,  //it for hide check box if order assign
                    );
                    $action = '';
                }
            }
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $data->count(),
            "recordsFiltered" 	=> $data->count(),
            "data" 				=> $new_data
         );
        echo json_encode($output);

    }


    public function get_all_driver(){
        $drivers = Driver::orderBy('id', 'desc')->get();
        $data = array();
        $date = date('Y-m-d', strtotime(str_replace('/', '-', request()->date)));
        foreach($drivers as $driver){
            $total_order = DB::table('deliveries');
            $total_order = $total_order->where('delivery_man_user_id',$driver->id);
            if(!empty(request()->date))
                $total_order->where('date',$date);
           $total_order = $total_order->count('*');
            $data[]=[
                'driver_name'   => $driver->driver_name,
                'driver_id'     => $driver->driver_id,
                'total_order'   => $total_order,
            ];
        }
        
        echo json_encode($data);
    }



}
