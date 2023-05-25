<div class="modal-header">
    <h5 class="modal-title" id="BlogLongTitle">Update Blog</h5>
    <button type="button"  id="updatrblogclose" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="" method="POST" enctype="multipart/form-data" id="updateblog">
    @csrf
    <div class="modal-body bg-white px-3">
        <input type="text" name="id" id="blogId"  value="{{$data->id}}" style="display:none;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title<span style="color:red;">*</span></label>
                    <input type="text" name="title" class="form-control" id="titleE" value="{{$data->title}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Image<span style="color:red;">*</span></label>
                    <input type="file" name="image" class="form-control" id="image">
                    <img src="/{{$data->image}}" alt="" height="100px" id="imageE" width="100px">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md 12">
                <div class="form-group">
                    <label for="description">Description<span style="color:red;">*</span></label>
                    <textarea class="ckeditor form-control" value="" name="description" id="descriptionE" required>
                    {{ $data->description }}
                    </textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="clrEForm">Clear</button>
        <button type="submit" value="Submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        //Load CKeditor
        // only load the library if we have a field.
        if ($('#descriptionE').length) {
            CKEDITOR.replace('descriptionE');
        }
        //Code highlighter
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });

    $('#clrEForm').click(function() {
        $('#updateblog')["0"].reset();
        CKEDITOR.instances['descriptionE'].setData("");
    });


    $(document).ready(function() {

        jQuery('#updateblog').submit(function(e) {
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
                image: {
                    required: true,
                },
                description: {
                    required: true,
                },
            },
            message: {},
            submitHandler: function() {

                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        const formData = new FormData($('#updateblog')["0"]);
                        jQuery.ajax({
                            url: "{{ route('SA-updateBlog') }}",
                            // data: jQuery("#updateblog").serialize(),
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {

                                if (result.success != null) {
                                    successMsg(result.success);
                                    blog_image_table.ajax.reload();
                                    jQuery("#updateblog")["0"].reset();
                                    $('#updateBlog .close').click();
                                } else {}
                            }
                        });
                    }
                });
            }
        })
    });
</script>