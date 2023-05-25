<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vendors;
use App\Models\PurchaseQuotation;
use App\Models\PurchaseOrder;
use App\Models\product;
use App\Models\Stock;
use Exception;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;

class purchaseController extends Controller
{


    // fetch unique vendors for return & exchange forms
    public function getAllInvoiceForReturnExchange()
    {
        $data = DB::table('purchase_orders')->select('vendor_id', 'vendor_name')->distinct()->get();

        return response()->json($data);
    }

    // all vendors unique invoice numbers
    public function fetchAllInvoicesNoforPayment()
    {
        $id = $_GET['id'];
        $data = PurchaseOrder::all()->where('vendor_id', $id);
        return response()->json($data);
    }

    // fetch all invoice numbers
    public function fetchAllProductsDetails(){
        $id = $_GET["pro"];
        $data = PurchaseOrder::all()->where('id', $id);
        return response()->json($data);
    }

    //
    public function index(){
        return view('superadmin.purchase');
    }

    //generate pdf
    public function purchaseInvoiceGeneratePDF($id)
    {
        $data = PurchaseOrder::where('id', $id)->get();
        $products = PurchaseOrder::where('id', $id)->value('products');
        $pdf = PDF::loadView('superadmin.purchase.purchase-order-modal.purchase-pdf', ['data'=>$data, 'products'=>$products]);
            
        return $pdf->download('invoice.pdf');
    }

    // quotaion sales
    public function purchaseQGeneratePDF($id)
    {
        $data = PurchaseQuotation::where('id', $id)->get();
        $products = PurchaseQuotation::where('id', $id)->value('products');
        $pdf = PDF::loadView('superadmin.purchase.purchase-order-modal.quotation-pdf', ['data'=>$data, 'products'=>$products]);
            
        return $pdf->download('purchase_quotation.pdf');
    }

    
    // ***************************************************************************************************//
   //                                           Vendor Tab Function                                      //
  //****************************************************************************************************//

