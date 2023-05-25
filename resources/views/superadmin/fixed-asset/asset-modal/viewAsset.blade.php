<!-- Modal -->
<div class="modal fade" id="viewAsset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="viewAssetForm">
        <div class="modal-body bg-white px-3">
           
              <div class="card">
                  <div class="card-body">
                    <!-- Id -->
                    <input type="text" name="assetId" id="assetIdView" class="form-control" disabled style="display: none;">
                    <!-- Name -->
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="nameView" class="form-control text-dark" placeholder="Name" disabled>
                      </div>

                      <!-- Quantity -->
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantityView" class="form-control text-dark" placeholder="Quantity" disabled>
                      </div>

                      <!-- Price -->
                      <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="priceView" class="form-control text-dark" placeholder="Price" disabled>
                      </div>

                      <!-- GST -->
                      <div class="form-group">
                        <label for="gst">GST</label>
                        <input type="number" name="gst" id="gstView" class="form-control text-dark" placeholder="GST" disabled>
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