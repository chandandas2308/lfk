<?php

namespace App\Http\Controllers\CustomerAPI;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\UserOrderItem;
use App\Models\UserOrder;
use App\Models\OfferPackages;
use App\Models\LoyaltyPoints;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use App\Models\LoyaltyPointTodays;
use App\Models\Wishlist;
use App\Models\Refferal;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\address;
use App\Models\product;
use App\Models\Banner;
use App\Models\Coupon;
use App\Models\Cupon;
use App\Models\Offer;
use App\Models\Stock;
use App\Models\cart;
use App\Models\LoyaltyPointshop;
use App\Models\Order;
use App\Models\VoucherHistory;
use Carbon\Carbon;
use Exception;

class CustomerAPIController extends Controller
{

    public function myList()
    {
        return response()->json([
            "status" => true,
            "message" => "Hi, There",
        ]);
    }

    // fetch all offers list
    public function offers()
    {
        $offers = OfferPackages::all();

        return response()->json([
            "status" => true,
            "message" => "Offers List",
            "data" => $offers,
        ]);
    }

    // fetch single offer via id
    public function singleOffer($id)
    {
        $offer = OfferPackages::find($id);

        return response()->json([
            "status" => true,
            "message" => "Offer Details",
            "data" => $offer,
        ]);
    }

    // fetch all coupons
    public function coupons()
    {
        $coupons = Cupon::all();

        return response()->json([
            "status" => true,
            "message" => "Coupons List",
            "data" => $coupons,
        ]);
    }

    // fetch single offer via id
    public function singleCoupon($id)
    {
        $coupon = Cupon::find($id);

        return response()->json([
            "status" => true,
            "message" => "Coupon Details",
            "data" => $coupon,
        ]);
    }

    // fetch all banners
    public function banners()
    {
        $banners = Banner::all();

        return response($banners, 200);
    }

    // fetch single banner via id
    public function singleBanner($id)
    {
        $banner = Banner::where('id', $id)->first();

        return response()->json([$banner, 200]);
    }

    // fetch referal awards points value
    public function refferalPoints()
    {
        $refferal = Refferal::all();

        return response()->json([
            "status" => true,
            "message" => "Refferal Points Details",
            "data" => $refferal,
        ]);
    }

    // fetch loyalty awards points value
    public function loyaltyPoints()
    {
        $loyaltyPoints = LoyaltyPointTodays::all();

        return response()->json([
            "status" => true,
            "message" => "Loyalty Points Details",
            "data" => $loyaltyPoints,
        ]);
    }

    //  fetch loyality point indivisual
    public function loyalityId($user_id){
        $point = LoyaltyPointshop::where('user_id',$user_id)->get();

        if(!empty($point)){
            return response()->json([
                "status" => true,
                "message" => "Loyalty Points Details",
                "data" => $point,
            ], 200);
        }else{
            return response()->json([
                "status" => true,
                "message" => "Data not found",
                "data" => $point,
            ]);
        }
    }

    // loyalty points transaction history
    public function loyaltyPointsHistory($user_id){
        $point = LoyaltyPoint::where('user_id',$user_id)->get();

        if(!empty($point)){
            return response()->json([
                "status" => true,
                "message" => "Loyalty Points History Details",
                "data" => $point,
            ], 200);
        }else{
            return response()->json([
                "status" => true,
                "message" => "Data not found",
                "data" => $point,
            ]);
        }
    }
    
    // fetch oreder  value
    public function couponList()
    {
        $coupanCode = Cupon::all();

        return response()->json([
            "status" => true,
            "message" => "Coupan Code Details",
            "data" => $coupanCode,
        ]);
    }

    // fetch  offer  value
    public function offerdetails()
    {
        $coupanCode = OfferPackages::all();

        return response()->json([
            "status" => true,
            "message" => "Offer Code Details",
            "data" => $coupanCode,
        ]);
    }

