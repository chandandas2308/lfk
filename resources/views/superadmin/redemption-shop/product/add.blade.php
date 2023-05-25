                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Add Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="addProductForm">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-5 form-group">
                                    <label for="product_id">Product <span class="text-danger">*</span></label>
                                    <select name="product_id" onchange="getProductDetails()" id="addRedemptionProduct" class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach($product as $key=>$value)
                                            <option value="{{$value->id}}">{{$value->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group" style="margin: auto;background: lightgray;font-size: larger;font-weight: bolder;text-align: center;padding: 5px;">
                                    OR
                                </div>
                                <div class="col-md-5 form-group">
                                    <label for="product_name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" id="product_name_redem" name="product_name" placeholder="Product Name" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="product_category">Category <span class="text-danger">*</span></label>
                                    <select name="product_category" id="product_category_redem" class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach($category as $key=>$value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="variant">Variant <span class="text-danger">*</span></label>
                                    <input type="text" id="product_variant_redem" name="variant" placeholder="Variant" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="vendor_id">Vendor</label>
                                    <select name="vendor_id" id="product_vendor_redem" class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach($vendor as $key=>$value)
                                            <option value="{{$value->id}}">{{$value->vendor_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="sku_code">SKU Code</label>
                                    <input type="text" id="product_sku_code_redem" name="sku_code" placeholder="SKU Code" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="uom">UOM <span class="text-danger">*</span></label>
                                    <input type="text" id="product_uom_redem" name="uom" placeholder="UOM" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="minimum_points">Points <span class="text-danger">*</span></label>
                                    <input type="text" id="product_minimum_points_redem" name="minimum_points" placeholder="Points" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="stockQty">Stock Quantity <span class="text-danger">*</span></label>
                                    <input type="text" id="product_uom_redem" name="stock_qty" placeholder="Stock Quantity" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-12">
                                <!-- image section -->
                                    <div class="form-group row">
                                        <label for="image" class="col-sm-2 col-form-label">Multiple Image <span class="text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <button class="btn btn-success" id="addImageBtn" type="button"><i class="fldemo glyphicon glyphicon-plus"></i>Add Image</button>
                                            <div class="input-group hdtuto control-group lst increment" >
                                                <!-- images -->
                                            </div>
                                        </div>
                                    </div>
                                    <div id="displayImages"></div>
                                </div>  
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" id="reset" class="btn btn-primary">Clear</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<script>

    $('#reset').on('click', function(){
        $('#displayImages').html('');
    });

    function getProductDetails(){
        $('#displayImages').html('');
        let product_id = $('#addRedemptionProduct').val();

        @foreach($product as $key => $value)
            if(product_id == "{{$value['id']}}"){
                $('#product_name_redem').val("{{$value['product_name']}}");
                $('#product_category_redem').val("{{$value['category_id']}}");
                $('#product_variant_redem').val("{{$value['product_varient']}}");
                $('#product_vendor_redem').val("{{$value['supplier_id']}}");
                $('#product_sku_code_redem').val("{{$value['sku_code']}}");
                $('#product_uom_redem').val("{{$value['uom']}}");
                @foreach(json_decode($value['images']) as $k => $v)
                    $('#displayImages').append(`
                        <img src="{{$v}}" height="100" width="100" />
                    `);
                @endforeach
            }
        @endforeach

    }

    $(document).ready(function(){
        $('#addProductForm').submit(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
                
                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        const formData = new FormData($('#addProductForm')["0"]);
                        console.log(formData);
                        jQuery.ajax({
                            url: "{{ route('redemption_product_shop.store') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                if(result.status == 'success'){
                                    successMsg(result.message);
                                    product_main_table.ajax.reload();
                                    $('#addProduct .close').click();
                                }else{
                                    toastr.error(result.message);
                                }
                            },
                            error: function(error){
                                $.each(error.responseJSON.errors, function(key,value){ toastr.error(value) })
                            }
                        });
                    }
                });
        });
    });
</script>