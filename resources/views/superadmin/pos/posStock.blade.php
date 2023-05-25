        <div class="p-3">
            <!-- orders Tab -->
            <div class="page-header flex-wrap" >
                <h4 class="mb-0">
                    POS Stock
                </h4>
                <div class="d-flex">
                    <a href="#" onclick="jQuery('delOrdersAlert').hide()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addOutletStock"> Create </a>
                </div>
            </div>
            <!-- alert section -->
            <!-- <div class="alert alert-success" id="delOrdersAlert" style="display:none"></div> -->
            <div class="alert alert-success alert-dismissible fade show" id="delOrdersAlert" style="display:none" role="alert">
                <strong></strong> <span id="delOrdersAlertMSG"></span>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- alert section end-->

            <!-- table start -->
            <div class="bg-white p-0 p-md-4" style="overflow-x:auto;">
                <table class="table text-center table-hover">
                    <caption class="sales-orders-main-table1 text-dark fw-bold"></caption>
                    <thead class="fw-bold text-dark">
                        <tr>
                            <th class=" border border-secondary">S/N</th>
                            <th class=" border border-secondary">Title</th>
                            <th class=" border border-secondary">Image</th>
                            <th class=" border border-secondary" colspan="3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="tbody orders-list1">

                    </tbody>
                </table>
            </div>
            <ul class="sales-orders-pagination-refs mt-0 mt-md-3 pagination-referece-css pagination justify-content-center"></ul>
            <!-- table end here -->
        </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- backend js file -->
    

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.ckeditor').ckeditor();
            });
        </script>
<script>
        jQuery(document).ready(function() {
            updateOrders();
        });

        // All Product Details
        function updateOrders() {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-allBlog') }}",
                success: function(response) {
                    let i = 0;
                    jQuery('.orders-list1').html('');
                    $('.sales-orders-main-table1').html('Total Blogs : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.orders-list1').append('<tr>\
                            <td class=" border border-secondary">' + ++i + '</td>\
                            <td class=" border border-secondary">' + value["title"] + '</td>\
                            <td class=" border border-secondary"><img src="/'+value["image"]+'"></td>\
                            <td class=" border border-secondary"><a name="viewOrders" data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewBlog"> <i class="mdi mdi-eye"></i> </a></td>\
                            <td style="" class=" border border-secondary"><a name="editOrders" data-toggle="modal" data-id="' + value["id"] + '" data-target="#updateBlog"> <i class="mdi mdi-pencil"></i> </a></td>\
                            <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesOrders" name="deleteOrders" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                    $('.sales-orders-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.sales-orders-pagination-refs').append(
                            '<li id="sales_orders_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                        );
                    });


                }
            });
        }
        // End function here

        // pagination links css and access page
        $(function() {
            $(document).on("click", "#sales_orders_pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append;

                $.get(finalURL, function(response) {
                    let i = response.from;
                    jQuery('.orders-list1').html('');
                    $('.sales-orders-main-table1').html('Total Orders : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.orders-list1').append('<tr>\
                        <td class=" border border-secondary">' + ++i + '</td>\
                            <td class=" border border-secondary">' + value["title"] + '</td>\
                            <td class=" border border-secondary"><img src="/'+value["image"]+'"></td>\
                            <td class=" border border-secondary"><a name="viewOrders" data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewBlog"> <i class="mdi mdi-eye"></i> </a></td>\
                            <td style="" class=" border border-secondary"><a name="editOrders" data-toggle="modal" data-id="' + value["id"] + '" data-target="#updateBlog"> <i class="mdi mdi-pencil"></i> </a></td>\
                            <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesOrders" name="deleteOrders" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                    $('.sales-orders-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.sales-orders-pagination-refs').append(
                            '<li id="sales_orders_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                        );
                    });
                });
                return false;
            });
        });
        // end here      

        // Edit Orders - start here
        // edit quotation detials
        $(document).on("click", "a[name = 'editOrders']", function(e) {

            let id = $(this).data("id");

            // function getOrderssInfo(id) {
                $.ajax({
                    type: "GET",
                    url: `{{ route('SA-viewBlog')}}`,
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        jQuery.each(response, function(key, value) {

                            $('#blogId').val(value["id"]);

                            $('#titleE').val(value["title"]);

                            $('#imageE').attr('src', '/'+value["image"]);

                            CKEDITOR.instances['descriptionE'].setData(value["description"]);
                        });
                    }
                });
            // }
        });
        // end here

    

        // view individuals orders
        $(document).on("click", "a[name = 'viewOrders']", function(e) {
            let id = $(this).data("id");
            getOrderssInfo(id);

            function getOrderssInfo(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-viewBlog')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        jQuery.each(response, function(key, value) {
                          
                            // jQuery.each(response, function(key, value) {


                                $('#titleV').val(value["title"]);

                                $('#imageV').attr('src', '/'+value["image"]);

                                CKEDITOR.instances['descriptionV'].setData(value["description"]);
                            // });

                        });
                    }
                });
            }
        });
        // end here    


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

                        // alertHideFun();
                        
                        jQuery("#delOrdersAlert").show();
                        jQuery("#delOrdersAlertMSG").html(response.success);
                        updateOrders();

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
        @include('superadmin.pos.pos-stock-modal.createOutlet')