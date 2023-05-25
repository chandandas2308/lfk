<div class="p-3">
    <!-- orders Tab -->
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Blog Images
        </h4>
        <div class="d-flex">
            <a href="#" onclick="jQuery('delOrdersAlert').hide()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addBlog"> Create </a>
        </div>
    </div>

    <!-- table start -->

    <div class="table-responsive"> 
      <table class="text-center table table-responsive table-bordered" id="blog_image_table">
            <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
      </table>
   </div>    
   
    <!-- table end here -->
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<div class="modal fade" id="updateBlog" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="updateBlogData">
            <!--  -->
        </div>
    </div>
</div>
<button style="display: none;" data-toggle="modal" data-target="#updateBlog" id="updateBlogBtn">updateBlog</button>

<div class="modal fade" id="viewBlog" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content" id="viewBlogData">
        </div>
    </div>
</div>
<button style="display: none;" data-toggle="modal" data-target="#viewBlog" id="viewBlogBtn">updateBlog</button>


<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        blog_image_table = $('#blog_image_table').DataTable({
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
                url: "{{ route('SA-allBlog') }}",
                type: 'GET',
            }
        });
    });

    $(document).ready(function() {
        $('.ckeditor').ckeditor();
    });

    // jQuery(document).ready(function() {
    //     fetchAllBlogs();
    // });

    // fetchAllBlogs();

    // // All Product Details
    // function fetchAllBlogs() {

    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('SA-allBlog') }}",
    //         success: function(response) {
    //             let i = 0;
    //             jQuery('.orders-list1').html('');
    //             $('.sales-orders-main-table1').html('Total Blogs : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.orders-list1').append('<tr>\
    //                         <td class=" border border-secondary">' + ++i + '</td>\
    //                         <td class=" border border-secondary">' + value["title"] + '</td>\
    //                         <td class=" border border-secondary"><img src="/' + value["image"] + '"></td>\
    //                         <td class=" border border-secondary"><a name="viewOrders"  data-id="' + value["id"] + '" > <i class="mdi mdi-eye"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a name="editOrders" data-id="' + value["id"] + '"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesOrders" name="deleteOrders" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                     </tr>');
    //             });

    //             $('.sales-orders-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.sales-orders-pagination-refs').append(
    //                     '<li id="sales_orders_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
    //                 );
    //             });


    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //     $(document).on("click", "#sales_orders_pagination a", function() {
    //         //get url and make final url for ajax 
    //         var url = $(this).attr("href");
    //         var append = url.indexOf("?") == -1 ? "?" : "&";
    //         var finalURL = url + append;

    //         $.get(finalURL, function(response) {
    //             let i = response.from;
    //             jQuery('.orders-list1').html('');
    //             $('.sales-orders-main-table1').html('Total Blogs : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.orders-list1').append('<tr>\
    //                     <td class=" border border-secondary">' + ++i + '</td>\
    //                         <td class=" border border-secondary">' + value["title"] + '</td>\
    //                         <td class=" border border-secondary"><img src="/' + value["image"] + '"></td>\
    //                         <td class=" border border-secondary"><a name="viewOrders"  data-id="' + value["id"] + '"  > <i class="mdi mdi-eye"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a name="editOrders"  data-id="' + value["id"] + '" > <i class="mdi mdi-pencil"></i> </a></td>\
    //                         <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesOrders" name="deleteOrders" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                     </tr>');
    //             });

    //             $('.sales-orders-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.sales-orders-pagination-refs').append(
    //                     '<li id="sales_orders_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // end here      

    $(document).on("click", "a[name = 'editOrders']", function(e) {

        let id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: `{{ route('SA-viewBlog')}}`,
            data: {
                'id': id,
                'status': 0,
            },
            success: function(response) {
                $('#updateBlogBtn').click();
                $('#updateBlogData').html(response);
            }
        });
        // }
    });
    // end here

    $(document).on("click", "a[name = 'viewOrders']", function(e) {
        let id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `{{ route('SA-viewBlog')}}`,
            data: {
                'id': id,
                'status': 1,
            },
            success: function(response) {
                $('#viewBlogBtn').click();
                $('#viewBlogData').html(response);
            }
        });
    });

    // delete a single orders using id
    $(document).on("click", "a[name = 'removeConfirmSalesOrders']", function(e) {
        let id = $(this).data("id");
        delOrders(id);

        function delOrders(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-destroyBlog')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    blog_image_table.ajax.reload();
                    $("#removeModalSalesOrders .close").click();

                }
            });
        }
    });


    $(document).on("click", "a[name = 'deleteOrders']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveSelectedSalesOrders').data('id', id);
    });
</script>

<div class="modal fade" id="removeModalSalesOrders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a name="removeConfirmSalesOrders" class="btn btn-primary" id="confirmRemoveSelectedSalesOrders">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Create Orders Model -->
@include('superadmin.blog.image-blog.createOrders')
