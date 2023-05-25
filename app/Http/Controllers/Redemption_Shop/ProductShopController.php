<?php

namespace App\Http\Controllers\Redemption_Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\product;
use App\Models\ProductRedemptionShop;
use App\Models\Stock;
use App\Models\Vendors;
use Illuminate\Http\Request;

class ProductShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = ProductRedemptionShop::orderBy('id', 'desc')->get();

        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="viewProduct('.$item->id.')">View</a>';
            $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="updateProduct('.$item->id.')">Edit</a>';
            $action .= '<a class="dropdown-item" href="javascript:void(0)" onclick="removeProduct('.$item->id.')">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->product_name,
                '<img src="'.json_decode($item->images)[0].'" height="100" width="100">',
                $item->points,
                $action
            );
            $action = '';
        }

        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($data),
            "recordsFiltered" 	=> sizeOf($data),
            "data" 				=> $new_data
        );
        echo json_encode($output);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(request()->status == 1){
            return view('superadmin.redemption-shop.product.add',["product"=>product::get(),"category"=>Category::get(), "vendor"=>Vendors::get()]);
        }else if(request()->status == 2){
            return view('superadmin.redemption-shop.product.view',["product"=>product::get(),"category"=>Category::get(), "vendor"=>Vendors::get(),"data"=>ProductRedemptionShop::find(request()->id)]);
        }else if(request()->status == 4){
            ProductRedemptionShop::find(request()->id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully'
            ]);
        }else{
            return view('superadmin.redemption-shop.product.update',["product"=>product::get(),"category"=>Category::get(), "vendor"=>Vendors::get(),"data"=>ProductRedemptionShop::find(request()->id)]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            [
                'product_name' => 'required',
                'product_category' => 'required',
                'variant' => 'required',
                'stock_qty' => 'required',
                // 'vendor_id' => 'required',
                // 'sku_code' => 'required',
                'uom' => 'required',
                'minimum_points' => 'required',
                'images' => $request->product_id!=null?'':'required',
            ],
        );

        $count = ProductRedemptionShop::where('product_id', $request->product_id)->count();

        if($count > 0){
            return response()->json([
                'status' => 'error',
                'message' => 'Product already exist'
            ]);
        }

        $data = [];
        $url = env("APP_URL", "http://lfk.sg/");
        if($request->hasfile('images'))
        {
           foreach($request->file('images') as $file)
           {
               $name = time().'.'.$file->extension();
               $file->move(public_path().'/products/images/', $name);
               $data[] = $url.'products/images/'.$name;
           }
        }

        if($request->product_id != null){
            $images = product::find($request->product_id);

            $stock = Stock::where('product_id', $request->product_id)->first();

            $remain_qty = (int)$stock->quantity-(int)$request->stock_qty;

            Stock::where('product_id', $request->product_id)->update(["quantity"=>$remain_qty]);

            foreach(json_decode($images->images) as $image)
            {
                $data[] = $image;
            }
        }

        ProductRedemptionShop::create([
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'product_category' => $request->product_category,
            'product_variant' => $request->variant,
            'vendor_id' => $request->vendor_id,
            'sku_code' => $request->sku_code,
            'uom' => $request->uom,
            'quantity' => $request->stock_qty,
            'points' => $request->minimum_points,
            'images'=> json_encode($data),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added successfully'
        ]);
    }

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
    public function update1(Request $request)
    {
        //
        $request->validate(
            [
                'product_name' => 'required',
                'product_category' => 'required',
                'variant' => 'required',
                'stock_qty' => 'required',
                // 'vendor_id' => 'required',
                // 'sku_code' => 'required',
                'uom' => 'required',
                'minimum_points' => 'required',
            ],
        );

        $data = [];
        $url = env("APP_URL", "http://lfk.sg/");
        if($request->hasfile('images'))
        {
           foreach($request->file('images') as $file)
           {
               $name = time().'.'.$file->extension();
               $file->move(public_path().'/products/images/', $name);
               $data[] = $url.'products/images/'.$name;
           }
        }
            $images = ProductRedemptionShop::find($request->id);
            foreach(json_decode($images->images) as $image)
            {
                $data[] = $image;
            }

            
        if($images->product_id != null){

            $stock = Stock::where('product_id', $images->product_id)->first();

            // dd((int)$images->quantity > (int)$request->stock_qty);
            if((int)$images->quantity > (int)$request->stock_qty){
                $updateQty = (int)$images->quantity-(int)$request->stock_qty;

                if((int)$stock->quantity > 0){
                    $remain_qty = (int)$stock->quantity+(int)$updateQty;
                }else{
                    $remain_qty = (int)$updateQty-(int)$stock->quantity;
                }

            }else{
                // dd('i am here');
                $updateQty = (int)$request->stock_qty-(int)$images->quantity;
                if((int)$stock->quantity > 0){
                    $remain_qty = (int)$stock->quantity-(int)$updateQty;
                }else{
                    $remain_qty = -(int)$updateQty-(int)$stock->quantity;
                }
            }

            Stock::where('product_id', $stock->product_id)->update(["quantity"=>$remain_qty]);
        }

        ProductRedemptionShop::where('id', $request->id)->update([
            'product_name' => $request->product_name,
            'product_id' => $request->product_id,
            'product_category' => $request->product_category,
            'product_variant' => $request->variant,
            'vendor_id' => $request->vendor_id,
            'sku_code' => $request->sku_code,
            'quantity' => $request->stock_qty,
            'uom' => $request->uom,
            'points' => $request->minimum_points,
            'images'=> json_encode($data),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully'
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
}
