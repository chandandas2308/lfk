<?php

namespace App\Http\Controllers\SuperAdmin;

use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Stock;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class BulkStock extends Controller
{
    //
    public function bulkStockUpload(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "bulk_file" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{

                $file = $request->file('bulk_file');

                $imageName = time().'.'.$request->bulk_file->extension();

                $request->bulk_file->move(public_path('stock'), $imageName);

                $location = 'stock';
                
                $filepath = public_path($location . "\\" . $imageName);


                try{
                    $users = (new FastExcel)->import($filepath, function ($line) {
                        if($line['Warehouse Name'] === '' || $line['Rack']=== '' || $line['Product Id']==='' || $line['Product Name']==='' || $line['Product Category']==='' || $line['Product Varients']==='' || $line['Quantity']==='' || $line['Batch Code']==='' || $line['Expiry Date']==='')
                        {
                            return [
                                "warehouse" => $line['Warehouse Name'],
                                "rack" => $line['Rack'],
                                "id" => $line['Product Id'],
                                "name" => $line['Product Name'],
                                "cat" => $line['Product Category'],
                                "var" => $line['Product Varients'],
                                "qty" => $line['Quantity'],
                                "batch" => $line['Batch Code'],
                                "date" => $line['Expiry Date'],
                            ];
                        }else{
                            Stock::insert([
                                "owner_id" => Auth::user()->id,
                                "warehouse_name" => $line['Warehouse Name'],
                                "rack" => $line['Rack'],
                                "product_id" => $line['Product Id'],
                                "product_name" => $line['Product Name'],
                                "product_category" => $line['Product Category'],
                                "product_variant" => $line['Product Varients'],
                                "quantity" => $line['Quantity'],
                                "sku_code" => $line['Batch Code'],
                                "expiry_date" => $line['Expiry Date'],
                                "created_at" => now()
                            ]);
            
                            product::where('id', $line["Product Id"])
                            ->update([
                                'batch_code' => $line['Batch Code'],
                            ]);

                            return true;
                        }
                    });

                    if($users[0] == 1){
                        return response()->json(['bulk_success' => 'Data Uploaded Successfully.']);
                    }else{
                        return response()->json(['bulk_success_alert' => 'Check Your File. File Should Contain All Maindatory Fields.']);
                    }

                }Catch(Exception $e){
                    return response()->json(['bulk_success_alert' => 'Your File Should Contain All Mandatory Fields']);
                }
        }
    }
    // download stock excel file
    public function stocksExcel()
    {
        return (new FastExcel(Stock::all()))->download('stocks.xlsx', function ($product) {
            return [
                "Warehouse Name" => '',
                "Rack" => '',
                "Product Id" => '',
                "Product Name" => '',
                "Product Varients" => '',
                "Product Category" => '',
                "Quantity" => '',
                "Batch Code" => '',
                "Expiry Date" => '',
            ];
        });
    }
}
