<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    //
    public function fetchAllWishlits()
    {
        $data = Wishlist::join('products', 'products.id', '=', 'wishlists.product_id')->where('user_id', Auth::user()->id)->get(["products.id", "wishlists.user_id", "products.product_name", "products.img_path", "products.min_sale_price"]);
        
        $new_data = array();
        $i = 0;
        foreach($data as $item){
            $new_data[] = array(
                ++$i,
                '<a href="/product/'.$item->id.'"><img src="'.$item->img_path.'" height="100" width="100" class="thumbnail rounded"></a>',
                '<a href="/product/'.$item->id.'">'.$item->product_name.'</a>',
                $item->min_sale_price,
                '<a href="javascript:void(0)" onclick="removeFromWishlist('.$item->user_id.', '.$item->id.')"><button type="button" class="btn btn-default"><i class="tf-ion-close" aria-hidden="true"></i></button></a>'
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

    // 
    public function store(Request $request)
    {
        try {
            $check = Wishlist::where('user_id',Auth::user()->id)->where('product_id',$request->product_id)->first();
            if(!$check){
                $wishlist = Wishlist::create([
                    "user_id" => Auth::user()->id,
                    "product_id" => $request->product_id,
                    "created_at" => now(),
                ]);
            }
            return response()->json(["success" => "Item added to wishlist"]);
            
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    public function remove()
    {
        try {
            
            $wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', request()->product_id)->delete();
            // return $wishlist;
            return response()->json(['success' => 'Item removed from wishlists']);

        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage()]);
        }
    }

    public function storeWishlist($id)
    {
        try {
            Wishlist::create([
                "user_id" => Auth::user()->id,
                "product_id" => $id,
                "created_at" => now(),
            ]);
            return redirect()->back()->with("success","Item added to wishlist");
            
        } catch (\Throwable $th) {
            return redirect()->back()->with("error",$th->getMessage());
        }
    }

    public function removeWishlist($id)
    {
        try {
            Wishlist::where('user_id', Auth::user()->id)->where('product_id', $id)->delete();
            return redirect()->back()->with("success","Item removed from wishlists");
        } catch (\Throwable $th) {
            return redirect()->back()->with("error",$th->getMessage());
        }
    }

}