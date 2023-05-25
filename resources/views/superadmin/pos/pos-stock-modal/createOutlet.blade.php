<div class="modal fade" id="addOutletStock" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Add POS Stock</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method="POST" enctype="multipart/form-data" id="storeOutlet">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="">Outlet</label>
                                    <select name="owner_id" id="outletStockID">
                                        <!--  -->
                                    </select>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="posStockPName">Product Name<span style="color:red;">*</span></label>
                                        <input type="text" name="product_name" class="form-control" id="posStockPName" placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="posStockVariant">Product Variant<span style="color:red;">*</span></label>
                                        <input type="text" name="product_variant" class="form-control" id="posStockVariant" placeholder="Product Variant">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pos_stock_unit_price">Unit Price<span style="color:red;">*</span></label>
                                        <input type="text" name="unit_price" class="form-control" id="pos_stock_unit_price" placeholder="Unit Price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="posStockQuantity">Quantity<span style="color:red;">*</span></label>
                                        <input type="text" name="quantity" class="form-control" id="posStockQuantity" placeholder="Quantity">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="clearOutletForm" >Clear</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    
        <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>


    $(document).on('click', '#clearOutletForm', function(){
        $('#storeOutlet')[0].reset();
    });

    $(document).ready(function(){
        jQuery('#storeOutlet').submit(function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                name : {
                    required : true,
                },
                email : {
                    required : true,
                },
                mobile_number : {
                    required : true,
                },
                postcode : {
                    required : true,
                },
                address : {
                    required : true,
                },
                unitCode : {
                    required : true,
                },
            },
            message:{},
            submitHandler: function(){
                
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        const formData = new FormData($('#storeOutlet')["0"]);
                        jQuery.ajax({
                            url: "{{ route('SA-PosStoreOutlet') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                
                                if(result.success != null){
                                    jQuery("#storeOutlet")["0"].reset();
                                    successMsg(result.success);
                                    fetchAllOutletDetails();
                                    $('#addOutlet .close').click();
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

    // 
    // function getAllOutlet(){
    //     jQuery.ajax({
    //         url: "{{ route('SA-FetchAllOutLet') }}",
    //         type: "post",
    //         success : function(Response){
    //             $('#outletStockID').html('');
    //             $('#outletStockID').append('<option value="">Select Outlet</option>');
    //             $.each(response.data, function(key, value){
    //                 $('#outletStockID').append(
    //                     `<option value="${id}"></option>`
    //                 );
    //             });
    //         }
    //     });
    // }

    // 
    $(document).on('change', '#outletPostCode', function(){
        let postcode = $(this).val();

        jQuery.ajax({
            url: "https://developers.onemap.sg/commonapi/search",
            type: "post",
            contentType: "application/json", 
            data: {
                "searchVal" : postcode,
                "returnGeom" : 'N',
                "getAddrDetails" : 'Y',
            },
            success : function(response){
                console.log(response);
            }
        });
    });

</script>