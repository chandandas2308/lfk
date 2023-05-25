<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\cart;
use App\Models\Category;
use App\Models\ConsolidateConfig;
use App\Models\Cupon;
use App\Models\DriverDate;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointshop;
use App\Models\LoyaltyPointTodays;
use App\Models\Notification;
use App\Models\OfferPackages;
use App\Models\Order;
use App\Models\VoucherHistory;
use App\Models\product;
use Illuminate\Support\Facades\View;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use App\Models\UserOrderPayment;
use App\Models\Stock;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\session as ModelsSession;
use App\Models\TrackStockDeductDetails;
use App\Models\Voucher;
use App\Models\VoucherCode;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{

    public function __construct()
    {
       $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
        ->select('stocks.*','products.id as main_product_id','products.img_path','products.product_category','products.chinese_product_name as product_name_c', 'products.category_id', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))
        ->where('stocks.quantity', '>=', 0)
        ->groupBy('stocks.product_id')
        ->get();
        $categories = Category::all();

        View::share('products', $products);
        View::share('categories', $categories);
    }
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
        
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        $client = new Client();
        
        
        // https://api.sandbox.hit-pay.com/v1/payment-requests //testing api
        // https://api.hit-pay.com/v1/payment-requests/ // main api
        $res = $client->request('GET', 'https://api.hit-pay.com/v1/payment-requests/'.$request->reference, [
            'headers' => [
                'X-BUSINESS-API-KEY'=> env('HIT_PAY_API_KEY'),
                'Content-Type'=> 'application/x-www-form-urlencoded',
                'X-Requested-With'=> 'XMLHttpRequest',
            ]
        ]);

        $data = json_decode($res->getBody(),true);

        if($request->status == 'completed'){
            
            $products = cart::where('use_id', Auth::user()->id)->get();

            $order_sum = 0;
            $cart = [];
            $date = Carbon::now();
    
            foreach ($products as $key => $value) {
                $proId = $value['product_id'];
                $pro = product::where("id", $proId)->get();
    
                foreach ($pro as $k => $v) {
                    $obj = [
                        "id" => $value['id'],
                        "product_id" => $v['id'],
                        "image" => $v['img_path'],
                        "product_name" => $v['product_name'],
                        'barcode'       => $v['barcode'],
                        "product_price" => $v['min_sale_price'],
                        "product_cat" => $v['product_category'],
                        "use_id" => Auth::user()->id,
                        "use_name" => Auth::user()->name,
                        "quantity" => $value['quantity'],
                        "total_price" => $v['min_sale_price'] * $value['quantity'],
                    ];
                    array_push($cart, $obj);
                    // $order_sum += (float)$v['min_sale_price'] * $value['quantity'];
                }
    
                $product = product::where('id',$value->product_id)->first();
                if($product->discount_price > 0){
                    if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                        $order_sum += $product->discount_price * $value->quantity;
                    }  
                    else{
                        $order_sum += $product->min_sale_price * $value->quantity;
                    }
                }else{
                    $order_sum += $product->min_sale_price * $value->quantity;
                }
            }
    
            // $order_number = random_int(100000, 999999);
            $data['total_product_price'] = cart::where('use_id', Auth::user()->id)->sum('total_price');
            $store = $data['total_product_price'];
            $total_product_price = cart::where('use_id', Auth::user()->id)->sum('total_price');
    
            // 
            $coupon_data = Cupon::where('coupon',$request->coupon)->first();
            $user_data = UserOrder::where('coupon_code',$request->coupon)->where('user_id',Auth::user()->id)->get();
           
            $cart_data = Cart::where('use_id',Auth::user()->id)->get();
            $cart_sum = Cart::where('use_id', Auth::user()->id)->sum('total_price');
            
            $item_price = 0;
            $discount_price = 0;
            $coupon_amount = 0;
            $discount_amount = 0;
            $coupon_type = '';
            $coupon_code = null;
            $total_product = 0;
    
            // foreach($cart_data as $item){
            //     // $stocks = Stock::where('product_id', $item->product_id)->first();
            //     // $prevStockQty = $stocks->quantity;
            //     // Stock::where('product_id', $item->product_id)->first()->update([
            //     //     'quantity' => ($prevStockQty-$item->quantity)
            //     // ]);

            //     $remaining = 0;
            //     $stocks = Stock::where('product_id', $item->product_id)->where('quantity','!=',0)->get();
            //     $total_stock_deduct = $item->quantity;
            //     foreach($stocks as $stock){
            //         $prevStockQty = $stock->quantity;

            //         if($remaining == 0 && $total_stock_deduct != 0){
            //             if($prevStockQty >= $item->quantity){
            //                 $deduct = $prevStockQty-$item->quantity;
            //                 $total_stock_deduct = 0;
            //                 $remaining = 0;
            //             }else{
            //                 // $deduct = $item->quantity - $prevStockQty;
            //                 $deduct = 0;
            //                 $remaining = $item->quantity - $prevStockQty;
            //             }
            //         }else{
            //             if($prevStockQty >= $remaining ){
            //                 $deduct = $prevStockQty - $remaining;
            //                 $total_stock_deduct = 0;
            //                 $remaining = 0;
            //             }else{
            //                 $remaining = $remaining - $prevStockQty;
            //             }
            //         }
            //         Stock::where('id', $stock->id)->update([
            //             'quantity' => $deduct
            //         ]);
                    
            //     }

            // }

            $voucherCode = VoucherCode::where('code', $request->coupon)->count();
            $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();


            if($voucherCode > 0){
                $voucher_id = $voucherCode1->voucher_id;
                $discount = Voucher::find($voucher_id);
    
                if ($date->toDateString() <= $discount->expiry_date){
                    VoucherCode::where('id', $voucher_id)->update([
                        'status' => true,
                    ]);

                    if ($discount->discount_type == 'discount_by_value_btn') {
                        $item_price = $cart_sum - $discount->discount;

                        $coupon_type = "voucher";
                        $coupon_amount = $discount->discount;
                        $discount_amount = $discount->discount;
                    } else {
                        $discount_price = ($cart_sum * $discount->discount) / 100;
                        $item_price = $cart_sum - $discount_price;

                        $coupon_type = "voucher";
                        $coupon_amount = $discount->discount;
                        $discount_amount = $discount_price;                        
                    }
                }else{
                    $error = 'Your Coupon Expired!';   
                }
    
            }else{
        
                if($coupon_data && !empty($request->coupon)){
                    if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon){
                        if($coupon_data->limit > $user_data->count()){
                            if($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
                                $coupon_code = $request->coupon;
                                
                                $change_use = Cupon::where('coupon',$request->coupon)->first();
                                Cupon::where('coupon',$request->coupon)->update([
                                    'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
                                ]);
                                foreach($cart_data as $item){
        
                                    $product = product::where('id',$item->product_id)->first();
                                    if($product->discount_price > 0){
                                        if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                            $total_product   = $product->discount_price*$item->quantity;                            
                                        }  
                                        else{
                                            $total_product = $product->min_sale_price*$item->quantity;
                                        }
                                    }else{
                                        $total_product = $product->min_sale_price*$item->quantity;
                                    }
        
        
                                    if($coupon_data->merchendise_btn == 'some_product'){
                                        $product = json_decode($coupon_data->merchendise);
                                        if(in_array($item->product_id,$product)){
                                            if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                                $item_price += $total_product - $coupon_data->face_value;
                                                
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                // $discount_amount += $total_product - $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
                                            }else{
                                                $discount_price = ($total_product * $coupon_data->face_value)/100;
                                                $item_price    += $total_product - $discount_price;
                                                
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }   
                                        }else{
                                            $item_price += $total_product;
                                        }
                                    }else if($coupon_data->merchendise_btn == 'category_product'){
                                        $product = json_decode($coupon_data->merchendise);
                                        $category = product::where('id',$item->product_id)->first();
                                        if(in_array($category->category_id,$product)){
                                            if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                                $item_price += $total_product - $coupon_data->face_value;
        
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                // $discount_amount += $total_product - $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
        
                                            }else{
                                                $discount_price = ($total_product * $coupon_data->face_value)/100;
                                                $item_price    += $total_product - $discount_price;
        
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }   
                                        }else{
                                            $item_price += $total_product;
                                        }
                                        
                                    }else{
                                        if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                            $item_price += $total_product - $coupon_data->face_value;
        
                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            // $discount_amount += $total_product - $coupon_data->face_value;
                                            $discount_amount += $coupon_data->face_value;
                                        }else{
                                            $discount_price = ($total_product * $coupon_data->face_value)/100;
                                            $item_price    += $total_product - $discount_price;
        
                                            
                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            $discount_amount += $discount_price;
                                        
        
                                        }   
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $item_price = $order_sum;
                }
            }
    
 
        $order_sum = $item_price;
           
        $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());

        $session_data = ModelsSession::where('id', Session::getId())->first();

        $addressIs = address::find($session_data->address_id);

        // $checkAddress = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
        
        // dd($notification);

        $order_number = UserOrder::orderBy('id', 'DESC')->pluck('order_no')->first();
        $order_number1 = UserOrder::orderBy('id', 'DESC')->pluck('id')->first();

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        if ($order_number == null or $order_number == "") {             
            $order_number = 'LFKODC'.$year.$month.'00001';
        } else {
            $number = str_replace('LFKODC', '', $order_number);
            $order_number =  "LFKODC" .$year.$month. sprintf("%04d", $order_number1 + 1);
        }

        $addressIs = address::find($session_data->address_id);

        $date2 = date('Y-m-d');

        // $user_last_order = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();

        if(!empty($user_last_order)){

            $last_order_date = $user_last_order->delivery_date;

                $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

                $consolidate_order_is = '';

                if ($last_order_date_format > $date2) {

                    // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date("Y/m/d"))->first();
                // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
                $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();

                    $consolidate_order_number = $notification->consolidate_order_no;
                    $delivery_date = $notification->delivery_date;
                    $end_date = $notification->end_date;
                    $payment_mode = $notification->payment_mode;
            
                    $data['order_no'] = $consolidate_order_number;

                    Notification::create([
                        'consolidate_order_no' => $consolidate_order_number,
                        'address_id' => $session_data->address_id,
                        'postcode' => $addressIs->postcode,
                        'user_id' => Auth::user()->id,
                        'order_no' => $order_number,
                        'delivery_date' => $delivery_date,
                        'end_date' => $end_date,
                        'payment_mode' => $payment_mode,
                        'remark' => $session_data->remark,
                    ]);       
                }else{
                    $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();

                        if ($consolidate_order_number == null or $consolidate_order_number == "") {
                            
                            $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                        } else {
                            $number = str_replace('LFKODCC', '', $consolidate_order_number);
                            $consolidate_order_number =  "LFKODCC" . sprintf("%04d", $number + 1);
                        }

                    $data['order_no'] = $consolidate_order_number;
                    Notification::create([
                        'consolidate_order_no' => $consolidate_order_number,
                        'address_id' => $session_data->address_id,
                        'postcode' => $addressIs->postcode,
                        'user_id' => Auth::user()->id,
                        'order_no' => $order_number,
                        'payment_mode' => 'hitpay',
                        'delivery_date' => $session_data->delivery_date,
                        'remark' => $session_data->remark,
                    ]);
                }

            } else {

                $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();

                        if ($consolidate_order_number == null or $consolidate_order_number == "") {
                            
                            $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                        } else {
                            $number = str_replace('LFKODCC', '', $consolidate_order_number);
                            $consolidate_order_number =  "LFKODCC" . sprintf("%04d", $number + 1);
                        }

                $data['order_no'] = $consolidate_order_number;
                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => $session_data->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => Auth::user()->id,
                    'order_no' => $order_number,
                    'payment_mode' => 'hitpay',
                    'delivery_date' => $session_data->delivery_date,
                    'remark' => $session_data->remark,
                ]);
            }
        // } else {

        //     $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();

        //             if ($consolidate_order_number == null or $consolidate_order_number == "") {
                        
        //                 $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
        //             } else {
        //                 $number = str_replace('LFKODCC', '', $consolidate_order_number);
        //                 $consolidate_order_number =  "LFKODCC" . sprintf("%04d", $number + 1);
        //             }

        //     $data['order_no'] = $consolidate_order_number;
        //     Notification::create([
        //         'consolidate_order_no' => $consolidate_order_number,
        //         'address_id' => $session_data->address_id,
        //         'postcode' => $addressIs->postcode,
        //         'user_id' => Auth::user()->id,
        //         'order_no' => $order_number,
        //         'payment_mode' => 'hitpay',
        //         'delivery_date' => $session_data->delivery_date,
        //         'remark' => $session_data->remark,
        //     ]);
        // }

        

             

            foreach($data["payments"] as $key => $value){
                $payment=UserOrderPayment::create([
                    'payment_id' => $value["id"],
                    'payment_request_id'=> $value["id"],
                    // 'phone'=> $request->phone,
                    'buyer_name'=> $value["buyer_name"],
                    'buyer_phone'=> $value["buyer_phone"],
                    'buyer_email'=> $value["buyer_email"],
                    'fees'=> $value["fees"],
                    'payment_type'=> $value["payment_type"],
                    'time'=> $value["created_at"],
                    'amount'=> $value["amount"],
                    'currency'=> $value["currency"],
                    'status'=> $value["status"],
                    'reference_number'=> $request->reference,
                    // 'hmac'=> $request->hmac,
                    // 'all_data' => $request->all()
                ]);
                
                
                $data = LoyaltyPointTodays::all()->first();
                $amount = $data->amount;
                $points = $data->points;

                // dd($amount, $points);

                $one_dollar_points = $points/$amount;

                $bill_amount = (float)$value["amount"];
                // dd($bill_amount);

                $gain_points = $bill_amount*$one_dollar_points;

                $loyalty_wallet = ($session_data->loyalty_points-$request->paid_points)+$gain_points;

                LoyaltyPoint::create([
                    'user_id' => Auth::user()->id,
                    'gained_points' => $gain_points,
                    'spend_points' => $request->paid_points,
                    'remains_points' => $loyalty_wallet,
                    'transaction_id' => $payment->id,
                    'transaction_amount' => $request->reference,
                    'transaction_date' => $value["created_at"],
                    "log"   => 'Purchase Order'
                ]);

                LoyaltyPointshop::updateOrCreate(
                    ['user_id' => Auth::user()->id],
                    ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => $payment->id]
                );

            }

            // $consolidate_date = Carbon::now()->addDays($days);
            // $data['end_date'] = $consolidate_date;
            $user_id_is = Auth::user()->id;
    
            $data['payment_id']    = $payment->id;
            $data['payment_refrence_id']    = $request->reference;

            $data['name']          = $request->name;
            $data['email']         = Auth::user()->email;
            $data['mobile_no']     = $request->mobile_no;
            $data['address']       = $request->address;
            $data['postcode']      = $request->postcode;
            $data['country']       = $request->country;
            $data['state']         = $request->state;
            $data['city']          = $request->city;     
            $data['final_price']        = $order_sum;
            $data['order_no']           = $order_number;
            $data['user_id']            = Auth::user()->id;
            $data['coupon_code']        = $coupon_code;
            $data['discount_amount']    = $discount_amount;
            $data['coupon_amount']      = $coupon_amount;
            $data['coupon_type']        = $coupon_type;
            $data['status']             = 0;
            // UserOrder::create($data);

            UserOrder::create([
                // 'end_date' => $consolidate_date,
                'payment_id'    => $payment->id,
                'payment_refrence_id'    => $request->reference,
                'name'          => $request->name,
                'email'         => Auth::user()->email,
                'mobile_no'     => $request->mobile_no,
                'address'       => $request->address,
                'postcode'      => $request->postcode,
                'country'       => $request->country!=null?$request->country:"singapore",
                'state'         => $request->state !=null?$request->state:"singapore",
                'city'          => $request->city !=null?$request->city:"singapore",
                // 'final_price'        => ($order_sum+(int)$request->ship_charge),
                'final_price'   => ($order_sum+(int)$request->ship_charge)-(int)$discount_amount,
                'order_no'           => $order_number,
                'consolidate_order_no' => $consolidate_order_number,
                'user_id'            => $user_id_is,
                'coupon_code'        => $coupon_code,
                'discount_amount'    => $discount_amount,
                'coupon_amount'      => $coupon_amount,
                'coupon_type'        => $coupon_type,
                'status'             => 0,
                'total_product_price' => $total_product_price,
                'ship_charge'   => $request->ship_charge,
            ]);
    
    
    
    
            $item_price = 0;
            $discount_price = 0;
            $coupon_amount = 0;
            $discount_amount = 0;
            $coupon_type = '';
            $coupon_code = null;
            $total_product = 0;
    
            $offer_discount_price = 0;
            $offer_discount_percentage = 0;
            $offer_discount_type = '';
            $offer_discount_face_value = 0;
            
            $voucherCode = VoucherCode::where('code', $session_data->coupon)->count();
            $voucherCode1 = VoucherCode::where('code', $session_data->coupon)->first();

            if($voucherCode > 0){
                $voucher_id = $voucherCode1->voucher_id;
                $discount = Voucher::find($voucher_id);
    
                if ($date->toDateString() <= $discount->expiry_date){
                                
                        VoucherCode::where('id', $voucher_id)->update([
                            'status' => true,
                        ]);

                        VoucherHistory::create([
                            'code' => $voucherCode1->code,
                            'voucher_id' => $discount->id,
                            'discount_amount' => $session_data->discount_value,
                            'voucher_amount' => $discount->discount,
                            'voucher_type' => $discount->discount_type,
                            'consolidate_order_no' => $consolidate_order_number,
                            'order_no' => $order_number,
                        ]);

                        foreach ($cart as $item) {
                            $product = product::where('id',$item['product_id'])->first();
                                if($product->discount_price > 0){
                                    if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                        $total_product              = $product->discount_price;
                                        
                                        $offer_discount_price       = $product->discount_price *  $item['quantity'];
                                        $offer_discount_percentage  = $product->discount_percentage;
                                        $offer_discount_type        = $product->discount_type;
                                        $offer_discount_face_value  = $product->discount_face_value;
                                    }  
                                    else{
                                        $total_product = $product->min_sale_price;
                                        $offer_discount_price       = 0;
                                        $offer_discount_percentage  = 0;
                                        $offer_discount_type        ='';
                                        $offer_discount_face_value  = 0;
                                    }
                                }else{
                                    $total_product = $product->min_sale_price;
                                    $offer_discount_price       = 0;
                                    $offer_discount_percentage  = 0;
                                    $offer_discount_type        ='';
                                    $offer_discount_face_value  = 0;
                                }
                            UserOrderItem::create([
                                'user_id'       => Auth::user()->id,
                                'order_no'      => $order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $item['product_id'],
                                'product_name'  => $item['product_name'],
                                'barcode'       => $item['barcode'],
                                'product_image' => $item['image'],
                                'quantity'      => $item['quantity'],
                                'product_price' => $item['product_price'],
                                'total_price'   => $item['product_price'] * $item['quantity'],
                                'after_discount' => $item['product_price'] * $item['quantity'],
                                'after_discount' => $total_product * $item['quantity'],
                                'offer_discount_price' => $offer_discount_price,
                                'offer_discount_percentage' => $offer_discount_percentage,
                                'offer_discount_type'=> $offer_discount_type,
                                'offer_discount_face_value' => $offer_discount_face_value
                            ]);
                        }
                    
                }else{
                    $error = 'Your Coupon Expired!';   
                }
    
            }else{

                if($coupon_data && !empty($request->coupon)){
                    $coupon_code = $request->coupon;
                    if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon && $coupon_data->limit > $user_data->count() && $date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
                        foreach($cart_data as $item){
        
        
                            $product = product::where('id',$item->product_id)->first();
                            if($product->discount_price > 0){
                                if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                    $total_product = $product->discount_price*$item->quantity;
                                    $offer_discount_price       = $product->discount_price;
                                    $offer_discount_percentage  = $product->discount_percentage;
                                    $offer_discount_type        = $product->discount_type;
                                    $offer_discount_face_value  = $product->discount_face_value;
                                }  
                                else{
                                    $total_product = $product->min_sale_price*$item->quantity;
                                    $offer_discount_price       = 0;
                                    $offer_discount_percentage  = 0;
                                    $offer_discount_type        = '';
                                    $offer_discount_face_value  = 0;
                                }
                            }else{
                                $total_product = $product->min_sale_price*$item->quantity;
                                $offer_discount_price       = 0;
                                $offer_discount_percentage  = 0;
                                $offer_discount_type        = '';
                                $offer_discount_face_value  = 0;
                            }
        
        
        
                            if($coupon_data->merchendise_btn == 'some_product'){
                                $product = json_decode($coupon_data->merchendise);
                                if(in_array($item->product_id,$product)){
                                    if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                        $item_price = $total_product - $coupon_data->face_value;
                                        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        // $discount_amount = $total_product - $coupon_data->face_value;
                                        $discount_amount = $coupon_data->face_value;
                                    }else{
                                        $discount_price = ($total_product * $coupon_data->face_value)/100;
                                        $item_price    = $total_product - $discount_price;
                                        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        $discount_amount = $discount_price;
                                    }   
        
                                }else{
                                    $item_price = $total_product;
                                    $coupon_code = null;
                                    $discount_amount = 0;
                                    $coupon_amount = 0;
                                    $coupon_type = '';
                                }
                                
                                UserOrderItem::create([
                                    'user_id'       => Auth::user()->id,
                                    'order_no'      => $order_number,
                                    'consolidate_order_no' => $consolidate_order_number,
                                    'product_id'    => $item->product_id,
                                    'product_name'  => $item->product_name,
                                    'barcode'       => $item->barcode,
                                    'product_image' => $item->image,
                                    'quantity'      => $item->quantity,
                                    'product_price' => $item->product_price,
                                    'total_price'   => $item->product_price * $item->quantity,
                                    'coupon_code'   => $coupon_code,
                                    'discount_amount'=> $discount_amount,
                                    'coupon_amount' => $coupon_amount,
                                    'coupon_type'   => $coupon_type,
                                    'after_discount' => $item_price,
                                    'offer_discount_price' => $offer_discount_price,
                                    'offer_discount_percentage' => $offer_discount_percentage,
                                    'offer_discount_type'=> $offer_discount_type,
                                    'offer_discount_face_value' => $offer_discount_face_value
        
        
                                ]);
                            }else if($coupon_data->merchendise_btn == 'category_product'){
                                $product = json_decode($coupon_data->merchendise);
                                $category = product::where('id',$item->product_id)->first();
                                if(in_array($category->category_id,$product)){
                                    if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                        $item_price = $total_product - $coupon_data->face_value;
        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        // $discount_amount = $total_product - $coupon_data->face_value;
                                        $discount_amount = $coupon_data->face_value;
        
                                    }else{
                                        $discount_price = ($total_product * $coupon_data->face_value)/100;
                                        $item_price    = $total_product - $discount_price;
        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        $discount_amount = $discount_price;
                                    }   
                                }else{
                                    $item_price = $total_product;
                                    $coupon_code = null;
                                    $discount_amount = 0;
                                    $coupon_amount = 0;
                                    $coupon_type = '';
                                }
                                
        
                                UserOrderItem::create([
                                    'user_id'       => Auth::user()->id,
                                    'order_no'      => $order_number,
                                    'consolidate_order_no' => $consolidate_order_number,
                                    'product_id'    => $item->product_id,
                                    'product_name'  => $item->product_name,
                                    'barcode'       => $item->barcode,
                                    'product_image' => $item->image,
                                    'quantity'      => $item->quantity,
                                    'product_price' => $item->product_price,
                                    'total_price'   => $item->product_price * $item->quantity,
                                    'coupon_code'   => $coupon_code,
                                    'discount_amount'=> $discount_amount,
                                    'coupon_amount' => $coupon_amount,
                                    'coupon_type'   => $coupon_type,
                                    'after_discount' => $item_price,
                                    'offer_discount_price' => $offer_discount_price,
                                    'offer_discount_percentage' => $offer_discount_percentage,
                                    'offer_discount_type'=> $offer_discount_type,
                                    'offer_discount_face_value' => $offer_discount_face_value
        
        
                                ]);
                            }else{
                                if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                    $item_price = $total_product - $coupon_data->face_value;
        
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    // $discount_amount = $total_product - $coupon_data->face_value;
                                    $discount_amount = $coupon_data->face_value;
                                }else{
                                    $discount_price = ($total_product * $coupon_data->face_value)/100;
                                    $item_price    = $total_product - $discount_price;
        
                                    
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    $discount_amount = $discount_price;
                                
        
                                }   
        
                                UserOrderItem::create([
                                    'user_id'       => Auth::user()->id,
                                    'order_no'      => $order_number,
                                    'consolidate_order_no' => $consolidate_order_number,
                                    'product_id'    => $item->product_id,
                                    'product_name'  => $item->product_name,
                                    'barcode'       => $item->barcode,
                                    'product_image' => $item->image,
                                    'quantity'      => $item->quantity,
                                    'product_price' => $item->product_price,
                                    'total_price'   => $item->product_price * $item->quantity,
                                    'coupon_code'   => $coupon_code,
                                    'discount_amount'=> $discount_amount,
                                    'coupon_amount' => $coupon_amount,
                                    'coupon_type'   => $coupon_type,
                                    'after_discount' => $item_price,
                                    'offer_discount_price' => $offer_discount_price,
                                    'offer_discount_percentage' => $offer_discount_percentage,
                                    'offer_discount_type'=> $offer_discount_type,
                                    'offer_discount_face_value' => $offer_discount_face_value
        
        
                                ]);
                            }
                        }
                    }
                }else{
                    foreach ($cart as $item) {
                    $product = product::where('id',$item['product_id'])->first();
                        if($product->discount_price > 0){
                            if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                $total_product              = $product->discount_price;
                                
                                $offer_discount_price       = $product->discount_price *  $item['quantity'];
                                $offer_discount_percentage  = $product->discount_percentage;
                                $offer_discount_type        = $product->discount_type;
                                $offer_discount_face_value  = $product->discount_face_value;
                            }  
                            else{
                                $total_product = $product->min_sale_price;
                                $offer_discount_price       = 0;
                                $offer_discount_percentage  = 0;
                                $offer_discount_type        ='';
                                $offer_discount_face_value  = 0;
                            }
                        }else{
                            $total_product = $product->min_sale_price;
                            $offer_discount_price       = 0;
                            $offer_discount_percentage  = 0;
                            $offer_discount_type        ='';
                            $offer_discount_face_value  = 0;
                        }
                    UserOrderItem::create([
                        'user_id'       => Auth::user()->id,
                        'order_no'      => $order_number,
                        'consolidate_order_no' => $consolidate_order_number,
                        'product_id'    => $item['product_id'],
                        'product_name'  => $item['product_name'],
                        'barcode'       => $item['barcode'],
                        'product_image' => $item['image'],
                        'quantity'      => $item['quantity'],
                        'product_price' => $item['product_price'],
                        'total_price'   => $item['product_price'] * $item['quantity'],
                        'after_discount' => $item['product_price'] * $item['quantity'],
                        'after_discount' => $total_product * $item['quantity'],
                        'offer_discount_price' => $offer_discount_price,
                        'offer_discount_percentage' => $offer_discount_percentage,
                        'offer_discount_type'=> $offer_discount_type,
                        'offer_discount_face_value' => $offer_discount_face_value
                    ]);
                }
                }
                }
    
    
            $carts = cart::where('use_id', Auth::user()->id)->get();
            $allProductDetails = json_encode($carts);
    
            $date  = Carbon::now();
            $order_date = $date->toDateString();
            Order::insert([
                "owner_id" => Auth::user()->id,
                "order_by" => 'self',
                "quotation_id" => NULL,
                "order_number" => $order_number,
                "customer_name" => $request->name,
                "customer_id" => Auth::user()->id,
                "date" => $order_date,
                "customer_address" => $request->address . ' ' . $request->city . ' ' . $request->state . ' ' . $request->country . ' ' . $request->postcode,
                "customer_type" => 'retail',
                "mobile_no" => $request->mobile_no,
                "email_id" => Auth::user()->email,
                "tax" => '0',
                "shipping_type" => 'delivery',
                "products_details" => $allProductDetails,
                "tax_inclusive" => '0',
                "untaxted_amount" => $store,
                "GST" => '',
                "sub_total" => $order_sum,
                "created_at" => now(),
            ]);


             // track stock deduct details with stock deduct details
            foreach($cart_data as $item){
                $remaining = 0;
                $stocks = Stock::where('product_id', $item->product_id)->where('quantity','!=',0)->get();
                $total_stock_deduct = $item->quantity;
                foreach($stocks as $stock){
                    $prevStockQty = $stock->quantity;

                    if($remaining == 0 && $total_stock_deduct != 0){
                        if($prevStockQty >= $item->quantity){
                            $deduct = $prevStockQty-$item->quantity;
                            $total_stock_deduct = 0;
                            $remaining = 0;
                            $deduct_quantity = $item->quantity;

                        }else{
                            // $deduct = $item->quantity - $prevStockQty;
                            $deduct = 0;
                            $remaining = $item->quantity - $prevStockQty;

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
                        'user_id'                => Auth::user()->id,
                        'product_id'             => $item->product_id,
                        'deduct_quantity'        => $deduct_quantity
                        ]);
                    }
                   
                    
                }
            }


           
            $carts = cart::where('use_id', Auth::user()->id)->get();
            cart::where('use_id', Auth::user()->id)->delete();

            $order_data = UserOrderItem::where('order_no', $order_number)->get();

            $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
            $data = DriverDate::all();
            
            // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();

        // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();

            $deliver_date = '';

            // 'consolidate_order_no' => $consolidate_order_number,

            // if(sizeof($notification) <= 0){
                
            // if($notification > 0){
            //     $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();

            //     $deliver_date = $notification->delivery_date;                
            // }else{
            //     $deliver_date = $session_data->delivery_date;
            // }

            if(!empty($user_last_order)){

                $last_order_date = $user_last_order->delivery_date;

                $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

                $consolidate_order_is = '';

                if ($last_order_date_format > $date) {
                    $deliver_date = $notification->delivery_date;
                }else{
                    $deliver_date = $session_data->delivery_date;
                }
            }else{
                $deliver_date = $session_data->delivery_date;
            }

            
            if($session_data->remark != null){
                $remark = $session_data->remark;
            }else{
                $remark = '';
            }
            
            $session = ModelsSession::find(Session::getId());
            $session->payment_mode = '';
            $session->loyalty_points = 0;
            // $session->address_id = null;
            $session->sub_total = 0;
            $session->shipping_charge = 0;
            $session->final_price = 0;
            $session->discount_value = 0;
            $session->coupon = null;
            $session_data->delivery_date = null;
            $session_data->remark = null;
            $session->save();


        

            return redirect()->route('order.select-delivery-date')->with([
                "orders" => $order_data,
                "order_no"  => $order_number,
                "consolidate_order_number"  => $consolidate_order_number,
                "new_data" => $new_data,
                "data" => $data,
                'deliver_date' => $deliver_date,
                'remark' => 'TEST',
            ]);
            
        }
        return redirect()->route('checkout');
    }


    // =========================================================================================================================================================
    // =========================================================================================================================================================
    // Pay with zero amount
    // =========================================================================================================================================================
    // =========================================================================================================================================================
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->status == 'completed'){
            
            $cart_data = cart::where('use_id', Auth::user()->id)->get();

            $date = Carbon::now();
            

            $sub_total = 0;
            $final_price = 0;
            $shipping_charge = 0;
            foreach($cart_data as $item){
                $product = DB::table('products')->where('id',$item->product_id)->first();
                $sub_total += $product->min_sale_price * $item->quantity;
                $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
            }



            
    
            $order_number = random_int(100000, 999999);
            $data['total_product_price'] = cart::where('use_id', Auth::user()->id)->sum('total_price');
            $total_product_price = cart::where('use_id', Auth::user()->id)->sum('total_price');
    
            // 
            $coupon_data = Cupon::where('coupon',$request->coupon)->first();
            $user_data = UserOrder::where('coupon_code',$request->coupon)->where('user_id',Auth::user()->id)->get();
           
            $cart_data = Cart::where('use_id',Auth::user()->id)->get();
            $cart_sum = Cart::where('use_id', Auth::user()->id)->sum('total_price');
            
            $item_price = 0;
            $discount_price = 0;
            $coupon_amount = 0;
            $discount_amount = 0;
            $coupon_type = '';
            $coupon_code = null;
            $total_product = 0;
    

            $voucherCode = VoucherCode::where('code', $request->coupon)->count();
            $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();

            if($voucherCode > 0){
                $voucher_id = $voucherCode1->voucher_id;
                $discount = Voucher::find($voucher_id);
    
                if ($date->toDateString() <= $discount->expiry_date){

                                VoucherCode::where('id', $voucher_id)->update([
                                    'status' => true,
                                ]);

                                if ($discount->discount_type == 'discount_by_value_btn') {
                                    $item_price = $cart_sum - $discount->discount;
            
                                    $coupon_type = "voucher";
                                    $coupon_amount = $discount->discount;
                                    $discount_amount = $discount->discount;
                                } else {
                                    $discount_price = ($cart_sum * $discount->discount) / 100;
                                    $item_price = $cart_sum - $discount_price;
            
                                    $coupon_type = "voucher";
                                    $coupon_amount = $discount->discount;
                                    $discount_amount = $discount_price;                        
                                }
               
                    
                }else{
                    $error = 'Your Coupon Expired!';   
                }
    
            }else{
    
                if($coupon_data && !empty($request->coupon)){
                    if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon){
                        if($coupon_data->limit > $user_data->count()){
                            if($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
                                $coupon_code = $request->coupon;
                                $change_use = Cupon::where('coupon',$request->coupon)->first();
                                Cupon::where('coupon',$request->coupon)->update([
                                    'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
                                ]);
                                foreach($cart_data as $item){
        
                                    $product = product::where('id',$item->product_id)->first();
                                    if($product->discount_price > 0){
                                        if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                            $total_product   = $product->discount_price*$item->quantity;                            
                                        }  
                                        else{
                                            $total_product = $product->min_sale_price*$item->quantity;
                                        }
                                    }else{
                                        $total_product = $product->min_sale_price*$item->quantity;
                                    }
        
        
                                    if($coupon_data->merchendise_btn == 'some_product'){
                                        $product = json_decode($coupon_data->merchendise);
                                        if(in_array($item->product_id,$product)){
                                            if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                                $item_price += $total_product - $coupon_data->face_value;
                                                
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                // $discount_amount += $total_product - $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
                                            }else{
                                                $discount_price = ($total_product * $coupon_data->face_value)/100;
                                                $item_price    += $total_product - $discount_price;
                                                
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }   
                                        }else{
                                            $item_price += $total_product;
                                        }
                                    }else if($coupon_data->merchendise_btn == 'category_product'){
                                        $product = json_decode($coupon_data->merchendise);
                                        $category = product::where('id',$item->product_id)->first();
                                        if(in_array($category->category_id,$product)){
                                            if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                                $item_price += $total_product - $coupon_data->face_value;
        
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                // $discount_amount += $total_product - $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
        
                                            }else{
                                                $discount_price = ($total_product * $coupon_data->face_value)/100;
                                                $item_price    += $total_product - $discount_price;
        
                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }   
                                        }else{
                                            $item_price += $total_product;
                                        }
                                        
                                    }else{
                                        if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                            $item_price += $total_product - $coupon_data->face_value;
        
                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            // $discount_amount += $total_product - $coupon_data->face_value;
                                            $discount_amount += $coupon_data->face_value;
                                        }else{
                                            $discount_price = ($total_product * $coupon_data->face_value)/100;
                                            $item_price    += $total_product - $discount_price;
        
                                            
                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            $discount_amount += $discount_price;
                                        
        
                                        }   
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $item_price = $final_price;
                }
            }
    
        $order_sum = $item_price;
           
    
        $addressIs = address::find($request->address_id);

        $order_number = UserOrder::orderBy('id', 'DESC')->pluck('order_no')->first();
        $order_number1 = UserOrder::orderBy('id', 'DESC')->pluck('id')->first();
        // dd($order_number1);

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        if ($order_number == null or $order_number == "") {             
            $order_number = 'LFKODC'.$year.$month.'00001';
        } else {
            $number = str_replace('LFKODC', '', $order_number);
            $order_number =  "LFKODC".$year.$month.sprintf("%04d", $order_number1 + 1);
        }


        $date1 = date('Y-m-d');
        // $user_last_order = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();

        if(!empty($user_last_order)){
        
            $last_order_date = $user_last_order->delivery_date;

            $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

            if ($last_order_date_format > $date1) {

                // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();
            // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
                $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();

                $consolidate_order_number = $notification->consolidate_order_no;
                $delivery_date = $notification->delivery_date;
                $end_date = $notification->end_date;
                $payment_mode = $notification->payment_mode;
        
                $data['order_no'] = $consolidate_order_number;
                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => $request->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => Auth::user()->id,
                    'order_no' => $order_number,
                    'delivery_date' => $delivery_date,
                    'end_date' => $end_date,
                    'payment_mode' => $payment_mode,
                    'remark' => $request->remark,
                ]);

            } else {

                $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
                $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();

                        if ($consolidate_order_number == null or $consolidate_order_number == "") {
                            
                            $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                        } else {
                            $number = str_replace('LFKODCC', '', $consolidate_order_number);
                            $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%04d", $consolidate_order_number1 + 1);
                        }

                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => $request->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => Auth::user()->id,
                    'order_no' => $order_number,
                    'payment_mode' => 'COD',
                    'delivery_date' => $request->delivery_date,
                    'remark' => $request->remark,
                ]);
            }
        } else {

            $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
            $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();

                    if ($consolidate_order_number == null or $consolidate_order_number == "") {
                        
                        $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                    } else {
                        $number = str_replace('LFKODCC', '', $consolidate_order_number);
                        $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%04d", $consolidate_order_number1 + 1);
                    }

            $data['order_no'] = $consolidate_order_number;

            Notification::create([
                'consolidate_order_no' => $consolidate_order_number,
                'address_id' => $request->address_id,
                'postcode' => $addressIs->postcode,
                'user_id' => Auth::user()->id,
                'order_no' => $order_number,
                'payment_mode' => 'COD',
                'delivery_date' => $request->delivery_date,
                'remark' => $request->remark,
            ]);
        }

                $payment=UserOrderPayment::create([
                    'buyer_name'=> $request->name,
                    'buyer_phone'=> $request->mobile_no,
                    'payment_type'=> 'COD',
                    'time'=> now(),
                    'amount'=> $request->amount,
                    'currency'=> 'sgd',
                    'status'=> 'succeeded',
                ]);
                
                if($request->amount == 0){
                
                    $data = LoyaltyPointTodays::all()->first();

                    $loyalty_points = LoyaltyPointshop::where('user_id', Auth::user()->id)->first();
                    $loyalty_wallet = ($loyalty_points->loyalty_points-$request->paid_points);

                    LoyaltyPoint::create([
                        'user_id' => Auth::user()->id,
                        'gained_points' => 0,
                        'spend_points' => $request->paid_points,
                        'remains_points' => $loyalty_wallet,
                        'transaction_id' => $payment->id,
                        'transaction_amount' => $request->amount,
                        'transaction_date' => now(),
                        "log"   => 'Purchase Order'
                    ]);

                    LoyaltyPointshop::updateOrCreate(
                        ['user_id' => Auth::user()->id],
                        ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => $payment->id]
                    );
                    
                }
    
            $data['payment_id']    = $payment->id;
            $data['payment_refrence_id']    = 'paidWithPoints01';

            $user_id_is = Auth::user()->id;

            $data['name']          = $request->name;
            $data['email']         = Auth::user()->email;
            $data['mobile_no']     = $request->mobile_no;
            $data['address']       = $request->address;
            $data['postcode']      = $request->postcode;
            $data['country']       = $request->country!=null?$request->country:"singapore";
            $data['state']         = $request->state;
            $data['city']          = $request->state;     
            $data['final_price']        = $order_sum;
            $data['order_no']           = $order_number;
            $data['user_id']            = $user_id_is;
            $data['coupon_code']        = $coupon_code;
            $data['discount_amount']    = $discount_amount;
            $data['coupon_amount']      = $coupon_amount;
            $data['coupon_type']        = $coupon_type;
            $data['status']             = 0;

            UserOrder::create([
                'payment_id'    => $payment->id,
                'payment_refrence_id'    => "COD",
                'name'          => $request->name,
                'email'         => Auth::user()->email,
                'mobile_no'     => $request->mobile_no,
                'address'       => $request->address,
                'postcode'      => $request->postcode,
                'country'       => $request->country!=null?$request->country:"singapore",
                'state'         => $request->state !=null?$request->state:"singapore",
                'city'          => $request->city !=null?$request->city:"singapore",
                'final_price'        => ($order_sum+(int)$request->ship_charge)-(int)$discount_amount,
                'order_no'           => $order_number,
                'consolidate_order_no' => $consolidate_order_number,
                'user_id'            => $user_id_is,
                'coupon_code'        => $coupon_code,
                'discount_amount'    => $discount_amount,
                'coupon_amount'      => $coupon_amount,
                'coupon_type'        => $coupon_type,
                'status'             => 0,
                'total_product_price' => $total_product_price,
                'ship_charge'   => $request->ship_charge,
            ]);
    
    
    
            $item_price = 0;
            $discount_price = 0;
            $coupon_amount = 0;
            $discount_amount = 0;
            $coupon_type = '';
            $coupon_code = null;
            $total_product = 0;
    
            $offer_discount_price = 0;
            $offer_discount_percentage = 0;
            $offer_discount_type = '';
            $offer_discount_face_value = 0;

            $voucherCode = VoucherCode::where('code', $request->coupon)->count();
            $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();

            if($voucherCode > 0){
                $voucher_id = $voucherCode1->voucher_id;
                $discount = Voucher::find($voucher_id);
    
                if ($date->toDateString() <= $discount->expiry_date){
                                
                        VoucherCode::where('id', $voucher_id)->update([
                            'status' => true,
                        ]);

                        VoucherHistory::create([
                            'code' => $voucherCode1->code,
                            'voucher_id' => $discount->id,
                            // 'discount_amount' => $session_data->discount_value,
                            'voucher_amount' => $discount->discount,
                            'voucher_type' => $discount->discount_type,
                            'consolidate_order_no' => $consolidate_order_number,
                            'order_no' => $order_number,
                        ]);

                        // $change_use = OfferPackages::where('coupon',$request->coupon)->first();
                        // Cupon::where('coupon',$request->coupon)->update([
                        //     'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
                        // ]);

                        foreach ($cart_data as $item) {
                            $product = product::where('id',$item['product_id'])->first();
                                if($product->discount_price > 0){
                                    if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                        $total_product              = $product->discount_price;
                                        
                                        $offer_discount_price       = $product->discount_price *  $item['quantity'];
                                        $offer_discount_percentage  = $product->discount_percentage;
                                        $offer_discount_type        = $product->discount_type;
                                        $offer_discount_face_value  = $product->discount_face_value;
                                    }  
                                    else{
                                        $total_product = $product->min_sale_price;
                                        $offer_discount_price       = 0;
                                        $offer_discount_percentage  = 0;
                                        $offer_discount_type        ='';
                                        $offer_discount_face_value  = 0;
                                    }
                                }else{
                                    $total_product = $product->min_sale_price;
                                    $offer_discount_price       = 0;
                                    $offer_discount_percentage  = 0;
                                    $offer_discount_type        ='';
                                    $offer_discount_face_value  = 0;
                                }
                            UserOrderItem::create([
                                'user_id'       => Auth::user()->id,
                                'order_no'      => $order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $item['product_id'],
                                'product_name'  => $item['product_name'],
                                'barcode'       => $item['barcode'],
                                'product_image' => $item['image'],
                                'quantity'      => $item['quantity'],
                                'product_price' => $item['product_price'],
                                'total_price'   => $item['product_price'] * $item['quantity'],
                                'after_discount' => $item['product_price'] * $item['quantity'],
                                // 'after_discount' => $total_product * $item['quantity'],
                                'offer_discount_price' => $offer_discount_price,
                                'offer_discount_percentage' => $offer_discount_percentage,
                                'offer_discount_type'=> $offer_discount_type,
                                'offer_discount_face_value' => $offer_discount_face_value
                            ]);
                        }
                    
                }else{
                    $error = 'Your Coupon Expired!';   
                }
    
            }else{
            
                if($coupon_data && !empty($request->coupon)){
                    $coupon_code = $request->coupon;
                    if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon && $coupon_data->limit > $user_data->count() && $date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
                        foreach($cart_data as $item){

                            $product = product::where('id',$item->product_id)->first();
                            if($product->discount_price > 0){
                                if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                    $total_product = $product->discount_price*$item->quantity;
                                    $offer_discount_price       = $product->discount_price;
                                    $offer_discount_percentage  = $product->discount_percentage;
                                    $offer_discount_type        = $product->discount_type;
                                    $offer_discount_face_value  = $product->discount_face_value;
                                }  
                                else{
                                    $total_product = $product->min_sale_price*$item->quantity;
                                    $offer_discount_price       = 0;
                                    $offer_discount_percentage  = 0;
                                    $offer_discount_type        = '';
                                    $offer_discount_face_value  = 0;
                                }
                            }else{
                                $total_product = $product->min_sale_price*$item->quantity;
                                $offer_discount_price       = 0;
                                $offer_discount_percentage  = 0;
                                $offer_discount_type        = '';
                                $offer_discount_face_value  = 0;
                            }
        
        
        
                            if($coupon_data->merchendise_btn == 'some_product'){
                                $product = json_decode($coupon_data->merchendise);
                                if(in_array($item->product_id,$product)){
                                    if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                        $item_price = $total_product - $coupon_data->face_value;
                                        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        // $discount_amount = $total_product - $coupon_data->face_value;
                                        $discount_amount = $coupon_data->face_value;
                                    }else{
                                        $discount_price = ($total_product * $coupon_data->face_value)/100;
                                        $item_price    = $total_product - $discount_price;
                                        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        $discount_amount = $discount_price;
                                    }   
        
                                }else{
                                    $item_price = $total_product;
                                    $coupon_code = null;
                                    $discount_amount = 0;
                                    $coupon_amount = 0;
                                    $coupon_type = '';
                                }
                                
                                UserOrderItem::create([
                                    'user_id'       => Auth::user()->id,
                                    'order_no'      => $order_number,
                                    'consolidate_order_no' => $consolidate_order_number,
                                    'product_id'    => $item->product_id,
                                    'product_name'  => $item->product_name,
                                    'barcode'       => $item->barcode,
                                    'product_image' => $item->image,
                                    'quantity'      => $item->quantity,
                                    'product_price' => $item->product_price,
                                    'total_price'   => $item->product_price * $item->quantity,
                                    'coupon_code'   => $coupon_code,
                                    'discount_amount'=> $discount_amount,
                                    'coupon_amount' => $coupon_amount,
                                    'coupon_type'   => $coupon_type,
                                    'after_discount' => $item_price,
                                    'offer_discount_price' => $offer_discount_price,
                                    'offer_discount_percentage' => $offer_discount_percentage,
                                    'offer_discount_type'=> $offer_discount_type,
                                    'offer_discount_face_value' => $offer_discount_face_value
                                ]);

                            }else if($coupon_data->merchendise_btn == 'category_product'){
                                $product = json_decode($coupon_data->merchendise);
                                $category = product::where('id',$item->product_id)->first();
                                if(in_array($category->category_id,$product)){
                                    if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                        $item_price = $total_product - $coupon_data->face_value;
        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        // $discount_amount = $total_product - $coupon_data->face_value;
                                        $discount_amount = $coupon_data->face_value;
        
                                    }else{
                                        $discount_price = ($total_product * $coupon_data->face_value)/100;
                                        $item_price    = $total_product - $discount_price;
        
                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount = $coupon_data->face_value;
                                        $discount_amount = $discount_price;
                                    }   
                                }else{
                                    $item_price = $total_product;
                                    $coupon_code = null;
                                    $discount_amount = 0;
                                    $coupon_amount = 0;
                                    $coupon_type = '';
                                }
                                
        
                                UserOrderItem::create([
                                    'user_id'       => Auth::user()->id,
                                    'order_no'      => $order_number,
                                    'consolidate_order_no' => $consolidate_order_number,
                                    'product_id'    => $item->product_id,
                                    'product_name'  => $item->product_name,
                                    'barcode'       => $item->barcode,
                                    'product_image' => $item->image,
                                    'quantity'      => $item->quantity,
                                    'product_price' => $item->product_price,
                                    'total_price'   => $item->product_price * $item->quantity,
                                    'coupon_code'   => $coupon_code,
                                    'discount_amount'=> $discount_amount,
                                    'coupon_amount' => $coupon_amount,
                                    'coupon_type'   => $coupon_type,
                                    'after_discount' => $item_price,
                                    'offer_discount_price' => $offer_discount_price,
                                    'offer_discount_percentage' => $offer_discount_percentage,
                                    'offer_discount_type'=> $offer_discount_type,
                                    'offer_discount_face_value' => $offer_discount_face_value
        
        
                                ]);
                            }else{
                                if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                    $item_price = $total_product - $coupon_data->face_value;
        
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    // $discount_amount = $total_product - $coupon_data->face_value;
                                    $discount_amount = $coupon_data->face_value;
                                }else{
                                    $discount_price = ($total_product * $coupon_data->face_value)/100;
                                    $item_price    = $total_product - $discount_price;
        
                                    
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    $discount_amount = $discount_price;
                                
        
                                }   
        
                                UserOrderItem::create([
                                    'user_id'       => Auth::user()->id,
                                    'order_no'      => $order_number,
                                    'consolidate_order_no' => $consolidate_order_number,
                                    'product_id'    => $item->product_id,
                                    'product_name'  => $item->product_name,
                                    'barcode'       => $item->barcode,
                                    'product_image' => $item->image,
                                    'quantity'      => $item->quantity,
                                    'product_price' => $item->product_price,
                                    'total_price'   => $item->product_price * $item->quantity,
                                    'coupon_code'   => $coupon_code,
                                    'discount_amount'=> $discount_amount,
                                    'coupon_amount' => $coupon_amount,
                                    'coupon_type'   => $coupon_type,
                                    'after_discount' => $item_price,
                                    'offer_discount_price' => $offer_discount_price,
                                    'offer_discount_percentage' => $offer_discount_percentage,
                                    'offer_discount_type'=> $offer_discount_type,
                                    'offer_discount_face_value' => $offer_discount_face_value
        
        
                                ]);
                            }
                        }
                    }
                }else{
                    foreach ($cart_data as $item) {
                    $product = product::where('id',$item['product_id'])->first();
                        if($product->discount_price > 0){
                            if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                $total_product              = $product->discount_price;
                                
                                $offer_discount_price       = $product->discount_price *  $item['quantity'];
                                $offer_discount_percentage  = $product->discount_percentage;
                                $offer_discount_type        = $product->discount_type;
                                $offer_discount_face_value  = $product->discount_face_value;
                            }  
                            else{
                                $total_product = $product->min_sale_price;
                                $offer_discount_price       = 0;
                                $offer_discount_percentage  = 0;
                                $offer_discount_type        ='';
                                $offer_discount_face_value  = 0;
                            }
                        }else{
                            $total_product = $product->min_sale_price;
                            $offer_discount_price       = 0;
                            $offer_discount_percentage  = 0;
                            $offer_discount_type        ='';
                            $offer_discount_face_value  = 0;
                        }
                    UserOrderItem::create([
                        'user_id'       => Auth::user()->id,
                        'order_no'      => $order_number,
                        'consolidate_order_no' => $consolidate_order_number,
                        'product_id'    => $item['product_id'],
                        'product_name'  => $item['product_name'],
                        'barcode'       => $item['barcode'],
                        'product_image' => $item['image'],
                        'quantity'      => $item['quantity'],
                        'product_price' => $item['product_price'],
                        'total_price'   => $item['product_price'] * $item['quantity'],
                        'after_discount' => $item['product_price'] * $item['quantity'],
                        // 'after_discount' => $total_product * $item['quantity'],
                        'offer_discount_price' => $offer_discount_price,
                        'offer_discount_percentage' => $offer_discount_percentage,
                        'offer_discount_type'=> $offer_discount_type,
                        'offer_discount_face_value' => $offer_discount_face_value
                    ]);
                }
                }
                }
    
    
            $carts = cart::where('use_id', Auth::user()->id)->get();
            $allProductDetails = json_encode($carts);
    
            $date  = Carbon::now();
            $order_date = $date->toDateString();
            Order::insert([
                "owner_id" => Auth::user()->id,
                "order_by" => 'self',
                "quotation_id" => NULL,
                "order_number" => $order_number,
                "customer_name" => $request->name,
                "customer_id" => Auth::user()->id,
                "date" => $order_date,
                "customer_address" => $request->address . ' ' . $request->city . ' ' . $request->state . ' ' . $request->country . ' ' . $request->postcode,
                "customer_type" => 'retail',
                "mobile_no" => $request->mobile_no,
                "email_id" => Auth::user()->email,
                "tax" => '0',
                "shipping_type" => 'delivery',
                "products_details" => $allProductDetails,
                "tax_inclusive" => '0',
                "untaxted_amount" => $total_product_price,
                "GST" => '',
                "sub_total" => $order_sum,
                "created_at" => now(),
            ]);



            // track stock deduct details with stock deduct details
            foreach($cart_data as $item){
                $remaining = 0;
                $stocks = Stock::where('product_id', $item->product_id)->where('quantity','!=',0)->get();
                $total_stock_deduct = $item->quantity;
                foreach($stocks as $stock){
                    $prevStockQty = $stock->quantity;

                    if($remaining == 0 && $total_stock_deduct != 0){
                        if($prevStockQty >= $item->quantity){
                            $deduct = $prevStockQty-$item->quantity;
                            $total_stock_deduct = 0;
                            $remaining = 0;
                            $deduct_quantity = $item->quantity;

                        }else{
                            // $deduct = $item->quantity - $prevStockQty;
                            $deduct = 0;
                            $remaining = $item->quantity - $prevStockQty;

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

                    
                    // Stock::where('id', $stock->id)->update([
                    //     'quantity' => $deduct
                    // ]);

                    if($deduct_quantity !=0 ){
                        $get_warehouse = Warehouse::where('name',$stock->warehouse_name)->first();
                        TrackStockDeductDetails::create([
                        'consolidate_order_no'   => $consolidate_order_number,
                        'order_no'               => $order_number,
                        'warehouse_id'           => $get_warehouse ? $get_warehouse->id : '',
                        'warehouse_name'         => $stock->warehouse_name,
                        'user_id'                => Auth::user()->id,
                        'product_id'             => $item->product_id,
                        'deduct_quantity'        => $deduct_quantity
                        ]);
                    }
                   
                    
                }
            }
        

            
            $carts = cart::where('use_id', Auth::user()->id)->get();
            // cart::where('use_id', Auth::user()->id)->delete();

            $order_data = UserOrderItem::where('order_no', $order_number)->get();

            $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
            $data = DriverDate::all();

            // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
        // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();

            $deliver_date = '';

            if(!empty($user_last_order)){

                $last_order_date = $user_last_order->delivery_date;

                $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

                $consolidate_order_is = '';

                if ($last_order_date_format > $date) {
                    $deliver_date = $notification->delivery_date;
                }else{
                    $deliver_date = $request->delivery_date;
                }
            }else{
                $deliver_date = $request->delivery_date;
            }
            
            if($request->remark != null){
                $remark = $request->remark;
            }else{
                $remark = '';
            }
           


            return redirect()->route('order.select-delivery-date')->with([
                "orders" => $order_data,
                "order_no"  => $order_number,
                "consolidate_order_number"  => $consolidate_order_number,
                "new_data" => $new_data,
                "data" => $data,
                'deliver_date' => $deliver_date,
                'remark' => 'TEST',
            ]);
        }
        return redirect()->route('checkout');








        // if($request->status == 'completed'){
            
        //     $products = cart::where('use_id', Auth::user()->id)->get();

        //     $order_sum = 0;
        //     $cart = [];
        //     $date = Carbon::now();
    
        //     foreach ($products as $key => $value) {
        //         $proId = $value['product_id'];
        //         $pro = product::where("id", $proId)->get();
    
        //         foreach ($pro as $k => $v) {
        //             $obj = [
        //                 "id" => $value['id'],
        //                 "product_id" => $v['id'],
        //                 "image" => $v['img_path'],
        //                 "product_name" => $v['product_name'],
        //                 'barcode'       => $v['barcode'],
        //                 "product_price" => $v['min_sale_price'],
        //                 "product_cat" => $v['product_category'],
        //                 "use_id" => Auth::user()->id,
        //                 "use_name" => Auth::user()->name,
        //                 "quantity" => $value['quantity'],
        //                 "total_price" => $v['min_sale_price'] * $value['quantity'],
        //             ];
        //             array_push($cart, $obj);
        //             // $order_sum += (float)$v['min_sale_price'] * $value['quantity'];
        //         }
    
        //         $product = product::where('id',$value->product_id)->first();
        //         if($product->discount_price > 0){
        //             if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
        //                 $order_sum += $product->discount_price * $value->quantity;
        //             }  
        //             else{
        //                 $order_sum += $product->min_sale_price * $value->quantity;
        //             }
        //         }else{
        //             $order_sum += $product->min_sale_price * $value->quantity;
        //         }
        //     }
    
        //     $order_number = random_int(100000, 999999);
        //     $data['total_product_price'] = cart::where('use_id', Auth::user()->id)->sum('total_price');
        //     $total_product_price = cart::where('use_id', Auth::user()->id)->sum('total_price');
    
        //     // 
        //     $coupon_data = Cupon::where('coupon',$request->coupon)->first();
        //     $user_data = UserOrder::where('coupon_code',$request->coupon)->where('user_id',Auth::user()->id)->get();
           
        //     $cart_data = Cart::where('use_id',Auth::user()->id)->get();
        //     $cart_sum = Cart::where('use_id', Auth::user()->id)->sum('total_price');
            
        //     $item_price = 0;
        //     $discount_price = 0;
        //     $coupon_amount = 0;
        //     $discount_amount = 0;
        //     $coupon_type = '';
        //     $coupon_code = null;
        //     $total_product = 0;
    
           
        //     // foreach($cart_data as $item){
        //     //     // $stocks = Stock::where('product_id', $item->product_id)->first();
        //     //     // $prevStockQty = $stocks->quantity;
        //     //     // Stock::where('product_id', $item->product_id)->first()->update([
        //     //     //     'quantity' => ($prevStockQty-$item->quantity)
        //     //     // ]);
        //     //     $remaining = 0;
        //     //     $stocks = Stock::where('product_id', $item->product_id)->where('quantity','!=',0)->get();
        //     //     $total_stock_deduct = $item->quantity;
        //     //     foreach($stocks as $stock){
        //     //         $prevStockQty = $stock->quantity;

        //     //         if($remaining == 0 && $total_stock_deduct != 0){
        //     //             if($prevStockQty >= $item->quantity){
        //     //                 $deduct = $prevStockQty-$item->quantity;
        //     //                 $total_stock_deduct = 0;
        //     //                 $remaining = 0;
        //     //             }else{
        //     //                 // $deduct = $item->quantity - $prevStockQty;
        //     //                 $deduct = 0;
        //     //                 $remaining = $item->quantity - $prevStockQty;
        //     //             }
        //     //         }else{
        //     //             if($prevStockQty >= $remaining ){
        //     //                 $deduct = $prevStockQty - $remaining;
        //     //                 $total_stock_deduct = 0;
        //     //                 $remaining = 0;
        //     //             }else{
        //     //                 $remaining = $remaining - $prevStockQty;
        //     //             }
        //     //         }
        //     //         Stock::where('id', $stock->id)->update([
        //     //             'quantity' => $deduct
        //     //         ]);
                    
                   
        //     //     }

        //     // }


        //     $voucherCode = VoucherCode::where('code', $request->coupon)->count();
        //     $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();

        //     if($voucherCode > 0){
        //         $voucher_id = $voucherCode1->voucher_id;
        //         $discount = Voucher::find($voucher_id);
    
        //         if ($date->toDateString() <= $discount->expiry_date){

        //                         VoucherCode::where('id', $voucher_id)->update([
        //                             'status' => true,
        //                         ]);

        //                         if ($discount->discount_type == 'discount_by_value_btn') {
        //                             $item_price = $cart_sum - $discount->discount;
            
        //                             $coupon_type = "voucher";
        //                             $coupon_amount = $discount->discount;
        //                             $discount_amount = $discount->discount;
        //                         } else {
        //                             $discount_price = ($cart_sum * $discount->discount) / 100;
        //                             $item_price = $cart_sum - $discount_price;
            
        //                             $coupon_type = "voucher";
        //                             $coupon_amount = $discount->discount;
        //                             $discount_amount = $discount_price;                        
        //                         }
               
                    
        //         }else{
        //             $error = 'Your Coupon Expired!';   
        //         }
    
        //     }else{
    
        //         if($coupon_data && !empty($request->coupon)){
        //             if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon){
        //                 if($coupon_data->limit > $user_data->count()){
        //                     if($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
        //                         $coupon_code = $request->coupon;
        //                         $change_use = Cupon::where('coupon',$request->coupon)->first();
        //                         Cupon::where('coupon',$request->coupon)->update([
        //                             'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
        //                         ]);
        //                         foreach($cart_data as $item){
        
        //                             $product = product::where('id',$item->product_id)->first();
        //                             if($product->discount_price > 0){
        //                                 if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
        //                                     $total_product   = $product->discount_price*$item->quantity;                            
        //                                 }  
        //                                 else{
        //                                     $total_product = $product->min_sale_price*$item->quantity;
        //                                 }
        //                             }else{
        //                                 $total_product = $product->min_sale_price*$item->quantity;
        //                             }
        
        
        //                             if($coupon_data->merchendise_btn == 'some_product'){
        //                                 $product = json_decode($coupon_data->merchendise);
        //                                 if(in_array($item->product_id,$product)){
        //                                     if($coupon_data->coupon_type == 'discount_by_value_btn'){
        //                                         $item_price += $total_product - $coupon_data->face_value;
                                                
        //                                         $coupon_type = $coupon_data->coupon_type;
        //                                         $coupon_amount += $coupon_data->face_value;
        //                                         // $discount_amount += $total_product - $coupon_data->face_value;
        //                                         $discount_amount += $coupon_data->face_value;
        //                                     }else{
        //                                         $discount_price = ($total_product * $coupon_data->face_value)/100;
        //                                         $item_price    += $total_product - $discount_price;
                                                
        //                                         $coupon_type = $coupon_data->coupon_type;
        //                                         $coupon_amount += $coupon_data->face_value;
        //                                         $discount_amount += $discount_price;
        //                                     }   
        //                                 }else{
        //                                     $item_price += $total_product;
        //                                 }
        //                             }else if($coupon_data->merchendise_btn == 'category_product'){
        //                                 $product = json_decode($coupon_data->merchendise);
        //                                 $category = product::where('id',$item->product_id)->first();
        //                                 if(in_array($category->category_id,$product)){
        //                                     if($coupon_data->coupon_type == 'discount_by_value_btn'){
        //                                         $item_price += $total_product - $coupon_data->face_value;
        
        //                                         $coupon_type = $coupon_data->coupon_type;
        //                                         $coupon_amount += $coupon_data->face_value;
        //                                         // $discount_amount += $total_product - $coupon_data->face_value;
        //                                         $discount_amount += $coupon_data->face_value;
        
        //                                     }else{
        //                                         $discount_price = ($total_product * $coupon_data->face_value)/100;
        //                                         $item_price    += $total_product - $discount_price;
        
        //                                         $coupon_type = $coupon_data->coupon_type;
        //                                         $coupon_amount += $coupon_data->face_value;
        //                                         $discount_amount += $discount_price;
        //                                     }   
        //                                 }else{
        //                                     $item_price += $total_product;
        //                                 }
                                        
        //                             }else{
        //                                 if($coupon_data->coupon_type == 'discount_by_value_btn'){
        //                                     $item_price += $total_product - $coupon_data->face_value;
        
        //                                     $coupon_type = $coupon_data->coupon_type;
        //                                     $coupon_amount += $coupon_data->face_value;
        //                                     // $discount_amount += $total_product - $coupon_data->face_value;
        //                                     $discount_amount += $coupon_data->face_value;
        //                                 }else{
        //                                     $discount_price = ($total_product * $coupon_data->face_value)/100;
        //                                     $item_price    += $total_product - $discount_price;
        
                                            
        //                                     $coupon_type = $coupon_data->coupon_type;
        //                                     $coupon_amount += $coupon_data->face_value;
        //                                     $discount_amount += $discount_price;
                                        
        
        //                                 }   
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }else{
        //             $item_price = $order_sum;
        //         }
        //     }
    
        // $order_sum = $item_price;
           
        // $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());
        // // dd();
        // $session_data = ModelsSession::where('id', Session::getId())->first();

        // $addressIs = address::find($session_data->address_id);

        // $order_number = UserOrder::orderBy('id', 'DESC')->pluck('order_no')->first();
        // $order_number1 = UserOrder::orderBy('id', 'DESC')->pluck('id')->first();
        // // dd($order_number1);

        // $now = new \DateTime('now');
        // $month = $now->format('m');
        // $year = $now->format('Y');

        // if ($order_number == null or $order_number == "") {             
        //     $order_number = 'LFKODC'.$year.$month.'00001';
        // } else {
        //     $number = str_replace('LFKODC', '', $order_number);
        //     $order_number =  "LFKODC".$year.$month.sprintf("%04d", $order_number1 + 1);
        // }

        // $addressIs = address::find($session_data->address_id);

        // $date1 = date('Y-m-d');

        // // $user_last_order = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        // $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
        //         ->select('notifications.*','addresses.unit')
        //         ->where('notifications.user_id', Auth::user()->id)
        //         ->where('notifications.postcode', $addressIs->postcode)
        //         ->where('addresses.unit', $addressIs->unit)
        //         ->latest()
        //         ->first();

        // if(!empty($user_last_order)){
        
        //     $last_order_date = $user_last_order->delivery_date;

        //     $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

        //     if ($last_order_date_format > $date1) {

        //         // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();
        //     // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        //         $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
        //         ->select('notifications.*','addresses.unit')
        //         ->where('notifications.user_id', Auth::user()->id)
        //         ->where('notifications.postcode', $addressIs->postcode)
        //         ->where('addresses.unit', $addressIs->unit)
        //         ->latest()
        //         ->first();

        //         $consolidate_order_number = $notification->consolidate_order_no;
        //         $delivery_date = $notification->delivery_date;
        //         $end_date = $notification->end_date;
        //         $payment_mode = $notification->payment_mode;
        
        //         $data['order_no'] = $consolidate_order_number;
        //         Notification::create([
        //             'consolidate_order_no' => $consolidate_order_number,
        //             'address_id' => $session_data->address_id,
        //             'postcode' => $addressIs->postcode,
        //             'user_id' => Auth::user()->id,
        //             'order_no' => $order_number,
        //             'delivery_date' => $delivery_date,
        //             'end_date' => $end_date,
        //             'payment_mode' => $payment_mode,
        //             'remark' => $session_data->remark,
        //         ]);

        //     } else {

        //         $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
        //         $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();

        //                 if ($consolidate_order_number == null or $consolidate_order_number == "") {
                            
        //                     $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
        //                 } else {
        //                     $number = str_replace('LFKODCC', '', $consolidate_order_number);
        //                     $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%04d", $consolidate_order_number1 + 1);
        //                 }

        //         $data['order_no'] = $consolidate_order_number;

        //         Notification::create([
        //             'consolidate_order_no' => $consolidate_order_number,
        //             'address_id' => $session_data->address_id,
        //             'postcode' => $addressIs->postcode,
        //             'user_id' => Auth::user()->id,
        //             'order_no' => $order_number,
        //             'payment_mode' => 'COD',
        //             'delivery_date' => $session_data->delivery_date,
        //             'remark' => $session_data->remark,
        //         ]);
        //     }
        // } else {

        //     $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
        //     $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();

        //             if ($consolidate_order_number == null or $consolidate_order_number == "") {
                        
        //                 $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
        //             } else {
        //                 $number = str_replace('LFKODCC', '', $consolidate_order_number);
        //                 $consolidate_order_number =  "LFKODCC" .$year.$month. sprintf("%04d", $consolidate_order_number1 + 1);
        //             }

        //     $data['order_no'] = $consolidate_order_number;

        //     Notification::create([
        //         'consolidate_order_no' => $consolidate_order_number,
        //         'address_id' => $session_data->address_id,
        //         'postcode' => $addressIs->postcode,
        //         'user_id' => Auth::user()->id,
        //         'order_no' => $order_number,
        //         'payment_mode' => 'COD',
        //         'delivery_date' => $session_data->delivery_date,
        //         'remark' => $session_data->remark,
        //     ]);
        // }

        //         $payment=UserOrderPayment::create([
        //             'buyer_name'=> $request->name,
        //             'buyer_phone'=> $request->mobile_no,
        //             'payment_type'=> 'COD',
        //             'time'=> now(),
        //             'amount'=> $request->amount,
        //             'currency'=> 'sgd',
        //             'status'=> 'succeeded',
        //         ]);
                
        //         if($request->amount == 0){
                
        //             $data = LoyaltyPointTodays::all()->first();

        //             $loyalty_wallet = ($session_data->loyalty_points-$request->paid_points);

        //             LoyaltyPoint::create([
        //                 'user_id' => Auth::user()->id,
        //                 'gained_points' => 0,
        //                 'spend_points' => $request->paid_points,
        //                 'remains_points' => $loyalty_wallet,
        //                 'transaction_id' => $payment->id,
        //                 'transaction_amount' => $request->amount,
        //                 'transaction_date' => now(),
        //                 "log"   => 'Purchase Order'
        //             ]);

        //             LoyaltyPointshop::updateOrCreate(
        //                 ['user_id' => Auth::user()->id],
        //                 ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => $payment->id]
        //             );
                    
        //         }
    
        //     $data['payment_id']    = $payment->id;
        //     $data['payment_refrence_id']    = 'paidWithPoints01';

        //     $user_id_is = Auth::user()->id;

        //     $data['name']          = $request->name;
        //     $data['email']         = Auth::user()->email;
        //     $data['mobile_no']     = $request->mobile_no;
        //     $data['address']       = $request->address;
        //     $data['postcode']      = $request->postcode;
        //     $data['country']       = $request->country!=null?$request->country:"singapore";
        //     $data['state']         = $request->state;
        //     $data['city']          = $request->state;     
        //     $data['final_price']        = $order_sum;
        //     $data['order_no']           = $order_number;
        //     $data['user_id']            = $user_id_is;
        //     $data['coupon_code']        = $coupon_code;
        //     $data['discount_amount']    = $discount_amount;
        //     $data['coupon_amount']      = $coupon_amount;
        //     $data['coupon_type']        = $coupon_type;
        //     $data['status']             = 0;

        //     UserOrder::create([
        //         'payment_id'    => $payment->id,
        //         'payment_refrence_id'    => "COD",
        //         'name'          => $request->name,
        //         'email'         => Auth::user()->email,
        //         'mobile_no'     => $request->mobile_no,
        //         'address'       => $request->address,
        //         'postcode'      => $request->postcode,
        //         'country'       => $request->country!=null?$request->country:"singapore",
        //         'state'         => $request->state !=null?$request->state:"singapore",
        //         'city'          => $request->city !=null?$request->city:"singapore",
        //         'final_price'        => ($order_sum+(int)$request->ship_charge)-(int)$discount_amount,
        //         'order_no'           => $order_number,
        //         'consolidate_order_no' => $consolidate_order_number,
        //         'user_id'            => $user_id_is,
        //         'coupon_code'        => $coupon_code,
        //         'discount_amount'    => $discount_amount,
        //         'coupon_amount'      => $coupon_amount,
        //         'coupon_type'        => $coupon_type,
        //         'status'             => 0,
        //         'total_product_price' => $total_product_price,
        //         'ship_charge'   => $request->ship_charge,
        //     ]);
    
    
    
        //     $item_price = 0;
        //     $discount_price = 0;
        //     $coupon_amount = 0;
        //     $discount_amount = 0;
        //     $coupon_type = '';
        //     $coupon_code = null;
        //     $total_product = 0;
    
        //     $offer_discount_price = 0;
        //     $offer_discount_percentage = 0;
        //     $offer_discount_type = '';
        //     $offer_discount_face_value = 0;

        //     $voucherCode = VoucherCode::where('code', $session_data->coupon)->count();
        //     $voucherCode1 = VoucherCode::where('code', $session_data->coupon)->first();

        //     if($voucherCode > 0){
        //         $voucher_id = $voucherCode1->voucher_id;
        //         $discount = Voucher::find($voucher_id);
    
        //         if ($date->toDateString() <= $discount->expiry_date){
                                
        //                 VoucherCode::where('id', $voucher_id)->update([
        //                     'status' => true,
        //                 ]);

        //                 VoucherHistory::create([
        //                     'code' => $voucherCode1->code,
        //                     'voucher_id' => $discount->id,
        //                     'discount_amount' => $session_data->discount_value,
        //                     'voucher_amount' => $discount->discount,
        //                     'voucher_type' => $discount->discount_type,
        //                     'consolidate_order_no' => $consolidate_order_number,
        //                     'order_no' => $order_number,
        //                 ]);

        //                 // $change_use = OfferPackages::where('coupon',$request->coupon)->first();
        //                 // Cupon::where('coupon',$request->coupon)->update([
        //                 //     'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
        //                 // ]);

        //                 foreach ($cart as $item) {
        //                     $product = product::where('id',$item['product_id'])->first();
        //                         if($product->discount_price > 0){
        //                             if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
        //                                 $total_product              = $product->discount_price;
                                        
        //                                 $offer_discount_price       = $product->discount_price *  $item['quantity'];
        //                                 $offer_discount_percentage  = $product->discount_percentage;
        //                                 $offer_discount_type        = $product->discount_type;
        //                                 $offer_discount_face_value  = $product->discount_face_value;
        //                             }  
        //                             else{
        //                                 $total_product = $product->min_sale_price;
        //                                 $offer_discount_price       = 0;
        //                                 $offer_discount_percentage  = 0;
        //                                 $offer_discount_type        ='';
        //                                 $offer_discount_face_value  = 0;
        //                             }
        //                         }else{
        //                             $total_product = $product->min_sale_price;
        //                             $offer_discount_price       = 0;
        //                             $offer_discount_percentage  = 0;
        //                             $offer_discount_type        ='';
        //                             $offer_discount_face_value  = 0;
        //                         }
        //                     UserOrderItem::create([
        //                         'user_id'       => Auth::user()->id,
        //                         'order_no'      => $order_number,
        //                         'consolidate_order_no' => $consolidate_order_number,
        //                         'product_id'    => $item['product_id'],
        //                         'product_name'  => $item['product_name'],
        //                         'barcode'       => $item['barcode'],
        //                         'product_image' => $item['image'],
        //                         'quantity'      => $item['quantity'],
        //                         'product_price' => $item['product_price'],
        //                         'total_price'   => $item['product_price'] * $item['quantity'],
        //                         'after_discount' => $item['product_price'] * $item['quantity'],
        //                         // 'after_discount' => $total_product * $item['quantity'],
        //                         'offer_discount_price' => $offer_discount_price,
        //                         'offer_discount_percentage' => $offer_discount_percentage,
        //                         'offer_discount_type'=> $offer_discount_type,
        //                         'offer_discount_face_value' => $offer_discount_face_value
        //                     ]);
        //                 }
                    
        //         }else{
        //             $error = 'Your Coupon Expired!';   
        //         }
    
        //     }else{
            
        //         if($coupon_data && !empty($request->coupon)){
        //             $coupon_code = $request->coupon;
        //             if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon && $coupon_data->limit > $user_data->count() && $date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
        //                 foreach($cart_data as $item){

        //                     $product = product::where('id',$item->product_id)->first();
        //                     if($product->discount_price > 0){
        //                         if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
        //                             $total_product = $product->discount_price*$item->quantity;
        //                             $offer_discount_price       = $product->discount_price;
        //                             $offer_discount_percentage  = $product->discount_percentage;
        //                             $offer_discount_type        = $product->discount_type;
        //                             $offer_discount_face_value  = $product->discount_face_value;
        //                         }  
        //                         else{
        //                             $total_product = $product->min_sale_price*$item->quantity;
        //                             $offer_discount_price       = 0;
        //                             $offer_discount_percentage  = 0;
        //                             $offer_discount_type        = '';
        //                             $offer_discount_face_value  = 0;
        //                         }
        //                     }else{
        //                         $total_product = $product->min_sale_price*$item->quantity;
        //                         $offer_discount_price       = 0;
        //                         $offer_discount_percentage  = 0;
        //                         $offer_discount_type        = '';
        //                         $offer_discount_face_value  = 0;
        //                     }
        
        
        
        //                     if($coupon_data->merchendise_btn == 'some_product'){
        //                         $product = json_decode($coupon_data->merchendise);
        //                         if(in_array($item->product_id,$product)){
        //                             if($coupon_data->coupon_type == 'discount_by_value_btn'){
        //                                 $item_price = $total_product - $coupon_data->face_value;
                                        
        //                                 $coupon_type = $coupon_data->coupon_type;
        //                                 $coupon_amount = $coupon_data->face_value;
        //                                 // $discount_amount = $total_product - $coupon_data->face_value;
        //                                 $discount_amount = $coupon_data->face_value;
        //                             }else{
        //                                 $discount_price = ($total_product * $coupon_data->face_value)/100;
        //                                 $item_price    = $total_product - $discount_price;
                                        
        //                                 $coupon_type = $coupon_data->coupon_type;
        //                                 $coupon_amount = $coupon_data->face_value;
        //                                 $discount_amount = $discount_price;
        //                             }   
        
        //                         }else{
        //                             $item_price = $total_product;
        //                             $coupon_code = null;
        //                             $discount_amount = 0;
        //                             $coupon_amount = 0;
        //                             $coupon_type = '';
        //                         }
                                
        //                         UserOrderItem::create([
        //                             'user_id'       => Auth::user()->id,
        //                             'order_no'      => $order_number,
        //                             'consolidate_order_no' => $consolidate_order_number,
        //                             'product_id'    => $item->product_id,
        //                             'product_name'  => $item->product_name,
        //                             'barcode'       => $item->barcode,
        //                             'product_image' => $item->image,
        //                             'quantity'      => $item->quantity,
        //                             'product_price' => $item->product_price,
        //                             'total_price'   => $item->product_price * $item->quantity,
        //                             'coupon_code'   => $coupon_code,
        //                             'discount_amount'=> $discount_amount,
        //                             'coupon_amount' => $coupon_amount,
        //                             'coupon_type'   => $coupon_type,
        //                             'after_discount' => $item_price,
        //                             'offer_discount_price' => $offer_discount_price,
        //                             'offer_discount_percentage' => $offer_discount_percentage,
        //                             'offer_discount_type'=> $offer_discount_type,
        //                             'offer_discount_face_value' => $offer_discount_face_value
        //                         ]);

        //                     }else if($coupon_data->merchendise_btn == 'category_product'){
        //                         $product = json_decode($coupon_data->merchendise);
        //                         $category = product::where('id',$item->product_id)->first();
        //                         if(in_array($category->category_id,$product)){
        //                             if($coupon_data->coupon_type == 'discount_by_value_btn'){
        //                                 $item_price = $total_product - $coupon_data->face_value;
        
        //                                 $coupon_type = $coupon_data->coupon_type;
        //                                 $coupon_amount = $coupon_data->face_value;
        //                                 // $discount_amount = $total_product - $coupon_data->face_value;
        //                                 $discount_amount = $coupon_data->face_value;
        
        //                             }else{
        //                                 $discount_price = ($total_product * $coupon_data->face_value)/100;
        //                                 $item_price    = $total_product - $discount_price;
        
        //                                 $coupon_type = $coupon_data->coupon_type;
        //                                 $coupon_amount = $coupon_data->face_value;
        //                                 $discount_amount = $discount_price;
        //                             }   
        //                         }else{
        //                             $item_price = $total_product;
        //                             $coupon_code = null;
        //                             $discount_amount = 0;
        //                             $coupon_amount = 0;
        //                             $coupon_type = '';
        //                         }
                                
        
        //                         UserOrderItem::create([
        //                             'user_id'       => Auth::user()->id,
        //                             'order_no'      => $order_number,
        //                             'consolidate_order_no' => $consolidate_order_number,
        //                             'product_id'    => $item->product_id,
        //                             'product_name'  => $item->product_name,
        //                             'barcode'       => $item->barcode,
        //                             'product_image' => $item->image,
        //                             'quantity'      => $item->quantity,
        //                             'product_price' => $item->product_price,
        //                             'total_price'   => $item->product_price * $item->quantity,
        //                             'coupon_code'   => $coupon_code,
        //                             'discount_amount'=> $discount_amount,
        //                             'coupon_amount' => $coupon_amount,
        //                             'coupon_type'   => $coupon_type,
        //                             'after_discount' => $item_price,
        //                             'offer_discount_price' => $offer_discount_price,
        //                             'offer_discount_percentage' => $offer_discount_percentage,
        //                             'offer_discount_type'=> $offer_discount_type,
        //                             'offer_discount_face_value' => $offer_discount_face_value
        
        
        //                         ]);
        //                     }else{
        //                         if($coupon_data->coupon_type == 'discount_by_value_btn'){
        //                             $item_price = $total_product - $coupon_data->face_value;
        
        //                             $coupon_type = $coupon_data->coupon_type;
        //                             $coupon_amount = $coupon_data->face_value;
        //                             // $discount_amount = $total_product - $coupon_data->face_value;
        //                             $discount_amount = $coupon_data->face_value;
        //                         }else{
        //                             $discount_price = ($total_product * $coupon_data->face_value)/100;
        //                             $item_price    = $total_product - $discount_price;
        
                                    
        //                             $coupon_type = $coupon_data->coupon_type;
        //                             $coupon_amount = $coupon_data->face_value;
        //                             $discount_amount = $discount_price;
                                
        
        //                         }   
        
        //                         UserOrderItem::create([
        //                             'user_id'       => Auth::user()->id,
        //                             'order_no'      => $order_number,
        //                             'consolidate_order_no' => $consolidate_order_number,
        //                             'product_id'    => $item->product_id,
        //                             'product_name'  => $item->product_name,
        //                             'barcode'       => $item->barcode,
        //                             'product_image' => $item->image,
        //                             'quantity'      => $item->quantity,
        //                             'product_price' => $item->product_price,
        //                             'total_price'   => $item->product_price * $item->quantity,
        //                             'coupon_code'   => $coupon_code,
        //                             'discount_amount'=> $discount_amount,
        //                             'coupon_amount' => $coupon_amount,
        //                             'coupon_type'   => $coupon_type,
        //                             'after_discount' => $item_price,
        //                             'offer_discount_price' => $offer_discount_price,
        //                             'offer_discount_percentage' => $offer_discount_percentage,
        //                             'offer_discount_type'=> $offer_discount_type,
        //                             'offer_discount_face_value' => $offer_discount_face_value
        
        
        //                         ]);
        //                     }
        //                 }
        //             }
        //         }else{
        //             foreach ($cart as $item) {
        //             $product = product::where('id',$item['product_id'])->first();
        //                 if($product->discount_price > 0){
        //                     if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
        //                         $total_product              = $product->discount_price;
                                
        //                         $offer_discount_price       = $product->discount_price *  $item['quantity'];
        //                         $offer_discount_percentage  = $product->discount_percentage;
        //                         $offer_discount_type        = $product->discount_type;
        //                         $offer_discount_face_value  = $product->discount_face_value;
        //                     }  
        //                     else{
        //                         $total_product = $product->min_sale_price;
        //                         $offer_discount_price       = 0;
        //                         $offer_discount_percentage  = 0;
        //                         $offer_discount_type        ='';
        //                         $offer_discount_face_value  = 0;
        //                     }
        //                 }else{
        //                     $total_product = $product->min_sale_price;
        //                     $offer_discount_price       = 0;
        //                     $offer_discount_percentage  = 0;
        //                     $offer_discount_type        ='';
        //                     $offer_discount_face_value  = 0;
        //                 }
        //             UserOrderItem::create([
        //                 'user_id'       => Auth::user()->id,
        //                 'order_no'      => $order_number,
        //                 'consolidate_order_no' => $consolidate_order_number,
        //                 'product_id'    => $item['product_id'],
        //                 'product_name'  => $item['product_name'],
        //                 'barcode'       => $item['barcode'],
        //                 'product_image' => $item['image'],
        //                 'quantity'      => $item['quantity'],
        //                 'product_price' => $item['product_price'],
        //                 'total_price'   => $item['product_price'] * $item['quantity'],
        //                 'after_discount' => $item['product_price'] * $item['quantity'],
        //                 // 'after_discount' => $total_product * $item['quantity'],
        //                 'offer_discount_price' => $offer_discount_price,
        //                 'offer_discount_percentage' => $offer_discount_percentage,
        //                 'offer_discount_type'=> $offer_discount_type,
        //                 'offer_discount_face_value' => $offer_discount_face_value
        //             ]);
        //         }
        //         }
        //         }
    
    
        //     $carts = cart::where('use_id', Auth::user()->id)->get();
        //     $allProductDetails = json_encode($carts);
    
        //     $date  = Carbon::now();
        //     $order_date = $date->toDateString();
        //     Order::insert([
        //         "owner_id" => Auth::user()->id,
        //         "order_by" => 'self',
        //         "quotation_id" => NULL,
        //         "order_number" => $order_number,
        //         "customer_name" => $request->name,
        //         "customer_id" => Auth::user()->id,
        //         "date" => $order_date,
        //         "customer_address" => $request->address . ' ' . $request->city . ' ' . $request->state . ' ' . $request->country . ' ' . $request->postcode,
        //         "customer_type" => 'retail',
        //         "mobile_no" => $request->mobile_no,
        //         "email_id" => Auth::user()->email,
        //         "tax" => '0',
        //         "shipping_type" => 'delivery',
        //         "products_details" => $allProductDetails,
        //         "tax_inclusive" => '0',
        //         "untaxted_amount" => $total_product_price,
        //         "GST" => '',
        //         "sub_total" => $order_sum,
        //         "created_at" => now(),
        //     ]);



        //     // track stock deduct details with stock deduct details
        //     foreach($cart_data as $item){
        //         $remaining = 0;
        //         $stocks = Stock::where('product_id', $item->product_id)->where('quantity','!=',0)->get();
        //         $total_stock_deduct = $item->quantity;
        //         foreach($stocks as $stock){
        //             $prevStockQty = $stock->quantity;

        //             if($remaining == 0 && $total_stock_deduct != 0){
        //                 if($prevStockQty >= $item->quantity){
        //                     $deduct = $prevStockQty-$item->quantity;
        //                     $total_stock_deduct = 0;
        //                     $remaining = 0;
        //                     $deduct_quantity = $item->quantity;

        //                 }else{
        //                     // $deduct = $item->quantity - $prevStockQty;
        //                     $deduct = 0;
        //                     $remaining = $item->quantity - $prevStockQty;

        //                     $deduct_quantity = $prevStockQty;
        //                 }
        //             }else{
        //                 if($prevStockQty >= $remaining ){
        //                     $deduct_quantity = $remaining;

        //                     $deduct = $prevStockQty - $remaining;
        //                     $total_stock_deduct = 0;
        //                     $remaining = 0;

                            
        //                 }else{
        //                     $remaining = $remaining - $prevStockQty;
        //                     $deduct_quantity = $prevStockQty;
        //                 }
        //             }

                    
        //             Stock::where('id', $stock->id)->update([
        //                 'quantity' => $deduct
        //             ]);

        //             if($deduct_quantity !=0 ){
        //                 $get_warehouse = Warehouse::where('name',$stock->warehouse_name)->first();
        //                 TrackStockDeductDetails::create([
        //                 'consolidate_order_no'   => $consolidate_order_number,
        //                 'order_no'               => $order_number,
        //                 'warehouse_id'           => $get_warehouse ? $get_warehouse->id : '',
        //                 'warehouse_name'         => $stock->warehouse_name,
        //                 'user_id'                => Auth::user()->id,
        //                 'product_id'             => $item->product_id,
        //                 'deduct_quantity'        => $deduct_quantity
        //                 ]);
        //             }
                   
                    
        //         }
        //     }
        

            
        //     $carts = cart::where('use_id', Auth::user()->id)->get();
        //     // cart::where('use_id', Auth::user()->id)->delete();

        //     $order_data = UserOrderItem::where('order_no', $order_number)->get();

        //     $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
        //     $data = DriverDate::all();

        //     // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
        // // $notification = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        // $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
        //         ->select('notifications.*','addresses.unit')
        //         ->where('notifications.user_id', Auth::user()->id)
        //         ->where('notifications.postcode', $addressIs->postcode)
        //         ->where('addresses.unit', $addressIs->unit)
        //         ->latest()
        //         ->first();

        //     $deliver_date = '';

        //     if(!empty($user_last_order)){

        //         $last_order_date = $user_last_order->delivery_date;

        //         $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

        //         $consolidate_order_is = '';

        //         if ($last_order_date_format > $date) {
        //             $deliver_date = $notification->delivery_date;
        //         }else{
        //             $deliver_date = $session_data->delivery_date;
        //         }
        //     }else{
        //         $deliver_date = $session_data->delivery_date;
        //     }
            
        //     if($session_data->remark != null){
        //         $remark = $session_data->remark;
        //     }else{
        //         $remark = '';
        //     }

        //     $session = ModelsSession::find(Session::getId());
        //     $session->payment_mode = '';
        //     $session->loyalty_points = 0;
        //     // $session->address_id = null;
        //     $session->sub_total = 0;
        //     $session->shipping_charge = 0;
        //     $session->final_price = 0;
        //     $session->discount_value = 0;
        //     $session->coupon = null;
        //     $session_data->delivery_date = null;
        //     $session_data->remark = null;
        //     $session->save();

           



        //     return redirect()->route('order.select-delivery-date')->with([
        //         "orders" => $order_data,
        //         "order_no"  => $order_number,
        //         "consolidate_order_number"  => $consolidate_order_number,
        //         "new_data" => $new_data,
        //         "data" => $data,
        //         'deliver_date' => $deliver_date,
        //         'remark' => 'TEST',
        //     ]);
        // }
        // return redirect()->route('checkout');
    }

    public function thanks(){
        $allProducts = product::all();
        $allCategory = Category::all()->take(5);

        return view('frontend.thanks', [
            "products" => $allProducts,
            "categories" => $allCategory,
        ]);
    }

    public function selectOrderDelivery(){
        //    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
        
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }
    public function updateSection(Request $request)
    {
        //
        // dd(Session::all());
        $order_data = UserOrderItem::where('order_no', Session::get('order_number'))->get();
        return view('frontend.delivery_date')->with([
                    "orders" =>$order_data,
                    "order_no"  => Session::get('order_no'),
                    "consolidate_order_number"  => Session::get('consolidate_order_number'),
                    "new_data" => Session::get('new_data'),
                    "data" => Session::get('data'),
                    'deliver_date' => Session::get('deliver_date'),
                ]);
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    public function make_payment_with_hit_pay(Request $request){
        $client = new Client();
        
        // https://api.sandbox.hit-pay.com/v1/payment-requests/ //testing api
        // https://api.hit-pay.com/v1/payment-requests/ // main api
        $res = $client->request('GET', 'https://api.sandbox.hit-pay.com/v1/payment-requests/'.$request->reference, [
            'headers' => [
                'X-BUSINESS-API-KEY'=> env('HIT_PAY_API_KEY'),
                'Content-Type'=> 'application/x-www-form-urlencoded',
                'X-Requested-With'=> 'XMLHttpRequest',
            ]
        ]);

        $payment_response_data = json_decode($res->getBody(),true);

        $if_coupon_data = $request->if_coupon_data;

        // print_r($request->reference);
        // print_r($request->all());
        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');
       
        $address = $request->address;
        $if_coupon_data = $request->if_coupon_data;
        $date = Carbon::now();
        $cart_data = [];
        $data_cart = cart::where('use_id', Auth::user()->id)->get();
        foreach($data_cart as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock){
                // $cart_data[] = Cart::where('use_id', Auth::user()->id)->where('product_id',$product->id)->get();                
                $cart_data[] = [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity
                ] ;
            }
        }

        $today_date = date('Y-m-d');
        $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $address['postcode'])
                ->where('addresses.unit', $address['unit'])
                ->latest()
                ->first();

        if(!empty($user_last_order)){

                $last_order_date = $user_last_order->delivery_date;

                $last_order_date = implode('-',array_reverse(explode('/',$last_order_date)));

                $consolidate_order_is = '';

                if ($last_order_date > $today_date) {

                    $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                        ->select('notifications.*','addresses.unit')
                        ->where('notifications.user_id', Auth::user()->id)
                        ->where('notifications.postcode', $address['postcode'])
                        ->where('addresses.unit', $address['unit'])
                        ->latest()
                        ->first();

                    $consolidate_order_number = $notification->consolidate_order_no;
                    $delivery_date = $notification->delivery_date;
                    $end_date = $notification->end_date;
                    $payment_mode = $notification->payment_mode;
            
                    $data['order_no'] = $consolidate_order_number;

                    Notification::create([
                        'consolidate_order_no'      => $consolidate_order_number,
                        'address_id'                => $request->address_id,
                        'postcode'                  => $address['postcode'],
                        'user_id'                   => Auth::user()->id,
                        'order_no'                  => $request->order_number,
                        'delivery_date'             => $delivery_date,
                        'end_date'                  => $end_date,
                        'payment_mode'              => $payment_mode,
                        'remark'                    => $request->remark,
                    ]);       
                }else{
                    // $consolidate_order_number = Notification::orderBy('id', 'DESC')
                    // ->first();

                    // if (empty($consolidate_order_number)) {  
                    //     $consolidate_order_number = 'LFKODCC'.$request->year.$request->month.'00001';
                    // } else {
                    //     $number = str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no);
                    //     $consolidate_order_number =  "LFKODCC" . sprintf("%04d", $number + 1);
                    // }

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

                    $data['order_no'] = $consolidate_order_number;
                    Notification::create([
                        'consolidate_order_no'      => $consolidate_order_number,
                        'address_id'                => $request->address_id,
                        'postcode'                  => $address['postcode'],
                        'user_id'                   => Auth::user()->id,
                        'order_no'                  => $request->order_number,
                        'payment_mode'              => 'hitpay',
                        'delivery_date'             => $request->delivery_date,
                        'remark'                    => $request->remark,
                    ]);
                }

            } else {

                // $consolidate_order_number = Notification::orderBy('id', 'DESC')->first();
                // if (empty($consolidate_order_number)) {
                //     $consolidate_order_number = 'LFKODCC'.$request->year.$request->month.'00001';
                // } else {
                //     $number = str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no);
                //     $consolidate_order_number =  "LFKODCC" . sprintf("%04d", $number + 1);
                // }

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

                $data['order_no'] = $consolidate_order_number;
                Notification::create([
                    'consolidate_order_no'      => $consolidate_order_number,
                    'address_id'                => $request->address_id,
                    'postcode'                  => $address['postcode'],
                    'user_id'                   => Auth::user()->id,
                    'order_no'                  => $request->order_number,
                    'payment_mode'              => 'hitpay',
                    'delivery_date'             => $request->delivery_date,
                    'remark'                    => $request->remark,
                ]);
            }


        foreach($payment_response_data['payments'] as $payment){
            $payment = UserOrderPayment::create([
                'consolidate_order_no'  => $consolidate_order_number,
                'user_id'               => Auth::user()->id,
                'payment_id'            => $payment["id"],
                'payment_request_id'    => $payment["id"],
                'buyer_name'            => $payment["buyer_name"],
                'buyer_phone'           => $payment["buyer_phone"],
                'buyer_email'           => $payment["buyer_email"],
                'fees'                  => $payment["fees"],
                'payment_type'          => $payment["payment_type"],
                'time'                  => $payment["created_at"],
                'amount'                => $payment["amount"],
                'currency'              => $payment["currency"],
                'status'                => $payment["status"],
                'reference_number'      => $request->reference,

            ]);


            LoyaltyPoint::create([
                'user_id'               => Auth::user()->id,
                'gained_points'         => (int)$request->sub_total,
                // 'spend_points'          => $request->paid_points,
                // 'remains_points'        => $loyalty_wallet,
                'transaction_id'        => $payment->id,
                'transaction_amount'    => 0,
                'transaction_date'      => now(),
                "log"                   => 'Purchase Order'
            ]);
    
            $old_data =  LoyaltyPointshop::where('user_id',Auth::user()->id)->first();
    
            LoyaltyPointshop::updateOrCreate(
                ['user_id' => Auth::user()->id],
                ['loyalty_points' => (int)($old_data->loyalty_points + $request->sub_total) , 'last_transaction_id' => $payment->id]
            );


        }


            UserOrder::create([
                'payment_id'                => $payment->id,
                'payment_reference_id'      => $request->reference,
                'name'                      => $address['name'],
                'email'                     => Auth::user()->email,
                'mobile_no'                 => $address['mobile_number'],
                'address_id'                => $address['id'],
                'address'                   => $address['address'],
                'postcode'                  => $address['postcode'],
                'unit'                      => $address['unit'],
                'country'                   => $request->country!=null?$request->country:"singapore",
                'state'                     => $request->state !=null?$request->state:"singapore",
                'city'                      => $request->city !=null?$request->city:"singapore",
                'final_price'               => $request->final_price,
                'order_no'                  => $request->order_number,
                'consolidate_order_no'      => $consolidate_order_number,
                'user_id'                   => Auth::user()->id,
                'coupon_code'               => $request->coupon,
                'discount_amount'           => $if_coupon_data['discount_amount'] ?? null,
                'coupon_amount'             => $if_coupon_data['coupon_amount'] ?? null,
                'coupon_type'               => $if_coupon_data['coupon_type'] ?? null,
                'status'                    => 0,
                'total_product_price'       => $if_coupon_data['total_product_original_price'],
                'ship_charge'               => $request->ship_charge,
            ]);



            $coupon_data = Cupon::where('coupon', $request->coupon)->first();
            $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', Auth::user()->id)->get();

            $voucherCode = VoucherCode::where('code', $request->coupon)->count();
            $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();

            // if ($voucherCode > 0) {
              
                
                if ($voucherCode1 && $date->toDateString() <= $voucherCode1->expiry_date && $voucherCode1->status == 0) {

                    $voucher_id = $voucherCode1->voucher_id;
                    $discount = Voucher::find($voucher_id);
                    foreach ($cart_data as $item) {
                        $product = product::where('id',$item['product_id'])->first();
                            if($product->discount_price > 0){
                                if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                    $total_product              = $product->discount_price *  $item['quantity'];;
                                    
                                    $offer_discount_price       = $product->discount_price *  $item['quantity'];
                                    $offer_discount_percentage  = $product->discount_percentage;
                                    $offer_discount_type        = $product->discount_type;
                                    $offer_discount_face_value  = $product->discount_face_value;
                                    $offer_name                 = $product->discount_name;
                                }  
                                else{
                                    $total_product = $product->min_sale_price *  $item['quantity'];;
                                    $offer_discount_price       = 0;
                                    $offer_discount_percentage  = 0;
                                    $offer_discount_type        ='';
                                    $offer_discount_face_value  = 0;
                                    $offer_name                 = null;
                                }
                            }else{
                                $total_product = $product->min_sale_price *  $item['quantity'];;
                                $offer_discount_price       = 0;
                                $offer_discount_percentage  = 0;
                                $offer_discount_type        ='';
                                $offer_discount_face_value  = 0;
                                $offer_name                 = null;
                            }

                            if ($discount->discount_type == 'discount_by_value_btn') {
                                $item_price = $total_product - $discount->discount;
        
                                $coupon_type = "voucher";
                                $coupon_amount = $discount->discount;
                                $discount_amount = $discount->discount;
                            } else {
                                $discount_price = ($total_product * $discount->discount) / 100;
                                $item_price = $total_product - $discount_price;
        
                                $coupon_type = "voucher";
                                $coupon_amount = $discount->discount;
                                $discount_amount = $discount_price;
                            }
        
                            VoucherCode::where('id', $voucher_id)->update([
                                'status' => true,
                            ]);
        
                            VoucherHistory::create([
                                'code'              => $voucherCode1->code,
                                'voucher_id'        => $discount->id,
                                'discount_amount'   => $discount_amount,
                                'voucher_amount'    => $discount->discount,
                                'voucher_type'      => $discount->discount_type,
                                'consolidate_order_no' => $consolidate_order_number,
                                'order_no'          => $request->order_number,
                            ]);

                        UserOrderItem::create([
                            'user_id'       => Auth::user()->id,
                            'order_no'      => $request->order_number,
                            'consolidate_order_no' => $consolidate_order_number,
                            'product_id'    => $item['product_id'],
                            'product_name'  => $product->product_name,
                            'barcode'       => $product->barcode,
                            'product_image' => $product->img_path,
                            'quantity'      => $item['quantity'],
                            'product_price' => $product->min_sale_price,
                            'total_price'   => $product->min_sale_price * $item['quantity'],
                            // 'after_discount' => $product->min_sale_price * $item['quantity'],
                            'after_discount' => null,
                            'offer_discount_price' => $offer_discount_price,
                            'offer_discount_percentage' => $offer_discount_percentage,
                            'offer_discount_type'=> $offer_discount_type,
                            'offer_discount_face_value' => $offer_discount_face_value,
                            'offer_name'                 => $offer_name,
                            'final_price_with_coupon_offer' => $total_product,
                        ]);
                    }


                    
                } 
                // else {
                //     $error = 'Your voucher Expired!';
                // }
            // } 

            else {
    
            if($coupon_data && !empty($request->coupon)){
                $coupon_code = $request->coupon;
                if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon && $coupon_data->limit > $user_data->count() && $date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
                    foreach($cart_data as $item){
    
                        $insert_product_details = DB::table('products')->where('id',$item['product_id'])->first();

                        $product = product::where('id',$item['product_id'])->first();
                        if($product->discount_price > 0){
                            if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                $total_product = $product->discount_price*$item['quantity'];
                                $offer_discount_price       = $product->discount_price *  $item['quantity'];;
                                $offer_discount_percentage  = $product->discount_percentage;
                                $offer_discount_type        = $product->discount_type;
                                $offer_discount_face_value  = $product->discount_face_value;
                                $offer_name                 = $product->discount_name;
                            }  
                            else{
                                $total_product = $product->min_sale_price*$item['quantity'];
                                $offer_discount_price       = 0;
                                $offer_discount_percentage  = 0;
                                $offer_discount_type        = '';
                                $offer_discount_face_value  = 0;
                                $offer_name                 = null;
                            }
                        }else{
                            $total_product = $product->min_sale_price*$item['quantity'];
                            $offer_discount_price       = 0;
                            $offer_discount_percentage  = 0;
                            $offer_discount_type        = '';
                            $offer_discount_face_value  = 0;
                            $offer_name                 = null;
                        }
    
    
    
                        if($coupon_data->merchendise_btn == 'some_product'){
                            $product = json_decode($coupon_data->merchendise);
                            if(in_array($item['product_id'],$product)){
                                if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                    $item_price = $total_product - $coupon_data->face_value;
                                    
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    // $discount_amount = $total_product - $coupon_data->face_value;
                                    $discount_amount = $coupon_data->face_value;
                                }else{
                                    $discount_price = ($total_product * $coupon_data->face_value)/100;
                                    $item_price    = $total_product - $discount_price;
                                    
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    $discount_amount = $discount_price;
                                }   
    
                            }else{
                                $item_price = $total_product;
                                $coupon_code = null;
                                $discount_amount = 0;
                                $coupon_amount = 0;
                                $coupon_type = '';
                            }
                            
                            UserOrderItem::create([
                                'user_id'       => Auth::user()->id,
                                'order_no'      => $request->order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $item['product_id'],
                                'product_name'  => $insert_product_details->product_name,
                                'barcode'       => $insert_product_details->barcode,
                                'product_image' => $insert_product_details->img_path,
                                'quantity'      => $item['quantity'],
                                'product_price' => $insert_product_details->min_sale_price,
                                'total_price'   => $insert_product_details->min_sale_price * $item['quantity'],
                                'coupon_code'   => $coupon_code,
                                'discount_amount'=> $discount_amount,
                                'coupon_amount' => $coupon_amount,
                                'coupon_type'   => $coupon_type,
                                'after_discount' => $discount_amount ? ($insert_product_details->min_sale_price * $item['quantity']) - $discount_amount : null,
                                'offer_discount_price' => $offer_discount_price,
                                'offer_discount_percentage' => $offer_discount_percentage,
                                'offer_discount_type'=> $offer_discount_type,
                                'offer_discount_face_value' => $offer_discount_face_value,
                                'offer_name'                 => $offer_name,
                                'final_price_with_coupon_offer' => $total_product - $discount_amount
                            ]);
    
                            $old_coupon_data = DB::table('cupons')->where('coupon',$coupon_code)->first();
                            if($old_coupon_data){
                                DB::table('cupons')->where('coupon',$coupon_code)->update([
                                    'no_of_used_coupon' => $old_coupon_data->no_of_used_coupon + 1
                                ]);
                            }
    
                        }else if($coupon_data->merchendise_btn == 'category_product'){
                            $product = json_decode($coupon_data->merchendise);
                            $category = product::where('id',$item['product_id'])->first();
                            if(in_array($category->category_id,$product)){
                                if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                    $item_price = $total_product - $coupon_data->face_value;
    
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    // $discount_amount = $total_product - $coupon_data->face_value;
                                    $discount_amount = $coupon_data->face_value;
    
                                }else{
                                    $discount_price = ($total_product * $coupon_data->face_value)/100;
                                    $item_price    = $total_product - $discount_price;
    
                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount = $coupon_data->face_value;
                                    $discount_amount = $discount_price;
                                }   
                            }else{
                                $item_price = $total_product;
                                $coupon_code = null;
                                $discount_amount = 0;
                                $coupon_amount = 0;
                                $coupon_type = '';
                            }
                            
    
                            UserOrderItem::create([
                                'user_id'       => Auth::user()->id,
                                'order_no'      => $request->order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $item['product_id'],
                                'product_name'  => $insert_product_details->product_name,
                                'barcode'       => $insert_product_details->barcode,
                                'product_image' => $insert_product_details->img_path,
                                'quantity'      => $item['quantity'],
                                'product_price' => $insert_product_details->min_sale_price,
                                'total_price'   => $insert_product_details->min_sale_price * $item['quantity'],
                                'coupon_code'   => $coupon_code,
                                'discount_amount'=> $discount_amount,
                                'coupon_amount' => $coupon_amount,
                                'coupon_type'   => $coupon_type,
                                'after_discount' => $discount_amount ? ($insert_product_details->min_sale_price * $item['quantity']) - $discount_amount : null,
                                'offer_discount_price' => $offer_discount_price,
                                'offer_discount_percentage' => $offer_discount_percentage,
                                'offer_discount_type'=> $offer_discount_type,
                                'offer_discount_face_value' => $offer_discount_face_value,
                                'offer_name'                 => $offer_name,
                                'final_price_with_coupon_offer' => $total_product - $discount_amount
                            ]);
    
                            $old_coupon_data = DB::table('cupons')->where('coupon',$coupon_code)->first();
                            if($old_coupon_data){
                                DB::table('cupons')->where('coupon',$coupon_code)->update([
                                    'no_of_used_coupon' => $old_coupon_data->no_of_used_coupon + 1
                                ]);
                            }
    
    
                        }else{
                            if($coupon_data->coupon_type == 'discount_by_value_btn'){
                                $item_price = $total_product - $coupon_data->face_value;
    
                                $coupon_type = $coupon_data->coupon_type;
                                $coupon_amount = $coupon_data->face_value;
                                // $discount_amount = $total_product - $coupon_data->face_value;
                                $discount_amount = $coupon_data->face_value;
                            }else{
                                $discount_price = ($total_product * $coupon_data->face_value)/100;
                                $item_price    = $total_product - $discount_price;
    
                                
                                $coupon_type = $coupon_data->coupon_type;
                                $coupon_amount = $coupon_data->face_value;
                                $discount_amount = $discount_price;
                            
    
                            }   
    
                            UserOrderItem::create([
                                'user_id'       => Auth::user()->id,
                                'order_no'      => $request->order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $item['product_id'],
                                'product_name'  => $insert_product_details->product_name,
                                'barcode'       => $insert_product_details->barcode,
                                'product_image' => $insert_product_details->img_path,
                                'quantity'      => $item['quantity'],
                                'product_price' => $insert_product_details->min_sale_price,
                                'total_price'   => $insert_product_details->min_sale_price * $item['quantity'],
                                'coupon_code'   => $coupon_code,
                                'discount_amount'=> $discount_amount,
                                'coupon_amount' => $coupon_amount,
                                'coupon_type'   => $coupon_type,
                                'after_discount' => $discount_amount ? ($insert_product_details->min_sale_price * $item['quantity']) - $discount_amount : null,
                                'offer_discount_price' => $offer_discount_price,
                                'offer_discount_percentage' => $offer_discount_percentage,
                                'offer_discount_type'=> $offer_discount_type,
                                'offer_discount_face_value' => $offer_discount_face_value,
                                'offer_name'                 => $offer_name,
                                'final_price_with_coupon_offer' => $total_product - $discount_amount
    
                            ]);
    
                            $old_coupon_data = DB::table('cupons')->where('coupon',$coupon_code)->first();
                            if($old_coupon_data){
                                DB::table('cupons')->where('coupon',$coupon_code)->update([
                                    'no_of_used_coupon' => $old_coupon_data->no_of_used_coupon + 1
                                ]);
                            }
                        }
                    }
                }
            }else{
                foreach ($cart_data as $item) {
                $product = product::where('id',$item['product_id'])->first();
                    if($product->discount_price > 0){
                        if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                            $total_product              = $product->discount_price *  $item['quantity'];;
                            
                            $offer_discount_price       = $product->discount_price *  $item['quantity'];
                            $offer_discount_percentage  = $product->discount_percentage;
                            $offer_discount_type        = $product->discount_type;
                            $offer_discount_face_value  = $product->discount_face_value;
                            $offer_name                 = $product->discount_name;
                        }  
                        else{
                            $total_product = $product->min_sale_price *  $item['quantity'];
                            $offer_discount_price       = 0;
                            $offer_discount_percentage  = 0;
                            $offer_discount_type        ='';
                            $offer_discount_face_value  = 0;
                            $offer_name                 = null;
                        }
                    }else{
                        $total_product = $product->min_sale_price *  $item['quantity'];
                        $offer_discount_price       = 0;
                        $offer_discount_percentage  = 0;
                        $offer_discount_type        ='';
                        $offer_discount_face_value  = 0;
                        $offer_name                 = null;
                    }
                    UserOrderItem::create([
                        'user_id'       => Auth::user()->id,
                        'order_no'      => $request->order_number,
                        'consolidate_order_no' => $consolidate_order_number,
                        'product_id'    => $item['product_id'],
                        'product_name'  => $product->product_name,
                        'barcode'       => $product->barcode,
                        'product_image' => $product->img_path,
                        'quantity'      => $item['quantity'],
                        'product_price' => $product->min_sale_price,
                        'total_price'   => $product->min_sale_price * $item['quantity'],
                        // 'after_discount' => $product->min_sale_price * $item['quantity'],
                        'after_discount' => null,
                        'offer_discount_price' => $offer_discount_price,
                        'offer_discount_percentage' => $offer_discount_percentage,
                        'offer_discount_type'=> $offer_discount_type,
                        'offer_discount_face_value' => $offer_discount_face_value,
                        'offer_name'                 => $offer_name,
                        'final_price_with_coupon_offer' => $total_product
                    ]);
                }
            }
        }



            $allProductDetails = json_encode($cart_data);
    
            $date  = Carbon::now();
            $order_date = $date->toDateString();

            Order::insert([
                "owner_id"          => Auth::user()->id,
                "order_by"          => 'self',
                "quotation_id"      => NULL,
                "order_number"      => $consolidate_order_number,
                "customer_name"     => $address['name'],
                "customer_id"       => Auth::user()->id,
                "date"              => $order_date,
                "customer_address"  => $address['address'] . ' ' . $address['name'] . ' ' . $address['postcode'] . ' ' . $address['mobile_number'] . ' ' . $address['unit'],
                "customer_type"     => 'retail',
                "mobile_no"         => $address['mobile_number'],
                "email_id"          => Auth::user()->email,
                "tax"               => '0',
                "shipping_type"     => 'delivery',
                "products_details"  => $allProductDetails,
                "tax_inclusive"     => '0',
                "untaxted_amount"   => $if_coupon_data['total_product'],
                "GST"               => '',
                "sub_total"         => $request->sub_total,
                "created_at"        => now(),
            ]);


            // track stock deduct details with stock deduct details
            foreach($cart_data as $item){
                $remaining = 0;
                $stocks = Stock::where('product_id', $item['product_id'])->where('quantity','!=',0)->get();
                $total_stock_deduct = $item['quantity'];
                foreach($stocks as $stock){
                    $prevStockQty = $stock->quantity;

                    if($remaining == 0 && $total_stock_deduct != 0){
                        if($prevStockQty >= $item['quantity']){
                            $deduct = $prevStockQty-$item['quantity'];
                            $total_stock_deduct = 0;
                            $remaining = 0;
                            $deduct_quantity = $item['quantity'];

                        }else{
                            // $deduct = $item->quantity - $prevStockQty;
                            $deduct = 0;
                            $remaining = $item['quantity'] - $prevStockQty;

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
                        'order_no'               => $request->order_number,
                        'warehouse_id'           => $get_warehouse ? $get_warehouse->id : '',
                        'warehouse_name'         => $stock->warehouse_name,
                        'user_id'                => Auth::user()->id,
                        'product_id'             => $item['product_id'],
                        'deduct_quantity'        => $deduct_quantity
                        ]);
                    }
                   
                }
            }


           
            //     // delete from cart
                foreach($cart_data as $delete_item){
                    cart::where('use_id', Auth::user()->id)
                    ->where('product_id',$delete_item['product_id'])
                    ->delete();
                }

            $order_data = UserOrderItem::where('order_no', $request->order_number)->get();

            $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
            $data = DriverDate::all();

            $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                    ->select('notifications.*','addresses.unit')
                    ->where('notifications.user_id', Auth::user()->id)
                    ->where('notifications.postcode', $address['postcode'])
                    ->where('addresses.unit', $address['unit'])
                    ->latest()
                    ->first();

            $deliver_date = '';

            if(!empty($user_last_order)){

                $last_order_date = $user_last_order->delivery_date;

                $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

                $consolidate_order_is = '';

                if ($last_order_date_format > $date) {
                    $deliver_date = $notification->delivery_date;
                }else{
                    $deliver_date = $request->delivery_date;
                }
            }else{
                $deliver_date = $request->delivery_date;
            }

            
            if($request->remark != null){
                $remark = $request->remark;
            }else{
                $remark = '';
            }
            

            return redirect()->route('order.select-delivery-date')->with([

                "orders"                    => $order_data,
                "order_no"                  => $request->order_number,
                "consolidate_order_number"  => $consolidate_order_number,
                "new_data"                  => $new_data,
                "data"                      => $data,
                'deliver_date'              => $deliver_date,
                'remark'                    => $remark,
                'payment_id'                => $payment->id,
            ]);
            
        // }



        // return $request->all(); 

    }





}