<?php

namespace App\Http\Controllers\CustomerAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\Category;
use App\Models\product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartApiController extends Controller
{
    public function carts($user_id)
    {
        // $carts = cart::where('use_id', $user_id)->get();
        $carts = DB::table('stocks')->join('products', 'products.id', '=', 'stocks.product_id')->join('carts', 'carts.product_id','=','products.id')->select(DB::raw('sum(stocks.quantity) as total_quantity'),'carts.*')->where('carts.use_id', $user_id)->where('stocks.quantity', '>', 0)->groupBy('stocks.product_id')->get();
        return response()->json([$carts, 200]);
    }

    public function addtocart(Request $request, $product_id, $user_id)
    {
        $userdata = User::where('id', $user_id)->first();

        $check_old_data = cart::where('product_id', $product_id)->where('use_id', $user_id)->first();
        $product = Product::where('id', $product_id)->first();
        if ($check_old_data) {
            cart::where('product_id', $product_id)->where('use_id', $user_id)->update([
                'quantity'      => !empty($request->quantity) ? $request->quantity : $check_old_data->quantity + 1,
                'total_price'   => $product->min_sale_price * (!empty($request->quantity) ? $request->quantity : $check_old_data->quantity + 1),
            ]);
        } else {
            cart::insert([
                "product_id"    => $product_id,
                "image"         => $product->img_path,
                "product_name"  => $product->product_name,
                "barcode"       => $product->barcode,
                "product_price" => $product->min_sale_price,
                "product_cat"   => $product->product_category,
                "use_id"        => $userdata->id,
                "use_name"      => $userdata->name,
                "quantity"      => $request->quantity,
                "total_price"   => $request->quantity * $product->min_sale_price,
                "created_at"    => now(),
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => 'Item Add Successfully to cart']);
    }
    public function updateqty(Request $request, $product_id, $user_id)
    {
        $old_data = cart::where('product_id', $product_id)->where('use_id', $user_id)->first();
        cart::where('product_id', $product_id)->where('use_id', $user_id)->update([
            'quantity'      => $request->newVal,
            'total_price'   => $request->newVal * $old_data->product_price
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Item updated Successfully']);
    }
    public function removeproduct($product_id, $user_id)
    {
        cart::where('product_id', $product_id)->where('use_id', $user_id)->delete();
        
        echo json_encode(['status' => 'success', 'message' => 'Item deleted Successfully']);
    }

    public function cartOrder($use_id, $id){
        $cart = cart::where('use_id', $use_id)->where('id', $id)->first();
        if(!empty($cart))
        {
            return response()->json([$cart, 200]);
        }
        return response()->json(['Data not found', 200]);
    }

}
