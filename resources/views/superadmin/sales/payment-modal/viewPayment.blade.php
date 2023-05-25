<!-- Modal -->
<div class="modal fade" id="viewPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editPaymentForm">
        <div class="modal-body bg-white px-3">

          <!-- <div class="card"> -->
            <!-- <div class="card-body"> -->

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="invoiceNo">Invoice Number</label>
                  <input type="text" name="invoiceNo" id="viewInvoiceNo" class="form-control" disabled>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="view_customer_name">Customer Name</label>
                  <input type="text" name="customer_name" id="view_customer_name" class="form-control" disabled>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="amount">Amount</label>
                  <input type="number" name="amount" class="form-control" id="viewAmount" placeholder="Amount" disabled />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="paymentType">Payment Type</label>
                  <select name="paymentType" id="viewPaymentType" class="form-control text-dark" disabled>
                      <option value="default">Choose Payment Type</option>
                      <option value="cash">Cash</option>
                      <option value="cheque">Cheque</option>
                      <option value="account">Account Transfer</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="paymentDate">Payment Date</label>
                  <input type="date" class="form-control" id="viewPaymentDate" name="paymentDate" placeholder="Payment Date" disabled />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="paymentStatus">Payment Status</label>
                  <!-- <select name="paymentStatus" id="viewPaymentStatus" class="form-control text-dark" disabled>
                      <option value="">Payment Status</option>
                      <option value="paid">Paid</option>
                      <option value="artial">Partial</option>
                  </select> -->
                  <input type="text" name="paymentStatus" id="viewPaymentStatus" class="form-control text-dark" disabled />
                </div>
              </div>
            </div>
            <!-- </div> -->
          <!-- </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>