<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\address;
use App\Models\UserOrderItem;
use Illuminate\Http\Request;
use App\Models\UserOrder;
use App\Models\product;
use App\Models\Order;
use App\Models\User;
use App\Models\cart;
use App\Models\ConsolidateConfig;
use App\Models\Cupon;
use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointshop;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\LoyaltyPointTodays;
use App\Models\DriverDate;
use App\Models\Notification;
use App\Models\UserOrderPayment;
use App\Models\Voucher;
use App\Models\VoucherCode;
use App\Models\VoucherHistory;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class CheckoutApiController extends Controller
{
    public function index($user_id)
    {
        $data = cart::where('use_id', $user_id)->get();
        if ($data->count() > 0) {

            $total_product = cart::where('use_id', $user_id)->sum('total_price');

            $ship_charge = 8;
            if ($total_product < 70) {
                $total_product = $total_product + $ship_charge;
            }

            return response()->json([
                "ship_charge"       => $ship_charge,
                "total_product"     => $total_product,
                "data"              => $data,
            ], 200);
        }
    }

    public function getPaymentDetails($reference_id)
    {
        $data = UserOrderPayment::where('reference_number', $reference_id)->get();
        
        if ($data->count() > 0) {
            return response()->json([
                "status"       => true,
                "message"      => "Records found",
                "data"         => $data,
            ], 200);
        }else{
            return response()->json([
                "status"       => false,
                "message"      => "No records found",
                "data"         => $data,
            ], 404);
        }
    }

    public function store(Request $request, $user_id)
    {
        header('Access-Control-Allow-Methods: * ');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
        header('Access-Control-Allow-Origin: *');
        
        $address = address::where('id', $request->address_id)->get();

        foreach ($address as $key => $value) {
            $obj = [
                'name'          => $value["name"],
                'mobile_no'     => $value["mobile_number"],
                'address'       => $value["address"],
                'postcode'      => $value["postcode"],
                'country'       => $value["country"],
                'state'         => $value["state"],
                'city'          => $value["city"],
            ];
        }

        $customer_id = $user_id;

        $products = cart::where('use_id', $customer_id)->get();

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
                    "use_id" => $customer_id,
                    "use_name" => Auth::user()->name,
                    "quantity" => $value['quantity'],
                    "total_price" => $v['min_sale_price'] * $value['quantity'],
                ];
                array_push($cart, $obj);
                // $order_sum += (float)$v['min_sale_price'] * $value['quantity'];
            }

            $product = product::where('id', $value->product_id)->first();
            if ($product->discount_price > 0) {
                if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                    $order_sum += $product->discount_price * $value->quantity;
                } else {
                    $order_sum += $product->min_sale_price * $value->quantity;
                }
            } else {
                $order_sum += $product->min_sale_price * $value->quantity;
            }
        }

        $order_number = random_int(100000, 999999);
        $data['total_product_price'] = cart::where('use_id', $customer_id)->sum('total_price');



        // 
        $coupon_data = Cupon::where('coupon', $request->coupon)->first();
        $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', $customer_id)->get();

        $cart_data = Cart::where('use_id', $customer_id)->get();
        $item_price = 0;
        $discount_price = 0;
        $coupon_amount = 0;
        $discount_amount = 0;
        $coupon_type = '';
        $coupon_code = null;
        $total_product = 0;




        if ($coupon_data && !empty($request->coupon)) {
            if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
                if ($coupon_data->limit > $user_data->count()) {
                    if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
                        $coupon_code = $request->coupon;
                        $change_use = Cupon::where('coupon', $request->coupon)->first();
                        Cupon::where('coupon', $request->coupon)->update([
                            'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
                        ]);
                        foreach ($cart_data as $item) {

                            $product = product::where('id', $item->product_id)->first();
                            if ($product->discount_price > 0) {
                                if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                    $total_product   = $product->discount_price;
                                } else {
                                    $total_product = $product->min_sale_price;
                                }
                            } else {
                                $total_product = $product->min_sale_price;
                            }


                            if ($coupon_data->merchendise_btn == 'some_product') {
                                $product = json_decode($coupon_data->merchendise);
                                if (in_array($item->product_id, $product)) {
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
                    }
                }
            }
        } else {
            $item_price = $order_sum;
        }






        $order_sum = $item_price;

        if ($order_sum < 70) {
            $order_sum = $order_sum + 8;
            $data['ship_charge'] = 8;
        } else {
            $data['ship_charge'] = 0;
        }

        $client = new Client();
        
        $res = $client->request('POST', 'https://api.hit-pay.com/v1/payment-requests/', [
            'headers' => [
                'X-BUSINESS-API-KEY' => env('HIT_PAY_API_KEY'),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'X-Requested-With' => 'XMLHttpRequest',
            ],
            'form_params' => [
                'email' => Auth::user()->email,
                'name'  => Auth::user()->name,
                'redirect_url' => route('create.api_order_payment', [
                    'user_id'       => $customer_id,
                    'name'          => $address[0]["name"],
                    'mobile_no'     => $address[0]["mobile_number"],
                    'address'       => $address[0]["address"],
                    'postcode'      => $address[0]["postcode"],
                    'country'       => $address[0]["country"],
                    'state'         => $address[0]["state"],
                    'city'          => $address[0]["city"],
                    'coupon'        => $address[0]["coupon"],
                ]),
                'reference_number' => 'REF123',
                'webhook' => route('webhook'),
                'currency' => 'SGD',
                'amount' => $order_sum
            ]
        ]);
        
        $response = [
            'status' => true,
            'message' => 'Use this link for payment',
            'link' => json_decode($res->getBody(), true)
        ];
        return response($response, 200);

    }

    // Direct Buy
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "reference" => "required",
            "user_id" => "required",
            "status" => "required",
            "product_id" => "required",
            "product_quantity" => "required",
            "address_id" => "required",
            "delivery_date" => "required",
            "shipping_charge" => "required",
            "shipping_charge" => "required",
            "bill_amount" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        } else {
            
        $client = new Client();
        
        $res = $client->request('GET', 'https://api.hit-pay.com/v1/payment-requests/'.$request->reference, [
            'headers' => [
                'X-BUSINESS-API-KEY'=> env('HIT_PAY_API_KEY'),
                'Content-Type'=> 'application/x-www-form-urlencoded',
                'X-Requested-With'=> 'XMLHttpRequest',
            ]
        ]);

        $data = json_decode($res->getBody(),true);

        $user_details = User::find($request->user_id);

        if($request->status == 'completed'){

            $address = address::where('id', request()->address_id)->get();
            
            $order_sum = 0;
            $date = Carbon::now();

            $product = product::where('id', request()->product_id)->first();
            if ($product->discount_price > 0) {
                if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                    $order_sum += $product->discount_price * request()->product_quantity;
                } else {
                    $order_sum += $product->min_sale_price * request()->product_quantity;
                }
            } else {
                $order_sum += $product->min_sale_price * request()->product_quantity;
            }

            $coupon_data = Cupon::where('coupon', $request->coupon)->first();
            $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', request()->id)->get();

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
                    // foreach ($cart_data as $item) {
    
                        $product = product::where('id', request()->product_id)->first();
                        if ($product->discount_price > 0) {
                            if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {

                                VoucherCode::where('id', $voucher_id)->update([
                                    'status' => true,
                                ]);
                                
                                $total_product = $product->discount_price*$request->product_quantity;
                            } else {
                                $total_product = $product->min_sale_price*$request->product_quantity;
                            }
                        } else {
                            $total_product = $product->min_sale_price*$request->product_quantity;
                        }
    
                        if ($discount->discount_type == 'discount_by_value_btn') {
                            $item_price += $total_product - $discount->discount;
    
                            $coupon_type = "voucher";
                            $coupon_amount = $discount->discount;
                            $discount_amount = $discount->discount;
                        } else {
                            $discount_price = ($total_product * $discount->discount) / 100;
                            $item_price    = $total_product - $discount_price;
    
                            $coupon_type = "voucher";
                            $coupon_amount = $discount->discount;
                            $discount_amount = $discount_price;                        
                        }                    
                    // }
                }else{
                    $error = 'Your Coupon Expired!';   
                }
    
            }else{
                if ($coupon_data && !empty($request->coupon)) {
                    // dd('in if');
                    if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
                        if ($coupon_data->limit > $user_data->count()) {
                            if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
                                $coupon_code = $request->coupon;
                                $change_use = Cupon::where('coupon', $request->coupon)->first();
                                Cupon::where('coupon', $request->coupon)->update([
                                    'no_of_used_coupon' => $change_use->no_of_used_coupon + 1
                                ]);
                                $product = product::where('id', request()->product_id)->first();

                                if ($product->discount_price > 0) {
                                    if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                        $total_product   = $product->discount_price;
                                    } else {
                                        $total_product = $product->min_sale_price;
                                    }
                                } else {
                                    $total_product = $product->min_sale_price;
                                }


                                if ($coupon_data->merchendise_btn == 'some_product') {
                                    $product = json_decode($coupon_data->merchendise);
                                    if (in_array(request()->product_id, $product)) {
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
                                } else if ($coupon_data->merchendise_btn == 'category_product') {
                                    $product = json_decode($coupon_data->merchendise);
                                    $category = product::where('id', request()->product_id)->first();
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
                } else {
                    // dd('in else');
                    $item_price = $order_sum;
                }
            }
    
    
            $order_sum = request()->bill_amount;
            $total_pay_amount = $order_sum;
            $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());

            $addressIs = address::find(request()->address_id);

            $checkAddress = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>',date('d/m/Y'))->count();

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

            $payment_mode = '';
            $addressIs = address::find(request()->address_id);
            // dd(sizeof($notification));
            if ($checkAddress > 0) {

                // $notification = Notification::where('user_id', request()->user_id)->where('end_date', '>', date('d/m/y', strtotime($current_date)))->orderBy('id', 'DESC')->first();
                $notification = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();

                // dd($notification);

                $consolidate_order_number = $notification->consolidate_order_no;
                $delivery_date = $notification->delivery_date;
        
                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => request()->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => request()->user_id,
                    'payment_mode' => 'hitpay',
                    'delivery_date' => $delivery_date,
                    'remark' => $request->remark,
                ]);

            } else {

                $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
                $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();

                // dd($consolidate_order_number);

                        if ($consolidate_order_number == null or $consolidate_order_number == "") {
                            
                            $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                        } else {
                            $number = str_replace('LFKODCC', '', $consolidate_order_number);
                            $consolidate_order_number =  "LFKODCC".$year.$month.sprintf("%04d", $consolidate_order_number1 + 1);
                        }

                        // dd($consolidate_order_number);
                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => request()->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => request()->user_id,
                    'payment_mode' => 'hitpay',
                    'delivery_date' => $request->delivery_date,
                    'remark' => $request->remark,
                ]);
            }

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

                $bill_amount = $value["amount"];

                $gain_points = $bill_amount*$one_dollar_points;

                $wallet_points = LoyaltyPointshop::where('user_id', request()->user_id)->value('loyalty_points');

                if($wallet_points != null){
                    $loyalty_wallet = $wallet_points+$gain_points;
                }else{
                    $loyalty_wallet = $gain_points;
                }

                LoyaltyPoint::create([
                    'user_id' => request()->user_id,
                    'gained_points' => $gain_points,
                    'spend_points' => 0,
                    'remains_points' => $loyalty_wallet,
                    'transaction_id' => $payment->id,
                    'transaction_amount' => $value["amount"],
                    'transaction_date' => $value["created_at"]
                ]);

                LoyaltyPointshop::updateOrCreate(
                    ['user_id' => request()->user_id],
                    ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => $payment->id]
                );

            }

            $user_details = User::find(request()->user_id);

            UserOrder::create([
                'payment_id'    => $payment->id,
                'payment_refrence_id'    => request()->reference,
                'name'          => $address[0]["name"],
                'email'         => $user_details->email,
                'mobile_no'     => $address[0]["mobile_number"],
                'address'       => $address[0]["address"],
                'postcode'      => $address[0]["postcode"],
                'country'       => $address[0]["country"]!=null?$address[0]["country"]:"singapore",
                'state'         => $address[0]["state"] !=null?$address[0]["state"]:"singapore",
                'city'          => $address[0]["city"] !=null?$address[0]["city"]:"singapore",
                // 'final_price'        => $total_pay_amount,
                'final_price'        => ($order_sum+(int)$request->shipping_charge)-(int)$discount_amount,
                'order_no'           => $order_number,
                'consolidate_order_no' => $consolidate_order_number,
                'user_id'            => request()->user_id,
                'coupon_code'        => $coupon_code,
                'discount_amount'    => $discount_amount,
                'coupon_amount'      => $coupon_amount,
                'coupon_type'        => $coupon_type,
                'status'             => 0,
                'total_product_price' => request()->bill_amount,
                'ship_charge'   => request()->shipping_charge,
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
                            'discount_amount' => $discount_amount,
                            'voucher_amount' => $discount->discount,
                            'voucher_type' => $discount->discount_type,
                            'consolidate_order_no' => $consolidate_order_number,
                            'order_no' => $order_number,
                        ]);

                            $product = product::where('id',request()->product_id)->first();
                                if($product->discount_price > 0){
                                    if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                        $total_product              = $product->discount_price;
                                        
                                        $offer_discount_price       = $product->discount_price *  request()->product_quantity;
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
                                    'user_id'       => request()->user_id,
                                    'order_no'      => $order_number,
                                    'consolidate_order_no' => $consolidate_order_number,
                                    'product_id'    => request()->product_id,
                                    'product_name'  => $product->product_name,
                                    'barcode'       => $product->barcode,
                                    'product_image' => $product->img_path,
                                    'quantity'      => request()->product_quantity,
                                    'product_price' => $product->min_sale_price,
                                    'total_price'   => $product->min_sale_price * request()->product_quantity,
                                    'after_discount' => $product->min_sale_price * request()->product_quantity,
                                    'after_discount' => $total_product * request()->product_quantity,
                                    'offer_discount_price' => $offer_discount_price,
                                    'offer_discount_percentage' => $offer_discount_percentage,
                                    'offer_discount_type'=> $offer_discount_type,
                                    'offer_discount_face_value' => $offer_discount_face_value
                                ]);
                    
                }else{
                    $error = 'Your Coupon Expired!';   
                }
    
            }else{

            if($coupon_data && !empty($request->coupon)){
                $coupon_code = $request->coupon;
                if($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon && $coupon_data->limit > $user_data->count() && $date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date){
                    $product = product::where('id',request()->product_id)->first();

                    $stocks = Stock::where('product_id', $product->id)->first();
                    $prevStockQty = $stocks->quantity;
                    Stock::where('product_id', $product->id)->first()->update([
                        'quantity' => ($prevStockQty-(int)(request()->product_quantity))
                    ]);

                        if($product->discount_price > 0){
                            if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                                $total_product = $product->discount_price;
                                $offer_discount_price       = $product->discount_price;
                                $offer_discount_percentage  = $product->discount_percentage;
                                $offer_discount_type        = $product->discount_type;
                                $offer_discount_face_value  = $product->discount_face_value;
                            }  
                            else{
                                $total_product = $product->min_sale_price;
                                $offer_discount_price       = 0;
                                $offer_discount_percentage  = 0;
                                $offer_discount_type        = '';
                                $offer_discount_face_value  = 0;
                            }
                        }else{
                            $total_product = $product->min_sale_price;
                            $offer_discount_price       = 0;
                            $offer_discount_percentage  = 0;
                            $offer_discount_type        = '';
                            $offer_discount_face_value  = 0;
                        }
    
    
    
                        if($coupon_data->merchendise_btn == 'some_product'){
                            $product = json_decode($coupon_data->merchendise);
                            if(in_array(request()->product_id,$product)){
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
                                'user_id'       => request()->id,
                                'order_no'      => $order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $product->id,
                                'product_name'  => $product->product_name,
                                'barcode'       => $product->barcode,
                                'product_image' => $product->img_path,
                                'quantity'      => request()->product_quantity,
                                'product_price' => $product->min_sale_price,
                                'total_price'   => $product->min_sale_price * request()->product_quantity,
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
                            $category = product::where('id',$product->id)->first();
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
                                'user_id'       => request()->user_id,
                                'order_no'      => $order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $product->id,
                                'product_name'  => $product->product_name,
                                'barcode'       => $product->barcode,
                                'product_image' => $product->img_path,
                                'quantity'      => request()->product_quantity,
                                'product_price' => $product->min_sale_price,
                                'total_price'   => $product->min_sale_price * request()->product_quantity,
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
                                $discount_amount = $coupon_data->face_value;
                            }else{
                                $discount_price = ($total_product * $coupon_data->face_value)/100;
                                $item_price    = $total_product - $discount_price;
    
                                
                                $coupon_type = $coupon_data->coupon_type;
                                $coupon_amount = $coupon_data->face_value;
                                $discount_amount = $discount_price;
                            
    
                            }   
    
                            UserOrderItem::create([
                                'user_id'       => request()->user_id,
                                'order_no'      => $order_number,
                                'consolidate_order_no' => $consolidate_order_number,
                                'product_id'    => $product->id,
                                'product_name'  => $product->product_name,
                                'barcode'       => $product->barcode,
                                'product_image' => $product->img_path,
                                'quantity'      => request()->product_quantity,
                                'product_price' => $product->min_sale_price,
                                'total_price'   => $product->min_sale_price * request()->product_quantity,
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
                }else{
                    $product = product::where('id',request()->product_id)->first();
                    if($product->discount_price > 0){
                        if($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date){
                            $total_product              = $product->discount_price;
                            
                            $offer_discount_price       = $product->discount_price *  request()->product_quantity;
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
                        'user_id'       => request()->user_id,
                        'order_no'      => $order_number,
                        'consolidate_order_no' => $consolidate_order_number,
                        'product_id'    => request()->product_id,
                        'product_name'  => $product->product_name,
                        'barcode'       => $product->barcode,
                        'product_image' => $product->img_path,
                        'quantity'      => request()->product_quantity,
                        'product_price' => $product->min_sale_price,
                        'total_price'   => $product->min_sale_price * request()->product_quantity,
                        'after_discount' => $product->min_sale_price * request()->product_quantity,
                        'after_discount' => $total_product * request()->product_quantity,
                        'offer_discount_price' => $offer_discount_price,
                        'offer_discount_percentage' => $offer_discount_percentage,
                        'offer_discount_type'=> $offer_discount_type,
                        'offer_discount_face_value' => $offer_discount_face_value
                    ]);
                }
            }
    
                $carts = cart::where('use_id', request()->user_id)->where('product_id', request()->product_id)->get();
                $total_product_price = cart::where('use_id', request()->user_id)->where('product_id', request()->product_id)->sum('total_price');
                
                $allProductDetails = json_encode($carts);

                $date  = Carbon::now();
                $order_date = $date->toDateString();

                Order::insert([
                    "owner_id" => request()->user_id,
                    "order_by" => 'self',
                    "quotation_id" => NULL,
                    "order_number" => $order_number,
                    "customer_name" => $address[0]["name"],
                    "customer_id" => request()->user_id,
                    "date" => $order_date,
                    "customer_address" => $address[0]["address"] . ' ' . $address[0]["city"] . ' ' . $address[0]["state"] . ' ' . $address[0]["country"] . ' ' . $address[0]["postcode"],
                    "customer_type" => 'retail',
                    "mobile_no" => $address[0]["mobile_number"],
                    "email_id" => $user_details->email,
                    "tax" => '0',
                    "shipping_type" => 'delivery',
                    "products_details" => $allProductDetails,
                    "tax_inclusive" => '0',
                    "untaxted_amount" => $total_product_price,
                    "GST" => '',
                    "sub_total" => $total_product_price,
                    "created_at" => now(),
                ]);

                $carts = cart::where('use_id', request()->user_id)->where('product_id', request()->product_id)->get();
                cart::where('use_id', request()->user_id)->where('product_id', request()->product_id)->delete();
    
                $order_data = UserOrderItem::where('order_no', $order_number)->get();
    
                $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
                $data = DriverDate::all();
                
                $notification = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
    
                $deliver_date = '';
                
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

                if($notification > 0){
                    $notification = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();
    
                    $deliver_date = $notification->delivery_date;                
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
        $response = [
            'status' => false,
            'message' => 'Payment Status Uncompleted'
        ];
        return response($response, 200);
    }
    }


    // CART BUY HITPAY
    public function cartBuy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "reference" => "required",
            "user_id" => "required",
            "status" => "required",
            "address_id" => "required",
            "shipping_charge" => "required",
            "delivery_date" => "required",
            "bill_amount" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        } else {
            
        $client = new Client();
        
        // https://api.sandbox.hit-pay.com/v1/payment-requests
        $res = $client->request('GET', 'https://api.hit-pay.com/v1/payment-requests/'.$request->reference, [
            'headers' => [
                'X-BUSINESS-API-KEY'=> env('HIT_PAY_API_KEY'),
                'Content-Type'=> 'application/x-www-form-urlencoded',
                'X-Requested-With'=> 'XMLHttpRequest',
            ]
        ]);

        $data = json_decode($res->getBody(),true);

        $user_details = User::find($request->user_id);

        if($request->status == 'completed'){

            $address = address::where('id', request()->address_id)->get();
            
            $products = cart::where('use_id', request()->user_id)->get();

            $order_sum = 0;
            $cart = [];
            $date = Carbon::now();
            $user = user::find(request()->user_id)->first();

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
                        "use_id" => request()->user_id,
                        "use_name" => $user->name,
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

            $data['total_product_price'] = cart::where('use_id', request()->user_id)->sum('total_price');
            $total_product_price = cart::where('use_id', request()->user_id)->sum('total_price');

            $coupon_data = Cupon::where('coupon', $request->coupon)->first();
            $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', request()->id)->get();

            $cart_data = Cart::where('use_id', request()->user_id)->get();
            $cart_sum = Cart::where('use_id', request()->user_id)->sum('total_price');

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
                    $item_price = $order_sum;
                }
            }

            $order_sum = request()->bill_amount;    
    
            $order_sum = request()->bill_amount;
            $total_pay_amount = $order_sum;
            $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());

            $addressIs = address::find(request()->address_id);

            $checkAddress = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>',date('d/m/Y'))->count();

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
            $addressIs = address::find(request()->address_id);
            
            if ($checkAddress > 0) {

                $notification = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();

                $consolidate_order_number = $notification->consolidate_order_no;
                $delivery_date = $notification->delivery_date;
        
                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => request()->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => request()->user_id,
                    'order_no' => $order_number,
                    'payment_mode' => 'hitpay',
                    'delivery_date' => $delivery_date,
                    'remark' => $request->remark,
                ]);

            } else {

                $consolidate_order_number = Notification::orderBy('id', 'DESC')->pluck('consolidate_order_no')->first();
                $consolidate_order_number1 = Notification::orderBy('id', 'DESC')->pluck('id')->first();


                        if ($consolidate_order_number == null or $consolidate_order_number == "") {
                            
                            $consolidate_order_number = 'LFKODCC'.$year.$month.'00001';
                        } else {
                            $number = str_replace('LFKODCC', '', $consolidate_order_number);
                            $consolidate_order_number =  "LFKODCC".$year.$month.sprintf("%04d", $consolidate_order_number1 + 1);
                        }

                $data['order_no'] = $consolidate_order_number;

                Notification::create([
                    'consolidate_order_no' => $consolidate_order_number,
                    'address_id' => request()->address_id,
                    'postcode' => $addressIs->postcode,
                    'user_id' => request()->user_id,
                    'payment_mode' => 'hitpay',
                    'order_no' => $order_number,                    
                    'delivery_date' => $request->delivery_date,
                    'remark' => $request->remark,
                ]);
            }

            foreach($data["payments"] as $key => $value){
                $payment=UserOrderPayment::create([
                    'payment_id' => $value["id"],
                    'payment_request_id'=> $value["id"],
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
                ]);

                $data = LoyaltyPointTodays::all()->first();
                $amount = $data->amount;
                $points = $data->points;

                $one_dollar_points = $points/$amount;

                $bill_amount = $value["amount"];

                $gain_points = $bill_amount*$one_dollar_points;

                $wallet_points = LoyaltyPointshop::where('user_id', request()->user_id)->value('loyalty_points');

                if($wallet_points != null){
                    $loyalty_wallet = $wallet_points+$gain_points;
                }else{
                    $loyalty_wallet = $gain_points;
                }

                LoyaltyPoint::create([
                    'user_id' => request()->user_id,
                    'gained_points' => $gain_points,
                    'spend_points' => 0,
                    'remains_points' => $loyalty_wallet,
                    'transaction_id' => $payment->id,
                    'transaction_amount' => $value["amount"],
                    'transaction_date' => $value["created_at"]
                ]);

                LoyaltyPointshop::updateOrCreate(
                    ['user_id' => request()->user_id],
                    ['loyalty_points' => $loyalty_wallet, 'last_transaction_id' => $payment->id]
                );
            }

            $user_details = User::find(request()->user_id);

            UserOrder::create([
                'payment_id'    => $payment->id,
                'payment_refrence_id'    => request()->reference,
                'name'          => $address[0]["name"],
                'email'         => $user_details->email,
                'mobile_no'     => $address[0]["mobile_number"],
                'address'       => $address[0]["address"],
                'postcode'      => $address[0]["postcode"],
                'country'       => $address[0]["country"]!=null?$address[0]["country"]:"singapore",
                'state'         => $address[0]["state"] !=null?$address[0]["state"]:"singapore",
                'city'          => $address[0]["city"] !=null?$address[0]["city"]:"singapore",
                // 'final_price'        => $total_pay_amount,
                'final_price'        => ($order_sum+(int)$request->shipping_charge)-(int)$discount_amount,
                'order_no'           => $order_number,
                'consolidate_order_no' => $consolidate_order_number,
                'user_id'            => request()->user_id,
                'coupon_code'        => $coupon_code,
                'discount_amount'    => $discount_amount,
                'coupon_amount'      => $coupon_amount,
                'coupon_type'        => $coupon_type,
                'status'             => 0,
                'total_product_price' => request()->bill_amount,
                'ship_charge'   => request()->shipping_charge,
            ]);
    
            foreach($cart_data as $item){
                $stocks = Stock::where('product_id', $item->product_id)->first();
                $prevStockQty = $stocks->quantity;
                Stock::where('product_id', $item->product_id)->first()->update([
                    'quantity' => ($prevStockQty-$item->quantity)
                ]);
            }

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
                            'discount_amount' => $discount_amount,
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
                                'user_id'       => request()->user_id,
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
                                'user_id'       => request()->user_id,
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
                                'user_id'       => request()->user_id,
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
                                'user_id'       => request()->user_id,
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
                            $total_product              = $product->discount_price*$item['quantity'];
                            
                            $offer_discount_price       = $product->discount_price *  $item['quantity'];
                            $offer_discount_percentage  = $product->discount_percentage;
                            $offer_discount_type        = $product->discount_type;
                            $offer_discount_face_value  = $product->discount_face_value;
                        }  
                        else{
                            $total_product = $product->min_sale_price*$item['quantity'];
                            $offer_discount_price       = 0;
                            $offer_discount_percentage  = 0;
                            $offer_discount_type        ='';
                            $offer_discount_face_value  = 0;
                        }
                    }else{
                        $total_product = $product->min_sale_price*$item['quantity'];
                        $offer_discount_price       = 0;
                        $offer_discount_percentage  = 0;
                        $offer_discount_type        ='';
                        $offer_discount_face_value  = 0;
                    }
                UserOrderItem::create([
                    'user_id'       => request()->user_id,
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
            $carts = cart::where('use_id', request()->user_id)->get();
            $allProductDetails = json_encode($carts);
    
            $date  = Carbon::now();
            $order_date = $date->toDateString();
            Order::insert([
                "owner_id" => request()->user_id,
                "order_by" => 'self',
                "quotation_id" => NULL,
                "order_number" => $order_number,
                "customer_name" => $addressIs->name,
                "customer_id" => request()->user_id,
                "date" => $order_date,
                "customer_address" => $request->address . ' ' . $request->city . ' ' . $request->state . ' ' . $request->country . ' ' . $request->postcode,
                "customer_type" => 'retail',
                "mobile_no" => $addressIs->mobile_number,
                "email_id" => $user->email,
                "tax" => '0',
                "shipping_type" => 'delivery',
                "products_details" => $allProductDetails,
                "tax_inclusive" => '0',
                "untaxted_amount" => $total_product_price,
                "GST" => '',
                "sub_total" => $order_sum,
                "created_at" => now(),
            ]);
            
            $carts = cart::where('use_id', request()->user_id)->get();
            cart::where('use_id', request()->user_id)->delete();

            $order_data = UserOrderItem::where('order_no', $order_number)->get();

            $new_data = DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date');
            $data = DriverDate::all();

            // $notification = Notification::where('user_id', request()->user_id)->where('delivery_date', '>', date('d/m/Y'))->get();
            $notification = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();

            $deliver_date = '';

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

            if($notification > 0){
                // $notification = Notification::where('user_id', request()->user_id)->where('consolidate_order_no', $consolidate_order_number)->first();
                $notification = Notification::where('user_id', request()->user_id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();

                $deliver_date = $notification->delivery_date;                
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
        $response = [
            'status' => false,
            'message' => 'Payment Status Uncompleted'
        ];
        return response($response, 200);
    }
    }

}
