<!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />     -->
<div class="modal fade" id="editOffer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Offer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" id="editOfferForm1" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body bg-white">

                    <input type="text" id="editOfferID" name="id" style="display:none;" />

                    <!-- Offer Name  -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="offer_number_edit" class="">Offer<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="offer_number_edit" name="offer_number" placeholder="Offer Number" readonly />
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="offer_type">Offer Type<span style="color:red;">*</span></label>

                            <div class="form-control d-flex justify-content-between">

                                <div class="border-bottom">
                                    <label for="discount_by_value_btn_offer_edit">Discount by Face Value</label>
                                    <input type="radio" name="offer_type" id="discount_by_value_btn_offer_edit" value="discount_by_value_btn" onchange="discountRadioBtnFnOfferEdit()" />
                                </div>

                                <div class="border-bottom">
                                    <label for="discount_by_precentage_btn_offer_edit">Discount by Percentage</label>
                                    <input type="radio" name="offer_type" id="discount_by_precentage_btn_offer_edit" value="discount_by_precentage_btn" onchange="discountRadioBtnFnOfferEdit()" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="face_value">Face Value<span style="color:red;">*</span></label>
                            <input type="number" class="form-control" id="full_face_value_offer_edit" name="face_value" placeholder="Enter Full Discount Face Value (USD)" style="display:none;" />
                            <input type="number" class="form-control" id="discount_face_value_offer_edit" name="face_value" placeholder="Enter Discount by Face Value (USD)" style="display:none;" />
                            <input type="number" class="form-control" id="discount_by_precentage_offer_edit" name="face_value" placeholder="Enter Discount by Face Precentage (%)" style="display:none;" />
                        </div>
                    </div>

                    <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="no_of_offer_edit" class="">No. of Offer<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="no_of_offer_edit" name="no_of_offers"  placeholder="No. of Offer" />
                                </div>
                                <div class="col-md-6">
                                    <label for="lilmit_per_personno_of_offer_edit" class="">Limit Per Person<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="lilmit_per_personno_of_offer_edit" name="limit_per_person"  placeholder="Limit Per Person" />
                                </div>
                            </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start_date_offer_edit" class="">Start Date<span style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="start_date_offer_edit" name="start_date" />
                        </div>
                        <div class="col-md-6">
                            <label for="end_date_offer_edit" class="">End Date<span style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="end_date_offer_edit" name="end_date" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="offer_description_offer_edit" class="">Offer Description</label>
                            <textarea name="offer_desc" id="offer_description_offer_edit" cols="30" class="form-control" placeholder="Enter Offer Description..." rows="2"></textarea>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 accordion" id="accordionExample">
                            <label for="coupon_merchendise" class="">Participate in Event Merchandise <span style="color:red;">*</span></label>
                            <div class="d-flex justify-content-between pt-4">
                                <div class="border-bottom">
                                    <label for="all_product_btn_offer_edit">All goods</label>
                                    <input type="radio" id="all_product_btn_offer_edit" name="products_btn_offer_edit" value="all_product" onchange="discountRadioBtnFn1OfferEdit()" checked />
                                </div>

                                <div class="border-bottom">
                                    <label for="some_product_btn_offer_edit">Some Product</label>
                                    <input type="radio" id="some_product_btn_offer_edit" name="products_btn_offer_edit" value="some_product" onchange="discountRadioBtnFn1OfferEdit()" />
                                </div>

                                <div class="border-bottom">
                                    <label for="category_product_btn_offer_edit">Category Product</label>
                                    <input type="radio" id="category_product_btn_offer_edit" name="products_btn_offer_edit" value="category_product" onchange="discountRadioBtnFn1OfferEdit()" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="collapseOneOfferEdit">
                            </div>

                            <div id="collapseTwoOfferEdit">
                                <div class="card card-body">
                                    <label for="form-label">Select Products</label>
                                    <hr>
                                    <div id="productsCheckboxesOfferEdit" style="height:250px; overflow-y:scroll;">
                                    </div>
                                </div>
                            </div>


                            <div id="collapseThreeOfferEdit">
                                <div class="card card-body">
                                    <label for="form-label">Select Category</label>
                                    <hr>
                                    <div id="categoryCheckboxesOfferEdit" style="height:250px; overflow-y:scroll;">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn  btn-primary" id="clearEditOfferForm">Clear</button>
                    <button type="submit" id="addCouponForm" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<!-- backend js file -->


