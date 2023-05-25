<!-- Modal -->
<div class="modal fade" id="addOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Purchase Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="addPurchaseOrderForm">
                <div class="modal-body bg-white px-3">
                    <!-- invoice body start here -->

                    <!-- info & alert section -->
                    <div class="alert alert-success" id="addOrderAlert" style="display:none"></div>
                    <div class="alert alert-danger" style="display:none">
                        <ul></ul>
                    </div>
                    <!-- end -->

                    <!-- row 0 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="quotationno1">Create Purchase Order<span style="color: red; font-size:small;">*</span></label>
                            <select name="create_purchase_order_by" id="create_purchase_order_by" class="form-control" onchange="changePurchaseOrderFn()">
                                <option value="">Select ...</option>
                                <option value="manual">By Manual</option>
                                <option value="byQuotation">By Purchase Requisition No.</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3">
                                <span class="text-secondary" style="font-size:small">By Manual : To Generate Manually Purchase Order.</span>
                                <br>
                                <span class="text-secondary" style="font-size:small">By Purchase Requisition No. : To Generate by already generated purchase requisition.</span>                               
                            </div>
                        </div>
                    </div>
                    

                    <hr>  

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorNameOrder">Purchase Requisition No</label>
                            <select name="quotationNumber" onchange="getPurchaseQuotation()" class="form-control purchaseQuotationNum" id="purchaseQuotationNum" disabled>
                            </select>
                            <input type="hidden" class="form-control text-dark" id="purQut" name="PurQut">

                        </div>
                        <!-- <div class="col-md-0 form-control text-center border-0 fw-bold text-dark">
                            <label for="vendorNameOrder"></label>
                            <h6></h6>
                        </div> -->
                        <div class="col-md-6">
                            <label for="vendorNameOrder">Purchase Order</label>
                            <input type="text" class="form-control text-dark" name="purchaseOrderNo" id="purchaseOrderNo" placeholder="Purchase Order" disabled />
                        </div>
                    </div>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorIdOrder">Vendor<span style="color:red; font-size:medium">*</span></label>
                            <select name="vendorIdOrder" class="form-control vendorNameOrder" id="vendorNameOrder" onchange="getProductsReq1()" disabled></select>
                            <!-- <input type="text" name="vendorNameOrder" class="form-control" id="vendorIdOrder" style="display:" /> -->
                        </div>
                        <div class="col-md-6">
                            <label for="receiptDateOrder">Receipt Date<span style="color:red; font-size:medium">*</span></label>
                            <input type="date" name="receiptDate" id="receiptDateOrder" value="<?= date('Y-m-d') ?>" class="form-control receiptDateOrder" placeholder="Receipt Date" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorReferenceOrder">Vendor Reference<span style="color:red; font-size:medium">*</span></label>
                            <input type="text" name="vendorReference" id="vendorReferenceOrder" class="form-control vendorReferenceOrder" placeholder="Vendor Reference" />
                        </div>
                        <div class="col-md-6">
                            <label for="billingStatus">Billing Status<span style="color:red; font-size:medium">*</span></label>
                            <select name="billingStatus" id="billingStatus" class="form-control">
                                <option value=''>Select Billing Status</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="checkbox" class="mt-4 askForConfirmPurchaseOrder" name="askForConfirm" value="confirm" id="askForConfirmPurchaseOrder"> <label for="askForConfirmPurchaseOrder" class="mt-4 text-primary">Ask for Confirmation</label>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label for="taxInclude" class="text-primary form-control"><input type="checkbox" name="taxInclude" id="taxIncludePurchaseOrder"> Tax inclusive</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="gstValue" value="7" id="gstValuePurchaseOrder" min="1" placeholder="GST (In %)" />
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
                        <!-- </div> -->
                    </div>

                    <div class="alert alert-danger alert-dismissible fade show" id="addProductExitstAlert" style="display:none" role="alert">
                        <strong>Info ! </strong> <span id="addProductContent"></span>
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- row 5 -->
                    <div class="form-group row">
                        <div class="col">
                            <fieldset class="border border-secondary p-2">
                                <legend class="float-none w-auto p-2">Order Details<span style="color:red; font-size:medium">*</span></legend>
                                <span style="color:red; font-size:small;" id="createOrdertableEmptyError"></span>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table border" id="products">
                                        <thead>
                                            <tr>
                                                <th class="border border-secondary">Product</th>
                                                <!-- <th class="border border-secondary">Id</th> -->
                                                <th class="border border-secondary">Variant</th>
                                                <th class="border border-secondary">Category</th>
                                                <!-- <th class="border border-secondary">SKU Code</th> -->
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
                                            <tr>
                                                <form id="addProductForm0">
                                                    <!-- product -->
                                                    <td class="border border-secondary">
                                                        <select id="productNameOrder" onchange="selectFunctionOrder1()" class="form-control form-control-lg">
                                                            <option value="">Select Product</option>
                                                        </select>
                                                    </td>
                                                    <!-- productId -->
                                                    <!-- Hide content -->
                                                    <td class="border border-secondary" style="display: none;">
                                                        <input type="text" id="productId" class="form-control" placeholder="Id">
                                                        <input type="text" id="productNameOrder1" class="form-control" placeholder="Id">
                                                    </td>
                                                    <!-- varient -->
                                                    <td class="border border-secondary">
                                                        <!-- <input type="text"  id="varientOrder" class="form-control" placeholder="Varient" disabled /> -->
                                                        <select name="varient" id="varientOrder" class="form-control" onchange="selectAddOrderFunction()">
                                                            <option value="">Select Variant</option>
                                                        </select>
                                                    </td>
                                                    <!-- category -->
                                                    <td class="border border-secondary">
                                                        <input type="text" id="categoryOrder" class="form-control" placeholder="Category" disabled />
                                                    </td>
                                                    <!-- sku_Code -->
                                                    <!-- <td class="border border-secondary">
                                                        <input type="text" id="sku_CodeOrder" class="form-control" placeholder="sku_Code" disabled />
                                                    </td> -->
                                                    <!-- Description -->
                                                    <td class="border border-secondary">
                                                        <input type="text" id="descriptionOrder" class="form-control" placeholder="Description">
                                                    </td>
                                                    <!-- Quantity -->
                                                    <td class="border border-secondary">
                                                        <input type="text" id="quantityOrder" value="0" class="form-control" placeholder="Quantity">
                                                    </td>
                                                    <!-- unit price -->
                                                    <td class="border border-secondary">
                                                        <input type="text" id="unitPriceOrder" value="0" class="form-control" placeholder="Unit Price" />
                                                    </td>
                                                    <!-- taxes -->
                                                    <td class="border border-secondary" style="display: none;">
                                                        <input type="text" id="taxesOrder" value="0" class="form-control" placeholder="Taxes" disabled />
                                                    </td>
                                                    <!-- sub total -->
                                                    <td class="border border-secondary">
                                                        <input type="text" id="subTotalOrder" value="0" class="form-control" placeholder="Gross Amount" disabled />
                                                    </td>
                                                    <!-- net amount -->
                                                    <td class="border border-secondary">
                                                        <input type="text" id="netAmountOrder" value="0" class="form-control" placeholder="Net Amount" disabled />
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a id="addProductOrder" class="btn btn-primary text-white">Add Product</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table text-center border productsTableOrder" id="productsTableOrder" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <!-- <th>Product ID</th> -->
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Variant</th>
                                                <!-- <th>SKU Code</th> -->
                                                <!-- <th>Batch Code</th> -->
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <!-- <th>Taxes</th> -->
                                                <th>Gross Amount</th>
                                                <th>Net Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productTableBodyOrder" class="productTableBodyOrder"></tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                            <input type="text" name="notes" id="notesOrder" class="form-control" placeholder="Add an Internal Note" />
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">Sub Total</div>
                                <div class="col-md-7 my-auto">
                                    <input type="test" name="untaxtedAmount1" id="untaxtedAmountOrder" class="form-control untaxtedAmountOrder" placeholder="Sub Total" disabled>
                                    <input type="test" name="untaxtedAmount" id="untaxtedAmountOrder1" class="form-control untaxtedAmountOrder1" placeholder="Sub Total" style="display: none;">
                                </div>
                            </div>
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">GST</div>
                                <div class="col-md-7 my-auto">
                                    <input type="test" name="gst1" id="gstOrder" class="form-control gstOrder" placeholder="GST" disabled>
                                    <input type="test" name="gst" id="gstOrder1" class="form-control gstOrder1" placeholder="GST" style="display: none;">
                                </div>
                            </div>
                            <hr />
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">Grand Total</div>
                                <div class="col-md-7 my-auto">
                                    <input type="test" id="quotationTotalOrder" name="quotationTotal1" class="form-control quotationTotalOrder" name="totalBill" placeholder="Grand Total" disabled>
                                    <input type="test" id="quotationTotalOrder1" name="quotationTotal" class="form-control quotationTotalOrder1" name="totalBill" placeholder="Grand Total" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end here -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addOrderPurchaseClearBtn">Clear</button>
                    <button type="submit" id="addPurchaseOrderForm1" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>


        function changePurchaseOrderFn(){
            if($('#create_purchase_order_by').val() == 'manual'){

                $('#purchaseQuotationNum').attr('disabled', true);
                $('#purchaseQuotationNum').val('');
                $('#purchaseOrderNo').removeAttr('disabled');
                jQuery("#addPurchaseOrderForm")["0"].reset();
                jQuery("#productTableBodyOrder").html('');
                $('#create_purchase_order_by').val('manual');
                $('#vendorNameOrder').removeAttr('disabled');

                $('#taxIncludePurchaseOrder').attr('readonly', false);
                $('#gstValuePurchaseOrder').attr('readonly', false);

            }else if($('#create_purchase_order_by').val() == 'byQuotation'){

                getPurchaseQuotationNo();

                $('#purchaseOrderNo').attr('disabled', true);
                $('#purchaseOrderNo').val('');
                $('#purchaseQuotationNum').removeAttr('disabled');
                jQuery("#addPurchaseOrderForm")["0"].reset();
                jQuery("#productTableBodyOrder").html('');
                $('#create_purchase_order_by').val('byQuotation');
                $('#vendorNameOrder').removeAttr('disabled');

                $('#taxIncludePurchaseOrder').attr('readonly', true);
                $('#gstValuePurchaseOrder').attr('readonly', true);

            }else{

                $('#productNameOrders2').attr('disabled', true);
                $('#purchaseOrderNo').attr('disabled', true);
                $('#purchaseQuotationNum').attr('disabled', true);
                jQuery("#addPurchaseOrderForm")["0"].reset();
                jQuery("#productTableBodyOrder").html('');
                $('#vendorNameOrder').attr('disabled', true);

                $('#taxIncludePurchaseOrder').attr('readonly', false);
                $('#gstValuePurchaseOrder').attr('readonly', false);

            }
        }

    $('#addOrderPurchaseClearBtn').on('click', function() {
        $('#addPurchaseOrderForm')["0"].reset();
        $('#productTableBodyOrder').html('');
        
        $('#askForConfirmPurchaseOrder').removeAttr('readonly');
        $('#taxIncludePurchaseOrder').removeAttr('readonly');
        $('#gstValuePurchaseOrder').removeAttr('readonly');
        $("#purchaseQuotationNum").removeAttr('disabled');
    });

        /*global window */
        // (function ($) {
        //     "use strict";
            $(document.body).delegate('[type="checkbox"][readonly="readonly"]', 'click', function(e) {
                e.preventDefault();
            });
        // }(window.jQuery));

    // disable Quotation and checkBox
    // $("#taxIncludePurchaseOrder").attr('disabled', 'disabled');
    // $("#purchaseOrderNo").on({
    //     focus: function() {
    //         $("#purchaseQuotationNum").attr('disabled', 'disabled');
    //         // $("#taxIncludePurchaseOrder").removeAttr('disabled');
    //         $('#addPurchaseOrderForm')["0"].reset();
    //         $('#productTableBodyOrder').html('');
    //     },
    //     blur: function() {
    //         let quotaionId = $("#purchaseOrderNo");
    //         if (quotaionId.val() != "") {
    //             $("#purchaseQuotationNum").attr('disabled', 'disabled');
    //             $("#taxIncludePurchaseOrder").removeAttr('disabled');
    //         } else {
    //             $("#purchaseQuotationNum").removeAttr('disabled');
    //         }
    //     }
    // });


    function selectFunctionOrder1() {
        let id = this.event.target.id;
        let pro = $('#' + id).val();

        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetNameProducts')}}",
            data: {
                "val": pro,
            },
            success: function(response) {

                $('#varientOrder').html('');
                $('#varientOrder').append('<option value="">Select Variant</option>');
                jQuery.each(response, function(key, value){

                    if($('#productsTableOrder tbody > tr').length == 0){
                        
                            $('#varientOrder').append(
                                '<option value="'+value["product_varient"]+'">\
                                    '+value["product_varient"]+'\
                                </option>'
                            );

                    }else{
                        
                        let count = 0;

                        $("#productTableBodyOrder tr").each(function(){
                            let proName = $(this).find('.product_name').text();
                            let proVarient = $(this).find('.product_varient').text();

                            if(proName == value['product_name'] && proVarient == value['product_varient']){
                                ++count;
                            }
                        });

                            if(count == 0){
                                $('#varientOrder').append(
                                    '<option value="'+value["product_varient"]+'">\
                                        '+value["product_varient"]+'\
                                    </option>'
                                );
                            }
                    }
                });
            }
            // success: function(response) {

            //     $('#varientOrder').html('');
            //     $('#varientOrder').append('<option value="">Choose Varients</option>');
            //     jQuery.each(response, function(key, value) {
            //         $('#varientOrder').append(
            //             '<option value="' + value["product_varient"] + '">\
            //                                         ' + value["product_varient"] + '\
            //                                     </option>'
            //         );
            //     });
            // }
        });
    };


    function selectAddOrderFunction() {
        let id = this.event.target.id;
        let varient = $('#' + id).val();
        let product = $('#productNameOrder').val();
        // let customerId = $('#customerName').val();

        // console.log(filterdProductArray);

        // console.log(varient);
        // console.log(product);

        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchProductsAllDetialsInfo')}}",
            success: function(response) {

                // console.log(response);

                jQuery.each(response, function(key, value) {
                    if (value['product_name'] === product && value['product_varient'] === varient) {
                        // product id
                        $('#' + id).closest('tr').find("input[id='productId']").val(value["id"]);
                        // sku code
                        $('#' + id).closest('tr').find("input[id='sku_CodeOrder']").val(value["sku_code"]);
                        // batch code
                        // $('#'+id).closest('tr').find("input[id='batch_CodeReq']").val(value["batch_code"]);
                        // category
                        $('#' + id).closest('tr').find("input[id='categoryOrder']").val(value["product_category"]);
                        // productNameReq
                        $('#' + id).closest('tr').find("input[id='productNameOrder1']").val(value["product_name"]);
                        // unit price
                        $('#' + id).closest('tr').find("input[id='unitPriceOrder']").val(value["min_sale_price"]);
                    }
                });
            }
        });
    }

    // calender
    function invoiceBackDateDesabale() {
        let today1 = new Date();
        let dd1 = today1.getDate();
        let mm1 = today1.getMonth() + 1;
        let yyyy1 = today1.getFullYear();
        if (dd1 < 10) {
            dd1 = '0' + dd1.toString();
        }
        if (mm1 < 10) {
            mm1 = '0' + mm1.toString();
        }
        today1 = yyyy1 + '-' + mm1 + '-' + dd1;
        return today1
    };
    $('#receiptDateOrder').attr('min', invoiceBackDateDesabale());
    // //end calender


    // All list purchase quotation
    getPurchaseQuotationNo();

    // purchase quotation number
    function getPurchaseQuotationNo() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-RequestAllQuotation')}}",
            success: function(response) {

                $('#purchaseQuotationNum').html('');
                $('#purchaseQuotationNum').append('<option value="">Select Requisition ID</option>');
                jQuery.each(response, function(key, value) {
                    $('#purchaseQuotationNum').append(
                        '<option value="' + value["id"] + '">\
                    ' + value["purchase_requisition"] + '\
                    </option>'
                    );
                });

            }
        });
    }
    $(document).ready(function() {
        getVendorNamesOrder();
    })


    // select quotation number to fill all detials
    function getPurchaseQuotation() {
        let pro = this.event.target.id;
        let id = $('#' + pro).val();
        jQuery(".productTableBodyOrder").html('');

        // getVendorNamesOrder();

        getPurchaseOrderDetials(id);


        function getPurchaseOrderDetials(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetSingleQuotation')}}",
                data: {
                    "id": id
                },
                success: function(response) {

                    // console.log('quotation no.');
                    // console.log(response);
                    // console.log('end');

                    jQuery.each(response, function(key, value) {
                        $('#vendorNameOrder').val(value["vendor_id"]);
                        $('#purQut').val(value["purchase_requisition"]);
                        // $('.vendorNameOrder').val(value["vendor_name"]).trigger("change");
                        getProductsReq1();
                        $('.addOrderDeadline').val(value["order_deadline"]);
                        $('.gstTreatmentOrder').val(value["gst_treatment"]);
                        $('.vendorReferenceOrder').val(value["vendor_reference"]);
                        $('.untaxtedAmountOrder').val(value["untaxted_amount"]);
                        $('.untaxtedAmountOrder1').val(value["untaxted_amount"]);
                        $('#notesOrder').val(value["note"]);
                        $('.gstOrder').val(value["GST"]);
                        $('.gstOrder1').val(value["GST"]);
                        $('.quotationTotalOrder').val(value["total"]);
                        $('.quotationTotalOrder1').val(value["total"]);

                        $('#gstValuePurchaseOrder').val(value['gstpercentage']);

                        if (value["confirmation"] != null) {
                            $(".askForConfirmPurchaseOrder").prop("checked", true);
                        }

                        $('#askForConfirmPurchaseOrder').attr('readonly', true);

                        $('#taxIncludePurchaseOrder').attr('readonly', true);

                        $('#gstValuePurchaseOrder').attr('readonly', true);

                        if (value["tax_inclusive"] == 1) {
                            $('#taxIncludePurchaseOrder').prop('checked', true);
                        } else {
                            $('#taxIncludePurchaseOrder').prop('checked', false);
                            $('#gstOrder').val('');
                        }

                        let sno = 0;

                        let str = value["products"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value) {
                            $('.productsTableOrder tbody').append('<tr class="child">\
                                    <td>' + ++sno + '</td>\
                                    <td class="product_Id" style="display:none;">' + value["product_Id"] + '</td>\
                                    <td class="product_name">' + value["product_name"] + '</td>\
                                    <td class="product_category">' + value["category"] + '</td>\
                                    <td class="product_varient">' + value["product_varient"] + '</td>\
                                    <td class="product_desc">' + value["description"] + '</td>\
                                    <td class="product_quantity">' + value["quantity"] + '</td>\
                                    <td class="unit_price">' + value["unitPrice"] + '</td>\
                                    <td class="taxes"  style="display: none;">' + value["taxes"] + '</td>\
                                    <td class="subtotal">' + value["subTotal"] + '</td>\
                                    <td class="netAmountOrder">' + value["netAmount"] + '</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="remCF1AddOrder">\
                                            <i class="mdi mdi-delete"></i>\
                                        </a>\
                                    </td>\
                                </tr>');
                        });
                    });
                }
            });
        }
    }


    $(document).on('keyup', "input[id='quantityOrder']", function(e) {
        calculateOrderTax()
    });

    function calculateOrderTax() {

        let quantity = $("input[id='quantityOrder']").val();
        let price = $("input[id='unitPriceOrder']").val();
        let taxes = $("input[id='taxesOrder']").val();

        // +parseFloat(taxes)
        let subtotal = parseFloat(quantity) * parseFloat(price);
        $("input[id='subTotalOrder']").val(subtotal);

        // gst value 
        let gstValue = $('#gstValuePurchaseOrder').val();
        price = subtotal;
        let totalGST = (parseFloat(price) * parseFloat(gstValue)) / 100;

        if ($('#taxIncludePurchaseOrder').prop('checked')) {
            $('#netAmountOrder').val(subtotal + totalGST);
        } else {
            $('#netAmountOrder').val(subtotal);
        }

        $("input[id='taxesOrder']").val(totalGST);
    }

    $(document).on('keyup', "input[id='unitPriceOrder']", function(e){
        let newPrice = $(this).val();
        let quantity = $('#quantityOrder').val();
        
        let subtotal = parseFloat(quantity)*parseFloat(newPrice);
        $(this).closest('tr').find("input[id='subTotalOrder']").val(subtotal);

            $gstValue = $('#gstValuePurchaseOrder').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxIncludePurchaseOrder').prop('checked')){
                $('#netAmountOrder').val(subtotal+$totalGST);
            }else{
                $('#netAmountOrder').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxesOrder']").val($totalGST);
    });

     // increase and decresse change gst
     $('#gstValuePurchaseOrder').on('keyup change keydown', function() {
        // let quantity = $('input[id="quantityOrder"]').val();
        // let price = $("input[id='unitPriceOrder']").val();
        // if (quantity != "" && price != "") {
        //     // calculateOrderTax();
        //     checkedTaxCondationOrders();
        // }
        // if (quantity == "" && price == "") {
        //     addedOrderItemChangeTax();
        // }
        calculateOrder();

    });

    // Addes item change gst

    function addedOrderItemChangeTax() {
        $("#productTableBodyOrder > tr").each(function(e) {
            let quantity = parseFloat($(this).find('.product_quantity').text());
            let price = parseFloat($(this).find(".unit_price").text());
            let taxes = parseFloat($(this).find(".taxes").text());
            let subtotal = parseFloat($(this).find(".subtotal").text());
            // gst value 
            $gstValue = $('#gstValuePurchaseOrder').val();
            $price = subtotal;
            $totalGST = ($price * $gstValue) / 100;
            if ($('#taxIncludePurchaseOrder').prop('checked')) {
                $(this).find('.netAmountOrder').text($price + $totalGST);

            } else {
                $(this).find('.netAmountOrder').text(subtotal);
            }
            $(this).find(".taxes").text($totalGST);
        })

    }

    //checked before add
    // $('#taxIncludePurchaseOrder').on('click', function(e) {
    //     checkedTaxCondationOrders();
    // });
    // function checkedTaxCondationOrders(){
    //     if ($('#taxIncludePurchaseOrder').prop('checked')) {
    //         switch ($('#netAmountOrder').val()) {
    //             case "NaN":
    //                 $('#netAmountOrder').val("");
    //                 break;
    //             case null:
    //                 $('#netAmountOrder').val("");
    //                 break;
    //             case "":
    //                 $('#netAmountOrder').val("");
    //                 break;
    //             default:
    //                 $('#netAmountOrder').val($price + $totalGST);
    //                 break;

    //         }
    //     } else {
    //         switch ($('#netAmountOrder').val()) {
    //             case "NaN":
    //                 $('#netAmountOrder').val("");
    //                 break;
    //             case null:
    //                 $('#netAmountOrder').val("");
    //                 break;
    //             case "":
    //                 $('#netAmountOrder').val("");
    //                 break;
    //             default:
    //                 $('#netAmountOrder').val($price);
    //                 break;
    //         }
    //     }

    // }


