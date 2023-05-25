<div class="modal-header">
    <h5 class="modal-title" id="BlogVideoLongTitle">Update Blog</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('SA-updateVideoBlog') }}" method="POST" enctype="multipart/form-data" id="updateVideoblog">
    @csrf
    <div class="modal-body bg-white px-3">
        <input type="text" name="id" id="blogId" value="{{$data->id}}" style="display:none;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Title<span style="color:red;">*</span></label>
                    <input type="text" name="editTitle" class="form-control" id="titleE" value="{{$data->title}}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="image">Video<span style="color:red;">*</span></label>
                    <input type="file" name="editVideo" class="form-control" id="video">
                    <video  height="200px" id="imageE" width="100%" controls>
                        <source  src="/{{$data->video}}" type="video/mp4">
                    </video>
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
        <button type="submit" value="Submit" id="editLoader" class="btn btn-primary">Submit</button>
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
        $('#updateVideoblog')["0"].reset();
        CKEDITOR.instances['descriptionE'].setData("");
    });


    // $(document).ready(function() {

    //     jQuery('#updateVideoblog').submit(function(e) {
    //         e.preventDefault();

    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //             },
    //         });
    //     }).validate({
    //         rules: {
    //             editTitle: {
    //                 required: true,
    //             },
    //             editVideo: {
    //                 required: true,
    //             },
    //             description: {
    //                 required: true,
    //             },
    //         },
    //         message: {},
    //         submitHandler: function() {

    //             bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
    //                 if (result) {
    //                     const formData = new FormData($('#updateVideoblog')["0"]);
    //                     jQuery.ajax({
    //                         url: "{{ route('SA-updateVideoBlog') }}",
    //                         enctype: "multipart/form-data",
    //                         type: "post",
    //                         data: formData,
    //                         contentType: false,
    //                         cache: false,
    //                         processData: false,
    //                         beforeSend: function() {
    //                             $('#editLoader').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    //                         },
    //                         success: function(result) {

    //                             if (result.success != null) {
    //                                 successMsg(result.success);
    //                                 jQuery("#updateVideoblog")["0"].reset();
    //                                 $('#updateVideoblog .close').click();
    //                                 blog_video_table.ajax.reload();
    //                             $('#editLoader').html('Submit');

    //                             } else {}
    //                         }
    //                     });
    //                 }
    //             });
    //         }
    //     })
    // });

</script>