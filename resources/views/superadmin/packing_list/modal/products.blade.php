<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="assignDriverForm">
    <div class="modal-body bg-white">
        <div class="form-group row">
            <div class="col-md-6">
                <input type="hidden" name="payment_status" value="Paid">
                <input type="hidden" name="consolidate_order_id" value="{{ $order_no }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="delivery_boy">Delivery Man Name</label>
                <select name="delivery_man_id" id="" class="form-control" required>
                    <option value="">--Select--</option>
                    @foreach($delivery_man as $key=>$value)
                    @if($status != 0)
                    <option value="{{ $value->driver_id }}" @if($delivery->delivery_man_id == $value->driver_id) selected @endif>{{ $value->driver_name }}</option>
                    @else
                    <option value="{{ $value->driver_id }}">{{ $value->driver_name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="pickupAddress">Warehouse Address</label>
                <input type="text" id="pickupAddress" name="pickupAddress" @if($status !=0) value="{{ $delivery->pickup_address }}" @endif class="form-control" placeholder="Pickup Address" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="status">Payment Status</label>
                <select class="form-control" name="payment_status" id="payment_status">
                    <option value="">Select Payment Status</option>
                    @if($status != 0)
                    <option value="Paid" @if($delivery->payment_status == "Paid") selected @endif >Paid</option>
                    <option value="Unpaid" @if($delivery->payment_status != "Paid") selected @endif>Unpaid</option>
                    @else
                    <option @if($payment_type != "COD") selected @endif value="Paid">Paid</option>
                    <option @if($payment_type == "COD") selected @endif value="Unpaid">Unpaid</option>
                    @endif
                </select>
            </div>
            <div class="col-md-6">
                <label for="description">Remark</label>
                <textarea id="description" name="description" placeholder="Description" class="form-control"> @if($status != 0) {{ $delivery->description }} @else {{ $remark }} @endif</textarea>
            </div>
            <div class="col-md-6">
                <label for="delivery_status">Delivery Status</label>
                <input class="form-control" type="text" id="delivery_status" name="delivery_status" value="Packing" readonly>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Clear</button>
        <button type="submit" id="addUserForm1" class="btn btn-primary">Save</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th>S/N</th>
            <th>Product Name</th>
            <th>Variant</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ordered_products as $key=>$value)
        <tr>
            <td>{{++$key}}</td>
            <td>{{$value->product_name}}</td>
            <td>{{$value->product_varient}}</td>
            <td>{{$value->total_quantity}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        jQuery("#assignDriverForm").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules: {
                delivery_man_id: {
                    required: true,
                },
            },
            messages: {},
            submitHandler: function() {
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        jQuery.ajax({
                            url: "{{ route('SA-AddOnlineSaleDelivery') }}",
                            data: jQuery("#assignDriverForm").serialize(),
                            type: "post",
                            success: function(data) {
                                if (data.success != null) {
                                    toastr.success(data.success);
                                    example.ajax.reload();
                                    $('#viewConsolidateOrder1 .close').click();
                                }
                                if (data.error != null) {
                                    toastr.error(data.error);
                                }
                            },
                        });
                    }
                });
            }
        });
    });
</script>