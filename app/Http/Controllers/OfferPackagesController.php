<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Cupon;
use App\Models\OfferPackages;
use Illuminate\Support\Facades\Auth;
use App\Models\product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use File;
use Image;

class OfferPackagesController extends Controller
{


    // Offer & coupon function
    // 
    // start
    // 

    // fetch all products name for dropdown
    public function getProductsDetailsList(){
        return response()->json(DB::table('products')->select('product_name', 'id')->distinct()->get());
    }

    // fetch all products name for dropdown
    public function getCategoryDetailsList(){
        return response()->json(DB::table('categories')->select('name', 'id')->distinct()->get());
    }

    // ==============================================banner===================================
    // fetch all Offers
    // =================================================================================
    public function getOffers()
    {
        if (Auth::user()->role_id == "0") {
            $data = DB::table('offer_packages')->orderBy('id', 'desc')->get();
        } else {
            $data = DB::table('offer_packages')->where('owner_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewOffer" data-toggle="modal" data-target="#viewOffer" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="removeOffer" data-toggle="modal" data-target="#removeModalOffer" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->offer_name,
                $item->offer_type == "full_discount_btn"?"full discount coupon":($item->offer_type == "discount_by_value_btn" ? "discount by value":"discount by percentage"),
                $item->face_value,
                // ($item->no_of_used_offer != null?$item->no_of_used_offer:0)."/".$item->no_of_offers,
                $item->start_date,
                $item->end_date,
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

    // =================================================================================
    // fetch a single Offer
    // =================================================================================
    public function getOffer()
    {
        $id = $_GET["id"];
        $data = OfferPackages::all()->where("id", $id);
        return response()->json($data);
    }
    
    // =================================================================================
    // Add Coupon
    // =================================================================================    
    public function addCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            Cupon::insert([
                "owner_id" => Auth::user()->id,
                "coupon" => $request->coupon_name,
                "coupon_type" => $request->coupon_type,
                "face_value" => $request->face_value,
                "no_of_coupon" => $request->no_of_coupon,
                "limit" => $request->limit_per_person,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "coupon_desc" => $request->coupon_desc,
                "merchendise_btn" => $request->products_btn,
                "merchendise" => $request->allCouponItemArr,
                "created_at"=> now(),
            ]);

            return response()->json(['success' => 'Coupon Added Successfully']);
        }
    }

    // =================================================================================
    // Edit Coupon
    // =================================================================================    
    public function editCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            Cupon::where("id", $request->id)
                ->update([
                    "coupon" => $request->coupon_name,
                    "coupon_type" => $request->coupon_type,
                    "face_value" => $request->face_value,
                    "no_of_coupon" => $request->no_of_coupon,
                    "limit" => $request->limit_per_person,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,
                    "coupon_desc" => $request->coupon_desc,
                    "merchendise_btn" => $request->products_btn,
                    "merchendise" => $request->allCouponItemArr,
                    "updated_at" => now()
                ]);

            return response()->json(['success' => 'Coupon Updated Succesfully']);
        }
    }

    // =================================================================================
    // Delete Coupon
    // =================================================================================        
    public function removeCoupon()
    {
        $id = $_GET["id"];
        Cupon::where("id", $id)->delete();
        return response()->json(["success" => "Coupon Deleted Successfully."]);
    }

    // =================================================================================
    // view Coupon
    // =================================================================================
    public function viewCoupon()
    {
        $id = $_GET["id"];
        $data = Cupon::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // fetch a single Coupon
    // =================================================================================
    public function getCoupon()
    {
        $id = $_GET["id"];
        $data = Cupon::all()->where("id", $id);
        return response()->json($data);
    }
    // =================================================================================
    // fetch all Coupons
    // =================================================================================
    public function getCoupons()
    {
        if (Auth::user()->role_id == "0") {
            $data = DB::table('cupons')->orderBy('id', 'desc')->get();
        } else {
            $data = DB::table('cupons')->where('owner_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        }

        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewcoupon" data-toggle="modal" data-target="#viewCoupon" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="removeCoupon" data-toggle="modal" data-target="#removeModalCoupon" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->coupon,
                $item->coupon_type == "full_discount_btn"?"full discount coupon":($item->coupon_type == "discount_by_value_btn"?"discount by value":"discount by percentage"),
                $item->face_value,
                ($item->no_of_used_coupon != null?$item->no_of_used_coupon:0)."/".$item->no_of_coupon,
                $item->start_date,
                $item->end_date,
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

    // 
    // End
    // 

    public function index(){
        return view('superadmin.OfferPackage');
    }

       // =================================================================================
    // Add Offer
    // =================================================================================    
    public function addOffer(Request $request)
    {
        // $uniqueTime = str_replace(' ', '', hexdec(date('Y-m-d H:i:s')));

        $validator = Validator::make($request->all(), [
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            OfferPackages::insert([
                "owner_id" => Auth::user()->id,
                'offer_name' => $request->offer_name,
                "offer" => $request->offer_number,
                "offer_type" => $request->offer_type,
                "face_value" => $request->face_value,
                "no_of_offers" => $request->no_of_offers,
                "limit" => $request->limit_per_person,
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "offer_desc" => $request->offer_desc,
                "merchendise_btn" => $request->products_btn_offer,
                "merchendise" => $request->allOfferItemArr,
                "created_at"=> now(),
            ]);



            $discount_price         = 0;
            $discount_type          = '';
            $discount_face_value    = 0;
            $discount_start_date    = $request->start_date;
            $discount_end_date      = $request->end_date;
            $discount_percentage    = 0;

            if($request->products_btn_offer == 'all_product'){
                foreach(product::all() as $item){
                    if($request->offer_type == 'discount_by_value_btn'){
                        $discount_price         = $item->min_sale_price - $request->face_value;
                        $discount_type          = $request->offer_type;
                        $discount_face_value    = $request->face_value;
                        $discount_percentage    = ($request->face_value/$item->min_sale_price)*100;
                    }else{
                        $discount_amount        = ($item->min_sale_price*$request->face_value)/100;
                        $discount_price         = $item->min_sale_price - $discount_amount;
                        $discount_type          = $request->offer_type;
                        $discount_face_value    = $request->face_value;

                        $discount_percentage    = $request->face_value;
                    }

                    product::where('id',$item->id)->update([
                        'discount_price'        => $discount_price,
                        'discount_name'         => $request->offer_name,
                        'discount_type'         => $discount_type,
                        'discount_face_value'   => $discount_face_value,
                        'discount_start_date'   => $discount_start_date,
                        'discount_end_date'     => $discount_end_date,
                        'discount_percentage'   => number_format($discount_percentage,2),
                    ]);
                }
            }else if($request->products_btn_offer == 'some_product'){
                foreach(json_decode($request->allOfferItemArr) as $item){
                    $product_data = product::where('id',$item)->first();
                    if($request->offer_type == 'discount_by_value_btn'){
                        $discount_price         = $product_data->min_sale_price - $request->face_value;
                        $discount_type          = $request->offer_type;
                        $discount_face_value    = $request->face_value;
                        $discount_percentage    = ($request->face_value/(float)$product_data->min_sale_price)*100;
                    }else{
                        $discount_amount        = ($product_data->min_sale_price*$request->face_value)/100;
                        $discount_price         = $product_data->min_sale_price - $discount_amount;
                        $discount_type          = $request->offer_type;
                        $discount_face_value    = $request->face_value;
                        $discount_percentage    = $request->face_value;
                    }
                    product::where('id',$item)->update([
                        'discount_price'        => $discount_price,
                        'discount_name'         => $request->offer_name,
                        'discount_type'         => $discount_type,
                        'discount_face_value'   => $discount_face_value,
                        'discount_start_date'   => $discount_start_date,
                        'discount_end_date'     => $discount_end_date,
                        'discount_percentage'   => number_format($discount_percentage,2),
                    ]);
                }
            }else{

                foreach(json_decode($request->allOfferItemArr) as $item){
                    $product_data = product::where('category_id',$item)->first();
                    if($request->offer_type == 'discount_by_value_btn'){
                        $discount_price         = $product_data->min_sale_price - $request->face_value;
                        $discount_type          = $request->offer_type;
                        $discount_face_value    = $request->face_value;
                        $discount_percentage    = ($request->face_value/$product_data->min_sale_price)*100;
                    }else{
                        $discount_amount        = ($product_data->min_sale_price*$request->face_value)/100;
                        $discount_price         = $product_data->min_sale_price - $discount_amount;
                        $discount_type          = $request->offer_type;
                        $discount_face_value    = $request->face_value;
                        $discount_percentage    = $request->face_value;
                    }
                    product::where('category_id',$item)->update([
                        'discount_price'        => $discount_price,
                        'discount_name'         => $request->offer_name,
                        'discount_type'         => $discount_type,
                        'discount_face_value'   => $discount_face_value,
                        'discount_start_date'   => $discount_start_date,
                        'discount_end_date'     => $discount_end_date,
                        'discount_percentage'   => number_format($discount_percentage,2),
                    ]);
                }
                
            }



            return response()->json(['success' => 'Offer Added Successfully']);
        }
    }

    // =================================================================================
    // Edit Offer
    // =================================================================================    
    public function editOffer(Request $request)
    {
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            OfferPackages::where("id", $request->id)
                ->update([
                    "offer_type" => $request->offer_type,
                    "face_value" => $request->face_value,
                    "no_of_offers" => $request->no_of_offers,
                    "limit" => $request->limit_per_person,
                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,
                    "offer_desc" => $request->offer_desc,
                    "merchendise_btn" => $request->products_btn_offer_edit,
                    "merchendise" => $request->allOfferItemArr,
                    "updated_at" => now()
                ]);

            return response()->json(['success' => 'Offer Updated Successfully']);
        }
    }

    // =================================================================================
    // Delete Offer
    // =================================================================================        
    public function removeOffer()
    {
        $id = $_GET["id"];

        $discount_price = null;
        $discount_name = null;
        $discount_type = null;
        $discount_face_value = null;
        $discount_start_date = null;
        $discount_end_date = null;
        $discount_percentage = null;

        $old_data =  OfferPackages::where("id", $id)->first();

        if($old_data->merchendise_btn == 'all_product'){
            foreach(product::all() as $item){

                product::where('id',$item->id)->update([
                    'discount_price'        => $discount_price,
                    'discount_name'         => $discount_name,
                    'discount_type'         => $discount_type,
                    'discount_face_value'   => $discount_face_value,
                    'discount_start_date'   => $discount_start_date,
                    'discount_end_date'     => $discount_end_date,
                    'discount_percentage'   => $discount_percentage,
                ]);
                
            }
        }else if($old_data->merchendise_btn == 'some_product'){
            foreach(json_decode($old_data->merchendise) as $item){
                product::where('id',$item)->update([
                    'discount_price'        => $discount_price,
                    'discount_name'         => $discount_name,
                    'discount_type'         => $discount_type,
                    'discount_face_value'   => $discount_face_value,
                    'discount_start_date'   => $discount_start_date,
                    'discount_end_date'     => $discount_end_date,
                    'discount_percentage'   => $discount_percentage,
                ]);
            }
        }else{

            foreach(json_decode($old_data->merchendise) as $item){
                product::where('category_id',$item)->update([
                    'discount_price'        => $discount_price,
                    'discount_name'         => $discount_name,
                    'discount_type'         => $discount_type,
                    'discount_face_value'   => $discount_face_value,
                    'discount_start_date'   => $discount_start_date,
                    'discount_end_date'     => $discount_end_date,
                    'discount_percentage'   => $discount_percentage,
                ]);
            }
            
        }

        OfferPackages::where("id", $id)->delete();
        return response()->json(["success" => "Offer Deleted Successfully."]);
    }

    // =================================================================================
    // view Offer
    // =================================================================================
    public function viewOffer()
    {
        $id = $_GET["id"];
        $data = OfferPackages::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // fetch all Banners
    // =================================================================================
    public function getBanners()
    {
        if (Auth::user()->is_admin == "0") {
            $data = DB::table('banners')->orderBy('id', 'desc')->get();
        } else {
            $data = DB::table('banners')->where('owner_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewbanner" data-toggle="modal" data-target=".viewBanner" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editbanner" data-toggle="modal" data-target="#editBanner" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deletebanner" data-toggle="modal" data-target="#removeModalBanner" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->title,
                $item->description,
                $item->product_name,
                '<img src="'.$item->image.'" height="100" width="100" />',
                $item->status,
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

    // =================================================================================
    // fetch a single Banner
    // =================================================================================
    public function getBanner()
    {
        $id = $_GET["id"];
        $data = Banner::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // Add Banner
    // =================================================================================    
    public function addBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {

                // new one
                if (!file_exists('banners')) {
                    mkdir('banners', 666, true);
                }

                $slug = Str::slug($request->title, '-');

                $image_resize = Image::make($request->image->getRealPath());
                $image_resize->save(public_path('banners/'.$slug.date('d_m_y_h').time()."." .$request->image->extension(), 100));

                $url = env("APP_URL", "https://lfk.sg/");

                $path = 'banners/' .$slug. date('d_m_y_h') . time() . "." .  $request->image->extension();

            Banner::create([
                "owner_id" => Auth::user()->id,
                "title" => $request->title,
                "description" => $request->description,
                "product_name" => $request->product_name,
                "product_id" => $request->product_id,
                "image" => $url.$path,
                "status" => $request->status,
                'type' => $request->type,
            ]);

            return response()->json(['success' => 'Banner Added Successfully']);
            
        }
    }

    // =================================================================================
    // Edit Banner
    // =================================================================================    
    public function editBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required",
            "description" => "required",
            "status" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            if ($request->file('image') === null) {
                Banner::where("id", $request->id)
                    ->update([
                        "title" => $request->title,
                        "description" => $request->description,
                        "product_id" => $request->product_id,
                        "status" => $request->status,
                        'type' => $request->type,
                        "updated_at" => now()
                    ]);
                return response()->json(['success' => 'Banner Updated Successfully']);
            } else {

                $productImgPath = Banner::find($request->id);

                File::delete($productImgPath->image);

                // new one
                if (!file_exists('banners')) {
                    mkdir('banners', 666, true);
                }
                $image_resize = Image::make($request->image->getRealPath());
                $slug = Str::slug($request->title, '-');

                $image_resize->save(public_path('banners/' . $slug . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));

                $url = env("APP_URL", "https://lfk.sg/");

                $path = 'banners/' . $slug . date('d_m_y_h') . time() . "." .  $request->image->extension();

                Banner::where("id", $request->id)
                    ->update([
                        "title" => $request->title,
                        "description" => $request->description,
                        "product_id" => $request->product_id,
                        "image" => $url.$path,
                        'type' => $request->type,
                        "status" => $request->status,
                        "updated_at" => now()
                    ]);
            }
            return response()->json(['success' => 'Banner Updated Successfully']);
        }
    }

    // =================================================================================
    // Delete Banner
    // =================================================================================        
    public function removeBanner()
    {
        $id = $_GET["id"];
        Banner::where("id", $id)->delete();
        return response()->json(["success" => "Banner Deleted Successfully."]);
    }

    // =================================================================================
    // view Banner
    // =================================================================================
    public function viewBanner()
    {
        $id = $_GET["id"];
        $data = Banner::all()->where("id", $id);
        return response()->json($data);
    }

    // filter
    
        // filter invoice
        public function filterStatusOfBanner()
        {
            if(Auth::User()->role_id==0){
                return response()->json(DB::table('banners')->where('status', $_GET['status'])->paginate(10));
            }else{
                return response()->json(DB::table('banners')->where('status', $_GET['status'] )->where("owner_id", Auth::User()->id)->paginate(10));
            }
        }

}