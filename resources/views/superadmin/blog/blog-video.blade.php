<div class="p-3">
    <!-- orders Tab -->
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Blog Video
        </h4>
        <div class="d-flex">
            <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#Video"> Create </a>
        </div>
    </div>

<div class="table-responsive">
<table class="text-center table table-responsive table-bordered" id="blog_video_table">

<thead>
    <tr>
        <th class="text-center">S/N</th>
        <th class="text-center">Title</th>
        <th class="text-center">Video Name</th>
        <th class="text-center">Action</th>
    </tr>
</thead>
</table>
</div>
    
</div>

<div class="modal fade" id="updateBlogVideo" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitleVideo" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="updateBlogVideoData">
              
        </div>
    </div>
</div>
<button style="display: none;" data-toggle="modal" data-target="#updateBlogVideo" id="updateBlogVideoBtn">updateBlog</button>

<div class="modal fade" id="viewBlogVideo" tabindex="-1" role="dialog" aria-labelledby="BlogVideoCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="viewBlogVideoData">
        </div>
    </div>
</div>
<button style="display: none;" data-toggle="modal" data-target="#viewBlogVideo" id="viewBlogVideoBtn">updateBlog</button>


<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });

    $(document).ready(function() {
        blog_video_table = $('#blog_video_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:8,
            buttons: [],
            ajax: {
                url: "{{ route('SA-allVideoBlog') }}",
                type: 'GET',
            }
        });
    });

    // jQuery(document).ready(function() {
    //     fetchAllVideoBlogs();
    // });

    // fetchAllVideoBlogs();

    // // All Product Details
    // function fetchAllVideoBlogs() {

    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('SA-allVideoBlog') }}",
    //         success: function(response) {
    //             let i = 0;
    //             jQuery('.orders-Videolist').html('');
    //             $('.sales-orders-Video-table').html('Total Video Blogs : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.orders-Videolist').append('<tr>\
    //                         <td class=" border border-secondary">' + ++i + '</td>\
    //                         <td class=" border border-secondary">' + value["title"] + '</td>\
    //                         <td class=" border border-secondary">' + value["video_name"] + '</td>\
    //                         <td class=" border border-secondary"><a name="viewBlogVideo"  data-id="' + value["id"] + '" > <i class="mdi mdi-eye"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a name="editBlogVideo" data-id="' + value["id"] + '"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalVideo" name="deleteBlogVideo" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                     </tr>');
    //             });

    //             $('.sales-Video-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.sales-Video-pagination-refs').append(
    //                     '<li id="sales_Video_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
    //                 );
    //             });


    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //     $(document).on("click", "#sales_Video_pagination a", function() {
    //         //get url and make final url for ajax 
    //         var url = $(this).attr("href");
    //         var append = url.indexOf("?") == -1 ? "?" : "&";
    //         var finalURL = url + append;

    //         $.get(finalURL, function(response) {
    //             let i = response.from;
    //             jQuery('.orders-Videolist').html('');
    //             $('.sales-orders-Video-table').html('Total Video Blogs : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.orders-Videolist').append('<tr>\
    //                     <td class=" border border-secondary">' + ++i + '</td>\
    //                         <td class=" border border-secondary">' + value["title"] + '</td>\
    //                         <td class=" border border-secondary">' + value["video_name"] + '</td>\
    //                         <td class=" border border-secondary"><a name="viewBlogVideo"  data-id="' + value["id"] + '"  > <i class="mdi mdi-eye"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a name="editBlogVideo"  data-id="' + value["id"] + '" > <i class="mdi mdi-pencil"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalVideo" name="deleteBlogVideo" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                     </tr>');
    //             });

    //             $('.sales-Video-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.sales-Video-pagination-refs').append(
    //                     '<li id="sales_Video_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // end here      

    $(document).on("click", "a[name = 'editBlogVideo']", function(e) {

        let id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: `{{ route('SA-viewVideoBlog')}}`,
            data: {
                'id': id,
                'status': 0,
            },
            success: function(response) {
                $('#updateBlogVideoBtn').click();
                $('#updateBlogVideoData').html(response);
            }
        });
        // }
    });
    // end here

    $(document).on("click", "a[name = 'viewBlogVideo']", function(e) {
        let id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `{{ route('SA-viewVideoBlog')}}`,
            data: {
                'id': id,
                'status': 1,
            },
            success: function(response) {
                $('#viewBlogVideoBtn').click();
                $('#viewBlogVideoData').html(response);
            }
        });
    });   

    // delete a single orders using id
    $(document).on("click", "a[name = 'removeConfirmVideoBlogs']", function(e) {
        let id = $(this).data("id");
        delOrders(id);

        function delOrders(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-destroyVideoBlog')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    blog_video_table.ajax.reload();
                    $("#removeModalVideo .close").click();
                }
            });
        }
    });


    $(document).on("click", "a[name = 'deleteBlogVideo']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveSelectedSalesVideo').data('id', id);
    });

    $(document).ready(function() {
                @if($errors->any())
                    toastr.error("{{ implode('', $errors->all(':message')) }}");
                @endif
                @if(session('status'))
                    toastr.success("{{ session('status') }}");
                @endif
        });

</script>

<div class="modal fade" id="removeModalVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Alert</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">DO YOU WANT TO DELETE?<span id="removeElementId"></span> </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                <a name="removeConfirmVideoBlogs" class="btn btn-primary" id="confirmRemoveSelectedSalesVideo">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Create Orders Model -->
@include('superadmin.blog.video-blog.addblog-video')