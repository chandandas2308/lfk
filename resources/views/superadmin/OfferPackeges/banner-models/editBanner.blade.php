<div class="modal fade" id="editBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lgs" role="document">
        <div class="modal-content bg-white p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" id="editBannerForm1" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body">

                    <!-- info & alert section -->
                    <div class="alert alert-success" id="editBannerAlert" style="display:none"></div>
                    <div class="alert alert-danger" style="display:none">
                        <ul></ul>
                    </div>
                    <!-- end -->
                            <input type="hidden" id="editbannerID" name="id"/>
                            <div class="form-group row">
                                <label for="image" class="col-sm-3 col-form-label">Banner Image<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="bannerImg" name="image" accept="image/*" />
                                    <img src="" id="editbanner_image" height="100" width="100" class="img-fluid" />
                                </div>
                            </div>
                            <!-- Title  -->
                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label">Title<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edittitle" name="title" placeholder="Title" />
                                </div>
                            </div>
                            <!-- Description  -->
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label">Description<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="editdescription" class="form-control" cols="30" rows="2" placeholder="Description"></textarea>
                                </div>
                            </div>

                            <!-- Product -->
                            <div class="form-group row">
                                <label for="product" class="col-sm-3 col-form-label">Product</label>
                                <div class="col-sm-9">
                                    <select name="product_id" id="product_id_edit" onchange="getProductIdfnEdit()" class="form-control" ></select>
                                    <input type="text" class="form-control" name="product_name" id="product_name_edit" placeholder="Product" style="display:none;" />
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group row">
                                <label for="editstatus1" class="col-sm-3 col-form-label">Status<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="status" id="editstatus1" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Type<span style="color:red;">*</span></label>
                                <div class="col-sm-9">
                                    <select name="type" id="bannerType" class="form-control">
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
                    <button type="button" class="btn btn-primary" id="editBannerFormClearBtn">Clear</button>
                    <button type="submit" id="editBannerForm" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>

    
// clear form
    jQuery('#editBannerFormClearBtn').on('click', function() {
        jQuery("#editBannerForm1")["0"].reset();
    });
    
  $(document).ready(function() {

        jQuery("#editBannerForm1").submit(function(e) {
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

            type: {
                required: true,
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
            $.ajax({
                url: "{{ route('SA-EditBanner') }}",
                type: "POST",
                data: new FormData($('#editBannerForm1')[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function(result) {
                    
                    if (result.error != null) {
                        jQuery.each(result.error, function(key, value) {
                            errorMsg(value);
                        });
                    } else if (result.barerror != null) {
                        jQuery("#editBannerAlert").hide();
                        errorMsg(result.barerror);
                    } else if (result.success != null) {
                        $('#editBanner .close').click();
                        jQuery(".alert-danger").hide();
                        successMsg(result.success);
                        banner_main_table.ajax.reload();
                    } else {
                        jQuery(".alert-danger").hide();
                        jQuery("#editBannerAlert").hide();
                    }
                }
            });
        }
    });
        }

        });
    });
// end here

    getProductsBannerEdit();

    let productListArrEdit = [];

    function getProductsBannerEdit() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetProductsDetailsList')}}",
            success: function(response) {

                productListArrEdit = response;

                $('#product_id_edit').append('<option value="">Select Product</option>');
                jQuery.each(response, function(key, value) {
                    $('#product_id_edit').append(
                        '<option value="' + value["id"] + '">\
                    ' + value["product_name"] + '\
                    </option>'
                    );
                });
            }
        });
    }

    function getProductIdfnEdit(){

        console.log(productListArrEdit);

        jQuery.each(productListArrEdit, function(key, value){
            let id = $('#product_id_edit').val();
            if(value['id'] == id){
                $('#product_name_edit').val(value['product_name']);
            }
        });
    }


</script>