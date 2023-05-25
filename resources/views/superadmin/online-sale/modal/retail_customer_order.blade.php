<div class="modal fade" id="viewRetailCustomerOrderInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Invoice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="salesEditInvoiceForm">
        <div class="modal-body bg-white px-3"> 
            <!-- invoice body start here -->

            <!-- row 0 -->
            <div class="form-group row">
                <!-- <div class="col-md-2 col-form-label">Order No.</div> -->
                <div class="col-md-6">
                    <label for="retailCustomerOrderNo">Order No.</label>
                    <input type="text" name="quotationNumber" id="retailCustomerOrderNo" class="form-control text-dark" placeholder="Order No." disabled />
                </div>

                <!-- <div class="col-md-2 col-form-label">Date</div> -->
                <div class="col-md-6">
                    <label for="retailCustomerDate">Date</label>
                    <input type="date" class="form-control text-dark" name="date" id="retailCustomerDate" placeholder="Date" disabled />
                </div>
            </div>

            <!-- row 2 -->
            <div class="form-group row">
                <!-- <div class="col-md-2 col-form-label">Customer Name</div> -->
                <div class="col-md-6">
                    <label for="retailCustomerName">Customer Name</label>
                    <input type="text" name="customerName" class="form-control" id="retailCustomerName" placeholder="Customer Name" disabled />
                </div>
                <!-- <div class="col-md-2 col-form-label">Email ID</div> -->
                <div class="col-md-6">
                    <label for="retailCustomerEmailId">Email ID</label>
                    <input type="text" name="customerName" class="form-control" id="retailCustomerEmailId" placeholder="Email ID" disabled />
                </div>
            </div>

            <!-- row 3 -->
            <div class="form-group row">
                <!-- <div class="col-md-2 col-form-label">Address</div> -->
                <div class="col-md-6">
                    <label for="retail_customer_address">Address</label>
                    <textarea name="address" id="retail_customer_address" class="form-control" disabled></textarea>
                </div>
                <!-- <div class="col-md-2 col-form-label">Total Amount</div> -->
                <div class="col-md-6">
                    <label for="retailCustomerTotalAmount">Total Amount</label>
                    <input type="text" name="total_amount" class="form-control" id="retailCustomerTotalAmount" placeholder="Total Amount" disabled />
                </div>
            </div>

            <!-- row 4 -->
            <div class="form-group row">
                <div class="col">
                    <fieldset class="border border-secondary p-2">
                        <legend class="float-none w-auto p-2">Invoice Details</legend>
                            <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                                <table class="table text-center border" id="retailCustomerProductsDetails">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Product Name</th>
                                            <th>Image</th>
                                            <th>Barcode</th>
                                            <th>Quantity</th>
                                            <th>Product Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody id="retailCustomerProductDetailsBody"></tbody>
                                </table>
                            </div>
                    </fieldset>
                </div>                
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>