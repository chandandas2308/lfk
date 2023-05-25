<!-- Modal -->
<div class="modal fade" id="addProductReturnExchange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Return & Exchange Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-success alert-dismissible fade show" id="addProductInReturnExchangeSuccessAlert"
                role="alert" style="display: none;">
                <strong> <span id="addProductInReturnExchangeSuccessMSG"></strong></span>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-danger alert-dismissible fade show" id="addProductReturnExchangeErrorAlert"
                style="display:none" role="alert">
                <strong> <span id="addProductReturnExchangeErrorMSG"></strong></span>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- end -->



            <form method="post" id="addProductRandExchangeForm">
                <div class="modal-body bg-white px-3">
                    <!-- invoice body start here -->
                    <!-- row 0 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="re-type" class="col-form-label">Type</label>
                            <select name="type" onchange="chooseType1()" id="re-type"
                                class="form-control text-dark">
                                <option value="">Choose Type...</option>
                                <option value="sale">Sale</option>
                                <option value="purchase">Purchase</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="user_name_re" class="col-form-label">Customer/Vendor Name</label>
                            <select name="user" id="user_name_re" onchange="chooseUser1()"
                                class="form-control text-dark">
                                <option value="">Choose Name...</option>
                            </select>
                            <input type="text" name="user_name" id="user_nameRE" class="user_name"
                                style="display: none;">
                        </div>
                    </div>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label for="re-invoice" class="col-form-label">Invoice No.</label>
                            <select name="invoiceNo" id="re-invoice" onchange="chooseInvoiceNoRE1()"
                                class="form-control text-dark">
                                <option value="">Choose Invoice No. ...</option>
                            </select>
                            <input type="text" id="saleAndPur" name="saleAndPur">
                        </div>
                        <div class="col-md-4">
                            <label for="invoice_date_re1" class="col-form-label">Invoice Date</label>
                            <input type="date" name="invoice_date" id="invoice_date_re1"
                                class="form-control text-dark" readonly />
                        </div>
                        <div class="col-md-4">
                            <label for="invoice_amount_re1" class="col-form-label">Invoice Amount</label>
                            <input type="text" name="invoice_Amount" id="invoice_amount_re1" class="form-control text-dark" placeholder="Invoice Amount" readonly />
                        </div>
                    </div>


                    <div class="alert alert-danger alert-dismissible fade show" id="addProductReturnExchangeExitstAlert"
                        style="display:none" role="alert">
                        <strong><span id="addProductReturnExchangeContent"></strong></span>
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <!-- row 5 -->
                    <div class="form-group row">
                        <div class="col">
                            <fieldset class="border border-secondary p-2">
                                <legend class="float-none w-auto p-2">Orders Details</legend>

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
                                                        <select name="productName" id="productNameRAndE1"
                                                            onchange="getOrderedProductInfo1()"
                                                            class="form-control form-control-lg  text-dark">
                                                            <option value="">Select Product</option>
                                                        </select>
                                                    </td>
                                                    <td class="border border-secondary">
                                                        <select name="productVariant" id="productVariantRAndE"
                                                            onchange="getOrderedProductVariantInfo12()"
                                                            class="form-control form-control-lg  text-dark">
                                                            <option value="">Select Variant</option>
                                                        </select>
                                                    </td>
                                                    <!-- productId -->
                                                    <!-- hide content -->
                                                    <td class="border border-secondary" style="display:none;">
                                                        <input type="text" name="product_name_re"
                                                            id="product_name_re" class="form-control  text-dark" />
                                                        <input type="text" name="product_id" id="product_id_re"
                                                            class="form-control  text-dark" />
                                                    </td>
                                                    <!-- Quantity -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="quantity" id="order_qty"
                                                            class="form-control  text-dark" placeholder="Quantity"
                                                            readonly />
                                                    </td>
                                                    <!-- Rate -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="Rate" id="product_rate_Re"
                                                            class="form-control text-dark" placeholder="Rate"
                                                            readonly />
                                                    </td>
                                                    <!-- Total Amount -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="totalAmount"
                                                            id="total_order_amount_re" class="form-control text-dark"
                                                            placeholder="Total Amount" readonly />
                                                    </td>
                                                    <!-- return & exchange -->
                                                    <td class="border border-secondary">
                                                        <select name="return_and_exchange" id="return_and_exchange"
                                                            class="form-control text-dark">
                                                            <option value="">Choose status</option>
                                                            <option value="return">Return</option>
                                                            <option value="exchange">Exchange</option>
                                                        </select>
                                                    </td>
                                                    <!-- return & exhcange qty-->
                                                    <td class="border border-secondary">
                                                        <input type="number"
                                                            name="returnAndExhcangeRe" id="return_exchange_re"
                                                            class="form-control text-dark"
                                                            placeholder="Return/Exchange Quantity">
                                                    </td>
                                                    <!-- Remark -->
                                                    <td class="border border-secondary">
                                                        <input type="text" name="remark" id="remark_re"
                                                            class="form-control text-dark"
                                                            placeholder="Remarks">
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a name="addLine" id="addProductReturnExchangeBtn"
                                                        class="btn btn-primary text-white">Add Product</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table text-center border" id="productRETable">
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
                                        <tbody id="productRETableBody"></tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        id="addProductReturnExchangeClearBtn">Clear</button>
                    <button type="submit" id="addProductRandExchangeForm1" class="btn btn-primary">Save</button>
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
        jQuery("#addProductRandExchangeForm")["0"].reset();
    });

    // validation script start here
    $(document).ready(function() {

        
            $('#user_name_re').prop("disabled", true);
            $('#re-invoice').prop("disabled", true);
            $('#productNameRAndE1').prop("disabled", true);

        // store data to database
        jQuery("#addProductRandExchangeForm").submit(function(e) {
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

            submitHandler : function(){

                let allProductDetailsRandEInvoice = [];

                allProductDetailsRandEInvoice.splice(0, allProductDetailsRandEInvoice.length);

                $("#productRETableBody > tr").each(function(e) {
                    let productId = $(this).find('.product_idRETable').text();
                    let productName = $(this).find('.product_nameRETable').text();
                    let productVariant = $(this).find('.product_varientRETable').text();
                    let quantityRE = $(this).find('.quantity_RETable').text();
                    let unitPriceRE = $(this).find('.unit_price_RETable').text();
                    let subTotalRE = $(this).find('.sub_totalRETable').text();
                    let statusRE = $(this).find('.status_RETable').text();
                    let quantityRAE = $(this).find('.quantity_return_RETable').text();
                    let remarkRE = $(this).find('.remark_RETable').text();

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
                    allProductDetailsRandEInvoice.push(dbData);

                });
                                              
                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('SA-AddREProduct') }}",
                            data: jQuery("#addProductRandExchangeForm").serialize() + "&allProductDetails=" + JSON
                                .stringify(allProductDetailsRandEInvoice),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function(result) {

                                if (result.error != null) {
                                    errorMsg(result.error);
                                } else if (result.barerror != null) {
                                    errorMsg(result.barerror);
                                } else if (result.return_exchange_add_success != null) {
                                    jQuery('.modal .close').click();
                                    successMsg(result.return_exchange_add_success);
                                    jQuery("#addProductRandExchangeForm")["0"].reset();
                                    jQuery("#productRETableBody").html('');
                                    return_exchange_main_table.ajax.reload();
                                    return_goods_main_table.ajax.reload();
                                    exchange_goods_main_table.ajax.reload();
                                } else {
                                    jQuery("#addProductReturnExchangeErrorAlert").hide();
                                    jQuery("#addProductInReturnExchangeSuccessAlert").hide();
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
    function chooseType1() {
        
        let type = $('#re-type').val();

        jQuery("#addProductRandExchangeForm")["0"].reset();
        $('#productRETableBody').html('');

        $('#re-type').val(type);

        $('#user_name_re').removeAttr("disabled");

        if (type === "sale") {

            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetAllInvoiceForPayment') }}",
                success: function(response) {

                    $('#user_name_re').html('');
                    $('#user_name_re').append('<option value="">Choose User...</option>');
                    jQuery.each(response, function(key, value) {
                        $('#user_name_re').append(
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

                    $('#user_name_re').html('');
                    $('#user_name_re').append('<option value="">Choose User...</option>');
                    jQuery.each(response, function(key, value) {
                        $('#user_name_re').append(
                            '<option value="' + value['vendor_id'] + '">' + value[
                                'vendor_name'] + '</option>'
                        );
                    });
                }
            });
        }
    }

    // check customer and fetch detials
    function chooseUser1() {
        let user_id = $('#user_name_re').val();

        $('#re-invoice').removeAttr("disabled");


        let type = $('#re-type').val();


        if (type === "sale") {

            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCustomerDetails') }}",
                data: {
                    "id": user_id,
                },
                success: function(response) {
                    $('#user_nameRE').val('');
                    $.each(response, function(k, v) {
                        $('#user_nameRE').val(v['customer_name']);
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
                    $('#user_nameRE').val('');
                    $.each(response, function(k, v) {
                        $('#user_nameRE').val(v['vendor_name']);
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
                    console.log(response);
                    $('#re-invoice').html('');
                    $('#re-invoice').append('<option value="">Choose Invoice No.</option>');
                    jQuery.each(response, function(key, value) {

                        $('#re-invoice').append(
                            '<option value=' + value["invoice_no"] + '>' + value["inv_no"] +
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
                    $('#re-invoice').html('');
                    $('#re-invoice').append('<option value="">Choose Invoice No.</option>');
                    jQuery.each(response, function(key, value) {

                        $('#re-invoice').append(
                            '<option value=' + value["id"] + '>' + value["qut_no"] + '</option>'
                        );
                    });
                }
            });
        }
    }

    // choose invoice number to view all details
    function chooseInvoiceNoRE1() {
        let user_id = $('#re-invoice').val();
        let type = $('#re-type').val();

        $('#productNameRAndE1').removeAttr("disabled");

        if (type === "sale") {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-InvoiceDetails') }}",
                data: {
                    "pro": user_id
                },
                success: function(response) {
                    console.log('sale', response);
                    jQuery.each(response, function(key, value) {

                        $('#invoice_date_re1').val(value['invoice_date']);
                        $('#invoice_amount_re1').val(value["total"]);
                        $('#saleAndPur').val(value["inv_no"]);

                        let str = value["products"];
                        let obj = JSON.parse(str);

                        $('#productNameRAndE1').html('');
                        $('#productNameRAndE1').append(
                            '<option value="">Choose Product Name...</option>');
                        jQuery.each(obj, function(key, value) {
                            $('#productNameRAndE1').append(
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



                        $('#invoice_date_re1').val(value['receipt_date']);
                        $('#invoice_amount_re1').val(value["total"]);
                        $('#saleAndPur').val(value["qut_no"]);

                        let str = value["products"];
                        let obj = JSON.parse(str);

                        $('#productNameRAndE1').html('');
                        $('#productNameRAndE1').append(
                            '<option value="">Choose Product Name...</option>');
                        jQuery.each(obj, function(key, value) {
                            $('#productNameRAndE1').append(
                                '<option value="' + value['product_Id'] + '">' + value[
                                    'product_name'] + '</option>'
                            );
                        });

                    });
                }
            });
        }
    }

    let AllPurSaleInfo = [];


    function getOrderedProductInfo1() {
        // let id = $('#productNameRAndE1').val();
        let namePro = $('#productNameRAndE1').val();

        let user_id = $('#re-invoice').val();
        let type = $('#re-type').val();

        if (type == "sale") {
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

                        AllPurSaleInfo = obj;

                        $('#productVariantRAndE').html('');
                        $('#productVariantRAndE').append('<option value="">Select Variant...</option>');
                        jQuery.each(obj, function(key, value) {

                            if(namePro == value['product_Id']){

                                $('#productVariantRAndE').append(`
                                    <option value="${value['product_varient']}">${value['product_varient']}</option>
                                `);
                            }

                            // let qty = 0;
                            // $("#productRETableBody > tr").each(function(e) {
                            //     qty += parseInt($(this).find('.quantity_return_RETable').text());
                            // });

                            // if (id === value['product_Id']) {
                            //     $('#product_name_re').val(value['product_name']);
                            //     $('#product_id_re').val(value['product_Id']);
                            //     $('#order_qty').val(parseInt(value['quantity'])-parseInt(qty));
                            //     $('#product_rate_Re').val(value['unitPrice']);
                            //     $('#total_order_amount_re').val(value['subTotal']);
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

                        AllPurSaleInfo = obj;

                        $('#productVariantRAndE').html('');
                        $('#productVariantRAndE').append('<option value="">Select Variant...</option>');
                        jQuery.each(obj, function(key, value) {

                            // $('#productVariantRAndE').append(`
                            //     <option value="${value['product_varient']}">${value['product_varient']}</option>
                            // `);
                            
                            if(namePro == value['product_Id']){
                                $('#productVariantRAndE').append(`
                                    <option value="${value['product_varient']}">${value['product_varient']}</option>
                                `);
                            }

                            // let qty = 0;
                            // $("#productRETableBody > tr").each(function(e) {
                            //     qty += parseInt($(this).find('.quantity_return_RETable').text());
                            // });                            

                            // if (id === value['product_Id']) {
                            //     $('#product_name_re').val(value['product_name']);
                            //     $('#product_id_re').val(value['product_Id']);
                            //     $('#order_qty').val(parseInt(value['quantity'])-parseInt(qty));
                            //     $('#product_rate_Re').val(value['unitPrice']);
                            //     $('#total_order_amount_re').val(value['subTotal']);
                            // }

                        });

                    });
                }
            });
        }
    }

    function getOrderedProductVariantInfo12() {
        let namePro = $('#productNameRAndE1').val();
        let user_id = $('#re-invoice').val();
        let type = $('#re-type').val();

        let variant = $('#productVariantRAndE').val();

        // if (type == "sale")
        // {
            
            jQuery.each(AllPurSaleInfo, function(key, value) {

                // alert(namePro);
                // alert(value['product_Id']);

                // alert(variant);
                // alert(value['product_varient']);

                if(namePro == value['product_Id'] && variant == value['product_varient']){

                    // alert('here');
                    let qty = 0;
                    $("#productRETableBody > tr").each(function(e) {
                        
                        let proId = $(this).find('.product_idRETable').text();
                        let proVariant = $(this).find('.product_varientRETable').text();

                        if(proId == namePro && proVariant == variant){
                            qty += parseInt($(this).find('.quantity_return_RETable').text());
                        }
                    });

                        $('#product_name_re').val(value['product_name']);
                        $('#product_id_re').val(value['product_Id']);
                        $('#order_qty').val(parseInt(value['quantity'])-parseInt(qty));
                        $('#product_rate_Re').val(value['unitPrice']);
                        $('#total_order_amount_re').val(value['subTotal']);

                }else{
                    // alert('out');
                }
            });   
        // }
    }


    $(document).on('keyup', "input[id='return_exchange_re']", function(e) {
        var quantityRE = $('#order_qty').val();
        var enterQty = $('#return_exchange_re').val();
        //alert(typeof(quantityRE));
        //alert(typeof(enterQty));
        if (parseInt(enterQty) > parseInt(quantityRE)) {
            //alert(enterQty);
            $('#addProductReturnExchangeExitstAlert').show();
            $('#addProductReturnExchangeContent').html('Please enter valid quantity.');
            $("#addProductReturnExchangeExitstAlert").show().delay(2000).fadeOut();
            $('#return_exchange_re').val('');
        }

    });

    // Table
    $('#addProductReturnExchangeBtn').on('click', function() {
        let productId = $('#product_id_re').val();
        let productName = $('#product_name_re').val();
        let productVariant = $('#productVariantRAndE').val();
        let quantityRE = $('#order_qty').val();
        let unitPriceRE = $('#product_rate_Re').val();
        let subTotalRE = $('#total_order_amount_re').val();
        let statusRE = $('#return_and_exchange').val();
        let quantityRAE = $('#return_exchange_re').val();
        let remarkRE = $('#remark_re').val();

        let slno = $('#productRETable tr').length;

        $("#productRETableBody > tr").each(function(e) {
            let findProductId = $(this).find('.product_idRETable').text();
            let findProductVarient = $(this).find('.product_varientRETable').text();
            let findProductStatus = $(this).find('.status_RETable').text();

            if (productId == findProductId && productVariant == findProductVarient && statusRE == findProductStatus) {
                // $('#addProductReturnExchangeExitstAlert').show();
                // $('#addProductReturnExchangeContent').html('');
                // $('#addProductReturnExchangeContent').html('Product already added.');
                errorMsg('Product already added');
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
        if (productName != "" && quantityRE != "" && unitPriceRE != "" && subTotalRE != "" && statusRE != "" &&
            quantityRAE != "") {
            $('#productRETable tbody').append('<tr class="child">\
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
                                                    <td class="border border-secondary remark_RETable" >' + remarkRE + '</td>\
                                                    <td>\
                                                        <a href="javascript:void(0);" class="remCF21">\
                                                            <i class="mdi mdi-delete"></i>\
                                                        </a>\
                                                    </td>\
                                                </tr>'
            );
        } else {

            if ($('#productRETableBody').children().length === 0) {

                // $('#tableREEmptyError').html('Please add products details.');
                errorMsg('Please add products details.');

            } else {

                $('#tableREEmptyError').html('');

            }
        }

        $('#productNameRAndE1').val('');
        $('#product_id_re').val('');
        $('#product_name_re').val('');
        $('#productVariantRAndE').val('');
        $('#order_qty').val(0);
        $('#product_rate_Re').val(0);
        $('#total_order_amount_re').val(0);
        $('#return_and_exchange').val('');
        $('#return_exchange_re').val(0);
        $('#remark_re').val('');        

    });

    $(document).on('click', '.remCF21', function() {
        $(this).parent().parent().remove();
        $('#productRETableEdit tbody tr').each(function(i) {
            $($(this).find('td')[0]).html(i + 1);
        });
    });

</script>
