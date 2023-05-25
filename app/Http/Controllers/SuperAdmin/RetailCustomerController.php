<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Delivery;
use App\Models\Driver;
use App\Models\Notification;
use App\Models\Order;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Models\address;
use App\Models\product;
use App\Models\UserOrderPayment;
use Maatwebsite\Excel\Facades\Excel;

class RetailCustomerController extends Controller
{
    //
    public function retailCustomer()
    {
        $data = DB::table('customers')->where('customer_type', 'retail')->orderBy('id', 'desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach ($data as $item) {
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewCustomer" data-toggle="modal" data-target="#viewRetailCustomerDetails" class="dropdown-item" href="#" data-id="' . $item->customer_id . '">View</a>';
            $action .= '<a class="dropdown-item" href="' . route('retail_customer_order.show', $item->customer_id) . '" >Add Order</a>';
            // $action .= '<a name="addRCustomerOrder" data-toggle="modal" data-target="#addRetailCustomerOrderDetails" class="dropdown-item" href="#" data-id="'.$item->customer_id.'">Add Order</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->customer_name,
                $item->phone_number ?? '--',
                $item->email_id ?? '--',
                $item->postal_code ?? '--',
                $item->address ?? '--',
                $item->unit_number ?? '--',
                $action
            );
            $action = '';
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => sizeOf($data),
            "recordsFiltered"     => sizeOf($data),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }

    // single retail customer details
    public function singleRetailCustomer()
    {
        $customer = Customer::all()->where('customer_id', $_GET['id']);
        $customer1 = Customer::where('customer_id', $_GET['id'])->first();

        $user = DB::table('users')->where('email', $customer1->email_id)->first();

        $points = DB::table('loyalty_pointshops')->where('user_id', $user->id)->first();

        if ($points == null) {
            $have_points = 0;
        } else {
            $have_points = $points->loyalty_points;
        }

        return response()->json([
            "points" => $have_points,
            "customer" => $customer
        ]);
    }

    // All User Item
    public function fetchRetailCustomerWiseProduct()
    {
        $data = DB::table('user_orders')
            ->join('notifications', 'notifications.consolidate_order_no', '=', 'user_orders.consolidate_order_no')
            ->join('user_order_payments', 'user_order_payments.id', '=', 'user_orders.payment_id')
            ->leftJoin('deliveries', 'deliveries.order_no', '=', 'user_orders.consolidate_order_no')
            ->where('user_orders.user_id', $_GET['id'])
            ->groupBy('notifications.consolidate_order_no')
            ->get([
                'notifications.*',
                'notifications.status as order_status',
                'user_order_payments.*',
                'user_orders.*',
                'deliveries.delivery_status'
            ]);

        $new_data = array();

        $i = 0;

        $action = '';

        foreach ($data as $item) {

            // dd($item->order_status);

            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewOrderDetails" id="viewOrderDetails" class="dropdown-item viewOrderDetails' . $i . '" data-id="' . $item->consolidate_order_no . '" >View</a>';
            if ($item->order_status == "Canceled") {
                $action .= '<a class="dropdown-item" href="javascript:void(0)">Canceled</a>';
            } else {
                $action .= '<form method="POST" action="' . route("SA-CancelOrder") . '">';
                $action .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
                $action .= '<input type="hidden" name="status1" value="1">';
                $action .= '<input type="hidden" name="order_no" value="' . $item->consolidate_order_no . '">';
                $action .= '<button type="submit" class="dropdown-item" >Cancel Order</button>';
                $action .= '</form>';
            }

            $action .= '<a class="dropdown-item" href="' . route("retail_customer_order.edit", $item->consolidate_order_no) . '" >Edit</a>';
            $action .= '<a href="' . url('/') . '/admin/retail_customer_order/delete/' . $item->consolidate_order_no . '" class="dropdown-item" >Delete</a>';
            // $action .= '<a class="dropdown-item" href="'.route("retail_customer_order.edit", $item->consolidate_order_no).'" >Cancel Order</a>';

            $action .= '</div>';
            $action .= '</div>';

            $final_price = UserOrderItem::where('consolidate_order_no', $item->consolidate_order_no)->sum('total_price');

            $new_data[] = array(
                ++$i,
                $item->consolidate_order_no,
                $item->name,
                $item->buyer_phone,
                $item->payment_type,
                '$' . $final_price,
                $item->delivery_date != null ? $item->delivery_date : "--",
                $item->delivery_status != null ? $item->delivery_status : ($item->delivery_status != '' ? $item->delivery_status : "Pending"),
                $action,
            );

            $action = '';
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );

        echo json_encode($output);
    }

