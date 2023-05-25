<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Models\product;
use App\Models\Stock;
use App\Models\TrackStockDeductDetails;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use App\Models\UserOrderPayment;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $customer = User::orderBy('id','desc')->get();

            $addresses = address::orderBy('id','desc')->get();

            $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
                ->select('stocks.*', 'products.img_path', 'products.chinese_product_name as product_name_c', 'products.category_id', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))
                ->where('stocks.quantity', '>', 0)
                ->groupBy('stocks.product_id')
                ->get();

            return view('superadmin.backend_order.order2', compact('customer', 'addresses', 'products'));
    }

    public function get_customer_details(){
        $user = User::find(request()->customer_id);
        echo json_encode($user);
    }

    public function get_product_details(){
        $data = Product::find(request()->product_id);
        echo json_encode($data);
    }

    public function add_new_address(Request $request){
        $data = $request->validate([
            'name'              => 'required',
            'mobile_number'     => 'required',
            'postcode'          => 'required',
            'address'           => 'required',
            'unit'              => 'required',
            'user_id'           => 'required'
        ]);

        address::create($data);

        echo json_encode(['status' => 'success', 'message' => 'New Address Add Successfully']);


    }


    public function get_all_product_list(){
        // echo json_encode(request()->product_id_array);exit;
        $data = '';
        if(empty(request()->product_id_array)){
            $data = Product::all();
        }else{
            $data = Product::whereNotIn('id',request()->product_id_array)->get();
        }
        echo json_encode($data);
    }

    public function get_previous_order_details(){
        $address = address::where('id',request()->address_id)->where('user_id',request()->user_id)->first();
        $date = date('d/m/Y');
        $delivery_date = '';
        $shipping_charge = 0;
        $old_order_total_amount = 0;
        $old_order_shipping_charge = 0;
        $old_order_product_sub_total = 0;
        $final_price = empty(request()->price) ? 0 : request()->price;

        $latest_order_final_price = empty(request()->price) ? 0 : request()->price;

        $last_order =  Notification::join('addresses','addresses.id','=','notifications.address_id')
        ->select('notifications.*','addresses.unit')
        ->where('notifications.user_id', request()->user_id)
        ->where('notifications.postcode', $address->postcode ?? '')
        ->where('addresses.unit', $address->unit ?? '')
        ->latest()
        ->first();

        if($address && $last_order){
           
            if($last_order->delivery_date > $date){
                $delivery_date = $last_order->delivery_date;
            }

                $last_order_date = $last_order->delivery_date;
                $consolidate_order_is = '';
               
                if($last_order &&  $last_order_date > $date && !empty($final_price)){
                    $old_order_total_amount = UserOrder::where('consolidate_order_no', $last_order->consolidate_order_no)
                    ->sum('final_price');

                    $old_order_product_sub_total = UserOrderItem::where('consolidate_order_no', $last_order->consolidate_order_no)
                    ->sum('final_price_with_coupon_offer');

                    $old_order_shipping_charge = UserOrder::where('consolidate_order_no', $last_order->consolidate_order_no)
                    ->sum('ship_charge');

                    $old_shipping_charge = UserOrder::where('consolidate_order_no', $last_order->consolidate_order_no)
                    ->where('ship_charge','-8')->first();

        
                    $total_amount_with_new_and_old_order = $old_order_total_amount + $final_price;

                    $consolidate_order_is = $last_order->consolidate_order_no;
                    $payment_mode = $last_order->payment_mode;
        
                    if ($old_order_total_amount >= 70) {
                        $shipping_charge = 0;
                        $final_price = $total_amount_with_new_and_old_order; 
                    } else if ($total_amount_with_new_and_old_order >= 70 && !$old_shipping_charge) {
                        $shipping_charge = -8;
                        $final_price = $total_amount_with_new_and_old_order - 8; 
                    } else {
                        $shipping_charge = 0;
                        $final_price = $total_amount_with_new_and_old_order; 
                    }
                }else{
                    if($final_price){
                        if ($final_price >= 70) {
                            $shipping_charge = 0;
                            $final_price = $final_price;
                        } else {
                            $shipping_charge = 8;
                            $final_price = $final_price + 8;
                        }
                    }
                }
            }else{
                if($final_price){
                    if ($final_price >= 70) {
                        $shipping_charge = 0;
                        $final_price = $final_price;
                    } else {
                        $shipping_charge = 8;
                        $final_price = $final_price + 8;
                    }
                }
            }



        echo json_encode([
            'delivery_date'                 => $delivery_date,
            'shipping_charge'               => number_format($shipping_charge,2),
            'old_order_product_sub_total'   => number_format($old_order_product_sub_total,2),
            'old_order_total_amount'        => number_format($old_order_total_amount,2),
            'old_order_shipping_charge'     => number_format($old_order_shipping_charge,2),
            'latest_order_final_price'      => number_format($latest_order_final_price + $shipping_charge ,2),
            // $total_amount_with_new_and_old_order
        ]);
    }


    public function add_new_order(Request $request){
        $request->validate([
            'customer_id'   => 'required',
            'recipientName' => 'required',
            'mobileNo'      => 'required',
            'address_id'    => 'required',
            'unit'          => 'required',
            'delivery_date' => 'required',
        ]);

          
            foreach($request->product_id as $key => $item){
                if(!empty($item)){
                 
                    $request->validate([
                        "product_id.".$key      => "required",
                        'quantity.'.$key        => 'required',
                        'unit_price.'.$key      => 'required',
                        'sub_total.'.$key      => 'required',
                    ],[
                        'product_id.'.$key.'.required'  => 'Please Select Product', 
                        'quantity.'.$key.'.required'    => 'Please Enter Quantity',
                        'unit_price.'.$key.'.required'  => 'Unit Price Required',
                        'sub_total.'.$key.'.required'   => 'Subtotal Price Required',

                    ]);
                }
            }

            $final_price = 0;
            $product_original_price = 0;
            foreach($request->product_id as $key => $item){
                if(!empty($item)){
                    $product = Product::find($item);
                    $price = !empty($product->discount_price) ? $product->discount_price : $product->min_sale_price;
                    $final_price = $price * $request->quantity[$key];
                    $product_original_price += $product->min_sale_price * $request->quantity[$key];
                }
            }



            $address = address::find($request->address_id);

            $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
            ->select('notifications.*','addresses.unit')
            ->where('notifications.user_id', $request->customer_id)
            ->where('notifications.postcode', $address->postcode)
            ->where('addresses.unit', $address->unit)
            ->latest()
            ->first();


            $today_date = date('Y-m-d');
            $last_order_date = implode('-',array_reverse(explode('/',$user_last_order->delivery_date ?? '')));

        if($user_last_order &&  $last_order_date > $today_date){
            $old_order_total_amount = UserOrder::where('consolidate_order_no', $user_last_order->consolidate_order_no)
            ->sum('final_price');

            $old_shipping_charge = UserOrder::where('consolidate_order_no', $user_last_order->consolidate_order_no)
            ->where('ship_charge','-8')->first();

            $total_amount_with_new_and_old_order = $old_order_total_amount + $final_price;

            if ($old_order_total_amount >= 70) {
                $shipping_charge = 0;
                $final_price = $final_price; 
            } else if ($total_amount_with_new_and_old_order >= 70 && !$old_shipping_charge) {
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

       

        $order_number = UserOrder::orderBy('id', 'DESC')->first();

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        if (empty($order_number)) {             
            $order_number = 'LFKODC'.$year.$month.'00001';
        } else {
            // $number = str_replace('LFKODC', '', $order_number->order_no);
            // $order_number =  "LFKODC".$year.$month.sprintf("%05d", $order_number1 + 1);
        
            $number = str_replace('LFKODC', '', $order_number->order_no);
            // $get_year = substr(str_replace('LFKODC', '', $consolidate_order_number->consolidate_order_no),0,4);
            // $get_month = substr(substr(str_replace('LFKODC', '', $consolidate_order_number->consolidate_order_no),0,6),-2);
            $get_year = substr($number,0,4);
            $get_month = substr(substr($number,0,6),-2);
            if($get_year == $year && $get_month == $month){
                $number = str_replace('LFKODC'.$get_year.$get_month, '', $order_number->order_no);
                $order_number =  "LFKODC" .$year.$month. sprintf("%05d", $number + 1);
            }else if($get_year == $year && $get_month != $month){
                $number = str_replace('LFKODC'.$get_year.$get_month, '', $order_number->order_no);
                $order_number =  "LFKODC" .$year.$month. sprintf("%05d", $number + 1);
            }else{
                $order_number = 'LFKODC'.$year.$month.'00001';
            }
        }

        
        $today_date = date('Y-m-d');
        $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', $request->customer_id)
                ->where('notifications.postcode', $address->postcode)
                ->where('addresses.unit', $address->unit)
                ->latest()
                ->first();
               
        if(!empty($user_last_order)){
           
            $last_order_date = $user_last_order->delivery_date;

            $last_order_date = implode('-',array_reverse(explode('/',$last_order_date)));

            if ($last_order_date > $today_date) {
               
            $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', $request->customer_id)
                ->where('notifications.postcode', $address->postcode)
                ->where('addresses.unit', $address->unit)
                ->latest()
                ->first();

                $consolidate_order_number = $notification->consolidate_order_no;
                $delivery_date = $notification->delivery_date;
                $end_date = $notification->end_date;
                $payment_mode = $notification->payment_mode;
                
                $data['order_no'] = $consolidate_order_number;
                Notification::create([
                    'consolidate_order_no'  => $consolidate_order_number,
                    'address_id'            => $request->address_id,
                    'postcode'              => $address->postcode,
                    'user_id'               => $request->customer_id,
                    'order_no'              => $order_number,
                    'delivery_date'         => $delivery_date,
                    'end_date'              => $end_date,
                    'payment_mode'          => $payment_mode,
                    'remark'                => $request->remark,
                ]);

            } else {
                
                $consolidate_order_number = Notification::orderBy('id', 'DESC')->first();
                if (empty($consolidate_order_number)) {
                    $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                } else {
                    $number = str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no);
                    // $get_year = substr(str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no),0,4);
                    // $get_month = substr(substr(str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no),0,6),-2);
                    $get_year = substr($number,0,4);
                    $get_month = substr(substr($number,0,6),-2);
                    if($get_year == $year && $get_month == $month){
                        $number = str_replace('LFKODCC'.$get_year.$get_month, '', $consolidate_order_number->consolidate_order_no);
                        $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%05d", $number + 1);
                    }else if($get_year == $year && $get_month != $month){
                        $number = str_replace('LFKODCC'.$get_year.$get_month, '', $consolidate_order_number->consolidate_order_no);
                        $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%05d", $number + 1);
                    }else{
                        $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                    }
                }


                // $consolidate_order_number = Notification::orderBy('id', 'DESC')->first();
                // if (empty($consolidate_order_number)) {
                //     $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                // } else {
                //     $number = str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no);
                //     $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%04d", $number + 1);
                // }
                // echo $consolidate_order_number;
                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no'      => $consolidate_order_number,
                    'address_id'                => $request->address_id,
                    'postcode'                  => $address->postcode,
                    'user_id'                   => $request->customer_id,
                    'order_no'                  => $order_number,
                    'payment_mode'              => 'COD',
                    'delivery_date'             => $request->delivery_date,
                    'remark'                    => $request->remark,
                ]);
            }
        } else {

            $consolidate_order_number = Notification::orderBy('id', 'DESC')->first();
            if (empty($consolidate_order_number)) {
                $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
            } else {
                $number = str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no);
                // $get_year = substr(str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no),0,4);
                // $get_month = substr(substr(str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no),0,6),-2);
                $get_year = substr($number,0,4);
                $get_month = substr(substr($number,0,6),-2);
                if($get_year == $year && $get_month == $month){
                    $number = str_replace('LFKODCC'.$get_year.$get_month, '', $consolidate_order_number->consolidate_order_no);
                    $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%05d", $number + 1);
                }else if($get_year == $year && $get_month != $month){
                    $number = str_replace('LFKODCC'.$get_year.$get_month, '', $consolidate_order_number->consolidate_order_no);
                    $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%05d", $number + 1);
                }else{
                    $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                }
            }
            
            // dd($consolidate_order_number);
            // if (empty($consolidate_order_number)) {
            //     $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
            // } else {
            //     $number = str_replace('LFKODCC'.$year.$month, '', $consolidate_order_number->consolidate_order_no);
            //     // $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%04d", $number + 1);
            // }
        

            $data['order_no'] = $consolidate_order_number;
           

            Notification::create([
                'consolidate_order_no'  => $consolidate_order_number,
                'address_id'            => $request->address_id,
                'postcode'              => $address->postcode,
                'user_id'               => $request->customer_id,
                'order_no'              => $order_number,
                'payment_mode'          => 'COD',
                'delivery_date'         => $request->delivery_date,
                'remark'                => $request->remark,
            ]);
        }

        $payment = UserOrderPayment::create([
            'consolidate_order_no'  => $consolidate_order_number,
            'user_id'               => $request->customer_id,
            'buyer_name'        => $address->name,
            'buyer_phone'       => $address->mobile_number,
            'payment_type'      => 'COD',
            'time'              => now(),
            'amount'            => $final_price,
            'currency'          => 'sgd',
            'status'            => 'succeeded',
        ]);


        UserOrder::create([
            'payment_id'                => $payment->id,
            'payment_reference_id'      => "COD",
            'name'                      => $address->name,
            'email'                     => $request->customer_id,
            'mobile_no'                 => $address->mobile_number,
            'address_id'                => $address->id,
            'address'                   => $address->address,
            'postcode'                  => $address->postcode,
            'unit'                      => $address->unit,
            'country'                   => $request->country!=null?$request->country:"singapore",
            'state'                     => $request->state !=null?$request->state:"singapore",
            'city'                      => $request->city !=null?$request->city:"singapore",
            'final_price'               => $final_price,
            'order_no'                  => $order_number,
            'consolidate_order_no'      => $consolidate_order_number,
            'user_id'                   => $request->customer_id,
            'coupon_code'               => empty($check_voucher_code) ? $request->coupon : null,
            'voucher_code'              => !empty($check_voucher_code) ? $request->coupon : null,
            'discount_amount'           => null,
            'coupon_amount'             => null,
            'coupon_type'               => null,
            'status'                    => 0,
            'total_product_price'       => $product_original_price,
            'ship_charge'               => $shipping_charge,
        ]);

        $date = Carbon::now();

        $store_data_in_order = [];
        foreach($request->product_id as $key => $item){
            if(!empty($item)){
                $insert_product_details = DB::table('products')->where('id',$item)->first();
                $product = product::where('id',$item)->first();
                if($product->discount_price > 0){
                    if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                        $total_product = $product->discount_price*$request->quantity[$key];
                        $offer_discount_price       = $product->discount_price * $request->quantity[$key];
                        $offer_discount_percentage  = $product->discount_percentage;
                        $offer_discount_type        = $product->discount_type;
                        $offer_discount_face_value  = $product->discount_face_value;
                        $offer_name                 = $product->discount_name;
                    }  
                    else{
                        $total_product = $product->min_sale_price*$request->quantity[$key];
                        $offer_discount_price       = 0;
                        $offer_discount_percentage  = 0;
                        $offer_discount_type        = '';
                        $offer_discount_face_value  = 0;
                        $offer_name                 = null;
                    }
                }else{
                    $total_product = $product->min_sale_price*$request->quantity[$key];
                    $offer_discount_price       = 0;
                    $offer_discount_percentage  = 0;
                    $offer_discount_type        = '';
                    $offer_discount_face_value  = 0;
                    $offer_name                 = null;
                }

                $store_data_in_order[] = [
                    'product_id'            => $item,
                    'product_name'          => $insert_product_details->product_name,
                    'product_image'         => $insert_product_details->img_path,
                    'quantity'              => $request->quantity[$key],
                    'product_price'         => $insert_product_details->min_sale_price,
                    'total_price'           => $insert_product_details->min_sale_price * $request->quantity[$key],
                ];


                UserOrderItem::create([
                    'user_id'               => $request->customer_id,
                    'order_no'              => $order_number,
                    'consolidate_order_no'  => $consolidate_order_number,
                    'product_id'            => $item,
                    'product_name'          => $insert_product_details->product_name,
                    'barcode'               => $insert_product_details->barcode,
                    'product_image'         => $insert_product_details->img_path,
                    'quantity'              => $request->quantity[$key],
                    'product_price'         => $insert_product_details->min_sale_price,
                    'total_price'           => $insert_product_details->min_sale_price * $request->quantity[$key],
                    'coupon_code'           => null,
                    'discount_amount'       => null,
                    'coupon_amount'         => null,
                    'coupon_type'           => null,
                    'after_discount'        => null,
                    'offer_discount_price'  => $offer_discount_price,
                    'offer_discount_percentage' => $offer_discount_percentage,
                    'offer_discount_type'       => $offer_discount_type,
                    'offer_discount_face_value' => $offer_discount_face_value,
                    'offer_name'                => $offer_name,
                    'final_price_with_coupon_offer' => $total_product
                ]);


            }
        }

       
        Order::insert([
            "owner_id"              => $request->customer_id,
            "order_by"              => 'self',
            "quotation_id"          => NULL,
            "order_number"          => $consolidate_order_number,
            "customer_name"         => $address->name,
            "customer_id"           => $request->customer_id,
            "date"                  => $date->toDateString(),
            "customer_address"      => $address->address . ' ' . $address->name . ' ' . $address->postcode . ' ' . $address->mobile_number . ' ' . $address->unit,
            "customer_type"         => 'retail',
            "mobile_no"             => $address->mobile_number,
            "email_id"              => $request->customer_id,
            "tax"                   => '0',
            "shipping_type"         => 'delivery',
            "products_details"      => json_encode($store_data_in_order),
            "tax_inclusive"         => '0',
            "untaxted_amount"       => $final_price,
            "GST"                   => '',
            "sub_total"             => $final_price,
            "created_at"            => now(),
        ]);

       

        // track stock deduct details with stock deduct details
        foreach($request->product_id as $key => $item){
            $remaining = 0;
            $stocks = Stock::where('product_id', $item)->where('quantity','!=',0)->get();
            $total_stock_deduct = $request->quantity[$key];
            foreach($stocks as $stock){
                $prevStockQty = $stock->quantity;

                if($remaining == 0 && $total_stock_deduct != 0){
                    if($prevStockQty >= $request->quantity[$key]){
                        $deduct = $prevStockQty-$request->quantity[$key];
                        $total_stock_deduct = 0;
                        $remaining = 0;
                        $deduct_quantity = $request->quantity[$key];

                    }else{
                        // $deduct = $item->quantity - $prevStockQty;
                        $deduct = 0;
                        $remaining = $request->quantity[$key] - $prevStockQty;

                        $deduct_quantity = $prevStockQty;
                    }
                }else{
                    if($prevStockQty >= $remaining ){
                        $deduct_quantity = $remaining;

                        $deduct = $prevStockQty - $remaining;
                        $total_stock_deduct = 0;
                        $remaining = 0;

                        
                    }else{
                        $remaining = $remaining - $prevStockQty;
                        $deduct_quantity = $prevStockQty;
                    }
                }

                
                Stock::where('id', $stock->id)->update([
                    'quantity' => $deduct
                ]);

                if($deduct_quantity !=0 ){
                    $get_warehouse = Warehouse::where('name',$stock->warehouse_name)->first();
                    TrackStockDeductDetails::create([
                    'consolidate_order_no'   => $consolidate_order_number,
                    'order_no'               => $order_number,
                    'warehouse_id'           => $get_warehouse ? $get_warehouse->id : '',
                    'warehouse_name'         => $stock->warehouse_name,
                    'user_id'                => $request->customer_id,
                    'product_id'             => $item,
                    'deduct_quantity'        => $deduct_quantity
                    ]);
                }
            }
        }



        echo json_encode(['status'=>'success','message' => 'New Order Create Successfully','url'=>route('SA-SalesTab')]);





    }



    // update order
    public function updateOrder1(Request $request){
            
            request()->validate([
                'customerName'      => 'required',
                'recipientName'     => 'required',
                'postcode'          => 'required',
                'address'           => 'required',
                'unit'              => 'required',
                'mobileNo'          => 'required',
                'delivery_date'     => 'required|date_format:d/m/Y',
                'product_id'        => 'required'
            ]);
    
            $user = User::find($request->customerName);
    
            if(strlen($request->address) > 1){
                $address = address::create([
                    'user_id'       => $user->id,
                    'name'          => $user->name,
                    'postcode'      => $request->postcode,
                    'address'       => $request->address,
                    'unit'          => $request->unit,
                    'mobile_number' => $request->mobileNo
                ]);
                $addressIs = address::find($address->id);
            }else{
                $addressIs = address::find($request->address);
            }
    
            // dd($checkAddress);
    
            $date = date('Y-m-d');
    
            // $checkAddress = Notification::where('user_id', $user->id)->where('postcode', $addressIs->postcode)->latest()->first();
            $checkAddress = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', $user->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();
            // dd($checkAddress);
    
            // $notification1 = Notification::where('user_id', $user->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
            $notification1 = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', $user->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->where('notifications.delivery_date', '>', date('d/m/Y'))->count();
            // dd($notification);
    
            $order_number = UserOrder::orderBy('id', 'DESC')->pluck('order_no')->first();
            $order_number1 = UserOrder::orderBy('id', 'DESC')->pluck('id')->first();
    
            $now = new \DateTime('now');
            $month = $now->format('m');
            $year = $now->format('Y');
    
            if ($order_number == null or $order_number == "") {
                $order_number = 'LFKODC' . $year . $month . '00001';
            } else {
                $number = str_replace('LFKODC', '', $order_number);
                $order_number =  "LFKODC" . $year . $month . sprintf("%04d", $order_number1 + 1);
            }
    
            if ($checkAddress != null) {
    
                $prev_delivery_date = implode('-', array_reverse(explode('/', $checkAddress->delivery_date)));
    
                $diff_days = date_diff(date_create($prev_delivery_date),date_create('2023-03-22'));
    
                // dd($diff_days);
    
                // $notification = Notification::where('user_id', $request->id)->where('postcode', $addressIs->postcode)->latest()->first();
                $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', $user->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();
                // dd($notification1);
                if ($notification1 > 0) {
    
                    $consolidate_order_number = $notification->consolidate_order_no;
                    $delivery_date = $notification->delivery_date;
                    $end_date = $notification->end_date;
                    $payment_mode = $notification->payment_mode;
    
                    $data['order_no'] = $consolidate_order_number;
                    Notification::create([
                        'consolidate_order_no'  => $consolidate_order_number,
                        'address_id'            => $addressIs->id,
                        'postcode'              => $addressIs->postcode,
                        'user_id'               => $user->id,
                        'order_no'              => $order_number,
                        'delivery_date'         => $delivery_date,
                        'end_date'              => $end_date,
                        'payment_mode'          => $payment_mode,
                    ]);
                } else {
                    $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
                    $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();
    
                    if ($consolidate_order_number == null or $consolidate_order_number == "") {
    
                        $consolidate_order_number = 'LFKODCC' . $year . $month . '00001';
                    } else {
                        $number = str_replace('LFKODCC', '', $consolidate_order_number);
                        $consolidate_order_number =  "LFKODCC" . $year . $month . sprintf("%04d", $consolidate_order_number1 + 1);
                    }
    
                    // dd($consolidate_order_number);
                    $data['order_no'] = $consolidate_order_number;
    
                    Notification::create([
                        'consolidate_order_no'  => $consolidate_order_number,
                        'address_id'            => $addressIs->id,
                        'postcode'              => $addressIs->postcode,
                        'user_id'               => $user->id,
                        'order_no'              => $order_number,
                        'payment_mode'          => 'COD',
                        'delivery_date'         => $request->delivery_date,
                    ]);
                }
            }else{
                $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
                    $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();
    
                    if ($consolidate_order_number == null or $consolidate_order_number == "") {
    
                        $consolidate_order_number = 'LFKODCC' . $year . $month . '00001';
                    } else {
                        $number = str_replace('LFKODCC', '', $consolidate_order_number);
                        $consolidate_order_number =  "LFKODCC" . $year . $month . sprintf("%04d", $consolidate_order_number1 + 1);
                    }
    
                    // dd($consolidate_order_number);
                    $data['order_no'] = $consolidate_order_number;
    
                    Notification::create([
                        'consolidate_order_no'      => $consolidate_order_number,
                        'address_id'                => $addressIs->id,
                        'postcode'                  => $addressIs->postcode,
                        'user_id'                   => $user->id,
                        'order_no'                  => $order_number,
                        'payment_mode'              => 'COD',
                        'delivery_date'             => $request->delivery_date,
                    ]);
            }
    
                $payment = UserOrderPayment::create([
                    'buyer_name'        => $user->name,
                    'buyer_phone'       => $request->mobileNo,
                    'payment_type'      => 'COD',
                    'time'              => now(),
                    'amount'            => $request->amount,
                    'currency'          => 'sgd',
                    'status'            => 'succeeded',
                ]);
    
                // $user = User::find($request->id);
    
                $order_sum = 0;
                $shipping_charge = 0;
    
                foreach ($request->product_id as $key => $value) {
                    $order_sum += $request->sub_total[$key];
                }
    
                if ($order_sum > 70) {
                    $shipping_charge = 0;
                } else {
                    $shipping_charge = 8;
                }
    
    
                UserOrder::create([
                    'payment_id'    => $payment->id,
                    'payment_refrence_id'    => "COD",
                    'name'          => $request->recipientName,
                    'email'         => $user->email,
                    'mobile_no'     => $request->mobileNo,
                    'address'       => $addressIs->id,
                    'postcode'      => $request->postcode,
                    'country'       => $request->country != null ? $request->country : "singapore",
                    'state'         => $request->state != null ? $request->state : "singapore",
                    'city'          => $request->city != null ? $request->city : "singapore",
                    'final_price'        => ($order_sum + (int)$shipping_charge),
                    'order_no'           => $order_number,
                    'consolidate_order_no' => $consolidate_order_number,
                    'user_id'            => $user->id,
                    'status'             => 0,
                    'total_product_price' => $order_sum,
                    'ship_charge'   => $shipping_charge,
                ]);
    
                $cart = [];
    
                foreach ($request->product_id as $key => $value) {
                    if(!empty($value)){
                        $product = product::where('id', $value)->first();

                        $total_product = $product->min_sale_price;
                        $offer_discount_price       = 0;
                        $offer_discount_percentage  = 0;
                        $offer_discount_type        = '';
                        $offer_discount_face_value  = 0;
        
                        UserOrderItem::create([
                            'user_id'       => $user->id,
                            'order_no'      => $order_number,
                            'consolidate_order_no' => $consolidate_order_number,
                            'product_id'    => $product->id,
                            'product_name'  => $product->product_name,
                            'barcode'       => $product->barcode,
                            'product_image' => $product->img_path,
                            'quantity'      => $request->quantity[$key],
                            'product_price' => $product->min_sale_price,
                            'total_price'   => $product->min_sale_price * $request->quantity[$key],
                            'after_discount' => $product->min_sale_price * $request->quantity[$key],
                            // 'after_discount' => $total_product * $item['quantity'],
                            'offer_discount_price' => $offer_discount_price,
                            'offer_discount_percentage' => $offer_discount_percentage,
                            'offer_discount_type' => $offer_discount_type,
                            'offer_discount_face_value' => $offer_discount_face_value
                        ]);
        
                        $obj = [
                            "product_id"    => $request->pid,
                            "image"         => $product->img_path,
                            "product_name"  => $product->product_name,
                            "barcode"       => $product->barcode,
                            "product_price" => $product->min_sale_price,
                            "product_cat"   => $product->product_category,
                            "use_id"        => $request->id,
                            "use_name"      => $request->customerName,
                            "quantity"      => $request->quantity[$key],
                            "total_price"   => $product->min_sale_price * $request->quantity[$key],
                            "created_at"    => now(),
                        ];
        
                        array_push($obj, $cart);
                    }
                }
    
                $date  = Carbon::now();
                $order_date = $date->toDateString();
                $allProductDetails = json_encode($cart);
    
                Order::insert([
                    "owner_id" => $user->id,
                    "order_by" => 'self',
                    "quotation_id" => NULL,
                    "order_number" => $order_number,
                    "customer_name" => $user->name,
                    "customer_id" => $user->id,
                    "date" => $order_date,
                    "customer_address" => $addressIs->address,
                    "customer_type" => 'retail',
                    "mobile_no" => $request->mobileNo,
                    "email_id" => $user->email,
                    "tax" => '0',
                    "shipping_type" => 'delivery',
                    "products_details" => $allProductDetails,
                    "tax_inclusive" => '0',
                    "untaxted_amount" => $order_sum,
                    "GST" => '',
                    "sub_total" => $order_sum,
                    "created_at" => now(),
                ]);
    
            return redirect()->route('SA-CustomerManagement')->with('success', 'Order is successfully ordered');
        
    
    }

        // update order
    public function updateOrder2(Request $request){
            
            request()->validate([
                'customerName' => 'required',
                'recipientName' => 'required',
                'postcode' => 'required',
                'address' => 'required',
                'unit' => 'required',
                'mobileNo' => 'required',
                'delivery_date' => 'required|date_format:d/m/Y',
                'product_id' => 'required'
            ]);
    
            $user = User::find($request->customer_id);
    
            if(strlen($request->address) > 1){
                $address = address::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'postcode' => $request->postcode,
                    'address' => $request->address,
                    'unit' => $request->unit,
                    'mobile_number' => $request->mobileNo
                ]);
                $addressIs = address::find($address->id);
            }else{
                $addressIs = address::find($request->address);
            }
                    Notification::where('consolidate_order_no', $request->consolidate_order_no)->update([
                        'address_id' => $addressIs->id,
                        'postcode' => $addressIs->postcode,
                        'user_id' => $user->id,
                        'delivery_date' => request()->delivery_date,
                        'end_date' => request()->delivery_date,
                    ]);
                
    
                $payment = UserOrderPayment::create([
                    'buyer_name' => $user->name,
                    'buyer_phone' => $request->mobileNo,
                    'payment_type' => 'COD',
                    'time' => now(),
                    'amount' => $request->amount,
                    'currency' => 'sgd',
                    'status' => 'succeeded',
                ]);
    
                // $user = User::find($request->id);
    
                $order_sum = 0;
    
                foreach ($request->product_id as $key => $value) {
                    $order_sum += $request->sub_total[$key];
                }
    
                $cart = [];
                $current_order_no = '';
                $prev_order_no = '';

                UserOrderItem::where('consolidate_order_no', $request->consolidate_order_no)->delete();
    
                foreach ($request->product_id as $key => $value) {
                    $product = product::where('id', $request->product_id[$key])->first();
    
                    $total_product = $product->min_sale_price;
                    $offer_discount_price       = 0;
                    $offer_discount_percentage  = 0;
                    $offer_discount_type        = '';
                    $offer_discount_face_value  = 0;
    
                    // if($request->list_id[$key] != null){

                        // UserOrderItem::where('id', $request->list_id[$key])->update([
                        //     'user_id'       => $user->id,
                        //     'product_id'    => $product->id,
                        //     'product_name'  => $product->product_name,
                        //     'barcode'       => $product->barcode,
                        //     'product_image' => $product->img_path,
                        //     'quantity'      => $request->quantity[$key],
                        //     'product_price' => $product->min_sale_price,
                        //     'total_price'   => $product->min_sale_price * $request->quantity[$key],
                        //     'after_discount' => $product->min_sale_price * $request->quantity[$key],
                        //     // 'after_discount' => $total_product * $item['quantity'],
                        //     'offer_discount_price' => $offer_discount_price,
                        //     'offer_discount_percentage' => $offer_discount_percentage,
                        //     'offer_discount_type' => $offer_discount_type,
                        //     'offer_discount_face_value' => $offer_discount_face_value
                        // ]);

                    // }else{

                        $order_number = UserOrder::orderBy('id', 'DESC')->pluck('order_no')->first();
                        $order_number1 = UserOrder::orderBy('id', 'DESC')->pluck('id')->first();
                
                        $now = new \DateTime('now');
                        $month = $now->format('m');
                        $year = $now->format('Y');
                
                        if ($order_number == null or $order_number == "") {
                            $order_number = 'LFKODC' . $year . $month . '00001';
                        } else {
                            $number = str_replace('LFKODC', '', $order_number);
                            $order_number =  "LFKODC" . $year . $month . sprintf("%04d", $order_number1 + 1);
                        }

                        UserOrderItem::create([
                            'user_id'       => $user->id,
                            'order_no'      => $order_number,
                            'consolidate_order_no' => $request->consolidate_order_no,
                            'product_id'    => $product->id,
                            'product_name'  => $product->product_name,
                            'barcode'       => $product->barcode,
                            'product_image' => $product->img_path,
                            'quantity'      => $request->quantity[$key],
                            'product_price' => $product->min_sale_price,
                            'total_price'   => $product->min_sale_price * $request->quantity[$key],
                            'after_discount' => $product->min_sale_price * $request->quantity[$key],
                            // 'after_discount' => $total_product * $item['quantity'],
                            'offer_discount_price' => $offer_discount_price,
                            'offer_discount_percentage' => $offer_discount_percentage,
                            'offer_discount_type' => $offer_discount_type,
                            'offer_discount_face_value' => $offer_discount_face_value
                        ]);
                    // }

                    $prev_order_no = $current_order_no;
                    $current_order_no = $request->list_order_no;

                    if($prev_order_no != $current_order_no){

                        $date  = Carbon::now();
                        $order_date = $date->toDateString();
                        $allProductDetails = json_encode($cart);
            
                        Order::where('order_number', $current_order_no)->update([
                            "owner_id" => $user->id,
                            "order_by" => 'self',
                            "quotation_id" => NULL,
                            "order_number" => $current_order_no,
                            "customer_name" => $user->name,
                            "customer_id" => $user->id,
                            "date" => $order_date,
                            "customer_address" => $addressIs->address,
                            "customer_type" => 'retail',
                            "mobile_no" => $request->mobileNo,
                            "email_id" => $user->email,
                            "tax" => '0',
                            "shipping_type" => 'delivery',
                            "products_details" => $allProductDetails,
                            "tax_inclusive" => '0',
                            "untaxted_amount" => $order_sum,
                            "GST" => '',
                            "sub_total" => $order_sum,
                            "created_at" => now(),
                        ]);

                        $cart = (array)null;

                    }else{

                        $obj = [
                            "product_id"    => $product->id,
                            "image"         => $product->img_path,
                            "product_name"  => $product->product_name,
                            "barcode"       => $product->barcode,
                            "product_price" => $product->min_sale_price,
                            "product_cat"   => $product->product_category,
                            "use_id"        => $user->id,
                            "use_name"      => $request->customerName,
                            "quantity"      => $request->quantity[$key],
                            "total_price"   => $product->min_sale_price * $request->quantity[$key],
                            "created_at"    => now(),
                        ];
        
                        array_push($obj, $cart);
                    }

                }
    
            return redirect()->route('SA-CustomerManagement')->with('success', 'Order is successfully updated');
        
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'customerName' => 'required',
            'recipientName' => 'required',
            'postcode' => 'required',
            'address' => 'required',
            'unit' => 'required',
            'mobileNo' => 'required',
            'delivery_date' => 'required|date_format:d/m/Y',
            'product_id' => 'required'
        ]);

        if(strlen($request->address) > 1){
            $address = address::create([
                'user_id' => $request->id,
                'name' => $request->customerName,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'unit' => $request->unit,
                'mobile_number' => $request->mobileNo
            ]);
            $addressIs = address::find($address->id);
        }else{
            $addressIs = address::find($request->address);
        }

        // dd($checkAddress);

        $date = date('Y-m-d');

        $checkAddress = Notification::where('user_id', $request->id)->where('postcode', $addressIs->postcode)->latest()->first();
        // dd($checkAddress);

        $notification1 = Notification::where('user_id', $request->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
        // dd($notification);

        $order_number = UserOrder::orderBy('id', 'DESC')->pluck('order_no')->first();
        $order_number1 = UserOrder::orderBy('id', 'DESC')->pluck('id')->first();

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        if ($order_number == null or $order_number == "") {
            $order_number = 'LFKODC' . $year . $month . '00001';
        } else {
            $number = str_replace('LFKODC', '', $order_number);
            $order_number =  "LFKODC" . $year . $month . sprintf("%04d", $order_number1 + 1);
        }

        if ($checkAddress != null) {

            $prev_delivery_date = implode('-', array_reverse(explode('/', $checkAddress->delivery_date)));

            $diff_days = date_diff(date_create($prev_delivery_date),date_create('2023-03-22'));

            // dd($diff_days);

            $notification = Notification::where('user_id', $request->id)->where('postcode', $addressIs->postcode)->latest()->first();

            if ($notification1 > 0) {

                $consolidate_order_number = $notification->consolidate_order_no;
                $delivery_date = $notification->delivery_date;
                $end_date = $notification->end_date;
                $payment_mode = $notification->payment_mode;

                $data['order_no'] = $consolidate_order_number;
                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => $addressIs->id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => $request->id,
                    'order_no' => $order_number,
                    'delivery_date' => $delivery_date,
                    'end_date' => $end_date,
                    'payment_mode' => $payment_mode,
                ]);
            } else {
                $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
                $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();

                if ($consolidate_order_number == null or $consolidate_order_number == "") {

                    $consolidate_order_number = 'LFKODCC' . $year . $month . '00001';
                } else {
                    $number = str_replace('LFKODCC', '', $consolidate_order_number);
                    $consolidate_order_number =  "LFKODCC" . $year . $month . sprintf("%04d", $consolidate_order_number1 + 1);
                }

                // dd($consolidate_order_number);
                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => $addressIs->id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => $request->id,
                    'order_no' => $order_number,
                    'payment_mode' => 'COD',
                    'delivery_date' => $request->delivery_date,
                ]);
            }
        }else{
            $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
                $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();

                if ($consolidate_order_number == null or $consolidate_order_number == "") {

                    $consolidate_order_number = 'LFKODCC' . $year . $month . '00001';
                } else {
                    $number = str_replace('LFKODCC', '', $consolidate_order_number);
                    $consolidate_order_number =  "LFKODCC" . $year . $month . sprintf("%04d", $consolidate_order_number1 + 1);
                }

                // dd($consolidate_order_number);
                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => $addressIs->id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => $request->id,
                    'order_no' => $order_number,
                    'payment_mode' => 'COD',
                    'delivery_date' => $request->delivery_date,
                ]);
        }

            $payment = UserOrderPayment::create([
                'buyer_name' => $request->customerName,
                'buyer_phone' => $request->mobileNo,
                'payment_type' => 'COD',
                'time' => now(),
                'amount' => $request->amount,
                'currency' => 'sgd',
                'status' => 'succeeded',
            ]);

            $user = User::find($request->id);

            $order_sum = 0;
            $shipping_charge = 0;

            foreach ($request->product_id as $key => $value) {
                $order_sum += $request->sub_total[$key];
            }

            if ($order_sum > 70) {
                $shipping_charge = 0;
            } else {
                $shipping_charge = 8;
            }


            UserOrder::create([
                'payment_id'    => $payment->id,
                'payment_refrence_id'    => "COD",
                'name'          => $request->recipientName,
                'email'         => $user->email,
                'mobile_no'     => $request->mobileNo,
                'address'       => $addressIs->id,
                'postcode'      => $request->postcode,
                'country'       => $request->country != null ? $request->country : "singapore",
                'state'         => $request->state != null ? $request->state : "singapore",
                'city'          => $request->city != null ? $request->city : "singapore",
                'final_price'        => ($order_sum + (int)$shipping_charge),
                'order_no'           => $order_number,
                'consolidate_order_no' => $consolidate_order_number,
                'user_id'            => $request->id,
                'status'             => 0,
                'total_product_price' => $order_sum,
                'ship_charge'   => $shipping_charge,
            ]);

            $cart = [];

            foreach ($request->product_id as $key => $value) {
                $product = product::where('id', $request->product_id[$key])->first();

                $total_product = $product->min_sale_price;
                $offer_discount_price       = 0;
                $offer_discount_percentage  = 0;
                $offer_discount_type        = '';
                $offer_discount_face_value  = 0;

                UserOrderItem::create([
                    'user_id'       => $request->id,
                    'order_no'      => $order_number,
                    'consolidate_order_no' => $consolidate_order_number,
                    'product_id'    => $product->id,
                    'product_name'  => $product->product_name,
                    'barcode'       => $product->barcode,
                    'product_image' => $product->img_path,
                    'quantity'      => $request->quantity[$key],
                    'product_price' => $product->min_sale_price,
                    'total_price'   => $product->min_sale_price * $request->quantity[$key],
                    'after_discount' => $product->min_sale_price * $request->quantity[$key],
                    // 'after_discount' => $total_product * $item['quantity'],
                    'offer_discount_price' => $offer_discount_price,
                    'offer_discount_percentage' => $offer_discount_percentage,
                    'offer_discount_type' => $offer_discount_type,
                    'offer_discount_face_value' => $offer_discount_face_value
                ]);

                $obj = [
                    "product_id"    => $request->pid,
                    "image"         => $product->img_path,
                    "product_name"  => $product->product_name,
                    "barcode"       => $product->barcode,
                    "product_price" => $product->min_sale_price,
                    "product_cat"   => $product->product_category,
                    "use_id"        => $request->id,
                    "use_name"      => $request->customerName,
                    "quantity"      => $request->quantity[$key],
                    "total_price"   => $product->min_sale_price * $request->quantity[$key],
                    "created_at"    => now(),
                ];

                array_push($obj, $cart);
            }

            $date  = Carbon::now();
            $order_date = $date->toDateString();
            $allProductDetails = json_encode($cart);

            Order::insert([
                "owner_id" => $request->id,
                "order_by" => 'self',
                "quotation_id" => NULL,
                "order_number" => $order_number,
                "customer_name" => $request->customerName,
                "customer_id" => $request->id,
                "date" => $order_date,
                "customer_address" => $addressIs->address,
                "customer_type" => 'retail',
                "mobile_no" => $request->mobileNo,
                "email_id" => $user->email,
                "tax" => '0',
                "shipping_type" => 'delivery',
                "products_details" => $allProductDetails,
                "tax_inclusive" => '0',
                "untaxted_amount" => $order_sum,
                "GST" => '',
                "sub_total" => $order_sum,
                "created_at" => now(),
            ]);

        return redirect()->route('SA-CustomerManagement')->with('success', 'Order is successfully ordered');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = User::find($id);
        $addresses = address::where('user_id', $id)->get();
        $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
            ->select('stocks.*', 'products.img_path', 'products.chinese_product_name as product_name_c', 'products.category_id', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))
            ->where('stocks.quantity', '>', 0)
            ->groupBy('stocks.product_id')
            ->get();

        return view('superadmin.backend_order.order', compact('customer', 'addresses', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_order_details = UserOrder::where('consolidate_order_no', $id)->first();

        $notification = Notification::where('consolidate_order_no', $id)->first();

        $address = address::find($notification->address_id);
    
        $addresses = address::where('user_id', $user_order_details->user_id)->get();

        $customer = Customer::where('customer_id', $user_order_details->user_id)->first();

        $user_ordered_item = UserOrderItem::where('consolidate_order_no', $id)->get();
        // dd($user_ordered_item[0]->product_price);

        $products = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->select('stocks.*', 'products.img_path', 'products.chinese_product_name as product_name_c', 'products.category_id', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))
            ->where('stocks.quantity', '>', 0)
            ->groupBy('stocks.product_id')
            ->get();

        return view('superadmin.backend_order.edit_order', compact('user_order_details', 'notification','address', 'addresses', 'customer', 'user_ordered_item', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::where('consolidate_order_no', $id)->select('order_no')->get();

        foreach($notification as $key=>$value){
            Order::where('order_number', $value->order_no)->delete();
            UserOrderItem::where('order_no', $value->order_no)->delete();
            UserOrder::where('order_no', $value->order_no)->delete();
            Notification::where('order_no', $value->order_no)->delete();
        }
        // $notification->delete();
        return redirect()->route('SA-CustomerManagement')->with('success', 'Order is successfully Removed');   
    }
}
