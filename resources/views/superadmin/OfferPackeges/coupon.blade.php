<!-- Coupons Tab -->
<div class="p-3">
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Coupons
        </h4>
        <div class="d-flex">
            <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addCoupon"> Add Coupon </a>
        </div>
    </div>

    <!-- <div class="alert alert-success" id="delCouponDetails" style="display:none"></div> -->
    <div class="alert alert-success alert-dismissible fade show" id="delCouponDetails" style="display:none" role="alert">
        <strong></strong> <span id="removeCouponAlertMSG"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- alert section end-->

    <!-- table start -->
    <div class="table-responsive">
    <table class="text-center table table-responsive table-bordered" id="coupon_details_main_table">
            <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th class="text-center">Coupon Name</th>
                    <th class="text-center">Threshold</th>
                    <th class="text-center">Face Value</th>
                    <th class="text-center">Remaining Quantity / Issued</th>
                    <th class="text-center">Start Date</th>
                    <th class="text-center">End Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
     
    <!-- table end here -->
</div>

<!-- Add coupon Model -->
@include('superadmin.OfferPackeges.coupon-models.addCoupon')
<!-- end model here -->

<!-- Edit coupon Model -->
@include('superadmin.OfferPackeges.coupon-models.editCoupon')
<!-- end model here -->

