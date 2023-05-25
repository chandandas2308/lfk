<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Http\Controllers\Controller;
use App\Models\cart;
use App\Models\Cupon;
use App\Models\product;
use App\Models\UserOrder;
use App\Models\Voucher;
use App\Models\VoucherCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    //
    // Check Coupon Code while buy carts products
    public function check_coupon_code(Request $request){
        $validator = Validator::make($request->all(), [
            'coupon' => 'required',
            'user_id' => 'required',
            'shipping_charge' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        }else{

        $coupon_data = Cupon::where('coupon', $request->coupon)->first();
        $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', request()->user_id)->get();
        $date = Carbon::now();
        $cart_data = cart::where('use_id', request()->user_id)->get();
        $item_price = 0;
        $discount_price = 0;
        $coupon_amount = 0;
        $discount_amount = 0;
        $coupon_type = '';
        $error = '';
        $total_product = 0;

        $voucherCode = VoucherCode::where('code', $request->coupon)->count();
        $voucherCode1 = VoucherCode::where('code', $request->coupon)->first();

        if($voucherCode > 0){
            $voucher_id = $voucherCode1->voucher_id;
            $discount = Voucher::find($voucher_id);

            if ($date->toDateString() <= $discount->expiry_date){
                foreach ($cart_data as $item) {

                    $product = product::where('id', $item->product_id)->first();
                    if ($product->discount_price > 0) {
                        if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                            $total_product = $product->discount_price*$item->quantity;
                        } else {
                            $total_product = $product->min_sale_price*$item->quantity;
                        }
                    } else {
                        $total_product = $product->min_sale_price*$item->quantity;
                    }

                        $discount_price = ($total_product * $discount->discount) / 100;
                        $item_price    += $total_product - $discount_price;

                        $coupon_type = "voucher";
                        $coupon_amount += $discount->discount;
                        $discount_amount += $discount_price;
                }
            }else{
                $error = 'Your Coupon Expired!';   
            }

        }else{

            if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
                if ($coupon_data->limit > $user_data->count()) {
                    if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
                        foreach ($cart_data as $item) {

                            $product = product::where('id', $item->product_id)->first();
                            if ($product->discount_price > 0) {
                                if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                    $total_product = $product->discount_price;
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

        return response()->json([
            'grand_total'           => $item_price,
            'coupon_discount'      => $discount_amount,
            'error'                => $error,
            "final_price" => ($item_price+$request->shipping_charge),
            'shipping_charge' => $request->shipping_charge,
            'coupon_amount' =>$coupon_amount,
            'coupon_type' => $coupon_type,
            'success'              => $error != '' ? '' : ($discount_amount > 0 ? 'Coupon Apply Successfully' : ''),
            'not_apply_for_this'   => $discount_amount > 0 ? '' : 'Sorry this coupon is not applicable to selected Products!'
        ], 200);
    }
    }

    // Check Coupon Code on single product buy
    public function check_coupon_code_single(Request $request){
        $validator = Validator::make($request->all(), [
            'coupon' => 'required|exists:cupons,coupon',
            'user_id' => 'required',
            'product_id' => 'required',
            'shipping_charge' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Inputs",
                "error" => $validator->getMessageBag()->toArray()
            ], 422);
        }else{

        $coupon_data = Cupon::where('coupon', $request->coupon)->first();
        $user_data = UserOrder::where('coupon_code', $request->coupon)->where('user_id', request()->user_id)->get();
        $date = Carbon::now();
        $item_price = 0;
        $discount_price = 0;
        $coupon_amount = 0;
        $discount_amount = 0;
        $coupon_type = '';
        $error = '';
        $total_product = 0;

        if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
            if ($coupon_data->limit > $user_data->count()) {
                if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {

                        $product = product::where('id', $request->product_id)->first();
                        if ($product->discount_price > 0) {
                            if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
                                $total_product = $product->discount_price;
                            } else {
                                $total_product = $product->min_sale_price;
                            }
                        } else {
                            $total_product = $product->min_sale_price;
                        }

                        if ($coupon_data->merchendise_btn == 'some_product') {
                            $product = json_decode($coupon_data->merchendise);
                            if (in_array($request->product_id, $product)) {
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
                            $category = product::where('id', $request->product_id)->first();
                            if (in_array($category->category_id, $product)) {
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
                        } else {
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

        return response()->json([
            'grand_total'           => $item_price,
            'coupon_discount'      => $discount_amount,
            'error'                => $error,
            "final_price" => (($item_price*$request->quantity)+$request->shipping_charge),
            'shipping_charge' => $request->shipping_charge,
            'coupon_amount' =>$coupon_amount,
            'coupon_type' => $coupon_type,
            'success'              => $error != '' ? '' : ($discount_amount > 0 ? 'Coupon Apply Successfully' : ''),
            'not_apply_for_this'   => $discount_amount > 0 ? '' : 'Sorry this coupon is not applicable to selected Products!'
        ], 200);
    }
    }
}
