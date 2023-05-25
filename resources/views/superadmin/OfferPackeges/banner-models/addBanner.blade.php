<div class="modal fade" id="addBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lgs" role="document">
        <div class="modal-content bg-white p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Banner</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" id="addBannerForm1" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">

                    <!-- info & alert section -->
                    <div class="alert alert-success" id="addBannerAlert1" style="display:none"></div>
                    <div class="alert alert-danger" style="display:none">
                        <ul></ul>
                    </div>
                    <!-- end -->

                    <!-- <div class="card"> -->
                        <!-- <div class="card-body"> -->

                            <!-- Upload Banner -->
                            <div class="form-group row">
                                <label for="image" class="col-sm-3 col-form-label">Banner Image<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" /><span style="color:red;">Image size must be at least 1284 X 600 px</span>
                                </div>
                            </div>

                            <!-- Title  -->
                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">Title<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" />
                                </div>
                            </div>

                            <!-- Description  -->
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label">Description<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="2" placeholder="Description"></textarea>
                                </div>
                            </div>

                            <!-- Product -->
                            <div class="form-group row">
                                <label for="product" class="col-sm-3 col-form-label">Product</label>
                                <div class="col-sm-9">
                                    <select name="product_id" id="product_id" onchange="getProductIdfn()" class="form-control" ></select>
                                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product"  style="display:none;" />
                                    <!-- <input type="text" name="product_id" id="product_id" style="display:;" /> -->
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Status<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Type<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="type" id="status" class="form-control">
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
                            
                        <!-- </div> -->
                    <!-- </div> -->
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="addBannerFormClearBtn">Clear</button>
                    <button type="submit" id="addBannerForm" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<!-- backend js file -->

<script>

// clear form
    jQuery('#addBannerFormClearBtn').on('click', function() {
        jQuery("#addBannerForm1")["0"].reset();
    });

  // validation script start here
  $(document).ready(function() {

    jQuery("#addBannerForm1").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
      rules: {

        title: {
          required: true,
        },

        description: {
          required: true,
        },

        image: {
          required: true,
        },
        
        type:{
            required: false,  
        },

        product_name: {
          required: false,
        },

        status: {
            required: true,
        },

      },
      messages: {},
      submitHandler : function(){
        bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
          if(result){
            jQuery.ajax({
                url: "{{ route('SA-AddBanner') }}",
                type: "POST",
                data: new FormData($('#addBannerForm1')[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    if (result.error != null) {
                        jQuery.each(result.error, function(key, value) {
                            errorMsg(value);
                        });
                    } else if (result.barerror != null) {
                        errorMsg(result.barerror);
                    } else if (result.success != null) {
                        $('#addBanner .close').click();
                        successMsg(result.success);
                        jQuery("#addBannerForm1")["0"].reset();
                        banner_main_table.ajax.reload();
                    } else {
                        jQuery(".alert-danger").hide();
                        jQuery("#addBannerAlert1").hide();
                    }
                },
            });
        }
    });
      }

    });
  });
  // end here

getProductsBanner();

let productListArr = [];

function getProductsBanner() {
    $.ajax({
        type: "GET",
        url: "{{ route('SA-GetProductsDetailsList')}}",
        success: function(response) {

            productListArr = response;

            $('#product_id').append('<option value="">Select Product</option>');
            jQuery.each(response, function(key, value) {
                $('#product_id').append(
                    '<option value="' + value["id"] + '">\
                ' + value["product_name"] + '\
                </option>'
                );
            });
        }
    });
}

function getProductIdfn(){

    console.log(productListArr);

    jQuery.each(productListArr, function(key, value){
        let id = $('#product_id').val();
        if(value['id'] == id){
            $('#product_name').val(value['product_name']);
        }
    });
}

    // jQuery(document).ready(function() {
    //     jQuery("#addBannerForm1").submit(function(e) {
    //         e.preventDefault();
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //             },
    //         });
    //         jQuery.ajax({
    //             url: "{{ route('SA-AddBanner') }}",
    //             type: "POST",
    //             data: new FormData(this),
    //             contentType: false,
    //             cache: false,
    //             processData: false,
    //             success: function(result) {
    //                 alertHideFun();
    //                 if (result.error != null) {
    //                     jQuery(".alert-danger>ul").html(
    //                         "<li> Info ! Please complete below mentioned fields : </li>"
    //                     );
    //                     jQuery.each(result.error, function(key, value) {
    //                         jQuery(".alert-danger").show();
    //                         jQuery(".alert-danger>ul").append(
    //                             // "<li>" + key + " : " + value + "</li>"
    //                         );
    //                     });
    //                 } else if (result.barerror != null) {
    //                     jQuery("#addBannerAlert1").hide();
    //                     jQuery(".alert-danger").show();
    //                     jQuery(".alert-danger").html(result.barerror);
    //                 } else if (result.success != null) {
    //                     jQuery(".alert-danger").hide();
    //                     jQuery("#addBannerAlert1").html(result.success);
    //                     jQuery("#addBannerAlert1").show();
    //                     jQuery("#addBannerForm1")["0"].reset();
    //                     getBanners();
    //                 } else {
    //                     jQuery(".alert-danger").hide();
    //                     jQuery("#addBannerAlert1").hide();
    //                 }
    //             },
    //         });
    //     });
    // });
</script>