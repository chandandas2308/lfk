<div class="modal fade viewBanner" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lgs" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Banner Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3">

        <!-- Title  -->
        <div class="form-group row">
          <label for="title" class="col-sm-3 col-form-label">Title</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="viewtitle" readonly />
          </div>
        </div>
        <!-- Upload Banner -->
        <div class="form-group row">
          <label for="image" class="col-sm-3 col-form-label">Banner Image</label>
          <div class="col-sm-9">
            <img src="" id="viewbanner_image" height="100" width="100" class="img-fluid" />
          </div>
        </div>

        <!-- Description  -->
        <div class="form-group row">
          <label for="description" class="col-sm-3 col-form-label">Description</label>
          <div class="col-sm-9">
            <textarea name="description" id="viewdescription" class="form-control" cols="30" rows="2" readonly></textarea>
          </div>
        </div>

        <!-- Product -->
        <div class="form-group row">
          <label for="viewproduct_name" class="col-sm-3 col-form-label">Product</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="viewproduct_name" readonly />
          </div>
        </div>
        <!-- Status -->
        <div class="form-group row">
          <label for="viewstatus1" class="col-sm-3 col-form-label">Status</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="viewstatus1" readonly />
          </div>
        </div>

        
        <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Type<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="type" disabled id="bannerTypeView" class="form-control">
                                        <option value="">Banner Type</option>
                                        <option value="0">Website & APK Banner 1</option>
                                        <option value="1">Website & APK Banner 2</option>
                                        <option value="2">APK Banner 1 & APK Banner 2</option>
                                        <option value="3">Only Website</option>
                                        <option value="4">APK Banner 1</option>
                                        <option value="5">APK Banner 2</option>
                                    </select>
                                </div>
                            </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>