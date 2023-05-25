<!-- Modal -->
<div class="modal fade" id="viewAssetTracking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Asset Tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editAssetTrackForm">
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
                        <label for="name">Name</label>
                        <input type="text" name="" id="assetNameView" class="form-control" disabled />
                      </div>

                      <!-- Quantity -->
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantityAssetTrackingView" class="form-control text-dark" placeholder="Quantity" disabled />
                      </div>

                      <!-- Location -->
                      <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" id="locationView" class="form-control text-dark" placeholder="Price"  disabled />
                      </div>

                      <!-- status -->
                      <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="statusView"  class="form-control" disabled>
                        <option value="">Select status</option>
                          <option value="active">Active</option>
                          <option value="inactive">Inactive</option>
                        </select>
                      </div>                      

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