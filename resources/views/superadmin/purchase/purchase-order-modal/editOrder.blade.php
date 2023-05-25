<!-- Modal -->
<div class="modal fade" id="editOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Purchase Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="editPurchaseOrderForm">
                <div class="modal-body bg-white px-3">
                    <!-- invoice body start here -->

                    <!-- info & alert section -->
                    <div class="alert alert-success" id="editOrderAlert" style="display:none"></div>
                    <div class="alert alert-danger" style="display:none">
                        <ul></ul>
                    </div>
                    <!-- end -->

                    <input type="text" name="id" id="orderId" style="display: none;">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorNameOrder">Purchase Requisition No.</label>
                            <input type="text" name="purchaseRequisitionNo" class="form-control" id="purchaseQuotationNumEdit" placeholder="Purchase Requisition No." readonly />
                            
                            <!-- <input type="text"  name="quotationNumber" class="form-control" onchange="selectPurchaseQuotationNumEdit()" id="purchaseQuotationNumEdit"> -->
                        </div>
                        <!-- <div class="col-md-0 form-control text-center border-0 fw-bold text-dark">
                            <label for="vendorNameOrder"></label>
                            <h6></h6>
                        </div> -->
                        <div class="col-md-6">
                            <label for="vendorNameOrder">Purchase Order No.</label>
                            <input type="text" class="form-control text-dark" name="purchase_order" id="refOrderNumEdit" placeholder="Purchase Order" readonly />
                        </div>
                    </div>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorNameOrderEdit">Vendor<span style="color:red; font-size:medium">*</span></label>
                            <!-- <select name="vendorName" class="form-control" onchange="selectVendorsOrderEdit()" id="vendorNameOrderEdit" readonly></select> -->
                            <input type="text" name="vendorName" class="form-control" id="vendorNameOrderEdit" readonly />
                        </div>
                        <div class="col-md-6">
                            <label for="receiptDateOrder">Receipt Date<span style="color:red; font-size:medium">*</span></label>
                            <input type="date" name="receiptDate" id="receiptDateOrderEdit" value="<?= date('Y-m-d') ?>" class="form-control" placeholder="Receipt Date" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="vendorReferenceOrder">Vendor Reference<span style="color:red; font-size:medium">*</span></label>
                            <input type="text" name="vendorReference" id="vendorReferenceOrderEdit" class="form-control" placeholder="Vendor Reference" />
                        </div>
                        <div class="col-md-6">
                            <label for="billingStatus">Billing Status<span style="color:red; font-size:medium">*</span></label>
                            <select name="billingStatus" id="billingStatusEdit" class="form-control">
                                <option value="">Select Billing Status</option>
                                <option value="paid">Paid</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="checkbox" class="mt-4" name="askForConfirm" value="confirm" id="askForConfirmOrderEdit"> <label for="askForConfirmOrder" class="mt-4 text-primary">Ask for Confirmation</label>
                        </div>
                        <div class="col-md-6">
                            <!-- <input type="checkbox" name="taxInclude" id="taxIncludeOrderEdit"> <label for="taxIncludeOrderEdit" class="text-primary">Tax inclusive</label> -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="input-group">
                                        <label for="taxInclude" class="text-primary form-control"><input type="checkbox" name="taxInclude" id="taxIncludeOrderEdit"> Tax inclusive</label>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="gstValue" value="7" id="gstValueOrderEdit" min="1" placeholder="GST (In %)" />
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
                            <fieldset class="border border-secondary ">
                                <legend class="float-none w-auto ">Order Details<span style="color:red; font-size:medium">*</span></legend>
                                <span style="color:red; font-size:small;" id="editOrdertableEmptyError"></span>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table border" id="products">
                                        <thead>
                                            <tr>
                                                <th class=" border border-secondary">Product</th>
                                                <!-- <th class=" border border-secondary">ID</th> -->
                                                <th class=" border border-secondary">Variant</th>
                                                <th class=" border border-secondary">Category</th>
                                                <!-- <th class=" border border-secondary">SKU Code</th> -->
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
                                            <tr>
                                                <form id="addProductForm0">
                                                    <!-- product -->
                                                    <td class=" border border-secondary">
                                                        <select id="productNameOrderEdit" onchange="selectFunctionOrderEdit()" class="form-control form-control-lg">
                                                            <option value="">Select Product</option>
                                                        </select>
                                                    </td>
                                                    <!-- productId -->
                                                    <!-- Hide content -->
                                                    <td class=" border border-secondary" style="display: none;">
                                                        <input type="text" id="productIdEdit" class="form-control" placeholder="Id">
                                                        <input type="text" id="productNameOrderEdit1" class="form-control" placeholder="Id">
                                                    </td>
                                                    <!-- varient -->
                                                    <td class=" border border-secondary">
                                                        <!-- <input type="text"  id="varientOrderEdit" class="form-control" placeholder="Varient" disabled /> -->
                                                        <select name="varient" id="varientOrderEdit" class="form-control" onchange="selectEditOrderFunction()">
                                                            <option value="">Select Variant</option>
                                                        </select>
                                                    </td>
                                                    <!-- category -->
                                                    <td class=" border border-secondary">
                                                        <input type="text" id="categoryOrderEdit" class="form-control" placeholder="Category" disabled />
                                                    </td>

                                                    <!-- sku code -->
                                                    
                                                    <!-- <td class=" border border-secondary">
                                                        <input type="text" id="sku_CodeOrderEdit" class="form-control" placeholder="SKU Code" disabled />
                                                    </td> -->

                                                    <!-- batch code -->

                                                    <!-- <td class=" border border-secondary">
                                                        <input type="text"  id="batch_CodeOrderEdit" class="form-control" placeholder="Batch Code" />
                                                    </td> -->

                                                    <!-- Description -->
                                                    <td class=" border border-secondary">
                                                        <input type="text" id="descriptionOrderEdit" class="form-control" placeholder="Description">
                                                    </td>
                                                    <!-- Quantity -->
                                                    <td class=" border border-secondary">
                                                        <input type="text" id="quantityOrderEdit" value="0" class="form-control" placeholder="Quantity">
                                                    </td>
                                                    <!-- unit price -->
                                                    <td class=" border border-secondary">
                                                        <input type="text" id="unitPriceOrderEdit" value="0" class="form-control" placeholder="Unit Price" />
                                                    </td>
                                                    <!-- taxes -->
                                                    <td class=" border border-secondary" style="display: none;">
                                                        <input type="text" id="taxesOrderEdit" value="0" class="form-control" placeholder="Taxes" disabled />
                                                    </td>
                                                    <!-- sub total -->
                                                    <td class=" border border-secondary">
                                                        <input type="text" id="subTotalOrderEdit" value="0" class="form-control" placeholder="Gross Amount" disabled />
                                                    </td>
                                                    <!-- net amount -->
                                                    <td class=" border border-secondary">
                                                        <input type="text" id="netAmountEdit" value="0" class="form-control" placeholder="Net Amount" disabled />
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    <a id="addProductOrderEdit" class="btn btn-primary text-white">Add Product</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                    <table class="table text-center border" id="productsTableOrderEdit" style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Variant</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Gross Amount</th>
                                                <th>Net Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="productTableBodyOrderEdit"></tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <!-- <a href="#" class="btn btn-secondary my-2">Send invoice by email</a> -->
                            <input type="text" name="notes" id="notesOrderEdit" class="form-control" placeholder="Add an Internal Note" />
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">Sub Total</div>
                                <div class="col-md-7 my-auto">
                                    <input type="text" name="untaxtedAmount1" id="untaxtedAmountOrderEdit" class="form-control " placeholder="Sub Total" disabled>
                                    <input type="text" name="untaxtedAmount" id="untaxtedAmountOrderEdit1" class="form-control " placeholder="Sub Total" style="display: none;">
                                </div>
                            </div>
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">GST</div>
                                <div class="col-md-7 my-auto">
                                    <input type="text" name="gst1" id="gstOrderEdit" class="form-control" placeholder="GST" disabled >
                                    <input type="text" name="gst" id="gstOrderEdit1" class="form-control" placeholder="GST" style="display: none;" >   
                                </div>
                            </div>
                            <hr />
                            <div class="row mx-auto my-1">
                                <div class="col-md-5 my-auto">Grand Total</div>
                                <div class="col-md-7 my-auto">
                                    <input type="text" id="quotationTotalOrderEdit" name="quotationTotal1" class="form-control" name="totalBill" placeholder="Grand Total" disabled>
                                    <input type="text" id="quotationTotalOrderEdit1" name="quotationTotal" class="form-control" name="totalBill" placeholder="Grand Total" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- end here -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editOrderPurchaseFormClearBtn">Clear</button>
                    <button type="submit" id="editPurchaseOrderForm1" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#editOrderPurchaseFormClearBtn').on('click', function() {
        $('#editPurchaseOrderForm')["0"].reset();
        $('#productTableBodyOrderEdit').html('');
    });


    // disable Quotation and checkBox
    // $("#taxIncludeOrderEdit").attr('disabled', 'disabled');
    // $("#refOrderNumEdit").on({
    //     focus: function() {
    //         $("#purchaseQuotationNumEdit").attr('disabled', 'disabled');
            // $("#taxIncludeOrderEdit").removeAttr('disabled');
           
            

        // },
        // blur: function() {
        //     let quotaionId = $("#refOrderNumEdit");
        //     if (quotaionId.val() != "") {
        //         $("#purchaseQuotationNumEdit").attr('disabled', 'disabled');
                // $("#taxIncludeOrderEdit").removeAttr('disabled');

            // } else {
            //     $("#purchaseQuotationNumEdit").removeAttr('disabled');
                // $("#taxIncludeOrderEdit").attr('disabled', 'disabled');

    //         }
    //     }
    // });


    // validation script start here
    $(document).ready(function() {
        // ==================================================================================
        // store data to database
        // ==================================================================================
        jQuery("#editPurchaseOrderForm").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
       
            getPurchaseQuotationNumEdit();

            $.validator.addMethod("validate", function(value) {
                return /[A-Za-z]/.test(value);
            });

        }).validate({
            rules: {
                quotationNumber: {
                    // required: true,
                },
                vendorName: {
                    required: true,
                },
                receiptDate: {
                    required: true,
                },
                vendorReference: {
                    required: true,
                },
                billingStatus: {
                    required: true,
                }
            },
            messages: {
                quotationNumber: {
                    // required: "Please select quotation number."
                },
                vendorName: {
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
            submitHandler: function(){

                if ($('#productTableBodyOrderEdit').children().length === 0) {
                    // $('#editOrdertableEmptyError').html('Please add products details.');
                    errorMsg('Please add products details.');
                } else {

                    allProductDetailsOrderEdit.splice(0, allProductDetailsOrderEdit.length);

                    $("#productTableBodyOrderEdit > tr").each(function(e) {
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
                        let netAmountEdit = $(this).find('.netAmountEdit').text();

                        let dbData = {
                            "product_Id": productId,
                            "product_name": productName,
                            "product_varient": varient,
                            "category": category,
                            "description": description,
                            "taxes": taxes,
                            "sku_code": sku_code,
                            "batch_code": batch_code,
                            "quantity": quantity,
                            "unitPrice": unitPrice,
                            "taxes": taxes,
                            "subTotal": subTotal,
                            "netAmount": netAmountEdit,
                        }
                        allProductDetailsOrderEdit.push(dbData);
                    });

                    bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                        if(result){
                            jQuery.ajax({
                                url: "{{ route('SA-UpdateOrderDetails') }}",
                                data: jQuery("#editPurchaseOrderForm").serialize() + "&allProductDetails=" + JSON.stringify(allProductDetailsOrderEdit),
                                enctype: "multipart/form-data",
                                type: "post",
                                success: function(result) {
                                    // alertHideFun();
                                    if (result.error != null) {
                                        errorMsg(result.error);
                                    } else if (result.barerror != null) {
                                        errorMsg(result.barerror);
                                    } else if (result.success != null) {
                                        $('.modal .close').click();
                                        successMsg(result.success);
                                        jQuery("#editPurchaseOrderForm")["0"].reset();
                                        jQuery("#productsTableOrderEdit tbody").html('');
                                        jQuery("#productTableBodyOrderEdit").html('');
                                        allProductDetailsOrderEdit.splice(0, allProductDetailsOrderEdit.length);
                                        purchase_invoice_main_table.ajax.reload();
                                    } else {
                                        jQuery(".alert-danger").hide();
                                        jQuery("#editOrderAlert").hide();
                                    }
                                },
                            });
                        }
                    });
                    $('#editOrdertableEmptyError').html('');
                }

            }
        });
    });
    // end here


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
    $('#receiptDateOrderEdit').attr('min', invoiceBackDateDesabale());
    // //end calender

    // All list purchase quotation
    getPurchaseQuotationNumEdit();

    // purchase quotation number
    function getPurchaseQuotationNumEdit() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-RequestAllQuotation')}}",
            success: function(response) {
                $('#purchaseQuotationNumEdit').html('');
                $('#purchaseQuotationNumEdit').append('<option value="">Select Requisition No.</option>');
                jQuery.each(response, function(key, value) {
                    $('#purchaseQuotationNumEdit').append(
                        '<option value="' + value["id"] + '">\
                    ' + value["id"] + '\
                    </option>'
                    );
                });
            }
        });
    }

    $(document).ready(function() {
        getVendorNamesOrderEdit();
    })

    // selectPurchaseQuotationNumEdit(id);
    // select quotation number to fill all detials
    function selectPurchaseQuotationNumEdit() {

        let pro = this.event.target.id;
        let id = $('#' + pro).val();

        jQuery("#productTableBodyOrderEdit").html('');

        getPurchaseOrderDetialsEdit(id);

        function getPurchaseOrderDetialsEdit(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetSingleQuotation')}}",
                data: {
                    "id": id
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#vendorNameOrderEdit').val(value["vendor_name"]);
                        getProductsOrderEdit(value["vendor_id"]);
                        $('#addOrderDeadlineEdit').val(value["order_deadline"]);
                        $('#gstTreatmentOrderEdit').val(value["gst_treatment"]);
                        $('#receiptDateOrderEdit').val(value["receipt_date"]);
                        $('#vendorReferenceOrderEdit').val(value["vendor_reference"]);
                        $('#untaxtedAmountOrderEdit').val(value["untaxted_amount"]);
                        $('#untaxtedAmountOrderEdit1').val(value["untaxted_amount"]);
                        $('#notesOrder').val(value["note"]);
                        $('#gstOrderEdit').val(value["GST"]);
                        $('#gstOrderEdit1').val(value["GST"]);
                        $('#quotationTotalOrderEdit').val(value["total"]);
                        $('#quotationTotalOrderEdit1').val(value["total"]);

                        if (value["confirmation"] == "confirm") {
                            $("#askForConfirmOrderEdit").prop("checked", true);
                        }

                        if (value["tax_inclusive"] == 1) {
                            $('#taxIncludeOrderEdit').prop('checked', true);
                        } else {
                            $('#taxIncludeOrderEdit').prop('checked', false);
                            $('#gstOrderEdit').val('');
                        }

                        let sno = 0;

                        let str = value["products"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value) {
                            $('#productsTableOrderEdit tbody').append('<tr class="child">\
                                    <td>' + ++sno + '</td>\
                                    <td class="product_Id">' + value["product_Id"] + '</td>\
                                    <td class="product_name">' + value["product_name"] + '</td>\
                                    <td class="product_category">' + value["category"] + '</td>\
                                    <td class="product_varient">' + value["product_varient"] + '</td>\
                                    <td class="product_desc">' + value["description"] + '</td>\
                                    <td class="product_quantity">' + value["quantity"] + '</td>\
                                    <td class="unit_price">' + value["unitPrice"] + '</td>\
                                    <td class="taxes"  style="display: none;">' + value["taxes"] + '</td>\
                                    <td class="subtotal">' + value["subTotal"] + '</td>\
                                    <td class="netAmountEdit">' + value["netAmount"] + '</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="remCF1EditOrder">\
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
    //  gst on click effect
    $(document).on('keyup', "input[id='quantityOrderEdit']", function(e) {
        calculateEditOrder();
    });
    function calculateEditOrder(){
        let quantity = $("input[id='quantityOrderEdit']").val();
        let price = $("input[id='unitPriceOrderEdit']").val();
        let taxes = $("input[id='taxesOrderEdit']").val();

        // +parseFloat(taxes)
        let subtotal = parseFloat(quantity) * parseFloat(price);
        $("input[id='subTotalOrderEdit']").val(subtotal);

        // gst value 
        $gstValue = $('#gstValueOrderEdit').val();
        $price = subtotal;
        $totalGST = ($price * $gstValue) / 100;

        if ($('#taxIncludeOrderEdit').prop('checked')) {
            $('#netAmountEdit').val(subtotal + $totalGST);
        } else {
            $('#netAmountEdit').val(subtotal);
        }

        $("input[id='taxesOrderEdit']").val($totalGST);
    }

    $(document).on('keyup', "input[id='unitPriceOrderEdit']", function(e){
        let newPrice = $(this).val();
        let quantity = $('#quantityOrderEdit').val();
        
        let subtotal = parseFloat(quantity)*parseFloat(newPrice);
        $(this).closest('tr').find("input[id='subTotalOrderEdit']").val(subtotal);

            $gstValue = $('#gstValueOrderEdit').val();
            $price = subtotal;
            $totalGST = ($price*$gstValue)/100;

            if($('#taxIncludeOrderEdit').prop('checked')){
                $('#netAmountEdit').val(subtotal+$totalGST);
            }else{
                $('#netAmountEdit').val(subtotal);
            }
            
            $(this).closest('tr').find("input[id='taxesOrderEdit']").val($totalGST);
    });

 // increase and decresse change gst
 $('#gstValueOrderEdit').on('keyup change keydown', function() {

        // let quantity = $('input[id="quantityOrderEdit"]').val();
        // let price = $("input[id='unitPriceOrderEdit']").val();
        // if (quantity != "" && price != "") {
        //     // calculateEditOrder();
        //     checkedTaxCondationOrders();
        // }
        // if (quantity == "" && price == "") {
        //     addedEditOrderItemChangeTax();
        // }

        calculateOrderEdit();

    });

    // Addes item change gst

    function addedEditOrderItemChangeTax() {
        $("#productTableBodyOrderEdit > tr").each(function(e) {
            let quantity = parseFloat($(this).find('.product_quantity').text());
            let price = parseFloat($(this).find(".unit_price").text());
            let taxes = parseFloat($(this).find(".taxes").text());
            let subtotal = parseFloat($(this).find(".subtotal").text());
            // gst value 
            $gstValue = $('#gstValueOrder').val();
            $price = subtotal;
            $totalGST = ($price * $gstValue) / 100;
            if ($('#taxIncludeOrderEdit').prop('checked')) {
                $(this).find('.netAmountEdit').text($price + $totalGST);

            } else {
                $(this).find('.netAmountEdit').text(subtotal);
            }
            $(this).find(".taxes").text($totalGST);
        })

    }

 //checked before add
//  $('#taxIncludeOrderEdit').on('click', function(e) {
//     // checkedTaxEditOrders();
// });
function checkedTaxEditOrders(){

        if ($('#taxIncludeOrderEdit').prop('checked')) {
            switch ($('#netAmountEdit').val()) {
                case "NaN":
                    $('#netAmountEdit').val("");
                    break;
                case null:
                    $('#netAmountEdit').val("");
                    break;
                case "":
                    $('#netAmountEdit').val("");
                    break;
                default:
                    $('#netAmountEdit').val($price + $totalGST);
                    break;

            }
        } else {
            switch ($('#netAmountEdit').val()) {
                case "NaN":
                    $('#netAmountEdit').val("");
                    break;
                case null:
                    $('#netAmountEdit').val("");
                    break;
                case "":
                    $('#netAmountEdit').val("");
                    break;
                default:
                    $('#netAmountEdit').val($price);
                    break;
            }
        }

    }

    // getVendorNamesOrderEdit();

    // get customer list
    function getVendorNamesOrderEdit() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchAllVendor')}}",
            success: function(response) {
                $('#vendorNameOrderEdit').html('');
                $('#vendorNameOrderEdit').append('<option value="">Select Vendor Name</option>');
                jQuery.each(response, function(key, value) {
                    $('#vendorNameOrderEdit').append(
                        '<option value="' + value["id"] + '">\
                            ' + value["vendor_name"] + '\
                            </option>'
                    );
                });
            }
        });
    }

    // #gstTreatmentOrderEdit
    

    // $('#vendorNameOrderEdit').change(function() {
    //     id = $(this).val();
    //     getProductsOrderEdit()
    // });

    // getProductsOrderEdit();

    // function getProductsOrderEdit(id) {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('SA-GetAllProducts')}}",
    //         data: {
    //             id: id
    //         },
    //         success: function(response) {
    //             $('#productNameOrderEdit').empty();
    //             $('#productNameOrderEdit').append('<option value="">Select Product</option>');
    //             jQuery.each(response, function(key, value) {
    //                 $('#productNameOrderEdit').append(
    //                     '<option value="' + value["product_name"] + '">\
    //                         ' + value["product_name"] + '\
    //                         </option>'
    //                 );
    //             });
    //         }
    //     });
    // }

    
        let proDetailsArrE1 = [];
        
        function getProductsOrderEdit(id){
            // let id = this.event.target.id;
            // alert('fn called');
            // alert($('#vendorIdOrder').val());
            // let pro = $('#vendorIdOrder').val();
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetAllProductsaw')}}",
                data : {
                    'id' : id,
                },
                success : function (response){

                    // console.log(response);

                    proDetailsArrE1 = response;
                    
                    let productsNameE1 = [];

                    jQuery.each(proDetailsArrE1, function(key, value){
                        productsNameE1.push(value['product_name']);
                    });

                    var uniqueArrayE1 = [];
        
                    for(i=0; i < productsNameE1.length; i++){
                        if(uniqueArrayE1.indexOf(productsNameE1[i]) === -1) {
                            uniqueArrayE1.push(productsNameE1[i]);
                        }
                    }

                    $('#productNameOrderEdit').html('');
                    $('#productNameOrderEdit').append('<option value="">Select Product</option>');
                    jQuery.each(uniqueArrayE1, function(key, value){
                        $('#productNameOrderEdit').append(
                            '<option value="'+value+'">\
                                '+value+'\
                            </option>'
                        );
                    });
                }
            });
        };


    function selectFunctionOrderEdit() {
        let id = this.event.target.id;
        let pro = $('#' + id).val();

        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetNameProducts')}}",
            data: {
                "val": pro,
            },
            success: function(response) {

                $('#varientOrderEdit').html('');
                $('#varientOrderEdit').append('<option value="">Select Variant</option>');
                jQuery.each(response, function(key, value){

                    if($('#productsTableOrderEdit tbody > tr').length == 0){
                        
                            $('#varientOrderEdit').append(
                                '<option value="'+value["product_varient"]+'">\
                                    '+value["product_varient"]+'\
                                </option>'
                            );

                    }else{
                        
                        let count = 0;

                        $("#productTableBodyOrderEdit tr").each(function(){
                            let proName = $(this).find('.product_name').text();
                            let proVarient = $(this).find('.product_varient').text();

                            if(proName == value['product_name'] && proVarient == value['product_varient']){
                                ++count;
                            }
                        });

                            if(count == 0){
                                $('#varientOrderEdit').append(
                                    '<option value="'+value["product_varient"]+'">\
                                        '+value["product_varient"]+'\
                                    </option>'
                                );
                            }
                    }
                });
            }
            // success: function(response) {
            //     $('#varientOrderEdit').html('');
            //     $('#varientOrderEdit').append('<option value="">Choose Varients</option>');
            //     jQuery.each(response, function(key, value) {
            //         $('#varientOrderEdit').append(
            //             '<option value="' + value["product_varient"] + '">\
            //                                         ' + value["product_varient"] + '\
            //                                     </option>'
            //         );
            //     });
            // }
        });
    };

    function selectEditOrderFunction() {
        let id = this.event.target.id;
        let varient = $('#' + id).val();
        let product = $('#productNameOrderEdit').val();

        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchProductsAllDetialsInfo')}}",
            success: function(response) {
                jQuery.each(response, function(key, value) {
                    if (value['product_name'] === product && value['product_varient'] === varient) {
                        // product id
                        $('#' + id).closest('tr').find("input[id='productIdEdit']").val(value["id"]);
                        // sku code
                        // $('#' + id).closest('tr').find("input[id='sku_CodeOrderEdit']").val(value["sku_code"]);
                        // batch code
                        // $('#'+id).closest('tr').find("input[id='batch_CodeReq']").val(value["batch_code"]);
                        // category
                        $('#' + id).closest('tr').find("input[id='categoryOrderEdit']").val(value["product_category"]);
                        // productNameReq
                        $('#' + id).closest('tr').find("input[id='productNameOrderEdit1']").val(value["product_name"]);
                        // unit price
                        $('#' + id).closest('tr').find("input[id='unitPriceOrderEdit']").val(value["min_sale_price"]);
                    }
                });
            }
        });
    }


    // Get GSTOrder Treatment by choocing vendor name
    function selectVendorsOrderEdit() {
        let id = this.event.target.id;
        let name = $('#' + id).val();
        getGSTOrder(name, id);

        //     get single product details
        function getGSTOrder(pro, id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GSTTreatment')}}",
                data: {
                    "name": name
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#gstTreatmentOrderEdit').val(value['GST']);
                    });
                }
            });
        }
    };

    // function selectFunctionOrderEdit(){
    //     let id = this.event.target.id;
    //     let pro = $('#'+id).val();
    //     getProduct(pro, id);

    // //     get single product details
    //     function getProduct(pro, id){
    //         $.ajax({
    //             type : "GET",
    //             url : "",
    //             data : {
    //                 "pro" : pro
    //             },
    //             success : function (response){
    //                 jQuery.each(response, function(key, value){
    //                     // product id
    //                     $('#'+id).closest('tr').find("input[id='productIdEdit']").val(value["id"]);
    //                     // productNameOrder1
    //                     $('#'+id).closest('tr').find("input[id='productNameOrderEdit1']").val(value["product_name"]);
    //                     // varient
    //                     $('#'+id).closest('tr').find("input[id='varientOrderEdit']").val(value["product_varient"]);
    //                     // category
    //                     $('#'+id).closest('tr').find("input[id='categoryOrderEdit']").val(value["product_category"]);
    //                     // sku code
    //                     $('#'+id).closest('tr').find("input[id='sku_CodeOrderEdit']").val(value["sku_code"]);
    //                     // batch code
    //                     $('#'+id).closest('tr').find("input[id='batch_CodeOrderEdit']").val(value["batch_code"]);
    //                     // unit price
    //                     $('#'+id).closest('tr').find("input[id='unitPriceOrderEdit']").val(value["min_sale_price"]);
    //                     // taxes
    //                     // $('#'+id).closest('tr').find("input[id='taxesOrderEdit']").val(value["tax"]);
    //                 });
    //             }
    //         });
    //     }
    // };

    let allProductDetailsOrderEdit = [];

    // Table
    $('#addProductOrderEdit').on('click', function() {
        let product_Id_Order = $('#productIdEdit').val();
        let productName = $('#productNameOrderEdit1').val();
        let varient = $('#varientOrderEdit').val();
        let category = $('#categoryOrderEdit').val();

        let description = $('#descriptionOrderEdit').val();
        let quantity = $('#quantityOrderEdit').val();
        let unitPrice = $('#unitPriceOrderEdit').val();
        let taxes = $('#taxesOrderEdit').val();
        let subTotal = $('#subTotalOrderEdit').val();
        let netAmountEdit = $('#netAmountEdit').val();

        // alertHideFun();

        let slno = $('#productsTableOrderEdit tr').length;
        if (productName != "" && varient != "" && category != "" && quantity != "" && unitPrice != "" && taxes != "" && subTotal != "") {

            $('#productsTableOrderEdit tbody').append('<tr class="child">\
                                                <td>' + slno + '</td>\
                                                <td class="product_Id" style="display:none;">' + product_Id_Order + '</td>\
                                                <td class="product_name">' + productName + '</td>\
                                                <td class="product_category">' + category + '</td>\
                                                <td class="product_varient">' + varient + '</td>\
                                                <td class="product_desc">' + description + '</td>\
                                                <td class="product_quantity">' + quantity + '</td>\
                                                <td class="unit_price">' + unitPrice + '</td>\
                                                <td class="taxes"  style="display: none;" >' + taxes + '</td>\
                                                <td class="subtotal">' + subTotal + '</td>\
                                                <td class="netAmountEdit">' + netAmountEdit + '</td>\
                                                <td>\
                                                    <a href="javascript:void(0);" class="remCF1EditOrder">\
                                                        <i class="mdi mdi-delete"></i>\
                                                    </a>\
                                                </td>\
                                            </tr>');
            calculateOrderEdit();

            $('#productNameOrderEdit').val('');
            $('#productIdEdit').val('');
            $('#productNameOrderEdit1').val('');
            $('#varientOrderEdit').val('');
            $('#categoryOrderEdit').val('');

            $('#descriptionOrderEdit').val('');
            $('#quantityOrderEdit').val(0);
            $('#unitPriceOrderEdit').val(0);
            $('#taxesOrderEdit').val(0);
            $('#subTotalOrderEdit').val(0);
            $('#netAmountEdit').val(0);
        }else{
            errorMsg('Please fill all mandatory fields.');
        }
    });

    $('#taxIncludeOrderEdit').change(function() {
        calculateOrderEdit();

        // // $('#categoryOrderEdit').val('');
        // // $('#sku_CodeOrderEdit').val('');
        // // $('#descriptionOrderEdit').val('');
        // $('#quantityOrderEdit').val('');
        // // $('#unitPriceOrderEdit').val('');
        // // $('#taxesOrderEdit').val('');
        // $('#subTotalOrderEdit').val('');
        // $('#netAmountEdit').val('');

        // $("#productTableBodyOrderEdit > tr").each(function(e) {

        //     let unitPrice = $(this).find('.unit_price').text();
        //     let taxes = $(this).find('.taxes').text();
        //     let subTotal = $(this).find('.subtotal').text();
        //     let netAmountEdit = $(this).find('.netAmountEdit').text();

        //     let amount = parseFloat(taxes) + parseFloat(subTotal);

        //     if ($('#taxIncludeOrderEdit').prop('checked')) {
        //         $(this).find('.netAmountEdit').text(amount);
        //     } else {
        //         $(this).find('.netAmountEdit').text(subTotal);
                
        //     }
        // });

    });

    function calculateOrderEdit() {

        let tax = $('#gstValueOrderEdit').val();

        let quantity = $('#quantityOrderEdit').val();

        let unitPrice = $('#unitPriceOrderEdit').val(); 

        let subTotal = parseFloat(quantity)*parseFloat(unitPrice);
        let taxes = ((parseFloat(quantity)*parseFloat(unitPrice))*parseFloat(tax))/100;

        $('#taxesOrderEdit').val(taxes);
        $('#subTotalOrderEdit').val(subTotal);

        if ($('#taxIncludeOrderEdit').prop('checked')) {
            $('#netAmountEdit').val(subTotal+taxes);
        } else {
            $('#netAmountEdit').val(subTotal);
        }

        $("#productTableBodyOrderEdit > tr").each(function(e) {

            unitPrice = $(this).find('.unit_price').text();

            quantity = $(this).find('.product_quantity').text();

            subTotal = parseFloat(unitPrice)*parseFloat(quantity);

            $(this).find('.subtotal').text(subTotal);

            taxes = (parseFloat(subTotal)*parseFloat(tax))/100;

            $(this).find('.taxes').text(taxes);

            if ($('#taxIncludeOrderEdit').prop('checked')) {
                $(this).find('.netAmountEdit').text(subTotal + taxes);
            } else {
                $(this).find('.netAmountEdit').text(subTotal);
            }
        });

        let sum = 0;
        tax = 0;
        let i = 0;

        $("#productTableBodyOrderEdit > tr").each(function() {
            sum += parseFloat($(this).find('.subtotal').text());
            tax += parseFloat($(this).find('.taxes').text());
        });

        $('#untaxtedAmountOrderEdit').val(sum);
        $('#untaxtedAmountOrderEdit1').val(sum);

        if ($('#taxIncludeOrderEdit').prop('checked')) {
            $('#gstOrderEdit').val(tax);
            $('#gstOrderEdit1').val(tax);
            
            $('#quotationTotalOrderEdit').val(parseFloat(sum)+parseFloat(tax));
            $('#quotationTotalOrderEdit1').val(parseFloat(sum)+parseFloat(tax));
        } else {
            $('#gstOrderEdit').val('');
            $('#gstOrderEdit1').val('');

            $('#quotationTotalOrderEdit').val(parseFloat(sum));
            $('#quotationTotalOrderEdit1').val(parseFloat(sum));
        }


        // let sum = 0;
        // let tax = 0;
        // let i = 0;

        // $("#productTableBodyOrderEdit tr .subtotal").each(function() {
        //     sum += parseFloat($(this).text());
        // });

        // $('#untaxtedAmountOrderEdit').val(sum);
        // $('#untaxtedAmountOrderEdit1').val(sum);
        // $('#quotationTotalOrderEdit').val(sum);
        // $('#quotationTotalOrderEdit1').val(sum);

        // $("#productTableBodyOrderEdit tr .taxes").each(function() {
        //     tax += parseFloat($(this).text());
        // });

        // $('#gstOrderEdit').val(tax);
        // $('#gstOrderEdit1').val(tax);

        // // $('#taxIncludeOrderEdit').change(function(){
        // if ($('#taxIncludeOrderEdit').prop('checked')) {
        //     let untaxtedAmountOrderEdit = parseFloat($('#untaxtedAmountOrderEdit').val());
        //     let totalBill = untaxtedAmountOrderEdit + tax;


            


        //     $('#quotationTotalOrderEdit').val(totalBill);
        //     $('#quotationTotalOrderEdit1').val(totalBill);

        // } else {
        //     console.log(123);
        //     let untaxtedAmountOrderEdit = parseFloat($('#untaxtedAmountOrderEdit').val());
        //     let totalBill = untaxtedAmountOrderEdit;

        //     $('#gstOrderEdit').val('');

        //     $('#quotationTotalOrderEdit').val(totalBill);
        //     $('#quotationTotalOrderEdit1').val(totalBill);

        // }
        // });

    };


    $(document).on('click', '.remCF1EditOrder', function() {
        $(this).parent().parent().remove();

        $('#productsTableOrderEdit tbody tr').each(function(i) {
            $($(this).find('td')[0]).html(i + 1);
        });

        calculateOrderEdit();
    });

</script>