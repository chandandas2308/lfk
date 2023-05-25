<div class="modal fade" id="updateStock" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <!--  -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="BlogLongTitle">UPDATE STOCK</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <!--  -->
                    <input type="hidden" value="{{ $id }}" id="updateStockOwnerId" />
                    <form action="" method="POST" enctype="multipart/form-data" id="outletUpdateStock">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <input type="hidden" name="id" id="updateStockId" />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="update_posStockPName">Product Name<span style="color:red;">*</span></label>
                                        <!-- <select name="product_name" id="update_posStockPName" onchange="getUpdateVariantName()" class="form-control" readonly>
                                        </select> -->
                                        <input type="text" name="product_name" id="update_posStockPName" class="form-control" readonly placeholder="Product Name" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="update_posStockVariant">Product Variant<span style="color:red;">*</span></label>
                                        <!-- <select name="product_variant" id="update_posStockVariant" onchange="getUpdateAllProductDetailsStock()" class="form-control">
                                            <option value="">Select Variant</option>
                                        </select> -->
                                        <input type="text" name="product_variant" id="update_posStockVariant" placeholder="Product Variant" class="form-control" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="update_pos_stock_unit_price">Unit Price</label>
                                        <input type="text" name="unit_price" class="form-control" id="update_pos_stock_unit_price" placeholder="Unit Price" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="update_posStockQuantity">Quantity<span style="color:red;">*</span></label>
                                        <input type="text" name="quantity" class="form-control" id="update_posStockQuantity" placeholder="Quantity" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!--  -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="updateOutletStockFrm">Clear</button>
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

    $(document).on('click', '#updateOutletStockFrm', function(){
        $('#outletUpdateStock')[0].reset();
    })

        jQuery.ajax({
            url: "{{ route('SA-FetchAllProductsList') }}",
            type: "get",
            success : function(response){
                $('#update_posStockPName').html('');
                $('#update_posStockPName').append('<option value="">Select Product</option>');
                $.each(response, function(key, value){
                    $('#update_posStockPName').append(
                        `<option value="${value["product_name"]}">${value["product_name"]}</option>`
                    );
                });
            }
        });

        // function getUpdateVariantName(){
        //     let proName = $('#update_posStockPName').val();
        //     jQuery.ajax({
        //         url: "{{ route('SA-FetchAllVariantList') }}",
        //         type: "get",
        //         data : {
        //             "proName" : proName,
        //         },
        //         success : function(response){
        //             $('#update_posStockVariant').html('');
        //             $('#update_posStockVariant').append('<option value="">Select Variant</option>');
        //             $.each(response, function(key, value){
        //                 $('#update_posStockVariant').append(
        //                     `<option value="${value["product_varient"]}">${value["product_varient"]}</option>`
        //                 );
        //             });
        //         }
        //     });
        // }

        function getUpdateAllProductDetailsStock() {

            let proName = $('#update_posStockPName').val();
            let proVariant = $('#update_posStockVariant').val();

            jQuery.ajax({
                url: "{{ route('SA-FetchAllProductsDetailsStock') }}",
                type: "get",
                data:{
                    "proName" : proName,
                    "proVariant" : proVariant,
                },
                success : function(response){
                    $.each(response, function(key, value){
                        $('#update_pos_stock_unit_price').val(value['min_sale_price']);
                    });
                }
            });
        }

    $(document).ready(function(){
        jQuery('#outletUpdateStock').submit(function(e){
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
                        const formData = new FormData($('#outletUpdateStock')["0"]);
                        jQuery.ajax({
                            url: "{{ route('SA-OutletUpdateStock') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                if(result.success != null){
                                    successMsg(result.success);
                                    // getAllOutletStockDetails($('#updateStockOwnerId').val());
                                    outlet_stock_table.ajax.reload();
                                    $('#updateStock .close').click();
                                    jQuery("#outletUpdateStock")["0"].reset();
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