<script>
    $('#clearEditOfferForm').on('click', function() {
        jQuery("#editOfferForm1")["0"].reset();
    })

    $('#coupon_generate_btn_edit').on('click', function() {
        var coupon = "BCCN" + Math.floor((Math.random() * 10000) + 5);
        $('#offer_number_edit').val(coupon);
    });

    getProductsOfferEdit();

    let productListArrOfferEdit = [];

    function getProductsOfferEdit() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetProductsDetailsList') }}",
            success: function(response) {

                productListArrOfferEdit = response;

                jQuery.each(response, function(key, value) {
                    $('#productsCheckboxesOfferEdit').append(
                        `
                        <div class="form-group">
                            <input class="" type="checkbox" id="${value['id']}" value="${value['id']}" onchange="" />
                            <label for="${value['product_name']}">${value['product_name']}</label>
                        </div>
                        `
                    );
                });
            }
        });
    }

    getCategoryOfferEdit();

    function getCategoryOfferEdit() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetCategoryDetailsList') }}",
            success: function(response) {

                jQuery.each(response, function(key, value) {
                    $('#categoryCheckboxesOfferEdit').append(
                        `
                        <div class="form-group">
                            <input class="" type="checkbox" id="${value['id']}" value="${value['id']}" onchange="" />
                            <label for="${value['name']}">${value['name']}</label>
                        </div>
                        `
                    );
                });
            }
        });
    }

    discountRadioBtnFnOfferEdit();

    function discountRadioBtnFnOfferEdit() {
        if ($('#full_discount_btn_offer_edit').prop('checked') == true) {
            $('#full_face_value_offer_edit').show();
            $('#full_face_value_offer_edit').removeAttr('disabled');
            $('#discount_face_value_offer_edit').hide();
            $('#discount_face_value_offer_edit').attr('disabled', true);
            $('#discount_by_precentage_offer_edit').hide();
            $('#discount_by_precentage_offer_edit').attr('disabled', true);
        } else if ($('#discount_by_value_btn_offer_edit').prop('checked') == true) {
            $('#full_face_value_offer_edit').hide();
            $('#full_face_value_offer_edit').attr('disabled', true);
            $('#discount_face_value_offer_edit').show();
            $('#discount_face_value_offer_edit').removeAttr('disabled');
            $('#discount_by_precentage_offer_edit').hide();
            $('#discount_by_precentage_offer_edit').attr('disabled', true);
        } else {
            $('#full_face_value_offer_edit').hide();
            $('#full_face_value_offer_edit').attr('disabled', true);
            $('#discount_face_value_offer_edit').hide();
            $('#discount_face_value_offer_edit').attr('disabled', true);
            $('#discount_by_precentage_offer_edit').show();
            $('#discount_by_precentage_offer_edit').removeAttr('disabled');
        }
    }

    discountRadioBtnFn1OfferEdit();

    function discountRadioBtnFn1OfferEdit() {
        if ($('#all_product_btn_offer_edit').prop('checked') == true) {
            $('#collapseOneOfferEdit').show();
            $('#collapseTwoOfferEdit').hide();
            $('#collapseThreeOfferEdit').hide();
        } else if ($('#some_product_btn_offer_edit').prop('checked') == true) {
            $('#collapseOneOfferEdit').hide();
            $('#collapseTwoOfferEdit').show();
            $('#collapseThreeOfferEdit').hide();
        } else {
            $('#collapseOneOfferEdit').hide();
            $('#collapseTwoOfferEdit').hide();
            $('#collapseThreeOfferEdit').show();
        }
    }


    jQuery(document).ready(function() {
        jQuery("#editOfferForm1").submit(function(e) {

            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });

        }).validate({
            rules: {

                coupon_name: {
                    required: true,
                },

                offer_type: {
                    required: true,
                },

                face_value: {
                    required: true,
                },

                no_of_offers: {
                    required: true,
                },

                limit_per_person: {
                    required: true,
                },

                start_date: {
                    required: true,
                },

                end_date: {
                    required: true,
                },

                products_btn_offer_edit: {
                    required: true,
                },
            },
            messages: {},
            submitHandler: function() {

                let allOfferItemArrEdit = [];

                if ($('#some_product_btn_offer_edit').prop('checked') == true) {
                    // function getProductCheckedValues() {
                    allOfferItemArrEdit = Array.from($('#productsCheckboxesOfferEdit').find(
                            'input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                } else if ($('#category_product_btn_offer_edit').prop('checked') == true) {
                    // function getCategoryCheckedValues() {
                    allOfferItemArrEdit = Array.from($('#categoryCheckboxesOfferEdit').find(
                            'input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                } else {
                    allOfferItemArrEdit = [];
                }

                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        $.ajax({
                            url: "{{ route('SA-EditOffer') }}",
                            data: jQuery("#editOfferForm1").serialize() +
                                "&allOfferItemArr=" + JSON.stringify(
                                    allOfferItemArrEdit),
                            type: "post",
                            success: function(result) {

                                if (result.error != null) {
                                    errorMsg(result.error);
                                } else if (result.barerror != null) {
                                    jQuery("#editOfferAlert1").hide();
                                    errorMsg(result.barerror);
                                } else if (result.success != null) {
                                    jQuery(".alert-danger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    offer_details_main_table.ajax.reload();
                                } else {
                                    jQuery(".alert-danger").hide();
                                    jQuery("#editOfferAlert1").hide();
                                }
                            }
                        });
                    }
                });
            }
        });
    });



    /////////////////////////////
</script>