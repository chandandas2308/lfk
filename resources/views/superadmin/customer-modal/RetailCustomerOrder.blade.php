<!-- Modal -->
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Create Order</h5>
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
                <select name="customer_name" class="form-control" id="customerName">
                    <option value="">--Select--</option>
                    @foreach($customers as $key=>$value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="customerAddress">Customer Address</label>
                <textarea name="customerAddress" class="form-control" id="customerAddress" rows="4" placeholder="Address"></textarea>
            </div>
        </div>

        <!-- row 2 -->
        <div class="form-group row">
            <div class="col-md-6">
                <label for="customerAddress">Payment Mode</label>
                <input type="text" name="payment_mode" id="" value="COD" readonly class="form-control">
            </div>
            <div class="col-md-6">
                <label for="customerAddress">Delivery Date</label>
                <input type="date" name="delivery_date" id="" class="form-control">
            </div>
        </div>

        <!-- row 5 -->
        <h6 class="salesQuantityError alert alert-warning" style="display: none;"></h6>
        <div class="row">
            <div class="col">
                <fieldset class="border border-secondary p-2">
                    <legend class="float-none w-auto p-2">Order Details<span style="color: red; font-size:smaller;">*</span></legend>
                    <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                        <table class="table border" id="products">
                            <thead>
                                <tr>
                                    <th class=" border border-secondary">Product</th>
                                    <th class=" border border-secondary">Variant</th>
                                    <th class=" border border-secondary">Category</th>
                                    <th class=" border border-secondary">Quantity</th>
                                    <th class=" border border-secondary">Unit Price</th>
                                    <th class=" border border-secondary">Gross Amount</th>
                                </tr>
                            </thead>
                            <tbody class="invoiceBody">
                                <tr>
                                    <form id="addProductForm0">
                                        <td class=" border border-secondary">
                                            <select name="productName" id="productName" onchange="selectFunction()" class="form-control form-control-lg">
                                                <option value="">Select Product</option>
                                                @foreach($products as $key=>$value)
                                                <option value="{{$value->product_id}}">{{$value->product_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class=" border border-secondary">
                                            <input type="hidden" id="product_name">
                                            <input type="text" name="variant" id="variantInput" class="form-control" placeholder="Variant" disabled />
                                        </td>
                                        <td class=" border border-secondary">
                                            <input type="text" name="category" id="categoryInput" class="form-control" placeholder="Category" disabled />
                                        </td>
                                        <td class=" border border-secondary">
                                            <input type="number" name="quantity" id="quantityInput" value="0" class="form-control" placeholder="Quantity">
                                        </td>
                                        <td class=" border border-secondary">
                                            <input type="text" name="unitPrice" id="unitPriceInput" class="form-control" placeholder="Unit Price" disabled />
                                        </td>
                                        <td class=" border border-secondary">
                                            <input type="text" name="subTotal" value="0" id="subTotalInput" class="form-control" placeholder="Gross Amount" disabled />
                                        </td>
                                </tr>
                                <tr>
                                    <td class="">
                                        <a name="addLine" id="addOrderProduct" class="btn btn-primary text-white">Add Product</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                        <table class="table dataTable text-center border" id="orderProductsTable">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Product Name</th>
                                    <th>Category</th>
                                    <th>Variant</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Gross Amount</th>
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

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="createQuotationFromClearBtn">Clear</button>
        <button type="submit" id="createQuotationForm1" class="btn btn-primary">Save</button>
    </div>
</form>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    // clear form
    jQuery('#createQuotationFromClearBtn').on('click', function() {
        jQuery("#createQuotationForm")["0"].reset();
    });

    // validation script start here
    $(document).ready(function() {

        // store data to database
        jQuery("#createQuotationForm").submit(function(e) {
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

                customerName: {
                    required: true,
                },

                expiration: {
                    required: true,
                },

                customerAddress: {
                    required: true,
                    minlength: 1,
                },

                paymentTerms: {
                    required: true,
                },

                gstValue: {
                    //   required: true,
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
            submitHandler: function() {

                if ($('#productTableBody').children().length === 0) {
                    errorMsg('Please add products details');
                } else {
                    $('#tableEmptyError').html('');
                    bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                        if (result) {

                            allProductDetails12.splice(0, allProductDetails12.length);

                            $("#productTableBody > tr").each(function(e) {
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
                                allProductDetails12.push(dbData);
                            });


                            jQuery.ajax({
                                url: "{{ route('SA-AddQuotation') }}",
                                data: jQuery("#createQuotationForm").serialize() + "&allProductDetails12=" + JSON.stringify(allProductDetails12),
                                enctype: "multipart/form-data",
                                type: "post",
                                success: function(result) {
                                    if (result.error != null) {
                                        jQuery(".salesQuantityError").hide();
                                        errorMsg(result.error);
                                    } else if (result.barerror != null) {
                                        jQuery("#addQuotationAlert").hide();
                                        errorMsg(result.barerror);
                                        jQuery(".salesQuantityError").hide();
                                    } else if (result.success != null) {
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
                                    } else if (result.salesQuantityError != null) {
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

    $(document).on('change', "input[id='quantityInput']", function(e) {

        let quantity = $(this).val();

        let price = $(this).closest('tr').find("input[id='unitPriceInput']").val();

        let subtotal = parseFloat(quantity) * parseFloat(price);

        $(this).closest('tr').find("input[id='subTotalInput']").val(subtotal);

    });

    // fetch unique customer detials
    function fetchCustomerName() {
        let id = this.event.target.id;
        let pro = $('#' + id).val();

        $.ajax({
            type: "GET",
            data: {
                'id': pro,
            },
            url: "{{ route('SA-GetCustomerDetails1')}}",
            success: function(response) {

                // console.log(response);

                jQuery.each(response, function(key, value) {
                    $('#qCustomer_name').val(value["customer_name"]);
                    $('#qCustomer_nameEdit').val(value["customer_name"]);
                    $('#customerAddress').val(value["address"]);

                    // Special Price Filtered Products Detials
                    $.ajax({
                        type: "GET",
                        url: "{{ route('SA-GetFilteredProductsDetials')}}",
                        data: {
                            "id": value['id']
                        },
                        success: function(response) {

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

                            jQuery.each(response, function(key, value) {
                                // 
                                $('#productName').append(
                                    '<option value="' + value["product_name"] + '">\
                                            ' + value["product_name"] + '\
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

    function selectFunction() {
        let id = $('#productName').val();
        console.log(id);

        @foreach($products as $key => $value)
        if (id == "{{$value->product_id}}") {
            $('#product_name').val("{{$value->product_name}}");
            $('#variantInput').val("{{$value->product_varient}}");
            $('#categoryInput').val("{{$value->product_category}}");
            $('#quantityInput').attr('max', "{{$value->quantity}}");
            $('#unitPriceInput').val("{{$value->min_sale_price}}");
        }
        @endforeach
    };

    function selectVarientFunction() {
        let id = this.event.target.id;
        let varient = $('#' + id).val();
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
            type: "GET",
            url: "{{ route('SA-FetchProductsDetialsInfo')}}",
            data: {
                "id": customerId,
            },
            success: function(response) {

                jQuery.each(response, function(key, value) {
                    if (value['product_name'] === product && value['varient'] === varient) {

                        // product id
                        $('#' + id).closest('tr').find("input[id='productIdQuotation']").val(value["id"]);
                        // sku code
                        $('#' + id).closest('tr').find("input[id='sku_code']").val(value["sku_code"]);
                        // batch code

                        $.ajax({
                            type: "GET",
                            url: "{{ route('SA-SalesAllBatchCode')}}",
                            data: {
                                "proName": value['product_name'],
                                "proVariant": value['varient'],
                            },
                            success: function(response) {
                                // console.log('batchcode', response);
                                $('#batch_code').html('');
                                $('#batch_code').append('<option value="">Select Batch Code</option>');
                                jQuery.each(response, function(k, v) {
                                    $('#batch_code').append(`
                                                            <option value="${v['batch_code']}">${v['batch_code']}</option>
                                                        `);
                                });
                            }
                        });

                        // category
                        $('#' + id).closest('tr').find("input[id='category']").val(value["category"]);
                        // productNameReq
                        $('#' + id).closest('tr').find("input[id='productNameQuotation1']").val(value["product_name"]);
                        // unit price
                        $('#' + id).closest('tr').find("input[id='unitPrice']").val(value["unit_price"]);
                    }
                });
            }
        });
    }

    var allProductDetails12 = [];

    var orderProductsArr = [];

    // Table
    $('#addOrderProduct').on('click', function() {
        let productId = $('#productName').val();
        let productName = $('#product_name').val();
        let varient = $('#variantInput').val();
        let category = $('#categoryInput').val();
        let quantity = $('#quantityInput').val();
        let unitPrice = $('#unitPriceInput').val();
        let subTotal = $('#subTotalInput').val();

        if (productId != "" && varient != "" != "" && category != "" && quantity != "" && unitPrice != "" && subTotal != "") {

            orderProductsArr.push({
                "product_id": productId,
                "productName": productName,
                "varient": varient,
                "category": category,
                "quantity": quantity,
                "unitPrice": unitPrice,
                "subTotal": subTotal,
            });

            updateOrderTable(orderProductsArr);

            $('#productName').val('');
            $('#product_name').val('');
            $('#variantInput').val('');
            $('#categoryInput').val('');
            $('#quantityInput').val(0);
            $('#unitPriceInput').val(0);
            $('#subTotalInput').val(0);

        } else {
            errorMsg('Please select products in form.');

            if ($('#productTableBody').children().length === 0) {
                errorMsg('Please add products details.');
            } else {
                $('#tableEmptyError').html('');
            }
        }
    });

    function updateOrderTable(orderProductsArr) {
        $('#orderProductsTable tbody').html('');
        let i = 0;
        $.each(orderProductsArr, function(key, value) {
            $('#orderProductsTable tbody').append('<tr class="child">\
                <td>' + ++i + '</td>\
                <td class="product_name">' + value['productName'] + '</td>\
                <td class="product_category">' + value['category'] + '</td>\
                <td class="product_varient">' + value['varient'] + '</td>\
                <td class="product_quantity">' + value['quantity'] + '</td>\
                <td class="unit_price">' + value['unitPrice'] + '</td>\
                <td class="subtotal">' + value['subTotal'] + '</td>\
                <td class="subtotal">  </td>\
            </tr>');
        })
    }

    function calculate() {
        let sum = 0;
        let tax = 0;
        let i = 0;

        $("#productTableBody tr .subtotal").each(function() {
            sum += parseFloat($(this).text());
        });

        $('#untaxtedAmount').val(sum);
        $('#untaxtedAmount1').val(sum);
        $('#quotationTotal').val(sum);
        $('#quotationTotal1').val(sum);

        $("#productTableBody tr .taxes").each(function() {
            tax += parseFloat($(this).text());
        });

        // $('#gst').val(tax);
        // $('#gst1').val(tax);

        // $('#taxInclude').change(function(){
        if ($('#taxInclude').prop('checked')) {
            let untaxtedAmount = parseFloat($('#untaxtedAmount').val());
            let totalBill = untaxtedAmount + tax;
            $('#gst').val(tax.toFixed(2));
            $('#gst1').val(tax.toFixed(2));
            $('#quotationTotal').val(totalBill);
            $('#quotationTotal1').val(totalBill);
        } else {
            let untaxtedAmount = parseFloat($('#untaxtedAmount').val());
            let totalBill = untaxtedAmount;

            $('#gst').val('');

            $('#quotationTotal').val(totalBill);
            $('#quotationTotal1').val(totalBill);
        }
        // });

    };

    $(document).on('click', '.remCF1CreateQty', function() {
        $(this).parent().parent().remove();

        $('#productsTable tbody tr').each(function(i) {
            $($(this).find('td')[0]).html(i + 1);
        });
        calculate();
        selectFunction();
    });
</script>