<!-- Modal -->
<div class="modal fade" id="editRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Requisition</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editRequestForm">
        <div class="modal-body bg-white px-3">
            <!-- invoice body start here -->

              <!-- info & alert section -->
                <div class="alert alert-success alert-dismissible fade show" id="editRequestAlert" style="display:none" role="alert">
                  <strong></strong> <span id="editRequestAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="editRequestAlertDanger" style="display:none" role="alert">
                  <strong></strong> <span id="editRequestAlertDangerMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <!-- end -->     

              <input type="text" name="id" id="requestQuotationId" style="display: none;">

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="vendorName">Vendor<span style="color:red; font-size:medium">*</span></label>
                    <select name="vendorName" class="form-control" id="vendorNameEQ" onchange="getProductsEQ()" readonly >
                        <option value="">Select Vendor</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="receiptDate">Recept Date<span style="color:red; font-size:medium">*</span></label>
                    <input type="date" name="receiptDate" id="receiptDateEQ" class="form-control" value="<?= date('Y-m-d') ?>" placeholder="Receipt Date" />
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="vendorReference">Vendor Reference<span style="color:red; font-size:medium">*</span></label>
                    <input type="text" name="vendorReference" id="vendorReferenceEQ" class="form-control" placeholder="Vendor Reference" />
                </div>
                <div class="col-md-6">
                    <input type="checkbox" class="mt-4" name="askForConfirm" value="confirm" id="askForConfirmEQ"> <label for="askForConfirm" class="mt-4 text-primary">Ask for Confirmation</label>
                </div>
            </div>             

            <!-- row 3 -->
            <!-- <div class="form-group row">
                <div class="col">
                    <input type="checkbox" name="taxIncludeEQ" id="taxIncludeEQ"> <label for="taxIncludeEQ" class="text-primary">Tax inclusive</label>
                </div>
            </div> -->

            <div class="row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group form-control">
                                    <input type="checkbox" name="taxInclude" id="taxIncludeEQ">
                                    <label for="taxInclude" class="text-primary my-auto"> &nbsp; Tax Inclusive</label>
                            </div>
                        </div>                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue" value="7" id="gstValueEReq" min="1" placeholder="GST (In %)" />
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
            <div class="form-group row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Order Details<span style="color:red; font-size:medium">*</span></legend>
                            <span style="color:red; font-size:small;" id="editReqtableEmptyError"></span>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table border" id="products">
                                    <thead>
                                        <tr>
                                            <th class=" border border-secondary">Product</th>
                                            <th class=" border border-secondary">Variant</th>
                                            <th class=" border border-secondary">Category</th>
                                            <th class=" border border-secondary">SKU Code</th>
                                            <!-- <th class=" border border-secondary">Batch Code</th> -->
                                            <th class=" border border-secondary">Description</th>
                                            <th class=" border border-secondary">Quantity</th>
                                            <th class=" border border-secondary">Unit Price</th>
                                            <!-- <th class=" border border-secondary">Taxes</th> -->
                                            <th class=" border border-secondary">Gross Amount</th>
                                            <th class=" border border-secondary">Net Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="invoiceBody">
                                        <tr><form id="addProductForm0">
                                            <!-- product -->
                                            <td class=" border border-secondary">
                                                <select name="productName" id="productNameEQ" onchange="selectFunctionEditReq()" class="form-control form-control-lg">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </td>
                                             <!-- productId -->
                                            <!-- Hide Content -->
                                            <td class=" border border-secondary" style="display: none;">
                                                <input type="text"  id="productIdEQ" class="form-control" placeholder="Id">
                                                <input type="text"  id="productNameEQ1" class="form-control" placeholder="Id">
                                            </td>
                                            <!-- varient -->
                                            <td class=" border border-secondary">
                                                <!-- <input type="text" name="varient" id="varientEQ" class="form-control" placeholder="Varient"> -->
                                                <select name="varient" id="varientEQ" class="form-control" onchange="selectRequestEditFunction()">
                                                    <option value="">Select Variant</option>
                                                </select>
                                            </td>
                                            <!-- category -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="category" id="categoryEQ" class="form-control" placeholder="Category" readonly />
                                            </td>

                                            <!-- sku_Code -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="sku_Code" id="sku_CodeEQ" class="form-control" placeholder="SKU Code" readonly />
                                            </td>

                                            <!-- batch_Code -->
                                            <!-- <td class=" border border-secondary">
                                                <input type="text" name="batch_Code" id="batch_CodeEQ" class="form-control" placeholder="batch_Code">
                                            </td> -->

                                            <!-- Description -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="description" id="descriptionEQ" class="form-control" placeholder="Description">
                                            </td>
                                            <!-- Quantity -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="quantity" id="quantityEQ" class="form-control" placeholder="Quantity">
                                            </td>
                                            <!-- unit price -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="unitPrice" id="unitPriceEQ" class="form-control" placeholder="Unit Price" />
                                            </td>
                                            <!-- taxes -->
                                            <td class=" border border-secondary" style="display: none;">
                                                <input type="text" name="taxes" id="taxesEQ" class="form-control" placeholder="Taxes">
                                            </td>
                                            <!-- sub total -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="subTotal" id="subTotalEQ" class="form-control" placeholder="Gross Amount" readonly />
                                            </td>
                                            <!--  -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="netAmount" id="netAmountEReq" class="form-control" placeholder="Net Amount" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                <a name="addLine" id="addProductReqEQ" class="btn btn-primary text-white">Add Product</a>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productsTableEQ" style="width: 100%; border-collapse: collapse;">
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
                                    <tbody id="productTableBodyEQ"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="form-group row">
                <div class="col-md-6">
                    <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                    <input type="text" name="notes" id="notesEQ" class="form-control" placeholder="Add an Internal Note" />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Sub Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" name="untaxtedAmount1" id="untaxtedAmountEQ" class="form-control" placeholder="Sub Total" disabled>
                            <input type="text" name="untaxtedAmount" id="untaxtedAmountEQ1" class="form-control" placeholder="Sub Total" style="display: none;">
                        </div>
                    </div>
                    <div class="row mx-auto" my-1 >
                        <div class="col-md-5 my-auto">GST</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" name="gst1" id="gstEQ" class="form-control" placeholder="GST" disabled>
                            <input type="text" name="gst" id="gstEQ1" class="form-control" placeholder="GST" style="display: none;">                        
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Grand Total</div>
                        <div class="col-md-7 my-auto">
                            <input type="text" id="quotationTotalEQ" name="quotationTotal1" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                            <input type="text" id="quotationTotalEQ1" name="quotationTotal" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                        </div>                   
                    </div>
                </div>
            </div>


            <!-- end here -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editRequestPurchaseClearBtn">Clear</button>
            <button type="submit" id="editRequestForm1" class="btn btn-primary">Save</button>
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

    $('#editRequestPurchaseClearBtn').on('click', function(){
        $('#editRequestForm')["0"].reset();
        $('#productTableBodyEQ').html('');
    });

    $(document).on('keyup', "input[id='unitPriceEQ']", function(e){
        let newPrice = $(this).val();
        let quantity = $('#quantityEQ').val();
        
        let subtotal = parseFloat(quantity)*parseFloat(newPrice);
        $(this).closest('tr').find("input[id='subTotalEQ']").val(subtotal);

            $gstValue = $('#gstValueEReq').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxIncludeEQ').prop('checked')){
                $('#netAmountEReq').val(subtotal+$totalGST);
            }else{
                $('#netAmountEReq').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxesEQ']").val($totalGST);
    });

     // validation script start here
     $(document).ready(function() {
            // store data to database
            jQuery("#editRequestForm").submit(function (e) {
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
                        required: "Please select vendor name."
                    },
                    receiptDate: {
                        required: "Please select Receipt Date.",
                    },
                    vendorReference: {
                        required: "Please enter vendor reference.",
                    }
                },
                submitHandler:function(){
                    
                    
                    if($('#productTableBodyEQ').children().length === 0){
                        // $('#editReqtableEmptyError').html('Please add products details.');
                        errorMsg('Please add product details');
                    }else{
                        // $('#editReqtableEmptyError').html('');
                    
                        allProductDetailsEQ.splice(0, allProductDetailsEQ.length);
                        
                        $("#productTableBodyEQ > tr").each(function(e){
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
                            let netAmount = $(this).find('.netAmountEReq').text();

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
                                    "netAmount":netAmount
                            }
                            allProductDetailsEQ.push(dbData);
                        });

                        bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                            if(result){
                                jQuery.ajax({
                                    url: "{{ route('SA-UpdateSingleQuotation') }}",
                                    data: jQuery("#editRequestForm").serialize()+"&allProductDetails="+JSON.stringify(allProductDetailsEQ),
                                    enctype: "multipart/form-data",
                                    type: "post",
                                    success: function (result) {
                                        if(result.error !=null ){
                                            errorMsg(result.error);
                                        }
                                        else if(result.barerror != null){
                                            jQuery("#editRequestAlert").hide();
                                            errorMsg(result.barerror);
                                        }
                                        else if(result.success != null){
                                            successMsg(result.success);
                                            $('.modal .close').click();
                                            jQuery("#editRequestForm")["0"].reset();
                                            jQuery("#productsTableEQ tbody").html('');
                                            jQuery("#productTableBodyEQ").html('');
                                            allProductDetailsEQ.splice(0, allProductDetailsEQ.length);
                                            purchase_quotation_main_table.ajax.reload();
                                            getVendorNamesEQ();
                                            getVendorNamesVQ();
                                            
                                        }else {
                                            jQuery("#editRequestAlertDanger").hide();
                                            jQuery("#editRequestAlert").hide();
                                        }
                                    },
                                });
                            }
                        });
                    }
                }
            });
        });
        // end here

    $(document).on('keyup keydown change', "input[id='gstValueEReq']", function(e){

                    let tax = parseFloat($(this).val());
                    // console.log(tax);

                    let quantity = $('#quantityEQ').val();
                    // console.log(quantity);
                    let price = $('#unitPriceEQ').val();
                    // console.log(price);
                    let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;
                    // console.log(taxes);

                    $('#taxesEQ').val(taxes);

                    // +parseFloat(taxes)
                    let subtotal = parseFloat(quantity)*parseFloat(price);
                    // console.log(subtotal);
                    $('#subTotalEQ').val(subtotal);
                    // console.log('---------------------------------------------------');

                    if($('#taxIncludeEQ').prop('checked')){
                        // console.log(subtotal+taxes);
                        $('#netAmountEReq').val(subtotal+taxes);
                    }else{
                        // console.log(subtotal);
                        $('#netAmountEReq').val(subtotal);
                    }

                    $("#productTableBodyEQ > tr").each(function(e){
                        let unitPrice = $(this).find('.unit_price').text();
                        let quantity = $(this).find('.product_quantity').text();

                        let taxes = ((parseFloat(quantity)*parseFloat(unitPrice))*parseFloat(tax))/100;

                        // let taxes = $(this).find('.taxes').text();
                        $(this).find('.taxes').text(taxes);
                        let subTotal = $(this).find('.subtotal').text();
                        let netAmount = $(this).find('.netAmountEReq').text();

                        let amount = parseFloat(taxes)+parseFloat(subTotal);

                        if($('#taxIncludeEQ').prop('checked')){
                            $(this).find('.netAmountEReq').text(amount);
                        }else{
                            $(this).find('.netAmountEReq').text(subTotal);
                        }
                    });
        calculateEQ();

    });

    $(document).on('keyup', "input[id='quantityEQ']", function(e){

            let quantity = $(this).val();
            let price = $(this).closest('tr').find("input[id='unitPriceEQ']").val();
            let taxes = $(this).closest('tr').find("input[id='taxesEQ']").val();

            // +parseFloat(taxes)
            let subtotal = parseFloat(quantity)*parseFloat(price);
            $(this).closest('tr').find("input[id='subTotalEQ']").val(subtotal);

            // gst value 
            $gstValue = $('#gstValueEReq').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxIncludeEQ').prop('checked')){
                $('#netAmountEReq').val(subtotal+$totalGST);
            }else{
                $('#netAmountEReq').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxesEQ']").val($totalGST);
    });

        getVendorNamesEQ();

        // get customer list
        function getVendorNamesEQ(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAllVendor')}}",
                success : function (response){
                    $('#vendorNameEQ').html('');
                    $('#vendorNameEQ').append('<option value="">Select Vendor Name</option>');
                    jQuery.each(response, function(key, value){
                        $('#vendorNameEQ').append(
                            '<option value="'+value["vendor_name"]+'">\
                            '+value["vendor_name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }

        let proDetailsArr3 = [];
        
            function getProductsEQ(pro){
                // let id = this.event.target.id;
                // let pro = $('#vendorNameEQ').val();
                $.ajax({
                    type : "GET",
                    url : "{{ route('SA-GetAllProductsaw')}}",
                    data : {
                        'id' : pro,
                    },
                    success : function (response){

                        // console.log(response);

                        proDetailsArr3 = response;
                        
                        let productsName3 = [];

                        jQuery.each(proDetailsArr3, function(key, value){
                            productsName3.push(value['product_name']);
                        });

                        var uniqueArray = [];
            
                        for(i=0; i < productsName3.length; i++){
                            if(uniqueArray.indexOf(productsName3[i]) === -1) {
                                uniqueArray.push(productsName3[i]);
                            }
                        }

                        $('#productNameEQ').html('');
                        $('#productNameEQ').append('<option value="">Select Product</option>');
                        jQuery.each(uniqueArray, function(key, value){
                            $('#productNameEQ').append(
                                '<option value="'+value+'">\
                                '+value+'\
                                </option>'
                            );
                        });
                    }
                });

                $('#productTableBodyEQ').html('');  
            };
        
                        function selectFunctionEditReq(){
                            let id = this.event.target.id;
                            let pro = $('#'+id).val();

                            $('#categoryEQ').val('');
                            $('#sku_CodeEQ').val('');
                            $('#descriptionEQ').val('');
                            $('#quantityEQ').val('');
                            $('#unitPriceEQ').val('');
                            $('#taxesEQ').val('');
                            $('#subTotalEQ').val('');
                            $('#netAmountEReq').val('');

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetNameProducts')}}",
                                data : {
                                    "val": pro,
                                },
                                success : function (response){
                                        $('#varientEQ').html('');
                                        $('#varientEQ').append('<option value="">Choose Varients</option>');
                                        jQuery.each(response, function(key, value){

                                            if($('#productsTableEQ tbody > tr').length == 0){
                                                
                                                    $('#varientEQ').append(
                                                        '<option value="'+value["product_varient"]+'">\
                                                            '+value["product_varient"]+'\
                                                        </option>'
                                                    );

                                            }else{

                                                let count = 0;

                                                $("#productTableBodyEQ tr").each(function(){
                                                    let proName = $(this).find('.product_name').text();
                                                    let proVarient = $(this).find('.product_varient').text();

                                                    if(proName == value['product_name'] && proVarient == value['product_varient']){
                                                        ++count;
                                                    }
                                                });

                                                    if(count == 0){
                                                        $('#varientEQ').append(
                                                            '<option value="'+value["product_varient"]+'">\
                                                                '+value["product_varient"]+'\
                                                            </option>'
                                                        );
                                                    }
                                            }
                                        });
                                }
                            });   
                        };

                        function selectRequestEditFunction(){
                            let id = this.event.target.id;
                            let varient = $('#'+id).val();
                           let product = $('#productNameEQ').val();

                            $('#categoryEQ').val('');
                            $('#sku_CodeEQ').val('');
                            $('#descriptionEQ').val('');
                            $('#quantityEQ').val('');
                            $('#unitPriceEQ').val('');
                            $('#taxesEQ').val('');
                            $('#subTotalEQ').val('');
                            $('#netAmountEReq').val('');

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-FetchProductsAllDetialsInfo')}}",
                                success : function (response){

                                    jQuery.each(response, function(key, value){
                                        if(value['product_name'] === product && value['product_varient'] === varient){
                                            // product id
                                            $('#'+id).closest('tr').find("input[id='productIdEQ']").val(value["id"]);
                                            // sku code
                                            $('#'+id).closest('tr').find("input[id='sku_CodeEQ']").val(value["sku_code"]);
                                            // batch code
                                            // $('#'+id).closest('tr').find("input[id='batch_CodeReq']").val(value["batch_code"]);
                                            // category
                                            $('#'+id).closest('tr').find("input[id='categoryEQ']").val(value["product_category"]);
                                            // productNameReq
                                            $('#'+id).closest('tr').find("input[id='productNameEQ1']").val(value["product_name"]);
                                            // unit price
                                            $('#'+id).closest('tr').find("input[id='unitPriceEQ']").val(value["min_sale_price"]);
                                        }
                                    });
                                }
                            });
                        }

        let allProductDetailsEQ = [];

        // Table
        $('#addProductReqEQ').on('click', function() {
            let id = $('#productIdEQ').val();
            let productName = $('#productNameEQ1').val();
            let varient = $('#varientEQ').val();
            let category = $('#categoryEQ').val();

            let sku_code = $('#sku_CodeEQ').val();
            // let batch_code = $('#batch_CodeEQ').val();

            let description = $('#descriptionEQ').val();
            let quantity = $('#quantityEQ').val();
            let unitPrice = $('#unitPriceEQ').val();
            let taxes = $('#taxesEQ').val();
            let subTotal = $('#subTotalEQ').val();
            let netAmountEReq = $('#netAmountEReq').val();

            let slno = $('#productsTableEQ tr').length;
            if(productName!="" && varient !="" && category!="" && quantity!="" && unitPrice!="" && taxes!="" && subTotal!=""){
                $('#productsTableEQ tbody').append('<tr class="child">\
                                                <td>'+ slno +'</td>\
                                                <td class="product_Id" style="display:none;">'+id+'</td>\
                                                <td class="product_name">'+productName+'</td>\
                                                <td class="product_category">'+category+'</td>\
                                                <td class="product_varient">'+varient+'</td>\
                                                <td class="sku_code">'+sku_code+'</td>\
                                                <td class="product_desc">'+description+'</td>\
                                                <td class="product_quantity">'+quantity+'</td>\
                                                <td class="unit_price">'+unitPrice+'</td>\
                                                <td class="taxes" style="display:none;"  >'+taxes+'</td>\
                                                <td class="subtotal">'+subTotal+'</td>\
                                                <td class="netAmountEReq">'+netAmountEReq+'</td>\
                                                <td>\
                                                    <a href="javascript:void(0);" class="remCF1EQ">\
                                                        <i class="mdi mdi-delete"></i>\
                                                    </a>\
                                                </td>\
                                            </tr>'
                                        );
                calculateEQ();

                $('#productNameEQ').val('');
                $('#productIdEQ').val('');
                $('#productNameEQ1').val('');
                $('#varientEQ').val('');
                $('#categoryEQ').val('');
                $('#sku_CodeEQ').val('');
                $('#descriptionEQ').val('');
                $('#quantityEQ').val(0);
                $('#unitPriceEQ').val(0);
                $('#taxesEQ').val(0);
                $('#subTotalEQ').val(0);
                $('#netAmountEReq').val(0);
                selectFunctionEditReq();

            }
        });

        $('#taxIncludeEQ').change(function(){

                    let tax = parseFloat($('#gstValueEReq').val());
                    // console.log(tax);

                    let quantity = $('#quantityEQ').val();
                    // console.log(quantity);
                    let price = $('#unitPriceEQ').val();
                    // console.log(price);
                    let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;
                    // console.log(taxes);

                    $('#taxesEQ').val(taxes);

                    // +parseFloat(taxes)
                    let subtotal = parseFloat(quantity)*parseFloat(price);
                    // console.log(subtotal);
                    $('#subTotalEQ').val(subtotal);
                    // console.log('---------------------------------------------------');

                    if($('#taxIncludeEQ').prop('checked')){
                        // console.log(subtotal+taxes);
                        $('#netAmountEReq').val(subtotal+taxes);
                    }else{
                        // console.log(subtotal);
                        $('#netAmountEReq').val(subtotal);
                    }

                    $("#productTableBodyEQ > tr").each(function(e){
                        let unitPrice = $(this).find('.unit_price').text();
                        let quantity = $(this).find('.product_quantity').text();

                        let taxes = ((parseFloat(quantity)*parseFloat(unitPrice))*parseFloat(tax))/100;

                        // let taxes = $(this).find('.taxes').text();
                        $(this).find('.taxes').text(taxes);
                        let subTotal = $(this).find('.subtotal').text();
                        let netAmount = $(this).find('.netAmountEReq').text();

                        let amount = parseFloat(taxes)+parseFloat(subTotal);

                        if($('#taxIncludeEQ').prop('checked')){
                            $(this).find('.netAmountEReq').text(amount);
                        }else{
                            $(this).find('.netAmountEReq').text(subTotal);
                        }
                    });

                calculateEQ();

        });

        function calculateEQ(){
            let sum = 0;
            let tax = 0;
            let i = 0;

            $("#productTableBodyEQ tr .subtotal").each(function(){
                sum += parseFloat($(this).text());
            }); 

            $('#untaxtedAmountEQ').val(sum.toFixed(2));
            $('#untaxtedAmountEQ1').val(sum.toFixed(2));
            $('#quotationTotalEQ').val(sum.toFixed(2));
            $('#quotationTotalEQ1').val(sum.toFixed(2));

            $("#productTableBodyEQ tr .taxes").each(function(){
                tax += parseFloat($(this).text());
            });

            $('#gstEQ').val(tax.toFixed(2));
            $('#gstEQ1').val(tax.toFixed(2));

                // $('#taxIncludeEQ').change(function(){
                    if($('#taxIncludeEQ').prop('checked')){
                        let untaxtedAmountEQ = parseFloat($('#untaxtedAmountEQ').val());
                        let totalBill = untaxtedAmountEQ+tax;

                        $('#quotationTotalEQ').val(totalBill.toFixed(2));
                        $('#quotationTotalEQ1').val(totalBill.toFixed(2));
                    }else{
                        let untaxtedAmountEQ = parseFloat($('#untaxtedAmountEQ').val());
                        let totalBill = untaxtedAmountEQ;

                        $('#gstEQ').val('');

                        $('#quotationTotalEQ').val(totalBill.toFixed(2));
                        $('#quotationTotalEQ1').val(totalBill.toFixed(2));
                    }
                // });

        };
        
        $(document).on('click','.remCF1EQ',function(){
            $(this).parent().parent().remove();

            $('#productsTableEQ tbody tr').each(function(i){            
                $($(this).find('td')[0]).html(i+1);
            });
            calculateEQ();
            selectFunctionEditReq();
        });        

</script>