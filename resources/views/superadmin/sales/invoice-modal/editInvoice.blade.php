<!-- Modal -->
<style>
    input[type="checkbox"][readonly] {
  pointer-events: none;
}
</style>
<div class="modal fade" id="editInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Invoice</h5>
        <button type="button" class="close" id="nio" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="salesEditInvoiceForm">
        <div class="modal-body bg-white px-3"> 
            <!-- invoice body start here -->

            <!-- info & alert section -->
                <div class="alert alert-success" id="editInvoiceAlert" style="display:none"></div>
                <div class="alert alert-danger" style="display:none">
                    <ul></ul>
                </div>
              <!-- end -->

              <!-- invoice id -->
              <input type="text" name="invoiceId" id="invoiceID" style="display: none;">
                <!-- End -->

            <!-- row 0 -->
            <div class="form-group row">
                <div class="col-md-2 col-form-label">Order No.</div>
                <div class="col-md-4">
                    <!-- <select name="quotationNumber" id="quotationNumberEInvoice" class="form-control text-dark"></select> -->
                    <input type="text" name="quotationNumber" id="quotationNumberEInvoice" placeholder="Order No." class="form-control text-dark" readonly />
                </div>
                <!-- <div class="col-md-2 form-control text-center border-0 fw-bold text-dark">
                    <h6>OR</h6>
                </div> -->
                <div class="col-md-2 col-form-label">Invoice No.</div>
                <div class="col-md-4">
                    <input type="text" readonly class="form-control text-dark" name="refNextQColumn" id="refNextColumnEInvoice" placeholder="Invoice No." />
                </div>
            </div>

            <!-- row 2 -->
            <div class="form-group row">
                <div class="col-md-2 col-form-label">Customer Name</div>
                <div class="col-md-4">
                    <!-- <select name="customerName" readonly class="form-control" onchange="fetchCustomerNameInvoice()" id="customerNameEditInvoice"></select> -->
                    <input type="text" name="customerName" class="form-control" placeholder="Customer Name" id="customerNameEditInvoice" readonly />
                    <input type="text" name="invoiceCustomer_id" id="invoiceCustomer_idEdit" style="display: none;"/>
                </div>
                <div class="col-md-2 col-form-label">Invoice Date</div>
                <div class="col-md-4">
                    <input type="date" name="invoiceDate" class="form-control text-dark" id="invoiceDateEInvoice" placeholder="Invoice Date">
                </div>
            </div>

            <!-- row 3 -->
            <div class="form-group row">
                <div class="col-md-2 col-form-label">Payment Reference</div>
                <div class="col-md-3">
                    <input type="text" name="paymentReference" class="form-control text-dark" id="pymentReferenceEInvoice" placeholder="Payment Reference">
                </div>
                <div class="col-md col-form-label" style="font-size: 14px;">Due Date</div>
                <div class="col-md-3">
                    <input type="date" name="dueDate" class="form-control text-dark" id="invoiceDueEInvoice" />
                </div>
                <div class="col-md col-form-label text-center border-0 fw-bold text-dark"><h6>OR</h6></div>
                <div class="col-md-2">
                    <select name="selectTerms" id="selectTermsEInvoice" class="form-control form-control-lg text-dark">
                        <option value="">Select Payment Terms</option>
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="30 days">30 days</option>
                    </select>
                </div>
            </div>

            <!-- row 4 -->
            <div class="row">
                <div class="col-md-8">
                    
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label for="taxInclude" class="text-primary form-control">
                                    <input type="checkbox" name="taxInclude" id="taxIncludeEditInvoice"> Tax Inclusive</label>
                            </div>
                        </div>                            
                        <div class="col-lg-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="gstValue" value="7" id="gstValueInvoiceEdit" min="1" placeholder="GST (In %)" />
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
            <h6 class="salesQuantityInvoiceErrorEdit alert alert-warning" style="display: none;"></h6>
            <div class="form-group row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Invoice Details</legend>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table border" id="products">
                                    <thead>
                                        <tr>
                                            <th class="p-2 border border-secondary">Product Name</th>      
                                            <th class="p-2 border border-secondary">Variant</th>
                                            <th class="p-2 border border-secondary">Category</th>
                                            <th class="p-2 border border-secondary">SKU Code</th>
                                            <th class="p-2 border border-secondary">Batch Code</th>
                                            <th class="p-2 border border-secondary">Description</th>
                                            <th class="p-2 border border-secondary">Quantity</th>
                                            <th class="p-2 border border-secondary">Unit Price</th>
                                            <th class="p-2 border border-secondary">Gross Amount</th>
                                            <th class="p-2 border border-secondary">Net Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="invoiceBody">
                                        <tr><form id="addProductForm0">
                                            <!-- product -->
                                            <td class="p-2 border border-secondary">
                                                <select name="productName" id="productNameEInvoice" onchange="selectProductInvoiceEFunction()" class="form-control form-control-lg">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </td>
                                             <!-- productId hide content -->
                                            <td class="p-2 border border-secondary" style="display:none;">
                                                <input type="text"  id="productIdEInvoice" class="form-control" placeholder="Id">
                                                <input type="text"  id="productNameEInvoice1" class="form-control" placeholder="Id">
                                            </td>
                                            <!-- varient -->
                                            <td class="p-2 border border-secondary">
                                                <!-- <input type="text" name="varient" id="varientEInvoice" class="form-control" placeholder="Varient" disabled /> -->
                                                <select name="varient" id="varientEInvoice" class="form-control" onchange="selectVarientInvoiceEFunction()">
                                                    <option value="">Select Variant</option>
                                                </select>
                                            </td>
                                            <!-- category -->
                                            <td class="p-2 border border-secondary">
                                                <input type="text" name="category" id="categoryEInvoice" class="form-control" placeholder="Category" disabled />
                                            </td>
                                            <!-- sku code -->
                                            <td class="p-2 border border-secondary">
                                                <input type="text" name="sku_Code" id="sku_CodeEInvoice" class="form-control" placeholder="SKU Code" disabled />
                                            </td>
                                            <!-- batch code -->
                                            <td class="p-2 border border-secondary">
                                                <!-- <input type="text" name="batch_Code" id="batch_CodeEInvoice" class="form-control" placeholder="Batch Code" disabled /> -->
                                                <select name="batch_Code" id="batch_CodeEInvoice" class="form-control">
                                                    <option value="">Select Batch Code</option>
                                                </select>
                                            </td>
                                            <!-- Description -->
                                            <td class="p-2 border border-secondary">
                                                <input type="text" name="description" id="descriptionEInvoice" class="form-control" placeholder="Description">
                                            </td>
                                            <!-- Quantity -->
                                            <td class="p-2 border border-secondary">
                                                <input type="text" name="quantity" id="quantityEInvoice" value="0" class="form-control" placeholder="Quantity">
                                            </td>
                                            <!-- unit price -->
                                            <td class="p-2 border border-secondary">
                                                <input type="text" name="unitPrice" id="unitPriceEInvoice" value="0" class="form-control" placeholder="Unit Price" disabled />
                                            </td>
                                            <!-- taxes -->
                                            <td class="p-2 border border-secondary" style="display: none;">
                                                <input type="text" name="taxes" id="taxesEInvoice" class="form-control" value="0" placeholder="Taxes" disabled />
                                            </td> 
                                            <!-- sub total -->
                                            <td class="p-2 border border-secondary">
                                                <input type="text" name="subTotal" id="subTotalEInvoice" value="0" class="form-control" placeholder="Gross Amount" disabled />
                                            </td>
                                            <!-- net amount -->
                                            <td class="p-2 border border-secondary">
                                                <input type="text" name="netAmountEInvoice" id="netAmountEInvoice" value="0" class="form-control" placeholder="Net Amount" disabled />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a name="addLine" id="addProductEInvoice" class="btn btn-primary text-white">Add Product</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productTableEInvoice" style="width: 100%; border-collapse: collapse;">
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
                                    <tbody id="productTableEditInvoiceBody"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>        

            <div class="form-group row">
                <div class="col-md-6">
                    <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                    <input type="text" name="notes" id="notesEInvoice" class="form-control" placeholder="Add an Internal Note" />
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Sub Total</div>
                        <div class="col-md-7 ">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" name="untaxtedAmountEInvoice" id="untaxtedAmountEInvoice" class="form-control" placeholder="Sub Total" disabled>
                                        <input type="text" name="untaxtedAmountEInvoice1" id="untaxtedAmountEInvoice1" class="form-control" placeholder="Sub Total" style="display: none;">
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
                                        <input type="text" name="GST" id="gstEInvoice" class="form-control" placeholder="GST" disabled>
                                        <input type="text" name="GST1" id="gstEInvoice1" class="form-control" placeholder="GST" style="display: none;">
                                    </div>
                                </div>                        
                        </div>
                    </div>
                    <hr />
                    <div class="row mx-auto my-1">
                        <div class="col-md-5 my-auto">Grand Total</div>
                        <div class="col-md-7 ">

                                <div class="form-group my-auto">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-facebook" type="button">
                                                $
                                            </button>
                                        </div>
                                        <input type="text" id="invoiceETotal" name="invoiceETotal" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                                        <input type="text" id="invoiceETotal1" name="invoiceETotal1" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                                    </div>
                                </div>
                        </div>                   
                    </div>
                </div>
            </div>


            <!-- end here -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editInvoiceClearFormBtn" >Clear</button>
            <button type="submit" id="salesEditInvoiceForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery CDN -->
