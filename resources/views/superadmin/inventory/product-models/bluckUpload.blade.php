<div class="modal fade bulkUploads" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- alert -->
            <div class="alert alert-warning alert-dismissible fade show" id="alert-bulk-warning" role="alert" style="display: none;">
                <strong>Info !</strong> <span id="alert-bulk-warning-msg"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- alert -->

            <!-- alert -->
            <div class="alert alert-success alert-dismissible fade show" id="alert-bulk-success" role="alert" style="display: none;">
                <strong>Info !</strong> <span id="alert-bulk-success-msg"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- alert -->

            <form enctype="multipart/form-data" method="post" id="uploadBulkFile">
                @csrf
                <div class="modal-body bg-white">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="#bluckProduct">Upload File</label>
                                <input type="file" name="bulk_file" id="bluckProduct" class="form-control" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="bulkUploadClearBtn">Clear</button>
                <button type="submit" id="" class="btn btn-primary">Save</button>
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

<script>

    $('#bulkUploadClearBtn').on('click', function(k,v){
        $('#uploadBulkFile')[0].reset();
    });

      // validation script start here
    $(document).ready(function() {
        jQuery("#uploadBulkFile").submit(function (e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            })
        }).validate({
                rules: {
                    bulk_file : {
                        required:true,
                    }
                },
                messages : {
                    bulk_file: {
                        required: "Please choose file.",
                    },
                },
                submitHandler:function(){

                    bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                        if(result){
                            jQuery.ajax({
                                url: "{{ route('SA-GetBulkProductUpload') }}",
                                data:  new FormData($('#uploadBulkFile')[0]),
                                type: "post",
                                contentType: false,
                                cache: false,
                                processData:false,
                                success: function (result) {
                                if(result.bulk_success_alert != null){
                                        errorMsg(result.bulk_success_alert);
                                        jQuery("#uploadBulkFile")["0"].reset();
                                    }
                                    else if(result.bulk_success != null){
                                        errorMsg(`In ${result.error_records} records found issues`);
                                        successMsg(`Total ${result.success_records} records inserted`);
                                        $('.modal .close').click();
                                        jQuery("#uploadBulkFile")["0"].reset();
                                        product_main_table.ajax.reload();
                                        stock_aging_main_table.ajax.reload();
                                    }else {
                                        jQuery("#alert-bulk-warning").hide();
                                        jQuery("#alert-bulk-success").hide();
                                        jQuery("#uploadBulkFile")["0"].reset();
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
