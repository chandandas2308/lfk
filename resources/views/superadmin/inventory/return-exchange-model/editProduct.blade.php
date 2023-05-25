<!-- Modal -->
<div class="modal fade" id="editProductReturnExchange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-success alert-dismissible fade show" id="editProductInReturnExchangeSuccessAlert"
                role="alert" style="display: none;">
                <strong> <span id="editProductInReturnExchangeSuccessMSG"></strong></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-danger alert-dismissible fade show" id="editProductReturnExchangeErrorAlert"
                style="display:none" role="alert">
                <strong> <span id="editProductReturnExchangeErrorMSG"></strong></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- end -->



            <form method="post" id="editProductRandExchangeForm">
                <div class="modal-body bg-white px-3">
                    <!-- invoice body start here -->

                    <input type="text" name="reuniqueId" id="reuniqueId" style="display: none;">

                    <!-- row 0 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="edit-re-type" class="col-form-label">Type</label>
                            <input type="text" name="type" id="edit-re-type" class="form-control text-dark"
                                readonly />
                        </div>
                        <div class="col-md-6">
                            <label for="edit_user_name_re" class="col-form-label">Customer/Vendor Name</label>
                            <input type="text" name="user" id="edit_user_name_re" class="form-control text-dark"
                                readonly />
                            <input type="text" name="user_name" id="edit_user_nameRE" class="user_name"
                                style="display: none;" />
                        </div>
                    </div>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="edit-re-invoice" class="col-form-label">Invoice No.</label>
                            <input type="text" name="invoiceNo" id="edit-re-invoice" class="form-control text-dark"
                                readonly />
                        </div>
                        <div class="col-md-4">
                            <label for="edit_invoice_date_re" class="col-form-label">Invoice Date</label>
                            <input type="date" name="invoice_date" id="edit_invoice_date_re"
                                class="form-control text-dark" readonly />
                        </div>
                        <div class="col-md-4">
                            <label for="edit_invoice_amount_re" class="col-form-label">Invoice Amount</label>
                            <input type="text" name="invoice_Amount" id="edit_invoice_amount_re" class="form-control text-dark" placeholder="Invoice Amount" readonly />
                        </div>
                    </div>

                    <div class="alert alert-danger alert-dismissible fade show" id="addProductReturnExchangeExitstAlert1"
                        style="display:none" role="alert">
                        <strong><span id="addProductReturnExchangeContent1"></strong></span>
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- row 5 -->
                    <div class="form-group row">
                        <div class="col">
                            <fieldset class="border border-secondary p-2">
                                <legend class="float-none w-auto p-2">Orders Details</legend>
                                <a onclick="editChooseInvoiceNoREDropDown()" href="javascript:void(0)" class="btn btn-primary text-white">Edit Product</a>
                                <span style="color:red; font-size:small;" id="tableREEmptyError"></span>

                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table border" id="products">
                                        <thead>
                                            <tr>
                                                <th class="border border-secondary">Product Name</th>
                                                <th class="border border-secondary">Product Variant</th>
                                                <th class="border border-secondary">Quantity</th>
                                                <th class="border border-secondary">Rate</th>
                                                <th class="border border-secondary">Total Amount</th>
                                                <th class="border border-secondary">Return & Exchange</th>
                                                <th class="border border-secondary">Return & Exchange Quantity</th>
                                                <th class="border border-secondary">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody class="invoiceBody">
                                            <tr>
                                                <form id="addProductForm0">
                                                    <!-- product -->
                                                    <td class="border border-secondary">
                                                        <select name="productName" id="editProductNameRAndE"
                                                            onchange="getEditOrderedProductInfo()"
                                                            class="form-control form-control-lg  text-dark"
                                                            disabled>
                                                            <option value="">Select Product</option>
                                                        </select>
                                                    </td>
                                                    <td class="border border-secondary">
                                                        <select name="productVariant" id="productVariantRAndE1"
                                                            onchange="getOrderedProductVariantInfo1()"
                                                            class="form-control form-control-lg  text-dark">
                                                            <option value="">Select Variant</option>
                                                        </select>
                                                    </td>
                                                    <!-- productId -->
                                                    <!-- hide content -->
                                                    <td class="border border-secondary" style="display:none;">
                                                        <input type="text" name="editProduct_name_re"
                                                            id="editProduct_name_re"
                                                            class="form-control  text-dark" />
                                                        <input type="text" name="product_id"
                                                            id="edit_product_id_re" class="form-control  text-dark" />
                                                    </td>
                                                    <!-- Quantity -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="quantity" id="edit_order_qty"
                                                            class="form-control  text-dark" placeholder="Quantity"
                                                            readonly />
                                                    </td>
                                                    <!-- Rate -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="Rate"
                                                            id="edit_product_rate_Re" class="form-control text-dark"
                                                            placeholder="Rate" readonly />
                                                    </td>
                                                    <!-- Total Amount -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="totalAmount"
                                                            id="edit_total_order_amount_re"
                                                            class="form-control text-dark" placeholder="Total Amount"
                                                            readonly />
                                                    </td>
                                                    <!-- return & exchange -->
                                                    <td class="border border-secondary">
                                                        <select name="edit_return_and_exchange"
                                                            id="edit_return_and_exchange"
                                                            class="form-control text-dark">
                                                            <option value="">Choose status</option>
                                                            <option value="return">Return</option>
                                                            <option value="exchange">Exchange</option>
                                                        </select>
                                                    </td>
                                                    <!-- return & exhcange qty-->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="returnAndExhcangeRe"
                                                            id="edit_return_exchange_re"
                                                            class="form-control text-dark"
                                                            placeholder="Return/Exchange Quantity">
                                                    </td>
                                                    <!-- Remark -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="remark" id="edit_remark_re"
                                                            class="form-control text-dark"
                                                            placeholder="Remarks">
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a name="addLine" id="addProductEditReturnExchangeBtn"
                                                        class="btn btn-primary text-white">Add Product</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table text-center border" id="productRETableEdit">
                                        <thead>
                                            <tr>
                                                <th class="border border-secondary">S/N</th>
                                                <th class="border border-secondary">Product Name</th>
                                                <th class="border border-secondary">Product Variant</th>
                                                <th class="border border-secondary">Quantity</th>
                                                <th class="border border-secondary">Rate</th>
                                                <th class="border border-secondary">Total Amount</th>
                                                <th class="border border-secondary">Return & Exchange</th>
                                                <th class="border border-secondary">Return & Exchange Quantity</th>
                                                <th class="border border-secondary">Remarks</th>
                                                <th class="border border-secondary">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productRETableEditBody"></tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        id="addProductReturnExchangeClearBtn">Clear</button>
                    <button type="submit" id="editProductRandExchangeForm1" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // clear form
    jQuery('#addProductReturnExchangeClearBtn').on('click', function() {
        jQuery("#editProductRandExchangeForm")["0"].reset();
    });

    // validation script start here
    $(document).ready(function() {

        // store data to database
        jQuery("#editProductRandExchangeForm").submit(function(e) {
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

                type: {
                    required: true,
                },

                user: {
                    required: true,
                },

                invoiceNo: {
                    required: true,
                },

            },

            messages: {
                type: {
                    required: "Choose the type...",
                },
                user: {
                    required: "Choose user...",
                },
                invoiceNo: {
                    required: "Choose invoice no. ...",
                },
            },

            submitHandler: function() {
                
                let allProductDetailsRandEInvoiceEdit = [];

                allProductDetailsRandEInvoiceEdit.splice(0, allProductDetailsRandEInvoiceEdit.length);

                $("#productRETableEditBody > tr").each(function(e) {
                    let productId = $(this).find('.product_idRETable').text();
                    let productName = $(this).find('.product_nameRETable').text();
                    let productVariant = $(this).find('.product_varientRETable').text();
                    let quantityRE = $(this).find('.quantity_RETable').text();
                    let unitPriceRE = $(this).find('.unit_price_RETable').text();
                    let subTotalRE = $(this).find('.sub_totalRETable').text();
                    let statusRE = $(this).find('.status_RETable').text();
                    let quantityRAE = $(this).find('.quantity_return_RETable').text();
                    let remarkRE = $(this).find('.edit_remark_RETable').text();
                    
                    let dbData = {
                        "product_Id": productId,
                        "product_name": productName,
                        "product_varient": productVariant,
                        "quantity": quantityRE,
                        "unit_price": unitPriceRE,
                        "subTotal": subTotalRE,
                        "status": statusRE,
                        "quantityRAC": quantityRAE,
                        "remark": remarkRE
                    }
                    allProductDetailsRandEInvoiceEdit.push(dbData);
                });
                                                      
                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('SA-EditREProducts') }}",
                            data: jQuery("#editProductRandExchangeForm").serialize() + "&allProductDetails=" + JSON
                                .stringify(allProductDetailsRandEInvoiceEdit),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function(result) {

                                if (result.error != null) {
                                    errorMsg(result.error);
                                } else if (result.barerror != null) {
                                    errorMsg(result.barerror);
                                } else if (result.success != null) {
                                    jQuery('.modal .close').click();
                                    successMsg(result.success);
                                    jQuery("#editProductRandExchangeForm")["0"].reset();
                                    jQuery("#productRETableEditBody").html('');
                                    return_exchange_main_table.ajax.reload();
                                    return_goods_main_table.ajax.reload();
                                    exchange_goods_main_table.ajax.reload();
                                } else {

                                    jQuery("#editProductReturnExchangeErrorAlert").hide();
                                    jQuery("#editProductInReturnExchangeSuccessAlert").hide();

                                }
                            },
                        });
                    }
                });

            }

        });
    });
    // end here


    // check type & fetch list out customer
    function editChooseType() {
        let type = $('#edit-re-type').val();

        $('#edit_user_name_re').removeAttr("disabled");

        if (type === "sale") {

            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetAllInvoiceForPayment') }}",
                success: function(response) {

                    $('#edit_user_name_re').html('');
                    $('#edit_user_name_re').append('<option value="">Choose User...</option>');
                    jQuery.each(response, function(key, value) {
                        $('#edit_user_name_re').append(
                            '<option value="' + value['customer_id'] + '">' + value[
                                'customer_name'] + '</option>'
                        );
                    });
                }
            });
        } else {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetAllInvoiceForReturnExchange') }}",
                success: function(response) {

                    $('#edit_user_name_re').html('');
                    $('#edit_user_name_re').append('<option value="">Choose User...</option>');
                    jQuery.each(response, function(key, value) {
                        $('#edit_user_name_re').append(
                            '<option value="' + value['vendor_id'] + '">' + value[
                                'vendor_name'] + '</option>'
                        );
                    });
                }
            });
        }
    }

    // check customer and fetch detials
    function editChooseUser() {
        let user_id = $('#edit_user_name_re').val();

        $('#edit-re-invoice').removeAttr("disabled");


        let type = $('#edit-re-type').val();


        if (type === "sale") {

            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCustomerDetails') }}",
                data: {
                    "id": user_id,
                },
                success: function(response) {
                    $.each(response, function(k, v) {
                        $('#edit_user_nameRE').val(v['customer_name']);
                    });
                }
            });
        } else {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetVendor') }}",
                data: {
                    "id": user_id,
                },
                success: function(response) {
                    $.each(response, function(k, v) {
                        $('#edit_user_nameRE').val(v['vendor_name']);
                    });
                }
            });
        }

        if (type === "sale") {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchAllInvoiceForPayments1') }}",
                data: {
                    "id": user_id
                },
                success: function(response) {
                    $('#edit-re-invoice').html('');
                    $('#edit-re-invoice').append('<option value="">Choose Invoice No.</option>');
                    jQuery.each(response, function(key, value) {
                        $('#edit-re-invoice').append(
                            '<option value=' + value["invoice_no"] + '>' + value["invoice_no"] +
                            '</option>'
                        );
                    });
                }
            });
        } else {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchAllInvoiceNoForPayments') }}",
                data: {
                    "id": user_id
                },
                success: function(response) {
                    $('#edit-re-invoice').html('');
                    $('#edit-re-invoice').append('<option value="">Choose Invoice No.</option>');
                    jQuery.each(response, function(key, value) {
                        $('#edit-re-invoice').append(
                            '<option value=' + value["id"] + '>' + value["id"] + '</option>'
                        );
                    });
                }
            });
        }
    }

    // choose invoice number to view all details
    // function editChooseInvoiceNoRE(){
    function editChooseInvoiceNoREDropDown() {
        let user_id = $('#edit-re-invoice').val();
        let type = $('#edit-re-type').val();

        $('#editProductNameRAndE').removeAttr('disabled');

        // $('#editProductNameRAndE').removeAttr("disabled");

        if (type === "sale") {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-InvoiceDetails') }}",
                data: {
                    "pro": user_id
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {

                        $('#edit_invoice_date_re').val(value['invoice_date']);
                        $('#edit_invoice_amount_re').val(value["total"]);

                        let str = value["products"];
                        let obj = JSON.parse(str);

                        $('#editProductNameRAndE').html('');
                        $('#editProductNameRAndE').append(
                            '<option value="">Choose Product Name...</option>');
                        jQuery.each(obj, function(key, value) {
                            $('#editProductNameRAndE').append(
                                '<option value="' + value['product_Id'] + '">' + value[
                                    'product_name'] + '</option>'
                            );
                        });

                    });
                }
            });
        } else {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchAllProductsDetials') }}",
                data: {
                    "pro": user_id
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {



                        $('#edit_invoice_date_re').val(value['receipt_date']);
                        $('#edit_invoice_amount_re').val(value["total"]);

                        let str = value["products"];
                        let obj = JSON.parse(str);

                        $('#editProductNameRAndE').html('');
                        $('#editProductNameRAndE').append(
                            '<option value="">Choose Product Name...</option>');
                        jQuery.each(obj, function(key, value) {
                            $('#editProductNameRAndE').append(
                                '<option value="' + value['product_Id'] + '">' + value[
                                    'product_name'] + '</option>'
                            );
                        });

                    });
                }
            });
        }
    }

    let AllPurSaleInfo1 = [];

    function getEditOrderedProductInfo() {
        let namePro = $('#editProductNameRAndE').val();

        let user_id = $('#edit-re-invoice').val();
        let type = $('#edit-re-type').val();

        if (type === "sale") {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-InvoiceDetails') }}",
                data: {
                    "pro": user_id
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {

                        let str = value["products"];
                        let obj = JSON.parse(str);

                        AllPurSaleInfo1 = obj;

                        $('#productVariantRAndE1').html('');
                        $('#productVariantRAndE1').append('<option value="">Select Variant...</option>');
                        jQuery.each(obj, function(key, value) {

                            console.log('varient',value['product_varient']);

                            if(namePro == value['product_Id']){
                                $('#productVariantRAndE1').append(`
                                    <option value="${value['product_varient']}">${value['product_varient']}</option>
                                `);
                            }

                            // let qty = 0;
                            // $("#productRETableEditBody > tr").each(function(e) {
                            //     qty += parseInt($(this).find('.quantity_return_RETable').text());
                            // });

                            // if (id === value['product_Id']) {
                            //     $('#editProduct_name_re').val(value['product_name']);
                            //     $('#edit_product_id_re').val(value['product_Id']);
                            //     $('#edit_order_qty').val(parseInt(value['quantity'])-parseInt(qty));
                            //     $('#edit_product_rate_Re').val(value['unitPrice']);
                            //     $('#edit_total_order_amount_re').val(value['subTotal']);
                            // }

                        });

                    });
                }
            });
        } else {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchAllProductsDetials') }}",
                data: {
                    "pro": user_id
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {

                        let str = value["products"];
                        let obj = JSON.parse(str);

                        AllPurSaleInfo1 = obj;

                        $('#productVariantRAndE1').html('');
                        $('#productVariantRAndE1').append('<option value="">Select Variant...</option>');
                        jQuery.each(obj, function(key, value) {

                            if(namePro == value['product_Id']){
                                $('#productVariantRAndE1').append(`
                                    <option value="${value['product_varient']}">${value['product_varient']}</option>
                                `);
                            }
                            // if (id === value['product_Id']) {

                            //     let qty = 0;
                            //     $("#productRETableEditBody > tr").each(function(e) {
                            //         qty += parseInt($(this).find('.quantity_return_RETable').text());
                            //     });

                            //     $('#editProduct_name_re').val(value['product_name']);
                            //     $('#edit_product_id_re').val(value['product_Id']);
                            //     $('#edit_order_qty').val(parseInt(value['quantity'])-parseInt(qty));
                            //     $('#edit_product_rate_Re').val(value['unitPrice']);
                            //     $('#edit_total_order_amount_re').val(value['subTotal']);

                            // }

                        });

                    });
                }
            });
        }
    }


    function getOrderedProductVariantInfo1() {
        let namePro = $('#editProductNameRAndE').val();

        let user_id = $('#re-invoice').val();
        let type = $('#re-type').val();

        let variant = $('#productVariantRAndE1').val();

        // if (type == "sale")
        // {
            jQuery.each(AllPurSaleInfo1, function(key, value) {

                // alert(namePro);
                // alert(value['product_Id']);

                // alert(variant);
                // alert(value['product_varient']);

                if(namePro == value['product_Id'] && variant == value['product_varient']){

                    // alert('here');
                    let qty = 0;
                    $("#productRETableEditBody > tr").each(function(e) {
                        
                        let proId = $(this).find('.product_idRETable').text();
                        let proVariant = $(this).find('.product_varientRETable').text();

                        if(proId == namePro && proVariant == variant){
                            qty += parseInt($(this).find('.quantity_return_RETable').text());
                        }
                    });

                        $('#editProduct_name_re').val(value['product_name']);
                        $('#edit_product_id_re').val(value['product_Id']);
                        $('#edit_order_qty').val(parseInt(value['quantity'])-parseInt(qty));
                        $('#edit_product_rate_Re').val(value['unitPrice']);
                        $('#edit_total_order_amount_re').val(value['subTotal']);

                }else{
                    // alert('out');
                }
            });   
        // }
    }    

    // Table
    $('#addProductEditReturnExchangeBtn').on('click', function() {
        let productId = $('#edit_product_id_re').val();
        let productName = $('#editProduct_name_re').val();
        let productVariant = $('#productVariantRAndE1').val();
        let quantityRE = $('#edit_order_qty').val();
        let unitPriceRE = $('#edit_product_rate_Re').val();
        let subTotalRE = $('#edit_total_order_amount_re').val();
        let statusRE = $('#edit_return_and_exchange').val();
        let quantityRAE = $('#edit_return_exchange_re').val();
        let remarkRE = $('#edit_remark_re').val();

        $("#productRETableEditBody > tr").each(function(e) {
            let findProductId = $(this).find('.product_idRETable').text();
            let findProductVarient = $(this).find('.product_varientRETable').text();
            let findProductStatus = $(this).find('.status_RETable').text();

            if (productId == findProductId && productVariant == findProductVarient && statusRE == findProductStatus) {
                // $('#addProductReturnExchangeExitstAlert1').show();
                // $('#addProductReturnExchangeContent1').html('');
                // $('#addProductReturnExchangeContent1').html('Product already added.');
                errorMsg('Product already added.');
                    
                productId = '';
                productName = '';
                productVariant = '';
                quantityRE = '';
                unitPriceRE = '';
                subTotalRE = '';
                statusRE = '';
                quantityRAE = '';
                remarkRE = '';
            }
        });

        let slno = $('#productRETableEdit tr').length;
        if (productName != "" && quantityRE != "" && unitPriceRE != "" && subTotalRE != "" && statusRE != "" &&
            quantityRAE != "") {
            $('#productRETableEdit tbody').append('<tr class="child">\
                                                    <td class="border border-secondary" >' + slno +
                '</td>\
                                                    <td class="border border-secondary product_idRETable" style="display:none;" >' +
                productId + '</td>\
                                                    <td class="border border-secondary product_nameRETable" >' +
                productName + '</td>\
                                                    <td class="border border-secondary product_varientRETable" >' +
                productVariant + '</td>\
                                                    <td class="border border-secondary quantity_RETable" >' +
                quantityRE + '</td>\
                                                    <td class="border border-secondary unit_price_RETable" >' +
                unitPriceRE + '</td>\
                                                    <td class="border border-secondary sub_totalRETable" >' +
                subTotalRE + '</td>\
                                                    <td class="border border-secondary status_RETable " >' + statusRE + '</td>\
                                                    <td class="border border-secondary quantity_return_RETable">' +
                quantityRAE + '</td>\
                                                    <td class="border border-secondary edit_remark_RETable" >' +
                remarkRE + '</td>\
                                                    <td>\
                                                        <a href="javascript:void(0);" class="editremCF21">\
                                                            <i class="mdi mdi-delete"></i>\
                                                        </a>\
                                                    </td>\
                                                </tr>'
            );
        } else {

            if ($('#productRETableEditBody').children().length === 0) {

                $('#tableREEmptyError').html('Please add products details.');
                errorMsg('Please add products details.');
                    

            } else {

                $('#tableREEmptyError').html('');

            }
        }

        $('#editProductNameRAndE').val('');
        $('#edit_product_id_re').val('');
        $('#editProduct_name_re').val('');
        $('#edit_order_qty').val(0);
        $('#edit_product_rate_Re').val(0);
        $('#edit_total_order_amount_re').val(0);
        $('#edit_return_and_exchange').val('');
        $('#edit_return_exchange_re').val(0);
        $('#edit_remark_re').val('');

    });

    $(document).on('click', '.editremCF21', function() {
        $(this).parent().parent().remove();
        $('#productRETableEdit tbody tr').each(function(i) {
            $($(this).find('td')[0]).html(i + 1);
        });
    });

</script>
