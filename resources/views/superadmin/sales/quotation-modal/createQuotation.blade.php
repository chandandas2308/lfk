<!-- Modal -->
<div class="modal fade" id="createQuotation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create Quotation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="createQuotationForm">
        <div class="modal-body bg-white px-3">           

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customerName">Customer Name <span style="color: red; font-size:small;">*</span></label>
                    <select name="customerName" class="form-control" onchange="fetchCustomerName()" id="customerName">
                    </select>
                    <input type="text" name="qCustomer_id" id="qCustomer_name" style="display: none;" />
                </div>
                <div class="col-md-6">
                    <label for="expiration">Date of Expiry<span style="color: red; font-size:small;">*</span></label>
                    <input type="date" name="expiration" id="expiration" class="form-control" placeholder="Date of Expiry">
                </div>
            </div>

            <!-- row 2 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customerAddress">Customer Address</label>
                    <textarea name="customerAddress" class="form-control" id="customerAddress" rows="4" placeholder="Address"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="paymentTerms">Payment Terms<span style="color: red; font-size:small;">*</span></label>
                    <select name="paymentTerms" class="form-control" id="paymentTerms">
                        <option value="">Select Payment Terms</option>
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="30 days">30 days</option>
                    </select>
                </div>
            </div>

            <!-- row 3 -->
            <div class="row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label for="taxInclude" class="text-primary form-control"><input type="checkbox" name="taxInclude" id="taxInclude"> Tax Inclusive</label>
                            </div>
                        </div>                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue" value="7" id="gstValue" min="1" placeholder="GST (In %)" />
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
            <h6 class="salesQuantityError alert alert-warning" style="display: none;"></h6>
            <div class="row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Order Details<span style="color: red; font-size:smaller;">*</span></legend>
                            <span style="color:red; font-size:small;" id="tableEmptyError"></span>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table border" id="products">
                                    <thead>
                                        <tr>
                                            <th class=" border border-secondary">Product</th>
                                            <!-- <th class=" border border-secondary">Id</th> -->
                                            <th class=" border border-secondary">Variant</th>
                                            <th class=" border border-secondary">Category</th>
                                            <th class=" border border-secondary">SKU Code</th>
                                            <th class=" border border-secondary">Batch Code</th>
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
                                                <select name="productName" id="productName" onchange="selectFunction()" class="form-control form-control-lg">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </td>
                                            <!-- productId -->
                                            <!-- hide content -->
                                            <td class=" border border-secondary" style="display:none;">
                                                <input type="text"  id="productIdQuotation" class="form-control" placeholder="Id">
                                                <input type="text"  id="productNameQuotation1" class="form-control" placeholder="Id">
                                            </td>
                                            <!-- varient -->
                                            <td class=" border border-secondary">
                                                <!-- <input type="text" name="varient" id="varient" class="form-control" placeholder="Varient" disabled /> -->
                                                <select name="varient" id="varient" class="form-control" onchange="selectVarientFunction()" >
                                                    <option value="">Select Variant</option>
                                                </select>
                                            </td>
                                            <!-- category -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="category" id="category" class="form-control" placeholder="Category" disabled />
                                            </td>
                                            <!-- sku code -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="sku_code" id="sku_code" class="form-control" placeholder="SKU Code" disabled />
                                            </td>
                                            <!-- batch code -->
                                            <td class=" border border-secondary">
                                                <!-- <input type="text" name="batch_code" id="batch_code" class="form-control" placeholder="Batch Code" disabled /> -->
                                                <select name="batch_code" id="batch_code" class="form-control">
                                                    <option value="">Select Batch Code</option>
                                                </select>
                                            </td>
                                            <!-- Description -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="description" id="description" class="form-control" placeholder="Description">
                                            </td>
                                            <!-- Quantity -->
                                            <td class=" border border-secondary">
                                                <input type="number" name="quantity" id="quantity" value="0" class="form-control" placeholder="Quantity">
                                            </td>
                                            <!-- unit price -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="unitPrice" value="0" id="unitPrice" class="form-control" placeholder="Unit Price" disabled />
                                            </td>
                                            <!-- taxes -->
                                            <td class=" border border-secondary" style="display:none;">
                                                <input type="text" name="taxes" id="taxes" value="0" class="form-control" placeholder="Taxes" />
                                            </td>
                                            <!-- gross amount -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="subTotal" value="0" id="subTotal" class="form-control" placeholder="Gross Amount" disabled />
                                            </td>
                                            <!-- net amount -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="netAmount" value="0" id="netAmount" class="form-control" placeholder="Net Amount" disabled />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="">
                                                <a name="addLine" id="addProduct" class="btn btn-primary text-white">Add Product</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productsTable" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>      
                                            <th>Product Name</th>
                                            <th>Category</th>
                                            <th>Variant</th>
                                            <th>SKU Code</th>
                                            <th>Batch Code</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Gross Amount</th>
                                            <th>Net Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBody"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="mt-2 row">
                <div class="col-md-6 mb-2">
                    <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                    <input type="text" name="notes" id="notes" class="form-control" placeholder="Add an Internal Note" />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Sub Total</div>
                        <div class="col-md-7">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" name="untaxtedAmount1" id="untaxtedAmount" class="form-control" placeholder="Sub Total" disabled>
                                        <input type="text" name="untaxtedAmount" id="untaxtedAmount1" class="form-control" placeholder="Sub Total" style="display: none;">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto ">GST</div>
                        <div class="col-md-7">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" name="gst1" id="gst" class="form-control" placeholder="GST" disabled>
                                        <input type="text" name="gst" id="gst1" class="form-control" placeholder="GST" style="display: none;">                        
                                    </div>
                                </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto ">Grand Total</div>        
                        <div class="col-md-7">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" id="quotationTotal" name="quotationTotal1" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                                        <input type="text" id="quotationTotal1" name="quotationTotal" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                                    </div>
                                </div>
                        </div>                   
                    </div>
                </div>
            </div>


            <!-- end here -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="createQuotationFromClearBtn" >Clear</button>
            <button type="submit" id="createQuotationForm1" class="btn btn-primary">Save</button>
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

    // clear form
    jQuery('#createQuotationFromClearBtn').on('click', function (){
        jQuery("#createQuotationForm")["0"].reset();
    });

  // validation script start here
  $(document).ready(function() {

    // store data to database
    jQuery("#createQuotationForm").submit(function (e) {
        e.preventDefault();    

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $.validator.addMethod("validate", function(value) {
            return /[A-Za-z]/.test(value);
        });

    }).validate({
      rules: {

        customerName : {
          required: true,
        },

        expiration : {
          required: true,
        },

        customerAddress : {
          required: true,
          minlength: 1,
        },

        paymentTerms : {
          required: true,
        },

        gstValue : {
        //   required: true,
          min: 1,
        },
      },
      messages : {
        customerName: {
          required: "Please enter customer name.",
          minlength: "Please enter valid customer name.",
          validate: "Please enter customer name."
        },
        expiration: {
            required: "Date of Expiry date required.",
        },
        customerAddress: {
          required: "Customer address required.",
          minlength: "Please enter valid customer address.",
        },
        paymentTerms: {
          required: "Please choose payment terms.",
        },
        gstValue: {
          required: "GST value required.",
          min: "GST value at least have 1%.",
        },
      },
      submitHandler:function(){

            if($('#productTableBody').children().length === 0){
                errorMsg('Please add products details');
            }else{
                $('#tableEmptyError').html('');
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        
                        allProductDetails.splice(0, allProductDetails.length);
                        
                        $("#productTableBody > tr").each(function(e){
                            let product_Id = $(this).find('.product_id').text();
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
                            let netAmount = $(this).find('.netAmount').text();

                            let dbData = {
                                    "product_Id":product_Id,
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
                            allProductDetails.push(dbData);
                        });

                                
                        jQuery.ajax({
                            url: "{{ route('SA-AddQuotation') }}",
                            data: jQuery("#createQuotationForm").serialize()+"&allProductDetails="+JSON.stringify(allProductDetails),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function (result) {
                                if(result.error !=null ){
                                    jQuery(".salesQuantityError").hide();
                                    errorMsg(result.error);
                                }
                                else if(result.barerror != null){
                                    jQuery("#addQuotationAlert").hide();
                                    errorMsg(result.barerror);
                                    jQuery(".salesQuantityError").hide();
                                }
                                else if(result.success != null){
                                    jQuery("#addQuotationAlertDanger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#createQuotationForm")["0"].reset();
                                    jQuery("#productsTable tbody").html('');
                                    jQuery("#productTableBody").html('');
                                    allProductDetailsEditSection.splice(0, allProductDetailsEditSection.length);
                                    sales_quotation_main_table.ajax.reload();
                                    sales_order_main_table.ajax.reload();
                                    jQuery(".salesQuantityError").hide();
                                    jQuery("#salesInvoiceForm")["0"].reset();
                                    jQuery("#productTableInvoiceBody").html('');
                                    getQuotationNum();
                                }else if(result.salesQuantityError != null){
                                    errorMsg(result.salesQuantityError);
                                    jQuery("#productsTable tbody").html('');
                                    jQuery("#productTableBody").html('');
                                } else {
                                    jQuery(".salesQuantityError").hide();
                                    jQuery("#addQuotationAlertDanger").hide();
                                    jQuery("#addQuotationAlert").hide();
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


var filterdProductArray;

    $(document).on('change keyup', "input[id='quantity']", function(e){

            let quantity = $(this).val();
            let price = $(this).closest('tr').find("input[id='unitPrice']").val();
            let taxes = $(this).closest('tr').find("input[id='taxes']").val();

            // +parseFloat(taxes)
            let subtotal = parseFloat(quantity)*parseFloat(price);
            $(this).closest('tr').find("input[name='subTotal']").val(subtotal);


            // gst value 
            $gstValue = $('#gstValue').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxInclude').prop('checked')){
                $('#netAmount').val(subtotal+$totalGST);
            }else{
                $('#netAmount').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxes']").val($totalGST);
    });

                $(document).on('keyup keydown change', "input[id='gstValue']", function(e){
                    let tax = parseFloat($(this).val());
                    // console.log(tax);

                    let quantity = $('#quantity').val();
                    // console.log(quantity);
                    let price = $('#unitPrice').val();
                    // console.log(price);
                    let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;
                    // console.log(taxes);

                    $('#taxes').val(taxes);

                    // +parseFloat(taxes)
                    let subtotal = parseFloat(quantity)*parseFloat(price);
                    // console.log(subtotal);
                    $('#subTotal').val(subtotal);
                    // console.log('---------------------------------------------------');

                    if($('#taxInclude').prop('checked')){
                        // console.log(subtotal+taxes);
                        $('#netAmount').val(subtotal+taxes);
                    }else{
                        // console.log(subtotal);
                        $('#netAmount').val(subtotal);
                    }

                    $("#productTableBody > tr").each(function(e){
                        let unitPrice = $(this).find('.unit_price').text();
                        let quantity = $(this).find('.product_quantity').text();

                        let taxes = ((parseFloat(quantity)*parseFloat(unitPrice))*parseFloat(tax))/100;

                        // let taxes = $(this).find('.taxes').text();
                        $(this).find('.taxes').text(taxes);
                        let subTotal = $(this).find('.subtotal').text();
                        let netAmount = $(this).find('.netAmount').text();

                        let amount = parseFloat(taxes)+parseFloat(subTotal);

                        if($('#taxInclude').prop('checked')){
                            $(this).find('.netAmount').text(amount);
                        }else{
                            $(this).find('.netAmount').text(subTotal);
                        }
                    });
                    calculate();
                });

                $('#taxInclude').change(function(){

                    let tax = parseFloat($('#gstValue').val());
                    // console.log(tax);

                    let quantity = $('#quantity').val();
                    // console.log(quantity);
                    let price = $('#unitPrice').val();
                    // console.log(price);
                    let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;
                    // console.log(taxes);

                    // +parseFloat(taxes)
                    let subtotal = parseFloat(quantity)*parseFloat(price);
                    // console.log(subtotal);
                    $('#subTotal').val(subtotal);
                    // console.log('---------------------------------------------------');

                    if($('#taxInclude').prop('checked')){
                        // console.log(subtotal+taxes);
                        $('#netAmount').val(subtotal+taxes);
                    }else{
                        // console.log(subtotal);
                        $('#netAmount').val(subtotal);
                    }

                    $("#productTableBody > tr").each(function(e){
                        let unitPrice = $(this).find('.unit_price').text();
                        let taxes = $(this).find('.taxes').text();
                        let subTotal = $(this).find('.subtotal').text();
                        let netAmount = $(this).find('.netAmount').text();

                        let amount = parseFloat(taxes)+parseFloat(subTotal);

                        if($('#taxInclude').prop('checked')){
                            $(this).find('.netAmount').text(amount);
                        }else{
                            $(this).find('.netAmount').text(subTotal);
                        }
                    });

                    calculate();
                });

        getCustomerQuotation();

        // get customer list
        function getCustomerQuotation(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-CustomersList')}}",
                success : function (response){
                    $('#customerName').html('');
                    $('#customerName').append('<option value="">Select Customer</option>');
                    $('#customerNameQEdit').html('');
                    $('#customerNameQEdit').append('<option value="">Select Customer</option>');
                    jQuery.each(response, function(key, value){
                        $('#customerName').append(
                            '<option value="'+value["id"]+'">\
                            '+value["customer_name"]+'\
                            </option>'
                        );
                        $('#customerNameQEdit').append(
                            '<option value="'+value["id"]+'">\
                            '+value["customer_name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }

        $('#productName').prop('disabled', true);

        // fetch unique customer detials
        function fetchCustomerName(){
            let id = this.event.target.id;
            let pro = $('#'+id).val();

            $.ajax({
                type : "GET",
                data : {
                    'id' : pro,
                },
                url : "{{ route('SA-GetCustomerDetails1')}}",
                success : function (response){

                    // console.log(response);
                                   
                    jQuery.each(response, function(key, value){
                        $('#qCustomer_name').val(value["customer_name"]);
                        $('#qCustomer_nameEdit').val(value["customer_name"]);     
                        $('#customerAddress').val(value["address"]);

                            // Special Price Filtered Products Detials
                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetFilteredProductsDetials')}}",
                                data : {
                                    "id": value['id']
                                },
                                success : function (response){

                                    // console.log('updated', response);

                                    filterdProductArray = response;
                                    // console.log(filterdProductArray);

                                    $('#productName').removeAttr('disabled');
                                    $('#productName').html('');

                                    $('#productIdQuotation').val('');
                                    
                                    $('#productNameQuotation1').val('');

                                    $('#varient').val('');

                                    $('#category').val('');

                                    $('#description').val('');

                                    $('#quantity').val(0);

                                    $('#unitPrice').val(0);

                                    $('#taxes').val(0);

                                    $('#subTotal').val(0);

                                    $('#netAmount').val(0);

                                    $('#productName').append('<option value="">Select Product</option>');
                                    
                                    jQuery.each(response, function(key, value){
                                        // 
                                        $('#productName').append(
                                            '<option value="'+value["product_name"]+'">\
                                            '+value["product_name"]+'\
                                            </option>'
                                        );
                                        // 
                                    });
                                }
                            });
                    });
                }
            });
        }

                        function selectFunction(){
                            // let id = this.event.target.id;
                            let pro = $('#productName').val();

                            $('#category').val('');
                            $('#description').val('');
                            $('#unitPrice').val(0);
                            $('#taxes').val(0);
                            $('#subTotal').val(0);
                            $('#quantity').val(0);
                            $('#netAmount').val(0);
                            $('#sku_code').val('');
                            $('#batch_code').val('');

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetNameProducts')}}",
                                data : {
                                    "val": pro,
                                },
                                success : function (response){
                                    $('#varient').html('');
                                    $('#varient').append('<option value="">Select Variant</option>');
                                    jQuery.each(response, function(key, value){

                                        if($('#productsTable tbody > tr').length == 0){
                                            
                                                $('#varient').append(
                                                    '<option value="'+value["product_varient"]+'">\
                                                        '+value["product_varient"]+'\
                                                    </option>'
                                                );

                                        }else{

                                            let count = 0;

                                            $("#productTableBody tr").each(function(){
                                                let proName = $(this).find('.product_name').text();
                                                let proVarient = $(this).find('.product_varient').text();

                                                if(proName == value['product_name'] && proVarient == value['product_varient']){
                                                    ++count;
                                                }
                                            });

                                                if(count == 0){
                                                    $('#varient').append(
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

                        function selectVarientFunction(){
                            let id = this.event.target.id;
                            let varient = $('#'+id).val();
                           let product = $('#productName').val();
                           let customerId = $('#customerName').val();
                            
                            $('#description').val('');
                            $('#unitPrice').val(0);
                            $('#taxes').val(0);
                            $('#subTotal').val(0);
                            $('#quantity').val(0);
                            $('#netAmount').val(0);
                            $('#sku_code').val('');
                            $('#batch_code').val('');

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-FetchProductsDetialsInfo')}}",
                                data : {
                                    "id": customerId,
                                },
                                success : function (response){
                                    
                                    jQuery.each(response, function(key, value){
                                        if(value['product_name'] === product && value['varient'] === varient){
                                            
                                            // product id
                                            $('#'+id).closest('tr').find("input[id='productIdQuotation']").val(value["id"]);
                                            // sku code
                                            $('#'+id).closest('tr').find("input[id='sku_code']").val(value["sku_code"]);
                                            // batch code

                                            $.ajax({
                                                type : "GET",
                                                url : "{{ route('SA-SalesAllBatchCode')}}",
                                                data : {
                                                    "proName": value['product_name'],
                                                    "proVariant": value['varient'],
                                                },
                                                success : function (response){
                                                    // console.log('batchcode', response);
                                                    $('#batch_code').html('');
                                                    $('#batch_code').append('<option value="">Select Batch Code</option>');
                                                    jQuery.each(response, function(k,v){
                                                        $('#batch_code').append(`
                                                            <option value="${v['batch_code']}">${v['batch_code']}</option>
                                                        `);
                                                    });
                                                }
                                            });

                                            // $('#'+id).closest('tr').find("input[id='batch_code']").val(value["batch_code"]);
                                            // category
                                            $('#'+id).closest('tr').find("input[id='category']").val(value["category"]);
                                            // productNameReq
                                            $('#'+id).closest('tr').find("input[id='productNameQuotation1']").val(value["product_name"]);
                                            // unit price
                                            $('#'+id).closest('tr').find("input[id='unitPrice']").val(value["unit_price"]);
                                        }
                                    });

                                    // jQuery.each(filterdProductArray, function(key, value){
                                    //     if(product === value['product_name']){


                                    //     }
                                    // });
                                }
                            });
                        }

                        // console.log(filterdProductArray);

                        // jQuery.each(filterdProductArray, function(key, value){
                        //     if(parseInt(pro) === value['id']){
                        //         // product id
                        //         $('#'+id).closest('tr').find("input[id='productIdQuotation']").val(value["id"]);
                        //         // productNameReq
                        //         $('#'+id).closest('tr').find("input[id='productNameQuotation1']").val(value["product_name"]);
                        //         // category
                        //         $('#'+id).closest('tr').find("input[id='category']").val(value["category"]);
                        //         // varients
                        //         $('#'+id).closest('tr').find("input[id='varient']").val(value["varient"]);
                        //         // sku code
                        //         $('#'+id).closest('tr').find("input[id='sku_code']").val(value["sku_code"]);
                        //         // batch code
                        //         $('#'+id).closest('tr').find("input[id='batch_code']").val(value["batch_code"]);
                        //         // unit price
                        //         $('#'+id).closest('tr').find("input[id='unitPrice']").val(value["unit_price"]);
                        //     }
                        // });

        let allProductDetails = [];

        // Table
        $('#addProduct').on('click', function() {
            let productId = $('#productIdQuotation').val();
            let productName = $('#productNameQuotation1').val();
            let varient = $('#varient').val();
            let category = $('#category').val();
            let sku_code = $('#sku_code').val();
            let batch_code = $('#batch_code').val();
            let description = $('#description').val();
            let unitPrice = $('#unitPrice').val();
            let taxes = $('#taxes').val();
            let subTotal = $('#subTotal').val();
            let quantity = $('#quantity').val();
            let netAmount = $('#netAmount').val();

            let slno = $('#productsTable tr').length;
                if(productName!="" && varient !="" && batch_code!="" && category!="" && quantity!="" && unitPrice!="" && taxes!="" && subTotal!=""){
                    $('#productsTable tbody').append('<tr class="child">\
                                                    <td>'+ slno +'</td>\
                                                    <td class="product_id" style="display:none;">'+productId+'</td>\
                                                    <td class="product_name">'+productName+'</td>\
                                                    <td class="product_category">'+category+'</td>\
                                                    <td class="product_varient">'+varient+'</td>\
                                                    <td class="sku_code">'+sku_code+'</td>\
                                                    <td class="batch_code">'+batch_code+'</td>\
                                                    <td class="product_desc">'+description+'</td>\
                                                    <td class="product_quantity">'+quantity+'</td>\
                                                    <td class="unit_price">'+unitPrice+'</td>\
                                                    <td class="taxes" style="display:none;" >'+taxes+'</td>\
                                                    <td class="subtotal">'+subTotal+'</td>\
                                                    <td class="netAmount">'+netAmount+'</td>\
                                                    <td>\
                                                        <a href="javascript:void(0);" class="remCF1CreateQty">\
                                                            <i class="mdi mdi-delete"></i>\
                                                        </a>\
                                                    </td>\
                                                </tr>'
                                            );
                    calculate();

                    if($('#productTableBody').children().length === 0){
                        
                    }else{
                        $('#tableEmptyError').html('');
                    }

                    $('#productName').val('');
                    $('#productIdQuotation').val('');
                    $('#productNameQuotation1').val('');
                    $('#varient').val('');
                    $('#category').val('');
                    $('#description').val('');
                    $('#unitPrice').val(0);
                    $('#taxes').val(0);
                    $('#subTotal').val(0);
                    $('#quantity').val(0);
                    $('#netAmount').val(0);
                    $('#sku_code').val('');
                    $('#batch_code').val('');

                    calculate();

                }
                else{

                    // $('#tableEmptyError').html('Please select products in form.');
                    errorMsg('Please select products in form.');

                    if($('#productTableBody').children().length === 0){
                        // $('#tableEmptyError').html('Please add products details.');
                        errorMsg('Please add products details.');
                    }else{
                        $('#tableEmptyError').html('');
                    }
                }
        });

        $('#taxInclude').change(function(){
            calculate();
        });

        function calculate(){
            let sum = 0;
            let tax = 0;
            let i = 0;

            $("#productTableBody tr .subtotal").each(function(){
                sum += parseFloat($(this).text());
            });

            $('#untaxtedAmount').val(sum.toFixed(2));
            $('#untaxtedAmount1').val(sum.toFixed(2));
            $('#quotationTotal').val(sum.toFixed(2));
            $('#quotationTotal1').val(sum.toFixed(2));

            $("#productTableBody tr .taxes").each(function(){
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
        
        $(document).on('click','.remCF1CreateQty',function(){
            $(this).parent().parent().remove();
            
            $('#productsTable tbody tr').each(function(i){            
                $($(this).find('td')[0]).html(i+1);
            });
            calculate();
            selectFunction();
        });

</script>