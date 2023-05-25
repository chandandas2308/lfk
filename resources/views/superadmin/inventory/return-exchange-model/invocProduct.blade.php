<!-- Modal -->
<div class="modal fade" id="invocProductRE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Zero Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

            <div class="alert alert-success alert-dismissible fade show" id="editProductInReturnExchangeSuccessAlertZeroInvoice" role="alert" style="display: none;">
                <strong></strong> <span id="editProductInReturnExchangeSuccessMSGZeroInvoice"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-danger alert-dismissible fade show" id="editProductReturnExchangeErrorAlertZeroinvoice" style="display:none" role="alert">
                <strong></strong> <span id="editProductReturnExchangeErrorMSGZeroInvoice"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- end -->

      <form method="post" id="zeroInvoiceForm">
        @csrf
        <div class="modal-body bg-white px-3"> 
            
            <!-- invoice body start here -->
            <input type="hidden" name="id" id="reuniqueIdinvoic" >

            <!-- row 0 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="view-re-type" class="form-label">Type</label>
                    <input type="text" name="type" id="view-re-typeinvoic" class="form-control text-dark" readonly />
                </div>
                <div class="col-md-6">
                    <label for="view_user_name_re" class="form-label">Customer/Vendor Name</label>
                    <input type="text" name="user" id="view_user_name_reinvoic" class="form-control text-dark" readonly />
                </div>
            </div>

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="view-re-invoice" class="form-label">Invoice No./Order No.</label>
                    <input type="text" name="return_and_exchanges_no" id="view-re-invoiceinvoic" class="form-control text-dark" readonly />
                </div>
                <div class="col-md-4">
                    <label for="view_invoice_date_re" class="form-label">Invoice Date/Order Date</label>
                    <input type="date" name="invoice_date" id="view_invoice_date_re1" class="form-control text-dark" readonly />
                </div>
                <div class="col-md-4">
                    <label for="view_invoice_amount_re" class="form-label">Zero Invoice Amount</label>
                    <input type="text" name="invoice_Amount" id="view_invoice_amount_re1" class="form-control text-dark" placeholder="Invoice Amount" readonly />
                </div>
            </div>

            <!-- row 2 -->
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="view-re-invoice" class="form-label">Zero Invoice Date<span style="color:red;">*</span></label>
                    <input type="date" name="date" id="return_and_exchanges_date" class="form-control text-dark" />
                </div>
                <div class="col-md-4">
                    
                </div>
            </div>
            <!-- row 5 -->
            <div class="form-group row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Orders Details</legend>
                        
                            <div class="table-responsive-sm" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productRETableViewinvoic">
                                    <thead>
                                        <tr>
                                            <th class="border border-secondary">S/N</th>
                                            <th class="border border-secondary">Product Name</th>
                                            <th class="border border-secondary">Variant</th>
                                            <th class="border border-secondary">Quantity</th>
                                            <th class="border border-secondary">Unit Price</th>
                                            <th class="border border-secondary">Status</th>
                                            <th class="border border-secondary">Return & Exchange Quantity</th>
                                            <th class="border border-secondary">Remark</th>
                                            <th class="border border-secondary">Batch Code</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productRETableViewBodyinvoic"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Close</button>
            <button type="submit" id="zeroInvoiceSubmitBtn" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    // validation script start here
    $(document).ready(function() {
            
        // store data to database
        jQuery("#zeroInvoiceForm").submit(function(e) {
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
                date: {
                    required: true,
                },
                batch_code: {
                    required: true,
                },
            },
            messages: {},
            submitHandler: function(){

                
                let allProductDetailsRandEInvoiceZeroInvoice = [];

                allProductDetailsRandEInvoiceZeroInvoice.splice(0, allProductDetailsRandEInvoiceZeroInvoice.length);

                $("#productRETableViewBodyinvoic > tr").each(function(e) {
                    let productId = $(this).find('.product_id').text();
                    let productName = $(this).find('.product_name').text();
                    // let quantityRE = $(this).find('.category').text();
                    let varientRE = $(this).find('.varient').text();
                    let quantityRE = $(this).find('.quantity').text();
                    let subTotalRE = $(this).find('.subTotal').text();
                    let statusRE = $(this).find('.status').text();
                    let quantityRAE = $(this).find('.requantity').text();
                    let remarkRE = $(this).find('.remark').text();
                    let batchCode = $(this).find('#batch_code_zero_invoice').val();

                    let dbData = {
                        "product_Id": productId,
                        "product_name": productName,
                        "product_varient": varientRE,
                        // "category": categoryRE,
                        "quantity": quantityRE,
                        "unit_price": subTotalRE,
                        "status": statusRE,
                        "quantityRAC": quantityRAE,
                        "remark": remarkRE,
                        "batchCode": batchCode
                    }
                    allProductDetailsRandEInvoiceZeroInvoice.push(dbData);
                });

                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('SA-UpdateZeroInvoice') }}",
                            data: jQuery("#zeroInvoiceForm").serialize() + "&orders=" + JSON.stringify(allProductDetailsRandEInvoiceZeroInvoice),
                            enctype: "multipart/form-data",
                            type: "post",
                            success: function(result) {

                                if (result.error != null) {
                                    errorMsg(result.error);
                                } 
                                else if (result.barerror != null) {
                                    errorMsg(result.barerror);
                                    jQuery("#addInvoiceAlert").hide();
                                    jQuery("#editProductInReturnExchangeSuccessAlertZeroInvoice").hide();

                                } else if (result.success != null) {

                                    $('.modal .close').click();
                                    successMsg(result.success);
                                    return_exchange_main_table.ajax.reload();

                                } else {

                                    jQuery("#editProductReturnExchangeErrorAlertZeroinvoice").hide();
                                    jQuery("#editProductInReturnExchangeSuccessAlertZeroInvoice").hide();

                                }
                            },
                        });
                    }
                });
            }
        });
    });
    // end here


</script>