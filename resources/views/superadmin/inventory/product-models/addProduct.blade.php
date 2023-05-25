<div class="modal fade" id="addProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-white p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" id="addProductForm1" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <!-- image section -->
              <div class="form-group row">
                <label for="image" class="col-sm-4 col-form-label">Product Image<span style="color: red;">*</span></label>
                <div class="col-sm-8">
                  <input type="file" class="form-control text-dark" id="proImg" accept="image/*" name="image" multiple />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <!-- name  -->
              <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Product Name(English)<span style="color: red;">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Product Name" />
                </div>
              </div>
            </div>
          </div>



          <div class="row">
            <div class="col-md-6">
              <!-- Product Category -->
              <div class="form-group row">
                <label for="productCategory" class="col-sm-4 col-form-label">Product Category<span style="color: red;">*</span></label>
                <div class="col-sm-8">
                  <!-- <input type="text" class="form-control" id="productCategory" name="productCategory" placeholder="Product Category" /> -->
                  <select class="form-control" name="productCategory" id="productCategory"></select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <!-- name  -->
              <div class="form-group row">
                <label for="name" class="col-sm-4 col-form-label">Product Name(Chinese)<span style="color: red;">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="chinese_product_name" name="chinese_product_name" placeholder="Product Name" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <!-- Supplier Code -->
              <div class="form-group row">
                <label for="supplierList" class="col-sm-4 col-form-label">Vendor Name</label>
                <div class="col-sm-8">
                  <select name="vendor_id" id="supCode" onchange="getVendorName()" class="form-control"></select>
                  <input type="hidden" name="supCode" id="vendor_namePA">
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <!-- Product Varient -->
              <div class="form-group row">
                <label for="productVarient" class="col-sm-4 col-form-label">Product Variant<span style="color: red;">*</span></label>
                <div class="col-sm-8">
                  <input class="form-control" type="text" name="productVarient" id="productVarient" placeholder="Product Variant" />
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <!-- UOM -->
              <div class="form-group row">
                <label for="skuCode" class="col-sm-4 col-form-label">UOM<span style="color: red;">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="uom" name="uom" placeholder="UOM" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <!-- Minimum Scale Price -->
              <div class="form-group row">
                <label for="minScalePrice" class="col-sm-4 col-form-label">Sales Price<span style="color: red;">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="minScalePrice" name="minScalePrice" placeholder="Sales Price" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label for="skuCode" class="col-sm-4 col-form-label">SKU Code</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="skuCode" name="skuCode" placeholder="SKU Code" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label for="featured_products" style="margin: auto;" class="col-sm-4 col-form-label">Featured Product</label>
                <div class="col-sm-8" style="margin: auto; border-bottom: 1px ridge;" >
                  <input type="checkbox" name="featured_product" id="featured_products">
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group row">
                <label for="featured_products" style="margin: auto;" class="col-sm-4 col-form-label">Stock Check</label>
                <div class="col-sm-8" style="margin: auto; border-bottom: 1px ridge;" >
                  <input type="checkbox" name="stock_check" id="stock_check">
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group row">
                <label for="featured_products" style="margin: auto;" class="col-sm-4 col-form-label">Product Barcode</label>
                <div class="col-sm-8" style="margin: auto; border-bottom: 1px ridge;" >
                  <input type="text" class="form-control" id="barcode" name="barcode" placeholder="Barcode" />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="ckeditor" placeholder="Description"></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <!-- image section -->
              <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Multiple Image</label>
                <div class="col-sm-10">
                  <button class="btn btn-success" id="addImageBtn" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add Image</button>
                  <div class="input-group hdtuto control-group lst increment">
                    <!-- images -->
                  </div>
                  <div class="clone hide" style="display: none;">
                    <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                      <input type="file" name="filenames[]" class="myfrm form-control">
                      <div class="input-group-btn">
                        <button class="btn btn-danger" id="removeImage" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="clearProductFormBtn">Clear</button>
          <button type="submit" id="addProductForm" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery CDN -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<!-- backend js file -->

