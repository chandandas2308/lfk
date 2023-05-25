<!-- Modal -->
<div class="modal fade" id="viewProductRE" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Products Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="viewProductRandExchangeForm">
        <div class="modal-body bg-white px-3"> 
            <!-- invoice body start here -->

            <!-- row 0 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="view-re-type" class="col-form-label">Type</label>
                    <input type="text" name="type" id="view-re-type" class="form-control text-dark" disabled />
                </div>
                <div class="col-md-6">
                    <label for="view_user_name_re" class="col-form-label">Customer/Vendor Name</label>
                    <input type="text" name="user" id="view_user_name_re" class="form-control text-dark" disabled />
                </div>
            </div>

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-4">
                    <label for="view-re-invoice" class="col-form-label">Invoice No.</label>
                    <input type="text" name="invoiceNo" id="view-re-invoice" class="form-control text-dark" disabled />
                </div>
                <div class="col-md-4">
                    <label for="view_invoice_date_re" class="col-form-label">Invoice Date</label>
                    <input type="date" name="invoice_date" id="view_invoice_date_re" class="form-control text-dark" disabled />
                </div>
                <div class="col-md-4">
                    <label for="view_invoice_amount_re" class="col-form-label">Invoice Amount</label>
                    <input type="text" name="invoice_Amount" id="view_invoice_amount_re" class="form-control text-dark" placeholder="Invoice Amount" disabled />
                </div>
            </div>

            <!-- row 5 -->
            <div class="form-group row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Orders Details</legend>
                        
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="productRETableView">
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
                                        </tr>
                                    </thead>
                                    <tbody id="productRETableViewBody"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>
        </div>
        <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" id="addProductReturnExchangeClearBtn" >Clear</button> -->
            <button type="buttont" id="viewProductRandExchangeForm1" data-dismiss="modal" class="btn btn-primary">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>