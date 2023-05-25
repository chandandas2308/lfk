<!-- Modal -->
<div class="modal fade" id="addRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Requisition</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="addRequestForm">
        <div class="modal-body bg-white px-3">
            <!-- invoice body start here -->

                <!-- info & alert section -->
                <div class="alert alert-success alert-dismissible fade show" id="addRequestAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="addRequestAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="addRequestAlertDanger" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="addRequestAlertDangerMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <!-- end -->     

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="vendorName">Vendor<span style="color:red; font-size:medium">*</span></label>
                    <select name="vendorId" onchange="getven()" class="form-control" id="vendorName">
                        <option value="">Select Vendor</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="receiptDate">Receipt Date<span style="color:red; font-size:medium">*</span></label>
                    <input type="date" name="receiptDate" id="receiptDate" value="<?= date('Y-m-d') ?>" class="form-control" placeholder="Receipt Date" />
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="vendorReference">Vendor Reference<span style="color:red; font-size:medium">*</span></label>
                    <input type="text" name="vendorReference" id="vendorReference" class="form-control" placeholder="Vendor Reference" />
                </div>
                <div class="col-md-6">
                    <input type="checkbox" class="mt-4" name="askForConfirm" value="confirm" id="askForConfirmOrder"> <label for="askForConfirmOrder" class="mt-4 text-primary">Ask for Confirmation</label>
                </div>
            </div>             

            <!-- row 3 -->
            <!-- <div class="form-group row">
                <div class="col">
                    <input type="checkbox" name="taxInclude" id="taxInclude"> <label for="taxInclude" class="text-primary">Tax inclusive</label>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group form-control">
                                    <input type="checkbox" name="taxInclude" id="taxInclude"> 
                                    <label for="taxInclude" class="text-primary my-auto">&nbsp; Tax Inclusive</label>
                            </div>
                        </div>                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue" value="7" id="gstValueReq" min="1" placeholder="GST (In %)" />
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-facebook" type="button">
                                            %
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- row 5 -->
            <div class="productTableAlert alert alert-warning" style="display: none;"></div>
            <div class="form-group row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Order Details<span style="color:red; font-size:medium">*</span></legend>
                        <span style="color:red; font-size:small;" id="createReqtableEmptyError"></span>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table border" id="products">
                                    <thead>
                                        <tr>
                                            <th class="border border-secondary">Product</th>
                                            <!-- <th class="border border-secondary">Id</th> -->
                                            <th class="border border-secondary">Variant</th>
                                            <th class="border border-secondary">Category</th>
                                            <th class="border border-secondary">SKU Code</th>
                                            <!-- <th class="border border-secondary">Batch Code</th> -->
                                            <th class="border border-secondary">Description</th>
                                            <th class="border border-secondary">Quantity</th>
                                            <th class="border border-secondary">Unit Price</th>
                                            <!-- <th class="border border-secondary">Taxes</th> -->
                                            <th class="border border-secondary">Gross Amount</th>
                                            <th class="border border-secondary">Net Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="invoiceBody">
                                        <tr><form id="addProductForm0">
                                            <!-- product -->
                                            <td class="border border-secondary">
                                                <select name="productName" id="productNameReq" onchange="selectFunctionReq()" class="form-control" width="350px">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </td>
                                            <!-- productId -->
                                            <!-- Hide Content -->
                                            <td class="border border-secondary" style="display: none;">
                                                <input type="text"  id="productIdReq" class="form-control" placeholder="Id">
                                                <input type="text"  id="productNameReq1" class="form-control" placeholder="Id">
                                            </td>
                                            <!-- varient -->
                                            <td class="border border-secondary">
                                                <!-- <input type="text" name="varient" id="varientReq" class="form-control" placeholder="Varient"> -->
                                                <select name="varient" id="varientReq" class="form-control" onchange="selectRequestFunction()" >
                                                    <option value="">Select Variant</option>
                                                </select>
                                            </td>
                                            <!-- category -->
                                            <td class="border border-secondary">
                                                <input type="text" name="category" id="categoryReq" class="form-control" placeholder="Category" readonly />
                                            </td>
                                            <!-- sku code -->
                                            <td class="border border-secondary">
                                                <input type="text" name="sku_Code" id="sku_CodeReq" class="form-control" placeholder="SKU Code" readonly />
                                            </td>
                                            <!-- batch code -->
                                            <!-- <td class="border border-secondary">
                                                <input type="text" name="batch_Code" id="batch_CodeReq" class="form-control" placeholder="Batch Code">
                                            </td> -->
                                            <!-- Description -->
                                            <td class="border border-secondary">
                                                <input type="text" name="description" id="descriptionReq" class="form-control" placeholder="Description">
                                            </td>
                                            <!-- Quantity -->
                                            <td class="border border-secondary">
                                                <input type="text" name="quantity" value="0" id="quantityReq" class="form-control" placeholder="Quantity">
                                            </td>
                                            <!-- unit price -->
                                            <td class="border border-secondary">
                                                <input type="text" name="unitPrice" value="0" id="unitPriceReq" class="form-control" placeholder="Unit Price" />
                                            </td>
                                            <!-- taxes -->
                                            <td class="border border-secondary" style="display: none;">
                                                <input type="text" name="taxes" value="0" id="taxesReq" class="form-control" placeholder="Taxes">
                                            </td>
                                            <!-- sub total -->
                                            <td class="border border-secondary">
                                                <input type="text" name="subTotal" value="0" id="subTotalReq" class="form-control" placeholder="Gross Amount" readonly />
                                            </td>
                                            <!-- sub total -->
                                            <td class="border border-secondary">
                                                <input type="text" name="netAmount"  value="0" id="netAmountReq" class="form-control" placeholder="Net Amount" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                <a name="addLine" id="addProductReq" class="btn btn-primary text-white">Add Product</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productsTableReq" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>       
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Variant</th>
                                            <th>SKU Code</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Gross Amount</th>
                                            <th>Net Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBodyReq"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="form-group row">
                <div class="col-md-6">
                    <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                    <input type="text" name="notes" id="notes" class="form-control" placeholder="Add an Internal Note" />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Sub Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" name="untaxtedAmount1" id="untaxtedAmount" class="form-control" placeholder="Sub Total" disabled>
                            <input type="text" name="untaxtedAmount" id="untaxtedAmount1" class="form-control" placeholder="Sub Total" style="display: none;">
                        </div>
                    </div>
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">GST</div>
                        <div class="col-md-7 my-auto">
                            <input type="tesxt" name="gst1" id="gst" class="form-control" placeholder="GST" disabled>
                            <input type="text" name="gst" id="gst1" class="form-control" placeholder="GST" style="display: none;" />                        
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Grand Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" id="quotationTotal" name="quotationTotal1" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                            <input type="text" id="quotationTotal1" name="quotationTotal" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                        </div>                   
                    </div>
                </div>
            </div>


            <!-- end here -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="addRequestPurchaseformClearBtn" >Clear</button>
            <button type="submit" id="addRequestForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery CDN -->
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>

