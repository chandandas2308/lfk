<!-- Offers Tab -->
<div class="p-3">
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Offers
        </h4>
        <div class="d-flex">
            <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addOffer"> Add Offer </a>
        </div>
    </div>

    <!-- alert section -->
    <div class="alert alert-success alert-dismissible fade show" id="delOfferAlert" style="display:none" role="alert">
        <strong></strong> <span id="delOfferAlertMSG"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- alert section end-->

    <!-- table start -->
    <div class="table-responsive">
    <table class="text-center table table-responsive table-bordered" id="offer_details_main_table">
            <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th class="text-center">Offer Name</th>
                    <th class="text-center">Threshold</th>
                    <th class="text-center">Face Value</th>
                    <!-- <th class="text-center">Remaining Quantity / Issued</th> -->
                    <th class="text-center">Start Date</th>
                    <th class="text-center">End Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    
    <!-- table end here -->
</div>

<!-- Add offer Model -->
@include('superadmin.OfferPackeges.offer-models.addOffer')
<!-- end model here -->

<!-- Edit offer Model -->
@include('superadmin.OfferPackeges.offer-models.editOffer')
<!-- end model here -->

<!-- View offer Model -->
@include('superadmin.OfferPackeges.offer-models.viewOffer')
<!-- end model here -->

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>

    $(document).ready(function() {
        offer_details_main_table = $('#offer_details_main_table').DataTable({
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
                url: "{{ route('SA-GetOffers') }}",
                type: 'GET',
            }
        });
    });

    // get a single Offer
    $(document).on("click", "a[name = 'editoffer']", function(e) {
        let id = $(this).data("id");
        getOffer(id);
        function getOffer(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetOffer')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#editOfferID').val(value["id"]);
                        $('#offer_number_edit').val(value["offer"]);

                        // $('#editcoupon_type').val(value["offer_type"]);

                        if(value['offer_type'] == "full_discount_btn"){

                            $('#full_discount_btn_offer_edit').prop('checked', true);
                            $('#full_face_value_offer_edit').val(value['face_value']);
                            $('#full_face_value_offer_edit').show();
                            $('#full_face_value_offer_edit').removeAttr('disabled');

                            $('#discount_face_value_offer_edit').hide();
                            $('#discount_face_value_offer_edit').attr('disabled', true);
                            $('#discount_by_precentage_offer_edit').hide();
                            $('#discount_by_precentage_offer_edit').attr('disabled', true);

                        }else if(value['offer_type'] == "discount_by_value_btn"){

                            $('#discount_by_value_btn_offer_edit').prop('checked', true);
                            $('#full_face_value_offer_edit').hide();
                            $('#full_face_value_offer_edit').attr('disabled', true);
                            $('#discount_face_value_offer_edit').val(value['face_value']);
                            $('#discount_face_value_offer_edit').show();
                            $('#discount_face_value_offer_edit').removeAttr('disabled');
                            $('#discount_by_precentage_offer_edit').hide();
                            $('#discount_by_precentage_offer_edit').attr('disabled', true);

                        }else{

                            $('#discount_by_precentage_btn_offer_edit').prop('checked', true);
                            $('#full_face_value_offer_edit').hide();
                            $('#full_face_value_offer_edit').attr('disabled', true);
                            $('#discount_face_value_offer_edit').hide();
                            $('#discount_face_value_offer_edit').attr('disabled', true);
                            $('#discount_by_precentage_offer_edit').show();
                            $('#discount_by_precentage_offer_edit').removeAttr('disabled');
                            $('#discount_by_precentage_offer_edit').val(value['face_value']);

                        }

                        // $('#editface_value').val(value["face_value"]);

                        $('#no_of_offer_edit').val(value["no_of_offers"]);

                        $('#lilmit_per_personno_of_offer_edit').val(value["limit"]);

                        $('#start_date_offer_edit').val(value["start_date"]);

                        $('#end_date_offer_edit').val(value["end_date"]);

                        $('#offer_description_offer_edit').val(value["offer_desc"]);

                        let listArr = value['merchendise'];

                        if(value['merchendise_btn'] == 'some_product'){

                            // console.log('some pro');

                            jQuery.each(JSON.parse(listArr), function(key, value){
                                // $('#productsCheckboxesEdit').find('input[type="checkbox"]').prop('checked', true);
                                $('#productsCheckboxesOfferEdit').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#some_product_btn_offer_edit').prop('checked', true);
                            $('#collapseTwoOfferEdit').show();
                            $('#collapseThreeOfferEdit').hide();
                            $('#collapseOneOfferEdit').hide();

                        }else if(value['merchendise_btn'] == 'category_product'){

                            // console.log('category');

                            jQuery.each(JSON.parse(listArr), function(key, value){
                                $('#categoryCheckboxesOfferEdit').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#category_product_btn_offer_edit').prop('checked', true);
                            $('#collapseTwoOfferEdit').hide();
                            $('#collapseThreeOfferEdit').show();
                            $('#collapseOneOfferEdit').show();

                        }else{

                            // console.log('all pro');

                            $('#all_product_btn_offer_edit').prop('checked', true);
                            $('#collapseTwoOfferEdit').hide();
                            $('#collapseThreeOfferEdit').hide();
                            $('#collapseOneOfferEdit').show();

                        }
                    });
                }
            });
        }
    });

        // get a single Offer
        $(document).on("click", "a[name = 'viewOffer']", function(e) {
        let id = $(this).data("id");
        getOffer(id);
        function getOffer(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetOffer')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#offer_number_view').val(value["offer"]);

                        // $('#editcoupon_type').val(value["coupon_type"]);

                        if(value['offer_type'] == "full_discount_btn"){

                            $('#full_discount_btn_offer_view').prop('checked', true);
                            $('#full_face_value_offer_view').val(value['face_value']);
                            $('#full_face_value_offer_view').show();
                            // $('#full_face_value_offer_view').removeAttr('disabled');

                            $('#discount_face_value_offer_view').hide();
                            $('#discount_face_value_offer_view').attr('disabled', true);
                            $('#discount_by_precentage_offer_view').hide();
                            $('#discount_by_precentage_offer_view').attr('disabled', true);

                        }else if(value['offer_type'] == "discount_by_value_btn"){

                            $('#discount_by_value_btn_offer_view').prop('checked', true);
                            $('#full_face_value_offer_view').hide();
                            $('#full_face_value_offer_view').attr('disabled', true);
                            $('#discount_face_value_offer_view').val(value['face_value']);
                            $('#discount_face_value_offer_view').show();
                            // $('#discount_face_value_offer_view').removeAttr('disabled');
                            $('#discount_by_precentage_offer_view').hide();
                            $('#discount_by_precentage_offer_view').attr('disabled', true);

                        }else{

                            $('#discount_by_precentage_btn_offer_view').prop('checked', true);
                            $('#full_face_value_offer_view').hide();
                            $('#full_face_value_offer_view').attr('disabled', true);
                            $('#discount_face_value_offer_view').hide();
                            $('#discount_face_value_offer_view').attr('disabled', true);
                            $('#discount_by_precentage_offer_view').show();
                            // $('#discount_by_precentage_offer_view').removeAttr('disabled');
                            $('#discount_by_precentage_offer_view').val(value['face_value']);

                        }

                        // $('#editface_value').val(value["face_value"]);

                        $('#no_of_coupon_offer_view').val(value["no_of_offers"]);

                        $('#lilmit_per_person_offer_view').val(value["limit"]);

                        $('#start_date_offer_view').val(value["start_date"]);

                        $('#end_date_offer_view').val(value["end_date"]);

                        $('#coupon_description_offer_view').val(value["offer_desc"]);

                        let listArr = value['merchendise'];

                        if(value['merchendise_btn'] == 'some_product'){
                            jQuery.each(JSON.parse(listArr), function(key, value){
                                // $('#productsCheckboxes_view').find('input[type="checkbox"]').prop('checked', true);
                                $('#productsCheckboxes_offer_view').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#some_product_btn_offer_view').prop('checked', true);
                            $('#collapseTwo_offer_view').show();
                            $('#collapseThree_offer_view').hide();
                            $('#collapseOne_offer_view').hide();

                        }else if(value['merchendise_btn'] == 'category_product'){

                            jQuery.each(JSON.parse(listArr), function(key, value){
                                // $('#categoryCheckboxes_view').find('input[type="checkbox"]').prop('checked', true);
                                $('#categoryCheckboxes_offer_view').find('input[id='+value+']').prop('checked', true);
                            });

                            $('#category_product_btn_offer_view').prop('checked', true);
                            $('#collapseTwo_offer_view').hide();
                            $('#collapseThree_offer_view').show();
                            $('#collapseOne_offer_view').show();

                        }else{

                            $('#all_product_btn_offer_view').prop('checked', true);
                            $('#collapseTwo_offer_view').hide();
                            $('#collapseThree_offer_view').hide();
                            $('#collapseOne_offer_view').show();

                        }

                    });
                }
            });
        }
    });

    $(document).on("click", "a[name = 'removeConfirmOfferDetails']", function(e) {
        let id = $(this).data("id");
        delRequest(id);

        function delRequest(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RemoveOffer')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    offer_details_main_table.ajax.reload();
                    $("#removeModalOffer .close").click();
                }
            });
        }
    });


    $(document).on("click", "a[name = 'removeOffer']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveOffer').data('id', id);
    });
</script>

<div class="modal fade" id="removeModalOffer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a name="removeConfirmOfferDetails" class="btn btn-primary" id="confirmRemoveOffer">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>












