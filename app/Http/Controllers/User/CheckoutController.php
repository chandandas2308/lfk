<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\cart;
use App\Models\Category;
use App\Models\ConsolidateConfig;
use App\Models\Cupon;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointTodays;
use App\Models\Notification;
use App\Models\Order;
use App\Models\product;
use App\Models\UserOrder;
use App\Models\DriverDate;
use App\Models\Voucher;
use App\Models\VoucherCode;
use Carbon\Carbon;
use App\Models\UserOrderItem;
use App\Models\ProductRedemptionShop;
use App\Models\LoyaltyPointshop;
use GuzzleHttp\Client;
use App\Models\session as ModelsSession;
use App\Models\UserOrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

use App\Models\Stock;
use App\Models\TrackStockDeductDetails;
use App\Models\VoucherHistory;
use App\Models\Warehouse;

class CheckoutController extends Controller
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

    // update address page
    function updateAddressPage($id)
    {
        $last_user_address = '';

        $data = Notification::where('consolidate_order_no',$id)->first();
        if($data)
            $last_user_address = $data->address_id;

        return view('frontend.updateOrder', [
            "consolidate_order_no"  => $id,
            'last_user_address'     => $last_user_address
        ]);
    }
    // update order address
    function updateAddress(Request $request)
    {
        // dd($request->post());
        
        $address_id = $request->address_id;

        $addressIs = Address::find($address_id);

        $consolidate_order = $request->consolidate_order_no;

        UserOrder::where('consolidate_order_no', $consolidate_order)->update([
            'name'      => $addressIs->name,
            "address"   => $addressIs->address,
            "mobile_no" => $addressIs->mobile_number,
            "postcode"  => $addressIs->postcode,
        ]);

        Notification::where('consolidate_order_no', $consolidate_order)->update([
            'address_id'    => $request->address_id,
            'postcode'      => $addressIs->postcode,
        ]);

        $check_deliveries = DB::table('deliveries')->where('order_no',request()->consolidate_order_no)->first();
        if($check_deliveries){
            DB::table('deliveries')->where('order_no',request()->consolidate_order_no)->update([
                'mobile_no'         => $addressIs->mobile_number,
                'customer_name'     => $addressIs->name,
                'address_id'        => request()->address_id,
                'delivery_address'  => $addressIs->address,
            ]);
        }

        return redirect(route('user.my-orders'))->with('success', 'Address updated');
    }

    // 
    function orderSummary()
    {
        $data = cart::where('use_id', Auth::user()->id)->get();
        if ($data->count() > 0) {
            return view('frontend.order_summary');
        }
        return redirect()->back()->with('msg', 'Please Add Some Product In Cart');
    }

    function redemptionOrderSummary($id)
    {
        $data = ProductRedemptionShop::find($id);
        if($data){
            $loyalty_wallet = DB::table('loyalty_pointshops')->where('user_id',Auth::user()->id)->first();
            if($loyalty_wallet->loyalty_points >= $data->points)
                return view('frontend.redemption_order_summary', ["data" => $data]);
            else
                return redirect()->route('checkIn.rewards')->with('back_message','Insufficient Points');
        }else{
            return redirect()->back('checkIn.rewards')->with('back_message','Data Not Found');
        }
    }

    function redemptionAddressSummary($id)
    {
        $notification = DB::table('notifications')
        ->where('user_id',Auth::user()->id)
        ->orderBy('id','desc')->first();
        $last_user_address = '';
        if($notification)
            $last_user_address = $notification->address_id;

        $data = ProductRedemptionShop::find($id);
        if($data){
            $loyalty_wallet = DB::table('loyalty_pointshops')->where('user_id',Auth::user()->id)->first();
            if($loyalty_wallet->loyalty_points >= $data->points)
                return view('frontend.redemption_address_summary', [
                    "product_redemption_shops_id" => $id ,
                    'last_user_address' => $last_user_address
                ]);
            else
                return redirect()->route('checkIn.rewards')->with('back_message','Insufficient Points');
        }else{
            return redirect()->back('checkIn.rewards')->with('back_message','Data Not Found');
        }
        
    }

    // 
    function redemptionDeliveryDateSummary(Request $request, $product_id)
    {

        $data = ProductRedemptionShop::find($product_id);
        if($data){
            $loyalty_wallet = DB::table('loyalty_pointshops')->where('user_id',Auth::user()->id)->first();
            if($loyalty_wallet->loyalty_points < $data->points){
                return redirect()->route('checkIn.rewards')->with('back_message','Insufficient Points');
            }
        }else{
            return redirect()->back('checkIn.rewards')->with('back_message','Data Not Found');
        }

        $address = address::find($request->address_id);

        $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
        ->select('notifications.*','addresses.unit')
        ->where('notifications.user_id', Auth::user()->id)
        ->where('notifications.postcode', $address->postcode)
        ->where('addresses.unit', $address->unit)
        ->where('notifications.delivery_date', '>', date('d/m/Y'))
        ->count();

        $remark = '';
        $order_no = '';
        if ($notification > 0) {
            $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
            ->select('notifications.*','addresses.unit')
            ->where('notifications.user_id', Auth::user()->id)
            ->where('notifications.postcode', $address->postcode)
            ->where('addresses.unit', $address->unit)
            ->where('notifications.delivery_date', '>', date('d/m/Y'))
            ->latest()
            ->first();

            $deliver_date = $notification->delivery_date;
            $remark = $notification->remark;
            $order_no = $notification->consolidate_order_no;
        } else {
            $deliver_date = '';
        }
        return view('frontend.redemption_delivery_date_selection', [
            "order_no"      => $order_no, 
            "product_redemption_shops_id"    => $product_id, 
            "deliver_date"  => $deliver_date, 
            "remark"        => $remark, 
            "address_id"    => $request->address_id
        ]);
    }

    // 
    function redemptionCheckoutSummary(Request $request, $product_id)
    {
        $data = ProductRedemptionShop::find($product_id);
        return view('frontend.redemption_checkout', [
            "order_no"      => $request->order_no, 
            "data"          => $data, 
            "deliver_date"  => $request->delivery_date, 
            "remark"        => $request->remark, 
            "address_id"    => $request->address_id,
            'product_redemption_shops_id' => $product_id
        ]);
    }

    // 
    function deliveryDate()
    {

        
        $data = cart::where('use_id', Auth::user()->id)->get();
        $address = address::find(request()->address_id);
        if(!$data){
            return redirect()->back()->with('back_message', 'Please Add Some Product In Cart');
        }
        if(!$address){
            return redirect()->back()->with('back_message', 'Please Select Delivery Address');
        }
        if($data && $address){
            $final_price = 0;
            foreach($data as $item){
                $product = DB::table('products')->where('id',$item->product_id)->first();
                $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
                ->groupBy('product_id')->sum('quantity');
                if($check_stock){
                    $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
                }
            }


            if ($final_price > 0) {
                $addressIs = address::find(request()->address_id);

                $remark = '';
                $date = date('Y-m-d');
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

                    if ($last_order_date_format > $date) {
                        $deliver_date = $user_last_order->delivery_date;
                        $remark = $user_last_order->remark;
                    } else {
                        $deliver_date = '';
                    }
                }else{
                    $deliver_date = '';
                }
                
                return view('frontend.delivery_date_selection', ["deliver_date" => $deliver_date, "remark" => $remark,'address_id'=>request()->address_id,'coupon' => request()->store_coupon_in_input_field]);
            }
        }
        return redirect()->back()->with('back_message', 'Please Add Some Product In Cart');
    }

    // store delivery and remark
    function storeDeliveryDate(Request $request)
    {
        $session = ModelsSession::find(Session::getId());
        $session->delivery_date = $request->delivery_date;
        $session->remark = $request->remark;
        $session->save();

        return redirect(route('checkout'));
    }

    // 
    function voucherGenerator($id)
    {
        $voucher = Voucher::find($id);

        $user_points = LoyaltyPointshop::where('user_id', Auth::user()->id)->first();
        if($voucher->points <= $user_points->loyalty_points){

            $voucher_code = "LKFVC" . ((rand() * 10000) + 5);

            $loyalty_wallet = ($user_points->loyalty_points - $voucher->points);

            LoyaltyPoint::create([
                'user_id'               => Auth::user()->id,
                'gained_points'         => 0,
                'spend_points'          => $voucher->points,
                'remains_points'        => $loyalty_wallet,
                'transaction_id'        => 0,
                'transaction_amount'    => 0,
                'transaction_date'      => now(),
                'log'                   => 'Generate Voucher Code'
            ]);

            LoyaltyPointshop::updateOrCreate(
                ['user_id' => Auth::user()->id],
                ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => 1]
            );

            VoucherCode::create([
                'voucher_id'        => $id,
                'code'              => $voucher_code,
                'user_id'           => Auth::user()->id,
                'status'            => false,
                'expiry_date'       => $voucher->expiry_date
            ]);

            return redirect()->back()->with('success', 'Voucher Code Generated. Code : ' . $voucher_code);
        }else{
            return redirect()->back()->with('back_message','Insufficient Points');
        }
    }

    // =====================================================================================
    // START
    // =====================================================================================
    // store redemption shop checkout
    function checkout(Request $request)
    {

        $product_details = ProductRedemptionShop::find($request->product_id);
        $address = address::find($request->address_id);
        $checkAddress = Notification::join('addresses','addresses.id','=','notifications.address_id')
            ->select('notifications.*','addresses.unit')
            ->where('notifications.user_id', Auth::user()->id)
            ->where('notifications.postcode', $address->postcode)
            ->where('addresses.unit', $address->unit)
            ->where('delivery_date', '>', date('d/m/Y'))->count();

        $order_number = UserOrder::orderBy('id', 'DESC')->first();

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        if ($order_number == null or $order_number == "") {
            $order_number = 'LFKODC' . $year . $month . '00001';
        } else {
            $number = str_replace('LFKODC', '', $order_number);
            $order_number =  "LFKODC" . $year . $month . sprintf("%04d", $order_number->id + 1);
        }

        if ($checkAddress > 0) {

            $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $address->postcode)
                ->where('addresses.unit', $address->unit)
                ->where('delivery_date', '>', date("d/m/Y"))
                ->first();

            $consolidate_order_number = $notification->consolidate_order_no;
            $delivery_date = $notification->delivery_date;
            $end_date = $notification->end_date;
            $payment_mode = 'points';

            $data['order_no'] = $consolidate_order_number;

            Notification::create([
                'consolidate_order_no'     => $consolidate_order_number,
                'address_id'               => $request->address_id,
                'postcode'                 => $address->postcode,
                'user_id'                  => Auth::user()->id,
                'order_no'                 => $order_number,
                'delivery_date'            => $delivery_date,
                'end_date'                 => $end_date,
                'payment_mode'             => $notification->payment_mode,
                'remark'                   => $request->remark,
            ]);
        } else {

            $consolidate_order_number = Notification::orderBy('id', 'DESC')->first();

            if (empty($consolidate_order_number)) {
                $consolidate_order_number = 'LFKODCC' . $year . $month . '00001';
            } else {
                $number = str_replace('LFKODCC', '', $consolidate_order_number->consolidate_order_no);
                $consolidate_order_number =  "LFKODCC" . sprintf("%04d", $number + 1);
            }

            $data['order_no'] = $consolidate_order_number;
            Notification::create([
                'consolidate_order_no'      => $consolidate_order_number,
                'address_id'                => $request->address_id,
                'postcode'                  => $address->postcode,
                'user_id'                   => Auth::user()->id,
                'order_no'                  => $order_number,
                'payment_mode'              => 'points',
                'delivery_date'             => $request->delivery_date,
                'remark'                    => $request->remark,
            ]);
        }

        $payment = UserOrderPayment::create([
            'consolidate_order_no'      => $consolidate_order_number,
            'user_id'                   => Auth::user()->id,
            'payment_id'                => 'points',
            'payment_request_id'        => 'points',
            'buyer_name'                => $address->name,
            'buyer_phone'               => $address->mobile_number,
            'buyer_email'               => Auth::user()->email,
            'points'                    => $product_details->points,
            'fees'                      => 0,
            'payment_type'              => 'points',
            'time'                      => now(),
            'amount'                    => 0,
            'currency'                  => 'sgd',
            'status'                    => 'succeeded',
            'reference_number'          => 'points',
        ]);

        $user_points = LoyaltyPointshop::where('user_id', Auth::user()->id)->first();

        $loyalty_wallet = ($user_points->loyalty_points - $product_details->points);

        LoyaltyPoint::create([
            'user_id'               => Auth::user()->id,
            'gained_points'         => 0,
            'spend_points'          => $product_details->points,
            'remains_points'        => $loyalty_wallet,
            'transaction_id'        => $payment->id,
            'transaction_amount'    => 0,
            'transaction_date'      => now(),
            'log'                   => 'Redemption Shop Order'
        ]);

        LoyaltyPointshop::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => $payment->id]
        );

        UserOrder::create([
            'payment_id'            => $payment->id,
            'payment_reference_id'  => "points",
            'name'                  => $address->name,
            'email'                 => Auth::user()->email,
            'mobile_no'             => $address->mobile_number,
            'address'               => $address->address,
            'postcode'              => $address->postcode,
            'points'                => $product_details->points,
            'country'               => "singapore",
            'state'                 => "singapore",
            'city'                  => "singapore",
            'final_price'           => 0,
            'order_no'              => $order_number,
            'consolidate_order_no'  => $consolidate_order_number,
            'user_id'               => Auth::user()->id,
            'status'                => 0,
            'total_product_price'   => 0,
            'ship_charge'           => 0,
        ]);

        $p_details = DB::table('products')->where('id',$product_details->product_id)->first();

        UserOrderItem::create([
            'user_id'               => Auth::user()->id,
            'order_no'              => $order_number,
            'consolidate_order_no'  => $consolidate_order_number,
            'product_id'            => $p_details->id,
            'points'                => $product_details->points,
            'product_name'          => $product_details->product_name,
            'barcode'               => $p_details->barcode ?? $product_details->product_name,
            'product_image'         => json_decode($product_details->images)[0],
            'quantity'              => 1,
            'product_price'         => 0,
            'total_price'           => 0,
        ]);

        ProductRedemptionShop::where('id', $product_details->id)
        ->update(['quantity' => (int)$product_details->quantity - 1]);

        $date  = Carbon::now();
        $order_date = $date->toDateString();

        $details = [
            "product_name"      => $product_details->product_name,
            "product_id"        => $product_details->id,
            "category_id"       => $product_details->product_category,
            "product_variant"   => $product_details->product_variant,
            "vendor_id"         => $product_details->vendor_id,
            "sku_code"          => $product_details->sku_code,
            "points"            => $product_details->points,
            "quantity"          => 1,
            "image"             => json_decode($product_details->images)[0],
            "use_id"            => Auth::user()->id,
            "use_name"          => $address->name,
        ];

        Order::insert([
            "owner_id"          => Auth::user()->id,
            "order_by"          => 'self',
            "quotation_id"      => NULL,
            "order_number"      => $order_number,
            "customer_name"     => $product_details->product_name,
            "customer_id"       => Auth::user()->id,
            "date"              => $order_date,
            "customer_address"  => $address->address,
            "customer_type"     => 'retail',
            "mobile_no"         => $address->mobile_number,
            "email_id"          => Auth::user()->email,
            "tax"               => '0',
            "shipping_type"     => 'delivery',
            "products_details"  => json_encode($details),
            "tax_inclusive"     => '0',
            "untaxted_amount"   => 0,
            "GST"               => '',
            "sub_total"         => 0,
            "created_at"        => now(),
        ]);

        $order_data = UserOrderItem::where('order_no', $order_number)->get();

        $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
        $data = DriverDate::all();

        $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
        ->select('notifications.*','addresses.unit')
        ->where('notifications.user_id', Auth::user()->id)
        ->where('notifications.postcode', $address->postcode)
        ->where('addresses.unit', $address->unit)
        ->where('delivery_date', '>', date('d/m/Y'))->count();

        $deliver_date = '';

        if ($notification > 0) {
            $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
            ->select('notifications.*','addresses.unit')
            ->where('notifications.user_id', Auth::user()->id)
            ->where('notifications.postcode', $address->postcode)
            ->where('addresses.unit', $address->unit)
            ->where('delivery_date', '>', date('d/m/Y'))->first();
            $deliver_date = $notification->delivery_date;
        }

        return redirect()->route('order.select-delivery-date')->with([
            "orders"            => $order_data,
            "order_no"          => $order_number,
            "consolidate_order_number"  => $consolidate_order_number,
            "new_data"          => $new_data,
            "data"              => $data,
            'deliver_date'      => $deliver_date,
        ]);
    }
    // =====================================================================================
    // END
    // =====================================================================================

    // 
    function addressSummary(){
        $data = cart::where('use_id',Auth::user()->id)->get();
        $notification = DB::table('notifications')->where('user_id',Auth::user()->id)->orderBy('id','desc')->first();


        $sub_total = 0;
        $final_price = 0;
        $shipping_charge = 0;
        foreach($data as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock > 0){
                $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
            }
        }
        $sub_total = $final_price;
        $user_last_order = '';
        $last_user_address = '';

        if($notification){
            $address = DB::table('addresses')->where('id',$notification->address_id)->first();

            $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
            ->select('notifications.*','addresses.unit')
            ->where('notifications.user_id', Auth::user()->id)
            ->where('notifications.postcode', $address->postcode)
            ->where('addresses.unit', $address->unit)
            ->latest()
            ->first();

            $date = date('Y-m-d');
            $last_order_date = implode('-',array_reverse(explode('/',$user_last_order->delivery_date ?? '')));
            $last_user_address = $notification->address_id;
        }
        if($user_last_order &&  $last_order_date > $date){
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

        return view('frontend.address_summary')->with([
            'cart_data'             => $data,
            'sub_total'             => (float)$sub_total,
            'final_price'           => (float)$final_price,
            'last_user_address'     => $last_user_address,
            'shipping_charge'       => $shipping_charge
        ]);

        // return redirect()->route('Home')->with('msg', 'Please Add Some Product In Cart');
    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = cart::where('use_id', Auth::user()->id)->get();
        if ($data->count() > 0) {
            $allProducts = product::all();
            $allCategory = Category::all()->take(5);

            $pointsAre = DB::table('loyalty_point_todays')->first();

            $amount = $pointsAre->amount;
            $points = $pointsAre->points;

            $cart_amount = cart::where('use_id', Auth::user()->id)->sum('total_price');

            $total_points = DB::table('loyalty_pointshops')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();

            if (sizeof($total_points) > 0) {
                $havePoints = $total_points[0]->loyalty_points;
            } else {
                $havePoints = 0;
            }

            $one_dollar_points = $points / $amount;

            $total_pay_points = $cart_amount * $one_dollar_points;

            $total_have_points = $havePoints;

            $status = false;
            if ($total_have_points >= $total_pay_points) {
                $status = true;
            }

            $payment_mode = '';

            $session = ModelsSession::find(Session::getId());

            $session_data = ModelsSession::where('id',  Session::getId())->first();
            $discount_value = ModelsSession::where('id',  Session::getId())->value('discount_value');
            $current_cart_amount = cart::where('use_id', Auth::user()->id)->sum('total_price');
            $session->sub_total = $current_cart_amount;

            if ($session_data->address_id != null || $session_data->address_id != '') {

                $addressIs = address::find($session_data->address_id);

                $date = date('Y-m-d');

                // $user_last_order = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
                $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
                ->where('notifications.postcode', $addressIs->postcode)
                ->where('addresses.unit', $addressIs->unit)
                ->latest()
                ->first();

                if(!empty($user_last_order)){

                    ModelsSession::updateOrCreate(["id" => Session::getId()], ['sub_total' => $current_cart_amount]);

                    $last_order_date = $user_last_order->delivery_date;

                    $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

                    $consolidate_order_is = '';

                    if ($last_order_date_format > $date) {

                        $payment_mode = $user_last_order->payment_mode;

                        $bill_amount = UserOrderItem::where('consolidate_order_no', $user_last_order->consolidate_order_no)->sum('total_price');

                        $consolidate_order_is = $user_last_order->consolidate_order_no;

                        $total_order_amount = $bill_amount + $current_cart_amount;

                        if ($bill_amount >= 70) {
                            ModelsSession::updateOrCreate(
                                ["id" => Session::getId()],
                                ['shipping_charge' => 0, 'final_price' => $current_cart_amount - $discount_value]
                            );
                        } else if ($total_order_amount >= 70) {
                            ModelsSession::updateOrCreate(
                                ["id" => Session::getId()],
                                ['shipping_charge' => -8, 'final_price' => ($current_cart_amount - 8) - $discount_value]
                            );
                        } else {
                            ModelsSession::updateOrCreate(
                                ["id" => Session::getId()],
                                ['shipping_charge' => 0, 'final_price' => ($current_cart_amount) - $discount_value]
                            );
                        }
                    } else {
                        $consolidate_order_is = "";
                        if ($current_cart_amount >= 70) {
                            $session->shipping_charge = 0;
                            $session->final_price = $current_cart_amount - $discount_value;
                        } else {
                            $session->shipping_charge = 8;
                            $session->final_price = ($current_cart_amount + 8) - $discount_value;
                        }
                    }
                } else {
                    $consolidate_order_is = "";
                    if ($current_cart_amount >= 70) {
                        $session->shipping_charge = 0;
                        $session->final_price = $current_cart_amount - $discount_value;
                    } else {
                        $session->shipping_charge = 8;
                        $session->final_price = ($current_cart_amount + 8) - $discount_value;
                    }
                }
            } else {

                if ($current_cart_amount >= 70) {
                    $session->shipping_charge = 0;
                    $session->final_price = $current_cart_amount - $discount_value;
                } else {
                    $session->shipping_charge = 8;
                    $session->final_price = ($current_cart_amount + 8) - $discount_value;
                }
            }

            $session->save();


            $session_data2 = ModelsSession::where('id', Session::getId())->first();

            if ($session_data2->coupon != null) {
                $coupon_data = Cupon::where('coupon', $session_data2->coupon)->first();
                $user_data = UserOrder::where('coupon_code', $session_data2->coupon)->where('user_id', Auth::user()->id)->get();
                $date = Carbon::now();
                $cart_data = Cart::where('use_id', Auth::user()->id)->get();
                $cart_sum = Cart::where('use_id', Auth::user()->id)->sum('total_price');
                $item_price = 0;
                $discount_price = 0;
                $coupon_amount = 0;
                $discount_amount = 0;
                $coupon_type = '';
                $error = '';
                $total_product = 0;

                $voucherCode = VoucherCode::where('code', $session_data2->coupon)->count();
                $voucherCode1 = VoucherCode::where('code', $session_data2->coupon)->first();

                if ($voucherCode > 0) {
                    $voucher_id = $voucherCode1->voucher_id;
                    $discount = Voucher::find($voucher_id);

                    if ($date->toDateString() <= $discount->expiry_date) {

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
                    } else {
                        $error = 'Your Coupon Expired!';
                    }
                } else {

                    if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
                        if ($coupon_data->limit > $user_data->count()) {
                            if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
                                foreach ($cart_data as $item) {

                                    $product = product::where('id', $item->product_id)->first();
                                    if ($product->discount_price > 0) {
                                        if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                            $total_product = $product->discount_price * $item->quantity;
                                        } else {
                                            $total_product = $product->min_sale_price * $item->quantity;
                                        }
                                    } else {
                                        $total_product = $product->min_sale_price * $item->quantity;
                                    }


                                    if ($coupon_data->merchendise_btn == 'some_product') {
                                        $product = json_decode($coupon_data->merchendise);
                                        if (in_array($item->product_id, $product)) {
                                            if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                                $item_price += $total_product - $coupon_data->face_value;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
                                            } else {
                                                $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                                $item_price    += $total_product - $discount_price;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }
                                        } else {
                                            $item_price += $total_product;
                                        }
                                    } else if ($coupon_data->merchendise_btn == 'category_product') {
                                        $product = json_decode($coupon_data->merchendise);
                                        $category = product::where('id', $item->product_id)->first();
                                        if (in_array($category->category_id, $product)) {
                                            if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                                $item_price += $total_product - $coupon_data->face_value;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                // $discount_amount += $total_product - $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
                                            } else {
                                                $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                                $item_price    += $total_product - $discount_price;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }
                                        } else {
                                            $item_price += $total_product;
                                        }
                                    } else {
                                        if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                            $item_price += $total_product - $coupon_data->face_value;

                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            // $discount_amount += $total_product - $coupon_data->face_value;
                                            $discount_amount += $coupon_data->face_value;
                                        } else {
                                            $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                            $item_price    += $total_product - $discount_price;

                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            $discount_amount += $discount_price;
                                        }
                                    }
                                }
                            } else {
                                $error = 'Your Coupon Expired!';
                            }
                        } else {
                            $error = 'Coupon Limit Exceeded';
                        }
                    } else {
                        $error = 'Coupon Not Available!';
                    }
                }

                $session_data = ModelsSession::where('id', Session::getId())->first();

                $session = ModelsSession::find(Session::getId());

                $session->discount_value = $discount_amount;
                $session->final_price = ($session_data->sub_total + $session_data->shipping_charge) - $discount_amount;

                $session->save();
            }

            // dd(DB::table('user_orders')->where('consolidate_order_no',$consolidate_order_is)->get());

            return view('frontend.checkout', [
                "ship_charge"       => 0,
                "total_product"     => 0,
                "products"          => $allProducts,
                "categories"        => $allCategory,
                "data"              => $data,
                "payment_mode"      => $payment_mode,
                "status"            => $status,
                "consolidate_order_is" => $consolidate_order_is,
                "session_data"      => ModelsSession::where('id', Session::getId())->first()
            ]);
        }
        return redirect()->route('Home')->with('msg', 'Please Add Some Product In Cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function check_coupon_code(Request $request)
    {

        $coupon_data = Cupon::where('coupon', $request->coupon)->first();
        $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', Auth::user()->id)->get();
        $date = Carbon::now();
        $data = Cart::where('use_id', Auth::user()->id)->get();
        
        $sub_total = 0;
        $final_price = 0;
        $shipping_charge = 0;
        $cart_data = [];
        foreach($data as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock){
                $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
                $cart_data[] = [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity
                ] ;
            }
        }

        // print_r(sizeOf($cart_data));

        $item_price = 0;
        $discount_price = 0;
        $coupon_amount = 0;
        $discount_amount = 0;
        $coupon_type = '';
        $error = '';
        $total_product = 0;

        
            
            $voucherCode = VoucherCode::where('code', $request->coupon)->count();
            $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();


            if ($voucherCode > 0) {
                $voucher_id = $voucherCode1->voucher_id;
                $discount = Voucher::find($voucher_id);
                // echo $voucherCode1->expiry_date;
                if ($date->toDateString() <= $voucherCode1->expiry_date) {
                    if( $voucherCode1->status == 0){
                        if ($discount->discount_type == 'discount_by_value_btn') {
                            $item_price = $final_price - $discount->discount;

                            $coupon_type = "voucher";
                            $coupon_amount = $discount->discount;
                            $discount_amount = $discount->discount;
                        } else {
                            $discount_price = ($final_price * $discount->discount) / 100;
                            $item_price = $final_price - $discount_price;

                            $coupon_type = "voucher";
                            $coupon_amount = $discount->discount;
                            $discount_amount = $discount_price;
                        }
                    }else{
                        $error = 'Your voucher Used!';
                    }
                } else {
                    $error = 'Your voucher Expired!';
                }
            } 

            else {
                $request->validate([
                    'coupon' => 'required|exists:cupons,coupon'
                ],[
                    'coupon.exists' => 'The selected Code is invalid.'
                ]);

            if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
                if ($coupon_data->limit > $user_data->count()) {
                    if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
                        foreach ($cart_data as $item) {
                        
                            $product = product::where('id', $item['product_id'])->first();
                            if ($product->discount_price > 0) {
                                if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                    $total_product = $product->discount_price * $item['quantity'];
                                } else {
                                    $total_product = $product->min_sale_price * $item['quantity'];
                                }
                            } else {
                                $total_product = $product->min_sale_price * $item['quantity'];
                            }


                            if ($coupon_data->merchendise_btn == 'some_product') {
                                $product = json_decode($coupon_data->merchendise);
                                if (in_array($item['product_id'], $product)) {
                                    if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                        $item_price += $total_product - $coupon_data->face_value;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        $discount_amount += $coupon_data->face_value;
                                    } else {
                                        $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                        $item_price    += $total_product - $discount_price;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        $discount_amount += $discount_price;
                                    }
                                } else {
                                    $item_price += $total_product;
                                }
                            } else if ($coupon_data->merchendise_btn == 'category_product') {
                                $product = json_decode($coupon_data->merchendise);
                                $category = product::where('id', $item['product_id'])->first();
                                if (in_array($category->category_id, $product)) {
                                    if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                        $item_price += $total_product - $coupon_data->face_value;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        // $discount_amount += $total_product - $coupon_data->face_value;
                                        $discount_amount += $coupon_data->face_value;
                                    } else {
                                        $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                        $item_price    += $total_product - $discount_price;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        $discount_amount += $discount_price;
                                    }
                                } else {
                                    $item_price += $total_product;
                                }
                            } else {
                                if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                    $item_price += $total_product - $coupon_data->face_value;

                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount += $coupon_data->face_value;
                                    // $discount_amount += $total_product - $coupon_data->face_value;
                                    $discount_amount += $coupon_data->face_value;
                                } else {
                                    $discount_price = ($total_product * $coupon_data->face_value) / 100;

                                    $item_price    += $total_product - $discount_price;

                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount += $coupon_data->face_value;
                                    $discount_amount += $discount_price;
                                }
                            }
                        }
                    } else {
                        $error = 'Your Coupon Expired!';
                    }
                } else {
                    $error = 'Coupon Limit Exceeded';
                }
            } else {
                $error = 'Coupon Not Available!';
            }
        }
        
        $final_price = $item_price;
        $shipping_charge = 0;
       
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

        $message = $coupon_type == 'voucher' ? 'Voucher Apply Successfully' : 'Coupon Apply Successfully';

        echo json_encode([
            'final_price'           => $final_price,
            'coupon_discount'       => $discount_amount,
            'error'                 => $error,
            'coupon_amount'         => $coupon_amount,
            'coupon_typ'            => $coupon_type,
            'success'               => $error != '' ? '' : ($discount_amount > 0 ? $message : ''),
            'not_apply_for_this'    => $error == '' ? ($discount_amount > 0 ? '' : 'Sorry this coupon is not applicable to selected Products!') : '',
            'shipping_charge'       => $shipping_charge,
        ]);

        // echo json_encode([
        //     'grand_total'           => $item_price,
        //     'coupon_discount'      => $discount_amount,
        //     'error'                => $error,
        //     "final_price" => ($session_data->sub_total + $session_data->shipping_charge) - $discount_amount - $total_offer_discount,
        //     "offer_discount" => $total_offer_discount,
        //     'sub_total' => $session_data->sub_total,
        //     'shipping_charge' => $session_data->shipping_charge,
        //     $coupon_amount,
        //     $coupon_type,
        //     'success'              => $error != '' ? '' : ($discount_amount > 0 ? 'Coupon Apply Successfully' : ''),
        //     'not_apply_for_this'   => $discount_amount > 0 ? '' : 'Sorry this coupon is not applicable to selected Products!'
        // ]);
    }


    public function select_payment_option(Request $request){
    

        $data = cart::where('use_id', Auth::user()->id)->get();
        if ($data->count() > 0) {
            $sub_total = 0;
            $final_price = 0;
            $shipping_charge = 0;
            $cart_data = [];
            foreach($data as $item){
                $product = DB::table('products')->where('id',$item->product_id)->first();
                $sub_total += $product->min_sale_price * $item->quantity;
                $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
                ->groupBy('product_id')->sum('quantity');
                if($check_stock){
                    $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
                    $cart_data[] = [
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity
                    ] ;
                }
            }
            $sub_total = $final_price;

            $payment_mode = '';


                $coupon_data = Cupon::where('coupon', $request->coupon)->first();
                $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', Auth::user()->id)->get();
                $date = Carbon::now();
                $item_price = 0;
                $discount_price = 0;
                $coupon_amount = 0;
                $discount_amount = 0;
                $coupon_type = '';
                $error = '';
                $total_product = 0;

                $voucherCode = VoucherCode::where('code', $request->coupon)->count();
                $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();

            if ($voucherCode > 0) {
                $voucher_id = $voucherCode1->voucher_id;
                $discount = Voucher::find($voucher_id);
                // echo $voucherCode1->expiry_date;
                if ($date->toDateString() <= $voucherCode1->expiry_date) {
                    if ($discount->discount_type == 'discount_by_value_btn') {
                        $item_price = $final_price - $discount->discount;

                        $coupon_type = "voucher";
                        $coupon_amount = $discount->discount;
                        $discount_amount = $discount->discount;
                    } else {
                        $discount_price = ($final_price * $discount->discount) / 100;
                        $item_price = $final_price - $discount_price;

                        $coupon_type = "voucher";
                        $coupon_amount = $discount->discount;
                        $discount_amount = $discount_price;
                    }
                } else {
                    $error = 'Your voucher Expired!';
                }
            } 

            else {
                    if ($coupon_data && $coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
                        if ($coupon_data->limit > $user_data->count()) {
                            if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
                                foreach ($cart_data as $item) {

                                    $product = product::where('id', $item['product_id'])->first();
                                    if ($product->discount_price > 0) {
                                        if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                            $total_product = $product->discount_price * $item['quantity'];
                                        } else {
                                            $total_product = $product->min_sale_price * $item['quantity'];
                                        }
                                    } else {
                                        $total_product = $product->min_sale_price * $item['quantity'];
                                    }


                                    if ($coupon_data->merchendise_btn == 'some_product') {
                                        $product = json_decode($coupon_data->merchendise);
                                        if (in_array($item['product_id'], $product)) {
                                            if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                                $item_price += $total_product - $coupon_data->face_value;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
                                            } else {
                                                $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                                $item_price    += $total_product - $discount_price;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }
                                        } else {
                                            $item_price += $total_product;
                                        }
                                    } else if ($coupon_data->merchendise_btn == 'category_product') {
                                        $product = json_decode($coupon_data->merchendise);
                                        $category = product::where('id', $item['product_id'])->first();
                                        if (in_array($category->category_id, $product)) {
                                            if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                                $item_price += $total_product - $coupon_data->face_value;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                // $discount_amount += $total_product - $coupon_data->face_value;
                                                $discount_amount += $coupon_data->face_value;
                                            } else {
                                                $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                                $item_price    += $total_product - $discount_price;

                                                $coupon_type = $coupon_data->coupon_type;
                                                $coupon_amount += $coupon_data->face_value;
                                                $discount_amount += $discount_price;
                                            }
                                        } else {
                                            $item_price += $total_product;
                                        }
                                    } else {
                                        if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                            $item_price += $total_product - $coupon_data->face_value;

                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            // $discount_amount += $total_product - $coupon_data->face_value;
                                            $discount_amount += $coupon_data->face_value;
                                        } else {
                                            $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                            $item_price    += $total_product - $discount_price;

                                            $coupon_type = $coupon_data->coupon_type;
                                            $coupon_amount += $coupon_data->face_value;
                                            $discount_amount += $discount_price;
                                        }
                                    }
                                }
                            } else {
                                $error = 'Your Coupon Expired!';
                            }
                        } else {
                            $error = 'Coupon Limit Exceeded';
                        }
                    } else {
                        $item_price = $final_price;
                    }
                }

                    $final_price = $item_price;
                    
            $address = DB::table('addresses')->where('id',$request->address_id)->first();

            $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
            ->select('notifications.*','addresses.unit')
            ->where('notifications.user_id', Auth::user()->id)
            ->where('notifications.postcode', $address->postcode)
            ->where('addresses.unit', $address->unit)
            ->latest()
            ->first();
    
            $date = date('Y-m-d');
            $last_order_date = implode('-',array_reverse(explode('/',$user_last_order->delivery_date ?? '')));
            $consolidate_order_is = '';
            
            if($user_last_order &&  $last_order_date > $date){
                $old_order_total_amount = UserOrder::where('consolidate_order_no', $user_last_order->consolidate_order_no)
                ->sum('final_price');

                $old_shipping_charge = UserOrder::where('consolidate_order_no', $user_last_order->consolidate_order_no)
                ->where('ship_charge','-8')->first();

    
                $total_amount_with_new_and_old_order = $old_order_total_amount + $final_price;

                $consolidate_order_is = $user_last_order->consolidate_order_no;
                $payment_mode = $user_last_order->payment_mode;
    
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

            return view('frontend.checkout', [
                "total_product"         => DB::table('carts')->where('use_id',Auth::user()->id)->sum('total_price'),
                "payment_mode"          => $payment_mode,
                "consolidate_order_is"  => $consolidate_order_is,
                'final_price'           => $final_price,
                'sub_total'             => $sub_total,
                'discount_amount'       => $discount_amount,   
                'shipping_charge'       => $shipping_charge, 
                'address_id'            => $request->address_id,
                'coupon'                => $request->coupon,
                'delivery_date'         => $request->delivery_date,
                'remark'                => $request->remark,
                'coupon_type'           => $coupon_type
            ]);
        }

        return redirect()->route('Home')->with('msg', 'Please Add Some Product In Cart');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     public function get_coupon_details($coupon,$cart_data,$date,$product_original_price,$final_price){
       
            $coupon_data = Cupon::where('coupon', $coupon)->first();
            $user_data = UserOrder::where('coupon_code', $coupon)->where('user_id', Auth::user()->id)->get();
    

            $item_price = 0;
            $discount_price = 0;
            $coupon_amount = 0;
            $discount_amount = 0;
            $coupon_type = '';
            $coupon_code = null;
            $total_product = 0;

            $voucherCode = VoucherCode::where('code', $coupon)->count();
            $voucherCode1 = VoucherCode::where('code', $coupon)->first();

            if ($voucherCode > 0) {
                $voucher_id = $voucherCode1->voucher_id;
                $discount = Voucher::find($voucher_id);
                // echo $voucherCode1->expiry_date;
                if ($date->toDateString() <= $voucherCode1->expiry_date && $voucherCode1->status == 0) {
                    if ($discount->discount_type == 'discount_by_value_btn') {
                        $item_price = $final_price - $discount->discount;

                        $coupon_type = "voucher";
                        $coupon_amount = $discount->discount;
                        $discount_amount = $discount->discount;
                    } else {
                        $discount_price = ($final_price * $discount->discount) / 100;
                        $item_price = $final_price - $discount_price;

                        $coupon_type = "voucher";
                        $coupon_amount = $discount->discount;
                        $discount_amount = $discount_price;
                    }
                } else {
                    $error = 'Your voucher Expired!';
                }
            } 

            else {
            

            if ($coupon_data && $coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
                if ($coupon_data->limit > $user_data->count()) {
                    if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
                        foreach ($cart_data as $item) {

                            $product = product::where('id', $item['product_id'])->first();
                            if ($product->discount_price > 0) {
                                if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                    $total_product = $product->discount_price * $item['quantity'];
                                } else {
                                    $total_product = $product->min_sale_price * $item['quantity'];
                                }
                            } else {
                                $total_product = $product->min_sale_price * $item['quantity'];
                            }


                            if ($coupon_data->merchendise_btn == 'some_product') {
                                $product = json_decode($coupon_data->merchendise);
                                if (in_array($item['product_id'], $product)) {
                                    if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                        $item_price += $total_product - $coupon_data->face_value;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        $discount_amount += $coupon_data->face_value;
                                    } else {
                                        $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                        $item_price    += $total_product - $discount_price;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        $discount_amount += $discount_price;
                                    }
                                } else {
                                    $item_price += $total_product;
                                }
                            } else if ($coupon_data->merchendise_btn == 'category_product') {
                                $product = json_decode($coupon_data->merchendise);
                                $category = product::where('id', $item['product_id'])->first();
                                if (in_array($category->category_id, $product)) {
                                    if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                        $item_price += $total_product - $coupon_data->face_value;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        // $discount_amount += $total_product - $coupon_data->face_value;
                                        $discount_amount += $coupon_data->face_value;
                                    } else {
                                        $discount_price = ($total_product * $coupon_data->face_value) / 100;
                                        $item_price    += $total_product - $discount_price;

                                        $coupon_type = $coupon_data->coupon_type;
                                        $coupon_amount += $coupon_data->face_value;
                                        $discount_amount += $discount_price;
                                    }
                                } else {
                                    $item_price += $total_product;
                                }
                            } else {
                                if ($coupon_data->coupon_type == 'discount_by_value_btn') {
                                    $item_price += $total_product - $coupon_data->face_value;

                                    $coupon_type = $coupon_data->coupon_type;
                                    $coupon_amount += $coupon_data->face_value;
                                    // $discount_amount += $total_product - $coupon_data->face_value;
                                    $discount_amount += $coupon_data->face_value;
                                } else {
                                    $discount_price = ($total_product * $coupon_data->face_value) / 100;

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
        }

            return [
                'item_price'        => $item_price,
                'discount_price'    => $discount_price,
                'coupon_amount'     => $coupon_amount ,
                'discount_amount'   => $discount_amount ,
                'coupon_type'       => $coupon_type,
                'coupon_code'       => $coupon_code ,
                'total_product'     => $total_product,
                'total_product_original_price' => $product_original_price
            ];
     }


    //  make cod payment
     function make_payment_with_cod($request,$address,$order_number,$month,$year,$final_price,$if_coupon_data,$ship_charge,$coupon,$cart_data,$date,$sub_total){
        $today_date = date('Y-m-d');
        $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
                ->select('notifications.*','addresses.unit')
                ->where('notifications.user_id', Auth::user()->id)
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
                ->where('notifications.user_id', Auth::user()->id)
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
                    'user_id'               => Auth::user()->id,
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
                    'user_id'                   => Auth::user()->id,
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
                'user_id'               => Auth::user()->id,
                'order_no'              => $order_number,
                'payment_mode'          => 'COD',
                'delivery_date'         => $request->delivery_date,
                'remark'                => $request->remark,
            ]);
        }

        $payment = UserOrderPayment::create([
            'consolidate_order_no'  => $consolidate_order_number,
            'user_id'               => Auth::user()->id,
            'buyer_name'        => $address->name,
            'buyer_phone'       => $address->mobile_number,
            'payment_type'      => 'COD',
            'time'              => now(),
            'amount'            => $final_price,
            'currency'          => 'sgd',
            'status'            => 'succeeded',
        ]);

        $check_voucher_code = VoucherCode::where('code', $coupon)->first();

        UserOrder::create([
            'payment_id'                => $payment->id,
            'payment_reference_id'      => "COD",
            'name'                      => $address->name,
            'email'                     => Auth::user()->email,
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
            'user_id'                   => Auth::user()->id,
            'coupon_code'               => empty($check_voucher_code) ? $request->coupon : null,
            'voucher_code'              => !empty($check_voucher_code) ? $request->coupon : null,
            'discount_amount'           => $if_coupon_data['discount_amount'],
            'coupon_amount'             => $if_coupon_data['coupon_amount'],
            'coupon_type'               => $if_coupon_data['coupon_type'],
            'status'                    => 0,
            'total_product_price'       => $if_coupon_data['total_product_original_price'],
            'ship_charge'               => $ship_charge,
        ]);

        

        $coupon_data = Cupon::where('coupon', $coupon)->first();
        $user_data = UserOrder::where('coupon_code', $coupon)->where('user_id', Auth::user()->id)->get();

        $voucherCode = VoucherCode::where('code', $coupon)->count();
        $voucherCode1 = VoucherCode::where('code', $coupon)->first();

            // if ($voucherCode > 0) {
                
                
                if ($voucherCode1 && $date->toDateString() <= $voucherCode1->expiry_date && $voucherCode1->status == 0) {
                    $voucher_id = $voucherCode1->voucher_id;
                    $discount = Voucher::find($voucher_id);
                    
                    foreach ($cart_data as $item) {
                        $product = product::where('id',$item['product_id'])->first();
                            if($product->discount_price > 0){
                                if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                    $total_product              = $product->discount_price *  $item['quantity'];
                                    
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
                                $item_price = $final_price - $discount->discount;
        
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
                                'order_no'          => $order_number,
                            ]);

                        UserOrderItem::create([
                            'user_id'       => Auth::user()->id,
                            'order_no'      => $order_number,
                            'consolidate_order_no' => $consolidate_order_number,
                            'product_id'    => $item['product_id'],
                            'product_name'  => $product->product_name,
                            'barcode'       => $product->barcode,
                            'product_image' => $product->img_path,
                            'quantity'      => $item['quantity'],
                            'product_price' => $product->min_sale_price,
                            'total_price'   => $product->min_sale_price * $item['quantity'],
                            // 'after_discount' => ($product->min_sale_price * $item['quantity']),
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
                            $offer_discount_price       = $product->discount_price *  $item['quantity'];
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
                            'order_no'      => $order_number,
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
                            'order_no'      => $order_number,
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
                            'order_no'      => $order_number,
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
                        $total_product              = $product->discount_price *  $item['quantity'];
                        
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
                    'order_no'      => $order_number,
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
            "owner_id"              => Auth::user()->id,
            "order_by"              => 'self',
            "quotation_id"          => NULL,
            "order_number"          => $consolidate_order_number,
            "customer_name"         => $address->name,
            "customer_id"           => Auth::user()->id,
            "date"                  => $order_date,
            "customer_address"      => $address->address . ' ' . $address->name . ' ' . $address->postcode . ' ' . $address->mobile_number . ' ' . $address->unit,
            "customer_type"         => 'retail',
            "mobile_no"             => $address->mobile_number,
            "email_id"              => Auth::user()->email,
            "tax"                   => '0',
            "shipping_type"         => 'delivery',
            "products_details"      => $allProductDetails,
            "tax_inclusive"         => '0',
            "untaxted_amount"       => $if_coupon_data['total_product'],
            "GST"                   => '',
            "sub_total"             => $sub_total,
            "created_at"            => now(),
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
                    'order_no'               => $order_number,
                    'warehouse_id'           => $get_warehouse ? $get_warehouse->id : '',
                    'warehouse_name'         => $stock->warehouse_name,
                    'user_id'                => Auth::user()->id,
                    'product_id'             => $item['product_id'],
                    'deduct_quantity'        => $deduct_quantity
                    ]);
                }
            }
        }
                

                // delete from cart
                foreach($cart_data as $delete_item){
                    cart::where('use_id', Auth::user()->id)
                    ->where('product_id',$delete_item['product_id'])
                    ->delete();
                }
    
                $order_data = UserOrderItem::where('order_no', $order_number)->get();
    
                $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
                $data = DriverDate::all();
    
                $notification = Notification::join('addresses','addresses.id','=','notifications.address_id')
                    ->select('notifications.*','addresses.unit')
                    ->where('notifications.user_id', Auth::user()->id)
                    ->where('notifications.postcode', $address->postcode)
                    ->where('addresses.unit', $address->unit)
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
               
                // echo 1;
    
            return[
                "orders"                    => $order_data,
                "order_no"                  => $order_number,
                "consolidate_order_number"  => $consolidate_order_number,
                "new_data"                  => $new_data,
                "data"                      => $data,
                'deliver_date'              => $deliver_date,
                'remark'                    => $remark,
                'payment_id'                => $payment->id,
            ];
       

     }


    //  get loyalty point
    function get_loyalty_point($sub_total,$payment_id){
        LoyaltyPoint::create([
            'user_id'               => Auth::user()->id,
            'gained_points'         => $sub_total,
            // 'spend_points'          => $request->paid_points,
            // 'remains_points'        => $loyalty_wallet,
            'transaction_id'        => $payment_id,
            'transaction_amount'    => 0,
            'transaction_date'      => now(),
            "log"                   => 'Purchase Order'
        ]);

        $old_data =  LoyaltyPointshop::where('user_id',Auth::user()->id)->first();

        LoyaltyPointshop::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['loyalty_points' => (int)($old_data->loyalty_points + $sub_total) , 'last_transaction_id' => $payment_id]
        );
    } 


   function make_payment_with_hit_pay($request,$address,$order_number,$month,$year,$final_price,$if_coupon_data,$ship_charge,$coupon,$sub_total){
        $client = new Client();
        // https://api.sandbox.hit-pay.com/v1/payment-requests test api
        // https://api.hit-pay.com/v1/payment-requests main api
        $res = $client->request('POST', 'https://api.sandbox.hit-pay.com/v1/payment-requests', [
            'headers' => [
                'X-BUSINESS-API-KEY' => env('HIT_PAY_API_KEY'),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'X-Requested-With' => 'XMLHttpRequest',
            ],
            'form_params' => [
                'email'     => Auth::user()->email,
                'name'      => Auth::user()->name,               
                'redirect_url' => route('payment.make_payment_with_hit_pay',[
                    'address'           => $address,
                    'delivery_date'     => $request->delivery_date,
                    'remark'            => $request->remark,
                    'address_id'        => $request->address_id,
                    'order_number'      => $order_number,
                    'month'             => $month,
                    'year'              => $year,
                    'final_price'       => $final_price,
                    'if_coupon_data'    => $if_coupon_data,
                    'ship_charge'       => $ship_charge,
                    'coupon'            => $coupon,
                    'sub_total'         => $sub_total

                ]),
                'reference_number' => 'REF123',
                'webhook' => route('webhook'),
                'currency' => 'SGD',
                'amount' => $final_price
            ]
        ]);

        $data = json_decode($res->getBody(), true);
        return $data['url'];

    }



    public function store(Request $request){

        $addresses = address::where('id', $request->address_id)->first();
        $data = cart::where('use_id', Auth::user()->id)->get();

        $date = Carbon::now();

        $sub_total = 0;
        $final_price = 0;
        $shipping_charge = 0;
        $cart_data = [];
        $product_original_price = 0;
        foreach($data as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock){
                $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
                // Cart::where('use_id', Auth::user()->id)->where('product_id',$product->id)->get();
                $cart_data[] = [
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity
                ] ;
                $product_original_price += $product->min_sale_price * $item->quantity;
            }
        }
        $sub_total = $final_price;

        if(!empty($request->coupon)){
            $coupon_date = $this->get_coupon_details($request->coupon,$cart_data,$date,$product_original_price,$final_price);
            $final_price = $coupon_date['item_price'];
        }else{
            $coupon_date = [
                'item_price'        => $final_price,
                'discount_price'    => null,
                'coupon_amount'     => null,
                'discount_amount'   => null ,
                'coupon_type'       => null,
                'coupon_code'       => null ,
                'total_product'     => $final_price,
                'total_product_original_price' => $product_original_price
            ];
        }
       
        $price_for_loyalty_point = $coupon_date['item_price'];

        // dd($final_price['item_price']);

        
        $address = DB::table('addresses')->where('id',$request->address_id)->first();

        $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
        ->select('notifications.*','addresses.unit')
        ->where('notifications.user_id', Auth::user()->id)
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



        if ($request->mode == "cod") {
            $data = $this->make_payment_with_cod($request,$address,$order_number,$month,$year,$final_price,$coupon_date,$shipping_charge,$request->coupon,$cart_data,$date,$sub_total);
            $this->get_loyalty_point((int)$price_for_loyalty_point,$data['payment_id']);
            return  redirect()->route('order.select-delivery-date')->with($data);
        }
        
        if($request->mode == 'hitpay'){
            $data = $this->make_payment_with_hit_pay($request,$address,$order_number,$month,$year,$final_price,$coupon_date,$shipping_charge,$request->coupon,$sub_total);
            return redirect($data);
        }







        return ;





        $addresses = address::where('id', $request->address_id)->first();

        $data = cart::where('use_id', Auth::user()->id)->get();

        $date = Carbon::now();
    
        $order_number = random_int(100000, 999999);
        $data['total_product_price'] = cart::where('use_id', Auth::user()->id)->sum('total_price');

        $sub_total = 0;
        $final_price = 0;
        $shipping_charge = 0;
        foreach($data as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock){
                $final_price += !empty($product->discount_price) ? ($product->discount_price * $item->quantity ): ($product->min_sale_price * $item->quantity);
            }
        }
        $sub_total = $final_price;

       
    
            // 
            

           

        if ($request->mode == "cod") {
                return redirect()->route('index.order_payment', [
                    'name'          => $addresses[0]["name"],
                    'mobile_no'     => $addresses[0]["mobile_number"],
                    'address'       => $addresses[0]["address"],
                    'postcode'      => $addresses[0]["postcode"],
                    'country'       => $addresses[0]["country"] != null ? $addresses[0]["country"] : "singapore",
                    'state'         => $addresses[0]["state"],
                    'city'          => $addresses[0]["city"],
                    'payment_type'  => 'COD',
                    'ship_charge'   => $shipping_charge,
                    'coupon'        => $request->coupon,
                    'wallat_points' => $loyalty_points->loyalty_points,
                    'paid_points'   => 0,
                    'remains_points' => $remains_points,
                    'amount' => $total_pay_amount,
                    'status' => 'completed',
                    'address_id' => $request->address_id,
                    'coupon'    => $request->coupon,
                    'remark'    => $request->remark,
                    'delivery_date' => $request->delivery_date
                ]);
            } else {
                $client = new Client();
    
    
                // https://api.sandbox.hit-pay.com/v1/payment-requests test api
                // https://api.hit-pay.com/v1/payment-requests main api
                $res = $client->request('POST', 'https://api.hit-pay.com/v1/payment-requests', [
                    'headers' => [
                        'X-BUSINESS-API-KEY' => env('HIT_PAY_API_KEY'),
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'form_params' => [
                        'email' => Auth::user()->email,
                        'name'  => Auth::user()->name,
                        // 'redirect_url'=>'https://ykpte.tbcsstesting.com/order_payment&name='.$request->name.'&mobile_no='.$request->mobile_no.'&address='.$request->address.'&postcode='.$request->postcode.'&country='.$request->country.'&state='.$request->state.'&city='.$request->city.'&coupon='.$request->coupon,
                        'redirect_url' => route('create.order_payment', [
                            'name'          => $addresses[0]["name"],
                            'mobile_no'     => $addresses[0]["mobile_number"],
                            'address'       => $addresses[0]["address"],
                            'postcode'      => $addresses[0]["postcode"],
                            'country'       => $addresses[0]["country"] != null ? $addresses[0]["country"] : "singapore",
                            'state'         => $addresses[0]["state"],
                            'city'          => $addresses[0]["city"],
                            'ship_charge'   => $shipping_charge,
                            'coupon'        => $request->coupon,
                            'wallat_points' => $loyalty_points->loyalty_points,
                            'paid_points'   => $total_pay_points,
                            'remains_points' => $remains_points,
                        ]),
                        'reference_number' => 'REF123',
                        'webhook' => route('webhook'),
                        'currency' => 'SGD',
                        'amount' => $total_pay_amount
                    ]
                ]);
                $data = json_decode($res->getBody(), true);
                return redirect($data['url']);
            }
        
    }
    // {


    //     $session_data = ModelsSession::where('id', Session::getId())->first();

    //     $address = address::where('id', $session_data->address_id)->get();

    //     foreach ($address as $key => $value) {
    //         $obj = [
    //             'name'          => $value["name"],
    //             'mobile_no'     => $value["mobile_number"],
    //             'address'       => $value["address"],
    //             'postcode'      => $value["postcode"],
    //             'country'       => $value["country"],
    //             'state'         => $value["state"],
    //             'city'          => $value["city"],
    //         ];
    //     }

    //     $products = cart::where('use_id', Auth::user()->id)->get();
    //     // dd($products);

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

    //         $product = product::where('id', $value->product_id)->first();
    //         if ($product->discount_price > 0) {
    //             if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
    //                 $order_sum += $product->discount_price * $value->quantity;
    //             } else {
    //                 $order_sum += $product->min_sale_price * $value->quantity;
    //             }
    //         } else {
    //             $order_sum += $product->min_sale_price * $value->quantity;
    //         }
    //     }

    //     $order_number = random_int(100000, 999999);
    //     $data['total_product_price'] = cart::where('use_id', Auth::user()->id)->sum('total_price');

    //     // 
    //     $coupon_data = Cupon::where('coupon', $request->coupon)->first();
    //     $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', Auth::user()->id)->get();

    //     $cart_data = Cart::where('use_id', Auth::user()->id)->get();
    //     $item_price = 0;
    //     $discount_price = 0;
    //     $coupon_amount = 0;
    //     $discount_amount = 0;
    //     $coupon_type = '';
    //     $coupon_code = null;
    //     $total_product = 0;




    //     if ($coupon_data && !empty($request->coupon)) {
    //         if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
    //             if ($coupon_data->limit > $user_data->count()) {
    //                 if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
    //                     $coupon_code = $request->coupon;
    //                     $change_use = Cupon::where('coupon', $request->coupon)->first();
    //                     // Cupon::where('coupon', $request->coupon)->update([
    //                     //     'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
    //                     // ]);
    //                     foreach ($cart_data as $item) {

    //                         $product = product::where('id', $item->product_id)->first();
    //                         if ($product->discount_price > 0) {
    //                             if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
    //                                 $total_product   = $product->discount_price * $item->quantity;
    //                             } else {
    //                                 $total_product = $product->min_sale_price * $item->quantity;
    //                             }
    //                         } else {
    //                             $total_product = $product->min_sale_price * $item->quantity;
    //                         }


    //                         if ($coupon_data->merchendise_btn == 'some_product') {
    //                             $product = json_decode($coupon_data->merchendise);
    //                             if (in_array($item->product_id, $product)) {
    //                                 if ($coupon_data->coupon_type == 'discount_by_value_btn') {
    //                                     $item_price += $total_product - $coupon_data->face_value;

    //                                     $coupon_type = $coupon_data->coupon_type;
    //                                     $coupon_amount += $coupon_data->face_value;
    //                                     // $discount_amount += $total_product - $coupon_data->face_value;
    //                                     $discount_amount += $coupon_data->face_value;
    //                                 } else {
    //                                     $discount_price = ($total_product * $coupon_data->face_value) / 100;
    //                                     $item_price    += $total_product - $discount_price;

    //                                     $coupon_type = $coupon_data->coupon_type;
    //                                     $coupon_amount += $coupon_data->face_value;
    //                                     $discount_amount += $discount_price;
    //                                 }
    //                             } else {
    //                                 $item_price += $total_product;
    //                             }
    //                         } else if ($coupon_data->merchendise_btn == 'category_product') {
    //                             $product = json_decode($coupon_data->merchendise);
    //                             $category = product::where('id', $item->product_id)->first();
    //                             if (in_array($category->category_id, $product)) {
    //                                 if ($coupon_data->coupon_type == 'discount_by_value_btn') {
    //                                     $item_price += $total_product - $coupon_data->face_value;

    //                                     $coupon_type = $coupon_data->coupon_type;
    //                                     $coupon_amount += $coupon_data->face_value;
    //                                     // $discount_amount += $total_product - $coupon_data->face_value;
    //                                     $discount_amount += $coupon_data->face_value;
    //                                 } else {
    //                                     $discount_price = ($total_product * $coupon_data->face_value) / 100;
    //                                     $item_price    += $total_product - $discount_price;

    //                                     $coupon_type = $coupon_data->coupon_type;
    //                                     $coupon_amount += $coupon_data->face_value;
    //                                     $discount_amount += $discount_price;
    //                                 }
    //                             } else {
    //                                 $item_price += $total_product;
    //                             }
    //                         } else {
    //                             if ($coupon_data->coupon_type == 'discount_by_value_btn') {
    //                                 $item_price += $total_product - $coupon_data->face_value;

    //                                 $coupon_type = $coupon_data->coupon_type;
    //                                 $coupon_amount += $coupon_data->face_value;
    //                                 // $discount_amount += $total_product - $coupon_data->face_value;
    //                                 $discount_amount += $coupon_data->face_value;
    //                             } else {
    //                                 $discount_price = ($total_product * $coupon_data->face_value) / 100;
    //                                 $item_price    += $total_product - $discount_price;


    //                                 $coupon_type = $coupon_data->coupon_type;
    //                                 $coupon_amount += $coupon_data->face_value;
    //                                 $discount_amount += $discount_price;
    //                             }
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //     } else {
    //         $item_price = $order_sum;
    //     }

    //     // $session_data->final_price
    //     $order_sum = $session_data->final_price;

    //     $remains_points = $session_data->loyalty_points;

    //     // if($request->mode != "cod" ){

    //     if ($request->loyaltyPoint != "false") {

    //         $data = LoyaltyPointTodays::all()->first();
    //         $amount = $data->amount;
    //         $points = $data->points;

    //         $one_dollar_points = $points / $amount;

    //         $total_pay_points = $order_sum * $one_dollar_points;

    //         $total_have_points = $session_data->loyalty_points;;

    //         if ($total_have_points == $total_pay_points) {
    //             $total_pay_amount = 0;
    //         } else if ($total_have_points > $total_pay_points) {
    //             $having_points_amount = $total_have_points / $one_dollar_points;

    //             $total_pay_amount = $order_sum - $having_points_amount;

    //             if ($total_pay_amount < 0) {    // having points are grater then pay points
    //                 $remains_points = $total_pay_amount * -1 * $one_dollar_points;
    //                 $total_pay_amount = 0;
    //             }
    //         } else {
    //             $total_pay_amount = $order_sum;
    //             $total_pay_points = 0;
    //         }
    //         // }else{
    //         //     $total_pay_amount = $order_sum;
    //         //     $total_pay_points = 0;
    //         // }
    //     } else {
    //         $total_pay_amount = $order_sum;
    //         $total_pay_points = 0;
    //     }

    //     if ($total_pay_amount == 0) {

    //         return redirect()->route('index.order_payment', [
    //             'name'          => $address[0]["name"],
    //             'mobile_no'     => $address[0]["mobile_number"],
    //             'address'       => $address[0]["address"],
    //             'postcode'      => $address[0]["postcode"],
    //             'country'       => $address[0]["country"],
    //             'state'         => $address[0]["state"],
    //             'city'          => $address[0]["city"],
    //             'coupon'        => $session_data->coupon,
    //             'ship_charge'   => $session_data->shipping_charge,
    //             'wallat_points' => $session_data->loyalty_points,
    //             'paid_points'   => $total_pay_points,
    //             'remains_points' => $remains_points,
    //             'amount' => $total_pay_amount,
    //             'payment_type' => 'COD',
    //             'status' => 'completed'
    //         ]);
    //     } else if ($request->mode == "cod") {

    //         return redirect()->route('index.order_payment', [
    //             'name'          => $address[0]["name"],
    //             'mobile_no'     => $address[0]["mobile_number"],
    //             'address'       => $address[0]["address"],
    //             'postcode'      => $address[0]["postcode"],
    //             'country'       => $address[0]["country"] != null ? $address[0]["country"] : "singapore",
    //             'state'         => $address[0]["state"],
    //             'city'          => $address[0]["city"],
    //             'payment_type' => 'COD',
    //             'ship_charge'   => $session_data->shipping_charge,
    //             'coupon'        => $session_data->coupon,
    //             'wallat_points' => $session_data->loyalty_points,
    //             'paid_points'   => 0,
    //             'remains_points' => $remains_points,
    //             'amount' => $total_pay_amount,
    //             'status' => 'completed'
    //         ]);
    //     } else {

    //         $client = new Client();


    //         // https://api.sandbox.hit-pay.com/v1/payment-requests test api
    //         // https://api.hit-pay.com/v1/payment-requests main api
    //         $res = $client->request('POST', 'https://api.hit-pay.com/v1/payment-requests', [
    //             'headers' => [
    //                 'X-BUSINESS-API-KEY' => env('HIT_PAY_API_KEY'),
    //                 'Content-Type' => 'application/x-www-form-urlencoded',
    //                 'X-Requested-With' => 'XMLHttpRequest',
    //             ],
    //             'form_params' => [
    //                 'email' => Auth::user()->email,
    //                 'name'  => Auth::user()->name,
    //                 // 'redirect_url'=>'https://ykpte.tbcsstesting.com/order_payment&name='.$request->name.'&mobile_no='.$request->mobile_no.'&address='.$request->address.'&postcode='.$request->postcode.'&country='.$request->country.'&state='.$request->state.'&city='.$request->city.'&coupon='.$request->coupon,
    //                 'redirect_url' => route('create.order_payment', [
    //                     'name'          => $address[0]["name"],
    //                     'mobile_no'     => $address[0]["mobile_number"],
    //                     'address'       => $address[0]["address"],
    //                     'postcode'      => $address[0]["postcode"],
    //                     'country'       => $address[0]["country"] != null ? $address[0]["country"] : "singapore",
    //                     'state'         => $address[0]["state"],
    //                     'city'          => $address[0]["city"],
    //                     'ship_charge'   => $session_data->shipping_charge,
    //                     'coupon'        => $session_data->coupon,
    //                     'wallat_points' => $session_data->loyalty_points,
    //                     'paid_points'   => $total_pay_points,
    //                     'remains_points' => $remains_points,
    //                 ]),
    //                 'reference_number' => 'REF123',
    //                 'webhook' => route('webhook'),
    //                 'currency' => 'SGD',
    //                 'amount' => $total_pay_amount
    //             ]
    //         ]);
    //         $data = json_decode($res->getBody(), true);
    //         return redirect($data['url']);
    //     }
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
        //
    }
}