    // fetch all order details
    public function fetchRetailCustomerWiseProductDetails()
    {
        $user_order = UserOrderItem::where('consolidate_order_no', request()->id)->get();
        return response()->json($user_order);
    }

    // Retail customer orders
    public function retailCustomerOrders()
    {

        $data = DB::table('notifications')
        ->groupBy('consolidate_order_no')
        ->orderBy('id','desc')->get();

        $new_data = [];
        foreach($data as $key => $item){
            $action = "";
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
          
            $action .= '<a class="dropdown-item" target="_blank" href="generate-online-sale-invoice-pdf/' . $item->consolidate_order_no . '">View</a>';
            $action .= '<a name="edit_online_sale_btn" class="dropdown-item" href="#" data-consolidate_order_no="'.$item->consolidate_order_no.'">Edit</a>';
            // $action .= '<a name="deletedriver" data-toggle="modal" data-target="#removeModalSalesdriver" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $user_order = UserOrder::where('consolidate_order_no',$item->consolidate_order_no)->first();
            $remark = DB::table('notifications')
            ->where('consolidate_order_no',$item->consolidate_order_no)
            ->orderBy('id','desc')->first();

            $total_amount = UserOrder::where('consolidate_order_no',$item->consolidate_order_no)
            ->groupBy('consolidate_order_no')
            ->sum('final_price');
            
            $new_data[] = [
                ++$key,
                $item->consolidate_order_no,
                $user_order->name,
                $user_order->mobile_no,
                $item->payment_mode,
                $remark ? $remark->remark : '--',
                '$'.number_format($total_amount,2),
                $item->delivery_date,
                $action
            ];
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);exit;


        $data = DB::table('user_orders')
            ->join('notifications', 'notifications.consolidate_order_no', '=', 'user_orders.consolidate_order_no')
            ->join('user_order_payments', 'user_order_payments.id', '=', 'user_orders.payment_id')
            ->join('users', 'users.id', '=', 'user_orders.user_id')
            ->groupBy('notifications.consolidate_order_no')
            ->orderBy('user_orders.id', 'desc')
            ->get(['users.name as customer_name', 'user_orders.name as recipient_name','user_orders.id as user_orders_id', 'user_orders.*', 'user_order_payments.*', 'notifications.*']);

            foreach ($data as $item) {

                $voucher = DB::table('voucher_histories')->where('consolidate_order_no', $item->consolidate_order_no)->first();

                $sum = DB::table('user_orders')->where('consolidate_order_no', $item->consolidate_order_no)->sum('final_price');

                if ($voucher != null) {
                    $total_amount = $sum - (int)$voucher->discount_amount;
                } else {
                    $total_amount = $sum;
                }

                // add latests remark
                $remark = DB::table('notifications')->where('consolidate_order_no', $item->consolidate_order_no)->orderBy('id', 'desc')->first();

                $action = "";
                $action .= '<div class="dropdown">';
                $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                $action .= '</a>';
                $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
              
                $action .= '<a class="dropdown-item" target="_blank" href="generate-online-sale-invoice-pdf/' . $item->consolidate_order_no . '">View</a>';
                $action .= '<a name="edit_online_sale_btn" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                $action .= '<a name="deletedriver" data-toggle="modal" data-target="#removeModalSalesdriver" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                $action .= '</div>';
                $action .= '</div>';
    


                $new_data[] = array(
                    ++$i,
                    $item->consolidate_order_no,
                    $item->name,
                    $item->mobile_no,
                    $item->payment_type,
                    // $item->remark,
                    $remark ? $remark->remark : '--',
                    $total_amount,
                    $item->delivery_date != null ? '<span style="display:none;">' . implode(array_reverse(explode('/', $item->delivery_date))) . '</span>' . $item->delivery_date : "--",
                    // '<a class="btn-sm btn-primary" target="_blank" href="generate-online-sale-invoice-pdf/' . $item->consolidate_order_no . '">View</a>'
                    $action
                );
            }
        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }

