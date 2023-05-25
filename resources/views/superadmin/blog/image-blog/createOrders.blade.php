<div class="modal fade" id="addBlog" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Add Blog</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data" id="storeblog">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">Title<span style="color:red;">*</span></label>
                                        <input type="text" name="title" class="form-control" id="title"
                                            placeholder="Title">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image<span style="color:red;">*</span></label>
                                        <input type="file" name="image" class="form-control" id="image">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md 12">
                                    <div class="form-group">
                                        <label for="description">Description<span style="color:red;">*</span></label>
                                        <textarea class="ckeditor form-control" name="description" id="description" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="clearBlogAdd" >Clear</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script>

    $('#clearBlogAdd').click(function(){
        $('#storeblog')["0"].reset();
        CKEDITOR.instances['description'].setData("");
    });

    $(document).ready(function(){
        jQuery('#storeblog').submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                title : {
                    required : true,
                },
                image : {
                    required : true,
                },
                description : {
                    required : true,
                },
            },
            message:{},
            submitHandler: function(){
                
                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        const formData = new FormData($('#storeblog')["0"]);
                        jQuery.ajax({
                            url: "{{ route('SA-storeBlog') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                
                                if(result.success != null){
                                    jQuery("#storeblog")["0"].reset();
                                    successMsg(result.success);
                                    blog_image_table.ajax.reload();
                                    $('#addBlog .close').click();
                                }else{
                                }
                            }
                        });
                    }
                });
            }
        })
    });
</script>