    public function WishLists($user_id)
    {
        $products = DB::table('wishlists')
            ->join('users', 'users.id', '=', 'wishlists.user_id')
            ->join('products', 'products.id', '=', 'wishlists.product_id')
            ->where('wishlists.user_id', $user_id)
            ->select('products.*')
            ->get();
        return response()->json([$products, 200]);
    }
    public function addWishList($product_id, $user_id)
    {
        $data = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if (!empty($data)) {
            return response()->json(['Item already exists in wishlists', 200]);
        }
        $wishlist = Wishlist::create([
            "user_id" => $user_id,
            "product_id" => $product_id,
            "created_at" => now(),
        ]);

        $response = [
            'status' => true,
            'message' => 'Added to wishlist',
            'user_details' => $wishlist,
        ];
        return response()->json([$response, 200]);
    }
    public function removeWishList($user_id, $product_id)
    {
        $wishlist = Wishlist::where('user_id', $user_id)->where('product_id', $product_id)->delete();
        return response()->json(['success' => 'Item removed from wishlists']);
    }

    // address

    public function addAddress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "user_id" => "required",
                "name" => "required",
                "address" => "required",
                "postcode" => "required",
                "mobile_number" => "required",
                "unit" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "Invalid Inputs",
                    "error" => $validator->getMessageBag()->toArray()
                ], 422);
            } else {

                $address = address::create([
                    "user_id" => $request->user_id,
                    "name" => $request->name,
                    "address" => $request->address,
                    "postcode" => $request->postcode,
                    "mobile_number" => $request->mobile_number,
                    "unit" => $request->unit,
                    "created_at" => now(),
                ]);

                

                $response = [
                    'status' => true,
                    'message' => 'Address details added',
                    'user_details' => $address,
                ];
                return response($response, 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updateAddress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "id" => "required",
                "user_id" => "required",
                "name" => "required",
                "address" => "required",
                "postcode" => "required",
                "mobile_number" => "required",
                "unit" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "Invalid Inputs",
                    "error" => $validator->getMessageBag()->toArray()
                ], 422);
            } else {

                $address = address::where('id', $request->id)->where('user_id', $request->user_id)
                    ->update([
                        "name" => $request->name,
                        "address" => $request->address,
                        "postcode" => $request->postcode,
                        "mobile_number" => $request->mobile_number,
                        "unit" => $request->unit,
                        "updated_at" => now(),
                    ]);

                $response = [
                    'status' => true,
                    'message' => 'Address details updated',
                    'user_details' => $address,
                ];
                return response($response, 200);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function removeAddress($id, $user_id)
    {
        try {

            $address = address::where('user_id', $user_id)->where('id', $id)->delete();

            $response = [
                'status' => true,
                'message' => 'Address details removed',
                'user_details' => $address,
            ];
            return response($response, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function allAddress($id)
    {
        $address = address::where('user_id', $id)->get();
        return response($address, 200);
    }
    public function Address($id, $user_id)
    {
        $address = Address::where('id', $id)->where('user_id', $user_id)->first();
        return response()->json([$address, 200]);
    }

    public function totalorders($user_id)
    {
        // $orders = UserOrder::where('user_id', $user_id)->get();
        $orders = DB::select('SELECT * from notifications where user_id='.$user_id.' GROUP BY consolidate_order_no');
        return response()->json([$orders, 200]);
    }
    
    public function fetchAllOrders($order_no)
    {
        $orders = UserOrderItem::where('consolidate_order_no', $order_no)->get();
        $voucher = VoucherHistory::where('consolidate_order_no', $order_no)->get();
        return response()->json([
            "orders" => $orders,
            "voucher" => $voucher
            , 200]);
    }

    public function userOrders($id)
    {
        $orders = Order::where('owner_id', $id)->get();
        return response($orders, 200);
    }

    public function singleorder($user_id, $id)
    {
        $order = UserOrder::where('user_id', $user_id)->where('id', $id)->first();
        return response()->json([$order, 200]);
    }

    //   PRODUCT AND CATEGORY API'S

    // check product is available in cart and wishlists
    public function check($product_id, $user_id)
    {
        $product = Stock::join('products', 'products.id', '=', 'stocks.product_id')->select(['products.*', 'stocks.quantity'])->where('products.id', $product_id)->first();
        if (!empty($product)) {
            $cart     = cart::where('product_id', $product->id)->where('use_id', $user_id)->count();
            $wishlist = Wishlist::where('product_id', $product->id)->where('user_id', $user_id)->count();

            return response()->json(['available in wishlist' . ' ' . $wishlist, 'available in cart' . ' ' . $cart,  200]);
        }
        return response()->json('Product not available in stock');
    }
    // list all products
    public function index()
    {
        // $products = Stock::join('products', 'products.id', '=', 'stocks.product_id')->get(['products.*', 'stocks.quantity']);
        $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')->select('stocks.*','products.description','products.img_path', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))->where('stocks.quantity', '>', 0)->groupBy('stocks.product_id')->get();

        return response()->json([
            "status" => true,
            "message" => "All Products List",
            "data" => $products,
        ]);
    }

    // Recommended Products
    function recommendedProducts($id){
        $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')->select('stocks.*','products.img_path','products.description','products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))->where('stocks.quantity', '>', 0)->where('products.category_id', $id)->groupBy('stocks.product_id')->get();
        return response()->json([
            "status" => true,
            "message" => "Recommended Products List",
            "data" => $products,
        ]);
    }

    // fetch single product details
    public function singleProduct($id)
    {
        $product = Stock::join('products', 'products.id', '=', 'stocks.product_id')->select(['products.*', 'stocks.quantity'])->where('products.id', $id)->first();
        if (!empty($product)) {
            $cart     = cart::where('product_id', $product->id)->count();
            $wishlist = Wishlist::where('product_id', $product->id)->count();

            return response()->json(['available in wishlist' . ' ' . $wishlist, 'available in cart' . ' ' . $cart, [$product, 200]]);
        }
        return response()->json('Product not available in stock');
    }

    public function singleProductViaId($id)
    {
        $product = Stock::join('products', 'products.id', '=', 'stocks.product_id')->select(['products.*', 'stocks.quantity'])->where('products.id', $id)->first();
        return response()->json($product);
    }

    // list all categories
    public function categories()
    {
        $categories = Category::all();

        return response()->json([
            "status" => true,
            "message" => "All Category List",
            "data" => $categories,
        ]);
    }

    // fetch single category
    public function singleCategory($id)
    {
        $result = Category::where('id', $id)->get();
        return response($result, 200);
    }

    // category wise products
    public function categoryWiseProduct($id)
    {
        if ($id != 0) {
            // $products = Product::where('category_id', $id)->where('batch_code', '!=', NULL)->get();
            $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')->select('stocks.*','products.img_path', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))->where('category_id', $id)->where('stocks.quantity', '>', 0)->groupBy('stocks.product_id')->get();
        } else {
            $products = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')->select('stocks.*','products.img_path', 'products.min_sale_price', DB::raw('sum(stocks.quantity) as total_quantity'))->where('category_id', $id)->where('stocks.quantity', '>', 0)->groupBy('stocks.product_id')->get();
        }
        return response($products, 200);
    }
    // Remaining product
    public function leftProduct($id){
        
        $data = cart::join('stocks' , 'stocks.product_id' ,'=', 'carts.product_id')->where('carts.product_id', $id )->select(['carts.*','stocks.quantity'])->get();
       
        return response($data, 200);

    }
    public function trendingproduct()
    {
        $trendingproduct = product::whereDate('created_at', Carbon::today())->get();
        return response($trendingproduct, 200);
    }
    public function bestproduct()
    {
        $topsales = DB::table('user_order_items')
            ->leftJoin('products', 'products.id', '=', 'user_order_items.product_id')
            ->select(
                'products.id',
                'products.product_name',
                'products.img_path',
                'user_order_items.product_id',
                DB::raw('SUM(user_order_items.quantity) as total')
            )
            ->groupBy('products.id', 'user_order_items.product_id', 'products.img_path', 'products.product_name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
        return response($topsales, 200);
    }
    public function newproduct()
    {
        $newproduct = product::whereDate('created_at', Carbon::today())->get();
        return response($newproduct, 200);
    }
}
