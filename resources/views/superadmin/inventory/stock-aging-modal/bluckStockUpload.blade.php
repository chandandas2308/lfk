<div class="modal fade bulkStockUploads" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- alert -->
            <div class="alert alert-warning alert-dismissible fade show" id="stock-alert-bulk-warning" role="alert" style="display: none;">
                <strong>Info !</strong> <span id="stock-alert-bulk-warning-msg"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- alert -->

            <!-- alert -->
            <div class="alert alert-success alert-dismissible fade show" id="stock-alert-bulk-success" role="alert" style="display: none;">
                <strong>Info !</strong> <span id="stock-alert-bulk-success-msg"></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- alert -->

            <form enctype="multipart/form-data" method="post" id="uploadStockBulkFile">
                <div class="modal-body bg-white">

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="#bluckStockProduct">Upload File</label>
                                <input type="file" name="bulk_file" id="bluckStockProduct" class="form-control" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="stockbulkClear">Clear</button>
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

    $('#stockbulkClear').on('click', function(k,v){
        $('#uploadStockBulkFile')[0].reset();
    });

      // validation script start here
    $(document).ready(function() {
        jQuery("#uploadStockBulkFile").submit(function (e) {
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
                    
                    bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                        if(result){
                            jQuery.ajax({
                                url: "{{ route('SA-GetBulkStockUpload') }}",
                                data:  new FormData($('#uploadStockBulkFile')[0]),
                                type: "post",
                                contentType: false,
                                cache: false,
                                processData:false,

                                success: function (result) {
                                if(result.bulk_success_alert != null){
                                        jQuery("#stock-alert-bulk-success").hide();
                                        // jQuery("#stock-alert-bulk-warning").show();
                                        jQuery("#uploadStockBulkFile")["0"].reset();
                                        // jQuery("#stock-alert-bulk-warning-msg").html(result.bulk_success_alert);
                                        errorMsg(result.bulk_success_alert);
                                        
                                    }
                                    else if(result.bulk_success != null){
                                        // jQuery("#stock-alert-bulk-warning").hide();
                                        // jQuery("#stock-alert-bulk-success").show();
                                        // jQuery("#stock-alert-bulk-success-msg").html(result.bulk_success);
                                        successMsg(result.success);
                                        $('.modal .close').click();
                                        jQuery("#uploadStockBulkFile")["0"].reset();
                                        getProducts();
                                        getStockAging();
                                    }else {
                                        jQuery("#stock-alert-bulk-warning").hide();
                                        jQuery("#stock-alert-bulk-success").hide();
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