    public function user_order_item_details(){
        $orders = DB::table('user_order_items')
                    ->select('user_order_items.*', 'quantity as total_quantity', 'final_price_with_coupon_offer as final_price')
                    ->where('consolidate_order_no', request()->consolidate_order_no)
                    ->get();
        $new_data = [];
        foreach ($orders as $key => $item) {
            $new_data[] = array(
                ++$key,
                $item->order_no,
                '<img src="'.$item->product_image.'" alt="'.$item->product_name.'" width="100px">',
                $item->product_name,
                '<input type="text" name="" value="'.$item->total_quantity.'" class="form-control" style="text-align: center;" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" onchange="update_product_quantity('.$item->product_id.','.$item->id.',this)">',
                $item->product_price,
                $item->final_price,
            );
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $orders->count(),
            "recordsFiltered"      =>  $orders->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }


    public function update_user_order_product_quantity(){

        $get_data = UserOrderItem::find(request()->user_order_item_id);
        $discount_amount = null;
        $offer_discount_price = null;
        if($get_data->discount_amount){

            if($get_data->offer_discount_percentage){
                $total_amount = ($get_data->product_price * request()->quantity) - (($get_data->offer_discount_percentage / 100) * $get_data->product_price * request()->quantity);
            }else{
                $total_amount = $get_data->product_price * request()->quantity;
            }


            if($get_data->coupon_type){
                if($get_data->coupon_type == 'discount_by_precentage_btn'){
                    $discount_amount =  ($get_data->coupon_amount/100) * $total_amount;
                }else{
                    $discount_amount =  $get_data->coupon_amount;
                }
            }else{
                $discount_amount = null;
            }
            $offer_discount_price = ($get_data->product_price * request()->quantity) - (($get_data->offer_discount_percentage / 100) * $get_data->product_price * request()->quantity);
        }
       
        $final_price_with_coupon_offer = ($get_data->product_price * request()->quantity) - $discount_amount - (($get_data->offer_discount_percentage / 100) * $get_data->product_price * request()->quantity);
        $update_order_item_data = [
            'quantity'              => request()->quantity,
            'total_price'           => $get_data->product_price * request()->quantity,
            'discount_amount'       => $discount_amount,
            'after_discount'        => $discount_amount ? ($get_data->product_price * request()->quantity) - $discount_amount : null,
            'offer_discount_price'  => $offer_discount_price,
            'final_price_with_coupon_offer' => $final_price_with_coupon_offer
        ];

        

        $user_order_items = UserOrderItem::where('order_no',$get_data->order_no)->get();

        $final_price = 0;
        $product_price = 0;
        foreach($user_order_items as $item){
            if($item->id != $get_data->id){
                $final_price +=$item->final_price_with_coupon_offer;
                $product_price += $item->product_price * $item->quantity;
            }
            
        }

        $final_price += $final_price_with_coupon_offer;
        $product_price += $get_data->product_price * request()->quantity;

        $update_order_data = [
            'total_product_price'    => (float)$product_price,
            'discount_amount'        => (float)$discount_amount,
            'final_price'            => (float)$final_price
        ];

        // dd($update_order_data);

        UserOrderItem::find(request()->user_order_item_id)->update($update_order_item_data);

        UserOrder::where('order_no',$get_data->order_no)
        ->where('consolidate_order_no',$get_data->consolidate_order_no)
        ->update($update_order_data);

        echo json_encode(['status'=>'success','message'=>"Details Update Successfully"]);
    }

    public function update_address_in_order(){
        // echo json_encode(1);

        $address = address::find(request()->address_id);

        Notification::where('consolidate_order_no',request()->consolidate_order_no)->update([
            'address_id'    =>  request()->address_id,
            'postcode'      => $address->postcode
        ]);

        UserOrder::where('consolidate_order_no',request()->consolidate_order_no)->update([
            'name'          => $address->name,
            'address'       => $address->address,
            'postcode'      => $address->postcode,
            'mobile_no'     => $address->mobile_number
        ]);

        $check_deliveries = DB::table('deliveries')->where('order_no',request()->consolidate_order_no)->first();
        if($check_deliveries){
            DB::table('deliveries')->where('order_no',request()->consolidate_order_no)->update([
                'mobile_no'         => $address->mobile_number,
                'customer_name'     => $address->name,
                'address_id'        => request()->address_id,
                'delivery_address'  => $address->address,
            ]);
        }

        echo json_encode(['status'=>'success','message'=>"Address Update Successfully"]);

    }


    public function change_order_delivery_date(){
        Notification::where('consolidate_order_no',request()->consolidate_order_no)->update([
            'delivery_date'    =>  request()->delivery_date,
        ]);

        $date = implode('-',array_reverse(explode('/',request()->delivery_date)));
        $check_deliveries = DB::table('deliveries')->where('order_no',request()->consolidate_order_no)->first();
        if($check_deliveries){
            DB::table('deliveries')->where('order_no',request()->consolidate_order_no)->update([
                'date'  => $date
            ]);
        }

        echo json_encode(['status'=>'success','message'=>"Delivery Date Update Successfully"]);

    }




    public function get_online_Sale_data(){
        $data = UserOrder::join('notifications','notifications.consolidate_order_no','=','user_orders.consolidate_order_no')
        ->select('user_orders.*','notifications.address_id','notifications.delivery_date')
        ->where('user_orders.consolidate_order_no',request()->consolidate_order_no)->first();
        $profile = User::find($data->user_id);
        return view('superadmin.online-sale.edit_online_sale')->with(['data'=>$data,'profile' => $profile]);
    }


    public function get_all_address(){
        if(!empty(request()->order_id)){
            $data = DB::table('user_orders')->where('user_orders.id',request()->order_id)->first();
            $address = DB::table('addresses')->where('user_id',$data->user_id)->get();
            echo json_encode($address);
        }

        if(!empty(request()->user_id)){
            $address = DB::table('addresses')->where('user_id',request()->user_id)->get();
            echo json_encode($address);
        }
    }




    public function pacingList1()
    {
        if (request()->date != null) {
            $orders = Delivery::join('notifications', 'notifications.consolidate_order_no', '=', 'deliveries.order_no')
                ->where('deliveries.delivery_man_user_id', request()->id)
                ->where('notifications.delivery_date', request()->date)
                ->groupBy('deliveries.order_no')
                ->get(['notifications.delivery_date as delivery_date_is', 'deliveries.*', 'notifications.payment_mode']);
        } else {
            $orders = Delivery::join('notifications', 'notifications.consolidate_order_no', '=', 'deliveries.order_no')
                ->where('delivery_man_user_id', $_GET['id'])
                ->groupBy('deliveries.order_no')
                ->get(['notifications.delivery_date as delivery_date_is', 'deliveries.*', 'notifications.payment_mode']);
        }

        $new_data = [];

        foreach ($orders as $item) {

            $collectable_cash = UserOrder::where('consolidate_order_no', $item->order_no)->sum('final_price');

            $total_quantity = UserOrderItem::where('consolidate_order_no', $item->order_no)->sum('quantity');

            $new_data[] = array(
                $item->order_no,
                $item->delivery_address,
                $item->delivery_date_is,
                $item->payment_mode === "COD" ? number_format($collectable_cash, 2) : "PAID",
                $total_quantity,
                $item->delivery_status,
                $item->remark,
                '<a id="viewProDetailsDriver1" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-id="' . $item->order_no . '"  data-target="#viewProDetailsDriver">View</a>'
            );
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $orders->count(),
            "recordsFiltered"     => $orders->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }

    // Excel
    public function export(Request $request)
    {
        $id = $request->id;
        $date = !empty($request->date) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->date))) : '';

