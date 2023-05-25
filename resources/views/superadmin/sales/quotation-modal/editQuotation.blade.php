<!-- Modal -->
<div class="modal fade" id="editQuotation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Quotation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editQuotationForm">
        <div class="modal-body bg-white px-3"> 
            <!-- invoice body start here -->
                <div class="alert alert-success alert-dismissible fade show" id="editQuotationAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="editQuotationAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="editQuotationAlertDanger" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="editQuotationAlertDangerMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <!-- end -->    

            <!-- quotation id -->
                <input type="text" name="quotationId" id="quotationId" style="display: none;">

            <!-- row 1 -->
            <div class="form-group row">

                <div class="col-md-6">
                    <label for="customerName">Customer Name<span style="color: red; font-size:small;">*</span></label>
                    <select name="customerName" class="form-control" onchange="fetchCustomerName()" id="customerNameQEdit"></select>
                    <input type="text" name="qCustomer_id" id="qCustomer_nameEdit"  style="display:none;" />
                </div>

                <div class="col-md-6">
                    <label for="expiration">Date of Expiry<span style="color: red; font-size:small;">*</span></label>
                    <input type="date" name="expiration" id="expirationQE" class="form-control" placeholder="Date of Expiry">
                </div>

            </div>

            <!-- row 2 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customerAddress">Customer Address</label>
                    <textarea name="customerAddress" class="form-control" id="customerAddressQE" rows="4" placeholder="Address"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="paymentTerms">Payment Terms<span style="color: red; font-size:small;">*</span></label>
                    <select name="paymentTerms" class="form-control" id="paymentTermsQE">
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
                                <label for="taxInclude" class="text-primary form-control"><input type="checkbox" name="taxInclude" id="taxIncludeQEdit"> Tax Inclusive</label>
                            </div>
                        </div>                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue" value="7" id="gstValueEdit" min="1" placeholder="GST (In %)" />
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
            <h6 class="salesQuantityErrorEdit alert alert-warning" style="display: none;"></h6>
            <div class="row">
                <div class="col">
                    <fieldset class="border border-secondary ">
                        <legend class="float-none w-auto">Order Details<span style="color: red; font-size:small;">*</span></legend>
                            <span style="color:red; font-size:small;" id="edittableEmptyError"></span>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table border" id="products">
                                    <thead>
                                        <tr>
                                            <th class=" border border-secondary">Product</th>
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
                                                <select name="productName" id="productNameQuotationSection" onchange="selectProductFun()" class="form-control form-control-lg">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </td>
                                            <!-- productId -->
                                            <!-- hide content -->
                                            <td class=" border border-secondary" style="display: none;">
                                                <input type="text"  id="productIdQuotationQE" class="form-control" placeholder="Id">
                                                <input type="text"  id="productNameQuotationQE1" class="form-control" placeholder="Id">
                                            </td>
                                            <!-- varient -->
                                            <td class=" border border-secondary">
                                                <!-- <input type="text" name="varient" id="varientQE" class="form-control" placeholder="Varient" disabled /> -->
                                                <select name="varient" id="varientQE" class="form-control" onchange="selectVarientEFunction()">
                                                    <option value="">Select Variant</option>
                                                </select>
                                            </td>
                                            <!-- category -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="category" id="categoryQE" class="form-control" placeholder="Category" disabled />
                                            </td>
                                            <!-- sku -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="sku_code" id="sku_CodeQE" class="form-control" placeholder="SKU Code" disabled />
                                            </td>
                                            <!-- batch -->
                                            <td class=" border border-secondary">
                                                <!-- <input type="text" name="batch_Code" id="batch_CodeQE" class="form-control" placeholder="Batch Code" /> -->
                                                <select name="batch_code" id="batch_CodeQE" class="form-control">
                                                    <option value="">Select Batch Code</option>
                                                </select>
                                            </td>
                                            <!-- Description -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="description" id="descriptionQE" class="form-control" placeholder="Description">
                                            </td>
                                            <!-- Quantity -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="quantity" id="quantityQE" value="0" class="form-control" placeholder="Quantity">
                                            </td>
                                            <!-- unit price -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="unitPrice" id="unitPriceQE" value="0" class="form-control" placeholder="Unit Price" disabled />
                                            </td>
                                            <!-- taxes -->
                                            <td class=" border border-secondary" style="display: none;">
                                                <input type="text" name="taxes" id="taxesQE" value="0" class="form-control" placeholder="Taxes" disabled />
                                            </td>
                                            <!-- Gross Amount -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="subTotal" id="subTotalQE" value="0" class="form-control" placeholder="Gross Amount" disabled />
                                            </td>
                                            <!-- Net Amount -->
                                            <td class=" border border-secondary">
                                                <input type="text" name="netAmount" id="netAmountQE" value="0" class="form-control" placeholder="Net Amount" disabled />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a name="addLine" id="addProductQE" class="btn btn-primary text-white">Add Product</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productsTableQE" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>      
                                            <!-- <th>Product ID</th> -->
                                            <th>Product Name</th>      
                                            <th>Category</th>
                                            <th>Variant</th>
                                            <th>SKU Code</th>
                                            <th>Batch Code</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <!-- <th>Taxes</th> -->
                                            <th>Gross Amount</th>
                                            <th>Net Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productTableBodyQE"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="row mt-2">
                <div class="col-md-6">
                    <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                    <input type="text" name="notes" id="notesQE" class="form-control" placeholder="Add an Internal Note" />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto ">Sub Total</div>
                        <div class="col-md-7">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" name="untaxtedAmount1" id="untaxtedAmountQE" class="form-control" placeholder="Sub Total" disabled>
                                        <input type="text" name="untaxtedAmount" id="untaxtedAmountQE1" class="form-control" placeholder="Sub Total" style="display: none;">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">GST</div>
                        <div class="col-md-7 ">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" name="gst1" id="gstQE" class="form-control" placeholder="GST" disabled>
                                        <input type="text" name="gst" id="gstQE1" class="form-control" placeholder="GST" style="display: none;">                        
                                    </div>
                                </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5  my-auto">Grand Total</div>
                        <div class="col-md-7 ">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" id="quotationTotalQE" name="quotationTotal1" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                                        <input type="text" id="quotationTotalQE1" name="quotationTotal" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                                    </div>
                                </div>
                        </div>                   
                    </div>
                </div>
            </div>


            <!-- end here -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editQuotationFormClearBtn" >Clear</button>
            <button type="submit" id="editQuotationForm1" class="btn btn-primary">Save</button>
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


                        function editQuotationFilterProducts(id){
                            // Special Price Filtered Products Detials
                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetFilteredProductsDetials')}}",
                                data : {
                                    "id": id
                                },
                                success : function (response){

                                    filterdProductArray = response;

                                    $('#productNameQuotationSection').html('');
                                    $('#productNameQuotationSection').append('<option value="">Select Product</option>');
                                    jQuery.each(response, function(key, value){
                                        // product name dropdown in qotation form
                                        $('#productNameQuotationSection').append(
                                            '<option value="'+value["product_name"]+'">\
                                            '+value["product_name"]+'\
                                            </option>'
                                        );
                                    });
                                }
                            });
                        }

                        function selectProductFun(){
                            // let id = this.event.target.id;
                            let pro = $('#productNameQuotationSection').val();

                            $('#categoryQE').val('');
                            $('#sku_CodeQE').val('');
                            $('#batch_CodeQE').val('');
                            $('#descriptionQE').val('');
                            $('#quantityQE').val('');
                            $('#unitPriceQE').val('');
                            $('#taxesQE').val('');
                            $('#subTotalQE').val('');
                            $('#netAmountQE').val('');

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetNameProducts')}}",
                                data : {
                                    "val": pro,
                                },

                                success : function (response){
                                    $('#varientQE').html('');
                                    $('#varientQE').append('<option value="">Select Variant</option>');
                                    jQuery.each(response, function(key, value){

                                        if($('#productsTableQE tbody > tr').length == 0){
                                            
                                                $('#varientQE').append(
                                                    '<option value="'+value["product_varient"]+'">\
                                                        '+value["product_varient"]+'\
                                                    </option>'
                                                );

                                        }else{

                                            let count = 0;

                                            $("#productTableBodyQE tr").each(function(){
                                                let proName = $(this).find('.product_name').text();
                                                let proVarient = $(this).find('.product_varient').text();

                                                if(proName == value['product_name'] && proVarient == value['product_varient']){
                                                    ++count;
                                                }
                                            });

                                                if(count == 0){
                                                    $('#varientQE').append(
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

                        function selectVarientEFunction(){
                            let id = this.event.target.id;
                            let varient = $('#'+id).val();
                           let product = $('#productNameQuotationSection').val();
                           let customerId = $('#customerNameQEdit').val();

                            $('#categoryQE').val('');
                            $('#sku_CodeQE').val('');
                            $('#batch_CodeQE').val('');
                            $('#descriptionQE').val('');
                            $('#quantityQE').val('');
                            $('#unitPriceQE').val('');
                            $('#taxesQE').val('');
                            $('#subTotalQE').val('');
                            $('#netAmountQE').val('');

                            // console.log(filterdProductArray);

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-FetchProductsDetialsInfo')}}",
                                data : {
                                    // "product":product,
                                    // "varient": varient,
                                    "id": customerId,
                                },
                                success : function (response){

                                    jQuery.each(response, function(key, value){
                                        if(value['product_name'] === product && value['varient'] === varient){
                                            // product id
                                            $('#'+id).closest('tr').find("input[id='productIdQuotationQE']").val(value["id"]);
                                            // productNameReq
                                            $('#'+id).closest('tr').find("input[id='productNameQuotationQE1']").val(value["product_name"]);
                                            // unit price
                                            $('#'+id).closest('tr').find("input[id='unitPriceQE']").val(value["unit_price"]);                                        
                                            // sku code
                                            $('#'+id).closest('tr').find("input[id='sku_CodeQE']").val(value["sku_code"]);
                                            // batch code
                                            // $('#'+id).closest('tr').find("input[id='batch_CodeQE']").val(value["batch_code"]);
                                            $.ajax({
                                                type : "GET",
                                                url : "{{ route('SA-SalesAllBatchCode')}}",
                                                data : {
                                                    "proName": value['product_name'],
                                                    "proVariant": value['varient'],
                                                },
                                                success : function (response){
                                                    $('#batch_CodeQE').html('');
                                                    $('#batch_CodeQE').append('<option value="">Select Batch Code</option>');
                                                    jQuery.each(response, function(k,v){
                                                        $('#batch_CodeQE').append(`
                                                            <option value="${v['batch_code']}">${v['batch_code']}</option>
                                                        `);
                                                    });
                                                }
                                            });
                                            // category
                                            $('#'+id).closest('tr').find("input[id='categoryQE']").val(value["category"]);
                                        }
                                    });
                                }
                            });
                        }                  

    // clear form
jQuery('#editQuotationFormClearBtn').on('click', function (){
    jQuery("#editQuotationForm")["0"].reset();
    $('#productTableBodyQE').html('');
});

  // validation script start here
  $(document).ready(function() {
    // store data to database
    jQuery("#editQuotationForm").submit(function (e) {
        e.preventDefault();    
        $.validator.addMethod("validate", function(value) {
            return /[A-Za-z]/.test(value);
        });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
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
          required: "Please enter customer name."
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
          min: "GST value atleast have 1%.",
        },
      },
      submitHandler:function(){

        if($('#productTableBodyQE').children().length === 0){
            // $('#edittableEmptyError').html('Please add products details.');
            errorMsg('Please add products details.');
        }else{
            $('#edittableEmptyError').html('');
        
            bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                if(result){
                
                    allProductDetailsEditSection.splice(0, allProductDetailsEditSection.length);
                    
                    $("#productTableBodyQE > tr").each(function(e){
                        let product_Id = $(this).find('.product_Id').text();
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
                        let netAmount = $(this).find('.netAmountQE').text();

                        let dbData = {
                                "product_Id":product_Id,
                                "product_name":productName,
                                "product_varient":varient,
                                "category":category,
                                "sku_code":sku_code,
                                "batch_code":batch_code,
                                "description":description,
                                "quantity":quantity,
                                "unitPrice":unitPrice,
                                "taxes":taxes,
                                "subTotal":subTotal,
                                "netAmount":netAmount,
                        }
                        allProductDetailsEditSection.push(dbData);
                    });

                    jQuery.ajax({
                        url: "{{ route('SA-UpdateQuotation') }}",
                        data: jQuery("#editQuotationForm").serialize()+"&allProductDetails="+JSON.stringify(allProductDetailsEditSection),
                        enctype: "multipart/form-data",
                        type: "post",
                        success: function (result) {
                            if(result.error !=null ){
                                jQuery(".salesQuantityErrorEdit").hide();
                                errorMsg(result.error);
                            }
                            else if(result.barerror != null)
                            {
                                errorMsg(result.barerror);
                                jQuery("#editQuotationAlert").hide();
                                jQuery(".salesQuantityErrorEdit").hide();
                            }
                            else if(result.success != null)
                            {
                                successMsg(result.success);
                                $('.modal .close').click();
                                jQuery("#editQuotationForm")["0"].reset();
                                allProductDetailsEditSection.splice(0, allProductDetailsEditSection.length);
                                sales_quotation_main_table.ajax.reload();
                                getQuotationNum();
                                jQuery("#productsTableQE tbody").html('');
                                jQuery("#productTableBodyQE").html('');
                                jQuery(".salesQuantityErrorEdit").hide();
                                jQuery("#salesInvoiceForm")["0"].reset();
                                jQuery("#productTableInvoiceBody").html('');
                                sales_order_main_table.ajax.reload();
                            }
                            else if(result.salesQuantityErrorEdit != null)
                            {
                                jQuery(".salesQuantityErrorEdit").show();
                                jQuery(".salesQuantityErrorEdit").html(result.salesQuantityErrorEdit);
                                jQuery("#productsTableQE tbody").html('');
                                jQuery("#productTableBodyQE").html('');
                            }
                            else 
                            {
                                jQuery(".salesQuantityErrorEdit").hide();
                                jQuery("#editQuotationAlertDanger").hide();
                                jQuery("#editQuotationAlert").hide();
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

    $(document).on('keyup keydown change', "input[id='gstValueEdit']", function(e){

        let tax = parseFloat($(this).val());

        let quantity = $('#quantityQE').val();
        let price = $('#unitPriceQE').val();

        let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;

        let subTotal = parseFloat(quantity)*parseFloat(price);

        $('#taxesQE').val(taxes);

        if($('#taxIncludeQEdit').prop('checked')){
            $('#netAmountQE').val(subTotal+taxes);
        }else{
            $('#netAmountQE').val(subTotal);
        }

            $("#productTableBodyQE > tr").each(function(e){
                let unitPrice = $(this).find('.unit_price').text();
                quantity = $(this).find('.product_quantity').text();
                subTotal = $(this).find('.subtotal').text();
                // let netAmount = $(this).find('.netAmountQE').text();

                taxes = ((parseFloat(unitPrice)*parseFloat(quantity))*parseFloat(tax))/100;

                $(this).find('.taxes').text(taxes);

                let amount = parseFloat(taxes)+parseFloat(subTotal);

                if($('#taxIncludeQEdit').prop('checked')){
                    $(this).find('.netAmountQE').text(amount);
                }else{
                    $(this).find('.netAmountQE').text(subTotal);
                }
            });

        calculateQE();

    });

    $(document).on('keyup', "input[id='quantityQE']", function(e){

            let quantity = $(this).val();
            let price = $(this).closest('tr').find("input[id='unitPriceQE']").val();
            let taxes = $(this).closest('tr').find("input[id='taxesQE']").val();

            // +parseFloat(taxes)
            let subtotal = parseFloat(quantity)*parseFloat(price);
            $(this).closest('tr').find("input[id='subTotalQE']").val(subtotal);

            // gst value
            $gstValue = $('#gstValueEdit').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;
            
            if($('#taxIncludeQEdit').prop('checked')){
                $('#netAmountQE').val(subtotal+$totalGST);
            }else{
                $('#netAmountQE').val(subtotal);
            }

            $(this).closest('tr').find("input[id='taxesQE']").val($totalGST);
            
            calculateQE();
    });

        getCustomerNameQ();

        // get customer list
        function getCustomerNameQ(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-CustomersList')}}",
                success : function (response){
                    $('#customerNameQEdit').html('');
                    $('#customerNameQEdit').append('<option value="">Select Customer</option>');
                    jQuery.each(response, function(key, value){
                        $('#customerNameQEdit').append(
                            '<option value="'+value["id"]+'">\
                            '+value["customer_name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }

    //    getQuotationProductsList();

    //     function getQuotationProductsList(){
    //         $.ajax({
    //             type : "GET",
    //             url : "{{ route('SA-GetAllProducts')}}",
    //             success : function (response){
    //                 $('#productNameQuotationSection').append('<option>Select Product</option>');
    //                 jQuery.each(response, function(key, value){
    //                     // product name dropdown in qotation form
    //                     $('#productNameQuotationSection').append(
    //                         '<option value="'+value["id"]+'">\
    //                         '+value["product_name"]+'\
    //                         </option>'
    //                     );
    //                 });
    //             }
    //         });
    //     }
        
        // function selectProductFun(){
        //     let id = this.event.target.id;
        //     let pro = $('#'+id).val();
        //     getProduct(pro, id);

        //     // get single product details
        //     function getProduct(pro, id){
        //         $.ajax({
        //             type : "GET",
        //             url : ,
        //             data : {
        //                 "pro" : pro
        //             },
        //             success : function (response){
        //                 jQuery.each(response, function(key, value){
        //                     // product id
        //                     $('#'+id).closest('tr').find("input[id='productIdQuotationQE']").val(value["id"]);
        //                     // productNameReq
        //                     $('#'+id).closest('tr').find("input[id='productNameQuotationQE1']").val(value["product_name"]);
        //                     // variend
        //                     $('#'+id).closest('tr').find("input[id='varientQE']").val(value["product_varient"]);
        //                     // category
        //                     $('#'+id).closest('tr').find("input[id='categoryQE']").val(value["product_category"]);
        //                     // unit price
        //                     $('#'+id).closest('tr').find("input[id='unitPriceQE']").val(value["min_sale_price"]);
        //                     // taxes
        //                     // $('#'+id).closest('tr').find("input[id='taxesQE']").val(value["tax"]);
        //                 });
        //             }
        //         });
        //     }
        // };

        let allProductDetailsEditSection = [];

        // Table
        $('#addProductQE').on('click', function() {
            let productId = $('#productIdQuotationQE').val();
            let productName = $('#productNameQuotationQE1').val();
            let varient = $('#varientQE').val();
            let sku_code = $('#sku_CodeQE').val();
            let batch_code = $('#batch_CodeQE').val();
            let category = $('#categoryQE').val();
            let description = $('#descriptionQE').val();
            let quantity = $('#quantityQE').val();
            let unitPrice = $('#unitPriceQE').val();
            let taxes = $('#taxesQE').val();
            let subTotal = $('#subTotalQE').val();
            let netAmountQE = $('#netAmountQE').val();

            let slno = $('#productsTableQE tr').length;
            if(productName!="" && varient !="" && batch_code!="" && category!="" && quantity!="" && unitPrice!="" && taxes!="" && subTotal!=""){
                $('#productsTableQE tbody').append('<tr class="child">\
                                                <td>'+ slno++ +'</td>\
                                                <td class="product_Id" style="display:none;">'+productId+'</td>\
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
                                                <td class="netAmountQE">'+netAmountQE+'</td>\
                                                <td>\
                                                    <a href="javascript:void(0);" class="remCF1QE">\
                                                        <i class="mdi mdi-delete"></i>\
                                                    </a>\
                                                </td>\
                                            </tr>'
                                        );
                calculateQE();

                    if($('#productTableBodyQE').children().length === 0){        
                    }else{
                        $('#edittableEmptyError').html('');
                    }
            }  else{

                // $('#edittableEmptyError').html('Please select products in form.');
                errorMsg('Please select products in form.');

                if($('#productTableBodyQE').children().length === 0){
                    // $('#edittableEmptyError').html('Please add products details.');
                    errorMsg('Please add products details.');
                    
                }else{
                    $('#edittableEmptyError').html('');
                }
            }

            $('#productNameQuotationSection').val('');
            $('#productIdQuotationQE').val('');
            $('#productNameQuotationQE1').val('');
             $('#varientQE').val('');
            $('#categoryQE').val('');
            $('#sku_CodeQE').val('');
            $('#batch_CodeQE').val('');
            $('#descriptionQE').val('');
            $('#quantityQE').val('');
            $('#unitPriceQE').val('');
            $('#taxesQE').val('');
            $('#subTotalQE').val('');
            $('#netAmountQE').val('');

        });

        $('#taxIncludeQEdit').change(function(){

            let quantity = parseFloat($('#quantityQE').val());

            let price = parseFloat($('#unitPriceQE').val());

            let taxes = parseFloat($('#taxesQE').val());

            let subtotal = parseFloat(quantity)*parseFloat(price);

            if($('#taxIncludeQEdit').prop('checked')){
                $('#netAmountQE').val(subtotal+parseFloat(taxes));
            }else{
                $('#netAmountQE').val(subtotal);
            }

            calculateQE();


            // $('#productNameQuotationSection').val('');
            // $('#productIdQuotationQE').val('');
            // $('#productNameQuotationQE1').val('');
            // $('#varientQE').val('');
            // $('#categoryQE').val('');
            // $('#sku_CodeQE').val('');
            // $('#batch_CodeQE').val('');
            // $('#descriptionQE').val('');
            // $('#quantityQE').val('');
            // $('#unitPriceQE').val('');
            // $('#taxesQE').val('');
            // $('#subTotalQE').val('');
            // $('#netAmountQE').val('');

            $("#productTableBodyQE > tr").each(function(e){
                let unitPrice = $(this).find('.unit_price').text();
                let taxes = $(this).find('.taxes').text();
                let subTotal = $(this).find('.subtotal').text();
                let netAmount = $(this).find('.netAmountQE').text();

                let amount = parseFloat(taxes)+parseFloat(subTotal);

                if($('#taxIncludeQEdit').prop('checked')){
                    $(this).find('.netAmountQE').text(amount);
                }else{
                    $(this).find('.netAmountQE').text(subTotal);
                }
            });

        });

        function calculateQE(){
            let sum = 0;
            let tax = 0;
            let i = 0;

            $("#productTableBodyQE tr .subtotal").each(function(){
                sum += parseFloat($(this).text());
            });

            $('#untaxtedAmountQE').val(sum.toFixed(2));
            $('#untaxtedAmountQE1').val(sum.toFixed(2));
            $('#quotationTotalQE').val(sum.toFixed(2));
            $('#quotationTotalQE1').val(sum.toFixed(2));

            $("#productTableBodyQE tr .taxes").each(function(){
                tax += parseFloat($(this).text());
            });

            $('#gstQE').val(tax.toFixed(2));
            $('#gstQE1').val(tax.toFixed(2));

                    if($('#taxIncludeQEdit').prop('checked')){
                        let untaxtedAmount = parseFloat($('#untaxtedAmountQE').val());
                        let totalBill = untaxtedAmount+tax;

                        $('#quotationTotalQE').val(totalBill.toFixed(2));
                        $('#quotationTotalQE1').val(totalBill.toFixed(2));
                    }else{
                        let untaxtedAmount = parseFloat($('#untaxtedAmountQE').val());
                        let totalBill = untaxtedAmount;

                        $('#gstQE').val('');

                        $('#quotationTotalQE').val(totalBill.toFixed(2));
                        $('#quotationTotalQE1').val(totalBill.toFixed(2));
                    }

        };
        
        $(document).on('click','.remCF1QE',function(){
            $(this).parent().parent().remove();
            $('#productsTableQE tbody tr').each(function(i){            
                $($(this).find('td')[0]).html(i+1);
            });
            calculateQE();
            selectProductFun();
        });        

</script>
