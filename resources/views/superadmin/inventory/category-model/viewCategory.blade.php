<div class="modal fade viewCategory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
<div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Category Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-white">
      
                      <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Category Image</label>
                        <div class="col-sm-9">
                          <input type="file" class="form-control" id="image" name="image" placeholder="Category Image" />
                          <img id="viewCategoryImg" height="100" width="100" />
                        </div>
                      </div>
                <div class="form-group row">
                        <label for="categoryName" class="col-sm-3 col-form-label">Category Name(English)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="viewcategoryName" name="name" placeholder="Category Name" disabled />
                        </div>
                </div>
                <div class="form-group row">
                        <label for="categoryName" class="col-sm-3 col-form-label">Category Name(Chinese)</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="viewchinesecategoryName" name="name" placeholder="Category Name" disabled />
                        </div>
                </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</script>