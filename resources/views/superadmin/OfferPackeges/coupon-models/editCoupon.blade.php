<div class="modal fade" id="editCoupon" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Coupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="forms-sample" id="editCouponForm1" enctype="multipart/form-data" method="post">
                @csrf
                <div class="modal-body bg-white">

                        <input type="text" id="editcouponID" name="id" style="display:none;" />

                            <!-- Coupon Name  -->
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="coupon_number_edit" class="">Coupon<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="coupon_number_edit" name="coupon_name"  placeholder="Coupon Number" readonly />
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="coupon_type" >Coupon Type<span style="color:red;">*</span></label>
                                    
                                    <div class="form-control d-flex justify-content-between">
                                        <div class="border-bottom">
                                            <label for="discount_by_value_btn_edit">Discount by Face Value</label>
                                            <input type="radio" name="coupon_type" id="discount_by_value_btn_edit" value="discount_by_value_btn" onchange="discountRadioBtnFnEdit()" />
                                        </div>

                                        <div class="border-bottom">
                                            <label for="discount_by_precentage_btn_edit">Discount by Percentage</label>
                                            <input type="radio" name="coupon_type" id="discount_by_precentage_btn_edit" value="discount_by_precentage_btn" onchange="discountRadioBtnFnEdit()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="face_value">Face Value<span style="color:red;">*</span></label>
                                    <input type="number" class="form-control" id="full_face_value_edit" name="face_value" placeholder="Enter Full Discount Face Value (USD)" style="display:none;" />
                                    <input type="number" class="form-control" id="discount_face_value_edit" name="face_value" placeholder="Enter Discount by Face Value (USD)" style="display:none;" />
                                    <input type="number" class="form-control" id="discount_by_precentage_edit" name="face_value" placeholder="Enter Discount by Face Percentage (%)" style="display:none;" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="no_of_coupon_edit" class="">No. of Coupon<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="no_of_coupon_edit" name="no_of_coupon"  placeholder="No. of Coupon" />
                                </div>
                                <div class="col-md-6">
                                    <label for="lilmit_per_personno_of_coupon_edit" class="">Limit Per Person<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="lilmit_per_personno_of_coupon_edit" name="limit_per_person"  placeholder="Limit Per Person" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="start_date_edit" class="">Start Date<span style="color:red;">*</span></label>
                                    <input type="date" class="form-control" id="start_date_edit" name="start_date"/>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date_edit" class="">End Date<span style="color:red;">*</span></label>
                                    <input type="date" class="form-control" id="end_date_edit" name="end_date"/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="coupon_description_edit" class="">Coupon Description</label>
                                    <textarea name="coupon_desc" id="coupon_description_edit" cols="30" class="form-control" placeholder="Enter Coupon Description..." rows="2"></textarea>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 accordion" id="accordionExample">
                                    <label for="coupon_merchendise" class="">Participate in Event Merchandise <span style="color:red;">*</span></label>
                                    <div class="d-flex justify-content-between pt-4">
                                        <div class="border-bottom">
                                            <label for="all_product_btn_edit">All goods</label>
                                            <input type="radio" id="all_product_btn_edit" name="products_btn" value="all_product" onchange="discountRadioBtnFn1Edit()" checked/>
                                        </div>

                                        <div class="border-bottom">
                                            <label for="some_product_btn_edit">Some Product</label>
                                            <input type="radio" id="some_product_btn_edit" name="products_btn" value="some_product" onchange="discountRadioBtnFn1Edit()" />
                                        </div>
                                        
                                        <div class="border-bottom">
                                            <label for="category_product_btn_edit">Category Product</label>
                                            <input type="radio" id="category_product_btn_edit" name="products_btn" value="category_product" onchange="discountRadioBtnFn1Edit()" />
                                        </div>
                                    </div>               
                                </div>
                                
                                <div class="col-md-6">
                                            <div id="collapseOneEdit">
                                            </div>

                                            <div id="collapseTwoEdit">
                                                <div class="card card-body">
                                                    <label for="form-label">Select Products</label>
                                                    <hr>
                                                    <div id="productsCheckboxesEdit" style="height:250px; overflow-y:scroll;"></div>
                                                </div>
                                            </div>

                                            
                                            <div id="collapseThreeEdit">
                                                <div class="card card-body">
                                                    <label for="form-label">Select Category</label>
                                                    <hr>
                                                    <div id="categoryCheckboxesEdit" style="height:250px; overflow-y:scroll;"></div>                                                    
                                                </div>
                                            </div>

                                </div>
                            </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="clearEditCouponForm">Clear</button>
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

    $('#clearEditCouponForm').on('click', function(){
        jQuery("#editCouponForm1")["0"].reset();
    })

    $('#coupon_generate_btn_edit').on('click', function() {
        var coupon = "BCCN" + Math.floor((Math.random() * 10000) + 5);
        $('#coupon_number_edit').val(coupon);
    });

    getProductsCouponEdit();

    let productListArrCouponEdit = [];

    function getProductsCouponEdit() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetProductsDetailsList')}}",
            success: function(response) {

                productListArrCouponEdit = response;

                jQuery.each(response, function(key, value) {
                    $('#productsCheckboxesEdit').append(
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

        getCategoryCouponEdit();

    function getCategoryCouponEdit() {
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetCategoryDetailsList')}}",
            success: function(response) {

                // productListArrCouponEdit = response;

                console.log(response);

                jQuery.each(response, function(key, value) {
                    $('#categoryCheckboxesEdit').append(
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

    discountRadioBtnFnEdit();

    function discountRadioBtnFnEdit(){
        if($('#full_discount_btn_edit').prop('checked') == true){
            $('#full_face_value_edit').show();
            $('#full_face_value_edit').removeAttr('disabled');
            $('#discount_face_value_edit').hide();
            $('#discount_face_value_edit').attr('disabled', true);
            $('#discount_by_precentage_edit').hide();
            $('#discount_by_precentage_edit').attr('disabled', true);
        }else if($('#discount_by_value_btn_edit').prop('checked') == true){
            $('#full_face_value_edit').hide();
            $('#full_face_value_edit').attr('disabled', true);
            $('#discount_face_value_edit').show();
            $('#discount_face_value_edit').removeAttr('disabled');
            $('#discount_by_precentage_edit').hide();
            $('#discount_by_precentage_edit').attr('disabled', true);
        }else{
            $('#full_face_value_edit').hide();
            $('#full_face_value_edit').attr('disabled', true);
            $('#discount_face_value_edit').hide();
            $('#discount_face_value_edit').attr('disabled', true);
            $('#discount_by_precentage_edit').show();
            $('#discount_by_precentage_edit').removeAttr('disabled');
        }
    }

    discountRadioBtnFn1Edit();

    function discountRadioBtnFn1Edit(){
        if($('#all_product_btn_edit').prop('checked') == true){
            $('#collapseOneEdit').show();
            $('#collapseTwoEdit').hide();
            $('#collapseThreeEdit').hide();
        }else if($('#some_product_btn_edit').prop('checked') == true){
            $('#collapseOneEdit').hide();
            $('#collapseTwoEdit').show();
            $('#collapseThreeEdit').hide();
        }else{
            $('#collapseOneEdit').hide();
            $('#collapseTwoEdit').hide();
            $('#collapseThreeEdit').show();
        }
    }


    jQuery(document).ready(function() {
        jQuery("#editCouponForm1").submit(function(e) {

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

            products_btn: {
                required: true,
            },
        },
      messages: {},
      submitHandler : function(){

                let allCouponItemArrEdit = [];

                if($('#some_product_btn_edit').prop('checked') == true){
                    // function getProductCheckedValues() {
                        allCouponItemArrEdit = Array.from($('#productsCheckboxesEdit').find('input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                }else if($('#category_product_btn_edit').prop('checked') == true){
                    // function getCategoryCheckedValues() {
                        allCouponItemArrEdit = Array.from($('#categoryCheckboxesEdit').find('input[type="checkbox"]'))
                        .filter((checkbox) => checkbox.checked)
                        .map((checkbox) => checkbox.value);
                    // }
                }else{
                    allCouponItemArrEdit = [];
                }
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        $.ajax({
                            url: "{{ route('SA-EditCoupon') }}",
                            data: jQuery("#editCouponForm1").serialize() + "&allCouponItemArr=" + JSON.stringify(allCouponItemArrEdit),
                            type: "post",
                            success: function(result) {

                                if (result.error != null) {
                                    errorMsg(result.error);
                                } else if (result.barerror != null) {
                                    jQuery("#editCouponAlert").hide();
                                    errorMsg(result.barerror);
                                } else if (result.success != null) {
                                    jQuery(".alert-danger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    coupon_details_main_table.ajax.reload();
                                } else {
                                    jQuery(".alert-danger").hide();
                                    jQuery("#editCouponAlert").hide();
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