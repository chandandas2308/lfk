<div class="modal fade" id="addCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" id="addCouponForm1" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body bg-white">

                    <!-- info & alert section -->
                    <div class="alert alert-success" id="addCouponAlert" style="display:none"></div>
                    <div class="alert alert-danger" style="display:none">
                        <ul></ul>
                    </div>
                    <!-- end -->

                    <!-- Coupon Name  -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="coupon_number" class="">Coupon<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="coupon_number" name="coupon_name" placeholder="Coupon Number" readonly />
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <i class="btn-sm btn-primary" id="coupon_generate_btn">
                                Generate
                            </i>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="coupon_type">Coupon Type<span style="color:red;">*</span></label>

                            <div class="form-control d-flex justify-content-between">

                                <div class="border-bottom">
                                    <label for="discount_by_value_btn">Discount by Face Value</label>
                                    <input type="radio" name="coupon_type" id="discount_by_value_btn" value="discount_by_value_btn" onchange="discountRadioBtnFn()" />
                                </div>

                                <div class="border-bottom">
                                    <label for="discount_by_precentage_btn">Discount by Percentage</label>
                                    <input type="radio" name="coupon_type" id="discount_by_precentage_btn" value="discount_by_precentage_btn" onchange="discountRadioBtnFn()" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="face_value">Face Value<span style="color:red;">*</span></label>
                            <input type="number" class="form-control" id="full_face_value" name="face_value" placeholder="Enter Full Discount Face Value (USD)" style="display:none;" />
                            <input type="number" class="form-control" id="discount_face_value" name="face_value" placeholder="Enter Discount by Face Value (USD)" style="display:none;" />
                            <input type="number" class="form-control" id="discount_by_precentage" name="face_value" placeholder="Enter Discount by Face Percentage (%)" style="display:none;" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="no_of_coupon" class="">No. of Coupon<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="no_of_coupon" name="no_of_coupon" placeholder="No. of Coupon" />
                        </div>
                        <div class="col-md-6">
                            <label for="lilmit_per_person" class="">Limit Per Person<span style="color:red;">*</span></label>
                            <input type="text" class="form-control" id="lilmit_per_person" name="limit_per_person" placeholder="Limit Per Person" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="start_date" class="">Start Date<span style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" />
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="">End Date<span style="color:red;">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="coupon_description" class="">Coupon Description</label>
                            <textarea name="coupon_desc" id="coupon_description" cols="30" class="form-control" placeholder="Enter Coupon Description..." rows="2"></textarea>
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 accordion" id="accordionExample">
                            <label for="coupon_description" class="">Participate in Event Merchandise <span style="color:red;">*</span></label>
                            <div class="d-flex justify-content-between pt-4">
                                <div class="border-bottom">
                                    <label for="all_product_btn">All goods</label>
                                    <input type="radio" id="all_product_btn" name="products_btn" value="all_product" onchange="discountRadioBtnFn1()" checked />
                                </div>

                                <div class="border-bottom">
                                    <label for="some_product_btn">Some Product</label>
                                    <input type="radio" id="some_product_btn" name="products_btn" value="some_product" onchange="discountRadioBtnFn1()" />
                                </div>

                                <div class="border-bottom">
                                    <label for="category_product_btn">Category Product</label>
                                    <input type="radio" id="category_product_btn" name="products_btn" value="category_product" onchange="discountRadioBtnFn1()" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div id="collapseOne">
                            </div>

                            <div id="collapseTwo">
                                <div class="card card-body">
                                    <label for="form-label">Select Products</label>
                                    <hr>
                                    <div id="productsCheckboxes" style="height:250px; overflow-y:scroll;"></div>
                                </div>
                            </div>


                            <div id="collapseThree">
                                <div class="card card-body">
                                    <label for="form-label">Select Category</label>
                                    <hr>
                                    <div id="categoryCheckboxes" style="height:250px; overflow-y:scroll;"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="clearCouponForm">Clear</button>
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
    $('#clearCouponForm').on('click', function() {
        jQuery("#addCouponForm1")["0"].reset();
    })

    $('#coupon_generate_btn').on('click', function() {
        var coupon = "BCCN" + Math.floor((Math.random() * 10000) + 5);
        $('#coupon_number').val(coupon);
    });

    getProductsCoupon();

    let productListArrCoupon = [];

    function getProductsCoupon() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetProductsDetailsList')}}",
            success: function(response) {

                productListArrCoupon = response;

                jQuery.each(response, function(key, value) {
                    $('#productsCheckboxes').append(
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

    getCategoryCoupon();

    function getCategoryCoupon() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetCategoryDetailsList')}}",
            success: function(response) {

                // productListArrCoupon = response;

                console.log(response);

                jQuery.each(response, function(key, value) {
                    $('#categoryCheckboxes').append(
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

    discountRadioBtnFn();

    function discountRadioBtnFn() {
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

    discountRadioBtnFn1();

    function discountRadioBtnFn1() {
        if ($('#all_product_btn').prop('checked') == true) {
            $('#collapseOne').show();
            $('#collapseTwo').hide();
            $('#collapseThree').hide();
        } else if ($('#some_product_btn').prop('checked') == true) {
            $('#collapseOne').hide();
            $('#collapseTwo').show();
            $('#collapseThree').hide();
        } else {
            $('#collapseOne').hide();
            $('#collapseTwo').hide();
            $('#collapseThree').show();
        }
    }


    jQuery(document).ready(function() {
        jQuery("#addCouponForm1").submit(function(e) {

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

                coupon_type: {
                    required: true,
                },

                face_value: {
                    required: true,
                },

                no_of_coupon: {
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

                // coupon_desc: {
                //     required: true,
                // },

                products_btn: {
                    required: true,
                },
            },
            messages: {},
            submitHandler: function() {

                let allCouponItemArr = [];

                if ($('#some_product_btn').prop('checked') == true) {
                    // function getProductCheckedValues() {
                    allCouponItemArr = Array.from($('#productsCheckboxes').find('input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                } else if ($('#category_product_btn').prop('checked') == true) {
                    // function getCategoryCheckedValues() {
                    allCouponItemArr = Array.from($('#categoryCheckboxes').find('input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                } else {
                    allCouponItemArr = [];
                }

                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        jQuery.ajax({
                            url: "{{ route('SA-AddCoupon') }}",
                            data: jQuery("#addCouponForm1").serialize() + "&allCouponItemArr=" + JSON.stringify(allCouponItemArr),
                            enctype: "multipart/form-data",
                            type: "post",

                            success: function(result) {

                                if (result.error != null) {
                                    errorMsg(result.error);
                                } else if (result.barerror != null) {
                                    jQuery("#addCouponAlert").hide();
                                    errorMsg(result.barerror);
                                } else if (result.success != null) {
                                    jQuery(".alert-danger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#addCouponForm1")["0"].reset();
                                    coupon_details_main_table.ajax.reload();
                                } else {
                                    jQuery(".alert-danger").hide();
                                    jQuery("#addCouponAlert").hide();
                                }
                            },
                        });
                    }
                });
            }
        });
    });
</script>