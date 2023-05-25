<!-- Modal -->
<style>
    input[type="checkbox"][readonly] {
        pointer-events: none;
    }
</style>

<div class="modal fade" id="createInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Invoice</h5>
                <button type="button" class="close" id="gio" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="salesInvoiceForm">
                <div class="modal-body bg-white px-3">
                    <!-- invoice body start here -->

                    <!-- info & alert section -->
                    <div class="alert alert-success alert-dismissible fade show" id="addInvoiceAlert" style="display:none" role="alert">
                        <strong> </strong> <span id="addInvoiceAlertMSG"></span>
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="alert alert-danger alert-dismissible fade show" id="addInvoiceAlertDanger" style="display:none" role="alert">
                        <strong> </strong> <span id="addInvoiceAlertDangerMSG"></span>
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- end -->


                    <!-- row 0 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="quotationno1">Create Invoice<span style="color: red; font-size:small;">*</span></label>
                            <select name="create_invoice_by" id="create_invoice_by" class="form-control" onchange="changeSalesInvoiceInputFn()">
                                <option value="">Select ...</option>
                                <option value="manual">By Manual</option>
                                <option value="byQuotation">By Sales Order No.</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3">
                                <span class="text-secondary" style="font-size:small">By Sales Order No. : To Generate by already generated sales order.</span>
                                <br>
                                <span class="text-secondary" style="font-size:small">By Manual : To Generate Manual Invoice.</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customerName">Order No.</label>
                            <select name="quotationNumber" onchange="getQuotationDetailsInvoice()" id="quotationNumber" class="form-control text-dark" disabled>
                                <option value="">Select Order No.</option>
                            </select>
                            <input class="form-control" type="text" id="quotat_id" name="unQutNo" style="display: none;">
                        </div>
                        <div class="col-md-6">
                            <label for="expiration">Invoice No.</label>
                            <input type="text" class="form-control text-dark" name="refNextQColumn" id="refNextColumn" placeholder="Invoice Number" disabled />
                        </div>
                        <span id="orderInvoiceIdAlert" style="color:red; font-size:small;display:none;">*One field is required in above fields.</span>
                    </div>

                    <!-- row 2 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customerName">Customer Name<span style="color: red; font-size:small;">*</span></label>
                            <input type="hidden" class="form-control" name="invoiceCustomer_id" id="invoiceCustomer_id" readonly placeholder="customer id" />
                            <select name="customerName" onchange="fetchCustomerNameInvoice()" class="form-control" id="customerNameInvoice" disabled></select>
                        </div>
                        <div class="col-md-6">
                            <label for="expiration">Invoice Date<span style="color: red; font-size:small;">*</span></label>
                            <input type="date" name="invoiceDate" class="form-control text-dark" id="invoiceDate" value="<?= date('dd-mm-yyyy') ?>" placeholder="Invoice Date">
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="customerName">Payment Reference<span style="color: red; font-size:small;">*</span></label>
                            <input type="text" name="paymentReference" class="form-control text-dark" id="pymentReference" placeholder="Payment Reference">
                        </div>
                        <div class="col-md-3">
                            <label for="expiration">Due Date</label>
                            <input type="date" name="dueDate" class="form-control text-dark" id="invoiceDueDate" />
                            <span id="orderInvoiceIdAlert2" style="color:red; font-size:small;display:none;">*One field is required in above fields.</span>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="mx-auto fw-bolder bg-dark p-1 rounded text-white">OR</div>
                        </div>
                        <div class="col-md-3">
                            <label for="expiration"></label>
                            <select name="selectTerms" id="selectTermsInvoice" class="form-control form-control-lg text-dark">
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
                                        <label for="taxInclude" class="text-primary form-control"><input type="checkbox" name="taxInclude" id="taxIncludeInvoice"> Tax Inclusive</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="gstValue" value="7" id="gstValueInvoice" min="1" placeholder="GST (In %)" />
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
                    <h6 class="salesQuantityInvoiceError alert alert-warning" style="display: none;"></h6>
                    <div class="form-group row">
                        <div class="col">
                            <fieldset class="border border-secondary p-2">
                                <legend class="float-none w-auto p-2">Invoice Details</legend>
                                <span style="color:red; font-size:small;" id="createinvoicetableEmptyError"></span>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table border" id="products">
                                        <thead>
                                            <tr>
                                                <th class="p-2 border border-secondary">Product Name</th>
                                                <!-- <th class="p-2 border border-secondary">Id</th>    -->
                                                <th class="p-2 border border-secondary">Variant</th>
                                                <th class="p-2 border border-secondary">Category</th>
                                                <th class="p-2 border border-secondary">SKU Code</th>
                                                <th class="p-2 border border-secondary">Batch Code</th>
                                                <th class="p-2 border border-secondary">Description</th>
                                                <th class="p-2 border border-secondary">Quantity</th>
                                                <th class="p-2 border border-secondary">Unit Price</th>
                                                <!-- <th class="p-2 border border-secondary">Taxes</th> -->
                                                <th class="p-2 border border-secondary">Gross Amount</th>
                                                <th class="p-2 border border-secondary">Net Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody class="invoiceBody">
                                            <tr>
                                                <form id="addProductForm0">
                                                    <!-- product -->
                                                    <td class="p-2 border border-secondary">
                                                        <select name="productName" id="productNameInvoice" onchange="selectProductInvoiceFunction()" class="form-control form-control-lg">
                                                            <option value="">Select Product</option>
                                                        </select>
                                                    </td>
                                                    <!-- productId -->
                                                    <!-- hide content -->
                                                    <td class="p-2 border border-secondary" style="display: none;">
                                                        <input type="text" id="productIdInvoice" class="form-control" placeholder="Id">
                                                        <input type="text" id="productNameInvoice1" class="form-control" placeholder="Id">
                                                    </td>
                                                    <!-- varient -->
                                                    <td class="p-2 border border-secondary">
                                                        <select name="varient" id="varientInvoice" class="form-control" onchange="selectVarientInvoiceFunction()">
                                                            <option value="">Select Variant</option>
                                                        </select>
                                                    </td>
                                                    <!-- category -->
                                                    <td class="p-2 border border-secondary">
                                                        <input type="text" name="category" id="categoryInvoice" class="form-control" placeholder="Category" disabled />
                                                    </td>
                                                    <!-- sku code -->
                                                    <td class="p-2 border border-secondary">
                                                        <input type="text" name="sku_Code" id="sku_CodeInvoice" class="form-control" placeholder="SKU Code" disabled />
                                                    </td>
                                                    <!-- batch code -->
                                                    <td class="p-2 border border-secondary">
                                                        <select name="batch_Code" id="batch_CodeInvoice" class="form-control">
                                                            <option value="">Select Batch Code</option>
                                                        </select>
                                                    </td>
                                                    <!-- Description -->
                                                    <td class="p-2 border border-secondary">
                                                        <input type="text" name="description" id="descriptionInvoice" class="form-control" placeholder="Description">
                                                    </td>
                                                    <!-- Quantity -->
                                                    <td class="p-2 border border-secondary">
                                                        <input type="text" name="quantity" id="quantityInvoice" value="0" class="form-control" placeholder="Quantity">
                                                    </td>
                                                    <!-- unit price -->
                                                    <td class="p-2 border border-secondary">
                                                        <input type="text" name="unitPrice" id="unitPriceInvoice" value="0" class="form-control" placeholder="Unit Price" disabled />
                                                    </td>
                                                    <!-- taxes -->
                                                    <td class="p-2 border border-secondary" style="display: none;">
                                                        <input type="text" name="taxes" id="taxesInvoice" class="form-control" value="0" placeholder="Taxes" disabled />
                                                    </td>
                                                    <!-- sub total -->
                                                    <td class="p-2 border border-secondary">
                                                        <input type="text" name="subTotal" id="subTotalInvoice" class="form-control" value="0" placeholder="Sub Total" disabled />
                                                    </td>
                                                    <!-- net amount -->
                                                    <td class="p-2 border border-secondary">
                                                        <input type="text" name="netAmount" id="netAmountInvoice" class="form-control" value="0" placeholder="Net Amount" disabled />
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a name="addLine" id="addProductInvoice" class="btn btn-primary text-white">Add Product</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table text-center border" id="productTableInvoice" style="width: 100%; border-collapse: collapse;">
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
                                        <tbody id="productTableInvoiceBody"></tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                            <input type="text" name="notes" id="notesSInvoice" class="form-control" placeholder="Add an Internal Note" />
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
                                            <input type="text" name="untaxtedAmountInvoice" id="untaxtedAmountInvoice" class="form-control" placeholder="Sub Total" disabled>
                                            <input type="text" name="untaxtedAmountInvoice1" id="untaxtedAmountInvoice1" class="form-control" placeholder="Sub Total" style="display: none;">
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
                                            <input type="text" name="GST" id="gstInvoice" class="form-control" placeholder="GST" disabled>
                                            <input type="text" name="GST1" id="gstInvoice1" class="form-control" placeholder="GST" style="display: none;">
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
                                            <input type="text" id="invoiceTotal" name="invoiceTotal" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                                            <input type="text" id="invoiceTotal1" name="invoiceTotal1" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end here -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="createInvoiceClearFormBt">Clear</button>
                    <button type="submit" id="salesInvoiceForm1" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document.body).delegate('[type="checkbox"][readonly="readonly"]', 'click', function(e) {
        e.preventDefault();
    });


    function changeSalesInvoiceInputFn() {
        getQuotationNum();
        if ($('#create_invoice_by').val() == 'manual') {

            $('#quotationNumber').attr('disabled', true);
            $('#quotationNumber').val('');
            $('#refNextColumn').removeAttr('disabled');
            jQuery("#salesInvoiceForm")["0"].reset();
            jQuery("#productTableInvoiceBody").html('');
            $('#create_invoice_by').val('manual');
            $('#customerNameInvoice').removeAttr('disabled');

            $('#taxIncludeInvoice').attr('readonly', false);
            $('#gstValueInvoice').attr('readonly', false);

        } else if ($('#create_invoice_by').val() == 'byQuotation') {

            getQuotationNum();

            $('#refNextColumn').attr('disabled', true);
            $('#refNextColumn').val('');
            $('#quotationNumber').removeAttr('disabled');
            jQuery("#salesInvoiceForm")["0"].reset();
            jQuery("#productTableInvoiceBody").html('');
            $('#create_invoice_by').val('byQuotation');
            $('#customerNameInvoice').removeAttr('disabled');

            $('#taxIncludeInvoice').attr('readonly', true);
            $('#gstValueInvoice').attr('readonly', true);

        } else {

            $('#productNameOrders2').attr('disabled', true);
            $('#refNextColumn').attr('disabled', true);
            $('#quotationNumber').attr('disabled', true);
            jQuery("#salesInvoiceForm")["0"].reset();
            jQuery("#productTableInvoiceBody").html('');
            $('#customerNameInvoice').attr('disabled', true);

            $('#taxIncludeInvoice').attr('readonly', false);
            $('#gstValueInvoice').attr('readonly', false);

        }

        getCustomerInvoice();

    }


    function selectProductInvoiceFunction() {
        let id = this.event.target.id;
        let pro = $('#' + id).val();

        $('#categoryInvoice').val('');
        $('#sku_CodeInvoice').val('');
        $('#batch_CodeInvoice').val('');
        $('#descriptionInvoice').val('');
        $('#quantityInvoice').val(0);
        $('#unitPriceInvoice').val(0);
        $('#taxesInvoice').val(0);
        $('#subTotalInvoice').val(0);
        $('#netAmountInvoice').val(0);

        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetNameProducts')}}",
            data: {
                "val": pro,
            },
            success: function(response) {

                // console.log(response);

                $('#varientInvoice').html('');
                $('#varientInvoice').append('<option value="">Select Variant</option>');
                jQuery.each(response, function(key, value) {

                    if ($('#productTableInvoice tbody > tr').length == 0) {
                        $('#varientInvoice').append(
                            '<option value="' + value["product_varient"] + '">\
                                                        ' + value["product_varient"] + '\
                                                    </option>'
                        );
                    } else {
                        let count = 0;
                        $("#productTableInvoiceBody tr").each(function() {
                            let proName = $(this).find('.product_nameInvoice').text();
                            let proVarient = $(this).find('.product_varientInvoice').text();

                            if (proName == value['product_name'] && proVarient == value['product_varient']) {
                                ++count;
                            }
                        });

                        if (count == 0) {
                            $('#varientInvoice').append(
                                '<option value="' + value["product_varient"] + '">\
                                                            ' + value["product_varient"] + '\
                                                        </option>'
                            );
                        }
                    }
                });
            }
        });
    };

    function selectVarientInvoiceFunction() {
        let id = this.event.target.id;
        let varient = $('#' + id).val();
        let product = $('#productNameInvoice').val();
        let customerId = $('#customerNameInvoice').val();

        $('#categoryInvoice').val('');
        $('#sku_CodeInvoice').val();
        $('#batch_CodeInvoice').val();
        $('#descriptionInvoice').val('');
        $('#quantityInvoice').val(0);
        $('#unitPriceInvoice').val(0);
        $('#taxesInvoice').val(0);
        $('#subTotalInvoice').val(0);
        $('#netAmountInvoice').val(0);

        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchProductsDetialsInfo')}}",
            data: {
                // "product": product,
                // "varient": varient,
                "id": customerId,
            },
            success: function(response) {

                console.log('sales order invoice', response);

                jQuery.each(response, function(key, value) {
                    if (value['product_name'] === product && value['varient'] === varient) {
                        // product id
                        $('#' + id).closest('tr').find("input[id='productIdInvoice']").val(value["id"]);
                        // sku code
                        $('#' + id).closest('tr').find("input[id='sku_CodeInvoice']").val(value["sku_code"]);
                        // batch code
                        // $('#'+id).closest('tr').find("input[id='batch_CodeInvoice']").val(value["batch_code"]);
                        $.ajax({
                            type: "GET",
                            url: "{{ route('SA-SalesAllBatchCode')}}",
                            data: {
                                "proName": value['product_name'],
                                "proVariant": value['varient'],
                            },
                            success: function(response) {
                                // console.log('batchcode', response);
                                $('#batch_CodeInvoice').html('');
                                $('#batch_CodeInvoice').append('<option value="">Select Batch Code</option>');
                                jQuery.each(response, function(k, v) {
                                    $('#batch_CodeInvoice').append(`
                                                            <option value="${v['batch_code']}">${v['batch_code']}</option>
                                                        `);
                                });
                            }
                        });
                        // category
                        $('#' + id).closest('tr').find("input[id='categoryInvoice']").val(value["category"]);
                        // productNameReq
                        $('#' + id).closest('tr').find("input[id='productNameInvoice1']").val(value["product_name"]);
                        // unit price
                        $('#' + id).closest('tr').find("input[id='unitPriceInvoice']").val(value["unit_price"]);
                    }
                });
            }
        });
    }


    function getFilteredProducts(id) {
        // Special Price Filtered Products Detials
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetFilteredProductsDetials')}}",
            data: {
                "id": id
            },
            success: function(response) {

                filterdProductArrayInvoice = response;

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

                $('#netAmountInvoice').val(0);

                $('#productNameInvoice').html('');
                $('#productNameInvoice').append('<option value="">Select Product</option>');
                jQuery.each(response, function(key, value) {
                    
                    $('#productNameInvoice').append(
                        '<option value="' + value["product_name"] + '">\
                                            ' + value["product_name"] + '\
                                            </option>'
                    );

                });
            }
        });
    }


    // clear form
    jQuery('#createInvoiceClearFormBt').on('click', function() {
        jQuery("#salesInvoiceForm")["0"].reset();
        $('#taxIncludeInvoice').removeAttr('readonly');
        $('#gstValueInvoice').removeAttr('readonly');
    });

    // validation script start here
    $(document).ready(function() {

        getQuotationNum();
        // store data to database
        jQuery("#salesInvoiceForm").submit(function(e) {
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

                customerName: {
                    required: true,
                },

                invoiceDate: {
                    required: true,
                },

                paymentReference: {
                    required: true,
                    minlength: 1,
                },

                gstValue: {
                    min: 1,
                },
            },
            messages: {
                customerName: {
                    required: "Please enter customer name.",
                    minlength: "Please enter valid customer name.",
                    validate: "Please enter customer name."
                },
                expiration: {
                    required: "Expiration date required.",
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
            submitHandler: function() {


                if ($('#productTableInvoiceBody').children().length === 0) {
                    errorMsg('Please add products details');

                } else {
                    $('#createinvoicetableEmptyError').html('');

                    bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                        if (result) {

                            allProductDetailsInvoice.splice(0, allProductDetailsInvoice.length);
                            $("#productTableInvoiceBody > tr").each(function(e) {
                                let product_Id = $(this).find('.product_idInvoice').text();
                                let productName = $(this).find('.product_nameInvoice').text();
                                let varient = $(this).find('.product_varientInvoice').text();
                                let category = $(this).find('.product_categoryInvoice').text();
                                let sku_code = $(this).find('.sku_CodeInvoice').text();
                                let batch_code = $(this).find('.batch_CodeInvoice').text();
                                let description = $(this).find('.product_descInvoice').text();
                                let quantity = $(this).find('.product_quantityInvoice').text();
                                let unitPrice = $(this).find('.unit_priceInvoice').text();
                                let taxes = $(this).find('.taxesInvoice').text();
                                let subTotal = $(this).find('.subtotalInvoice').text();
                                let netAmount = $(this).find('.netAmountInvoice').text();

                                let dbData = {
                                    "product_Id": product_Id,
                                    "product_name": productName,
                                    "product_varient": varient,
                                    "category": category,
                                    "sku_code": sku_code,
                                    "batch_code": batch_code,
                                    "description": description,
                                    "taxes": taxes,
                                    "quantity": quantity,
                                    "unitPrice": unitPrice,
                                    "taxes": taxes,
                                    "subTotal": subTotal,
                                    "netAmount": netAmount
                                }
                                allProductDetailsInvoice.push(dbData);
                            });

                            jQuery.ajax({
                                url: "{{ route('SA-StoreInvoice') }}",
                                data: jQuery("#salesInvoiceForm").serialize() + "&allProductDetails=" + JSON.stringify(allProductDetailsInvoice),
                                enctype: "multipart/form-data",
                                type: "post",
                                success: function(result) {
                                    if (result.error != null) {
                                        $('#taxIncludeInvoice').removeAttr('readonly');
                                        $('#gstValueInvoice').removeAttr('readonly');
                                        errorMsg(result.error);
                                    } else if (result.barerror != null) {
                                        jQuery("#addInvoiceAlert").hide();
                                        errorMsg(result.barerror);
                                        $('#taxIncludeInvoice').removeAttr('readonly');
                                        $('#gstValueInvoice').removeAttr('readonly');
                                    } else if (result.success != null) {
                                        jQuery("#addInvoiceAlertDanger").hide();
                                        successMsg(result.success);
                                        $('.modal .close').click();
                                        jQuery("#salesInvoiceForm")["0"].reset();
                                        jQuery("#productTableInvoiceBody").html('');

                                        $('#taxIncludeInvoice').removeAttr('readonly');
                                        $('#gstValueInvoice').removeAttr('readonly');
                                        sales_invoice_main_table.ajax.reload();
                                        getQuotationDetailsorder();
                                        getQuotationDetails();
                                        getInvoiceNo();
                                    } else if (result.salesQuantityInvoiceError != null) {
                                        errorMsg(result.salesQuantityInvoiceError);
                                        jQuery("#productTableInvoiceBody").html('');
                                        $('#taxIncludeInvoice').removeAttr('readonly');
                                        $('#gstValueInvoice').removeAttr('readonly');
                                    } else {
                                        jQuery("#addInvoiceAlertDanger").hide();
                                        jQuery("#addInvoiceAlert").hide();
                                        $('#taxIncludeInvoice').removeAttr('readonly');
                                        $('#gstValueInvoice').removeAttr('readonly');
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


    // fetch all quotation number
    getQuotationNum();

    function getQuotationNum() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetAllinvoiceQuotations')}}",
            success: function(response) {
                $('#quotationNumber').html('');
                $('#quotationNumber').append('<option value="">Select Order Number</option>');
                jQuery.each(response, function(key, value) {
                    $('#quotationNumber').append(
                        '<option value="' + value["orderID"] + '">\
                            ' + value["quotation_id"] + '\
                            </option>'
                    );


                });

            }

        });
    }


    // get customer list
    getCustomerInvoice();

    function getCustomerInvoice() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-CustomersList')}}",
            success: function(response) {

                $('#customerNameInvoice').html('');
                $('#customerNameInvoice').append('<option value="">Select Customer</option>');

                jQuery.each(response, function(key, value) {
                    $('#customerNameInvoice').append(
                        '<option value="' + value["id"] + '">\
                                ' + value["customer_name"] + '\
                            </option>'
                    );
                });

            }
        });
    }


    // fetch unique customer detials
    function fetchCustomerNameInvoice() {
        let id = this.event.target.id;
        let pro = $('#' + id).val();

        $.ajax({
            type: "GET",
            data: {
                'id': pro,
            },
            url: "{{ route('SA-GetCustomerDetails1')}}",
            success: function(response) {
                jQuery.each(response, function(key, value) {
                    $('#invoiceCustomer_id').val(value["customer_name"]);
                    $('#invoiceCustomer_idEdit').val(value["customer_name"]);

                    // Special Price Filtered Products Detials
                    $.ajax({
                        type: "GET",
                        url: "{{ route('SA-GetFilteredProductsDetials')}}",
                        data: {
                            "id": value['id']
                        },
                        success: function(response) {

                            filterdProductArrayInvoice = response;
                            // console.log(filterdProductArrayInvoice);
                            // console.log(filterdProductArray);

                            $('#productNameInvoice').removeAttr('disabled');
                            $('#productNameInvoice').html('');

                            $('#productIdInvoice').val('');

                            $('#productNameInvoice1').val('');

                            $('#varient').val('');

                            $('#category').val('');

                            $('#description').val('');

                            $('#quantity').val(0);

                            $('#unitPrice').val(0);

                            $('#taxes').val(0);

                            $('#subTotal').val(0);

                            $('#netAmountInvoice').val(0);

                            $('#productNameInvoice').html('');
                            $('#productNameInvoice').append('<option value="">Select Product</option>');
                            jQuery.each(response, function(key, value) {
                                // product name dropdown in qotation form
                                $('#productNameInvoice').append(
                                    '<option value="' + value["product_name"] + '">\
                                            ' + value["product_name"] + '\
                                            </option>'
                                );
                            });
                        }
                    });
                });
            }
        });
    }

    // list quotation detials
    function getQuotationDetailsInvoice() {
        let id = this.event.target.value;

        jQuery("#productTableInvoiceBody").html('');
        getQuotationInfoInvoice(id);

        function getQuotationInfoInvoice(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetQuotation')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#quotat_id').val(value["quotation_id"]);

                        $('#quot_id').val(value["quotation_id"]);
                        $('#customerNameInvoice').val(value["customer_id"]);
                        $('#invoiceCustomer_id').val(value["customer_name"]);
                        $('#selectTermsInvoice').val(value["payment_terms"]);
                        $('#untaxtedAmountInvoice').val(parseFloat(value["untaxted_amount"]).toFixed(2));
                        $('#untaxtedAmountInvoice1').val(parseFloat(value["untaxted_amount"]).toFixed(2));
                        $('#gstInvoice').val(parseFloat(value["GST"]).toFixed(2));
                        if(value["GST"] != null){
                            $('#gstInvoice1').val(parseFloat(value["GST"]).toFixed(2));
                        }else{
                            $('#gstInvoice1').val(0);
                        }
                        
                        $('#gstValueInvoice').val(parseFloat(value["gstValue"]).toFixed(2));
                        $('#invoiceTotal').val(parseFloat(value["sub_total"]).toFixed(2));
                        $('#invoiceTotal1').val(parseFloat(value["sub_total"]).toFixed(2));
                        $('#notesSInvoice').val(value['note']);

                        // alert(value["customer_id"]);
                        getFilteredProducts(value["customer_id"]);

                        let sno = 0;

                        if (value["tax_inclusive"] == 1) {
                            $('#taxIncludeInvoice').prop('checked', true);
                        } else {
                            $('#taxIncludeInvoice').prop('checked', false);
                            $('#gstInvoice').val('');
                        }

                        $('#taxIncludeInvoice').attr('readonly', true);
                        $('#gstValueInvoice').attr('readonly', true);

                        let str = value["products_details"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value) {
                            $('#productTableInvoice tbody').append('<tr class="child">\
                                        <td>' + ++sno + '</td>\
                                        <td class="product_idInvoice" style="display:none;" >' + value["product_Id"] + '</td>\
                                        <td class="product_nameInvoice">' + value["product_name"] + '</td>\
                                        <td class="product_categoryInvoice">' + value["category"] + '</td>\
                                        <td class="product_varientInvoice">' + value["product_varient"] + '</td>\
                                        <td class="sku_CodeInvoice">' + value["sku_code"] + '</td>\
                                        <td class="batch_CodeInvoice">' + value["batch_code"] + '</td>\
                                        <td class="product_descInvoice">' + value["description"] + '</td>\
                                        <td class="product_quantityInvoice">' + value["quantity"] + '</td>\
                                        <td class="unit_priceInvoice">' + value["unitPrice"] + '</td>\
                                        <td class="taxesInvoice" style="display:none;" >' + value["taxes"] + '</td>\
                                        <td class="subtotalInvoice">' + value["subTotal"] + '</td>\
                                        <td class="netAmountInvoice">' + value["netAmount"] + '</td>\
                                        <td><a href="javascript:void(0);" class="remCF1AddInvoice">\
                                                <i class="mdi mdi-delete"></i>\
                                            </a>\
                                        </td>\
                                    </tr>');
                        });
                    });
                }
            });
        }
    };

    let allProductDetailsInvoice = [];

    // Table
    $('#addProductInvoice').on('click', function() {
        let productId = $('#productIdInvoice').val();
        let productName = $('#productNameInvoice1').val();
        let varient = $('#varientInvoice').val();
        let category = $('#categoryInvoice').val();
        let sku_code = $('#sku_CodeInvoice').val();
        let batch_code = $('#batch_CodeInvoice').val();
        let description = $('#descriptionInvoice').val();
        let quantity = $('#quantityInvoice').val();
        let unitPrice = $('#unitPriceInvoice').val();
        let taxes = $('#taxesInvoice').val();
        let subTotal = $('#subTotalInvoice').val();
        let netAmountInvoice = $('#netAmountInvoice').val();

        let count = $('#productTableInvoice tr').length;
        if (productName != "" && varient != "" && category != "" && batch_code != "" && quantity != "" && unitPrice != "" && taxes != "" && subTotal != "") {
            $('#productTableInvoice tbody').append('<tr class="child">\
                                                <td>' + count + '</td>\
                                                <td class="product_idInvoice" style="display:none;" >' + productId + '</td>\
                                                <td class="product_nameInvoice">' + productName + '</td>\
                                                <td class="product_categoryInvoice">' + category + '</td>\
                                                <td class="product_varientInvoice">' + varient + '</td>\
                                                <td class="sku_CodeInvoice">' + sku_code + '</td>\
                                                <td class="batch_CodeInvoice">' + batch_code + '</td>\
                                                <td class="product_descInvoice">' + description + '</td>\
                                                <td class="product_quantityInvoice">' + quantity + '</td>\
                                                <td class="unit_priceInvoice">' + unitPrice + '</td>\
                                                <td class="taxesInvoice" style="display:none;" >' + taxes + '</td>\
                                                <td class="subtotalInvoice">' + subTotal + '</td>\
                                                <td class="netAmountInvoice">' + netAmountInvoice + '</td>\
                                                <td><a href="javascript:void(0);" class="remCF1AddInvoice">\
                                                        <i class="mdi mdi-delete"></i>\
                                                    </a>\
                                                </td>\
                                            </tr>');
            calculateInvoice();
            if ($('#productTableInvoiceBody').children().length === 0) {

            } else {
                $('#createinvoicetableEmptyError').html('');
            }
        } else {

            errorMsg('Please select products in form.');

            if ($('#productTableInvoiceBody').children().length === 0) {
                
                errorMsg('Please add products details.');

            } else {
                $('#createinvoicetableEmptyError').html('');
            }
        }

        $('#productNameInvoice').val('');
        $('#productIdInvoice').val('');
        $('#productNameInvoice1').val('');
        $('#varientInvoice').val('');
        $('#categoryInvoice').val('');
        $('#sku_CodeInvoice').val();
        $('#batch_CodeInvoice').val();
        $('#descriptionInvoice').val('');
        $('#quantityInvoice').val(0);
        $('#unitPriceInvoice').val(0);
        $('#taxesInvoice').val(0);
        $('#subTotalInvoice').val(0);
        $('#netAmountInvoice').val(0);

        fetchCustomerNameInvoice();

    });

    // select product quantity
    $(document).on('keyup', "input[id='quantityInvoice']", function(e) {

        let quantity = $(this).val();
        let price = $(this).closest('tr').find("input[id='unitPriceInvoice']").val();
        let taxes = $(this).closest('tr').find("input[id='taxesInvoice']").val();

        // +parseFloat(taxes)
        let subtotal = parseFloat(quantity) * parseFloat(price);
        $(this).closest('tr').find("input[name='subTotal']").val(subtotal);

        // gst value 
        $gstValue = $('#gstValueInvoice').val();
        $price = subtotal;
        $totalGST = ($price * $gstValue) / 100;

        if ($('#taxIncludeInvoice').prop('checked')) {
            $('#netAmountInvoice').val(subtotal + $totalGST);
        } else {
            $('#netAmountInvoice').val(subtotal);
        }

        $(this).closest('tr').find("input[id='taxesInvoice']").val($totalGST);

    });

    $(document).on('change', "input[id='gstValueInvoice']", function(e) {
        let tax = parseFloat($(this).val());
        // console.log(tax);

        let quantity = $('#quantityInvoice').val();
        // console.log(quantity);
        let price = $('#unitPriceInvoice').val();
        // console.log(price);
        let taxes = ((parseFloat(quantity) * parseFloat(price)) * parseFloat(tax)) / 100;
        // console.log(taxes);

        $('#taxesInvoice').val(taxes);

        // +parseFloat(taxes)
        let subtotal = parseFloat(quantity) * parseFloat(price);
        // console.log(subtotal);
        $('#subTotalInvoice').val(subtotal);
        // console.log('---------------------------------------------------');

        if ($('#taxIncludeInvoice').prop('checked')) {
            // console.log(subtotal+taxes);
            $('#netAmountInvoice').val(subtotal + taxes);
        } else {
            // console.log(subtotal);
            $('#netAmountInvoice').val(subtotal);
        }

        $("#productTableInvoiceBody > tr").each(function(e) {
            let unitPrice = $(this).find('.unit_priceInvoice').text();
            let quantity = $(this).find('.product_quantityInvoice').text();

            let taxes = ((parseFloat(quantity) * parseFloat(unitPrice)) * parseFloat(tax)) / 100;

            // let taxes = $(this).find('.taxes').text();
            $(this).find('.taxesInvoice').text(taxes);
            let subTotal = $(this).find('.subtotalInvoice').text();
            let netAmount = $(this).find('.netAmountInvoice').text();

            let amount = parseFloat(taxes) + parseFloat(subTotal);

            if ($('#taxIncludeInvoice').prop('checked')) {
                $(this).find('.netAmountInvoice').text(amount);
            } else {
                $(this).find('.netAmountInvoice').text(subTotal);
            }
        });
        calculateInvoice();
    });

    $('#taxIncludeInvoice').change(function() {

        let tax = parseFloat($('#gstValueInvoice').val());
        // console.log(tax);

        let quantity = $('#quantityInvoice').val();
        // console.log(quantity);
        let price = $('#unitPriceInvoice').val();
        // console.log(price);
        let taxes = ((parseFloat(quantity) * parseFloat(price)) * parseFloat(tax)) / 100;
        // console.log(taxes);

        // +parseFloat(taxes)
        let subtotal = parseFloat(quantity) * parseFloat(price);
        // console.log(subtotal);
        $('#subTotalInvoice').val(subtotal);
        // console.log('---------------------------------------------------');

        if ($('#taxIncludeInvoice').prop('checked')) {
            // console.log(subtotal+taxes);
            $('#netAmountInvoice').val(subtotal + taxes);
        } else {
            // console.log(subtotal);
            $('#netAmountInvoice').val(subtotal);
        }

        $("#productTableInvoiceBody > tr").each(function(e) {
            let unitPrice = $(this).find('.unit_priceInvoice').text();
            let taxes = $(this).find('.taxesInvoice').text();
            let subTotal = $(this).find('.subtotalInvoice').text();
            let netAmount = $(this).find('.netAmountInvoice').text();

            let amount = parseFloat(taxes) + parseFloat(subTotal);

            if ($('#taxIncludeInvoice').prop('checked')) {
                $(this).find('.netAmountInvoice').text(amount);
            } else {
                $(this).find('.netAmountInvoice').text(subTotal);
            }
        });

        calculateInvoice();
    });

    function calculateInvoice() {
        let sum = 0;
        let tax = 0;
        let i = 0;

        $("#productTableInvoiceBody tr .subtotalInvoice").each(function() {
            sum += parseFloat($(this).text());
        });

        $('#untaxtedAmountInvoice').val(sum);
        $('#untaxtedAmountInvoice1').val(sum);
        $('#invoiceTotal').val(sum);
        $('#invoiceTotal1').val(sum);


        $("#productTableInvoiceBody tr .taxesInvoice").each(function() {
            tax += parseFloat($(this).text());
        });

        // $('#gstInvoice').val(tax);
        // $('#gstInvoice1').val(tax);

        if ($('#taxIncludeInvoice').prop('checked')) {
            let untaxtedAmount = parseFloat($('#untaxtedAmountInvoice').val());
            let totalBill = untaxtedAmount + tax;
            $('#gstInvoice').val(tax.toFixed(2));
            $('#gstInvoice1').val(tax.toFixed(2));
            $('#invoiceTotal').val(totalBill.toFixed(2));
            $('#invoiceTotal1').val(totalBill.toFixed(2));
        } else {
            let untaxtedAmount = parseFloat($('#untaxtedAmountInvoice').val());
            let totalBill = untaxtedAmount;

            $('#gstInvoice').val('');

            $('#invoiceTotal').val(totalBill.toFixed(2));
            $('#invoiceTotal1').val(totalBill.toFixed(2));
        }
    };

    $(document).on('click', '.remCF1AddInvoice', function() {
        $(this).parent().parent().remove();
        $('#myTable tbody tr').each(function(i) {
            $($(this).find('td')[0]).html(i + 1);
        });
        calculateInvoice();
    });
</script>