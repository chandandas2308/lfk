
<div class="modal fade addCategory" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <form class="forms-sample" id="addCategoryForm1" enctype="multipart/form-data" method="post">
          @csrf
          <div class="modal-body bg-white">

                <div class="alert alert-success alert-dismissible fade show" id="addCategoryAlert" style="display:none" role="alert">
                  <strong></strong> <span id="addCategoryAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" id="addCategoryAlertDanger" style="display:none" role="alert">
                  <strong></strong> <span id="addCategoryAlertDangerMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
<!-- 
              <div class="card">
                <div class="card-body"> -->

                
                    <!-- Category image  -->
                    <div class="form-group row">
                      <label for="name" class="col-sm-3 col-form-label">Category Image</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control" id="image" name="image" placeholder="Category Image" />
                      </div>
                    </div>
                    <!-- Category Name  -->
                    <div class="form-group row">
                      <label for="name" class="col-sm-3 col-form-label">Category Name(English)<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Category Name" />
                          <div class="alert-info px-2 py-1 small">Category e.g. Rice</div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="name" class="col-sm-3 col-form-label">Category Name(Chinese)<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="chinese_name" name="chinese_name" placeholder="Category Name" />
                          <div class="alert-info px-2 py-1 small">Category e.g. Rice</div>
                      </div>
                    </div>
              </div>
              <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="clearCategoryFormBtn">Clear</button>
            <button type="submit" id="addCategoryForm" class="btn btn-primary">Save</button>
          </div>
        </form>
    </div>
  </div>
</div>

<script>

    // clear form
      jQuery('#clearCategoryFormBtn').on('click', function (){
        jQuery("#addCategoryForm1")["0"].reset();
      });

  // validation script start here
  jQuery(document).ready(function () {
    jQuery("#addCategoryForm1").submit(function (e) {

        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $.validator.addMethod("imageType", function(value) {
          var ext = $('#image').val().split('.').pop().toLowerCase();
          if(ext == ''){
            return true;
          }else if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1){
            return false;
          }else{
            return true;
          }
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
          if(result){
            const formData1 = new FormData($('#addCategoryForm1')["0"]);
            jQuery.ajax({
                url: "{{ route('SA-AddCategory') }}",
                data: formData1,
                enctype: "multipart/form-data",
                dataType: 'json',
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
                        jQuery("#addCategoryForm1")["0"].reset();
                        $('.varientsDropdownAddCategory').val('');
                        category_main_table.ajax.reload();
                        $(document).ready(function(){
                          listCategory1();
                        });

                    }else {
                        jQuery("#addCategoryAlertDanger").hide();
                        jQuery("#addCategoryAlert").hide();
                    }
                },
            });
          }
        });
      }
    });
  });
// end here

</script>