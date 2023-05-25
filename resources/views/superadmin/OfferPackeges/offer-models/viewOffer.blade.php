<div class="modal fade" id="viewOffer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content  p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Offer Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" id="viewOfferForm1" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body bg-white">

                    <!-- info & alert section -->
                    <!-- <div class="alert alert-success" id="" style="display:none"></div>
                    <div class="alert alert-danger" style="display:none">
                        <ul></ul>
                    </div> -->
                    <!-- end -->

                    <!-- <div class="card">
                        <div class="card-body"> -->

                            <!-- Offer Name  -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="offer_number_view" class="">Offer<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="offer_number_view" name="" placeholder="Offer Number" disabled />
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <!-- <i class="btn-sm btn-primary" id="coupon_generate_btn">
                                        Generate
                                    </i> -->
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="coupon_type">Offer Type<span style="color:red;">*</span></label>

                                    <div class="form-control d-flex justify-content-between">
                                        <!-- <div class="border-bottom">
                                            <label for="full_discount_btn_offer_view">Full Discount Offer</label>
                                            <input type="radio" name="offer_type" id="full_discount_btn_offer_view" value="full_discount_btn" onchange="discountRadioBtnFnOfferView()" onclick="return false" checked />
                                        </div> -->

                                        <div class="border-bottom">
                                            <label for="discount_by_value_btn">Discount by Face Value</label>
                                            <input type="radio" name="offer_type" id="discount_by_value_btn_offer_view" value="discount_by_value_btn" onchange="discountRadioBtnFnOfferView()" onclick="return false" />
                                        </div>

                                        <div class="border-bottom">
                                            <label for="discount_by_precentage_btn">Discount by Percentage</label>
                                            <input type="radio" name="offer_type" id="discount_by_precentage_btn_offer_view" value="discount_by_precentage_btn" onchange="discountRadioBtnFnOfferView()" onclick="return false" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="face_value">Face Value<span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" id="full_face_value_offer_view" name="face_value" placeholder="Enter Full Discount Face Value (USD)" style="display:none;" disabled />
                                    <input type="number" class="form-control" id="discount_face_value_offer_view" name="face_value" placeholder="Enter Discount by Face Value (USD)" style="display:none;" disabled />
                                    <input type="number" class="form-control" id="discount_by_precentage_offer_view" name="face_value" placeholder="Enter Discount by Face Percentage (%)" style="display:none;" disabled />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="no_of_coupon_offer_view" class="">No. of Offer<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="no_of_coupon_offer_view" name="no_of_coupon" placeholder="No. of Offer" disabled />
                                </div>
                                <div class="col-md-6">
                                    <label for="lilmit_per_person_offer_view" class="">Limit Per Person<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="lilmit_per_person_offer_view" name="limit_per_person" placeholder="Limit Per Person" disabled />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="start_date" class="">Start Date<span style="color:red;">*</span></label>
                                    <input type="date" class="form-control" id="start_date_offer_view" name="start_date" disabled />
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="">End Date<span style="color:red;">*</span></label>
                                    <input type="date" class="form-control" id="end_date_offer_view" name="end_date" disabled />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="coupon_description_offer_view" class="">Offer
                                        Description</label>
                                    <textarea name="coupon_desc" id="coupon_description_offer_view" cols="30" class="form-control" placeholder="Enter Offer Description..." rows="2" disabled></textarea>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 accordion" id="accordionExample">
                                    <label for="coupon_description" class="">Participate in Event Merchandise
                                        <span style="color:red;">*</span></label>
                                    <div class="d-flex justify-content-between pt-4">
                                        <div class="border-bottom">
                                            <label for="all_product_btn_offer_view">All goods</label>
                                            <input type="radio" id="all_product_btn_offer_view" name="products_btn" value="all_product" onchange="discountRadioBtnFn1OfferView()" onclick="return false" checked />
                                        </div>

                                        <div class="border-bottom">
                                            <label for="some_product_btn_offer_view">Some Product</label>
                                            <input type="radio" id="some_product_btn_offer_view" name="products_btn" value="some_product" onchange="discountRadioBtnFn1OfferView()" onclick="return false" />
                                        </div>

                                        <div class="border-bottom">
                                            <label for="category_product_btn_offer_view">Category Product</label>
                                            <input type="radio" id="category_product_btn_offer_view" name="products_btn" value="category_product" onchange="discountRadioBtnFn1OfferView()" onclick="return false" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div id="collapseOne_offer_view">
                                        <!-- <div class="card card-body">
                                                    All Products
                                                </div> -->
                                    </div>

                                    <div id="collapseTwo_offer_view">
                                        <div class="card card-body">
                                            <label for="form-label">Select Products</label>
                                            <hr>
                                            <div id="productsCheckboxes_offer_view" style="height:250px; overflow-y:scroll;"></div>
                                        </div>
                                    </div>


                                    <div id="collapseThree_offer_view">
                                        <div class="card card-body">
                                            <label for="form-label">Select Category</label>
                                            <hr>
                                            <div id="categoryCheckboxes_offer_view" style="height:250px; overflow-y:scroll;"></div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        <!-- </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    <!-- <button type="submit" id="addCouponForm" class="btn btn-primary">Save</button> -->
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
    getProductsCouponOfferView();

    let productListArrCouponOfferview = [];

    function getProductsCouponOfferView() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetProductsDetailsList') }}",
            success: function(response) {

                productListArrCouponOfferview = response;

                jQuery.each(response, function(key, value) {
                    $('#productsCheckboxes_offer_view').append(
                        `
                        <div class="form-group">
                            <input class="" type="checkbox" id="${value['id']}" value="${value['id']}" onchange=""  onclick="return false" />
                            <label for="${value['product_name']}">${value['product_name']}</label>
                        </div>
                        `
                    );
                });
            }
        });
    }

    getCategoryCouponOfferView();

    function getCategoryCouponOfferView() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetCategoryDetailsList') }}",
            success: function(response) {

                // productListArrCouponOfferview = response;

                // console.log(response);

                jQuery.each(response, function(key, value) {
                    $('#categoryCheckboxes_offer_view').append(
                        `
                        <div class="form-group">
                            <input class="" type="checkbox" id="${value['id']}" value="${value['id']}" onchange=""  onclick="return false" />
                            <label for="${value['name']}">${value['name']}</label>
                        </div>
                        `
                    );
                });
            }
        });
    }

    discountRadioBtnFnOfferView();

    function discountRadioBtnFnOfferView() {
        if ($('#full_discount_btn').prop('checked') == true) {
            $('#full_face_value').show();
            $('#full_face_value').removeAttr('disabled');
            $('#discount_face_value').hide();
            $('#discount_face_value').attr('disabled', true);
            $('#discount_by_precentage').hide();
            $('#discount_by_precentage').attr('disabled', true);
        } else if ($('#discount_by_value_btn').prop('checked') == true) {
            $('#full_face_value').hide();
            $('#full_face_value').attr('disabled', true);
            $('#discount_face_value').show();
            $('#discount_face_value').removeAttr('disabled');
            $('#discount_by_precentage').hide();
            $('#discount_by_precentage').attr('disabled', true);
        } else {
            $('#full_face_value').hide();
            $('#full_face_value').attr('disabled', true);
            $('#discount_face_value').hide();
            $('#discount_face_value').attr('disabled', true);
            $('#discount_by_precentage').show();
            $('#discount_by_precentage').removeAttr('disabled');
        }
    }

    discountRadioBtnFn1OfferView();

    function discountRadioBtnFn1OfferView() {
        if ($('#all_product_btn_offer_view').prop('checked') == true) {
            $('#collapseOne_offer_view').show();
            $('#collapseTwo_offer_view').hide();
            $('#collapseThree_offer_view').hide();
        } else if ($('#some_product_btn_offer_view').prop('checked') == true) {
            $('#collapseOne_offer_view').hide();
            $('#collapseTwo_offer_view').show();
            $('#collapseThree_offer_view').hide();
        } else {
            $('#collapseOne_offer_view').hide();
            $('#collapseTwo_offer_view').hide();
            $('#collapseThree_offer_view').show();
        }
    }
</script>