let vendorNameArr = [];
    // get customer list
    function getVendorNamesOrder() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchAllVendor')}}",
            success: function(response) {

                vendorNameArr = response;
                
                $('#vendorNameOrder').html('');
                $('#vendorNameOrder').append('<option value="">Select Vendor Name</option>');
                jQuery.each(response, function(key, value) {
                    $('#vendorNameOrder').append(
                        '<option value="' + value["id"] + '">\
                            ' + value["vendor_name"] + '\
                            </option>'
                    );
                });
            }
        });
    }

    // function getVendorNameFn() {
    //     let id = $('#vendorNameOrder').val();

    //     jQuery.each(vendorNameArr, function(key, value){
    //         if(value['id'] == id){
    //             $('#vendorIdOrder').val(value['vendor_name']);
    //         }
    //     });

    //     getProductsReq1();

    // }

    // $('#vendorNameOrder').change(function() {
    //     id = $(this).val();
    //     getProductsReq1(id)
    // });

    // // getProductsReq();

    // function getProductsReq1(id) {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('SA-GetAllProducts')}}",
    //         data: {
    //             id: id
    //         },
    //         success: function(response) {
    //             $('#productNameOrder').empty();
    //             $('#productNameOrder').append('<option value="">Select Product</option>');
    //             jQuery.each(response, function(key, value) {
    //                 $('#productNameOrder').append(
    //                     '<option value="' + value["product_name"] + '">\
    //                             ' + value["product_name"] + '\
    //                         </option>'
    //                 );
    //             });
    //         }
    //     });
    // }

    let proDetailsArr1 = [];
        
        function getProductsReq1(){

            // let id = this.event.target.id;
            // alert('fn called');
            // alert($('#vendorIdOrder').val());

            let pro = $('#vendorNameOrder').val();
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetAllProductsaw')}}",
                data : {
                    'id' : pro,
                },
                success : function (response){

                    // console.log(response);

                    proDetailsArr1 = response;
                    
                    let productsName1 = [];

                    jQuery.each(proDetailsArr1, function(key, value){
                        productsName1.push(value['product_name']);
                    });

                    var uniqueArray1 = [];
        
                    for(i=0; i < productsName1.length; i++){
                        if(uniqueArray1.indexOf(productsName1[i]) === -1) {
                            uniqueArray1.push(productsName1[i]);
                        }
                    }

                    $('#productNameOrder').html('');
                    $('#productNameOrder').append('<option value="">Select Product</option>');
                    jQuery.each(uniqueArray1, function(key, value){
                        $('#productNameOrder').append(
                            '<option value="'+value+'">\
                            '+value+'\
                            </option>'
                        );
                    });
                }
            });
        };






    // function selectFunctionOrder(){
    // let id = this.event.target.id;
    // let pro = $('#'+id).val();
    // getProduct(pro, id);

    // console.log('function called');

    //     get single product details
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
    //                 $('#'+id).closest('tr').find("input[id='productId']").val(value["id"]);
    //                 // productNameOrder1
    //                 $('#'+id).closest('tr').find("input[id='productNameOrder1']").val(value["product_name"]);
    //                 // variend
    //                 $('#'+id).closest('tr').find("input[id='varientOrder']").val(value["product_varient"]);
    //                 // category
    //                 $('#'+id).closest('tr').find("input[id='categoryOrder']").val(value["product_category"]);
    //                 // sku
    //                 $('#'+id).closest('tr').find("input[id='sku_CodeOrder']").val(value["sku_code"]);
    //                 // batch
    //                 $('#'+id).closest('tr').find("input[id='batch_CodeOrder']").val(value["batch_code"]);
    //                 // unit price
    //                 $('#'+id).closest('tr').find("input[id='unitPriceOrder']").val(value["min_sale_price"]);
    //                 // taxes
    //                 // $('#'+id).closest('tr').find("input[id='taxesOrder']").val(value["tax"]);
    //             });
    //         }
    //     });
    // }
    // };

    let allProductDetailsOrder = [];

    // Table
    $('#addProductOrder').on('click', function() {

        let order_product_id = $('#productId').val();
        let productName = $('#productNameOrder1').val();
        let varient = $('#varientOrder').val();
        let category = $('#categoryOrder').val();
        let sku_code = $('#sku_CodeOrder').val();
        let description = $('#descriptionOrder').val();
        let quantity = $('#quantityOrder').val();
        let unitPrice = $('#unitPriceOrder').val();
        let taxes = $('#taxesOrder').val();
        let subTotal = $('#subTotalOrder').val();
        let netAmountOrder = $('#netAmountOrder').val();

        let slno = $('#productsTableOrder tr').length;

        $("#productTableBodyOrder > tr").each(function(e) {
            let findProductId = $(this).find('.product_Id').text();
            let findProductName = $(this).find('.product_name').text();

            if (order_product_id == findProductId) {
                $('#addProductExitstAlert').show();
                $('#addProductContent').html('');
                $('#addProductContent').html('Product already added.');
                order_product_id = '';
                productName = '';
                varient = '';
                category = '';
                sku_code = '';
                description = '';
                quantity = '';
                unitPrice = '';
                taxes = '';
                subTotal = '';
                netAmountOrder = '';
                alertHideFun();
            }
        });

        if (productName != "" && varient != "" && category != "" && quantity != "" && unitPrice != "" && taxes != "" && subTotal != "") {
            $('#productsTableOrder tbody').append('<tr class="child">\
                                                <td>' + slno + '</td>\
                                                <td class="product_Id" style="display:none;">' + order_product_id + '</td>\
                                                <td class="product_name">' + productName + '</td>\
                                                <td class="product_category">' + category + '</td>\
                                                <td class="product_varient">' + varient + '</td>\
                                                <td class="product_desc">' + description + '</td>\
                                                <td class="product_quantity">' + quantity + '</td>\
                                                <td class="unit_price">' + unitPrice + '</td>\
                                                <td class="taxes"  style="display: none;" >' + taxes + '</td>\
                                                <td class="subtotal">' + subTotal + '</td>\
                                                <td class="netAmountOrder">' + netAmountOrder + '</td>\
                                                <td>\
                                                    <a href="javascript:void(0);" class="remCF1AddOrder">\
                                                        <i class="mdi mdi-delete"></i>\
                                                    </a>\
                                                </td>\
                                            </tr>');
            calculateOrder();

            $('#productNameOrder').val('');
            $('#productId').val('');
            $('#productNameOrder1').val('');
            $('#varientOrder').val('');
            $('#categoryOrder').val('');
            $('#sku_CodeOrder').val('');
            $('#descriptionOrder').val('');
            $('#quantityOrder').val(0);
            $('#unitPriceOrder').val(0);
            $('#taxesOrder').val(0);
            $('#subTotalOrder').val(0);
            $('#netAmountOrder').val(0);

            if ($('#productTableBodyOrder').children().length === 0) {
                // $('#createOrdertableEmptyError').html('Please add products details.');
                errorMsg('Please add products details');
            } else {
                $('#createOrdertableEmptyError').html('');
            }
        }else{
            errorMsg('Please fill mandatory field');
        }
    });

    $('#taxIncludePurchaseOrder').change(function() {
        calculateOrder();

        // $('#categoryOrder').val('');
        // $('#sku_CodeOrder').val('');
        // $('#descriptionOrder').val('');
        // $('#quantityOrder').val('');
        // $('#unitPriceOrder').val('');
        // $('#taxesOrder').val('');
        // $('#subTotalOrder').val('');
        // $('#netAmountOrder').val('');

        // $("#productTableBodyOrder > tr").each(function(e) {
        //     let unitPrice = $(this).find('.unit_price').text();
        //     let taxes = $(this).find('.taxes').text();
        //     let subTotal = $(this).find('.subtotal').text();
        //     let netAmountOrder = $(this).find('.netAmountOrder').text();

        //     let amount = parseFloat(taxes) + parseFloat(subTotal);

        //     if ($('#taxIncludePurchaseOrder').prop('checked')) {
        //         $(this).find('.netAmountOrder').text(amount);
        //     } else {
        //         $(this).find('.netAmountOrder').text(subTotal);
        //     }

        // });


    });

    function calculateOrder() {

        let tax = $('#gstValuePurchaseOrder').val();

        let quantity = $('#quantityOrder').val();

        let unitPrice = $('#unitPriceOrder').val(); 

        let subTotal = parseFloat(quantity)*parseFloat(unitPrice);
        let taxes = ((parseFloat(quantity)*parseFloat(unitPrice))*parseFloat(tax))/100;

        $('#taxesOrder').val(taxes);
        $('#subTotalOrder').val(subTotal);

        if ($('#taxIncludePurchaseOrder').prop('checked')) {
            $('#netAmountOrder').val(subTotal+taxes);
        } else {
            $('#netAmountOrder').val(subTotal);
        }

        $("#productTableBodyOrder > tr").each(function(e) {

            unitPrice = $(this).find('.unit_price').text();

            quantity = $(this).find('.product_quantity').text();

            subTotal = parseFloat(unitPrice)*parseFloat(quantity);

            $(this).find('.subtotal').text(subTotal);

            taxes = (parseFloat(subTotal)*parseFloat(tax))/100;

            $(this).find('.taxes').text(taxes);

            if ($('#taxIncludePurchaseOrder').prop('checked')) {
                $(this).find('.netAmountOrder').text(subTotal + taxes);
            } else {
                $(this).find('.netAmountOrder').text(subTotal);
            }
        });

        let sum = 0;
        tax = 0;
        let i = 0;

        $("#productTableBodyOrder > tr").each(function() {
            sum += parseFloat($(this).find('.subtotal').text());
            tax += parseFloat($(this).find('.taxes').text());
        });

        $('#untaxtedAmountOrder').val(sum);
        $('#untaxtedAmountOrder1').val(sum);

        if ($('#taxIncludePurchaseOrder').prop('checked')) {
            $('#gstOrder').val(tax);
            $('#gstOrder1').val(tax);
            
            $('#quotationTotalOrder').val(parseFloat(sum)+parseFloat(tax));
            $('#quotationTotalOrder1').val(parseFloat(sum)+parseFloat(tax));
        } else {
            $('#gstOrder').val('');
            $('#gstOrder1').val('');

            $('#quotationTotalOrder').val(parseFloat(sum));
            $('#quotationTotalOrder1').val(parseFloat(sum));
        }

        // let sum = 0;
        // let tax = 0;
        // let i = 0;

        // $("#productTableBodyOrder tr .subtotal").each(function() {
        //     sum += parseFloat($(this).text());
        // });

        // $('#untaxtedAmountOrder').val(sum);
        // $('#untaxtedAmountOrder1').val(sum);
        // $('#quotationTotalOrder').val(sum);
        // $('#quotationTotalOrder1').val(sum);

        // $("#productTableBodyOrder tr .taxes").each(function() {
        //     tax += parseFloat($(this).text());
        // });

        // $('#gstOrder').val(tax);
        // $('#gstOrder1').val(tax);

        // // $('#taxIncludePurchaseOrder').change(function(){
        // if ($('#taxIncludePurchaseOrder').prop('checked')) {
        //     let untaxtedAmountOrder = parseFloat($('#untaxtedAmountOrder').val());
        //     let totalBill = untaxtedAmountOrder + tax;

        //     $('#quotationTotalOrder').val(totalBill);
        //     $('#quotationTotalOrder1').val(totalBill);
        // } else {
        //     let untaxtedAmountOrder = parseFloat($('#untaxtedAmountOrder').val());
        //     let totalBill = untaxtedAmountOrder;

        //     $('#gstOrder').val('');

        //     $('#quotationTotalOrder').val(totalBill);
        //     $('#quotationTotalOrder1').val(totalBill);
        // }
        // });

    };


    $(document).on('click', '.remCF1AddOrder', function() {

        $(this).parent().parent().remove();

        $('#productsTableOrder tbody tr').each(function(i) {
            $($(this).find('td')[0]).html(i + 1);
        });

        calculateOrder();
    });

        // validation script start here
        $(document).ready(function() {
            jQuery("#addPurchaseOrderForm").submit(function(e) {
                // getPurchaseQuotationNum();
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
                        create_purchase_order_by : {
                            required: true,
                        },
                        quotationNumber : {
                            required : function(element){
                                $('#purchaseOrderNo-error').hide();
                                return ('#purchaseOrderNo:blank' || '#purchaseQuotationNum:blank');
                            }
                        },
                        purchaseOrderNo : {
                            required : function(element){
                                $('#purchaseQuotationNum-error').hide();
                                return ('#purchaseOrderNo:blank' || '#purchaseQuotationNum:blank');
                            }
                        },               
                        vendorIdOrder : {
                            required: true,
                        },
                        receiptDate : {
                            required: true,
                        },
                        vendorReference : {
                            required: true,
                        },
                        billingStatus : {
                            required: true,
                        }
                },
                messages: {
                    quotationNumber: {
                        required : "One field is required in <b>Purchase Requisition Id</b> OR <b>Purchase Order</b>"
                    },
                    purchaseOrderNo: {
                        required : "One field is required in <b>Purchase Requisition Id</b> OR <b>Purchase Order</b>"
                    },
                    vendorIdOrder: {
                        required: "Please select vendor name."
                    },
                    receiptDate: {
                        required: "Please select Receipt Date.",
                    },
                    vendorReference: {
                        required: "Please enter vendor reference.",
                    },
                    billingStatus: {
                        required: "Please select billing status.",
                    }
                },
                submitHandler : function(){
                    allProductDetailsOrder.splice(0, allProductDetailsOrder.length);

                    $("#productTableBodyOrder > tr").each(function(e) {
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
                        let netAmountOrder = $(this).find('.netAmountOrder').text();


                        let dbData = {
                            "product_Id": productId,
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
                            "netAmount": netAmountOrder
                        }
                        allProductDetailsOrder.push(dbData);
                    });

                    if ($('#productTableBodyOrder').children().length === 0) {

                        // $('#createOrdertableEmptyError').html('Please add products details.');
                        errorMsg('Please add products details.');

                    } else {

                        // $('#createOrdertableEmptyError').html('');

                        
                        bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                            if(result){
                                jQuery.ajax({
                                    url: "{{ route('SA-AddPurchaseOrder') }}",
                                    data: jQuery("#addPurchaseOrderForm").serialize() + "&allProductDetails=" + JSON.stringify(allProductDetailsOrder),
                                    enctype: "multipart/form-data",
                                    type: "post",
                                    success: function(result) {
                                        // alertHideFun();

                                        $('#askForConfirmPurchaseOrder').removeAttr('readonly');
                                        $('#taxIncludePurchaseOrder').removeAttr('readonly');
                                        $('#gstValuePurchaseOrder').removeAttr('readonly');
                                        $("#purchaseQuotationNum").removeAttr('disabled');

                                        if (result.error != null) {
                                            errorMsg(result.error);
                                        } else if (result.barerror != null) {
                                            jQuery("#addOrderAlert").hide();
                                            errorMsg(result.barerror);
                                        } else if (result.success != null) {
                                            successMsg(result.success);
                                            $('.modal .close').click();
                                            purchase_invoice_main_table.ajax.reload();
                                            jQuery("#addPurchaseOrderForm")["0"].reset();
                                            jQuery("#productsTableOrder tbody").html('');
                                            jQuery("#productTableBodyOrder").html('');
                                            allProductDetailsOrder.splice(0, allProductDetailsOrder.length);
                                            getPurchaseQuotationNo();
                                        } else {
                                            jQuery(".alert-danger").hide();
                                            jQuery("#addOrderAlert").hide();
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

</script>