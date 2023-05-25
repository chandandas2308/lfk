<!-- Modal -->
<div class="modal fade" id="viewCustomerDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Customer Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="viewCustomerForm">
        <div class="modal-body bg-white px-3">
           
                <!-- <div class="card">
                  <div class="card-body"> -->


                  <div class="row">
                    <div class="col-md-6">
                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customerName">Customer Name</label>
                        <input type="text" name="customerName" id="customerViewName" class="form-control" placeholder="Customer Name" disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label for="emailId">Email ID</label>
                        <input type="email" name="emailId" id="CustomerViewEmailId1" class="form-control" placeholder="Email ID"  disabled>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="mobileNo">Mobile Number</label>
                        <input type="text" name="mobileNo" id="CustomerViewMobNo" class="form-control" placeholder="Mobile Number"  disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phoneNo">Home Number</label>
                        <input type="text" name="phoneNo" id="customerViewPhNo" class="form-control" placeholder="Home Number"  disabled>
                      </div>
                    </div>
                  </div>






                  <div class="row">
                    <div class="col-md-6">
                      <!-- Customer Email ID -->
                      <div class="form-group">
                        <!-- Customer Address -->
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea
                              name="address"
                              class="form-control"
                              id="customerViewAddress"
                              rows="4"
                              placeholder="Address"
                              disabled
                            ></textarea>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                    </div>
                  </div>
                      <hr>
                      <h4>Invoice Details</h4>
                      <div style="overflow-x:auto;">    
                        <table class="table table-bordered ">
                          <thead>
                            <th>S/N</th>
                            <th>Invoice no</th>
                            <th>Product id</th>
                            <th>Product name</th>
                            <th>Quantity</th>
                            <th>Total amount</th>
                          </thead>
                          <tbody id="invoice_details_table"></tbody>
                        </table>
                      </div>
                      
                  <!-- </div>
                </div>     -->
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>