    //===============================================================================================
    //                                            Add Vendor
    //===============================================================================================    
    public function addVendor(Request $request){
        
        $validator = Validator::make($request->all(),[
            "vendorName" => "required",
            "contactPersonName" => "required",
            // "address" => "required",
            // "mobileNo" => "required|regex:/^([0-9\s\-\+\(\)]*)$/|min:7|max:15",
            // "phoneNo" => "required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10",
            // "emailId" => "required",
            // "gst" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{

            try
            {
                Vendors::insert([
                    "vendor_name" => $request->vendorName,
                    "contact_person_name" => $request->contactPersonName,
                    "address" => $request->address,
                    "email" => $request->emailId,
                    "phone_no" => $request->phoneNo,
                    
                    "mobile_no" => $request->mobileNo,
                    // "GST" => $request->gst,
                    "created_at" => now()
                ]);

                return response()->json(['success'=>'Vendor Details Added Successfully']);
            }
            catch(Exception $e)
            {
                return response()->json(['barerror'=>"Database Query Error."]);
            }
        }
    }


    //===============================================================================================
    //                                          fetch Vendors Details
    //===============================================================================================    
    public function getVendors(){
        $data =  DB::table('vendors')->orderBy('id','desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewVendor" data-toggle="modal" data-target="#viewVendor" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editVendor" data-toggle="modal" data-target="#editVendor" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteVendor" data-toggle="modal" data-target="#removeModalPurchaseVendor" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->vendor_name,
                $item->contact_person_name,
                (($item->phone_no != null)?$item->phone_no:"--"),
                $item->mobile_no,
                (($item->email != null)?$item->email:"--"),
                (($item->address != null)?$item->address:"--"),
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

    // all vendors detials for form
    public function getAllVendors(){
        return response()->json(Vendors::all());
    }

    // filter
    public function filterPurchaseVendor()
    {
        return response()->json(DB::table('vendors')->where('vendor_name', 'LIKE', '%'.$_GET['user'].'%')->paginate(10));
    } 

    //===============================================================================================
    //                                       fetch single vendor details
    //===============================================================================================        
    
    public function getVendor(){
         $id = $_GET['id'];
         return response()->json(Vendors::all()->where('id', $id));
    }


    //===============================================================================================
    //                                              Udpate vendor
    //===============================================================================================
    public function updateVendor(Request $request){
        $validator = Validator::make($request->all(),[
            "vendorName" => "required",
            "contactPersonName" => "required",
            // "address" => "required",
           // "mobileNo" => "required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10",
            // "phoneNo" => "required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10",
            // "emailId" => "required",
            // "gst" => "required",
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else{

            try
            {
                Vendors::where('id', $request->id)
                ->update([
                    "vendor_name" => $request->vendorName,
                    "contact_person_name" => $request->contactPersonName,
                    "address" => $request->address,
                    "email" => $request->emailId,
                    "phone_no" => $request->phoneNo,
                    "mobile_no" => $request->mobileNo,
                    // "GST" => $request->gst,
                    "updated_at" => now()
                ]);

                return response()->json(['success'=>'Vendor Details Updated Successfully']);
            }
            catch(Exception $e)
            {
                return response()->json(['barerror'=>"Database Query Error."]);
            }
        }
    }


    //===============================================================================================
    //                                          remove vendor details
    //===============================================================================================    
    public function removeVendor(){
        try{
            $id = $_GET['id'];
            Vendors::where('id', $id)->delete();
            return response()->json(['success'=>'Vendor Details Removed Successfully']);
        }
        catch(Exception $e)
        {
            return response()->json(['barerror'=>"Database Query Error..."]);
        }            
    }



    // ***************************************************************************************************//
   //                             Purchase Requisition Tab Function                                      //
  //****************************************************************************************************//    


    //===============================================================================================
    //                                    get gst treatment
    //===============================================================================================   
    public function getGSTTreatment(){
        $vendor = $_GET['name'];
        return response()->json(Vendors::all()->where('vendor_name', $vendor));
    }

    //===============================================================================================
    //                                  add quotation request
    //===============================================================================================       
    public function addRequest(Request $request){
        $products = $request->allProductDetails;
        $validator = Validator::make($request->all(),[
            // "vendorName" => "required",
            // "receiptDate" => "required",
            // "vendorReference" => "required",
            // "untaxtedAmount" => "required",
            // // "gst" => "required",
            // "quotationTotal" => "required"
        ]);

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        $product_id = PurchaseQuotation::orderBy('id', 'DESC')->pluck('purchase_requisition')->first();


        if ($product_id == null or $product_id == "") {
            $product_id = 'LFKPR'.$year.$month.'000001' ;
        } else {
            $number = (int)str_replace('LFKPR', '', $product_id);

            $product_id = "LFKPR" . sprintf("%04d", $number + 1);

        }

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else if(sizeof(json_decode($products)) === 0){
            return response()->json(['barerror'=>'Please Add Products in Product Table.']);
        }else{
            try
            {

                $checkbox = ($request->taxInclude === 'on')?true:false;

                $vendorId = $request->vendorId;

                $vendorName = Vendors::where('id',$vendorId)->value('vendor_name');

                PurchaseQuotation::insert([
                    "vendor_id" => $request->vendorId,
                    "vendor_name" => $vendorName,
                    "purchase_requisition" => $product_id,
                    "receipt_date" => $request->receiptDate,
                    "vendor_reference" => $request->vendorReference,
                    "confirmation" => $request->askForConfirm,
                    "products" => $products,
                    "note" => $request->notes,
                    "tax_inclusive" => $checkbox,
                    "untaxted_amount" => $request->untaxtedAmount,
                    "gstpercentage" => $request->gstValue,
                    "GST" => $request->gst,
                    "total" => $request->quotationTotal,
                    "created_at" => now()
                ]);

                return response()->json(['success'=>'Quotation Added Successfully']);
            }
            catch(Exception $e)
            {
                return response()->json(['barerror'=>$e->getMessage()]);
            }
        }
    }

    //===============================================================================================
    //                          get all request quotations detials
    //===============================================================================================     
    public function requestQuotations(){
        // return response()->json(DB::table('purchase_quotations')->paginate(10));
        $data = DB::table('purchase_quotations')->orderBy('id','desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewRequest" data-toggle="modal" data-target="#viewRequest" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editRequest" data-toggle="modal" data-target="#editRequest" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="deleteRequest" data-toggle="modal" data-target="#removeModalPurchaseReq" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                $item->purchase_requisition,
                $item->vendor_name,
                number_format($item->total,2),
                (($item->confirmation!=null)?$item->confirmation:"--"),
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

    // all quotation ids
    public function requestAllQuotations()
    {
        return response()->json(PurchaseQuotation::all()->where('order_status',null));
    }

    // filter
    public function requestAllQuotationsFilter()
    {
        return response()->json(DB::table('purchase_quotations')->where('vendor_name', 'LIKE', '%'.$_GET['user'].'%')->paginate(10));
    }

    // fetch all products detials
    public function fetchProductsAllInfo()
    {
        return response()->json(product::all());
    }


    //===============================================================================================
    //                              get single quotation
    //===============================================================================================     
    public function getRequestQuotation(){
        $id = $_GET['id'];
        return response()->json(PurchaseQuotation::all()->where('id', $id));
    }

    //===============================================================================================
    //                          update quotation detials
    //===============================================================================================         
    public function updateRequestQuotation(Request $request){
        $products = $request->allProductDetails;
        $validator = Validator::make($request->all(),[
            "vendorName" => "required",
            "receiptDate" => "required",
            "vendorReference" => "required",
            "untaxtedAmount" => "required",
            // "gst" => "required",
            "quotationTotal" => "required"
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        }else if(sizeof(json_decode($products)) === 0){
            return response()->json(['barerror'=>'Please Add Products in Product Table.']);
        }else{

            try
            {

                $checkbox = ($request->taxInclude === 'on')?true:false;

                PurchaseQuotation::where('id', $request->id)
                ->update([
                    "vendor_name" => $request->vendorName,
                    "receipt_date" => $request->receiptDate,
                    "vendor_reference" => $request->vendorReference,
                    "confirmation" => $request->askForConfirm,
                    "products" => $products,
                    "tax_inclusive" => $checkbox,
                    "note" => $request->notes,
                    "gstpercentage" => $request->gstValue,
                    "untaxted_amount" => $request->untaxtedAmount,
                    "GST" => $request->gst,
                    "total" => $request->quotationTotal,
                    "updated_at" => now()
                ]);

                return response()->json(['success'=>'Quotation Updated Successfully']);
            }
            catch(Exception $e)
            {
                return response()->json(['barerror'=>$e->getMessage()]);
            }
        }
    }

    //===============================================================================================
    //                                     remove quotation
    //===============================================================================================             
    public function removeRequestQuotation(){
        $id = $_GET['id'];
        try{
            PurchaseQuotation::where('id', $id)->delete();
            return response()->json(['success'=>'Quotation Deleted Successfully']);
        }
        catch(Exception $e)
        {
            return response()->json(['barerror'=>"Database Error."]);
        }
    }


          // ***************************************************************************************************//
         //                             Purchase Requisition Tab Function                                      //
        //****************************************************************************************************//    

    //===============================================================================================
    // Add New Purchase Order
    //===============================================================================================  
    public function addPurchaseOrder(Request $request){

        $products = $request->allProductDetails;

        $validator = Validator::make($request->all(),[
        ]);

        $now = new \DateTime('now');
        $month = $now->format('m');
        $year = $now->format('Y');

        $product_id = PurchaseOrder::orderBy('id', 'DESC')->pluck('qut_no')->first();


        if ($product_id == null or $product_id == "") {
            $product_id = 'LFKPO'.$year.$month.'000001' ;
        } else {
            $number = (int)str_replace('LFKPO', '', $product_id);

            $product_id = "LFKPO" . sprintf("%04d", $number + 1);

        }

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        // }else if($request->quotationNumber == "" && $request->refOrderNum == ""){
        //     return response()->json(['barerror'=>'Please select quotation number or inter INV/2022/00001 (Anyone field required).']);
        // }else if(sizeof(json_decode($products)) === 0){
        //     return response()->json(['barerror'=>'Please add products in product table.']);
        }else{
            try
            {   
                $checkbox = ($request->taxInclude === 'on')?true:false;

                if($request->create_purchase_order_by == 'byQuotation'){
                    $pur_order_id = PurchaseOrder::orderBy('id', 'DESC')->pluck('id')->first();
                    if($pur_order_id == null or $pur_order_id == ""){
                        $pur_order_id = 1;
                    }
                    else{
                        $pur_order_id = $pur_order_id + 1;
                    }
                }else{
                    $pur_order_id = $request->purchaseOrderNo;
                }

                $vendorId = $request->vendorIdOrder;
                $vendorName = Vendors::where('id', $vendorId)->value('vendor_name');

                PurchaseOrder::insert([
                    "quotation_no"=> $request->quotationNumber,
                    "order_no"=> $pur_order_id,
                    "ord_no"=> $product_id,
                    "qut_no"=> $request->PurQut,
                    "vendor_id"=> $request->vendorIdOrder,
                    "vendor_name"=> $vendorName,
                    "receipt_date"=> $request->receiptDate,
                    "vendor_reference"=> $request->vendorReference,
                    "billing_status"=> $request->billingStatus,
                    "confirmation"=> $request->askForConfirm,
                    "products"=> $products,
                    "notes"=> $request->notes,
                    "tax" => $request->gstValue,
                    "tax_inclusive" => $checkbox,
                    "untaxted_amount"=> $request->untaxtedAmount,
                    "GST"=> $request->gst,
                    "total"=> $request->quotationTotal,
                    "created_at" => now(),
                ]);

                $output =   json_decode($products, true);
        
                // foreach($output as $value){
                //     $inStock = Stock::where('product_id', $value['product_Id'])->value('quantity');
                //     $sum = $inStock + $value['quantity'];

                //     Stock::where('product_id', $value['product_Id'])
                //             ->update([
                //                 "quantity" => $sum,
                //                 "updated_at" => now(),
                //             ]);
                // }

                PurchaseQuotation::where('id', $request->quotationNumber)
                ->update([
                    "order_status" => "Yes",
                    "display" => "none"
                ]);

                return response()->json(['success'=>'Purchase Order Details Added Successfully']);
            }
            catch(Exception $e)
            {
                return response()->json(['barerror'=>$e->getMessage()]);
            }
        }
    }

    //===============================================================================================
    //                              get quotation detials
    //===============================================================================================     
    public function getOrdersDetails(){
        $data = DB::table('purchase_orders')->orderBy('id', 'desc')->get();
        $i = 0;
        $action = '';
        $new_data = [];

        foreach($data as $item){
            $action .= '<div class="dropdown">';
            $action .= '<a class="" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            $action .= '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>';
            $action .= '</a>';
            $action .= '<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">';
            $action .= '<a name="viewOrder" data-toggle="modal" data-target="#viewOrder" class="dropdown-item" href="#" data-id="'.$item->id.'">View</a>';
            $action .= '<a name="editOrder" data-toggle="modal" data-target="#editOrder" class="dropdown-item" href="#" data-id="'.$item->id.'">Edit</a>';
            $action .= '<a name="delOrder" data-toggle="modal" data-target="#removeModalPurchaseOrder" class="dropdown-item" href="#" data-id="'.$item->id.'">Delete</a>';
            $action .= '</div>';
            $action .= '</div>';
            
            $new_data[] = array(
                ++$i,
                (($item->ord_no != null)?$item->ord_no:'--'),
                (($item->qut_no != null)?$item->qut_no:'--'),
                $item->vendor_name,
                $item->receipt_date,
                number_format($item->total,2),
                $item->billing_status,
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


    //===============================================================================================
    //                              get single order detials
    //===============================================================================================     
    public function getOrderDetails(){
        $id = $_GET['id'];
        return response()->json(PurchaseOrder::all()->where('id', $id));
    }

    //===============================================================================================
    //                                  Update
    //===============================================================================================     
    public function updateOrderDetails(Request $request){
        $products = $request->allProductDetails;
        $validator = Validator::make($request->all(),[
            // "vendorName" => "required",
            // "receiptDate" => "required",
            // "vendorReference" => "required",
            // "billingStatus"  => "required",
            // "untaxtedAmount" => "required",
            // "gst" => "required",
            // "quotationTotal" => "required"
        ]);

        if($validator->fails()){
            return response()->json(['error'=>$validator->getMessageBag()->toArray()]);
        // }else if($request->quotationNumber == "" && $request->refOrderNum == ""){
        //     return response()->json(['barerror'=>'Please select quotation number or inter INV/2022/00001 (Anyone field required).']);
        // }else if(sizeof(json_decode($products)) === 0){
        //     return response()->json(['barerror'=>'Please add products in product table.']);
        }else{
            try
            {

                $checkbox = ($request->taxInclude === 'on')?true:false;

                PurchaseOrder::where('id', $request->id)
                ->update([
                    // "quotation_no"=> $request->purchaseRequisitionNo,
                    // "refOrderNum"=> $request->purchase_order,
                    // "vendor_name"=> $request->vendorName,
                    "receipt_date"=> $request->receiptDate,
                    "vendor_reference"=> $request->vendorReference,
                    "billing_status"=> $request->billingStatus,
                    "confirmation"=> $request->askForConfirm,
                    "tax_inclusive" => $checkbox,
                    "tax" => $request->gstValue,
                    "products"=> $products,
                    "notes"=> $request->notes,
                    "untaxted_amount"=> $request->untaxtedAmount,
                    "GST"=> $request->gst,
                    "total"=> $request->quotationTotal,
                    "updated_at" => now()
                ]);

                return response()->json(['success'=>'Purchase Order Details Updated Successfully']);
            }
            catch(Exception $e)
            {
                return response()->json(['barerror'=>"Database Query Error."]);
            }
        }
    }

    //===============================================================================================
    //                                  remove order detials
    //===============================================================================================     
    public function removeOrderDetails(){
        $id = $_GET['id'];
        try{
            PurchaseOrder::where('id', $id)->delete();
            return response()->json(['success'=>'Purchase Order Details Removed Successfully']);
        }
        catch(Exception $e)
        {
            return response()->json(['barerror'=>"Database Query Error..."]);
        }
    }

    // filter purchase order by vendor name
    public function purchaseOrderFilter()
    {
        return response()->json(DB::table('purchase_orders')->where('vendor_name', 'LIKE', '%'.$_GET['user'].'%')->paginate(10));
    }
}
