<style>
    .imageDiv{
        position: relative;
        display: initial;
        margin: 2px;
    }
    .imageLabel{
        background: #ff4141;
        color: white;
        padding: 4px;
        border-radius: 50%;
        padding-top: 6px;
        z-index: 1;
        position: absolute;
        right: 0;
        top: -36px;
    }
</style>

<div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-white">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form class="forms-sample" id="editProductForm1" enctype="multipart/form-data" method="post">
        @csrf
      <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <!-- image section -->
                    <div class="form-group row">
                        <label for="image" class="col-sm-4 col-form-label">Product Image</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control text-dark" id="proImg" accept="image/*" name="image" />
                            <img src="" id="product_image" height="100" width="100" class="img-fluid" />
                        </div>
                    </div>
                    <!-- id -->
                    <div class="form-group row" style="display:none;">
                        <!-- <label for="image" class="col-sm-4 col-form-label">Product ID</label> -->
                        <!-- <div class="col-sm-8"> -->
                            <input type="text" id="product_id" name="productId" style="display:none;" />
                        <!-- </div> -->
                        
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- name  -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Product Name(English)<span style="color: red;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="product_name" name="name" placeholder="Product Name" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Product Category -->
                    <div class="form-group row">
                        <label for="productCategory1" class="col-sm-4 col-form-label">Product Category<span style="color: red;">*</span></label>
                        <div class="col-sm-8">
                            <!-- <input type="text" class="form-control" id="product_category" name="productCategory" placeholder="Product Category" /> -->
                            <select class="form-control" name="productCategory" id="productCategory1"></select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- name  -->
                    <div class="form-group row">
                        <label for="name" class="col-sm-4 col-form-label">Product Name(Chinese)<span style="color: red;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="editchinese_product_name" name="chinese_product_name" placeholder="Product Name" />
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
            <div class="col-md-6">
                    <!-- Product Varient -->
                    <div class="form-group row">
                        <label for="productVarient" class="col-sm-4 col-form-label">Product Variant<span style="color: red;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="product_varient" name="productVarient" placeholder="Product Variant" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- UOM -->
                    <div class="form-group row">
                        <label for="skuCode" class="col-sm-4 col-form-label">UOM<span style="color: red;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="u_om" name="uom" placeholder="UOM" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Minimum Scale Price -->
                    <div class="form-group row">
                        <label for="minScalePrice" class="col-sm-4 col-form-label">Sales Price<span style="color: red;">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="min_ScalePrice" name="editMinScalePrice" placeholder="Sales Price" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Supplier Code -->
                    <div class="form-group row">
                        <label for="supplierList1" class="col-sm-4 col-form-label">Vendor Name</label>
                        <div class="col-sm-8">
                            <select name="supCode" id="sup_code_id" class="form-control"></select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- SKU Code -->
                    <div class="form-group row">
                        <label for="skuCode" class="col-sm-4 col-form-label">SKU Code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="sku_code" name="skuCode" placeholder="SKU Code" />
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="featured_products_update" style="margin: auto;" class="col-sm-4 col-form-label">Featured Product</label>
                        <div class="col-sm-8" style="margin: auto; border-bottom: 1px ridge;" >
                            <input type="checkbox" name="featured_product" id="featured_products_update">
                        </div>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group row">
                      <label for="featured_products" style="margin: auto;" class="col-sm-4 col-form-label">Stock Check</label>
                      <div class="col-sm-8" style="margin: auto; border-bottom: 1px ridge;" >
                        <input type="checkbox" name="stock_check" id="edit_stock_check">
                      </div>
                    </div>
                  </div>


                <div class="col-md-6">
                    <div class="form-group row">
                        <label for="featured_products" style="margin: auto;" class="col-sm-4 col-form-label">Product Barcode</label>
                        <div class="col-sm-8" style="margin: auto; border-bottom: 1px ridge;" >
                        <input type="text" class="form-control" id="barcodeEdit" name="barcode" placeholder="Barcode" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="descriptionE" id="descriptionE" row="10" class="ckeditor" placeholder="Description"></textarea>
                </div>
            </div>

                <div class="col-md-12">
                    <!-- image section -->
                    <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label">Multiple Image</label>
                        <div class="col-sm-10">
                            <button class="btn btn-success" id="editImageBtn" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add Image</button>
                            <div id="previousImages"></div>
                            <div class="input-group hdtuto control-group lst increment" >
                                <!-- images -->
                            </div>
                            <div class="clone hide" style="display: none;">
                                <div class="hdtuto control-group lst input-group" style="margin-top:10px">
                                    <input type="file" name="filenames[]" class="myfrm form-control">
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger" id="removeImageE" type="button"><i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- id -->
                    <div class="form-group row" style="display:none;">
                            <input type="text" id="product_id" name="product_id" style="display:none;" />
                    </div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="editProductFormClearBtn" >Clear</button>
        <button type="submit" id="editProductForm" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- jQuery CDN -->
<script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<!-- backend js file -->

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<script>
    
$(document).ready(function() {
  $('.ckeditor').ckeditor();
});

$(document).ready(function() {

    $(document).on('click','#editImageBtn',function(){ 
        var lsthmtl = $(".clone").html();
        $(".increment").append(lsthmtl);
    });

    $(document).on("click","#removeImageE",function(){ 
        $(this).parent().parent().remove();
    });

});

 // clear form
    jQuery('#editProductFormClearBtn').on('click', function (){
        jQuery("#editProductForm1")["0"].reset();
        CKEDITOR.instances['descriptionE'].setData("");
      });

  // validation script start here
  jQuery(document).ready(function () {
    jQuery("#editProductForm1").submit(function (e) {
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

            name : {
                required: true,
                minlength: 1,
                validate: true,
            },

            productCategory : {
                required: true,
            },


            productVarient : {
                required: true,
            },

            uom : {
                required: true,
                minlength: 1,
            },

            editMinScalePrice : {
                required: true,
                min: 1,
                number: true,
            },

        },
        messages : {
            image:{
                required: "Please choose Product Image",
            },
            name: {
                required: "Please enter valid Product Name",
                minlength: "Category Name should be at least 1 characters",
                validate: "Please enter valid Product Name"
            },
            productCategory: {
                required: "Please choose Product Category",
            },
            productVarient: {
                required: "Please choose Product Variants",
            },
        },
        submitHandler:function(){
            const formData = new FormData($('#editProductForm1')["0"]);
            bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                if(result){

                    var description1 = CKEDITOR.instances.descriptionE.getData();

                    formData.append('description1',description1);
                    formData.append('updateImages',updateImages);

                    $.ajax({
                        url: "{{ route('SA-EditProduct') }}",
                        type: "POST",
                        data:  formData,
                        contentType: false,
                        cache: false,
                        processData:false,

                        success: function (result) {
                            if(result.error !=null ){
                                jQuery.each(result.error, function (key, value) {
                                });
                                errorMsg(result.error);
                            }
                            else if(result.barerror != null){
                                errorMsg(result.barerror);
                            }
                            else if(result.success != null){
                                successMsg(result.success);
                                $('.increment').html('');
                                $('.modal .close').click();

                                product_main_table.ajax.reload();

                                setTimeout(() => {
                                    $('#product_main_table').find('svg').attr('width', 100);
                                }, 2000);

                                updateImages.length = 0;

                                getStockProductList();
                                vendorNameArr.splice(0, vendorNameArr.length);
                                CKEDITOR.instances['description'].setData("");
                            }else {
                                updateImages.length = 0;
                                jQuery(".alert-danger").hide();
                                jQuery("#editUserAlert").hide();
                            }
                        }
                    });
                }
            });
        }
      });
    });
  // end here


  function removeImage(key){
    $('#image'+key).remove();
    $('#imageLabel'+key).remove();
    updateImages.splice(key, 1);
  }

// list supplier
jQuery(document).ready(function (){
        getSuplier();
    });

    function getSuplier(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });
        jQuery.ajax({
            url: "{{ route('SA-ListSupplier') }}",
            type: "GET",
            success: function (result) {
                jQuery("#sup_code_id").html('<option value="">Choose Vendor</option>');
                jQuery.each(result, function (key, value) {
                    $('#sup_code_id').append('<option value="'+value["id"]+'">\
                    '+value["vendor_name"]+'\
                    </option>');
                });
            }
        });
    }

// list category
function listCategory2(){
        jQuery.ajax({
            url: "{{ route('SA-ListCategories') }}",
            type: "GET",

            success: function (result) {
                jQuery("#productCategory1").html('<option value="">Choose Category</option>');
                jQuery.each(result, function (key, value) {
                    $('#productCategory1').append('<option value="'+value["id"]+'">\
                    '+value["name"]+'\
                    </option>');
                });
            }
        });
    }

</script>