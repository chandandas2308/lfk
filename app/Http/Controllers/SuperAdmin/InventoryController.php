<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\product;
use App\Models\Category;
use App\Models\PurchaseOrder;
use App\Models\Stock;
use App\Models\ReturnAndExchange;
use App\Models\SalesInvoice;
use App\Models\Warehouse;
use App\Models\MultiImage;
use App\Models\Return_Goods_Warehouse;
use App\Models\Exchange_Goods_Warehouse;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use \Milon\Barcode\DNS2D;
use \Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\FormMultipleUpload;
use Image;


// use Intervention\Image\ImageManagerStatic as Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use PhpParser\Parser\Multiple;

class InventoryController extends Controller
{

    // list all batch code
    public function getAllBatchCode1()
    {
        return response()->json(Stock::all()->where('product_name', $_GET['product_name'])->where('product_variant', $_GET['varient']));
    }
    // end

    //
    // =================================================================================
    // All Inventory functions
    // =================================================================================    
    public function inventory()
    {
        $data = json_decode(product::all());

        return view('superadmin.inventory');

        // return response()->json(['data' => $data]);
    }

    // ***************************************************************************************************//
    //                                           PRODUCT SECTION                                          //
    //****************************************************************************************************//

    //   all list products details for forms
    public function getAllProducts()
    {
        if (Auth::User()->is_admin === '2') {
            // return response()->json(product::all());
            return response()->json(DB::table('products')->select('product_name')->distinct()->get());
        } else {
            // return response()->json(product::all()->where('owner_id', Auth::User()->id));
            return response()->json(DB::table('products')->where('owner_id', Auth::User()->id)->select('product_name')->distinct()->get());
        }
    }

    public function GetAllProductsaw()
    {
        $id = $_GET["id"];
        $data = product::all()->where("supplier_id", $id);
        return response()->json($data);
    }

    // get product name for stock form
    public function getNameProducts()
    {
        // return response()->json(product::all()->where('id', $_GET['val']));
        return response()->json(DB::table('products')->where('product_name', $_GET['val'])->distinct()->get());
    }