<script>

                        function selectProductInvoiceEFunction(){
                            let id = this.event.target.id;
                            let pro = $('#'+id).val();

                            $('#categoryEInvoice').val('');
                            $('#sku_CodeEInvoice').val('');
                            $('#batch_CodeEInvoice').val('');
                            $('#descriptionEInvoice').val('');
                            $('#quantityEInvoice').val(0);
                            $('#unitPriceEInvoice').val(0);
                            $('#taxesEInvoice').val(0);
                            $('#subTotalEInvoice').val(0);
                            $('#netAmountEInvoice').val(0);

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetNameProducts')}}",
                                data : {
                                    "val": pro,
                                },
                                success : function (response){
                                    console.log(response);
                                    $('#varientEInvoice').html('');
                                    $('#varientEInvoice').append('<option value="">Select Variant</option>');
                                    jQuery.each(response, function(key, value){
                                        if($('#productTableEInvoice tbody > tr').length == 0){
                                                $('#varientEInvoice').append(
                                                    '<option value="'+value["product_varient"]+'">\
                                                        '+value["product_varient"]+'\
                                                    </option>'
                                                );
                                        }else{
                                            let count = 0;
                                            $("#productTableEditInvoiceBody tr").each(function(){
                                                let proName = $(this).find('.product_nameEInvoice').text();
                                                let proVarient = $(this).find('.product_varientEInvoice').text();

                                                if(proName == value['product_name'] && proVarient == value['product_varient']){
                                                    ++count;
                                                }
                                            });

                                                if(count == 0){
                                                    $('#varientEInvoice').append(
                                                        '<option value="'+value["product_varient"]+'">\
                                                            '+value["product_varient"]+'\
                                                        </option>'
                                                    );
                                                }
                                        }
                                    });
                                    // jQuery.each(response, function(key, value){
                                    //         $('#varientEInvoice').append(
                                    //             '<option value="'+value["product_varient"]+'">\
                                    //                 '+value["product_varient"]+'\
                                    //             </option>'
                                    //         );
                                    // });
                                }
                            });
                        };

                        function selectVarientInvoiceEFunction(){
                            let id = this.event.target.id;
                            let varient = $('#'+id).val();
                            let product = $('#productNameEInvoice').val();
                            let customerId = $('#customerNameEditInvoice').val();

                            $('#categoryEInvoice').val('');
                            $('#sku_CodeEInvoice').val('');
                            $('#batch_CodeEInvoice').val('');
                            $('#descriptionEInvoice').val('');
                            $('#quantityEInvoice').val(0);
                            $('#unitPriceEInvoice').val(0);
                            $('#taxesEInvoice').val(0);
                            $('#subTotalEInvoice').val(0);
                            $('#netAmountEInvoice').val(0);

                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-FetchProductsDetialsInfo')}}",
                                data : {
                                    // "product": product,
                                    // "varient": varient,
                                    "id": customerId,
                                },
                                success : function (response){

                                    // console.log(response);

                                    jQuery.each(response, function(key, value){
                                        if(value['product_name'] === product && value['varient'] === varient){
                                            // product id
                                            $('#'+id).closest('tr').find("input[id='productIdEInvoice']").val(value["id"]);
                                            // sku code
                                            $('#'+id).closest('tr').find("input[id='sku_CodeEInvoice']").val(value["sku_code"]);
                                            // batch code
                                            // $('#'+id).closest('tr').find("input[id='batch_CodeEInvoice']").val(value["batch_code"]);
                                            $.ajax({
                                                type : "GET",
                                                url : "{{ route('SA-SalesAllBatchCode')}}",
                                                data : {
                                                    "proName": value['product_name'],
                                                    "proVariant": value['varient'],
                                                },
                                                success : function (response){
                                                    // console.log('batchcode', response);
                                                    $('#batch_CodeEInvoice').html('');
                                                    $('#batch_CodeEInvoice').append('<option value="">Select Batch Code</option>');
                                                    jQuery.each(response, function(k,v){
                                                        $('#batch_CodeEInvoice').append(`
                                                            <option value="${v['batch_code']}">${v['batch_code']}</option>
                                                        `);
                                                    });
                                                }
                                            });
                                            // category
                                            $('#'+id).closest('tr').find("input[id='categoryEInvoice']").val(value["category"]);
                                            // productNameReq
                                            $('#'+id).closest('tr').find("input[id='productNameEInvoice1']").val(value["product_name"]);
                                            // unit price
                                            $('#'+id).closest('tr').find("input[id='unitPriceEInvoice']").val(value["unit_price"]);
                                        }
                                    });
                                }
                            });
                        }

        $('#editInvoiceClearFormBtn').on('click', function(){
            $('#salesEditInvoiceForm')['0'].reset();
            $('#productTableEditInvoiceBody').html('');
        });

                        function editInvoiceFilterProducts(id){
                            // Special Price Filtered Products Detials
                            $.ajax({
                                type : "GET",
                                url : "{{ route('SA-GetFilteredProductsDetials')}}",
                                data : {
                                    "id": id
                                },
                                success : function (response){

                                    filterdProductArray = response;

                                    $('#productNameEInvoice').html('');
                                    $('#productNameEInvoice').append('<option value="">Select Product</option>');
                                    jQuery.each(response, function(key, value){
                                        // product name dropdown in qotation form
                                        $('#productNameEInvoice').append(
                                            '<option value="'+value["product_name"]+'">\
                                            '+value["product_name"]+'\
                                            </option>'
                                        );
                                    });
                                }
                            });
                        }

    // fetch all quotation number
    getQuotationNumEInvoice();
    function getQuotationNumEInvoice(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetAllQuotations')}}",
                success : function (response){
                    
                    
                    $('#quotationNumberEInvoice').append('<option value="">Select Order Number</option>');
                    jQuery.each(response, function(key, value){
                        $('#quotationNumberEInvoice').append(
                            '<option value="'+value["id"]+'">\
                            '+value["id"]+'\
                            </option>'
                        );
                    });
                }
            });
        }


        // get customer list
        getCustomerEInvoice();

        function getCustomerEInvoice(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-CustomersList')}}",
                success : function (response){
                    $('#customerNameEInvoice').append('<option value="">Select Customer</option>');
                    jQuery.each(response, function(key, value){
                        $('#customerNameEInvoice').append(
                            '<option value="'+value["customer_name"]+'">\
                            '+value["customer_name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }

        let allProductDetailsEInvoice = [];

        // Table
        $('#addProductEInvoice').on('click', function() {
            let productId = $('#productIdEInvoice').val();
            let productName = $('#productNameEInvoice1').val();
            let varient = $('#varientEInvoice').val();
            let category = $('#categoryEInvoice').val();
            let sku_code = $('#sku_CodeEInvoice').val();
            let batch_code = $('#batch_CodeEInvoice').val();
            let description = $('#descriptionEInvoice').val();
            let quantity = $('#quantityEInvoice').val();
            let unitPrice = $('#unitPriceEInvoice').val();
            let taxes = $('#taxesEInvoice').val();
            let subTotal = $('#subTotalEInvoice').val();
            let netAmountEInvoice = $('#netAmountEInvoice').val();

            let count = $('#productTableEInvoice tr').length;
            if(productName!="" && varient !="" && category!="" && batch_code!="" && quantity!="" && unitPrice!="" && taxes!="" && subTotal!=""){
                $('#productTableEInvoice tbody').append('<tr class="child">\
                    <td>'+count+'</td>\
                    <td class="product_IdEInvoice" style="display:none;">'+productId+'</td>\
                    <td class="product_nameEInvoice">'+productName+'</td>\
                    <td class="product_categoryEInvoice">'+category+'</td>\
                    <td class="product_varientEInvoice">'+varient+'</td>\
                    <td class="sku_CodeEInvoice">'+sku_code+'</td>\
                    <td class="batch_CodeEInvoice">'+batch_code+'</td>\
                    <td class="product_descEInvoice">'+description+'</td>\
                    <td class="product_quantityEInvoice">'+quantity+'</td>\
                    <td class="unit_priceEInvoice">'+unitPrice+'</td>\
                    <td class="taxesEInvoice" style="display:none;" >'+taxes+'</td>\
                    <td class="subtotalEInvoice">'+subTotal+'</td>\
                    <td class="netAmountEInvoice">'+netAmountEInvoice+'</td>\
                    <td><a href="javascript:void(0);" class="remCF1EditInvoice">\
                            <i class="mdi mdi-delete"></i>\
                        </a>\
                    </td>\
                </tr>');
            }
            calculateEInvoice();

            $('#productNameEInvoice').val('');
            $('#productIdEInvoice').val('');
            $('#productNameEInvoice1').val('');
            $('#varientEInvoice').val('');
            $('#categoryEInvoice').val('');
            $('#sku_CodeEInvoice').val('');
            $('#batch_CodeEInvoice').val('');
            $('#descriptionEInvoice').val('');
            $('#quantityEInvoice').val(0);
            $('#unitPriceEInvoice').val(0);
            $('#taxesEInvoice').val(0);
            $('#subTotalEInvoice').val(0);
            $('#netAmountEInvoice').val(0);
        });

        // select product quantity
        $(document).on('keyup', "input[id='quantityEInvoice']", function(e){

            let quantity = $(this).val();
            let price = $(this).closest('tr').find("input[id='unitPriceEInvoice']").val();
            let taxes = $(this).closest('tr').find("input[id='taxesEInvoice']").val();

            // +parseFloat(taxes)
            let subtotal = parseFloat(quantity)*parseFloat(price);
            $(this).closest('tr').find("input[id='subTotalEInvoice']").val(subtotal);

            // gst value 
            $gstValue = $('#gstValueInvoiceEdit').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxIncludeEditInvoice').prop('checked')){
                $('#netAmountEInvoice').val(subtotal+$totalGST);
            }else{
                $('#netAmountEInvoice').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxesEInvoice']").val($totalGST);

        });

        $('#taxIncludeEditInvoice').change(function(){
            calculateEInvoice();

            $("#productTableEditInvoiceBody > tr").each(function(e){
                    let unitPrice = $(this).find('.unit_priceEInvoice').text();
                    let taxes = $(this).find('.taxesEInvoice').text();
                    let subTotal = $(this).find('.subtotalEInvoice').text();
                    let netAmount = $(this).find('.netAmountEInvoice').text();

                    let amount = parseFloat(taxes)+parseFloat(subTotal);

                    if($('#taxIncludeEditInvoice').prop('checked')){
                        $(this).find('.netAmountEInvoice').text(amount);
                    }else{
                        $(this).find('.netAmountEInvoice').text(subTotal);
                    }
            });

        });

            $(document).on('change', "input[id='gstValueInvoiceEdit']", function(e){
                    let tax = parseFloat($(this).val());
                    // console.log(tax);

                    let quantity = $('#quantityEInvoice').val();
                    // console.log(quantity);
                    let price = $('#unitPriceEInvoice').val();
                    // console.log(price);
                    let taxes = ((parseFloat(quantity)*parseFloat(price))*parseFloat(tax))/100;
                    // console.log(taxes);

                    $('#taxesEInvoice').val(taxes);

                    // +parseFloat(taxes)
                    let subtotal = parseFloat(quantity)*parseFloat(price);
                    // console.log(subtotal);
                    $('#subTotalEInvoice').val(subtotal);
                    // console.log('---------------------------------------------------');

                    if($('#taxIncludeEditInvoice').prop('checked')){
                        // console.log(subtotal+taxes);
                        $('#netAmountEInvoice').val(subtotal+taxes);
                    }else{
                        // console.log(subtotal);
                        $('#netAmountEInvoice').val(subtotal);
                    }

                    $("#productTableEditInvoiceBody > tr").each(function(e){
                        let unitPrice = $(this).find('.unit_priceEInvoice').text();
                        let quantity = $(this).find('.product_quantityEInvoice').text();

                        let taxes = ((parseFloat(quantity)*parseFloat(unitPrice))*parseFloat(tax))/100;

                        // let taxes = $(this).find('.taxes').text();
                        $(this).find('.taxesEInvoice').text(taxes);
                        let subTotal = $(this).find('.subtotalEInvoice').text();
                        let netAmount = $(this).find('.netAmountEInvoice').text();

                        let amount = parseFloat(taxes)+parseFloat(subTotal);

                        if($('#taxIncludeEditInvoice').prop('checked')){
                            $(this).find('.netAmountEInvoice').text(amount);
                        }else{
                            $(this).find('.netAmountEInvoice').text(subTotal);
                        }
                    });
                    calculateEInvoice();
                });

        function calculateEInvoice(){
            let sum = 0;
            let tax = 0;
            let i = 0;

            $("#productTableEditInvoiceBody tr .subtotalEInvoice").each(function(){
                sum += parseFloat($(this).text());
            });

            $('#untaxtedAmountEInvoice').val(sum);
            $('#untaxtedAmountEInvoice1').val(sum);

            $('#invoiceETotal').val(sum);
            $('#invoiceETotal1').val(sum);

            $("#productTableEditInvoiceBody tr .taxesEInvoice").each(function(){
                tax += parseFloat($(this).text());
            });

            $('#gstEInvoice').val(tax.toFixed(2));
            $('#gstEInvoice1').val(tax.toFixed(2));

                // $('#taxIncludeEditInvoice').change(function(){
                    if($('#taxIncludeEditInvoice').prop('checked')){
                        let untaxtedAmount = parseFloat($('#untaxtedAmountEInvoice').val());
                        let totalBill = untaxtedAmount+tax;

                        $('#invoiceETotal').val(totalBill);
                        $('#invoiceETotal1').val(totalBill);
                    }else{
                        let untaxtedAmount = parseFloat($('#untaxtedAmountEInvoice').val());
                        let totalBill = untaxtedAmount;

                        $('#gstEInvoice').val('');

                        $('#invoiceETotal').val(totalBill);
                        $('#invoiceETotal1').val(totalBill);
                    }
                // });

        };

        
        $(document).on('click','.remCF1EditInvoice',function(){
            $(this).parent().parent().remove();
            calculateEInvoice();
            $('#myTable tbody tr').each(function(i){            
                $($(this).find('td')[0]).html(i+1);
            });
        });


        // store data to database
            jQuery("#salesEditInvoiceForm").submit(function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                });

                allProductDetailsEInvoice.splice(0, allProductDetailsEInvoice.length);
                
                $("#productTableEditInvoiceBody > tr").each(function(e){
                    let product_Id = $(this).find('.product_IdEInvoice').text();
                    let productName = $(this).find('.product_nameEInvoice').text();
                    let varient = $(this).find('.product_varientEInvoice').text();
                    let category = $(this).find('.product_categoryEInvoice').text();
                    let sku_code = $(this).find('.sku_CodeEInvoice').text();
                    let batch_code = $(this).find('.batch_CodeEInvoice').text();
                    let description = $(this).find('.product_descEInvoice').text();
                    let quantity = $(this).find('.product_quantityEInvoice').text();
                    let unitPrice = $(this).find('.unit_priceEInvoice').text();
                    let taxes = $(this).find('.taxesEInvoice').text();
                    let subTotal = $(this).find('.subtotalEInvoice').text();
                    let netAmount = $(this).find('.netAmountEInvoice').text();

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
                    allProductDetailsEInvoice.push(dbData);
                    
                });        
                
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('SA-UpdateInvoice') }}",
                            data: jQuery("#salesEditInvoiceForm").serialize()+"&allProductDetails="+JSON.stringify(allProductDetailsEInvoice),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function (result) {

                                sales_invoice_main_table.ajax.reload();

                                if(result.error !=null ){
                                    errorMsg(result.error);
                                }
                                else if(result.barerror != null){
                                    jQuery("#editInvoiceAlert").hide();
                                    errorMsg(result.barerror);
                                    jQuery(".salesQuantityInvoiceErrorEdit").hide();
                                }
                                else if(result.success != null){
                                    jQuery(".alert-danger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#salesInvoiceForm")["0"].reset();
                                    sales_invoice_main_table.ajax.reload();
                                    jQuery(".salesQuantityInvoiceErrorEdit").hide();
                                    getQuotationDetails();
                                }
                                else if(result.salesQuantityInvoiceErrorEdit != null){
                                    errorMsg(result.salesQuantityInvoiceErrorEdit);
                                    jQuery("#productTableEditInvoiceBody").html('');
                                }
                                else {
                                    jQuery(".alert-danger").hide();
                                    jQuery("#editInvoiceAlert").hide();
                                    jQuery(".salesQuantityInvoiceErrorEdit").hide();
                                }
                            },
                        });
                    }
                });
            });
</script>