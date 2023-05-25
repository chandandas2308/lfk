

<div class="modal fade" id="editCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form class="forms-sample" id="editCategoryForm1" enctype="multipart/form-data" method="post">
        @csrf
      <div class="modal-body bg-white">

                <div class="alert alert-success alert-dismissible fade show" id="editCategoryAlert" style="display:none" role="alert">
                  <strong> </strong> <span id="editCategoryAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="editCategoryAlertDanger" style="display:none" role="alert">
                  <strong> </strong> <span id="editCategoryAlertDangerMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                    
                    <!-- Category Id  -->
                    <div class="form-group row" style="display: none;">
                      <label for="categoryId" class="col-sm-3 col-form-label">Category Id</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="categoryId" name="id" placeholder="Category Id" />
                      </div>
                    </div>

                  <!-- Category image  -->
                  <div class="form-group row">
                      <label for="name" class="col-sm-3 col-form-label">Category Image</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="imageUpdate" name="image" placeholder="Category Image" />
                        <img id="editCategoryImg" height="100" width="100" />
                      </div>
                  </div>
                  
                    <!-- Category Name  -->
                    <div class="form-group row">
                      <label for="categoryName" class="col-sm-3 col-form-label">Category Name(English)<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="categoryName" name="name" placeholder="Category Name" />
                      </div>
                    </div>
                    <!-- Category Name  -->
                    <div class="form-group row">
                      <label for="categoryName" class="col-sm-3 col-form-label">Category Name(Chinese)<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="chinesecategoryName" name="chinese_name" placeholder="Category Name" />
                      </div>
                    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="clearEditCategoryFormBtn">Clear</button>
        <button type="submit" id="editCategoryForm" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script>

      // clear form
      jQuery('#clearEditCategoryFormBtn').on('click', function (){
        jQuery("#editCategoryForm1")["0"].reset();
      });

  // validation script start here
// database store
jQuery(document).ready(function () {
    jQuery("#editCategoryForm1").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        
      $.validator.addMethod("imageType", function(value) {
        var ext = $('#imageUpdate').val().split('.').pop().toLowerCase();
        if(ext == ''){
          return true;
        }else if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
          return false;
        }else{
          return true;
        }
      });

      $.validator.addMethod("validate", function(value) {
        return /[A-Za-z]/.test(value);
      });

    }).validate({
      rules: {
        name : {
          required: true,
          minlength: 1,
        },
        chinese_name : {
          required: true,
          minlength: 1,
        },
        image: {
          imageType : true
          // accept: "image/*",
        },
      },
      messages : {
        name: {
          required: "Please enter category. e.g. Rice",
          minlength: "Category name should be at least 1 characters.",
        },
        chinese_name: {
          required: "Please enter category. e.g. Rice",
          minlength: "Category name should be at least 1 characters.",
        },
        image: {
          imageType: "image/jpg,image/jpeg,image/png,image/gif"
        }
      },
      submitHandler:function(){
        bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
          const formData1 = new FormData($('#editCategoryForm1')["0"]);
          if(result){
            $.ajax({
                url: "{{ route('SA-EditCategory') }}",
                data: formData1,
                enctype: "multipart/form-data",
                type: "post",
                contentType: false,
                cache: false,
                processData: false,

                success: function (result) {
                    category_main_table.ajax.reload();

                    if(result.error !=null ){
                        errorMsg(result.error);
                    }
                    else if(result.barerror != null){
                        errorMsg(result.barerror);
                    }
                    else if(result.success != null){
                        successMsg(result.success);
                        $('.modal .close').click();
                        jQuery("#editProductForm1")["0"].reset();
                        category_main_table.ajax.reload();
                        // getCategory();
                        listCategory();
                        listCategory1();
                    }else {
                        jQuery("#editCategoryAlertDanger").hide();
                        jQuery("#editCategoryAlert").hide();
                    }
                }
            });
          }
        });
      }
    });
  });
// end here

</script>