        // $products = product::get();
    
        // $data = Delivery::join('notifications','notifications.consolidate_order_no','=','deliveries.order_no')
        // ->join('user_orders','user_orders.consolidate_order_no', '=', 'notifications.consolidate_order_no')
        // ->join('user_order_items', 'user_order_items.consolidate_order_no', '=', 'notifications.consolidate_order_no')
        // ->select('notifications.delivery_date as delivery_date_is', 'deliveries.*', 'notifications.payment_mode', 'user_orders.final_price', 'user_orders.name', 'user_orders.mobile_no', 'user_orders.address', 'user_order_items.product_name')
        // ->where('deliveries.delivery_man_user_id',$id);
        // if(!empty($date)){
        //     $data->where('notifications.delivery_date', $date);
        // }
        // $data->groupBy('notifications.consolidate_order_no');
        // $data = $data->get();
        // return view('superadmin.reports.deliveryReport', [
        //     'invoices'  => $data,
        //     'data'      => $products,
        //     'driver_id' => $id,
        //     'date'      => $date
        // ]);
        // dd($request->post());
        $driver = DB::table('drivers')->where('id',$id)->first();
        return Excel::download(new UsersExport($request->id, $request->date), $driver->driver_name.$date.'.xlsx');

    }


    public function pacingList2()
    {

        // $orders = UserOrderItem::join('products', 'products.id','=', 'user_order_items.product_id')
        //                         ->groupBy('user_order_items.product_id')
        //                         ->where('consolidate_order_no', request()->order_no)->get(['products.product_varient', DB::raw('sum(user_order_items.quantity) as total_quantity'), 'user_order_items.*']);

        $orders = UserOrderItem::leftJoin('products', 'products.id', '=', 'user_order_items.product_id')
            ->groupBy('user_order_items.product_id')
            ->where('consolidate_order_no', request()->order_no)->get(['products.product_varient', DB::raw('sum(user_order_items.quantity) as total_quantity'), 'user_order_items.*']);

        $new_data = [];

        $i = 0;

        foreach ($orders as $item) {
            $new_data[] = array(
                ++$i,
                $item->product_name,
                $item->product_varient,
                $item->total_quantity,
            );
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $orders->count(),
            "recordsFiltered"     => $orders->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }

    // Retail customer orders packing list
    public function pacingList()
    {

        if (request()->date != null) {
            $data = DB::table('user_orders')
                ->join('notifications', 'notifications.consolidate_order_no', '=', 'user_orders.consolidate_order_no')
                ->join('user_order_payments', 'user_order_payments.id', '=', 'user_orders.payment_id')
                ->leftJoin('deliveries', 'deliveries.order_no', '=', 'user_orders.consolidate_order_no')
                ->leftJoin('users', 'deliveries.delivery_man_id', '=', 'users.id')
                ->where('notifications.delivery_date', request()->date)
                ->groupBy('notifications.consolidate_order_no')
                ->orderBy('user_orders.id', 'desc')
                ->get(['deliveries.delivery_man_id', 'user_orders.*', 'users.name as driver_name', 'notifications.delivery_date', 'deliveries.date']);
        } else {
            // $date = date('Y-m-d');
            // $next_day = date('d/m/Y', strtotime($date. ' + 1 days'));

            $data = DB::table('user_orders')
                ->join('notifications', 'notifications.consolidate_order_no', '=', 'user_orders.consolidate_order_no')
                ->join('user_order_payments', 'user_order_payments.id', '=', 'user_orders.payment_id')
                ->leftJoin('deliveries', 'deliveries.order_no', '=', 'user_orders.consolidate_order_no')
                ->leftJoin('users', 'deliveries.delivery_man_id', '=', 'users.id')
                // ->where('notifications.delivery_date', $next_day)
                ->groupBy('notifications.consolidate_order_no')
                ->orderBy('user_orders.id', 'desc')
                ->get(['deliveries.delivery_man_id', 'user_orders.*', 'users.name as driver_name', 'notifications.delivery_date', 'deliveries.date']);
        }

        // dd($data);

        $drivers = Driver::orderBy('id', 'desc')->get();

        $deliveries = Delivery::where('delivery_status', 'Packing')->orWhere('delivery_status', 'Pending')->get();

        $i = 0;
        $new_data = [];

        $action = '';

        foreach ($data as $item) {

            $class_name = "'class$i'";

            $action .= '<select class="select_2_input class' . $i . '" onchange="updateDriver(' . $class_name . ')" data-id="' . $item->consolidate_order_no . '">';
            $action .= '<option value="">Select</option>';

            if ($item->driver_name != null) {
                foreach ($drivers as $key => $value) {
                    // $count = Delivery::where('delivery_man_user_id', $value->id)->Where('delivery_status', 'Packing')->orWhere('delivery_status', 'Pending')->count();
                    $count = Delivery::where('delivery_man_user_id', $value->id)->whereBetween('delivery_status', ['Packing', 'Pending'])->where('date', $item->date)->count();

                    if ($value->driver_id == $item->delivery_man_id) {
                        $action .= '<option value="' . $value->driver_id . '" selected >' . $value->driver_name . ' {Total Orders : ' . $count . '}</option>';
                    } else {
                        $action .= '<option value="' . $value->driver_id . '" >' . $value->driver_name . ' {Total Orders : ' . $count . '}</option>';
                    }
                }
            } else {
                foreach ($drivers as $key => $value) {
                    // $count = Delivery::where('delivery_man_user_id', $value->id)->Where('delivery_status', 'Packing')->orWhere('delivery_status', 'Pending')->count();
                    $count = Delivery::where('delivery_man_user_id', $value->id)->whereBetween('delivery_status', ['Packing', 'Pending'])->where('date', $item->date)->count();
                    $action .= '<option value="' . $value->driver_id . '"  >' . $value->driver_name . ' {Total Orders : ' . $count . '}</option>';
                }
            }

            $action .= '</select>';

            $new_data[] = array(
                ++$i,
                $item->consolidate_order_no,
                $item->name,
                $item->address,
                $item->delivery_date,
                // ($item->driver_name == null)?$action:$item->driver_name,
                $action,
                '<a id="viewOrderedProductDetails" title="Assign Driver" class="btn btn-primary" href="javascript:void(0)" data-toggle="modal" data-id="' . $item->consolidate_order_no . '"  data-target="#viewConsolidateOrder1">View</a>'
            );
            $action = '';
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }

    // open ordered product modal
    function viewOrderedProducts()
    {

        $order_no = request()->id;

        $delivery_man = Driver::get();

        $ordered_products = UserOrderItem::join('products', 'products.id', '=', 'user_order_items.product_id')->where('user_order_items.consolidate_order_no', $order_no)->groupBy('user_order_items.product_id')->get(['products.product_varient', DB::raw('sum(user_order_items.quantity) as total_quantity'), 'user_order_items.product_id', 'user_order_items.product_name', 'user_order_items.quantity']);

        $payment_status = Notification::where('consolidate_order_no', request()->id)->first();

        $delivery_data_if_added = Delivery::where('order_no', request()->id)->first();

        $status = 0;

        if ($delivery_data_if_added != null) {
            $status = 1;
        }

        return view(
            'superadmin.packing_list.modal.products',
            [
                "order_no" => $order_no,
                "delivery_man" => $delivery_man,
                "ordered_products" => $ordered_products,
                'status' => $status,
                'delivery' => $delivery_data_if_added,
                'payment_type' => $payment_status->payment_mode,
                "remark" => $payment_status->remark,
            ]
        );
    }

    // View Retail Customer order details
    public function viewRetailCustomerOrders()
    {
        return response()->json(Order::find($_GET['id'])->ordeBy('id', 'DESC'));
    }

    // update retail customer status
    public function updateRetailCustomerStatus(Request $request)
    {
        try {
            Customer::where('id', $request->id)->update(["status" => (bool)$request->status]);
            return response()->json(['success' => 'Status Updated']);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    // add retail customer order
    public function retailCustomerOrder()
    {
        $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
            ->select('stocks.*', 'products.img_path', 'products.category_id', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))
            ->where('stocks.quantity', '>', 0)
            ->groupBy('stocks.product_id')
            ->get();

        // dd($products);

        $customers = User::where('is_admin', 0)->get();
        return view('superadmin.customer-modal.RetailCustomerOrder', ["products" => $products, "customers" => $customers]);
    }
}
