<div class="modal fade" id="Video" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="BlogVideoLongTitle">Add Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <form action="{{route('SA-storevideo')}}" method="POST" enctype="multipart/form-data" id="storeblogVideo">
                @csrf
                <div class="modal-body bg-white px-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title<span style="color:red;">*</span></label>
                                <input type="text" name="titleVideo" class="form-control" id="titleVideo" placeholder="Title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Video<span style="color:red;">*</span></label>
                                <input type="file" name="video" class="form-control" id="video">
                            </div>
                            <div class="form-group">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md 12">
                            <div class="form-group">
                                <label for="description">Description<span style="color:red;">*</span></label>
                                <textarea class="form-control" name="descriptionVideo" id="descriptionVideo" required></textarea>
                                <!-- ckeditor -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="clearVideoBlogAdd">Clear</button>
                    <button type="submit" value="Submit" id="submitloader" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- jQuery CDN -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>


<script>
    $('#clearVideoBlogAdd').click(function() {
        $('#storeblogVideo')["0"].reset();
        CKEDITOR.instances['description'].setData("");
    });

        // $(function () {
            // $(document).ready(function () {
                $('#storeblogVideo').ajaxForm({
                    beforeSend: function () {
                        var percentage = '0';
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentage = percentComplete;
                        $('.progress .progress-bar').css("width", percentage+'%', function() {
                          return $(this).attr("aria-valuenow", percentage) + "%";
                        })
                    },
                    complete: function (xhr) {
                        console.log(xhr);
                        jQuery("#storeblogVideo")["0"].reset();
                        successMsg("Blog added successfully");
                        $('#Video .close').click();
                        blog_video_table.ajax.reload();
                    }
                });
            // });
        // });

    // $(document).ready(function() {
    //     jQuery('#storeblogVideo').submit(function(e) {
    //         e.preventDefault();

    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //             },
    //         });
    //     }).validate({
    //         rules: {
    //             titleVideo: {
    //                 required: true,
    //             },
    //             video: {
    //                 required: true,
    //             },
    //             descriptionVideo: {
    //                 required: true,
    //             },
    //         },
    //         message: {},
    //         submitHandler: function() {

    //             bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
    //                 if (result) {
    //                     const formData = new FormData($('#storeblogVideo')["0"]);
    //                     jQuery.ajax({
    //                         url: "{{route('SA-storevideo')}}",
    //                         enctype: "multipart/form-data",
    //                         type: "post",
    //                         data: formData,
    //                         contentType: false,
    //                         cache: false,
    //                         processData: false,
    //                         beforeSend: function() {
    //                             $('#submitloader').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    //                         },
    //                         success: function(result) {

    //                             if (result.success != null) {
    //                                 jQuery("#storeblogVideo")["0"].reset();
    //                                 successMsg(result.success);
    //                                 $('#Video .close').click();
    //                                 blog_video_table.ajax.reload();
    //                             $('#submitloader').html('Submit');

    //                             } else {}
    //                         }

    //                     });
    //                 }
    //             });
    //         }
    //     })
    // });
</script>