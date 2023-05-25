<!-- Modal -->
<div class="modal fade" id="viewECredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">E-Credit Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editECreditForm">
        <div class="modal-body bg-white px-3">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="customer_name">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" id="customer_name" disabled placeholder="Customer Name" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" name="mobile" class="form-control" id="mobile" disabled placeholder="Mobile Number" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Email Id:</label>
                    <input type="email" name="email" class="form-control" id="email" disabled placeholder="Price" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="available_balanced">Available Balanced</label>
                    <input type="text" name="available_balanced" class="form-control" id="available_balanced" disabled placeholder="Total Points" />
                  </div>
                </div>
              </div>
              <br>
               <h5>History</h5>
              <hr>
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label for="available_balanced">Order ID</label>
                    <input type="text" name="order_id" class="form-control" id="order_id" disabled placeholder="Order ID" />
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="available_balanced">Order Name</label>
                    <input type="text" name="order_name" class="form-control" id="order_name" disabled placeholder="Order Name" />
                  </div>
                </div>
              </div>
              <div class="row">
               <div class="col-6">
                  <div class="form-group">
                    <label for="price">Total Amont</label>
                    <input type="text" name="price" class="form-control" id="price" disabled placeholder="Total Price" />
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label for="available_balanced">Order Name</label>
                    <input type="text" name="order_name" class="form-control" id="order_name" disabled placeholder="Order Name" />
                  </div>
                </div>
              </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>