<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\cart;
use App\Models\LoyaltyPointshop;
use App\Models\Notification;
use App\Models\session as ModelsSession;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutSessionController extends Controller
{
    //
    function updateAddress(Request $request){

        $data = cart::where('use_id',Auth::user()->id)->get();
        $notification = DB::table('notifications')->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();

        $sub_total = 0;
        $final_price = 0;
        $shipping_charge = 0;
        foreach($data as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            // $sub_total += $product->min_sale_price * $item->quantity;
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock){
                $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
            }
        }

        $address = DB::table('addresses')->where('id',$request->id)->first();

        $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
        ->select('notifications.*','addresses.unit')
        ->where('notifications.user_id', Auth::user()->id)
        ->where('notifications.postcode', $address->postcode)
        ->where('addresses.unit', $address->unit)
        ->latest()
        ->first();

        $date = date('Y-m-d');
        $last_order_date = implode('-',array_reverse(explode('/',$user_last_order->delivery_date ?? '')));

        if($user_last_order &&  $last_order_date > $date){
            $old_order_total_amount = UserOrder::where('consolidate_order_no', $user_last_order->consolidate_order_no)
            ->sum('final_price');

            $total_amount_with_new_and_old_order = $old_order_total_amount + $final_price;

            if ($old_order_total_amount >= 70) {
                $shipping_charge = 0;
                $final_price = $final_price; 
            } else if ($total_amount_with_new_and_old_order >= 70) {
                $shipping_charge = -8;
                $final_price = $final_price - 8; 
            } else {
                $shipping_charge = 0;
                $final_price = $final_price; 
            }
        }else{
            if ($final_price >= 70) {
                $shipping_charge = 0;
                $final_price = $final_price;
            } else {
                $shipping_charge = 8;
                $final_price = $final_price + 8;
            }
        }
        return response()->json([
            "final_price"       => $final_price,
            'shipping_charge'   => $shipping_charge,
        ]);
    }

    function updatePaymentMode(Request $request){

        $session_data = ModelsSession::where('id', Session::getId())->first();
        $loyalty_points = LoyaltyPointshop::where('user_id', Auth::user()->id)->value('loyalty_points');

        $session = ModelsSession::find(Session::getId());
        $session->payment_mode = request()->mode;
        $session->loyalty_points = $loyalty_points;
        $session->save();

        return response()->json([
            "final_price" => (((float)$session_data->sub_total+(int)$session_data->shipping_charge)-(float)$session_data->discount_value),
            'sub_total' => $session_data->sub_total,
            'shipping_charge' => $session_data->shipping_charge
        ]);

    }

    function removeCoupon(){

        $data = cart::where('use_id',Auth::user()->id)->get();
        $notification = DB::table('notifications')->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();

        $sub_total = 0;
        $final_price = 0;
        $shipping_charge = 0;
        foreach($data as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            $sub_total += $product->min_sale_price * $item->quantity;
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock){
                $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
            }
        }

        $address = DB::table('addresses')->where('id',request()->address_id)->first();
        $user_last_order = '';
        if($address){
            $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
            ->select('notifications.*','addresses.unit')
            ->where('notifications.user_id', Auth::user()->id)
            ->where('notifications.postcode', $address->postcode)
            ->where('addresses.unit', $address->unit)
            ->latest()
            ->first();
        }

        $date = date('Y-m-d');
        $last_order_date = implode('-',array_reverse(explode('/',$user_last_order->delivery_date ?? '')));

        if($user_last_order &&  $last_order_date > $date){
            $old_order_total_amount = UserOrder::where('consolidate_order_no', $user_last_order->consolidate_order_no)
            ->sum('final_price');

            $total_amount_with_new_and_old_order = $old_order_total_amount + $final_price;

            if ($old_order_total_amount >= 70) {
                $shipping_charge = 0;
                $final_price = $final_price; 
            } else if ($total_amount_with_new_and_old_order >= 70) {
                $shipping_charge = -8;
                $final_price = $final_price - 8; 
            } else {
                $shipping_charge = 0;
                $final_price = $final_price; 
            }
        }else{
            if ($final_price >= 70) {
                $shipping_charge = 0;
                $final_price = $final_price;
            } else {
                $shipping_charge = 8;
                $final_price = $final_price + 8;
            }
        }
        return response()->json([
            "final_price"       =>  number_format($final_price,2),
            'shipping_charge'   => number_format($shipping_charge,2)
        ]);
    }   

}
