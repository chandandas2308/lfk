<!-- Modal -->
<div class="modal fade" id="viewVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Vendor Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="viewVendorForm">
        <div class="modal-body bg-white px-3">

                <!-- info & alert section -->
                <div class="alert alert-success" id="viewVendorAlert" style="display:none"></div>
                  <div class="alert alert-danger" style="display:none">
                    <ul></ul>
                  </div>
              <!-- end -->
            <input type="text" name="id" id="idV" class="form-control text-dark" style="display: none;">
              <!-- <div class="card">
                  <div class="card-body"> -->


                  <div class="row">
                    <div class="col-md-6">
                        <!-- Customer Name -->
                        <div class="form-group">
                        <label for="vendorName">Vendor Name</label>
                        <input type="text" name="vendorName" id="vendorNameV" class="form-control text-dark" placeholder="Vendor Name" disabled />
                      </div>
                    </div>
                    <div class="col-md-6">
                    
                      <div class="form-group">
                        <label for="vendorID">Vendor ID</label>
                        <input type="text" name="vendorID" id="VendoerIDView" class="form-control text-dark" placeholder="Vendor ID" disabled>
                      </div>
                    
                    </div>
                  </div>

                      <div class="row">
                    <div class="col-md-6">
                      
                      <div class="form-group">
                        <label for="contactPersonName">Contact Person Name</label>
                        <input type="text" name="contactPersonName" id="contactPersonNameV" class="form-control text-dark" placeholder="Contact Person Name" disabled />
                      </div>

                    </div>
                    <div class="col-md-6">
                                          <!-- Vendor Phone Number -->
                                          <div class="form-group">
                        <label for="phoneNo">Home Number</label>
                        <input type="text" name="phoneNo" id="phoneNoV" class="form-control text-dark" placeholder="Home Number" disabled />
                      </div>
                    </div>
                  </div>



                      <div class="row">
                    <div class="col-md-6">
                      <!-- Vendor Mobile Number -->
                      <div class="form-group">
                        <label for="mobileNo">Mobile Number</label>
                        <input type="text" name="mobileNo" id="mobileNoV" class="form-control text-dark" placeholder="Mobile Number" disabled />
                      </div>
                    </div>
                    <div class="col-md-6">
                      

                      <!-- Vendor Email ID -->
                      <div class="form-group">
                        <label for="emailId">Email ID</label>
                        <input type="email" name="emailId" id="emailIdV" class="form-control text-dark" placeholder="Email ID" disabled />
                      </div>

                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                        <!-- Vendor Address -->
                      <div class="form-group">
                          <label for="address">Address</label>
                          <textarea
                            name="address"
                            class="form-control text-dark"
                            id="addressV"
                            rows="4"
                            placeholder="Address" disabled
                          ></textarea>
                        </div>                      
                    </div>
                    <div class="col-md-6">

                    </div>
                  </div>

                      <!-- GST -->
                      <!-- <div class="form-group">
                        <label for="gst">GST</label>
                        <select name="gst" id="gstV" class="form-control text-dark" disabled>
                            <option value="">Select GST treatment</option>
                            <option value="A">Demo</option>
                            <option value="B">Demo1</option>
                            <option value="C">Demo2</option>
                        </select>
                      </div> -->
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