<script>

        $('#addAssetClearBtn').on('click', function(){
            $("#addAssetForm")["0"].reset();
        });

        // validation script start here
        $(document).ready(function() {
            // store data to database
            jQuery("#addRequestForm").submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                });
            }).validate({
                rules: {
                    vendorName : {
                        required: true,
                    },
                    receiptDate: {
                        required: true,
                    },
                    vendorReference: {
                        required: true,
                    },
                },
                messages : {
                        vendorName: {
                            required: "Please Select Vendor Name."
                        },
                        receiptDate: {
                            required: "Please select Receipt Date.",
                        },
                        vendorReference: {
                            required: "Please Enter Vendor Reference.",
                        }
                },
                submitHandler:function(){

                    if($('#productTableBodyReq').children().length === 0){
                        // $('#createReqtableEmptyError').html('Please add products details.');
                        errorMsg('Please add products details.')
                    }else{
                        // $('#createReqtableEmptyError').html('');
                    

                        allProductDetailsReq.splice(0, allProductDetailsReq.length);
                        
                        $("#productTableBodyReq > tr").each(function(e){
                            let productId = $(this).find('.product_Id').text();
                            let productName = $(this).find('.product_name').text();
                            let varient = $(this).find('.product_varient').text();
                            let category = $(this).find('.product_category').text();
                            let sku_code = $(this).find('.sku_code').text();
                            let batch_code = $(this).find('.batch_code').text();
                            let description = $(this).find('.product_desc').text();
                            let quantity = $(this).find('.product_quantity').text();
                            let unitPrice = $(this).find('.unit_price').text();
                            let taxes = $(this).find('.taxes').text();
                            let subTotal = $(this).find('.subtotal').text();
                            let netAmountReq = $(this).find('.netAmountReq').text();

                            let dbData = {
                                    "product_Id" : productId,
                                    "product_name":productName,
                                    "product_varient":varient,
                                    "category":category,
                                    "sku_code":sku_code,
                                    "batch_code":batch_code,
                                    "description":description,
                                    "taxes":taxes,
                                    "quantity":quantity,
                                    "unitPrice":unitPrice,
                                    "taxes":taxes,
                                    "subTotal":subTotal,
                                    "netAmount":netAmountReq
                            }
                            allProductDetailsReq.push(dbData);
                        });

                        bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                            if(result){
                                jQuery.ajax({
                                    url: "{{ route('SA-AddRequest') }}",
                                    data: jQuery("#addRequestForm").serialize()+"&allProductDetails="+JSON.stringify(allProductDetailsReq),
                                    enctype: "multipart/form-data",
                                    type: "post",
                                    success: function (result) {
                                        if(result.error !=null ){
                                            errorMsg(result.error);                                            
                                        }
                                        else if(result.barerror != null){
                                            errorMsg(result.barerror);
                                            jQuery("#addRequestAlert").hide();
                                        }
                                        else if(result.success != null){
                                            successMsg(result.success);
                                            $('.modal .close').click();
                                            jQuery("#addRequestAlertDanger").hide();
                                            jQuery("#addRequestForm")["0"].reset();
                                            jQuery("#productsTableReq tbody").html('');
                                            jQuery("#productTableBodyReq").html('');
                                            allProductDetailsReq.splice(0, allProductDetailsReq.length);
                                            purchase_quotation_main_table.ajax.reload();
                                            getVendorNamesEQ();
                                            getVendorNamesVQ();
                                            getPurchaseQuotationNum();                            
                                        } else {                            
                                            jQuery("#addRequestAlertDanger").hide();
                                            jQuery("#addRequestAlert").hide();
                                        }
                                    },
                                });
                            }
                        });
                    }
                },
            });
        });
        // end here

    $('#addRequestPurchaseformClearBtn').on('click', function(){
        $('#addRequestForm')["0"].reset();
        $('#productTableBodyReq').html('');
    });

    $(document).on('keyup, change', "input[id='unitPriceReq']", function(e){
        let newPrice = $(this).val();
        let quantity = $('#quantityReq').val();
        
        let subtotal = parseFloat(quantity)*parseFloat(newPrice);
        $(this).closest('tr').find("input[id='subTotalReq']").val(subtotal);

            $gstValue = $('#gstValueReq').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxInclude').prop('checked')){
                $('#netAmountReq').val(subtotal+$totalGST);
            }else{
                $('#netAmountReq').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxesReq']").val($totalGST);
    });

    $(document).on('keyup, change', "input[id='quantityReq']", function(e){

            let quantity = $(this).val();
            let price = $(this).closest('tr').find("input[id='unitPriceReq']").val();
            let taxes = $(this).closest('tr').find("input[id='taxesReq']").val();

            // +parseFloat(taxes)
            let subtotal = parseFloat(quantity)*parseFloat(price);
            $(this).closest('tr').find("input[id='subTotalReq']").val(subtotal);

             // gst value 
            $gstValue = $('#gstValueReq').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxInclude').prop('checked')){
                $('#netAmountReq').val(subtotal+$totalGST);
            }else{
                $('#netAmountReq').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxesReq']").val($totalGST);
    });

    

        getVendorNames();

        // get customer list
        function getVendorNames(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAllVendor')}}",
                success : function (response){
                    $('#vendorName').html('');
                    $('#vendorName').append('<option value="">Select Vendor Name</option>');
                    jQuery.each(response, function(key, value){
                        $('#vendorName').append(
                            '<option value="'+value["id"]+'">\
                            '+value["vendor_name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }

        let proDetailsArr = [];
        
            function getven(){
                let id = this.event.target.id;
                let pro = $('#'+id).val();
                $.ajax({
                    type : "GET",
                    url : "{{ route('SA-GetAllProductsaw')}}",
                    data : {
                        'id' : pro,
                    },
                    success : function (response){

                        proDetailsArr = response;
                        
                        let productsName = [];

                        jQuery.each(proDetailsArr, function(key, value){
                            productsName.push(value['product_name']);
                        });

                        var uniqueArray = [];
            
                        for(i=0; i < productsName.length; i++){
                            if(uniqueArray.indexOf(productsName[i]) === -1) {
                                uniqueArray.push(productsName[i]);
                            }
                        }

                        $('#productNameReq').html('');
                        $('#productNameReq').append('<option value="">Select Product</option>');
                        jQuery.each(uniqueArray, function(key, value){
                            $('#productNameReq').append(
                                '<option value="'+value+'">\
                                '+value+'\
                                </option>'
                            );
                        });
                    }
                });

                $('#productTableBodyReq').html('');
                
            };
        
                        
                        function selectFunctionReq(){
                            // let id = this.event.target.id;
                            let pro = $('#productNameReq').val();

                            $('#categoryReq').val('');
                            $('#sku_CodeReq').val('');
                            $('#descriptionReq').val('');
                            $('#quantityReq').val(0);
                            $('#unitPriceReq').val(0);
                            $('#taxesReq').val(0);
                            $('#subTotalReq').val(0);
                            $('#netAmountReq').val(0);

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetNameProducts')}}",
                                data : {
                                    "val": pro,
                                },
                                success : function (response){
                                        $('#varientReq').html('');
                                        $('#varientReq').append('<option value="">Select Variants</option>');
                                        jQuery.each(response, function(key, value){

                                            if($('#productsTableReq tbody > tr').length == 0){
                                                
                                                    $('#varientReq').append(
                                                        '<option value="'+value["product_varient"]+'">\
                                                            '+value["product_varient"]+'\
                                                        </option>'
                                                    );

                                            }else{

                                                let count = 0;

                                                $("#productTableBodyReq tr").each(function(){
                                                    let proName = $(this).find('.product_name').text();
                                                    let proVarient = $(this).find('.product_varient').text();

                                                    if(proName == value['product_name'] && proVarient == value['product_varient']){
                                                        ++count;
                                                    }
                                                });

                                                    if(count == 0){
                                                        $('#varientReq').append(
                                                            '<option value="'+value["product_varient"]+'">\
                                                                '+value["product_varient"]+'\
                                                            </option>'
                                                        );
                                                    }
                                            }
                                        });
                                }
                                // success : function (response){
                                //     $('#varientReq').html('');
                                //     $('#varientReq').append('<option value="">Choose Varients</option>');
                                //     jQuery.each(response, function(key, value){
                                //             $('#varientReq').append(
                                //                 '<option value="'+value["product_varient"]+'">\
                                //                     '+value["product_varient"]+'\
                                //                 </option>'
                                //             );
                                //     });
                                // }
                            });   
                        };

            // get single product details
            // function getProduct(pro, id){
            //     $.ajax({
            //         type : "GET",
            //         url : "",
            //         data : {
            //             "pro" : pro
            //         },
            //         success : function (response){
            //             jQuery.each(response, function(key, value){
            //                 // product id
            //                 $('#'+id).closest('tr').find("input[id='productIdReq']").val(value["id"]);
            //                 // productNameReq
            //                 $('#'+id).closest('tr').find("input[id='productNameReq1']").val(value["product_name"]);
            //                 // category
            //                 $('#'+id).closest('tr').find("input[id='categoryReq']").val(value["product_category"]);
            //                 // varient
            //                 $('#'+id).closest('tr').find("input[id='varientReq']").val(value["product_varient"]);
            //                 // sku code
            //                 $('#'+id).closest('tr').find("input[id='sku_CodeReq']").val(value["sku_code"]);
            //                 // batch code
            //                 $('#'+id).closest('tr').find("input[id='batch_CodeReq']").val(value["batch_code"]);
            //                 // unit price
            //                 $('#'+id).closest('tr').find("input[id='unitPriceReq']").val(value["min_sale_price"]);
            //                 // taxes
            //                 // $('#'+id).closest('tr').find("input[id='taxesReq']").val(value["tax"]);
            //             });
            //         }
            //     });
            // }


                        function selectRequestFunction(){
                            let id = this.event.target.id;
                            let varient = $('#'+id).val();
                           let product = $('#productNameReq').val();
                            // let customerId = $('#customerName').val();

                            $('#categoryReq').val('');
                            $('#sku_CodeReq').val('');
                            $('#descriptionReq').val('');
                            $('#quantityReq').val(0);
                            $('#unitPriceReq').val(0);
                            $('#taxesReq').val(0);
                            $('#subTotalReq').val(0);
                            $('#netAmountReq').val(0);

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-FetchProductsAllDetialsInfo')}}",
                                success : function (response){

                                    // console.log(response);

                                    jQuery.each(response, function(key, value){
                                        if(value['product_name'] === product && value['product_varient'] === varient){
                                            // product id
                                            $('#'+id).closest('tr').find("input[id='productIdReq']").val(value["id"]);
                                            // sku code
                                            $('#'+id).closest('tr').find("input[id='sku_CodeReq']").val(value["sku_code"]);
                                            // batch code
                                            // $('#'+id).closest('tr').find("input[id='batch_CodeReq']").val(value["batch_code"]);
                                            // category
                                            $('#'+id).closest('tr').find("input[id='categoryReq']").val(value["product_category"]);
                                            // productNameReq
                                            $('#'+id).closest('tr').find("input[id='productNameReq1']").val(value["product_name"]);
                                            // unit price
                                            $('#'+id).closest('tr').find("input[id='unitPriceReq']").val(value["min_sale_price"]);
                                        }
                                    });
                                }
                            });
                        }

        let allProductDetailsReq = [];

        // Table
        $('#addProductReq').on('click', function() {
            let id = $('#productIdReq').val();
            let productName = $('#productNameReq1').val();
            let varient = $('#varientReq').val();
            let category = $('#categoryReq').val();
            let sku_code = $('#sku_CodeReq').val();
            // let batch_code = $('#batch_CodeReq').val();
            let description = $('#descriptionReq').val();
            let quantity = $('#quantityReq').val();
            let unitPrice = $('#unitPriceReq').val();
            let taxes = $('#taxesReq').val();
            let subTotal = $('#subTotalReq').val();
            let netAmountReq = $('#netAmountReq').val();

            let slno = $('#productsTableReq tr').length;
            if(productName!="" && varient !="" && category!="" && quantity!="" && unitPrice!="" && taxes!="" && subTotal!=""){

                                        $('#productsTableReq tbody').append('<tr class="child">\
                                                <td>'+ slno +'</td>\
                                                <td class="product_Id" style="display:none;">'+id+'</td>\
                                                <td class="product_name">'+productName+'</td>\
                                                <td class="product_category">'+category+'</td>\
                                                <td class="product_varient">'+varient+'</td>\
                                                <td class="sku_code">'+sku_code+'</td>\
                                                <td class="product_desc">'+description+'</td>\
                                                <td class="product_quantity">'+quantity+'</td>\
                                                <td class="unit_price">'+unitPrice+'</td>\
                                                <td class="taxes"  style="display:none;" >'+taxes+'</td>\
                                                <td class="subtotal">'+subTotal+'</td>\
                                                <td class="netAmountReq">'+netAmountReq+'</td>\
                                                <td>\
                                                    <a href="javascript:void(0);" class="remCF1AddReq">\
                                                        <i class="mdi mdi-delete"></i>\
                                                    </a>\
                                                </td>\
                                            </tr>'
                                        );
                calculateReq();
                $('.productTableAlert').hide();

                // $('#productNameReq').val('');
                $('#productNameReq').val('');
                $('#productIdReq').val('');
                $('#productNameReq1').val('');
                $('#varientReq').val('');
                $('#categoryReq').val('');
                $('#sku_CodeReq').val('');
                $('#descriptionReq').val('');
                $('#quantityReq').val(0);
                $('#unitPriceReq').val(0);
                $('#taxesReq').val(0);
                $('#subTotalReq').val(0);
                $('#netAmountReq').val(0);
                selectFunctionReq();
            }else{
                // $('.productTableAlert').show();
                // $('.productTableAlert').text('Please complete all fields.');
                errorMsg('Please complete all fields.');
            }
        });

                $(document).on('keyup keydown change', "input[id='gstValueReq']", function(e){
                    let tax = parseFloat($(this).val());
                    // console.log(tax);

                    let quantity = $('#quantityReq').val();
                    // console.log(quantity);
                    let price = $('#unitPriceReq').val();
                    // console.log(price);
                    let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;
                    // console.log(taxes);

                    $('#taxesReq').val(taxes);

                    // +parseFloat(taxes)
                    let subtotal = parseFloat(quantity)*parseFloat(price);
                    // console.log(subtotal);
                    $('#subTotalReq').val(subtotal);
                    // console.log('---------------------------------------------------');

                    if($('#taxInclude').prop('checked')){
                        // console.log(subtotal+taxes);
                        $('#netAmountReq').val(subtotal+taxes);
                    }else{
                        // console.log(subtotal);
                        $('#netAmountReq').val(subtotal);
                    }

                    $("#productTableBodyReq > tr").each(function(e){
                        let unitPrice = $(this).find('.unit_price').text();
                        let quantity = $(this).find('.product_quantity').text();

                        let taxes = ((parseFloat(quantity)*parseFloat(unitPrice))*parseFloat(tax))/100;

                        // let taxes = $(this).find('.taxes').text();
                        $(this).find('.taxes').text(taxes);
                        let subTotal = $(this).find('.subtotal').text();
                        let netAmount = $(this).find('.netAmountReq').text();

                        let amount = parseFloat(taxes)+parseFloat(subTotal);

                        if($('#taxInclude').prop('checked')){
                            $(this).find('.netAmountReq').text(amount);
                        }else{
                            $(this).find('.netAmountReq').text(subTotal);
                        }
                    });
                    calculateReq();
                });

        $('#taxInclude').change(function(){
                // $('#productNameReq').val('');
                // $('#productIdReq').val('');
                // $('#productNameReq1').val('');
                // $('#varientReq').val('');
                // $('#categoryReq').val('');
                // $('#sku_CodeReq').val('');
                // $('#descriptionReq').val('');
                // $('#quantityReq').val('');
                // $('#unitPriceReq').val('');
                // $('#taxesReq').val('');
                // $('#subTotalReq').val('');
                // $('#netAmountReq').val('');

                let tax = parseFloat($('#gstValueReq').val());
                    // console.log(tax);

                    let quantity = $('#quantityReq').val();
                    // console.log(quantity);
                    let price = $('#unitPriceReq').val();
                    // console.log(price);
                    let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;
                    // console.log(taxes);

                    $('#taxesReq').val(taxes);

                    // +parseFloat(taxes)
                    let subtotal = parseFloat(quantity)*parseFloat(price);
                    // console.log(subtotal);
                    $('#subTotalReq').val(subtotal);
                    // console.log('---------------------------------------------------');

                    if($('#taxInclude').prop('checked')){
                        // console.log(subtotal+taxes);
                        $('#netAmountReq').val(subtotal+taxes);
                    }else{
                        // console.log(subtotal);
                        $('#netAmountReq').val(subtotal);
                    }

                $("#productTableBodyReq > tr").each(function(e){
                    let unitPrice = $(this).find('.unit_price').text();
                    let taxes = $(this).find('.taxes').text();
                    let subTotal = $(this).find('.subtotal').text();
                    let netAmountReq = $(this).find('.netAmountReq').text();

                    let amount = parseFloat(taxes)+parseFloat(subTotal);

                    if($('#taxInclude').prop('checked')){
                        $(this).find('.netAmountReq').text(amount);
                    }else{
                        $(this).find('.netAmountReq').text(subTotal);
                    }
                });

                calculateReq();

        });

        function calculateReq(){
            let sum = 0;
            let tax = 0;
            let i = 0;

            $("#productTableBodyReq tr .subtotal").each(function(){
                sum += parseFloat($(this).text());
            });

            $('#untaxtedAmount').val(sum.toFixed(2));
            $('#untaxtedAmount1').val(sum.toFixed(2));
            $('#quotationTotal').val(sum.toFixed(2));
            $('#quotationTotal1').val(sum.toFixed(2));

            $("#productTableBodyReq tr .taxes").each(function(){
                tax += parseFloat($(this).text());
            });

            // $('#gst').val(tax);
            // $('#gst1').val(tax);

                // $('#taxInclude').change(function(){
                    if($('#taxInclude').prop('checked')){
                        let untaxtedAmount = parseFloat($('#untaxtedAmount').val());
                        let totalBill = untaxtedAmount+tax;

                        $('#gst').val(tax.toFixed(2));
                        $('#gst1').val(tax.toFixed(2));
                        
                        $('#quotationTotal').val(totalBill.toFixed(2)); 
                        $('#quotationTotal1').val(totalBill.toFixed(2));
                    }else{
                        let untaxtedAmount = parseFloat($('#untaxtedAmount').val());
                        let totalBill = untaxtedAmount;

                        $('#gst').val('');

                        $('#quotationTotal').val(totalBill.toFixed(2));
                        $('#quotationTotal1').val(totalBill.toFixed(2));
                    }
                // });
        };
        
        $(document).on('click','.remCF1AddReq',function(){
            $(this).parent().parent().remove();

            $('#productsTableReq tbody tr').each(function(i){            
                $($(this).find('td')[0]).html(i+1);
            });
            calculateReq();
        });

</script>