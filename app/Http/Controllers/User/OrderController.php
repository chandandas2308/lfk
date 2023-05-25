<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyPoint;
use App\Models\product;
use App\Models\UserOrderItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\UserOrder;
use App\Models\VoucherHistory;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

        // fetch all loyalty points
        public function loyaltyPoints()
        {
            $data = LoyaltyPoint::join('users', 'users.id','=','loyalty_points.user_id')->where('users.id', Auth::user()->id)->get(["users.*", "loyalty_points.*"]);
            
            $new_data = array();
            $i = 0;
    
            foreach($data as $item){
                $new_data[] = array(
                    ++$i,
                    $item->gained_points,
                    $item->spend_points,
                    $item->remains_points,    
                    date('d-m-Y', strtotime($item->transaction_date))
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

    //pending
    public function fetchAllListOrder()
    {

        if(request()->id != 1){
            $data = DB::table('user_orders')
                ->join('notifications', 'notifications.consolidate_order_no', '=', 'user_orders.consolidate_order_no')
                ->join('user_order_payments', 'user_order_payments.id', '=', 'user_orders.payment_id')
                ->leftJoin('deliveries', 'deliveries.order_no', '=', 'user_orders.consolidate_order_no')
                ->where('notifications.user_id', Auth::user()->id)
                // ->where('deliveries.delivery_status', 'delivered')
                ->groupBy('notifications.consolidate_order_no')
                ->get();
        }else{
            $data = DB::table('user_orders')
                ->join('notifications', 'notifications.consolidate_order_no', '=', 'user_orders.consolidate_order_no')
                ->join('user_order_payments', 'user_order_payments.id', '=', 'user_orders.payment_id')
                ->leftJoin('deliveries', 'deliveries.order_no', '=', 'user_orders.consolidate_order_no')
                // ->orWhere('deliveries.delivery_status', '!=', 'delivered')
                // ->whereNull('deliveries.delivery_status')
                ->where('user_orders.user_id', Auth::user()->id)
                ->groupBy('notifications.consolidate_order_no')
                ->get();
                // dd($data);
        }
        $new_data = array();

        $i = 0;

        $action = '';

        foreach ($data as $item) {

            $action .= '<a name="viewOrderDetails" style="background:#f26622; border-color:#fff;" id="viewOrderDetails" class="btn btn-primary viewOrderDetails'.$i.'" data-id="'.$item->consolidate_order_no.'">View</a>';
            $action .= '<a class="btn" style="background:#ec1c24; color:#fff; border-color:#fff;" href="'.route('checkout.updateAddressPage',$item->consolidate_order_no).'" >Change Address</a>';

            // $final_price = UserOrderItem::where('consolidate_order_no', $item->consolidate_order_no)->sum('total_price');
            $final_price = DB::table('user_orders')->where('consolidate_order_no', $item->consolidate_order_no)->sum('final_price');

            $new_data[] = array(
                ++$i,
                substr($item->consolidate_order_no,-5),
                $item->name,
                $item->buyer_phone,
                $item->payment_type,
                '$'.$final_price,
                $item->delivery_date !=null ? $item->delivery_date : "--",
                substr($item->address,10).'...',
                !empty($item->delivery_status) ? $item->delivery_status : "Pending",
                $item->remark,
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

    public function myVouchersDetails(){
        $data = DB::table('voucher_codes')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        $new_data = array();
        $i = 0;

        foreach ($data as $item) {
            $new_data[] = array(
                ++$i,
                $item->code,
                $item->status != 1 ? "Active":"Used",
                date('d-m-Y', strtotime($item->expiry_date)),
                date('d-m-Y', strtotime($item->created_at)),
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

    // fetch consolidate order details
    public function consolidateOrdersDetails()
    {
        $user_order = UserOrderItem::where('consolidate_order_no', request()->id)->get();

        $delivery_date = Notification::where('consolidate_order_no', request()->id)->first();

        $address = UserOrder::where('consolidate_order_no', request()->id)->first();

        $total = UserOrder::where('consolidate_order_no', request()->id)->sum('final_price');

        $subTotalOfProducts = UserOrderItem::where('consolidate_order_no', request()->id)->sum('total_price');

        $shipping_charge = UserOrder::where('consolidate_order_no', request()->id)->sum('ship_charge');
        
        $is_voucher = VoucherHistory::where('consolidate_order_no', request()->id)->count();

        $voucher_history_total = VoucherHistory::where('consolidate_order_no', request()->id)->sum('voucher_amount');

        $offer_discount_face_value1 = UserOrderItem::where('consolidate_order_no', request()->id)->get();

        $offer_discount_face_value=0;

        foreach($offer_discount_face_value1 as $key=>$value){
            $offer_discount_face_value += $value->offer_discount_face_value*$value->quantity;
        }



        $sub_total = UserOrderItem::where('consolidate_order_no', request()->id)->sum('final_price_with_coupon_offer');
        $shipping_charge = UserOrder::where('consolidate_order_no', request()->id)->sum('ship_charge');

        $final_price = UserOrder::where('consolidate_order_no', request()->id)->sum('final_price');

        $voucher_code = UserOrder::where('consolidate_order_no', request()->id)->where('voucher_code','!=','')->first();

        $notification = Notification::where('consolidate_order_no',request()->id)->latest()->first();
        // ->sum('offer_discount_face_value');

        // dd($offer_discount_face_value);

        return view('frontend.order.view',[
            'sub_total'         => $sub_total,
            "shipping_charge"   => $shipping_charge,
            'final_price'       => $final_price,
            'voucher_code'      => $voucher_code, 
            'notification'      => $notification,

            "offer_discount_face_value" => $offer_discount_face_value,
            "is_voucher"=>$is_voucher, 
            "voucher_history_total"=>$voucher_history_total, 
            "consolidate_order_no"=>request()->id,
            "subTotalOfProducts" => $subTotalOfProducts,
            "delivery_date"=>$delivery_date,
            "address"=>$address, 
            "total"=>$total, 
            "shipping_charge"=>$shipping_charge]);
    }

    public function all_order_list(){

        $user_order = UserOrderItem::where('consolidate_order_no', request()->consolidate_order_no)->get();
        $new_data = array();
        foreach ($user_order as $item) {
            $new_data[] = array(
               '<img src="'.$item->product_image.'" width="100">',
                $item->product_name,
                $item->quantity,
                '$'.$item->product_price,
                '$'.$item->final_price_with_coupon_offer
            );
        }

        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $user_order->count(),
            "recordsFiltered"      => $user_order->count(),
            "data"                 => $new_data
        );

        echo json_encode($output);


    }



    // complet
    public function fetchAllcompletOrder()
    {

        $data = UserOrderItem::join('products', 'products.id', '=', 'user_order_items.product_id')->where('user_id', Auth::user()->id)->get(["products.id", "user_order_items.user_id", "products.product_name", "products.img_path", "products.min_sale_price"]);

        $new_data = array();

        foreach ($data as $item) {
            $new_data[] = array(
                $item->user_id,
                Carbon::parse($item->created_at)->format('d-m-y'),
                '<img src="' . $item->img_path . '" height="100" width="100" class="thumbnail rounded" >',
                $item->min_sale_price,
                Carbon::parse($item->end_date)->format('d-m-y'),
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
}
