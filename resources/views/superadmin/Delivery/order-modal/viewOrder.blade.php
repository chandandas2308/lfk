<!-- Modal -->
<div class="modal fade" id="viewcnclorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      
        <div class="modal-body bg-white px-3">

                <!-- info & alert section -->
                <div class="alert alert-success" id="editAssetTrackingAlert" style="display:none"></div>
                  <div class="alert alert-danger" style="display:none">
                    <ul></ul>
                  </div>
                <!-- end -->
           
              <div class="card">
                  <div class="card-body">

                    <input type="text" name="" id="viewAssetTrackingId" class="form-control" disabled  style="display: none;" />

                    <!-- Name -->
                      <div class="form-group">
                        <label for="vieworder_number">Order Number</label>
                        <input type="text" name="vieworder_number" id="vieworder_number" class="form-control" disabled />
                      </div>

                      <!-- Quantity -->
                      <div class="form-group">
                        <label for="viewcustomer_name">Customer Name</label>
                        <input type="text" name="viewcustomer_name" id="viewcustomer_name" class="form-control text-dark" placeholder="Customer Name" disabled />
                      </div>

                      <!-- Location -->
                      <div class="form-group">
                        <label for="viewcontact_no">Contact No</label>
                        <input type="text" name="viewcontact_no" id="viewcontact_no" class="form-control text-dark" placeholder="Contact No"  disabled />
                      </div>
                      <div class="form-group">
                        <label for="viewproduct_description">Product Description</label>
                        <input type="text" name="viewproduct_description" id="viewproduct_description" class="form-control text-dark" placeholder="Product Description"  disabled />
                      </div>
                      <div class="form-group">
                        <label for="viewamount">Amount</label>
                        <input type="text" name="viewamount" id="viewamount" class="form-control text-dark" placeholder="Amount"  disabled />
                      </div>
                      <div class="form-group">
                        <label for="viewpickup_address">Pickup Address</label>
                        <input type="text" name="viewpickup_address" id="viewpickup_address" class="form-control text-dark" placeholder="Pickup Address"  disabled />
                      </div>
                      <div class="form-group">
                        <label for="viewdelivery_address">Delivery Address</label>
                        <input type="text" name="viewdelivery_address" id="viewdelivery_address" class="form-control text-dark" placeholder="Delivery Address"  disabled />
                      </div>
                      <div class="form-group">
                        <label for="viewregion">Region</label>
                        <input type="text" name="viewregion" id="viewregion" class="form-control text-dark" placeholder="Region"  disabled />
                      </div>
                      <div class="form-group">
                        <label for="viewdelivery_date">Delivery Date</label>
                        <input type="date" name="viewdelivery_date" id="viewdelivery_date" class="form-control text-dark" placeholder="Delivery Date"  disabled />
                      </div>
                      <div class="form-group">
                        <label for="viewdriver">Driver</label>
                        <input type="text" name="viewdriver" id="viewdriver" class="form-control text-dark" placeholder="Driver"  disabled />
                      </div> 
                      <div class="form-group">
                        <label for="viewdelivery_status">Delivery Status</label>
                        <input type="text" name="viewdelivery_status" id="viewdelivery_status" class="form-control text-dark" placeholder="Delivery Status"  disabled />
                      </div>  
                      <div class="form-group">
                        <label for="viewcharges">Charges</label>
                        <input type="text" name="viewcharges" id="viewcharges" class="form-control text-dark" placeholder="Charges"  disabled />
                      </div> 
                      <div class="form-group">
                        <label for="viewpayment_staus">Payment Staus</label>
                        <input type="text" name="viewpayment_staus" id="viewpayment_staus" class="form-control text-dark" placeholder="Payment Staus"  disabled />
                      </div>                  
                      
                  </div>
                </div>    

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      
    </div>
  </div>
</div>