<div class="modal fade" id="addOffer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Offers</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" id="addOfferForm1" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body bg-white">

                    <!-- Offer Name  -->
                    {{-- <div class="form-group row">
                        <div class="col-md-6">
                            <label for="offer_number" class="">Offer<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="offer_number" name="offer_number" placeholder="Offer Number" readonly />
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <i class="btn-sm btn-primary" id="offer_generate_btn">
                                Generate
                            </i>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="offer_number" class="">Offer Name<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="offer_name" name="offer_name" placeholder="Offer Name"/>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="offer_type">Offer Type<span style="color:red;">*</span></label>

                            <div class="form-control d-flex justify-content-between">

                                <div class="border-bottom">
                                    <label for="discount_by_value_btn_offer">Discount by Face Value</label>
                                    <input type="radio" name="offer_type" id="discount_by_value_btn_offer" value="discount_by_value_btn" onchange="discountRadioBtnFnOffer()" />
                                </div>

                                <div class="border-bottom">
                                    <label for="discount_by_precentage_btn_offer">Discount by Percentage</label>
                                    <input type="radio" name="offer_type" id="discount_by_precentage_btn_offer" value="discount_by_precentage_btn" onchange="discountRadioBtnFnOffer()" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="face_value">Face Value<span style="color:red;">*</span></label>
                            <input type="number" class="form-control" id="full_face_value_offer" name="face_value" placeholder="Enter Full Discount Face Value (USD)" style="display:none;" />
                            <input type="number" class="form-control" id="discount_face_value_offer" name="face_value" placeholder="Enter Discount by Face Value (USD)" style="display:none;" />
                            <input type="number" class="form-control" id="discount_by_precentage_offer" name="face_value" placeholder="Enter Discount by Face Percentage (%)" style="display:none;" />
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <div class="col-md-6">
                            <label for="no_of_coupon_offer" class="">No. of Offer<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="no_of_coupon_offer" name="no_of_offers" placeholder="No. of Offer" />
                        </div>
                        <div class="col-md-6">
                            <label for="lilmit_per_person_offer" class="">Limit Per Person<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="lilmit_per_person_offer" name="limit_per_person" placeholder="Limit Per Person" />
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start_date_offer" class="">Start Date<span style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="start_date_offer" name="start_date" />
                        </div>
                        <div class="col-md-6">
                            <label for="end_date_offer" class="">End Date<span style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="end_date_offer" name="end_date" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="coupon_description_offer" class="">Offer Description</label>
                            <textarea name="offer_desc" id="coupon_description_offer" cols="30" class="form-control" placeholder="Enter Offer Description..." rows="2"></textarea>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 accordion" id="accordionExample">
                            <label for="all_product_btn" class="">Participate in Event Merchandise<span style="color:red;">*</span></label>
                            <div class="d-flex justify-content-between pt-4">
                                <div class="border-bottom">
                                    <label for="all_product_btn">All goods</label>
                                    <input type="radio" id="all_product_btn_offer" name="products_btn_offer" value="all_product" onchange="discountRadioBtnFn2()" checked />
                                </div>

                                <div class="border-bottom">
                                    <label for="some_product_btn">Some Product</label>
                                    <input type="radio" id="some_product_btn_offer" name="products_btn_offer" value="some_product" onchange="discountRadioBtnFn2()" />
                                </div>

                                <div class="border-bottom">
                                    <label for="category_product_btn">Category Product</label>
                                    <input type="radio" id="category_product_btn_offer" name="products_btn_offer" value="category_product" onchange="discountRadioBtnFn2()" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="collapseOneOffer">
                            </div>

                            <div id="collapseTwoOffer">
                                <div class="card card-body">
                                    <label for="form-label">Select Products</label>
                                    <hr>
                                    <div id="productsCheckboxes_offer" style="height:250px; overflow-y:scroll;"></div>
                                </div>
                            </div>


                            <div id="collapseThreeOffer">
                                <div class="card card-body">
                                    <label for="form-label">Select Category</label>
                                    <hr>
                                    <div id="categoryCheckboxes_offer" style="height:250px; overflow-y:scroll;"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="clearAddOfferForm">Clear</button>
                    <button type="submit" id="addOfferForm" class="btn btn-primary">Save</button>
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
    $('#offer_generate_btn').on('click', function() {
        var coupon = "BCCN" + Math.floor((Math.random() * 10000) + 5);
        $('#offer_number').val(coupon);
    });

    $('#clearAddOfferForm').on('click', function() {
        jQuery("#addOfferForm1")["0"].reset();
    })
    getProductsOffer();

    let productListArrOffer = [];

    function getProductsOffer() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetProductsDetailsList')}}",
            success: function(response) {

                productListArrOffer = response;

                jQuery.each(response, function(key, value) {
                    $('#productsCheckboxes_offer').append(
                        `
                        <div class="form-group">
                            <input class="" type="checkbox" id="${value['product_name']}" value="${value['id']}" onchange="" />
                            <label for="${value['product_name']}">${value['product_name']}</label>
                        </div>
                        `
                    );
                });
            }
        });
    }

    getCategoryOffer();

    function getCategoryOffer() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetCategoryDetailsList')}}",
            success: function(response) {

                // productListArrOffer = response;

                console.log(response);

                jQuery.each(response, function(key, value) {
                    $('#categoryCheckboxes_offer').append(
                        `
                        <div class="form-group">
                            <input class="" type="checkbox" id="${value['name']}" value="${value['id']}" onchange="" />
                            <label for="${value['name']}">${value['name']}</label>
                        </div>
                        `
                    );
                });
            }
        });
    }


    discountRadioBtnFnOffer();

    function discountRadioBtnFnOffer() {
        if ($('#full_discount_btn_offer').prop('checked') == true) {
            $('#full_face_value_offer').show();
            $('#full_face_value_offer').removeAttr('disabled');
            $('#discount_face_value_offer').hide();
            $('#discount_face_value_offer').attr('disabled', true);
            $('#discount_by_precentage_offer').hide();
            $('#discount_by_precentage_offer').attr('disabled', true);
        } else if ($('#discount_by_value_btn_offer').prop('checked') == true) {
            $('#full_face_value_offer').hide();
            $('#full_face_value_offer').attr('disabled', true);
            $('#discount_face_value_offer').show();
            $('#discount_face_value_offer').removeAttr('disabled');
            $('#discount_by_precentage_offer').hide();
            $('#discount_by_precentage_offer').attr('disabled', true);
        } else {
            $('#full_face_value_offer').hide();
            $('#full_face_value_offer').attr('disabled', true);
            $('#discount_face_value_offer').hide();
            $('#discount_face_value_offer').attr('disabled', true);
            $('#discount_by_precentage_offer').show();
            $('#discount_by_precentage_offer').removeAttr('disabled');
        }
    }

    discountRadioBtnFn2();

    function discountRadioBtnFn2() {
        if ($('#all_product_btn_offer').prop('checked') == true) {
            $('#collapseOneOffer').show();
            $('#collapseTwoOffer').hide();
            $('#collapseThreeOffer').hide();
        } else if ($('#some_product_btn_offer').prop('checked') == true) {
            $('#collapseOneOffer').hide();
            $('#collapseTwoOffer').show();
            $('#collapseThreeOffer').hide();
        } else {
            $('#collapseOneOffer').hide();
            $('#collapseTwoOffer').hide();
            $('#collapseThreeOffer').show();
        }
    }


    jQuery(document).ready(function() {
        jQuery("#addOfferForm1").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });

        }).validate({
            rules: {

                offer_number: {
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

                products_btn: {
                    required: true,
                },
            },
            messages: {},
            submitHandler: function() {

                let allOfferItemArr = [];

                if ($('#some_product_btn_offer').prop('checked') == true) {
                    // function getProductCheckedValues() {
                    allOfferItemArr = Array.from($('#productsCheckboxes_offer').find('input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                } else if ($('#category_product_btn_offer').prop('checked') == true) {
                    // function getCategoryCheckedValues() {
                    allOfferItemArr = Array.from($('#categoryCheckboxes_offer').find('input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                } else {
                    allOfferItemArr = [];
                }

                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        jQuery.ajax({
                            url: "{{ route('SA-AddOffer') }}",
                            data: jQuery("#addOfferForm1").serialize() + "&allOfferItemArr=" + JSON.stringify(allOfferItemArr),
                            enctype: "multipart/form-data",
                            type: "post",

                            success: function(result) {
                                if (result.error != null) {
                                    errorMsg(result.error);
                                } else if (result.barerror != null) {
                                    jQuery("#addOfferAlert").hide();
                                    errorMsg(result.barerror);
                                } else if (result.success != null) {
                                    jQuery(".alert-danger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#addOfferForm1")["0"].reset();
                                    offer_details_main_table.ajax.reload();
                                } else {
                                    jQuery(".alert-danger").hide();
                                    jQuery("#addOfferAlert").hide();
                                }
                            },
                        });
                    }
                });

            }
        });
    });
</script>