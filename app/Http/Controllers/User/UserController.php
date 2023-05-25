<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\address;
use App\Models\cart;
use App\Models\Category;
use App\Models\Notification;
use App\Models\product;
use App\Models\User;
use App\Models\Customer;
use App\Models\UserOrder;
use App\Models\LoyaltyPoint;
use Illuminate\Support\Str;
use App\Models\Wishlist;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\session as ModelsSession;
use App\Models\UserOrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Image;

class UserController extends Controller
{
    //
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

    public function profile()
    {
        $addresses = address::all()->where('user_id', Auth::user()->id);
        $orders = UserOrder::where('user_orders.user_id', Auth::user()->id)->join('notifications', 'notifications.order_no', '=', 'user_orders.order_no')->join('orders', 'orders.order_number', '=', 'user_orders.order_no')->get(['user_orders.*','notifications.delivery_date', 'orders.products_details']);
        $wishlistItems = Wishlist::join('products', 'products.id', '=', 'wishlists.product_id')->get(["products.product_name", "products.img_path", "products.min_sale_price"]);

        $loyalty_point = LoyaltyPoint::where('user_id', Auth::user()->id)->get();

        $notification = DB::table('notifications')
        ->where('user_id',Auth::user()->id)
        ->orderBy('id','desc')->first();
        $last_user_address = $notification->address_id ?? '';
        return view('frontend.profile',[
            'addresses'     => $addresses,
            'orders'        => $orders,
            'wishlistItems' => $wishlistItems,
            'loyalty_point' => $loyalty_point,
            'last_user_address' => $last_user_address
        ]);
    }
    // edit profile
    public function editProfile(Request $request)
    {
        try {
            $slug = Str::slug($request->name, '-');
            if (!file_exists('products')) {
                mkdir('products', 666, true);
            }
    
        if($request->profile_image != null){

            $image_resize = \Image::make($request->profile_image->getRealPath());
            // $image_resize->resize(400, 400);
            $name = $slug . date('d_m_y_h') . time();
            $image_resize->save(public_path('products/' . $name . "." .  $request->profile_image->extension(), 100));
            $path = 'products/' . $name . "." .  $request->profile_image->extension();
            $url = env("APP_URL", "http://lfk.sg/");

            user::where('id',Auth::user()->id)->update([
                'image' => $url.$path,
            ]);
            Customer::where('customer_id',Auth::user()->id)->update([
                'image' => $url.$path,
            ]);
        }

        $login_user_id = Auth::user()->id;

            $status =  user::where('id',$login_user_id)->update([
                'name' => $request->fullName,
                'email' => $request->emailAddress,
                'mobile_number' => $request->homeNumber,
                'phone_number' => $request->homeNumber,
            ]);

            Customer::where('customer_id',$login_user_id)->update([
                'customer_name' => $request->fullName,
                'email_id' => $request->emailAddress,
                'mobile_number' => $request->homeNumber,
                'phone_number' => $request->homeNumber,
            ]);

            return response()->json(['success'=>'Profile Updated Successfully']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
    public function addWishlist()
    {
        $wishlistItems = Wishlist::join('products', 'products.id', '=', 'wishlists.product_id')->get(["products.product_name", "products.img_path", "products.min_sale_price"]);

        return view('frontend.wishlist',[
            'wishlistItems' => $wishlistItems,

        ]);
    }
    public function orderhistory()
    {
        $orders = UserOrder::where('user_orders.user_id', Auth::user()->id)->join('notifications', 'notifications.order_no', '=', 'user_orders.order_no')->join('orders', 'orders.order_number', '=', 'user_orders.order_no')->get(['user_orders.*','notifications.delivery_date', 'orders.products_details']);

        return view('frontend.order-history',[
            'orders' => $orders,
        ]);
    }

    public function myOrders()
    {
        $orders = UserOrder::where('user_orders.user_id', Auth::user()->id)->join('notifications', 'notifications.order_no', '=', 'user_orders.order_no')->join('orders', 'orders.order_number', '=', 'user_orders.order_no')->get(['user_orders.*','notifications.delivery_date', 'orders.products_details']);

        return view('frontend.my-order',[
            'orders' => $orders,
        ]);
    }

    public function addressAdd()
    {
        $addresses = address::all()->where('user_id', Auth::user()->id);

        return view('frontend.address',[
            'addresses' => $addresses,
            'last_user_address' => ''

        ]);
    }

    public function showloyality()
    {
        return view('frontend.loyality-points');
    }

    public function myVoucher()
    {
        return view('frontend.my-voucher');
    }

    public function addAddress(Request $request)
    {
        try {
            $address = address::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'postcode' => $request->postcode,
                'address' => $request->address,
                'unit' => $request->unit_number,
                'mobile_number' => $request->mobile_number
            ]);

            Customer::where('customer_id', Auth::user()->id)->update([
                "address" => $request->address,
                'postal_code' => $request->postcode,
                'unit_number' => $request->unit_number,
            ]);

            User::where('id', Auth::user()->id)->update([
                "address" => $request->address,
                'postal_code' => $request->postcode,
                'unit_number' => $request->unit_number,
            ]);

            $session = ModelsSession::find(Session::getId());

            $session->address_id = $address->id;
            $session->save();

            return response()->json(['success'=>'New Address Added']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }
    }
    


    // delivery Date Add
    public function addDelivery(Request $request)
    {
        // dd($request->post());

        return redirect(route('order.thanks.details', $request->order_no));

        // try {
            // $date = $request->validate([
            //     'delivery_date'  => 'required',
            // ]);

            // Notification::where('consolidate_order_no',$request->order_no)->update([
            //     'delivery_date' => $request->delivery_date,
            //     'end_date' => $request->delivery_date,
            //     'remark' => $request->remark,
            // ]);

            // return view('frontend.thanks', ['order_number' => $request->user_order_no, 'consolidate_order_no' => $request->order_no])->with('success', 'Delivery Date Added');
        // } catch (\Throwable $th) {
            // return view('frontend.thanks', ['order_number' => $request->order_no])->with('error', $th->getMessage());
        // }
    }

    public function thanksFun($id)
    {
        try {

            if(app()->getLocale() == 'en'){
                $details = DB::table('user_order_items')
                ->join('products', 'products.id','=', 'user_order_items.product_id')
                ->select('products.product_name as product_name1','user_order_items.*',DB::raw('SUM(user_order_items.quantity) as quantity'),DB::raw('SUM(final_price_with_coupon_offer) as product_order_total'))
                ->groupBy('user_order_items.product_id')
                ->where('consolidate_order_no', $id)
                ->get();
            }
            else{
                $details = DB::table('user_order_items')
                ->join('products', 'products.id','=', 'user_order_items.product_id')
                ->select('products.chinese_product_name as product_name1','user_order_items.*',DB::raw('SUM(user_order_items.quantity) as quantity'),DB::raw('SUM(final_price_with_coupon_offer) as product_order_total'))
                ->groupBy('user_order_items.product_id')
                ->where('consolidate_order_no', $id)
                ->get();
            }
            return view('frontend.thanks', ['details' => $details])->with('success', 'Delivery Date Added');

        } catch (\Throwable $th) {

            return view('frontend.thanks', ['details' => $details])->with('error', $th->getMessage());

        }
    }
    
    public function fetchAllAddresses()
    {
        $data = address::where('user_id', Auth::user()->id)->orderBy('status','desc')->get();

        $new_data = array();
        $i = 0;
        $action = "";
        foreach($data as $item){
            // $action .= '<a name="updateAddress" data-id="'.$item->id.'" data-toggle="modal" data-target="#updateAddress"><button type="button" class="btn btn-default"><i class="tf-pencil2" aria-hidden="true"></i></button></a>';
            // $action .= ' | ';
            // $action .= '<a href="javascript:void(0)" onclick="removeAddress('.$item->id.')"><button type="button" class="btn btn-default"><i class="tf-ion-close" aria-hidden="true"></i></button></a>';
            // class="dropdown-item" 
            $action = '';
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="updateAddress" data-id="'.$item->id.'" class="dropdown-item" data-toggle="modal" data-target="#updateAddress" style="font-size: 16px;padding: 0.25rem 1.5rem;">Edit</a><br>';
            if($item->status != 1){
                $action .= '<a href="javascript:void(0)" onclick="makeDefaultAddress('.$item->id.')" class="dropdown-item" style="font-size: 16px;padding: 0.25rem 1.5rem;">Add Default</a><br>';
            }
            $action .= '<a href="javascript:void(0)" onclick="removeAddress('.$item->id.')" class="dropdown-item" style="font-size: 16px;padding: 0.25rem 1.5rem;">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->name,
                $item->mobile_number,
                $item->postcode,
                $item->address,
                $item->unit,    
                $item->status != 0 ? "Default" : "",
                $action
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

    public function addressesCards()
    {
        // $session = ModelsSession::find(Session::getId());

        // // $data1 = address::where('user_id', Auth::user()->id)->first();
        // $data1 = address::where('id', $session->address_id)->first();

        // $payment_mode = '';

        // // $session = ModelsSession::find(Session::getId());
        
        // $session_data = ModelsSession::where('id', Session::getId())->first();
        // $discount_value = ModelsSession::where('id', Session::getId())->value('discount_value');

        // $checkAddress = 0;
        // if($data1 != null){
        //     if($session->address_id != null){

        //     }else{
        //         $session->address_id = $data1->id;
        //     }

        //         $addressIs = address::find($data1->id);
            
        //         $current_cart_amount = cart::where('use_id', Auth::user()->id)->sum('total_price');
                
        //         ModelsSession::updateOrCreate(["id"=>Session::getId()],['sub_total' => $current_cart_amount]);

        //         $current_cart_amount = cart::where('use_id', Auth::user()->id)->sum('total_price');
        //         $session->sub_total = $current_cart_amount;
        //         $discount_value = ModelsSession::where('id', Session::getId())->value('discount_value');

        //         $date = date('Y-m-d');

             
        //         // $user_last_order = Notification::where('user_id', Auth::user()->id)->where('postcode', $addressIs->postcode)->latest()->first();
        //         $user_last_order = Notification::join('addresses','addresses.id','=','notifications.address_id')
        //                         ->select('notifications.*','addresses.unit')
        //                         ->where('notifications.user_id', Auth::user()->id)
        //                         ->where('notifications.postcode', $addressIs->postcode)
        //                         ->where('addresses.unit', $addressIs->unit)
        //                         ->latest()
        //                         ->first();
        //         if(!empty($user_last_order)){

        //             $last_order_date = $user_last_order->delivery_date;

        //             $last_order_date_format = implode('-',array_reverse(explode('/',$last_order_date)));

        //             if ($last_order_date_format > $date) {

        //                 $payment_mode = $user_last_order->payment_mode;
                        
        //                 $bill_amount = UserOrderItem::where('consolidate_order_no', $user_last_order->consolidate_order_no)->sum('total_price');
        //                 // dd($bill_amount);
                        
        //                 $total_order_amount = $bill_amount+$current_cart_amount;
        
        //                 // 2 <= 1
        //                 // if($checkAddress <= 1){
        //                     if($bill_amount >= 70){
        //                         ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                         ['shipping_charge' => 0,'final_price' => $current_cart_amount-$discount_value]);
        
        //                     }else if($total_order_amount >= 70){
        //                         ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                         ['shipping_charge' => -8,'final_price' => ($current_cart_amount-8)-$discount_value]);
        //                     }else{
        //                         ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                         ['shipping_charge' => 0,'final_price' => ($current_cart_amount)-$discount_value]);
        //                     }
        //             }else{
        //                 if($current_cart_amount >= 70){
        //                     $id = ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                         ['shipping_charge' => 0,'final_price' => $current_cart_amount-$discount_value]);
        //                 }else{
        //                     ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                         ['shipping_charge' => 8,'final_price' => ($current_cart_amount+8)-$discount_value]);
        //                 }
        //             }
        //         }else{
        //             if($current_cart_amount >= 70){
        //                 $id = ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                     ['shipping_charge' => 0,'final_price' => $current_cart_amount-$discount_value]);
        //             }else{
        //                 ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                     ['shipping_charge' => 8,'final_price' => ($current_cart_amount+8)-$discount_value]);
        //             }
        //         }
        // }

        // if($session_data->address_id == null || $session_data->address_id == '' ){
        //     $current_cart_amount = (int)cart::where('use_id', Auth::user()->id)->sum('total_price');
                
    
        //         if($current_cart_amount >= 70){
        //             $id = ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                     ['shipping_charge' => 0,'final_price' => ($current_cart_amount-$discount_value)]);
        //         }else{
        //             ModelsSession::updateOrCreate(["id"=>Session::getId()],
        //                     ['shipping_charge' => 8,'final_price' => ($current_cart_amount+8)-$discount_value]);
        //         }
    
        //         ModelsSession::updateOrCreate(["id"=>Session::getId()],['sub_total' => $current_cart_amount]);
        // }

        // $session->save();

        $data = address::where('user_id', Auth::user()->id)->get();
        $session_data1 = ModelsSession::where('id', Session::getId())->first();

        return response()->json([
            "data" => $data,
            // "session"=>[
            //     "final_price" => ($session_data1->sub_total+$session_data1->shipping_charge),
            //     'sub_total' => $session_data1->sub_total,
            //     'shipping_charge' => $session_data1->shipping_charge,
            //     "payment_mode"      => $payment_mode,
            //     'order_count' => $checkAddress,
            //     'address_id' => $session->address_id
            // ]
        ]);
    }

    public function removeAddress($id)
    {
        address::where('id', $id)->delete();
        return response()->json(['success'=>'Address Removed Successfully']);
    }

    public function defaultAddress($id){
        address::where('status', 1)->update(["status"=>false]);

        address::where('id', $id)->update([
            'status' => true
        ]);

        $address = address::where('status', 1)->first();

        Customer::where('customer_id', Auth::user()->id)->update([
            "address" => $address->address,
            'postal_code' => $address->postcode,
            'unit_number' => $address->unit,
        ]);

        return response()->json(['success'=>'Address Updated Successfully']);   
    }

    public function fetchSingleAddress()
    {
        return response()->json(address::find($_GET['id']));
    }

    public function updateAddress(Request $request)
    {
        try {
            address::where('id', $request->id)->update([
                'name' => $request->name,
                'postcode' => $request->postcode,
                'address' => $request->editAddress,
                'unit' => $request->unit_number,
                'mobile_number' => $request->mobile_number
            ]);

            return response()->json(['success'=>'Address Updated Successfully']);

        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }

    }

    // Address
    public function APIaddres(){
        $address = new Client();
          $res =  $address->request('GET','https://developers.onemap.sg/commonapi/search?searchVal='.request()->postalcode.'&returnGeom=Y&getAddrDetails=Y',[
            'headers'=> [
                'Content-Type'=>'application/json',
                'cache'=> false,
                'Accept'     => 'application/json',
            ],
            // 'data'=>[
            //         "searchVal"=> 819642,
            //     "returnGeom" => 'Y',
            //     "getAddrDetails"=> 'Y',
            //     ]
            ]) ;
            return ($res->getBody());
    }

    // API Reg Address
    public function APIRegAddress(){
        $address = new Client();
          $res =  $address->request('GET','https://developers.onemap.sg/commonapi/search?searchVal='.request()->postalcode.'&returnGeom=Y&getAddrDetails=Y',[
            'headers'=> [
                'Content-Type'=>'application/json',
                'cache'=> false,
                'Accept'     => 'application/json',
            ],
            // 'data'=>[
            //         "searchVal"=> 819642,
            //     "returnGeom" => 'Y',
            //     "getAddrDetails"=> 'Y',
            //     ]
            ]) ;
            return ($res->getBody());
    }
}
