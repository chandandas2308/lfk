<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\CheckInSetting;
use App\Models\DailyCheckInCoins;
use App\Models\DriverDate;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointshop;
use App\Models\LoyaltyPointTodays;
use App\Models\Notification;
use App\Models\Order;
use App\Models\ProductRedemptionShop;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use App\Models\UserOrderPayment;
use App\Models\Voucher;
use App\Models\VoucherCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CoinsController extends Controller
{
    //

    // prev order
    public function prevOrder(Request $request){
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "address_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        } else {

            $addressIs = address::find(request()->address_id);
            
            if ($addressIs != null) {
                $checkAddress = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
                $prevOrders = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();

                if ($checkAddress > 0) {
                    $ordered_items = UserOrderItem::where('consolidate_order_no', $prevOrders->consolidate_order_no)->get();
                    return response()->json([
                        "status" => true,
                        "message" => "Success",
                        "prev_order" => $ordered_items,
                    ], 200);
                }else{
                    return response()->json([
                        "status" => true,
                        "message" => "No order found on this address",
                    ], 200);
                }
            }else{
                return response()->json([
                    "status" => true,
                    "message" => "No order found on this address",
                ], 200);
            }
        }
    }

    // daily checkin
    public function dailyCheckInCoins(){
        $data = CheckInSetting::first();

        $arr = [
            [
                "Day" =>$data->day1
            ],
            [
                "Day" =>$data->day2
            ],
            [
                "Day" =>$data->day3
            ],
            [
                "Day" =>$data->day4
            ],
            [
                "Day" =>$data->day5
            ],
            [
                "Day" =>$data->day6
            ],
            [
                "Day" =>$data->day7
            ],
        ];
        return $arr;
    }

    public function redemptionShopVoucherList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        } else {

            $date = Carbon::now();

            $data = VoucherCode::where('user_id', $request->user_id)->where('expiry_date', '>=', $date->toDateString())->get();

            return response()->json([
                "status" => "success",
                "data" => $data
            ], 200);
        }
    }
    
    public function myVoucher(Request $request){
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        } else {
            $data = VoucherCode::where('user_id', $request->user_id)->get();
            return response()->json([
                "status" => "success",
                "data" => $data
            ], 200);
        }
    }

    public function dayCoins($id)
    {
        $data = DailyCheckInCoins::orderBy('id', 'desc')->where('user_id', $id)->first();

        return response()->json([
            "status" => "success",
            "data" => $data
        ], 200);
    }

    public function redemptionShopProduct()
    {
        $data = ProductRedemptionShop::get();

        $arr = [];
        foreach($data as $key=>$value){
            array_push($arr,[
                "id" => $value->id,
                "product_name" => $value->product_name,
                "product_id" => $value->product_id,
                "product_category" => $value->product_category,
                "product_variant" => $value->product_variant,
                "vendor_id" => $value->vendor_id,
                "sku_code" => $value->sku_code,
                "uom" => $value->uom,
                "points" => $value->points,
                "quantity" => $value->quantity,
                "image" => json_decode($value->images)[0],
            ]);
        }

        return response()->json([
            "status" => "success",
            "data" => $arr
        ], 200);
    }

    public function redemptionShopVoucher()
    {
        $data = Voucher::get();

        return response()->json([
            "status" => "success",
            "data" => $data
        ], 200);
    }

    public function redemptionShopGenerateCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        } else {

            $voucher = Voucher::find($request->id);

            $voucher_code = "LKFVC".((rand()*10000)+5);
            
            $user_points = LoyaltyPointshop::where('user_id', $request->user_id)->first();

            $loyalty_wallet = ($user_points->loyalty_points-$voucher->points);

            LoyaltyPointshop::updateOrCreate(
                ['user_id' => $request->user_id],
                ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => 1]
            );

            VoucherCode::create([
                'voucher_id' => $request->id,
                'code' => $voucher_code,
                'user_id' => $request->user_id,
                'status' => false,
                'expiry_date' => $voucher->expiry_date
            ]);

            return response()->json([
                "status" => true,
                "message" => "success",
                "code" => $voucher_code,
                "expiry_date" => $voucher->expiry_date,
            ], 200);
        }
    }

    public function redemptionShopCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "product_id" => "required",
            "quantity" => "required",
            "address_id" => "required",
            "delivery_date" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        } else {
            $product_details = ProductRedemptionShop::find($request->product_id);
            $addressIs = address::find($request->address_id);
            $checkAddress = Notification::where('user_id', $request->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
    
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
    
            if ($checkAddress > 0) {
    
                $notification = Notification::where('user_id', $request->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date("d/m/Y"))->first();
    
                $consolidate_order_number = $notification->consolidate_order_no;
                $delivery_date = $notification->delivery_date;
                $end_date = $notification->end_date;
                $payment_mode = 'points';
        
                $data['order_no'] = $consolidate_order_number;
    
                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => $request->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => $request->user_id,
                    'order_no' => $order_number,
                    'delivery_date' => $delivery_date,
                    'end_date' => $end_date,
                    // 'payment_mode' => 'points',
                    'payment_mode' => $notification->payment_mode,
                    'remark' => $request->remark
                ]);       
    
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
                    'address_id' => $request->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => $request->user_id,
                    'order_no' => $order_number,
                    'payment_mode' => 'points',
                    'delivery_date' => $request->delivery_date,
                    'remark' => $request->remark,
                ]);
            }

            $user_details = User::find($request->user_id);
    
            $payment=UserOrderPayment::create([
                'payment_id' => 'points',
                'payment_request_id'=> 'points',
                'buyer_name'=> $addressIs->name,
                'buyer_phone'=> $addressIs->mobile_number,
                'buyer_email'=> $user_details->email,
                'points' => $product_details->points,
                'fees'=> 0,
                'payment_type'=> 'points',
                'time'=> now(),
                'amount'=> 0,
                'currency'=> 'sgd',
                'status'=> 'succeeded',
                'reference_number'=> 'points',
            ]);
    
            $data = LoyaltyPointTodays::all()->first();
            $user_points = LoyaltyPointshop::where('user_id', $request->user_id)->first();
    
            $loyalty_wallet = ($user_points->loyalty_points-$product_details->points);
    
            LoyaltyPoint::create([
                'user_id' => $request->user_id,
                'gained_points' => 0,
                'spend_points' => $product_details->points,
                'remains_points' => $loyalty_wallet,
                'transaction_id' => $payment->id,
                'transaction_amount' => 0,
                'transaction_date' => now(),
            ]);
    
            LoyaltyPointshop::updateOrCreate(
                ['user_id' => $request->user_id],
                ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => $payment->id]
            );
    
            UserOrder::create([
                'payment_id'    => $payment->id,
                'payment_refrence_id'    => "points",
                'name'          => $product_details->product_name,
                'email'         => $user_details->email,
                'mobile_no'     => $addressIs->mobile_number,
                'address'       => $addressIs->address,
                'postcode'      => $addressIs->postcode,
                'country'       => "singapore",
                'points' => $product_details->points,
                'state'         => "singapore",
                'city'          => "singapore",
                'final_price'        => 0,
                'order_no'           => $order_number,
                'consolidate_order_no' => $consolidate_order_number,
                'user_id'            => $request->user_id,
                'status'             => 0,
                'total_product_price' => 0,
                'ship_charge'   => 0,
            ]);
    
            UserOrderItem::create([
                'user_id'       => $request->user_id,
                'order_no'      => $order_number,
                'consolidate_order_no' => $consolidate_order_number,
                'product_id'    => $product_details->id,
                'product_name'  => $product_details->product_name,
                'barcode'       => $product_details->product_name,
                'points' => $product_details->points,
                'product_image' => json_decode($product_details->images)[0],
                'quantity'      => 1,
                'product_price' => 0,
                'total_price'   => 0,
            ]);
    
            ProductRedemptionShop::where('id', $product_details->id)->update(['quantity'=>(int)$product_details->quantity-1]);
    
            $date  = Carbon::now();
            $order_date = $date->toDateString();
    
            $details = [
                "product_name" => $product_details->product_name,
                "product_id" => $product_details->id,
                "category_id" => $product_details->product_category,
                "product_variant" => $product_details->product_variant,
                "vendor_id" => $product_details->vendor_id,
                "sku_code" => $product_details->sku_code,
                "points" => $product_details->points,
                "quantity" => 1,
                "image" => json_decode($product_details->images)[0],
                "use_id" => $request->user_id,
                "use_name" => $addressIs->name,
            ];
    
            Order::insert([
                "owner_id" => $request->user_id,
                "order_by" => 'self',
                "quotation_id" => NULL,
                "order_number" => $order_number,
                "customer_name" => $product_details->product_name,
                "customer_id" => $request->user_id,
                "date" => $order_date,
                "customer_address" => $addressIs->address,
                "customer_type" => 'retail',
                "mobile_no" => $addressIs->mobile_number,
                "email_id" => $user_details->email,
                "tax" => '0',
                "shipping_type" => 'delivery',
                "products_details" => json_encode($details),
                "tax_inclusive" => '0',
                "untaxted_amount" => 0,
                "GST" => '',
                "sub_total" => 0,
                "created_at" => now(),
            ]);
    
            $order_data = UserOrderItem::where('order_no', $order_number)->get();
            
            $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
            $data = DriverDate::all();
    
            $notification = Notification::where('user_id', $request->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
    
            $deliver_date = '';
            
            if($notification > 0){
                $notification = Notification::where('user_id', $request->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();
                $deliver_date = $notification->delivery_date;                
            }

            
            $fullSlotDates = [];

            foreach($new_data as $key => $value){
                foreach($data as $key1 => $value1){
                    if($value1->date_time == $value->delivery_date && $value->count == $value1->limit){
                        array_push($fullSlotDates, $value1->date_time);
                    }
                }
            }

            foreach($data as $key1 => $value1){
                if($value1->limit == "0"){
                    array_push($fullSlotDates, $value1->date_time);
                }
            }

            return response()->json([
                "status" => true,
                "message" => "Order successfully ordered",
                "data" => [
                    "orders" => $order_data,
                    "order_no"  => $order_number,
                    "fullSlotDates" => $fullSlotDates,
                    "consolidate_order_number"  => $consolidate_order_number,
                    "delivery_dates_slots" => $new_data,
                    "delivery_date_configuration" => $data,
                    'deliver_date' => $deliver_date,
                    'remark' => $request->remark
                ]
            ], 200);

        }
    }

}
