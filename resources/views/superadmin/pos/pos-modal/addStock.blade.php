<div class="modal fade" id="addStock" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <!--  -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="BlogLongTitle">ADD STOCK</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <!--  -->

                    <form action="" method="POST" enctype="multipart/form-data" id="outletAddStock">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <input type="hidden" name="id" value="{{ $id }}" id="addStockOwnerId" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="posStockPName">Product Name<span style="color:red;">*</span></label>
                                        <select name="product_name" id="posStockPName" onchange="getVariantName()" class="form-control">
                                        <!--  -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="posStockVariant">Product Variant<span style="color:red;">*</span></label>
                                        <select name="product_variant" id="posStockVariant" onchange="getAllProductDetailsStock()" class="form-control">
                                            <option value="">Select Variant</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pos_stock_unit_price">Unit Price</label>
                                        <input type="text" name="unit_price" class="form-control" id="pos_stock_unit_price" placeholder="Unit Price" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="posStockQuantity">Quantity<span style="color:red;">*</span></label>
                                        <input type="text" name="quantity" class="form-control" id="posStockQuantity" placeholder="Quantity" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--  -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="addOutletStockFrm">Clear</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                        </div>
                    <!--  -->
                </form>
                <!--  -->
                </div>
            </div>
        </div>

   
        <!-- jQuery CDN -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    $(document).on('click', '#addOutletStockFrm', function(){
        $('#outletAddStock')[0].reset();
    })

        jQuery.ajax({
            url: "{{ route('SA-FetchAllProductsList') }}",
            type: "get",
            success : function(response){
                $('#posStockPName').html('');
                $('#posStockPName').append('<option value="">Select Product</option>');
                $.each(response, function(key, value){
                    $('#posStockPName').append(
                        `<option value="${value["product_name"]}">${value["product_name"]}</option>`
                    );
                });
            }
        });

        function getVariantName(){
            let proName = $('#posStockPName').val();
            jQuery.ajax({
                url: "{{ route('SA-FetchAllVariantList') }}",
                type: "get",
                data : {
                    "proName" : proName,
                },
                success : function(response){
                    $('#posStockVariant').html('');
                    $('#posStockVariant').append('<option value="">Select Variant</option>');
                    $.each(response, function(key, value){
                        $('#posStockVariant').append(
                            `<option value="${value["product_varient"]}">${value["product_varient"]}</option>`
                        );
                    });
                }
            });
        }

        function getAllProductDetailsStock() {

            let proName = $('#posStockPName').val();
            let proVariant = $('#posStockVariant').val();

            jQuery.ajax({
                url: "{{ route('SA-FetchAllProductsDetailsStock') }}",
                type: "get",
                data:{
                    "proName" : proName,
                    "proVariant" : proVariant,
                },
                success : function(response){
                    $.each(response, function(key, value){
                        $('#pos_stock_unit_price').val(value['min_sale_price']);
                    });
                }
            });
        }

    $(document).ready(function(){
        jQuery('#outletAddStock').submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                product_name : {
                    required : true,
                },
                product_variant : {
                    required : true,
                },
                unit_price : {
                    required : true,
                },
                quantity : {
                    required : true,
                    number : true,
                },
            },
            message:{},
            submitHandler: function(){
                
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        const formData = new FormData($('#outletAddStock')["0"]);
                        jQuery.ajax({
                            url: "{{ route('SA-OutletStoreStock') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {

                                if(result.success != null){
                                    successMsg(result.success);
                                    // getAllOutletStockDetails($('#addStockOwnerId').val());
                                    outlet_stock_table.ajax.reload();
                                    $('#addStock .close').click();
                                    // jQuery("#outletAddStock")["0"].reset();

                                    $('#posStockPName').val('');
                                    $('#posStockVariant').val('');
                                    $('#pos_stock_unit_price').val('');
                                    $('#posStockQuantity').val('');
                                }else{
                                    errorMsg(result.error);
                                }

                            }
                        });
                    }
                });
            }
        })
    });
</script>