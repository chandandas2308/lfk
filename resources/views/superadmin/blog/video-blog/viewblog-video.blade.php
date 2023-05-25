<div class="modal-header">
    <h5 class="modal-title " id="BlogVideoLongTitle">View Blog</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body bg-white px-3">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="titleV" value="{{$data->title}}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="image">Video</label> <br>
                <video  alt="" id="imageV" height="200px" width="100%" controls>
                    <source src="/{{$data->video}}" type="video/mp4">
                </video>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md 12">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="ckeditor form-control" id="viewDescriptionV" name="descriptionV" readonly>
                {{ $data->description }}
                </textarea>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //Load CKeditor
        // only load the library if we have a field.
        if ($('#viewDescriptionV').length) {
            CKEDITOR.replace('viewDescriptionV');
        }
        //Code highlighter
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>