    // =================================================================================
    // fetch all products
    // =================================================================================
    public function getProducts(Request $request)
    {
        if (Auth::User()->is_admin === '2') {
            $data = DB::table('products')->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')->select('products.*', DB::raw('sum(stocks.quantity) as total_quantity'))->groupBy('products.id')->orderBy('id','DESC')->get();
            

            $i = 0;
            $action = '';
            $new_data = [];
    
            foreach($data as $item){
                $action .= '<div class="dropdown">';
                $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                $action .= '</a>';
                $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                $action .= '<a name="viewProducts" data-toggle="modal" data-target=".viewProduct" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
                $action .= '<a name="editProducts" data-toggle="modal" data-target="#editProduct" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                $action .= '<a name="deleteProducts"  data-toggle="modal" data-target="#removeModalProduct" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                $action .= '</div>';
                $action .= '</div>';
    
                $new_data[] = array(
                    ++$i,
                    $item->productId,
                    ($item->img_path != null)?'<img src= "'.$item->img_path.'" width="100" />':'<img src="'.asset('dummy-image-portrait.jpg').'" width="100" />',
                    $item->barcode,
                    $item->product_name,
                    $item->chinese_product_name,
                    $item->product_varient,
                    $item->product_category,
                    $item->total_quantity,
                    $item->uom,
                    $item->min_sale_price,
                    $action
                );
                $action = '';
            }
            
        } else {
            $data =  DB::table('products')->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')->select('products.*', DB::raw('sum(stocks.quantity) as total_quantity'))->groupBy('stocks.product_id')->get();
            
            $i = 0;
            $action = '';
            $new_data = [];
    
            foreach($data as $item){
                $action .= '<div class="dropdown">';
                $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                $action .= '</a>';
                $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                $action .= '<a name="viewProducts" data-toggle="modal" data-target=".viewProduct" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
                $action .= '<a name="editProducts" data-toggle="modal" data-target="#editProduct" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                $action .= '<a name="deleteProducts"  data-toggle="modal" data-target="#removeModalProduct" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                $action .= '</div>';
                $action .= '</div>';
    
                $new_data[] = array(
                    ++$i,
                    $item->productId,
                    ($item->img_path != null)?'<img src= "'.$item->img_path.'" />':'<img src="'.asset('dummy-image-portrait.jpg').'" width="100" />',
                    $item->barcode,
                    $item->product_name,
                    $item->chinese_product_name,
                    $item->product_varient,
                    $item->product_category,
                    $item->total_quantity,
                    $item->uom,
                    $item->min_sale_price,
                    $action
                );
                $action = '';
            }
       
        }

        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $data->count(),
            "recordsFiltered" 	=> $data->count(),
            "data" 				=> $new_data
        );
        echo json_encode($output);

    }


    // =================================================================================
    // update zero invoice
    // ================================================================================= 
    public function updateZeroInvoice(Request $request)
    {
        ReturnAndExchange::where('id', $request->id)
            ->update([
                "date" => $request->date,
                "zeroInvoiceOrders" => $request->orders,
                "updated_at" => now(),
            ]);


        $output =   json_decode($request->orders, true);

        foreach ($output as $value) {
            $inStock = Stock::where('product_id', $value['product_Id'])->where('product_varient', $value['product_variant'])->where('batch_code', $value['batchCode'])->value('quantity');

            if ($request->type != "sale") {
                $minus = $inStock - (int)$value['quantityRAC'];

                Stock::where('product_id', $value['product_Id'])
                    ->where('product_varient', $value['product_variant'])
                    ->where('batch_code', $value['batchCode'])
                    ->update([
                        "quantity" => $minus,
                        "updated_at" => now(),
                    ]);
            } else {
                $minus = $inStock + (int)$value['quantityRAC'];

                Stock::where('product_id', $value['product_Id'])
                    ->where('product_varient', $value['product_variant'])
                    ->where('batch_code', $value['batchCode'])
                    ->update([
                        "quantity" => $minus,
                        "updated_at" => now(),
                    ]);
            }
        }

        // ReturnAndExchange::where('id', $request->reuniqueIdinvoic)
        // ->update([
        //     "return_and_exchanges_date" => $request->return_and_exchanges_date,
        //     "zeroInvoiceOrders" => $request->orders,
        //     "updated_at" => now(),
        // ]);


        // $output =   json_decode($request->orders, true);

        // foreach ($output as $value) {
        //     $inStock = Stock::where('product_id', $value['product_Id'])->where('product_variant', $value['product_variant'])->where('batch_code', $value['batchCode'])->value('quantity');

        //         if($request->type != "sale"){
        //             $minus = $inStock - (int)$value['quantityRAC'];

        //             Stock::where('product_id', $value['product_Id'])
        //             ->where('product_variant', $value['product_variant'])
        //             ->where('batch_code', $value['batchCode'])
        //             ->update([
        //                 "quantity" => $minus,
        //                 "updated_at" => now(),
        //             ]);
        //         }else{
        //             $minus = $inStock + (int)$value['quantityRAC'];

        //             Stock::where('product_id', $value['product_Id'])
        //             ->where('product_variant', $value['product_variant'])
        //             ->where('batch_code', $value['batchCode'])
        //             ->update([
        //                 "quantity" => $minus,
        //                 "updated_at" => now(),
        //             ]);
        //         }
        // }


        return response()->json(["success" => "Zero Invoice Updated Successfully."]);
    }


    // =================================================================================
    // fetch a single product
    // =================================================================================
    public function getProductSection()
    {
        if (Auth::User()->is_admin === '2') {
            $id = $_GET["id"];
            $data = product::all()->where("id", $id);
            return response()->json($data);
        } else {
            $id = $_GET["id"];
            $data = product::all()->where("id", $id)->where('owner_id', Auth::User()->id);
            return response()->json($data);
        }
    }

    // =================================================================================
    // Add Product in inventory
    // =================================================================================    
    public function addProduct(Request $request)
    {
        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        $product_id = product::orderBy('id', 'DESC')->pluck('productId')->first();

        if ($product_id == null or $product_id == "") {
            $product_id = 'PRD'.$year.$month.'000001' ;
        } else {
            $number = str_replace('PRD', '', $product_id);
            $product_id = "PRD" . sprintf("%04d", $number + 1);
        }
        $product_Bar = product::orderBy('id', 'DESC')->pluck('id')->first();
        $d = new DNS1D();
        if($request->barcode != null){
            $barcode = $d->getBarcodeSVG((string)$request->barcode, 'C39');
        }else{
            $barcode = $d->getBarcodeSVG((string)$product_id, 'C39');
        }

        $categoryId = $request->productCategory;

        $categoryName = Category::where('id', $categoryId)->value('name');
        $url = env("APP_URL", "http://lfk.sg/");
        $data = [];
        if($request->hasfile('filenames'))
        {
           foreach($request->file('filenames') as $file)
           {
                $file_name = $file->getClientOriginalName();
               $name = $file_name.'.'.time().'.'.$file->extension();
               $file->move(public_path().'/products/images/', $name);
               $data[] = $url.'products/images/'.$name;
           }
        }
         

        if ($request->file('image') == null) {

            product::insert([
                "productId" => $product_id,
                "owner_id" => Auth::user()->id,
                "barcode_id" => $request->barcode != null ? $request->barcode : $product_id,
                "product_name" => $request->name,
                "chinese_product_name" => $request->chinese_product_name,
                "description" => $request->description1,
                "barcode" => $barcode,
                "product_varient" => $request->productVarient,
                "product_category" => $categoryName,
                "category_id" => $categoryId,
                "uom" => $request->uom,
                "img_path" => null,
                "sku_code" => $request->skuCode,
                "min_sale_price" => $request->minScalePrice,
                "images" => json_encode($data),
                "supplier_code" => $request->supCode,
                "supplier_id" => $request->vendor_id,
                "featured_product" => $request->featured_product != null?true:false,
                "created_at" => now(),
                'stock_check' => !empty($request->stock_check) ? 1 : 0
            ]);

            return response()->json(['success' => 'Product Added Successfully']);
        } else {

            $count = product::all()
                ->where("product_name", $request->name)
                ->where("product_varient", $request->productVarient)
                ->where("owner_id", Auth::user()->id)
                ->count();
            if ($count > 0) {
                return response()->json(['barerror' => 'Product is Already Exists in Stock']);
            } else {

                $product_id = product::orderBy('id', 'DESC')->pluck('productId')->first();

                if ($product_id == null or $product_id == "") {
                    $product_id = 'PRD'.$year.$month.'000001';
                } else {
                $number = str_replace('PRD', '', $product_id);

                    $product_id = "PRD".sprintf("%04d", $number + 1) ;
                }

                $product_Bar = product::orderBy('id', 'DESC')->pluck('id')->first();
                $d = new DNS1D();
                // $barcode = $d->getBarcodeSVG((string)$product_Bar, 'C39');
                if($request->barcode != null){
                    $barcode = $d->getBarcodeSVG((string)$request->barcode, 'C39');
                }else{
                    $barcode = $d->getBarcodeSVG((string)$product_id, 'C39');
                }

                $slug = Str::slug($request->name, '-');
                if (!file_exists('products')) {
                    mkdir('products', 666, true);
                }

                $image_resize = \Image::make($request->image->getRealPath());
                
                $name = $slug . date('d_m_y_h') . time();
                $image_resize->save(public_path('products/' . $name . "." .  $request->image->extension(), 100));
                $path = 'products/' . $name . "." .  $request->image->extension();
                $url = env("APP_URL", "http://lfk.sg/");

                product::insert([
                    "productId" => $product_id,
                    "owner_id" => Auth::user()->id,
                    "product_name" => $request->name,
                    "barcode_id" => $request->barcode != null ? $request->barcode : $product_id,
                    "chinese_product_name" => $request->chinese_product_name,
                    "barcode" => $barcode,
                    "product_varient" => $request->productVarient,
                    "product_category" => $categoryName,
                    "description" => $request->description1,
                    "category_id" => $categoryId,
                    "uom" => $request->uom,
                    "images" => json_encode($data),
                    "img_path" => $url . $path,
                    "sku_code" => $request->skuCode,
                    "min_sale_price" => $request->minScalePrice,
                    "supplier_code" => $request->supCode,
                    "supplier_id" => $request->vendor_id,
                    "featured_product" => $request->featured_product != null?true:false,
                    "created_at" => now(),
                    'stock_check' => !empty($request->stock_check) ? 1 : 0
                ]);

                return response()->json(['success' => 'Product Added Successfully']);
            }
            // }
        }
    }


    // =================================================================================
    // Edit Products
    // =================================================================================    
    public function editProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "chinese_product_name" => "required",
            "productVarient" => "required",
            "productCategory" => "required",
            "editMinScalePrice" => "required",
        ]);

        product::where("id", $request->productId)->update([
            "images" => explode(',',$request->updateImages)
        ]);

        $url = env("APP_URL", "http://lfk.sg/");

        $data1 = product::where("id", $request->productId)->value('images');
        $data = json_decode($data1);

        if($request->hasfile('filenames'))
        {
           foreach($request->file('filenames') as $file)
           {
                $file_name = $file->getClientOriginalName();
               $name = $file_name.'.'.time().'.'.$file->extension();
               $file->move(public_path().'/products/images/', $name);
               $data[] = $url.'products/images/'.$name;
           }

                product::where("id", $request->productId)
                    ->update([
                        "images" => json_encode($data),
                    ]);
                }

                $d = new DNS1D();

                $products_details = product::where('id', $request->productId)->first();
                
                if($request->barcode != null){
                    $barcode = $d->getBarcodeSVG((string)$request->barcode, 'C39');
                }else{
                    $barcode = $d->getBarcodeSVG($products_details->productId, 'C39');
                }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            if ($request->file('image') == null) {
                 product::where("id", $request->productId)
                    ->update([
                        "product_name" => $request->name,
                        "barcode_id" => $request->barcode != null?$request->barcode:$products_details->productId,
                        "chinese_product_name" => $request->chinese_product_name,
                        "product_varient" => $request->productVarient,
                        "product_category" => $request->productCategory,
                        "sku_code" => $request->skuCode,
                        "barcode" => $barcode,
                        "min_sale_price" => $request->editMinScalePrice,
                        "uom" => $request->uom,
                        "supplier_id" => $request->supCode,
                        "description" => $request->description1,
                        "featured_product" => $request->featured_product != null?true:false,
                        "updated_at" => now(),
                        'stock_check' => !empty($request->stock_check) ? 1 : 0
                    ]);

                

            } else {

                $slug = Str::slug($request->name, '-');
                if (!file_exists('products')) {
                    mkdir('products', 666, true);
                }
                $image_resize = \Image::make($request->image->getRealPath());
                
                $name = $slug . date('d_m_y_h') . time();
                $image_resize->save(public_path('products/' . $name . "." .  $request->image->extension(), 100));
                $path = 'products/' . $name . "." .  $request->image->extension();
                $url = env("APP_URL", "http://lfk.sg/");

              product::where("id", $request->productId)
                    ->update([
                        "product_name" => $request->name,
                        "barcode_id" => $request->barcode != null?$request->barcode:$products_details->productId,
                        "product_varient" => $request->productVarient,
                        "product_category" => $request->productCategory,
                        "img_path" => $url . $path,
                        "barcode" => $barcode,
                        "sku_code" => $request->skuCode,
                        "min_sale_price" => $request->editMinScalePrice,
                        "supplier_id" => $request->supCode,
                        "featured_product" => $request->featured_product != null?true:false,
                        "description" => $request->description1,
                        "updated_at" => now(),
                        'stock_check' => !empty($request->stock_check) ? 1 : 0
                    ]);
                  
            }

            return response()->json(['success' => 'Product Updated Successfully']);
        }
    }

    // =================================================================================
    // List Varients
    // =================================================================================            
    public function listVarients()
    {
        return response()->json(Category::all()->where('name', $_GET['val']));
    }

    // 
    // Fetch unique varietns
    // 
    public function listUniqueVarients()
    {
        return response()->json(DB::table('products')->select('product_name', 'product_varient')->distinct()->get());
    }

    // =================================================================================
    // Delete Product
    // =================================================================================        
    public function removeProduct()
    {
        $id = $_GET["id"];
        $product = product::where("id", $id)->first();
        
        $stock = Stock::where('product_name', $product->product_name)
                ->where('product_varient', $product->product_varient)
                ->delete();

        $product->delete();

        // product::where("id", $id)->delete();
        return response()->json(["success" => "Product Deleted Successfully."]);
    }

    // =================================================================================
    // view product
    // =================================================================================
    public function viewProduct()
    {
        $id = $_GET["id"];
        $data = product::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // Filter Product
    // =================================================================================
    public function listProductsFilter()
    {
        if (Auth::User()->is_admin === '2') {
            $category = $_GET['category'];

            $data = DB::table('products')->where('product_category', 'LIKE', '%' . $category . '%')->paginate(10);
            return response()->json($data);
        } else {
            $category = $_GET['category'];

            $data = DB::table('products')->where('product_category', 'LIKE', '%' . $category . '%')->where('owner_id', Auth::user()->id)->paginate(10);
            return response()->json($data);
        }
    }

    // =================================================================================
    // Filter Product
    // =================================================================================
    public function listProNameFilter()
    {
        if (Auth::User()->is_admin === '2') {
            $proName = $_GET['product_name'];

            // $data = product::all()->where('product_name', $proName);
            $data = DB::table('products')->where('product_name', 'LIKE', '%' . $proName . '%')->paginate(10);
            return response()->json($data);
        } else {
            $proName = $_GET['product_name'];

            // $data = product::all()->where('product_name', $proName)->where('owner_id', Auth::user()->id);
            $data = DB::table('products')->where('product_name', 'LIKE', '%' . $proName . '%')->where('owner_id', Auth::user()->id)->paginate(10);
            return response()->json($data);
        }
    }

    // ***************************************************************************************************//
    //                                           STOCK SECTION                                            //
    //****************************************************************************************************//


    // =================================================================================
    // add stock
    // =================================================================================
    public function addStock(Request $request)
    {

        $count = Stock::all()
            ->where("product_name", $request->product_name)
            ->where("owner_id", Auth::user()->id)
            ->where('product_category', $request->category)
            ->where('product_varient', $request->varient)
            ->where('batch_code', $request->batchCode)
            ->count();

        if ($count > 0) {

            $oldQty = Stock::where("product_name", $request->product_name)
                ->where("owner_id", Auth::user()->id)
                ->where('product_category', $request->category)
                ->where('product_varient', $request->varient)
                ->where('batch_code', $request->batchCode)->value('quantity');

            $newQty = $request->quantity;

            $qty = (int)$oldQty + (int)$newQty;

            Stock::where("product_name", $request->product_name)
                ->where("owner_id", Auth::user()->id)
                ->where('product_category', $request->category)
                ->where('product_varient', $request->varient)
                ->where('batch_code', $request->batchCode)
                ->update([
                    "quantity" => $qty,
                ]);
            return response()->json(["success" => "Product is Added Successfully in Stock."]);
        } else {

            Stock::insert([
                "owner_id" => Auth::user()->id,
                "warehouse_name" => $request->warehouse,
                "rack" => $request->rack,
                "product_name" => $request->product_name,
                "product_id" => $request->product_id,
                "product_varient" => $request->varient,
                "product_category" => $request->category,
                "quantity" => $request->quantity,
                "batch_code" => $request->skuCode,
                "batch_code" => $request->batchCode,
                "expiry_date" => $request->expiryDate,
                "created_at" => now()
            ]);

            product::where('product_name', $request->product_name)->where('product_varient', $request->varient)
                ->update([
                    'batch_code' => $request->batchCode,
                ]);

            return response()->json(["success" => "Product is Added Successfully in Stock."]);
        }
    }


    // ***************************************************************************************************//
    //                                           CATEGORY SECTION                                         //
    //****************************************************************************************************//

    // =================================================================================
    // List Categories
    // =================================================================================
    public function listCategories()
    {
        $data = Category::all();
        return response()->json($data);
    }

    // =================================================================================
    // List Categories and product
    // =================================================================================
    public function listCategoriesProduct()
    {
        $data = Category::all();
        return response()->json($data);
    }


    // =================================================================================
    // Add Category
    // =================================================================================
    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "chinese_name" => "required",
            // "status" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {

            if ($request->file('image') == null) {
                Category::insert([
                    "owner_id" => Auth::user()->id,
                    "name" => $request->name,
                    "chinese_name" => $request->chinese_name,
                    "created_at" => now(),
                ]);

                return response()->json(['success' => 'Category added successfully']);
            } else {
                $count  = Category::all()->where("name", $request->name)->count();
                if ($count > 0) {
                    return response()->json(['barerror' => $request->name . " Name is Already Taken. Check Category Table!"]);
                } else {

                    // new one
                    if (!file_exists('category')) {
                        mkdir('category', 666, true);
                    }
                    $image_resize = Image::make($request->image->getRealPath());
                    $image_resize->save(public_path('category/' . $request->title . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));

                    $url = env("APP_URL", "https://lfk.sg/");

                    $path = 'category/' . $request->title . date('d_m_y_h') . time() . "." .  $request->image->extension();

                    Category::insert([
                        "owner_id" => Auth::user()->id,
                        "name" => $request->name,
                        "chinese_name" => $request->chinese_name,
                        "image" => $url . $path,
                        "created_at" => now(),
                    ]);

                    return response()->json(['success' => 'Category Added Successfully']);
                }
            }
        }
    }

    // =================================================================================
    // fetch Categories
    // =================================================================================
    public function getCategories()
    {
        $data = DB::table('categories')->orderBy('id', 'DESC')->get();

        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="view" data-toggle="modal" data-target=".viewCategory" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editCat" data-toggle="modal" data-target="#editCategory" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteCat"  data-toggle="modal" data-target="#removeModalCategory" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->name,
                $item->chinese_name,
                ($item->image != null)?'<img width="100" src="'.$item->image.'" />':'<img src="'.asset('dummy-image-portrait.jpg').'" width="100" />',
                $action
            );
            $action = '';
        }
        
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $data->count(),
            "recordsFiltered" 	=> $data->count(),
            "data" 				=> $new_data
        );
        echo json_encode($output);

    }

    // =================================================================================
    // fetch a single product
    // =================================================================================
    public function getCategory()
    {
        $id = $_GET["id"];
        $data = Category::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // edit category
    // =================================================================================    
    public function editCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {


            $categoryImgPath = Category::find($request->id)->value('image');

            if ($request->file('image') == null) {
                Category::where("id", $request->id)
                    ->update([
                        "name" => $request->name,
                        "chinese_name" => $request->chinese_name,
                        "image" => $categoryImgPath,
                        "updated_at" => now(),
                    ]);
                return response()->json(['success' => 'Category Updated Successfully']);
            } else {

                $categoryImgPath = Category::find($request->id);

                File::delete($categoryImgPath->image);

                if (!file_exists('category')) {
                    mkdir('category', 666, true);
                }
                $image_resize = Image::make($request->image->getRealPath());
                // $image_resize->resize(400, 400);
                $image_resize->save(public_path('category/' . $request->title . date('d_m_y_h') . time() . "." .  $request->image->extension(), 100));

                $url = env("APP_URL", "https://lfk.sg/");

                $path = 'category/' . $request->title . date('d_m_y_h') . time() . "." .  $request->image->extension();

                Category::where("id", $request->id)
                    ->update([
                        "name" => $request->name,
                        "chinese_name" => $request->chinese_name,
                        "image" => $url . $path,
                        "updated_at" => now(),
                    ]);
                return response()->json(['success' => 'Category Updated Successfully']);
            }

            // Category::where("id", $request->id)
            // ->update([
            //         "name" => $request->name,
            //         // "status" => $request->status,
            //         "updated_at" => now(),
            // ]);
            // return response()->json(['success'=>'Category updated successfully']);
        }
    }

    // =================================================================================
    // Delete Category
    // =================================================================================        
    public function removeCategory()
    {
        $id = $_GET["id"];
        Category::where("id", $id)->delete();
        return response()->json(["success" => "Category Deleted Successfully."]);
    }

    // =================================================================================
    // view category
    // =================================================================================
    public function viewCategory()
    {
        $id = $_GET["id"];
        $data = Category::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // search category
    // =================================================================================    
    public function searchCategory()
    {
        if ($_GET['category'] != '') {
            $filter = DB::table('categories')->where('name', 'LIKE', '%' . $_GET['category'] . '%')->paginate(10);
            return response()->json($filter);
        } else {
            $filter = DB::table('categories')->paginate(10);
            return response()->json($filter);
        }
    }


    // ***************************************************************************************************//
    //                                    RETURN & EXCHAGE SECTION                                        //
    //****************************************************************************************************//

    // =================================================================================
    // Add Product
    // =================================================================================
    public function addREProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // "type" => "required",
            // "user" => "required",
            // "invoiceNo" => "required",
            // "invoice_date" => "required",
            // "invoice_Amount" => "required",
            // "allProductDetails" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else if (sizeof(json_decode($request->allProductDetails)) === 0) {
            return response()->json(['barerror' => 'Please Add Products in Product Table.']);
        } else {
            ReturnAndExchange::insert([
                "owner_id" => Auth::user()->id,
                "type" => $request->type,
                "invoice_no" => $request->invoiceNo,
                "both_sale_pur" => $request->saleAndPur,
                "user_id" => $request->user,
                "user_name" => $request->user_name,
                "invoice_date" => $request->invoice_date,
                "invoice_amount" => $request->invoice_Amount,
                "orders" => $request->allProductDetails,
                "created_at" => now(),
            ]);

            $array = $request->allProductDetails;

            // $dataArr = [];

            // foreach(json_decode($array) as $k){

            //     if($k->status === 'return'){
            //         // array_push($dataArr, [
            //         //     "type" => $k->status,
            //         //     "user_id" => $request->user,
            //         //     "user_name" => $request->user_name,
            //         //     "invoice_date" => $request->invoiceNo,
            //         //     "product_Id" => $k->product_Id,
            //         //     "product_name" => $k->product_name,
            //         //     "quantity" => $k->quantityRAC,
            //         //     "unit_price" => $k->unit_price,
            //         //     "remark" => $k->remark,
            //         // ]);

            //         Return_Goods_Warehouse::insert([
            //             "type" => $k->status,
            //             "user_id" => $request->user,
            //             "user_name" => $request->user_name,
            //             "invoice_date" => $request->invoice_date,
            //             "product_Id" => $k->product_Id,
            //             "product_name" => $k->product_name,
            //             "quantity" => $k->quantityRAC,
            //             "unit_price" => $k->unit_price,
            //             "remark" => $k->remark,
            //             "created_at" => now(),
            //         ]);
            //     }else{
            //         Exchange_Goods_Warehouse::insert([
            //             "type" => $k->status,
            //             "user_id" => $request->user,
            //             "user_name" => $request->user_name,
            //             "invoice_date" => $request->invoice_date,
            //             "product_Id" => $k->product_Id,
            //             "product_name" => $k->product_name,
            //             "quantity" => $k->quantityRAC,
            //             "unit_price" => $k->unit_price,
            //             "remark" => $k->remark,
            //             "created_at" => now(),
            //         ]);
            //     }

            // }

            // return $dataArr;

            return response()->json(["return_exchange_add_success" => "Product is Added Successfully."]);
        }
    }

    // =================================================================================
    // Fetch all products
    // =================================================================================    
    public function getREProducts()
    {
        // return response()->json(DB::table('return_and_exchanges')->paginate(10));
        $data = DB::table('return_and_exchanges')->orderBy('id', 'DESC')->get();

        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewRE" data-toggle="modal" data-target="#viewProductRE" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editRE" data-toggle="modal" data-target="#editProductReturnExchange" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteRE"  data-toggle="modal" data-target="#removeModalreturnExchange" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->type,
                $item->user_name,
                $item->both_sale_pur,
                $item->invoice_date,
                $item->invoice_amount,
                (($item->type != 'sale')?"--":'<a name="invocProductRE"  data-toggle="modal" data-id="'.$item->id.'"  data-target="#invocProductRE"> Zero Invoice </a>'),
                $action
            );
            $action = '';
        }
        
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> $data->count(),
            "recordsFiltered" 	=> $data->count(),
            "data" 				=> $new_data
        );
        echo json_encode($output);
    }



    // =================================================================================
    // fetch single product
    // =================================================================================        
    public function fetchREProducts()
    {
        $id = $_GET["id"];
        $data = ReturnAndExchange::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // edit product
    // =================================================================================        
    public function editREProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "type" => "required",
            "user" => "required",
            "invoiceNo" => "required",
            "invoice_date" => "required",
            "invoice_Amount" => "required",
            "allProductDetails" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {

            $array = $request->allProductDetails;

            ReturnAndExchange::where('id', $request->reuniqueId)
                ->update([
                    "type" => $request->type,
                    "invoice_no" => $request->invoiceNo,
                    "user_id" => $request->user,
                    "user_name" => $request->user_name,
                    "invoice_date" => $request->invoice_date,
                    "invoice_amount" => $request->invoice_Amount,
                    "orders" => $request->allProductDetails,
                    "updated_at" => now(),
                ]);

            // foreach(json_decode($array) as $k){

            //     if($k->status === 'return'){
            //         // array_push($dataArr, [
            //         //     "type" => $k->status,
            //         //     "user_id" => $request->user,
            //         //     "user_name" => $request->user_name,
            //         //     "invoice_date" => $request->invoiceNo,
            //         //     "product_Id" => $k->product_Id,
            //         //     "product_name" => $k->product_name,
            //         //     "quantity" => $k->quantityRAC,
            //         //     "unit_price" => $k->unit_price,
            //         //     "remark" => $k->remark,
            //         // ]);

            //         Return_Goods_Warehouse::where('product_Id', $k->product_Id)
            //         ->update([
            //             "type" => $k->status,
            //             "user_id" => $request->user,
            //             "user_name" => $request->user_name,
            //             "invoice_date" => $request->invoice_date,
            //             "product_Id" => $k->product_Id,
            //             "product_name" => $k->product_name,
            //             "quantity" => $k->quantityRAC,
            //             "unit_price" => $k->unit_price,
            //             "remark" => $k->remark,
            //             "updated_at" => now(),
            //         ]);
            //     }else{
            //         Exchange_Goods_Warehouse::where('product_Id', $k->product_Id)
            //         ->update([
            //             "type" => $k->status,
            //             "user_id" => $request->user,
            //             "user_name" => $request->user_name,
            //             "invoice_date" => $request->invoice_date,
            //             "product_Id" => $k->product_Id,
            //             "product_name" => $k->product_name,
            //             "quantity" => $k->quantityRAC,
            //             "unit_price" => $k->unit_price,
            //             "remark" => $k->remark,
            //             "updated_at" => now(),
            //         ]);
            //     }

            // }

            return response()->json(["success" => "Product is Updated Successfully."]);
        }
    }

    // =================================================================================
    // remove product
    // =================================================================================        
    public function removeREProducts()
    {
        $id = $_GET["id"];
        ReturnAndExchange::where("id", $id)->delete();
        return response()->json(["success" => "Product is Deleted Successfully."]);
    }

    // =================================================================================
    // view product
    // =================================================================================        
    public function viewREProducts()
    {
        $id = $_GET["id"];
        $data = ReturnAndExchange::all()->where("id", $id);
        return response()->json($data);
    }

    // =================================================================================
    // filter return exchange product
    // =================================================================================            
    public function viewREFilter()
    {
        $status = $_GET['status'];
        return response()->json(ReturnAndExchange::all()->where('status', $status));
    }

    public function inputREFilter()
    {
        $pro_name = $_GET['user'];
        // return response()->json(ReturnAndExchange::all()->where('user', $pro_name));
        return response()->json(DB::table('return_and_exchanges')->where('user_name', 'LIKE', '%' . $pro_name . '%')->paginate(10));
    }

    // ***************************************************************************************************//
    //                                       Stock Tracking SECTION                                       //
    //****************************************************************************************************//     

    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage;
        $itemstoshow = array_slice($items, $offset, $perPage);
        return new LengthAwarePaginator($itemstoshow, $total, $perPage);
    }

    // =================================================================================
    // fetch all stock tracking detials
    // =================================================================================
    public function fetchStockTrackingDetails(Request $request)
    {
        $sales_Invoice = SalesInvoice::all();
        $purchase_Invoice = PurchaseOrder::all();

        $arr = [];

        foreach ($sales_Invoice as $value) {
            array_push($arr, (object)[
                "id" => $value['id'],
                "products" => $value['products'],
                "name" => $value['customer_name'],
                "receipt_date" => $value['invoice_date'],
                "status" => "Outgoing"
            ]);
        }

        foreach ($purchase_Invoice as $value) {
            array_push($arr, (object)[
                "id" => $value['id'],
                "products" => $value['products'],
                "name" => $value['vendor_name'],
                "receipt_date" => $value['receipt_date'],
                "status" => "Incoming"
            ]);
        }

        // $data = $this->paginate($arr, 4);
        // $data->withPath($request->url());
        // return $data;

        $i = 0;
        $action = '';
        $new_data = [];

        foreach($arr as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a data-toggle="modal" data-target="#viewProducts" onclick="fetchProducts('. $item->id .')" class="dropdown-item" href="javascript:void(0)" id="stockTrackingModalPopBtn">View Products</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->name,
                $item->receipt_date,
                $item->status,
                $action
            );
            $action = '';
        }
        
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($arr),
            "recordsFiltered" 	=> sizeOf($arr),
            "data" 				=> $new_data
        );
        echo json_encode($output);

    }

    // =================================================================================
    // fetch all stock tracking products detials
    // =================================================================================    
    public function fetchStockProductsDetails()
    {
        $id = $_GET['id'];
        $sales_Invoice = SalesInvoice::all()->where('id', $id);
        $purchase_Invoice = PurchaseOrder::all()->where('id', $id);

        $productsArr = [];

        foreach ($sales_Invoice as $value) {
            array_push($productsArr, (object)[
                "products" => $value['products'],
                "name" => $value['customer_name'],
                "status" => "Outgoing"
            ]);
        }

        foreach ($purchase_Invoice as $value) {
            array_push($productsArr, (object)[
                "products" => $value['products'],
                "name" => $value['vendor_name'],
                "status" => "Incoming"
            ]);
        }

        return $productsArr;
    }

    public function fetchStockProductsDetailsFilter(Request $request)
    {

        return $_GET['user'];

        $sales_Invoice = SalesInvoice::all();
        $purchase_Invoice = PurchaseOrder::all();

        $arr = [];

        foreach ($sales_Invoice as $value) {
            array_push($arr, (object)[
                "id" => $value['id'],
                "products" => $value['products'],
                "name" => $value['customer_name'],
                "receipt_date" => $value['invoice_date'],
                "status" => "Outgoing"
            ]);
        }

        foreach ($purchase_Invoice as $value) {
            array_push($arr, (object)[
                "id" => $value['id'],
                "products" => $value['products'],
                "name" => $value['vendor_name'],
                "receipt_date" => $value['receipt_date'],
                "status" => "Incoming"
            ]);
        }

        $data = $this->paginate($arr, 4);
        $data->withPath($request->url());
        return $data;
    }

    // ***************************************************************************************************//
    //                                       Stock Aging SECTION                                          //
    //****************************************************************************************************//    

    // =================================================================================
    // get stock details
    // =================================================================================            
    public function getStockDetails()
    {
        if (Auth::user()->is_admin === '2') {
            // return response()->json(DB::table('stocks')->paginate(10));
            $data = DB::table('stocks')->orderBy('id','desc')->get();

            $i = 0;
            $action = '';
            $new_data = [];

            foreach($data as $item){
                $action .= '<div class="dropdown">';
                $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                $action .= '</a>';
                $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                $action .= '<a name="editStock" data-toggle="modal" data-target=".editStock" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                $action .= '<a name="delStock" data-toggle="modal" data-target="#removeModalStockAging" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                $action .= '</div>';
                $action .= '</div>';

                $new_data[] = array(
                    ++$i,
                    $item->warehouse_name,
                    $item->product_name,
                    $item->product_varient,
                    $item->product_category,
                    $item->batch_code,
                    $item->quantity,
                    (($item->expiry_date !=null)?$item->expiry_date:"--"),
                    $action
                );
                $action = '';
            }

        } else {
            // return response()->json(DB::table('stocks')->where('owner_id', Auth::user()->id)->paginate(10));
            $data = DB::table('stocks')->where('owner_id', Auth::user()->id)->orderBy('id','desc')->get();
            
            $i = 0;
            $action = '';
            $new_data = [];

            foreach($data as $item){
                $action .= '<div class="dropdown">';
                $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                $action .= '</a>';
                $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                $action .= '<a name="editStock" data-toggle="modal" data-target=".editStock" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                $action .= '<a name="delStock" data-toggle="modal" data-target="#removeModalStockAging" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                $action .= '</div>';
                $action .= '</div>';

                $new_data[] = array(
                    ++$i,
                    $item->warehouse_name,
                    $item->product_name,
                    $item->product_varient,
                    $item->product_category,
                    $item->batch_code,
                    $item->quantity,
                    (($item->expiry_date !=null)?$item->expiry_date:"--"),
                    $action
                );
                $action = '';
            }

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
    // get single stock detials
    // =================================================================================      
    public function getSingleStockDetails()
    {
        return response()->json(Stock::all()->where('id', $_GET['id']));
    }

    // =================================================================================
    // update single stock detials
    // =================================================================================      
    public function updateSingleStockDetails(Request $request)
    {

        Stock::where('id', $request->id)
            ->update([
                "quantity" => $request->quantity,
                "batch_code" => $request->batchCode,
                "expiry_date" => $request->expiryDate,
                "updated_at" => now()
            ]);
        return response()->json(["success" => "Product is Updated Successfully in Stock."]);
    }

    public function removeSingleStockDetails()
    {
        try {
            Stock::where('id', $_GET['id'])->delete();
            return response()->json(["success" => "Product is Removed Successfully in Stock."]);
        } catch (Exception $e) {
            return response()->json(['barerror' => $e->getMessage()]);
        }
    }

    // filter
    public function filterSingleStockDetails()
    {
        $proName = $_GET['product_name'];
        if ($_GET['product_name'] != '') {
            // return response()->json(Stock::all()->where('product_name', $proName));
            return response()->json(DB::table('stocks')->where('product_name', 'LIKE', '%' . $proName . '%')->paginate(10));
        } else {
            return response()->json(DB::table('stocks')->paginate(10));
        }
    }



    // ***************************************************************************************************//
    //                                       Warehouse SECTION                                          //
    //****************************************************************************************************//    

    // =================================================================================
    // Add warehouse
    // =================================================================================   
    public function addWarehouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "shortCode" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            try {

                if (Warehouse::where('name', $request->name)->where('owner_id', Auth::user()->id)->count() >= 1) {

                    return response()->json(['barerror' => 'Warehouse Name Already Exist.']);
                } else {

                    Warehouse::insert([
                        "owner_id" => Auth::user()->id,
                        "name" => $request->name,
                        "short_code" => $request->shortCode,
                        "address" => $request->address,
                        "racks" => $request->racks,
                        "created_at" => now(),
                    ]);

                    return response()->json(['success' => 'Warehouse Details Added Successfully']);
                }
            } catch (Exception $e) {
                return response()->json(['barerror' => $e->getMessage()]);
            }
        }
    }

    // all list warehouse detials
    public function getAllWarehouseDetails()
    {
        if (Auth::user()->is_admin === '2') {
            try {
                return response()->json(Warehouse::all());
            } catch (Exception $e) {
                return response()->json(['success' => $e->getMessage()]);
            }
        } else {
            try {
                return response()->json(Warehouse::all());
            } catch (Exception $e) {
                return response()->json(['success' => $e->getMessage()]);
            }
        }
    }


    // get warehouse list name detials
    public function getlistWarehouseNameDetails()
    {
        try {
            return response()->json(Warehouse::all()->where('id', $_GET['id']));
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }
    // add Multi Image
    public function addMultiImage(Request $request)
    {
        $randam = rand();

        $imageName1 = time() .$randam.'img1.' . $request->Image1->extension();
        $request->Image1->move(public_path('products'), $imageName1);
        $url1 = env("APP_URL", "http://lfk.sg/");
        $imageName2 = time() .$randam. 'img2.' . $request->Image2->extension();
        $request->Image2->move(public_path('products'), $imageName2);
        $url2 = env("APP_URL", "http://lfk.sg/");
        $imageName3 = time() .$randam. 'img3.' . $request->Image3->extension();
        $request->Image3->move(public_path('products'), $imageName3);
        $url3 = env("APP_URL", "http://lfk.sg/");
        $imageName4 = time() .$randam. 'img4.' . $request->Image4->extension();
        $request->Image4->move(public_path('products'), $imageName4);
        $url4 = env("APP_URL", "http://lfk.sg/");

        MultiImage::insert([
            "owner_id" => Auth::user()->id,
            "category" => $request->selCategory,
           "product" => $request->selproductname,
           "product_id" => $request->nameProductId,
           "Image1" => $url1 . 'products/' . $imageName1,
            "Image2" =>  $url2 . 'products/' . $imageName2,
            "Image3" => $url3 . 'products/' . $imageName3,
            "Image4" =>  $url4 . 'products/' . $imageName4,
            "created_at" => now(),
        ]);

        return response()->json(['success' => 'Images Added Successfully']);


    }

    // =================================================================================
    // fetch all image
    // =================================================================================
    public function getProductsImages(Request $request)
    {
        if (Auth::User()->is_admin === '2') {
            // return response()->json(product::all());
            return response()->json(DB::table('multi_images')->orderBy('id','desc')->paginate(10));
        } else {
            // return response()->json(product::all()->where('owner_id', Auth::User()->id));
            return response()->json(DB::table('multi_images')->where('owner_id', Auth::User()->id)->orderBy('id','desc')->paginate(10));
        }
    }

    // =================================================================================
    // fetch a single image
    // =================================================================================
    public function getImageSection()
    {
        if (Auth::User()->is_admin === '2') {
            $id = $_GET["id"];
            $data = MultiImage::all()->where("id", $id);
            return response()->json($data);
        } else {
            $id = $_GET["id"];
            $data = MultiImage::all()->where("id", $id)->where('owner_id', Auth::User()->id);
            return response()->json($data);
        }
    }



    // get Product list name detials
    public function getlistMultiImagesDetails()
    {
        try {
            return response()->json(product::all()->where('category_id', $_GET['category_id']));
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }

    // get Product list name detials
    public function getlistMultiImagesId()
    {
        try {
            return response()->json(product::all()->where(' id', $_GET['id']));
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }

    // fetch all rack warehouse details
    public function rackInfo()
    {
        $rack = $_GET['rack'];
        $warehouse = $_GET['warehouse'];

        try {
            return response()->json(Stock::all()->where('rack', $rack)->where('warehouse_name', $warehouse));
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }

    // warehouse filter
    public function warehouseFilter()
    {
        try {
            return response()->json(DB::table('warehouses')->where('name', 'LIKE', '%' . $_GET['warehouse'] . '%')->paginate(10));
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }

    // fetch all
    public function getWarehouseDetails()
    {
        if (Auth::user()->is_admin == '2') {
            // dd('i am here');
            try {
                // Warehouse::all()
                // return response()->json(DB::table('warehouses')->paginate(10));
                $data=DB::table('warehouses')->orderBy('id','desc')->get();
     
                $i = 0;
                $action = '';
                $new_data = [];

                foreach($data as $item){
                    $action .= '<div class="dropdown">';
                    $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                    $action .= '</a>';
                    $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                    $action .= '<a name="viewWarehouse" data-toggle="modal" data-target=".viewWarehouse" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
                    $action .= '<a name="editWarehouse" data-toggle="modal" data-target=".editWarehouse" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                    $action .= '<a name="delWarehouse" data-toggle="modal" data-target="#removeModalWarehouse" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                    $action .= '</div>';
                    $action .= '</div>';

                    $new_data[] = array(
                        ++$i,
                        $item->name,
                        $item->short_code,
                        (($item->address!=null)?$item->address:"--"),
                        $action
                    );
                    $action = '';
                }

            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        } else {
            try {
                // return response()->json(DB::table('warehouses')->where('owner_id', Auth::user()->id)->paginate(10));
                $data = DB::table('warehouses')->where('owner_id', Auth::user()->id)->orderBy('id', 'desc')->get();

                $i = 0;
                $action = '';
                $new_data = [];

                foreach($data as $item){
                    $action .= '<div class="dropdown">';
                    $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
                    $action .= '</a>';
                    $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
                    $action .= '<a name="viewWarehouse" data-toggle="modal" data-target=".viewWarehouse" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
                    $action .= '<a name="editWarehouse" data-toggle="modal" data-target=".editWarehouse" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
                    $action .= '<a name="delWarehouse" data-toggle="modal" data-target="#removeModalWarehouse" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
                    $action .= '</div>';
                    $action .= '</div>';

                    $new_data[] = array(
                        ++$i,
                        $item->name,
                        $item->short_code,
                        (($item->address!=null)?$item->address:"--"),
                        $action
                    );
                    $action = '';
                }
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($data),
            "recordsFiltered" 	=> sizeOf($data),
            "data" 				=> $new_data
        );
        echo json_encode($output);
    }

    // fetch single
    public function singleWarehouseDetails()
    {
        try {
            $id = $_GET['id'];
            $data = Warehouse::where('id', $id)->first();
            $stock = Stock::where('warehouse_name', $data->name)->get();
            return response()->json(["data"=>$data, "stock"=>$stock]);
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }

    // update 
    public function updateWarehouseDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "shortCode" => "required",
            // "address" => "required",
            // "racks" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {
            try {

                Warehouse::where('id', $request->warehouseId)
                    ->update([
                        "name" => $request->name,
                        "short_code" => $request->shortCode,
                        "address" => $request->address,
                        "racks" => $request->rackArr,
                        "updated_at" => now(),
                    ]);

                return response()->json(['success' => 'Warehouse Details Updated Successfully']);
            } catch (Exception $e) {
                return response()->json(['barerror' => $e->getMessage()]);
            }
        }
    }

    // remove
    public function removeWarehouseDetails()
    {
        try {
            $id = $_GET['id'];
            Warehouse::where('id', $id)->delete();
            return response()->json(['success' => 'Warehouse Details Removed Successfully']);
        } catch (Exception $e) {
            return response()->json(['success' => $e->getMessage()]);
        }
    }


    // // return goods warehouse
    // public function getReturnGoodsWarehouseDetails()
    // {
    //     return response()->json(ReturnAndExchange::all());
    // }


    // return goods warehouse
    public function getReturnGoodsWarehouseDetails(Request $request)
    {
        $data = DB::table('return_and_exchanges')->select(['orders', 'user_name', 'invoice_date'])->get();

        // dd($data);

        $arr = [];

        if ($_GET['type'] == 'return')
            foreach ($data as $kay1 => $value1) {
                // dd($value1);
                // echo print_r($value1);
                foreach (json_decode($value1->orders) as $key => $value) {
                    // return $value1->user_name;
                    if ($value->status == 'return') {
                        array_push($arr, [
                            "user_name" => $value1->user_name,
                            "invoice_date" => $value1->invoice_date,
                            "product_Id" => $value->product_Id,
                            "product_name" => $value->product_name,
                            "quantity" => $value->quantity,
                            "unit_price" => $value->unit_price,
                            "subTotal" => $value->subTotal,
                            "status" => $value->status,
                            "quantityRAC" => $value->quantityRAC,
                            "remark" => $value->remark
                        ]);
                    }
                }
            }
        else {
            foreach ($data as $kay1 => $value1) {
                // return json_decode($value->orders);
                foreach (json_decode($value1->orders) as $key => $value) {
                    // return $value->status;
                    if ($value->status == 'exchange') {
                        array_push($arr, [
                            "user_name" => $value1->user_name,
                            "invoice_date" => $value1->invoice_date,
                            "product_Id" => $value->product_Id,
                            "product_name" => $value->product_name,
                            "quantity" => $value->quantity,
                            "unit_price" => $value->unit_price,
                            "subTotal" => $value->subTotal,
                            "status" => $value->status,
                            "quantityRAC" => $value->quantityRAC,
                            "remark" => $value->remark
                        ]);
                    }
                }
            }
        }


        $i = 0;
        $new_data = [];

        foreach($arr as $item){
            $new_data[] = array(
                ++$i,
                $item['user_name'],
                $item['invoice_date'],
                $item['product_name'],
                $item['quantityRAC'],
                $item['unit_price'],
            );
        }
        $output = array(
            "draw" 				=> request()->draw,
            "recordsTotal" 		=> sizeOf($arr),
            "recordsFiltered" 	=> sizeOf($arr),
            "data" 				=> $new_data
        );
        echo json_encode($output);

        // $data = $this->paginate($arr, 4);
        // $data->withPath($request->url());
        // return $data;
    }
}
