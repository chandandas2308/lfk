<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\cart;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\session as ModelsSession;
use Illuminate\Support\Facades\DB;
use App\Models\UserOrderItem;
use App\Models\Cupon;
use App\Models\Stock;
use App\Models\UserOrder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    //

    public function __construct()
    {
        $products = $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
        ->select('stocks.*','products.id as main_product_id','products.img_path','products.product_category','products.chinese_product_name as product_name_c', 'products.category_id', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))
        ->where('stocks.quantity', '>=', 0)
        ->groupBy('stocks.product_id')
        ->get();
        $categories = Category::all();
        $carts = cart::all();

        View::share('products', $products);
        View::share('categories', $categories);
        View::share('carts', $carts);
    }

    // Add Product to cart
    public function Addtocart(Request $request)
    {

        if(Auth::check()){

            $customerStatus = Customer::where('customer_id', Auth::user()->id)->first();

            if($customerStatus != null){
                if ($customerStatus->status == 1) {
                    echo json_encode(['status' => 'error', 'message' => "You do not have permission to access"]);
                    exit;
                }
            }

            $request->validate(
                [
                    'pid' => 'required|exists:products,id'
                ],
                [],
                [
                    'pid' => 'Product'
                ]
            );
            $check_old_data = cart::where('product_id', $request->pid)->where('use_id', Auth::user()->id)->first();
            $product = product::where('id', $request->pid)->first();

            if ($check_old_data) {

                cart::where('product_id',$request->pid)->where('use_id',Auth::user()->id)->update([
                    "quantity" => $check_old_data->quantity + 1
                ]);
            } else {
                cart::insert([
                    "product_id"    => $request->pid,
                    "image"         => $product->img_path,
                    "product_name"  => $product->product_name,
                    "barcode"       => $product->barcode,
                    "product_price" => $product->min_sale_price,
                    "product_cat"   => $product->product_category,
                    "use_id"        => Auth::user()->id,
                    "use_name"      => Auth::user()->name,
                    "quantity"      => !empty($request->quantity) ? $request->quantity :  1,
                    "total_price"   => $product->min_sale_price * (!empty($request->quantity) ? $request->quantity :  1),
                    "created_at"    => now(),
                ]);
            }

            // $session = ModelsSession::find(Session::getId());
            // $session_data = ModelsSession::where('id', Session::getId())->first();
            // $discount_value = ModelsSession::where('id', Session::getId())->value('discount_value');            
            // $current_cart_amount = cart::where('use_id', Auth::user()->id)->sum('total_price');
            // // dd($current_cart_amount);
            // $session->sub_total = $current_cart_amount;

            // if($session_data->address_id != null || $session_data->address_id != ''){

            //     // $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());
            //     $addressIs = address::find($session_data->address_id);
    
            //     $checkAddress = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
            //     $prevOrders = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();
    
            //     if($checkAddress > 0){
            //         $bill_amount = UserOrderItem::where('consolidate_order_no', $prevOrders->consolidate_order_no)->sum('total_price');
                    
            //         $total_order_amount = $bill_amount+$current_cart_amount;
        
            //         if($bill_amount >= 70){
            //             ModelsSession::updateOrCreate(["id"=>Session::getId()],
            //             ['shipping_charge' => 0,'final_price' => $current_cart_amount-$discount_value]);

            //         }else if($total_order_amount >= 70){
            //             ModelsSession::updateOrCreate(["id"=>Session::getId()],
            //             ['shipping_charge' => -8,'final_price' => ($current_cart_amount-8)-$discount_value]);
            //         }else{
            //             ModelsSession::updateOrCreate(["id"=>Session::getId()],
            //             ['shipping_charge' => 0,'final_price' => ($current_cart_amount)-$discount_value]);
            //         }
            //     }else{
            //         if($current_cart_amount >= 70){
            //             $session->shipping_charge = 0;
            //             $session->final_price = $current_cart_amount-$discount_value;
            //         }else{
            //             $session->shipping_charge = 8;
            //             $session->final_price = ($current_cart_amount+8)-$discount_value;
            //         }
            //     }
                
            // }else{

            //     if($current_cart_amount >= 70){
            //         $session->shipping_charge = 0;
            //         $session->final_price = $current_cart_amount-$discount_value;
            //     }else{
            //         $session->shipping_charge = 8;
            //         $session->final_price = ($current_cart_amount+8)-$discount_value;
            //     }
                
            // }

            // $session->save();

            if (!$request->ajax()) {
                return redirect(route('checkout.orderSummary'));
            }

            echo json_encode(['status' => 'success', 'message' => 'Item Add Successfully']);
        }else{
            echo json_encode(['error' => 'error', 'message' => 'not logged In']);
        }
    }

    // 
    // 
    // 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('frontend.cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(app()->getLocale() == 'en')
        {
            $data = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('carts', 'carts.product_id','=','products.id')
            ->select(DB::raw('sum(stocks.quantity) as total_quantity'),'carts.*', 'products.product_name as product_name','products.discount_price')
            ->where('carts.use_id', Auth::user()->id)
            ->groupBy('stocks.product_id')->get();
        }else{
            $data = DB::table('stocks')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('carts', 'carts.product_id','=','products.id')
            ->select(DB::raw('sum(stocks.quantity) as total_quantity'),'carts.*', 'products.chinese_product_name as product_name','products.discount_price')
            ->where('carts.use_id', Auth::user()->id)
            ->groupBy('stocks.product_id')->get();
        }

        echo json_encode($data);
    }

    public function order_summary(){
        $data = cart::where('use_id', Auth::user()->id)->get();
        $cart_data = [];
        foreach($data as $item){
            $product = DB::table('products')->where('id',$item->product_id)->first();
            $check_stock = DB::table('stocks')->where('product_id',$item->product_id)
            ->groupBy('product_id')->sum('quantity');
            if($check_stock){
                // $stock_data = Cart::where('use_id', Auth::user()->id)->where('product_id',$product->id)->first();
                $cart_data[] = [
                    'total_quantity'    => $check_stock,
                    'product_name'      => app()->getLocale() == 'en' ? $product->product_name : $product->chinese_product_name,
                    'discount_price'    => $product->discount_price,
                    'product_id'        => $item->product_id,
                    'quantity'          => $item->quantity,
                    'id'                => $item->id,
                    'product_price'     => $product->min_sale_price,
                    'image'             => $product->img_path
                ]; 
            }
        }

        echo json_encode($cart_data);
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
        $old_data = cart::where('id', $id)->where('use_id', Auth::user()->id)->first();
        cart::where('id', $id)->where('use_id', Auth::user()->id)->update([
            'quantity'      => $request->newVal,
            'total_price'   => $request->newVal * $old_data->product_price
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Cart Update Successfully']);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        request()->validate([
            'id' => 'required|exists:carts,id'
        ]);

        $session = ModelsSession::find(Session::getId());

        cart::find($id)->delete();
        
        $session_data = ModelsSession::where('id', Session::getId())->first();
        $discount_value = ModelsSession::where('id', Session::getId())->value('discount_value');
        $current_cart_amount = cart::where('use_id', Auth::user()->id)->sum('total_price');
        $session->sub_total = $current_cart_amount;

        if($session_data->address_id != null || $session_data->address_id != ''){

            // $current_date = Carbon::createFromFormat('Y-m-d H:i:s', carbon::now());

            $addressIs = address::find($session_data->address_id);

            $checkAddress = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
            $prevOrders = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();

            if($checkAddress > 0){
                $bill_amount = UserOrderItem::where('consolidate_order_no', $prevOrders->consolidate_order_no)->sum('total_price');
                
                $total_order_amount = $bill_amount+$current_cart_amount;
    
                // if($checkAddress <= 1){
                //     if($bill_amount >= 70){
                //         $session->shipping_charge = 0;
                //         $session->final_price = $current_cart_amount-$discount_value;
                //     }else if($total_order_amount >= 70){
                //         $session->shipping_charge = -8;
                //         $session->final_price = ($current_cart_amount-8)-$discount_value;
                //     }else{
                //         $session->shipping_charge = 0;
                //         $session->final_price = ($current_cart_amount)-$discount_value;
                //     }
                // }else{
                //     if($bill_amount >= 70){
                //         $session->shipping_charge = 0;
                //         $session->final_price = $current_cart_amount-$discount_value;
                //     }else{
                //         $session->shipping_charge = 0;
                //         $session->final_price = ($current_cart_amount)-$discount_value;
                //     }
                // }
                if($bill_amount >= 70){
                    ModelsSession::updateOrCreate(["id"=>Session::getId()],
                    ['shipping_charge' => 0,'final_price' => $current_cart_amount-$discount_value]);

                }else if($total_order_amount >= 70){
                    ModelsSession::updateOrCreate(["id"=>Session::getId()],
                    ['shipping_charge' => -8,'final_price' => ($current_cart_amount-8)-$discount_value]);
                }else{
                    ModelsSession::updateOrCreate(["id"=>Session::getId()],
                    ['shipping_charge' => 0,'final_price' => ($current_cart_amount)-$discount_value]);
                }
            }else{
                if($current_cart_amount >= 70){
                    $session->shipping_charge = 0;
                    $session->final_price = $current_cart_amount-$discount_value;
                }else{
                    $session->shipping_charge = 8;
                    $session->final_price = ($current_cart_amount+8)-$discount_value;
                }
            }
            
        }else{
            
            if($current_cart_amount >= 70){
                $session->shipping_charge = 0;
                $session->final_price = $current_cart_amount-$discount_value;
            }else{
                $session->shipping_charge = 8;
                $session->final_price = ($current_cart_amount+8)-$discount_value;
            }            
            
        }
        
        $session->save();

        $session_data2 = ModelsSession::where('id', Session::getId())->first();

        $discount_amount = 0;
        if($session_data2->coupon != null){
        $coupon_data = Cupon::where('coupon', $session_data2->coupon)->first();
            $user_data = UserOrder::where('coupon_code', $session_data2->coupon)->where('user_id', Auth::user()->id)->get();
            $date = Carbon::now();
            $cart_data = Cart::where('use_id', Auth::user()->id)->get();
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

            $session_data = ModelsSession::where('id', Session::getId())->first();

            $session = ModelsSession::find(Session::getId());

            $session->discount_value = $discount_amount;
            $session->final_price = ($session_data->sub_total+$session_data->shipping_charge)-$discount_amount;
            
            $session->save();
        }

        $session_data1 = ModelsSession::where('id', Session::getId())->first();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Item Remove Successfully',
            "final_price" => ($session_data1->sub_total+$session_data1->shipping_charge)-$discount_amount,
            'sub_total' => $session_data1->sub_total,
            'shipping_charge' => $session_data1->shipping_charge,
            'coupon_discount'      => $discount_amount,
        ]);
    }


    // quantity update to cart
    public function updateQuantityToCart()
    {

        $product = cart::where('id', request()->id)->first();

        $stock_check = Stock::where('product_id',$product->product_id)->sum('quantity');

        $quantity = request()->quantity;

        $error = '';

        $product_details = DB::table('products')->where('id',$product->product_id)->first();

        if($quantity == 0){
            $carts = cart::where('id', request()->id)->delete();
        }else{
            if($stock_check >= request()->quantity){
                $carts = cart::where('id', request()->id)->update([
                    "total_price"   => ((int)$product->product_price * (!empty(request()->quantity) ? request()->quantity :  1)),
                    "quantity"      => request()->quantity,
                ]);
            }else{
                $error = "Item Out of Stock";
            }
        }        

        return response()->json([
                'status' => 'success',
                'message' => empty($error) ? 'Item Quantity Updated Successfully' : '',
                'error' => !empty($error) ? $error : '',
            ]);

        // $session = ModelsSession::find(Session::getId());
        
        // $session_data = ModelsSession::where('id', Session::getId())->first();

        // $discount_value = ModelsSession::where('id', Session::getId())->value('discount_value');
        // $current_cart_amount = cart::where('use_id', Auth::user()->id)->sum('total_price');
        // $session->sub_total = $current_cart_amount;

        // if($session_data->address_id != null || $session_data->address_id != ''){

            
        //     $addressIs = address::find($session_data->address_id);

        //     $checkAddress = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->count();
        //     $prevOrders = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->where('delivery_date', '>', date('d/m/Y'))->first();

        //     if($checkAddress > 0){
        //         $bill_amount = UserOrderItem::where('consolidate_order_no', $prevOrders->consolidate_order_no)->sum('total_price');
                
        //         $total_order_amount = $bill_amount+$current_cart_amount;
    
        //         if($bill_amount >= 70){
        //             ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //             ['shipping_charge' => 0,'final_price' => $current_cart_amount-$discount_value]);

        //         }else if($total_order_amount >= 70){
        //             ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //             ['shipping_charge' => -8,'final_price' => ($current_cart_amount-8)-$discount_value]);
        //         }else{
        //             ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //             ['shipping_charge' => 0,'final_price' => ($current_cart_amount)-$discount_value]);
        //         }
        //     }else{
        //         if($current_cart_amount >= 70){
        //             $session->shipping_charge = 0;
        //             $session->final_price = $current_cart_amount-$discount_value;
        //         }else{
        //             $session->shipping_charge = 8;
        //             $session->final_price = ($current_cart_amount+8)-$discount_value;
        //         }
        //     }

        // }else{

        //     if($current_cart_amount >= 70){
        //         $session->shipping_charge = 0;
        //         $session->final_price = $current_cart_amount-$discount_value;
        //     }else{
        //         $session->shipping_charge = 8;
        //         $session->final_price = ($current_cart_amount+8)-$discount_value;
        //     }
            
        // }
        
        // $session->save();

        // $session_data2 = ModelsSession::where('id', Session::getId())->first();

        // $discount_amount = 0;
        // if($session_data2->coupon != null){

        // $coupon_data = Cupon::where('coupon', $session_data2->coupon)->first();
        //     $user_data = UserOrder::where('coupon_code', $session_data2->coupon)->where('user_id', Auth::user()->id)->get();
        //     $date = Carbon::now();
        //     $cart_data = Cart::where('use_id', Auth::user()->id)->get();
        //     $item_price = 0;
        //     $discount_price = 0;
        //     $coupon_amount = 0;
        //     $discount_amount = 0;
        //     $coupon_type = '';
        //     $error = '';
        //     $total_product = 0;
    
        //     if ($coupon_data->no_of_coupon > $coupon_data->no_of_used_coupon) {
        //         if ($coupon_data->limit > $user_data->count()) {
        //             if ($date->toDateString() >= $coupon_data->start_date  && $date->toDateString() <= $coupon_data->end_date) {
        //                 foreach ($cart_data as $item) {
    
        //                     $product = product::where('id', $item->product_id)->first();
        //                     if ($product->discount_price > 0) {
        //                         if ($date->toDateString() >= $product->discount_start_date && $date->toDateString() <= $product->discount_end_date) {
        //                             $total_product = $product->discount_price*$item->quantity;
        //                         } else {
        //                             $total_product = $product->min_sale_price*$item->quantity;
        //                         }
        //                     } else {
        //                         $total_product = $product->min_sale_price*$item->quantity;
        //                     }
    
    
        //                     if ($coupon_data->merchendise_btn == 'some_product') {
        //                         $product = json_decode($coupon_data->merchendise);
        //                         if (in_array($item->product_id, $product)) {
        //                             if ($coupon_data->coupon_type == 'discount_by_value_btn') {
        //                                 $item_price += $total_product - $coupon_data->face_value;
    
        //                                 $coupon_type = $coupon_data->coupon_type;
        //                                 $coupon_amount += $coupon_data->face_value;
        //                                 $discount_amount += $coupon_data->face_value;
        //                             } else {
        //                                 $discount_price = ($total_product * $coupon_data->face_value) / 100;
        //                                 $item_price    += $total_product - $discount_price;
    
        //                                 $coupon_type = $coupon_data->coupon_type;
        //                                 $coupon_amount += $coupon_data->face_value;
        //                                 $discount_amount += $discount_price;
        //                             }
        //                         } else {
        //                             $item_price += $total_product;
        //                         }
        //                     } else if ($coupon_data->merchendise_btn == 'category_product') {
        //                         $product = json_decode($coupon_data->merchendise);
        //                         $category = product::where('id', $item->product_id)->first();
        //                         if (in_array($category->category_id, $product)) {
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
        //                         } else {
        //                             $item_price += $total_product;
        //                         }
        //                     } else {
        //                         if ($coupon_data->coupon_type == 'discount_by_value_btn') {
        //                             $item_price += $total_product - $coupon_data->face_value;
    
        //                             $coupon_type = $coupon_data->coupon_type;
        //                             $coupon_amount += $coupon_data->face_value;
        //                             // $discount_amount += $total_product - $coupon_data->face_value;
        //                             $discount_amount += $coupon_data->face_value;
        //                         } else {
        //                             $discount_price = ($total_product * $coupon_data->face_value) / 100;
        //                             $item_price    += $total_product - $discount_price;
    
        //                             $coupon_type = $coupon_data->coupon_type;
        //                             $coupon_amount += $coupon_data->face_value;
        //                             $discount_amount += $discount_price;
        //                         }
        //                     }
        //                 }
        //             } else {
        //                 $error = 'Your Coupon Expired!';
        //             }
        //         } else {
        //             $error = 'Coupon Limit Exceeded';
        //         }
        //     } else {
        //         $error = 'Coupon Not Available!';
        //     }            

        //     $session_data = ModelsSession::where('id', Session::getId())->first();

        //     $session = ModelsSession::find(Session::getId());

        //     $session->discount_value = $discount_amount;
        //     $session->final_price = ($session_data->sub_total+$session_data->shipping_charge)-$discount_amount;
            
        //     $session->save();
        // }
            
        // $session_data1 = ModelsSession::where('id', Session::getId())->first();

        // return response()->json([
        //     'status' => 'success',
        //     'message' => empty($error) ? 'Item Quantity Updated Successfully' : '',
        //     'error' => !empty($error) ? $error : '',
        //     "final_price" => ($session_data1->sub_total+$session_data1->shipping_charge)-$discount_amount,
        //     'sub_total' => $session_data1->sub_total,
        //     'shipping_charge' => $session_data1->shipping_charge,
        //     'coupon_discount'      => $discount_amount,
        // ]);
    }
}
