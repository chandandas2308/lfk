<!-- Banner Tab -->
<div class="p-3 bg-white">
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Banners
        </h4>
        <div class="d-flex">
            <!-- <select name="" id="selectDeliverymanStatus" onchange="deliverymanFilterByPayStatus()" class="form-control m-2 " style="border:2px solid #ccc;">
                <option value="" class="bg-info text-white" style="font-size: small;">Select Status</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select> -->
            <!-- Reset Filter -->
            <!-- <a href="#" id="resetBannerFilter" class="text-black reset-btn p-2 align-items-center" style="height:38px;margin-top:8px;margin-left: 3px !important; margin-right:3px !important; border:2px solid #ccc !important;">Reset</a> -->
        </div>
        <div class="d-flex">
            <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addBanner"> Add Banner </a>
        </div>
    </div>

    <!-- alert section -->
    <div class="alert alert-success" id="delBannerAlert" style="display:none"></div>
    <!-- alert section end-->

    <!-- table start -->
    <div class="table-responsive">
    <table class="text-center table table-responsive table-bordered" id="banner_main_table">
            <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th class="text-center">Title</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Product</th>
                    <th class="text-center">Image </th>
                    <th class="text-center">Status </th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
       
    <!-- table end here -->
</div>

<!-- Add warehouse Model -->
@include('superadmin.OfferPackeges.banner-models.addBanner')
<!-- end model here -->

<!-- Edit banner Model -->
@include('superadmin.OfferPackeges.banner-models.editBanner')
<!-- end model here -->

<!-- View banner Model -->
@include('superadmin.OfferPackeges.banner-models.viewBanner')
<!-- end model here -->

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>

    
    $(document).ready(function() {
        banner_main_table = $('#banner_main_table').DataTable({
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
                url: "{{ route('SA-GetBanners') }}",
                type: 'GET',
            }
        });
    });
    
    // get a single Banner
    $(document).on("click", "a[name = 'editbanner']", function(e) {
        let id = $(this).data("id");
        getBanner(id);

        function getBanner(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetBanner')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#editbannerID').val(value["id"]);
                        $('#edittitle').val(value["title"]);
                        $('#editdescription').val(value["description"]);
                        $('#editbanner_image').attr("src", '/banners/' + value["image"].substring(value['image'].lastIndexOf('/') + 1));
                        $('#product_id_edit').val(value["product_id"]);
                        $('#product_name_edit').val(value["product_name"]);
                        $('#bannerType').val(value['type']);
                        $('#editstatus1').val(value["status"]);
                    });
                }
            });
        }
    });

    // view a single Banner using id
    $(document).on("click", "a[name = 'viewbanner']", function(e) {
        let id = $(this).data("id");
        getBanner(id);

        function getBanner(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-ViewBanner')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#viewtitle').val(value["title"]);
                        $('#viewdescription').html(value["description"]);
                        $('#viewbanner_image').attr("src", '/banners/' + value["image"].substring(value['image'].lastIndexOf('/') + 1));
                        $('#viewproduct_name').val(value["product_name"]);
                        $('#viewstatus1').val(value["status"]);
                        $('#bannerTypeView').val(value['type']);
                    });
                }
            });
        }
    });

    // filter
    function deliverymanFilterByPayStatus() {
        let status = $('#selectDeliverymanStatus').val();
        $.ajax({
            type: "GET",
            url: "{{ route('SA-FilterStatusOfBanner') }}",
            data: {
                "status": status,
            },
            success: function(response) {

                let i = 0;
                jQuery('.bannerbody').html('');
                $('.deliveryman-main-table').html('Total Banners : ' + response.total);
                jQuery.each(response.data, function(key, value) {

                    $('.bannerbody').append('<tr>\
                            <td class="border border-secondary">' + ++i + '</td>\
                            <td class=" border border-secondary">' + value["title"] + '</td>\
                            <td class=" border border-secondary">' + value["description"] + '</td>\
                            <td class=" border border-secondary">' + value["product_name"] + '</td>\
                            <td class=" border border-secondary"> <img src= "/banners/' + value["image"].substring(value['image'].lastIndexOf('/') + 1) + '" /></td>\
                            <td class=" border border-secondary">' + value["status"] + '</td>\
                            <td class=" border border-secondary"><a name="viewbanner"  data-toggle="modal" data-id="' + value["id"] + '"  data-target=".viewBanner"> <i class="mdi mdi-eye"></i> </a></td>\
                            <td class=" border border-secondary"><a name="editbanner" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editBanner"> <i class="mdi mdi-pencil"></i> </a></td>\
                            <td class="border border-secondary"><a name="deletebanner" data-toggle="modal" data-target="#removeModalBanner" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                });
                $('.deliveryman-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.deliveryman-pagination-refs').append(
                        '<li id="search_delivery_man_by_status_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
                    );
                });


            }
        });
    }
    // pagination links css and access page
    $(function() {
        $(document).on("click", "#search_delivery_man_by_status_pagination a", function() {
            //get url and make final url for ajax 
            var url = $(this).attr("href");
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append + "status=" + $('#selectDeliverymanStatus').val();

            $.get(finalURL, function(response) {
                let i = response.from;

                jQuery('.bannerbody').html('');
                $('.deliveryman-main-table').html('Total Banners : ' + response.total);
                jQuery.each(response.data, function(key, value) {
                    $('.bannerbody').append('<tr>\
                                <td class="border border-secondary">' + i++ + '</td>\
                                <td class=" border border-secondary">' + value["title"] + '</td>\
                                <td class=" border border-secondary">' + value["description"] + '</td>\
                                <td class=" border border-secondary">' + value["product_name"] + '</td>\
                                <td class=" border border-secondary"> <img src= "/banners/' + value["image"].substring(value['image'].lastIndexOf('/') + 1) + '" /></td>\
                                <td class=" border border-secondary">' + value["status"] + '</td>\
                                <td class=" border border-secondary"><a name="viewbanner"  data-toggle="modal" data-id="' + value["id"] + '"  data-target=".viewBanner"> <i class="mdi mdi-eye"></i> </a></td>\
                                <td class=" border border-secondary"><a name="editbanner" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editBanner"> <i class="mdi mdi-pencil"></i> </a></td>\
                                <td class="border border-secondary"><a name="deletebanner" data-toggle="modal" data-target="#removeModalBanner" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                            </tr>');
                });
                $('.deliveryman-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.deliveryman-pagination-refs').append(
                        '<li id="search_delivery_man_by_status_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here 

    $(document).on("click", "a[name = 'removeConfirmBannerDetails']", function(e) {
        let id = $(this).data("id");
        delRequest(id);

        function delRequest(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RemoveBanner')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    banner_main_table.ajax.reload();
                    $("#removeModalBanner .close").click();

                }
            });
        }
    });


    $(document).on("click", "a[name = 'deletebanner']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveBanner').data('id', id);
    });
</script>

<div class="modal fade" id="removeModalBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a name="removeConfirmBannerDetails" class="btn btn-primary" id="confirmRemoveBanner">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>