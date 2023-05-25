<div class="modal fade viewProduct" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3">
        <div class="card">
          <div class="card-body">
            <div class="form-group row">
              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="row">
                  <label for="product_imageView" class="col-sm-6 col-form-label">Product Image</label>
                  <img src="" id="product_imageView" height="100" width="100" class="img-fluid" />
                </div>
              </div>

              <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="row">

                  <label for="image" class="col-sm-6 col-form-label">Barcode</label>
                  <div class="col-sm-6" style="overflow-x: auto;">
                    <div id="product_barcode_view"></div>
                  </div>

                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <div class="row">
                  <label for="name" class="col-sm-6 col-form-label">Product Name(English)</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" name="" id="product_name1" disabled />
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row">
                  <label for="name" class="col-sm-6 col-form-label">Product Name(Chinese)</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" name="" id="chinese_product_name1" disabled />
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <div class="row">
                  <label for="productCategory" class="col-sm-6 col-form-label">Product Category</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" name="" id="product_category1" disabled />
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row">
                  <label for="productVarient" class="col-sm-6 col-form-label">Product Variant</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" name="" id="product_varient1" disabled />
                  </div>
                </div>
              </div>

            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <div class="row">
                  <label for="minScalePrice" class="col-sm-6 col-form-label">Sales Price</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" name="" id="min_ScalePrice1" disabled />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <!-- UOM -->
                <div class="form-group row">
                  <label for="uom" class="col-sm-6 col-form-label">UOM</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" id="u_om1" name="uom" placeholder="UOM" disabled />
                  </div>
                </div>
              </div>

            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <div class="row">
                  <label for="supCode" class="col-sm-6 col-form-label">Vendor Name</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" name="" id="sup_code1" disabled />
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group row">
                  <label for="vendoerIDProView" class="col-sm-6 col-form-label">Vendor ID</label>
                  <div class="col-sm-6">
                    <input type="text" name="vendorID" id="vendoerIDProView" class="form-control" placeholder="Vendor ID" disabled />
                  </div>
                </div>
              </div>

              <div class="col-sm-6">
                <div class="row">
                  <label for="skuCode" class="col-sm-6 col-form-label">SKU Code</label>
                  <div class="col-sm-6 col-form-label">
                    <input type="text" class="form-control" name="" id="sku_code1" disabled />
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group row">
                  <label for="featured_products_view" style="margin: auto;" class="col-sm-4 col-form-label">Featured Product</label>
                  <div class="col-sm-8" style="margin: auto; border-bottom: 1px ridge;">
                    <input type="checkbox" name="featured_product" id="featured_products_view" disabled>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <div class="col-sm-6 col-form-label">
                  <p id="descriptionV" class="form-control" style="background: #e9ecef;"></p>
                </div>
              </div>
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6">
              <div class="row">
                <label for="product_imageView" class="col-sm-6 col-form-label">Images</label>
                <div id="previousImagesView"></div>
              </div>
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

<script>
  $(document).ready(function(){

    setTimeout(() => {
        $('#product_barcode_view').find('svg').attr('width', 100);
    }, 3000);
  })
</script>