<script>
  $(document).ready(function() {
    $('.ckeditor').ckeditor();
  });


  $(document).ready(function() {

    $(document).on('click', '#addImageBtn', function() {
      var lsthmtl = $(".clone").html();
      $(".increment").append(lsthmtl);
    });

    $(document).on("click", "#removeImage", function() {
      $(this).parent().parent().remove();
    });

  });

  // clear form
  jQuery('#clearProductFormBtn').on('click', function() {
    jQuery("#addProductForm1")["0"].reset();
    CKEDITOR.instances['description'].setData("");
  });

  $(document).on('click', '.removeService', function() {
    $(this).parent().parent().remove();
    $('#financeQuotationTable tbody tr').each(function(i) {
      $($(this).find('td')[0]).html(i + 1);
    });
  });

  // validation script start here
  $(document).ready(function(e) {
    jQuery("#addProductForm1").submit(function(e) {
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
      });

      $.validator.addMethod("validate", function(value) {
        return /[A-Za-z]/.test(value);
      });

    }).validate({
      rules: {
        image: {
          required: true
        },
        name: {
          required: true,
          minlength: 1,
          validate: true,
        },
        chinese_product_name: {
          required: true,
          minlength: 1,
          validate: false
        },
        productCategory: {
          required: true,
        },
        productVarient: {
          required: true,
        },
        supCode: {
          required: true,
        },
        skuCode: {
          // required: true,
        },
        uom: {
          required: true,
        },
        minScalePrice: {
          required: true,
        },
        tax: {
          required: true,
        },
        "filenames[]": {
          required: true,
          minlength: 1,
        }
      },
      messages: {
        name: {
          required: "Please enter valid Product Name",
          minlength: "Category Name should be at least 1 characters",
          validate: "Please enter valid Product Name"
        },
        chinese_product_name: {
          required: "Please enter valid Product Name",
          minlength: "Category Name should be at least 1 characters"
        },
        productCategory: {
          required: "Please choose Product Category",
        },
        productVarient: {
          required: "Please choose Product Variant",
        },
        supCode: {
          required: "Please choose Vendor Name",
        },
        skuCode: {
          required: "Please enter SKU Code",
        },
        uom: {
          required: "Please enter UOM",
        },
        minScalePrice: {
          required: "Please enter Sale Price",
        },
      },
      submitHandler: function() {

        const formData = new FormData($('#addProductForm1')["0"]);
        bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
          if (result) {
            
          var description1 = CKEDITOR.instances.description.getData();

          formData.append('description1',description1);

            jQuery.ajax({
              url: "{{ route('SA-AddProduct') }}",
              type: "POST",
              data: formData,
              contentType: false,
              cache: false,
              processData: false,

              success: function(result) {
                if (result.error != null) {
                  errorMsg(result.error);
                } else if (result.barerror != null) {
                  errorMsg(result.barerror);
                } else if (result.success != null) {
                  successMsg(result.success);
                  $('.modal .close').click();
                  jQuery("#addProductForm1")["0"].reset();
                  product_main_table.ajax.reload();
                  getStockProductList();
                  $(".increment").html('');
                  CKEDITOR.instances['description'].setData("");
                } else {
                  jQuery("#addProductAlertDanger2").hide();
                  jQuery("#addProductAlert").hide();
                }
              },
            });
          }
        });
      }
    });
  });
  // end here

  let supplierDetails = [];

  // list supplier
  getSuplier();

  function getSuplier() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
    });
    jQuery.ajax({
      url: "{{ route('SA-ListSupplier') }}",
      type: "GET",
      success: function(result) {

        supplierDetails = result;

        $('#supCode').html('');
        $('#supCode').append(`<option value="">Choose Vendor</option>`);
        jQuery.each(result, function(key, value) {
          $('#supCode').append(`<option value="${value['id']}">${value['vendor_name']}</option>`);
        });
      }
    });
  }

  // list category

  function getVendorName() {
    let vendorId = $('#supCode').val();
    jQuery.each(supplierDetails, function(k, v) {

      if (vendorId == v['id']) {
        $('#vendor_namePA').val(v['vendor_name']);
      }

    });
  }

  var listCategory1 = function() {
    jQuery.ajax({
      url: "{{ route('SA-ListCategories') }}",
      type: "GET",
      success: function(result) {
        jQuery("#productCategory").html('<option value="">Choose Product Category</option>');
        jQuery.each(result, function(key, value) {
          $('#productCategory').append('<option value="' + value["id"] + '">\
                    ' + value["name"] + '\
                    </option>');
        });
      }
    });
  }
</script>