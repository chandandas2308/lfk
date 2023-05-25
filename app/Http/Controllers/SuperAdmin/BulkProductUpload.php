<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Vendors;
use Exception;
use \Milon\Barcode\DNS2D;
use \Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class BulkProductUpload extends Controller
{
    //
    public function bulkProductUpload(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "bulk_file" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {

            $file = $request->file('bulk_file');

            $imageName = time() . '.' . $request->bulk_file->extension();

            $request->bulk_file->move(public_path('uploads'), $imageName);

            $location = 'uploads';

            $filepath = public_path($location . "/" . $imageName);

            // try {
                    
                $users = (new FastExcel)->import($filepath, function ($line) {
                    if ($line['Product Name'] == '' || $line['Product Category'] == '' || $line['Product Variant'] == '' || $line["Category ID"] == '' || $line['UOM'] == '' || $line['Minimum Sale Price'] == '' || $line['Vendor ID'] == '' || $line['Vendor Name'] == '') 
                    {

                        return 'Mandatory field skipped';

                    } 
                    else 
                    {
                        $vendor = Vendors::all()->where('id', $line['Vendor ID'])->count();
                        if ($vendor > 0) 
                        {
                            $category = Category::where('id',$line["Category ID"])->count();
                            if($category > 0)
                            {
                                $product = product::where('product_name', $line['Product Name'])->where('product_varient', $line['Product Variant'])->count();
                                if ($product < 1)
                                {
                                    $product_id = product::orderBy('id', 'DESC')->pluck('id')->first();

                                    if ($product_id == null or $product_id == "")
                                    {
                                        $product_id = 1;
                                    }
                                    else
                                    {
                                        $product_id = $product_id + 1;
                                    }

                                    $d = new DNS1D();
                                    $barcode = $d->getBarcodeSVG((string)$product_id, 'C39');
                                
                                    return product::insert([
                                        "id" => $product_id,
                                        "owner_id" => Auth::user()->id,
                                        "product_name" => $line['Product Name'],
                                        "product_varient" => $line['Product Variant'],
                                        "product_category" => $line['Product Category'],
                                        "category_id" => $line['Category ID'],
                                        "uom" => $line['UOM'],
                                        "barcode" => $barcode,
                                        "sku_code" => $line['SKU Code'],
                                        "min_sale_price" => $line['Minimum Sale Price'],
                                        "supplier_code" => $line['Vendor Name'],
                                        "supplier_id" => $line['Vendor ID'],
                                        "created_at" => now()
                                    ]);
                                }
                                else
                                {
                                    return 'Products already exits';
                                }
                            }
                            else
                            {
                                return 'Category ID did not match';
                            }
                        }
                        else
                        {
                            return 'Vender ID did not match';
                        }
                    }
                });

                $success_records = 0;
                $error_records = 0;

                foreach($users as $key => $value){
                    if($value == "true"){
                        ++$success_records;
                    }else{
                        ++$error_records;
                    }
                }
                File::delete($filepath);
            return response()->json(['bulk_success' => 'Data Uploaded Successfully', "success_records"=>$success_records, "error_records"=>$error_records, "info"=>$users]);
        }
    }

    // download products excel file
    public function productsExcel()
    {
        return (new FastExcel(product::all()))->download('product.xlsx', function ($product) {
            return [
                "Product Name" => '',
                "Product Variant" => '',
                "Product Category" => '',
                "UOM" => '',
                "Vendor ID" => '',
                "Vendor Name" => '',
                "SKU Code" => '',
                "Minimum Sale Price" => '',
            ];
        });
    }
}