<!-- View coupon Model -->
@include('superadmin.OfferPackeges.coupon-models.viewCoupon')
<!-- end model here -->

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>

    $(document).ready(function() {
        coupon_details_main_table = $('#coupon_details_main_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:10,
            buttons: [],
            ajax: {
                url: "{{ route('SA-GetCoupons') }}",
                type: 'GET',
            }
        });
    });

    // jQuery(document).ready(function() {
    //     getCoupons();
    // });

    // // All Coupon Details
    // function getCoupons() {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('SA-GetCoupons') }}",
    //         success: function(response) {
    //             let i = 0;
    //             jQuery('.couponbody').html('');
    //             $('.coupon-details-main-table').html('Total Results  : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.couponbody').append('<tr>\
    //                     <td class="border border-secondary">' + ++i + '</td>\
    //                     <td class="border border-secondary">' + value["coupon"] + '</td>\
    //                     <td class="border border-secondary">' + ((value["coupon_type"] == "full_discount_btn")?"full discount coupon":(value["coupon_type"] == "discount_by_value_btn")?"discount by value":"discount by precentage") + '</td>\
    //                     <td class="border border-secondary">' + value["face_value"] + '</td>\
    //                     <td class="border border-secondary">' + ((value["no_of_used_coupon"] != null)?value["no_of_used_coupon"]:0)+"/"+value["no_of_coupon"] + '</td>\
    //                     <td class="border border-secondary">' + value["start_date"] + '</td>\
    //                     <td class="border border-secondary">' + value["end_date"] + '</td>\
    //                     <td class="border border-secondary"><a name="viewcoupon"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewCoupon"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="removeCoupon" data-toggle="modal" data-target="#removeModalCoupon" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });

    //             $('.coupon-list-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.coupon-list-pagination-refs').append(
    //                     '<li id="coupon-list-details-pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //     $(document).on("click", "#coupon-list-details-pagination a", function() {
    //         //get url and make final url for ajax 
    //         var url = $(this).attr("href");
    //         var append = url.indexOf("?") == -1 ? "?" : "&";
    //         var finalURL = url + append;

    //         $.get(finalURL, function(response) {
    //             let i = response.from;
    //             jQuery('.couponbody').html('');
    //             $('.coupon-details-main-table').html('Total Results  : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.couponbody').append('<tr>\
    //                     <td class="border border-secondary">' + ++i + '</td>\
    //                     <td class="border border-secondary">' + value["coupon"] + '</td>\
    //                     <td class="border border-secondary">' + ((value["coupon_type"] == "full_discount_btn")?"full discount coupon":(value["coupon_type"] == "discount_by_value_btn")?"discount by value":"discount by precentage") + '</td>\
    //                     <td class="border border-secondary">' + value["face_value"] + '</td>\
    //                     <td class="border border-secondary">' + ((value["no_of_used_coupon"] != null)?value["no_of_used_coupon"]:0)+"/"+value["no_of_coupon"] + '</td>\
    //                     <td class="border border-secondary">' + value["start_date"] + '</td>\
    //                     <td class="border border-secondary">' + value["end_date"] + '</td>\
    //                     <td class="border border-secondary"><a name="viewcoupon"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewCoupon"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td  class="border border-secondary"><a name="deletecoupon" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });

    //             $('.coupon-list-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.coupon-list-pagination-refs').append(
    //                     '<li id="coupon-list-details-pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // // End function here

    // get a single Coupon
    $(document).on("click", "a[name = 'editcoupon']", function(e) {
        let id = $(this).data("id");
        getCoupon(id);
        function getCoupon(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCoupon')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    console.log(response);
                    jQuery.each(response, function(key, value) {
                        $('#editcouponID').val(value["id"]);
                        $('#coupon_number_edit').val(value["coupon"]);

                        // $('#editcoupon_type').val(value["coupon_type"]);

                        if(value['coupon_type'] == 'full_discount_btn'){

                            $('#full_discount_btn_edit').prop('checked', true);
                            $('#full_face_value_edit').val(value['face_value']);
                            $('#full_face_value_edit').show();
                            $('#full_face_value_edit').removeAttr('disabled');

                            $('#discount_face_value_edit').hide();
                            $('#discount_face_value_edit').attr('disabled', true);
                            $('#discount_by_precentage_edit').hide();
                            $('#discount_by_precentage_edit').attr('disabled', true);

                        }else if(value['coupon_type'] == 'discount_by_value_btn'){

                            $('#discount_by_value_btn_edit').prop('checked', true);
                            $('#full_face_value_edit').hide();
                            $('#full_face_value_edit').attr('disabled', true);
                            $('#discount_face_value_edit').val(value['face_value']);
                            $('#discount_face_value_edit').show();
                            $('#discount_face_value_edit').removeAttr('disabled');
                            $('#discount_by_precentage_edit').hide();
                            $('#discount_by_precentage_edit').attr('disabled', true);

                        }else{

                            $('#discount_by_precentage_btn_edit').prop('checked', true);
                            $('#full_face_value_edit').hide();
                            $('#full_face_value_edit').attr('disabled', true);
                            $('#discount_face_value_edit').hide();
                            $('#discount_face_value_edit').attr('disabled', true);
                            $('#discount_by_precentage_edit').show();
                            $('#discount_by_precentage_edit').removeAttr('disabled');
                            $('#discount_by_precentage_edit').val(value['face_value']);

                        }

                        // $('#editface_value').val(value["face_value"]);

                        $('#no_of_coupon_edit').val(value["no_of_coupon"]);

                        $('#lilmit_per_personno_of_coupon_edit').val(value["limit"]);

                        $('#start_date_edit').val(value["start_date"]);

                        $('#end_date_edit').val(value["end_date"]);

                        $('#coupon_description_edit').val(value["coupon_desc"]);

                        let listArr = value['merchendise'];

                        if(value['merchendise_btn'] == 'some_product'){

                            // console.log('some pro');

                            jQuery.each(JSON.parse(listArr), function(key, value){
                                $('#productsCheckboxesEdit').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#some_product_btn_edit').prop('checked', true);
                            $('#collapseTwoEdit').show();
                            $('#collapseThreeEdit').hide();
                            $('#collapseOneEdit').hide();

                        }else if(value['merchendise_btn'] == 'category_product'){

                            // console.log('category');

                            jQuery.each(JSON.parse(listArr), function(key, value){
                                $('#categoryCheckboxesEdit').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#category_product_btn_edit').prop('checked', true);
                            $('#collapseTwoEdit').hide();
                            $('#collapseThreeEdit').show();
                            $('#collapseOneEdit').show();

                        }else{

                            // console.log('all pro');

                            $('#all_product_btn_edit').prop('checked', true);
                            $('#collapseTwoEdit').hide();
                            $('#collapseThreeEdit').hide();
                            $('#collapseOneEdit').show();

                        }

                        // $('#editparticipate_merchendise').val(value["participate_merchendise"]);

                        // $('#editstatus').val(value["status"]);
                    });
                }
            });
        }
    });

     // get a single Coupon
     $(document).on("click", "a[name = 'viewcoupon']", function(e) {
        let id = $(this).data("id");
        getCoupon(id);
        function getCoupon(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCoupon')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    console.log(response);
                    jQuery.each(response, function(key, value) {
                        $('#coupon_number_view').val(value["coupon"]);

                        // $('#editcoupon_type').val(value["coupon_type"]);

                        if(value['coupon_type'] == 'full_discount_btn'){

                            $('#full_discount_btn_view').prop('checked', true);
                            $('#full_face_value_view').val(value['face_value']);
                            $('#full_face_value_view').show();
                            // $('#full_face_value_view').removeAttr('disabled');

                            $('#discount_face_value_view').hide();
                            $('#discount_face_value_view').attr('disabled', true);
                            $('#discount_by_precentage_view').hide();
                            $('#discount_by_precentage_view').attr('disabled', true);

                        }else if(value['coupon_type'] == 'discount_by_value_btn'){

                            $('#discount_by_value_btn_view').prop('checked', true);
                            $('#full_face_value_view').hide();
                            $('#full_face_value_view').attr('disabled', true);
                            $('#discount_face_value_view').val(value['face_value']);
                            $('#discount_face_value_view').show();
                            // $('#discount_face_value_view').removeAttr('disabled');
                            $('#discount_by_precentage_view').hide();
                            $('#discount_by_precentage_view').attr('disabled', true);

                        }else{

                            $('#discount_by_precentage_btn_view').prop('checked', true);
                            $('#full_face_value_view').hide();
                            $('#full_face_value_view').attr('disabled', true);
                            $('#discount_face_value_view').hide();
                            $('#discount_face_value_view').attr('disabled', true);
                            $('#discount_by_precentage_view').show();
                            // $('#discount_by_precentage_view').removeAttr('disabled');
                            $('#discount_by_precentage_view').val(value['face_value']);

                        }

                        // $('#editface_value').val(value["face_value"]);

                        $('#no_of_coupon_view').val(value["no_of_coupon"]);

                        $('#lilmit_per_person_view').val(value["limit"]);

                        $('#start_date_view').val(value["start_date"]);

                        $('#end_date_view').val(value["end_date"]);

                        $('#coupon_description_view').val(value["coupon_desc"]);

                        let listArr = value['merchendise'];

                        if(value['merchendise_btn'] == 'some_product'){
                            jQuery.each(JSON.parse(listArr), function(key, value){
                                $('#productsCheckboxes_view').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#some_product_btn_view').prop('checked', true);
                            $('#collapseTwo_view').show();
                            $('#collapseThree_view').hide();
                            $('#collapseOne_view').hide();

                        }else if(value['merchendise_btn'] == 'category_product'){

                            jQuery.each(JSON.parse(listArr), function(key, value){
                                $('#categoryCheckboxes_view').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#category_product_btn_view').prop('checked', true);
                            $('#collapseTwo_view').hide();
                            $('#collapseThree_view').show();
                            $('#collapseOne_view').show();

                        }else{

                            $('#all_product_btn_view').prop('checked', true);
                            $('#collapseTwo_view').hide();
                            $('#collapseThree_view').hide();
                            $('#collapseOne_view').show();

                        }
                    });
                }
            });
        }
    });
    
    $(document).on("click", "a[name = 'removeConfirmCouponDetails']", function(e) {
        let id = $(this).data("id");
        delRequest(id);

        function delRequest(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RemoveCoupon')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    coupon_details_main_table.ajax.reload();
                    $("#removeModalCoupon .close").click();
                }
            });
        }
    });


    $(document).on("click", "a[name = 'removeCoupon']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveCoupon').data('id', id);
    });
</script>

<div class="modal fade" id="removeModalCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a name="removeConfirmCouponDetails" class="btn btn-primary" id="confirmRemoveCoupon">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>