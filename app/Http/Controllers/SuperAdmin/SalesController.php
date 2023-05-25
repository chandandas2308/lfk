<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\address;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\SalesInvoice;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\Notification;
use Exception;
use App\Models\Quotation;
use App\Models\Stock;
use App\Models\UserOrder;
use App\Models\UserOrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Symfony\Contracts\Service\Attribute\Required;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Hash;

//namespace App\Http\Controllers;

//use Illuminate\Http\Request;

class SalesController extends Controller
{



    public function salesAllBatchCode()
    {
        $data = Stock::all()->where('product_name', $_GET['proName'])->where('product_varient', $_GET['proVariant']);
        return $data;
    }

    // ***************************************************************************************************//
    //                                           Quotation SECTION                                        //
    //****************************************************************************************************//
    // add quotation
    public function addQuotation(Request $request)
    {

        $allProductDetails = $_REQUEST['allProductDetails'];

        $validator = Validator::make($request->all(), [
            "customerName" => "required",
            "expiration"  => "required",
            "customerAddress" => "required",
            "paymentTerms"  => "required",
            "untaxtedAmount"  => "required",
            // "gst"  => "required",
            "quotationTotal" => "required",
        ]);

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        $product_id = Quotation::orderBy('id', 'DESC')->pluck('quotation_id')->first();


        if ($product_id == null or $product_id == "") {
            $product_id = 'LFKRFQ'.$year.$month.'000001' ;
        } else {
            $number = (int)str_replace('LFKRFQ', '', $product_id);

            $product_id = "LFKRFQ" . sprintf("%04d", $number + 1);

        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else if (sizeof(json_decode($allProductDetails)) === 0) {
            return response()->json(['barerror' => 'Please add products in product table.']);
        } else {

            $checkbox = ($request->taxInclude === 'on') ? true : false;

            Quotation::insert([
                "owner_id" => Auth::user()->id,
                "customer_id" => $request->customerName,
                "quotation_id" => $product_id,
                "customer_name" => $request->qCustomer_id,
                "expiration" => $request->expiration,
                "customer_address" => $request->customerAddress,
                "payment_terms" => $request->paymentTerms,
                "products_details" => $allProductDetails,
                "tax_inclusive" => $checkbox,
                "untaxted_amount" => $request->untaxtedAmount,
                "GST" => $request->gst,
                "status" => "Pending",
                "note" => $request->notes,
                "gstValue" => $request->gstValue,
                "sub_total" => $request->quotationTotal,
                "created_at" => now()
            ]);

            return response()->json(["success" => "Quotation Generated Successfully."]);
        }
    }

    // list all quotations num for detials in invoice in sales tab
    public function getAllQuotations()
    {
        return response()->json(Quotation::all());
    }
    public function getAllinvoiceQuotations()
    {
        $id = "Yes";
        return response()->json(Quotation::all()->where("invoicestatus", "!=", $id)->where("orderID", "!=", null));
    }
    // fetch all quotations
    public function getQuotations()
    {
        $data=DB::table('quotations')->orderBy('id','DESC')->get();
        
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewQuotation" data-toggle="modal" data-target="#viewQuotation" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editQuotation" style="display:'. $item->display .';" data-toggle="modal" data-target="#editQuotation" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteQuotation" style="display:'. $item->display .';" data-toggle="modal" data-target="#removeModalSalesQuotation" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $status = $item->status != "Confirmed" ? 'pointer' : '';
            
            $new_data[] = array(
                ++$i,
                $item->quotation_id,
                $item->customer_name,
                number_format($item->sub_total,2),
                number_format($item->sub_total,2),
                $item->expiration,
                number_format($item->sub_total,2),
                $item->payment_terms,
                (($item->status != "Pending") ? "Confirmed" : '<a class="'. $status .' btn btn-primary" data-toggle="modal" data-target="#statusModalSalesQuotation" name="statusQuotation" data-id="'. $item->id. '" >'. $item->status. '</a>'),
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
    public function getQuotationsorder()
    {
        $data = DB::table('quotations')->where("status", "Confirmed")->orderBy('id','DESC')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewQuotationORDER" data-toggle="modal" data-target="#viewQuotationORDER" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="deleteQorder" style="display:'. $item->display .';" data-toggle="modal" data-target="#removeModalorderQuotation" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->quotation_id,
                $item->customer_name,
                number_format($item->sub_total,2),
                number_format($item->sub_total,2),
                $item->expiration,
                number_format($item->sub_total,2),
                $item->payment_terms,
                (($item->display != "none")?'<a data-toggle="modal" class="btn btn-primary"  data-target="#statusModalOrderQuotation" name="statusorderQuotation" data-id="'.$item->id.'" >Cancel</a>':"Invoiced"),
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

    // fetch a single quotation
    public function getQuotation()
    {
        $id = $_GET['id'];
        return response()->json(Quotation::all()->where("orderID", $id));
    }

    // fetch a single quotation
    public function getQuotation1()
    {
        $id = $_GET['id'];
        return response()->json(Quotation::all()->where("id", $id));
    }

    // update quotation
    public function updateQuotation(Request $request)
    {
        $allProductDetails = $_REQUEST['allProductDetails'];

        $validator = Validator::make($request->all(), [
            "customerName" => "required",
            "expiration"  => "required",
            "customerAddress" => "required",
            "paymentTerms"  => "required",
            "untaxtedAmount"  => "required",
            // "gst"  => "required",
            "quotationTotal" => "required",
        ]);
        

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else if (sizeof(json_decode($allProductDetails)) === 0) {
            return response()->json(['barerror' => 'Please add products in product table.']);
        } else {

            $checkbox = ($request->taxInclude === 'on') ? true : false;

            Quotation::where('id', $request->quotationId)
                ->update([
                    "customer_id" => $request->customerName,
                    "quotation_id" => $request->product_id,
                    "customer_name" => $request->qCustomer_id,
                    "expiration" => $request->expiration,
                    "customer_address" => $request->customerAddress,
                    "payment_terms" => $request->paymentTerms,
                    "products_details" => $allProductDetails,
                    "tax_inclusive" => $checkbox,
                    "untaxted_amount" => $request->untaxtedAmount,
                    "GST" => $request->gst,
                    "note" => $request->notes,
                    "gstValue" => $request->gstValue,
                    "sub_total" => $request->quotationTotal,
                    "updated_at" => now()
                ]);

            return response()->json(["success" => "Quotation Updated Successfully."]);
        }
    }

    // remove quotation
    public function removeQuotation()
    {
        $id = $_GET['id'];
        Quotation::where('id', $id)->delete();
        return response()->json(['success' => "Quotation Removed Successfully."]);
    }
    // change quotation
    public function statusQuotation()
    {

        $id = $_GET['id'];

        // $id2 = IdGenerator::generate(['table' => 'quotations','field'=>'id', 'length' => 3, 'prefix' =>$id]);
        // $id2 = 20;

        $id2 = Quotation::orderBy('id', 'DESC')->pluck('id')->first();

        if ($id2 == null or $id2 == "") {
            $id2 = 1;
        } else {
            $id2 = $id2 + 1;
        }


        Quotation::where('id', $_GET['id'])
            ->update([
                "status" => "Confirmed",
                "orderID" => $id2,
            ]);

        return response()->json(["success" => "Quotation Status Updated Successfully."]);
    }

    public function statusorderQuotation()
    {
        $id = $_GET['id'];
        Quotation::where('id', $_GET['id'])
            ->update([
                "status" => "Pending",
                "orderID" => null,
            ]);

        return response()->json(["success" => "Order Status Updated Successfully."]);
    }

    // Fetch Special Price Filtered Products Detials
    public function getFilterProducts()
    {
        $customer_id = $_GET['id'];
        $all_products = product::all()->unique(['product_name'])->toArray();

        $customer_pro = Customer::all()->where('id', $customer_id)->value('specialPrice');

        $arr1Id = [];

        $arr2Id = [];

        $finalProDetials = [];

        if (empty(json_decode($customer_pro))) {

            foreach ($all_products as $k1 => $v1) {
                array_push($finalProDetials, [
                    "id" => $v1['id'],
                    "product_name" => $v1['product_name'],
                    "sku_code" => $v1['sku_code'],
                    "batch_code" => $v1['batch_code'],
                    "category" => $v1['product_category'],
                    "varient" => $v1['product_varient'],
                    "unit_price" => $v1['min_sale_price']
                ]);
            }
        } else {

            foreach ($all_products as $k => $v) {
                array_push($arr1Id, $v['product_name']);
            }

            foreach (json_decode($customer_pro) as $k => $v) {
                array_push($arr2Id, $v->product_name);
            }

            $unmatch_pro = array_diff($arr1Id, $arr2Id);

            // products which not listed in special price list
            foreach ($unmatch_pro as $k => $v) {
                foreach ($all_products as $k1 => $v1) {
                    if ($v === $v1['product_name']) {
                        array_push($finalProDetials, [
                            "id" => $v1['id'],
                            "product_name" => $v1['product_name'],
                            "category" => $v1['product_category'],
                            "varient" => $v1['product_varient'],
                            "sku_code" => $v1['sku_code'],
                            "batch_code" => $v1['batch_code'],
                            "sku_code" => $v1['sku_code'],
                            "unit_price" => $v1['min_sale_price']
                        ]);
                    }
                }
            }

            // products which listed in special price list
            foreach (json_decode($customer_pro) as $k => $v) {
                array_push($finalProDetials, [
                    "id" => (int)$v->id,
                    "product_name" => $v->product_name,
                    "category" => $v->category,
                    "varient" => $v->product_varient,
                    "sku_code" => $v->sku_code,
                    "batch_code" => $v->batch_code,
                    "unit_price" => $v->specialPrice
                ]);
            }
        }

        return response()->json($finalProDetials);
    }

    public function fetchProductsDetialsInfo()
    {

        $customer_id = $_GET['id'];

        $all_products = product::all()->toArray();

        $customer_pro = Customer::all()->where('id', $customer_id)->value('specialPrice');

        $arr1Id = [];

        $arr2Id = [];

        $unmatch_pro = [];

        if (empty(json_decode($customer_pro))) {

            foreach ($all_products as $k1 => $v1) {
                array_push($unmatch_pro, [
                    "id" => $v1['id'],
                    "product_name" => $v1['product_name'],
                    "sku_code" => $v1['sku_code'],
                    "batch_code" => $v1['batch_code'],
                    "category" => $v1['product_category'],
                    "varient" => $v1['product_varient'],
                    "unit_price" => $v1['min_sale_price'],
                ]);
            }
        } else {

            foreach ($all_products as $k => $v) {
                $obj = (object)[
                    "id" => $v['id'],
                    "product_name" => $v['product_name'],
                    "product_varient" => $v['product_varient'],
                    "unit_price" => $v['min_sale_price'],
                    "category" => $v['product_category'],
                    "sku_code" => $v['sku_code'],
                    'batch_code' => $v['batch_code']
                ];
                array_push($arr1Id, $obj);
            }

            foreach (json_decode($customer_pro) as $k => $v) {
                array_push($arr2Id, (object)[
                    "id" => $v->id,
                    "product_name" => $v->product_name,
                    "product_varient" => $v->product_varient,
                    "unit_price" => $v->specialPrice,
                    "sku_code" => $v->sku_code,
                    "category" => $v->category,
                    "batch_code" => $v->batch_code,
                ]);
            }

            
            foreach ($arr1Id as $k => $v) {
                foreach ($arr2Id as $key => $value) {
                    if ($v->product_name != $value->product_name || $v->product_varient != $value->product_varient) {
                        array_push($unmatch_pro, (object)[
                            "id" => $v->id,
                            "product_name" => $v->product_name,
                            "category" => $v->category,
                            "varient" => $v->product_varient,
                            "sku_code" => $v->sku_code,
                            "batch_code" => $v->batch_code,
                            "unit_price" => $v->unit_price
                        ]);
                    }
                }
            }

            // products which listed in special price list
            foreach (json_decode($customer_pro) as $k => $v) {
                array_push($unmatch_pro, (object)[
                    "id" => (int)$v->id,
                    "product_name" => $v->product_name,
                    "category" => $v->category,
                    "varient" => $v->product_varient,
                    "sku_code" => $v->sku_code,
                    "batch_code" => $v->batch_code,
                    "unit_price" => $v->specialPrice
                ]);
            }
        }

        return response()->json($unmatch_pro);
    }

    // sales quotation filter
    public function salesQuotationFilter()
    {
        return response()->json(DB::table('quotations')->where('customer_name', 'LIKE', '%' . $_GET['user'] . '%')->paginate(10));
    }



    // ***************************************************************************************************//
    //                                           Invoice SECTION                                          //
    //****************************************************************************************************//    

    //generate pdf
    public function generatePDF($id)
    {
        $data = SalesInvoice::where('id', $id)->get();
        $products = SalesInvoice::where('id', $id)->value('products');
        $pdf = PDF::loadView('superadmin.sales.invoice-modal.invoice-pdf', ['data' => $data, 'products' => $products]);

        return $pdf->download('invoice.pdf');
    }

    public function printSalesInvoicePDF($id)
    {
        $data = SalesInvoice::where('id', $id)->get();
        $products = SalesInvoice::where('id', $id)->value('products');
        $pdf = PDF::loadView('superadmin.sales.invoice-modal.invoice-pdf', ['data' => $data, 'products' => $products]);

        return $pdf->stream('invoice.pdf');
    }

    // quotaion sales
    public function generateQuotationPDF($id)
    {
        $data = Quotation::where('id', $id)->get();
        $products = Quotation::where('id', $id)->value('products_details');
        $pdf = PDF::loadView('superadmin.sales.invoice-modal.quotation-pdf', ['data' => $data, 'products' => $products]);

        return $pdf->download('invoice.pdf');
    }

    // Online sale invoice pdf download
    public function generateOnlineSaleInvoicePDF($consolidate_order_no){

        $user_order = UserOrder::where('consolidate_order_no',$consolidate_order_no)->first();
        $notification = Notification::where('consolidate_order_no',$consolidate_order_no)->first();
        $address =  address::find($notification->address_id);
        $user_order_item = UserOrderItem::where('consolidate_order_no',$consolidate_order_no)
        ->select('*',DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(final_price_with_coupon_offer) as total_price'))
        ->groupBy('product_id')->get();

        $total_order_price = UserOrder::where('consolidate_order_no',$consolidate_order_no)
        ->groupBy('consolidate_order_no')->sum('final_price');

        // if($total_order_price < 70){
        //     $sum = $total_order_price + 8;
        // }else{
        //     $sum = $total_order_price;
        // }

        $sum = $total_order_price;

        $tax_total = ((int)$sum*8)/100;

        $shipping_charge = UserOrder::where('consolidate_order_no', request()->id)->sum('ship_charge');

        $check_voucher_apply = UserOrder::where('consolidate_order_no',$consolidate_order_no)
        ->where('voucher_code','!=',null)->first();

        $remark = Notification::where('consolidate_order_no',$consolidate_order_no)->latest()->first();

        return view('superadmin.online-sale.modal.invoice-pdf', [
            'address'           => $address, 
            'tax_total'         => $tax_total,
            'data'              => $notification,
            'user_order_item'   => $user_order_item, 
            'user_order'        => $user_order, 
            'sum'               => $sum, 
            'shipping_charge'   => $shipping_charge,
            'check_voucher_apply' => $check_voucher_apply,
            'remark'                => $remark
        ]);



        $orders = UserOrderItem::where('consolidate_order_no', request()->id)->get();

        $details = UserOrder::where('consolidate_order_no', request()->id)->first();

        $payment_mode = Notification::where('consolidate_order_no', request()->id)->first();

        $address = DB::table('addresses')->where('id', $payment_mode->address_id)->first();
        
        $shipping_charge = UserOrder::where('consolidate_order_no', request()->id)->sum('ship_charge');

        $total_price = UserOrderItem::where('consolidate_order_no', request()->id)->sum('total_price');

        $discount_amount = UserOrderItem::where('consolidate_order_no', request()->id)->sum('discount_amount');

        $offer_discount_face_value1 = UserOrderItem::where('consolidate_order_no', request()->id)->get();

        $discount_amount_offer=0;

        foreach($offer_discount_face_value1 as $key=>$value){
            $discount_amount_offer += $value->offer_discount_face_value*$value->quantity;
        }

        $sum_1 = $total_price-$discount_amount-$discount_amount_offer;

        if($sum_1 < 70){
            $sum = $sum_1+8;
        }else{
            $sum = $sum_1;
        }

        $tax_total = ((int)$sum*8)/100;

        // dd($payment_mode);

        return view('superadmin.online-sale.modal.invoice-pdf', ['address'=>$address, 'tax_total'=>$tax_total,'payment_mode'=>$payment_mode,'data' => $orders, 'details' => $details, 'sum' => $sum, 'shipping_charge' => $shipping_charge]);
        // $pdf = PDF::loadView('superadmin.online-sale.modal.invoice-pdf', ['address'=>$address, 'tax_total'=>$tax_total,'payment_mode'=>$payment_mode,'data' => $orders, 'details' => $details, 'sum' => $sum, 'shipping_charge' => $shipping_charge]);
        // // dd($pdf);

        // return $pdf->stream('LFK_Invoice.pdf');
    }

    

    //
    public function index()
    {
        return view('superadmin.sales');
    }
    // fetch customer list
    public function getCustomer()
    {
        $list = User::all();
        return response()->json($list);
    }

    // fetch products details
    public function getProducts()
    {
        $products = product::all();
        return response()->json($products);
    }

    // fetch a single product
    public function getProduct()
    {
        $proId = $_GET["pro"];
        $data = product::all()->where("id", $proId);
        return response()->json($data);
    }

    // fetch a single product by matching name
    public function getProductInfo()
    {
        $proName = $_GET["pro"];
        $data = product::all()->where("product_name", $proName);
        return response()->json($data);
    }

    // store invoice
    public function storeInvoice(Request $request)
    {

        $allProductDetails = $_REQUEST['allProductDetails'];

        $validator = Validator::make($request->all(), [
            "customerName" => "required",
            "invoiceDate" => "required",
            "paymentReference" => "required",
        ]);
        
        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        $product_id = SalesInvoice::orderBy('id', 'DESC')->pluck('inv_no')->first();


        if ($product_id == null or $product_id == "") {
            $product_id = 'LFKINV'.$year.$month.'000001' ;
        } else {
            $number = (int)str_replace('LFKINV', '', $product_id);

            $product_id = "LFKINV" . sprintf("%04d", $number + 1);

        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else {

            $checkbox = ($request->taxInclude == 'on') ? true : false;

            if ($request->create_invoice_by == 'byQuotation') {
                $sale_order_id = SalesInvoice::orderBy('id', 'DESC')->pluck('id')->first();
                if ($sale_order_id == null or $sale_order_id == "") {
                    $sale_order_id = 1;
                } else {
                    $sale_order_id = $sale_order_id + 1;
                }
            } else {
                $sale_order_id = $request->refNextQColumn;
            }

            SalesInvoice::insert([
                "quotation_no" => $request->quotationNumber,
                "inv_no" => $product_id,
                "invoice_no" => $sale_order_id,
                "quot_no" => $request->unQutNo,
                "customer_id" => $request->customerName,
                "customer_name" => $request->invoiceCustomer_id,
                "invoice_date" => $request->invoiceDate,
                "payment_ref" => $request->paymentReference,
                "due_date" => $request->dueDate,
                "status" => $request->selectTerms,
                "note" => $request->notes,
                "tax" => $request->gstValue,
                "tax_inclusive" => $checkbox,
                "pending_amount" => $request->invoiceTotal1,
                "products" => $allProductDetails,
                "untaxed_amount" => $request->untaxtedAmountInvoice1,
                "GST" => $request->GST1,
                "total" => $request->invoiceTotal1,
                "created_at" => now()
            ]);
            Quotation::where('orderID', $request->quotationNumber)
                ->update([
                    "invoicestatus" => "Yes",
                    "display" => "none"
                ]);
            $output =   json_decode($allProductDetails, true);

            // return $output;

            foreach ($output as $value) {
                $inStock = Stock::all()->where('product_id', $value["product_Id"])->where('product_varient', $value["product_varient"])->where('batch_code', $value["batch_code"])->value('quantity');

                $minus = $inStock - $value['quantity'];

                Stock::where('product_id', $value["product_Id"])
                    ->where('product_varient', $value["product_varient"])
                    ->where('batch_code', $value["batch_code"])
                    ->update([
                        "quantity" => $minus,
                        "updated_at" => now(),
                    ]);
            }

            return response()->json(["success" => "Invoice Generated Successfully."]);
        }
    }

    // all invoice detials to view in payemet section
    public function getAllInvoice()
    {
        return response()->json(SalesInvoice::all());
    }

    // fetch unique customer for payment forms
    public function getAllInvoiceForPayment()
    {
        $data = DB::table('sales_invoices')->select('customer_id', 'customer_name')->distinct()->get();

        return response()->json($data);
    }

    // get all invoice detials
    public function getInvoice()
    {
        $data = DB::table('sales_invoices')->orderBy('id','DESC')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewInvoice" data-toggle="modal" data-target="#viewInvoice" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editInvoice" style="display:'. $item->display .'" data-toggle="modal" data-target="#editInvoice" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteInvoice" style="display:'. $item->display .'" data-toggle="modal" data-target="#removeModalSalesInvoice" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                (($item->quot_no != null)?$item->quot_no:"--"),
                (($item->inv_no != null)?$item->inv_no:"--"),
                $item->invoice_date,
                (($item->due_date != null)?$item->due_date:"--"),
                $item->customer_name,
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

    // fetch single invoice detials
    public function getSingleInvoice()
    {
        $id = $_GET['id'];
        $data = SalesInvoice::all()->where('id', $id);
        return response()->json($data);
    }

    // fetch all invoices detials for payments form
    public function getAllInvoicesforPayment()
    {
        $id = $_GET['id'];
        $data = SalesInvoice::all()->where('customer_id', $id)->where('pending_amount', '!=', 0);
        return response()->json($data);
    }

    // fetch all invoices detials for payments form
    public function getAllInvoicesforPayment1()
    {
        $id = $_GET['id'];
        $data = SalesInvoice::all()->where('pending_amount', '!=', 0)->where('customer_id', $id);
        return response()->json($data);
    }

    // Update Invoice
    public function updateInvoice(Request $request)
    {

        $allProductDetails = $_REQUEST['allProductDetails'];

        $validator = Validator::make($request->all(), [
            "customerName" => "required",
            "invoiceDate" => "required",
            "paymentReference" => "required",
            "allProductDetails" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            // }else if($request->quotationNumber == "" && $request->refNextQColumn == ""){
            //     return response()->json(['barerror'=>'Please enter reference number or YYMMXXXX(2040001) field. <br> fill any one of the field.']);
            // }else if($request->dueDate === null && $request->selectTerms === ""){
            //     return response()->json(['barerror'=>'Please inter <b><u>Due date</u></b> or select <b><u>select terms</u></b> field. <br> fill any one of the field.']);
            // }else if(sizeof(json_decode($allProductDetails)) === 0){
            // return response()->json(['barerror'=>'Please add products in product table.']);
        } else {

            $checkbox = ($request->taxInclude === 'on') ? true : false;

            SalesInvoice::where('id', $request->invoiceId)
                ->update([
                    // "quotation_no" => $request->quotationNumber,
                    // "invoice_no" => $request->refNextQColumn,
                    // "customer_id" => $request->invoiceCustomer_id,
                    // "customer_name" => $request->customerName,
                    "invoice_date" => $request->invoiceDate,
                    "payment_ref" => $request->paymentReference,
                    "due_date" => $request->dueDate,
                    "status" => $request->selectTerms,
                    "tax_inclusive" => $checkbox,
                    "tax" => $request->gstValue,
                    "note" => $request->notes,
                    "products" => $allProductDetails,
                    "untaxed_amount" => $request->untaxtedAmountEInvoice1,
                    "GST" => $request->GST1,
                    "total" => $request->invoiceETotal1,
                    "pending_amount" => $request->invoiceETotal1,
                    "updated_at" => now()
                ]);

            return response()->json(["success" => "Invoice Updated Successfully."]);
        }
    }

    // remove invoice
    public function removeInvoice()
    {
        $id = $_GET['id'];
        SalesInvoice::where('id', $id)->delete();
        return response()->json(["success" => "Invoice Removed Successfully."]);
    }

    // filter
    public function filterInvoice()
    {
        $status = $_GET['status'];
        // return response()->json(SalesInvoice::all()->where('status', $status));
        return response()->json(DB::table('sales_invoices')->where('status', 'LIKE', '%' . $status . '%')->paginate(10));
    }

    // filter invoice
    public function filterInvoiceName()
    {
        return response()->json(DB::table('sales_invoices')->where('customer_name', 'LIKE', '%' . $_GET['user'] . '%')->paginate(10));
    }


    // ***************************************************************************************************//
    //                                           Payment SECTION                                          //
    //****************************************************************************************************//    

    // fetch all invoice numbers
    public function getInvoiceDetails()
    {
        $id = $_GET["pro"];
        $data = SalesInvoice::all()->where('invoice_no', $id);
        return response()->json($data);
    }

    // fetch all invoice numbers for dropdown
    public function getInvoiceNoDetails()
    {
        $data = SalesInvoice::all();
        return response()->json($data);
    }

    // add payment detials
    public function addPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // "invoiceNo" => "required",
            // "paymentType" => "required",
            // "paymentDate" => "required",
            // "paymentStatus" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else if ($request->invoiceNo === "default") {
            return response()->json(['barerror' => 'Please select the valid invoice number from field.']);
        } else if ($request->paymentType === "default") {
            return response()->json(['barerror' => 'Please select the valid payment type from field.']);
        } else if ($request->paymentDate === null) {
            return response()->json(['barerror' => 'Please select the valid payment date from field.']);
        } else if ($request->paymentStatus === "default") {
            return response()->json(['barerror' => 'Please select the valid payment status from field.']);
        } else {

            $old_data = SalesInvoice::where('invoice_no', $request->invoiceNo)->first();
            $paid_amount = 0;
            if ($request->paymentStatus === 'paid') {
                $paid_amount = $request->amount;
            } else {
                $paid_amount = $request->partialamount + $old_data->paid_amount;
            }
            if ($request->paymentStatus === 'partial' && $old_data->total == $paid_amount) {
                $paymentStatusd = "paid";
            } else {
                $paymentStatusd = $request->paymentStatus;
            }

            $pending_amt = $request->amount - $paid_amount;
            Payment::insert([
                "invoice_no"    => $request->invoiceNo,
                "inv_no"    => $request->pInvNam,
                "customer_id"   => $request->customer_name,
                "customer_name" => $request->customer_id,
                "amount"        => $request->amount,
                "partialamount" => $request->partialamount,
                "paid_amount"   => $paid_amount,
                "payment_type"  => $request->paymentType,
                "payment_date"  => $request->paymentDate,
                "invoice_date"  => $request->invoicedaate,
                "payment_status" => $paymentStatusd,
                "pending_amt"   => $pending_amt,
                "created_at"    => now()
            ]);

            if ($request->paymentStatus === 'paid') {
                SalesInvoice::where('invoice_no', $request->invoiceNo)
                    ->update([
                        "payment_status" => "paid",
                        "display" => "none",
                        "partial_amount" => $request->partialamount,
                        "paid_amount"   => $paid_amount,
                        "pending_amount" => 0,
                        "updated_at" => now()
                    ]);
            } elseif ($request->paymentStatus === 'partial' && $old_data->total == $paid_amount) {
                SalesInvoice::where('invoice_no', $request->invoiceNo)
                    ->update([
                        "payment_status" => "paid",
                        "display" => "none",
                        "partial_amount" => $request->partialamount,
                        "paid_amount"   => $paid_amount,
                        "pending_amount" => 0,
                        "updated_at" => now()
                    ]);
            } else {
                SalesInvoice::where('invoice_no', $request->invoiceNo)
                    ->update([
                        "payment_status" => $request->paymentStatus,
                        "partial_amount" => $request->partialamount,
                        "pending_amount" => $pending_amt,
                        "paid_amount"   => $paid_amount,
                        "updated_at" => now()
                    ]);
            }


            // Payment::insert([
            //     "invoice_no" => $request->invoiceNo,
            //     "customer_id" => $request->customer_name,
            //     "customer_name" => $request->customer_id,
            //     "amount" => $request->amount,
            //     "partialamount" => $request->partialamount,
            //     "payment_type" => $request->paymentType,
            //     "payment_date" => $request->paymentDate,
            //     "invoice_date" => $request->invoicedaate,
            //     "payment_status" => $request->paymentStatus,
            //     "created_at" => now()
            // ]);

            // if($request->paymentStatus == 'paid'){
            //     SalesInvoice::where('id', $request->invoiceId)
            //     ->update([
            //         "payment_status" => "yes",
            //         "display" => "none",
            //         "updated_at" => now()
            //     ]);
            // }else{

            // }

            return response()->json(["success" => "Payment Added Successfully."]);
        }
    }

    // fetch all payments details list
    public function getPayments()
    {
        $data = DB::table('payments')->orderBy('id','DESC')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewPayment" data-toggle="modal" data-target="#viewPayment" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editPayment" data-toggle="modal" data-target="#editPayment" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deletePayment" data-toggle="modal" data-target="#removeModalSalesPayment" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->inv_no,
                $item->invoice_date,
                $item->customer_name,
                $item->payment_date,
                $item->amount,
                (( $item->partialamount != null)? $item->partialamount:"--"),
                (( $item->pending_amt != null)? $item->pending_amt:"--"),
                $item->payment_type,
                $item->payment_status,
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

    // fetch single payment detials
    public function getPaymentDetials()
    {
        $id = $_GET['id'];
        $data = Payment::all()->where('id', $id);
        return response()->json($data);
    }

    // edit payment details
    public function editPaymentDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "invoiceNo" => "required",
            "paymentType" => "required",
            "paymentDate" => "required",
            "paymentStatus" => "required"
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
        } else if ($request->invoiceNo === "default") {
            return response()->json(['barerror' => 'Please select the valid invoice number from field.']);
        } else if ($request->paymentType === "default") {
            return response()->json(['barerror' => 'Please select the valid payment type from field.']);
        } else if ($request->paymentDate === null) {
            return response()->json(['barerror' => 'Please select the valid payment date from field.']);
        } else if ($request->paymentStatus === "default") {
            return response()->json(['barerror' => 'Please select the valid payment status from field.']);
        } else {

            Payment::where("id", $request->id)
                ->update([
                    "amount" => $request->amount,
                    "partialamount" => $request->partialamount,
                    "payment_type" => $request->paymentType,
                    "payment_date" => $request->paymentDate,
                    "invoice_date" => $request->invoicedaate,
                    "payment_status" => $request->paymentStatus,
                    "created_at" => now()
                ]);

            if ($request->paymentStatus == 'paid') {
                SalesInvoice::where('id', $request->invoiceId)
                    ->update([
                        "payment_status" => "yes",
                        "display" => "none",
                        "updated_at" => now()
                    ]);
            }

            return response()->json(["success" => "Details Updated Successfully."]);
        }
    }

    // remove payment details
    public function removePaymentDetials()
    {
        $id = $_GET['id'];
        Payment::where('id', $id)->delete();
        return response()->json(["success" => "Payment Deleted Successfully."]);
    }

    // filter payment by status
    public function filterPaymentDetials()
    {
        $status = $_GET['status'];
        // $data = Payment::with('salesInvoice')->where('payment_status', $status)->get();
        return response()->json(DB::table('payments')->where('payment_status', 'LIKE', '%' . $status . '%')->paginate(10));
        // return response()->json($data);
    }

    // payment filter by customer name
    public function getPaymentsFilter()
    {
        return response()->json(DB::table('payments')->where('customer_name', 'LIKE', '%' . $_GET['user'] . '%')->paginate(10));
    }


    // ***************************************************************************************************//
    //                                           Customer SECTION                                         //
    //****************************************************************************************************//    

    //   Main Customer Tab
    public function customerManagement()
    {
        return view('superadmin.customer');
    }

    // Add Customer
    public function addCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "customerName" => "required",
            "address" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            // }else if($request->gst === "default"){
            //     return response()->json(['barerror'=>'Please select the valid gst from field.']);
        } else {

            Customer::create([
                "customer_type" => 'bussiness',
                "customer_id" => Auth::user()->id,
                "customer_name" => $request->customerName,
                "address" => $request->address,
                "email_id" => $request->emailId,
                "phone_number" => $request->phoneNo,
                "mobile_number" => $request->mobileNo,
                "created_at" => now()
            ]);


            // $user = User::create([
            //     'is_admin' => '0',
            //     'name' => $data['name'],
            //     'email' => $data['email'],
            //     'mobile_number' => $data['mobile_number'],
            //     'password' => Hash::make($data['password']),
            // ]);

            // return "hello";
            return response()->json(["success" => "Customer Added Successfully."]);
        }
    }

    // store retail customer
    public function addRetailCustomer(Request $request)
    {
        // try {
        // $data = $request->validate(
        //     [
        //         'customerName' => 'required',
        //         'mobileNo'  => 'required',
        //         'emailId'     => 'required|email|unique:users',
        //         'postcode'  => 'required',
        //         'address'  => 'required',
        //         'unit'  => 'required'                    
        //     ]
        // );

        $n = 4;

        $start = strlen($request->mobileNo) - $n;

        $password = substr($request->mobileNo, $start);

        $user = User::create([
            'is_admin' => '0',
            'name' => $request->customerName,
            'email' => $request->emailId,
            'mobile_number' => $request->phoneNo,
            'password' => Hash::make($password),
        ]);

        Customer::create([
            'customer_name' => $request->customerName,
            'address' => $request->address,
            'customer_type' => 'retail',
            'mobile_number' => $request->phoneNo,
            'email_id' => $request->emailId,
            'customer_id' => $user->id,
            'postal_code' => $request->postcode,
            'unit_number' => $request->unit,
        ]);

        address::create([
            'user_id' => $user->id,
            'name' => $request->customerName,
            'address' => $request->address,
            'postcode' => $request->postcode,
            'mobile_number' => $request->phoneNo,
            'unit' => $request->unit,
        ]);

        return response()->json(['success' => 'Details Registered Successfully']);
    }

    // fetch all customer details
    public function customersList()
    {
        $data = Customer::all()->where('customer_type', 'bussiness');
        return response()->json($data);
    }

    // fetch all customer details
    public function customersListPaginate()
    {
        $data=DB::table('customers')->where('customer_type', 'bussiness')->orderBy('id', 'DESC')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewCustomer" data-toggle="modal" data-target="#viewCustomerDetails" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editCustomer" data-toggle="modal" data-target="#editCustomerDetails" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteCustomer" data-toggle="modal" data-target="#removeModalCustomerManagement" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';

            $new_data[] = array(
                ++$i,
                $item->customer_name,
                $item->mobile_number,
                (($item->email_id != null) ? $item->email_id : "--"),
                $item->address,
                '<a name="addSpecialPrice" onclick="getSpecialPriceList('.$item->id.')" class="btn btn-primary btn-sm text-white" style="cursor:pointer;" data-toggle="modal" data-id="'.$item->id.'" data-target="#addSpecialPrice"> Add Price </a>',
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

    // fetch single customer details
    public function getCustomerDetails()
    {
        $id = $_GET['id'];
        $products = SalesInvoice::where('customer_id', $id)->select('products', 'invoice_no')->get();
        // return $products;
        // $data = SalesInvoice::join('customers', 'customers.id', '=', 'sales_invoices.customer_id')->where('customers.id', $id)->get(['customers.*', 'sales_invoices.*']);
        // return response()->json($data);
        $data = Customer::all()->where('id', $id)->first();
        $allData = [];

        array_push($allData, $products);
        array_push($allData, $data);
        return response()->json($allData);
    }

    public function getCustomerDetails1()
    {
        $id = $_GET['id'];
        // $data = SalesInvoice::join('customers', 'customers.id', '=', 'sales_invoices.customer_id')->where('customers.id', $id)->get(['customers.*', 'sales_invoices.*']);
        // return response()->json($data);
        return response()->json(Customer::all()->where('id', $id));
    }

    // fetch single customer salesInvoice details
    public function getCustomerSalesInvoiceDetails()
    {
        $id = $_GET['id'];
        return response()->json(SalesInvoice::all()->where('customer_id', $id));
    }

    // edit customer detials
    public function editCustomerDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "customerName" => "required",
            "address" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->getMessageBag()->toArray()]);
            // }else if($request->gst === "default"){
            //     return response()->json(['barerror'=>'Please select the valid gst from field.']);
        } else {

            $customer = Customer::find($request->id);

            User::where('id', $customer->customer_id)->update([
                "mobile_number" => $request->phoneNo,
                "phone_number" =>$request->phoneNo,
            ]);

            Customer::where('id', $request->id)
                ->update([
                    "customer_name" => $request->customerName,
                    "address" => $request->address,
                    "email_id" => $request->emailId,
                    "phone_number" => $request->phoneNo,
                    "mobile_number" => $request->phoneNo,
                    "updated_at" => now()
                ]);

            return response()->json(["success" => "Details Updated Successfully."]);
        }
    }

    // remove customer
    public function removeCustomer()
    {
        try {
            $id = $_GET['id'];
            Customer::where('id', $id)->delete();
            return response()->json(["success" => "Details Deleted Successfully."]);
        } catch (Exception $e) {
            return response()->json(['barerror' => "Database Query Error..."]);
        }
    }

    // update special price to customer tab
    public function updateCustomerDetails(Request $request)
    {

        $alladdSpecialPriceArray = $request->alladdSpecialPriceArray;

        Customer::where('id', $request->customer_id)
            ->update([
                "specialPrice" => $alladdSpecialPriceArray,
                "updated_at" => now()
            ]);


        // if(sizeof(json_decode($alladdSpecialPriceArray)) === 0){
        //     return response()->json(['barerror'=>'Please add products in product table.']);
        // }else{

        //     Customer::where('id', $request->customer_id)
        //         ->update([
        //             "specialPrice" => $request->alladdSpecialPriceArray,
        //             "updated_at" => now(),
        //         ]);

        return response()->json(["special_price_success" => "Special Price Updated Successfully."]);
        // }
    }

    public function customerFilter()
    {
        return response()->json(DB::table('customers')->where('customer_type', 'bussiness')->where('customer_name', 'LIKE', '%' . $_GET['user'] . '%')->paginate(10));
    }

    public function retailCustomerFilter()
    {
        return response()->json(DB::table('customers')->where('customer_type', 'retail')->where('customer_name', 'LIKE', '%' . $_GET['user'] . '%')->paginate(10));
    }
}
