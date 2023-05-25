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
                                <div class="col-md-6 form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" id="" disabled name="product_name" value="{{$data->product_name}}" placeholder="Product Name" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="product_category">Product Category</label>
                                    <select name="product_category" id="" disabled class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach($category as $key=>$value)
                                            <option value="{{$value->id}}" @if($data->product_category == $value->id) selected @endif >{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="variant">Variant</label>
                                    <input type="text" id="" disabled name="variant" value="{{$data->product_variant}}" placeholder="Variant" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="vendor_id">Vendor</label>
                                    <select name="vendor_id" id="" disabled class="form-control">
                                        <option value="">--Select--</option>
                                        @foreach($vendor as $key=>$value)
                                            <option value="{{$value->id}}" @if($data->vendor_id == $value->id) selected @endif >{{$value->vendor_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="sku_code">SKU Code</label>
                                    <input type="text" id="" disabled value="{{$data->sku_code}}" name="sku_code" placeholder="SKU Code" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="uom">UOM</label>
                                    <input type="text" id="" disabled name="uom" value="{{$data->uom}}" placeholder="UOM" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="minimum_points">Points</label>
                                    <input type="text" id="" disabled name="minimum_points" placeholder="Points" value="{{$data->points}}" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="stockQty">Stock Quantity</label>
                                    <input type="text" id="product_uom_redem" disabled value="{{$data->quantity}}" name="stock_qty" placeholder="Stock Quantity" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-12">
                                        <label for="">Images</label>
                                        @foreach(json_decode($data->images) as $key=>$value)
                                            <img src="{{$value}}" alt="{{$value}}" height="100" width="100">
                                        @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>