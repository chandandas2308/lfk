<style>
    .dt-head-center {
        text-align: center !important;
    }

    thead,
    th {
        text-align: center !important;
    }

    /* .dataTables_filter {
        display: none;
        } */
</style>


<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Consolidate Delivery Order</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="post" id="addConsolidateOrderForm">
    <div class="modal-body bg-white px-3">

        <!--  -->
        <div class="form-group row">
            <div class="col-md-6">
                <label for="customer_order_id">Consolidate Order No.</label>
                <input type="text" id="customer_order_id" value="{{ $data->consolidate_order_no }}"
                    class="form-control" placeholder="Order ID" disabled>
                <input type="hidden" name="consolidate_order_id" value="{{ $data->consolidate_order_no }}">
            </div>
            <div class="col-md-6">
                <label for="customer_order_date">Order Date</label>
                <input type="text" id="customer_order_date" class="form-control" value="{{ $data->created_at }}"
                    disabled>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="customer_name_cons">Customer Name</label>
                <input type="text" id="customer_name_cons" value="{{ $data->name }}" class="form-control"
                    placeholder="Customer Name" disabled />
            </div>
            <div class="col-md-6">
                <label for="customer_email_cons">Email ID</label>
                <input type="email" id="customer_email_cons" value="{{ $data->email }}" class="form-control"
                    placeholder="Email ID" disabled />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="customer_mob_no_cons">Mobile No.</label>
                <input type="text" id="customer_mob_no_cons" value="{{ $data->mobile_no }}" class="form-control"
                    placeholder="Mobile No." disabled />
            </div>
            <div class="col-md-6">
                <label for="customer_zipcode_cons">Postal Code</label>
                <input type="text" id="customer_zipcode_cons" value="{{ $data->postcode }}" class="form-control"
                    placeholder="Postal Code" disabled />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="customer_delivery_date">Delivery Date</label>
                <input type="text" id="customer_delivery_date" value="{{ $delivery_date->delivery_date }}"
                    class="form-control" placeholder="Delivery date" disabled />
            </div>
            <div class="col-md-6">
                <label for="amt">Total Amount</label>
                <input type="number" id="amt" class="form-control" value="{{ $total_amount }}"
                    placeholder="Total Amount" disabled />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="address">Address</label>
                <textarea id="address" placeholder="Address" class="form-control" disabled>{{ $data->address }}</textarea>
            </div>
            <div class="col-md-6">
                <label for="address">Shipping Charge</label>
                <input type="text" name="" id="" value="{{ $shipping_charge }}"
                    class="form-control">
            </div>
            <!-- <div class="col-md-6">
                    <label for="status">Payment Status</label>
                    <select class="form-control" name="payment_status" id="payment_status">
                        <option value="">Select Payment Status</option>
                        @if ($status != 0)
<option value="Paid" @if ($delivery->payment_status == 'Paid') selected @endif >Paid</option>
                            <option value="Unpaid" @if ($delivery->payment_status != 'Paid') selected @endif>Unpaid</option>
@else
<option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
@endif
                    </select>
                </div> -->
        </div>
        <!-- <div class="form-group row">
                <div class="col-md-6">
                    <label for="delivery_boy">Delivery Boy Name</label>
                    <select name="delivery_man_id" id="" class="form-control">
                        <option value="">--Select--</option>
                        @foreach ($delivery_boy as $key => $value)
@if ($status != 0)
<option value="{{ $value->driver_id }}" @if ($delivery->delivery_man_user_id == $value->driver_id) selected @endif>{{ $value->driver_name }}</option>
@else
<option value="{{ $value->driver_id }}">{{ $value->driver_name }}</option>
@endif
@endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="pickupAddress">Pickup Address</label>
                    <input type="text" id="pickupAddress" name="pickupAddress" @if ($status != 0) value="{{ $delivery->pickup_address }}" @endif class="form-control" placeholder="Pickup Address" />
                </div>
            </div> -->
        <!-- <div class="form-group row">
                <div class="col-md-6">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Description" class="form-control"> @if ($status != 0)
{{ $delivery->description }}
@endif
</textarea>
                </div>
                <div class="col-md-6">
                          <label for="delivery_status">Delivery Status</label>
                          <input class="form-control" type="text" id="delivery_status" name="delivery_status" value="Packing" readonly>
                </div>
            </div> -->

        <!--  -->

        @if ($delivery_date->status == 'Delivered')
            @php
                $signature = DB::table('deliveries')
                    ->where('order_no', $data->consolidate_order_no)
                    ->first();
                $remark = DB::table('remarks')
                    ->where('order_no', $data->consolidate_order_no)
                    ->latest()
                    ->first();
            @endphp

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customer_order_id">Customer Signature</label>
                    <img src="{{ $signature->signature }}" alt="" srcset="" height="300">
                </div>
                <div class="col-md-6">
                    <label for="customer_order_id">Delivery Date and Time</label>
                    <input type="text" name="" readonly class="form-control"
                        value="{{ date('d-m-Y h:i', strtotime($signature->delivered_date_time)) }}">
                </div>

                <div class="col-md-6">
                    <label for="customer_order_id">Remark</label>
                    <input type="text" name="" readonly class="form-control"
                        value="{{ $remark->remark }}">
                </div>
                @if (!empty($remark->image))
                    <div class="col-md-6">
                        <label for="customer_order_id">Remark Image</label>
                        <img src="{{ $remark->image }}" alt="" srcset="" height="300">
                    </div>
                @endif

                @if (!empty($signature->delivered_payment_method))
                    <div class="col-md-6">
                        <label for="customer_order_id">Payment Type</label>
                        <input type="text" name="" readonly class="form-control"
                        value="{{ $signature->delivered_payment_method }}">
                    </div>
                    @endif
                    @if (!empty($signature->delivered_online_payment_image))
                    <div class="col-md-6">
                        <label for="customer_order_id">Payment Image</label>
                        <img src="{{ $signature->delivered_online_payment_image }}" alt="" srcset="" height="300">
                    </div>
                    @endif

            </div>

        @endif

        @if ($delivery_date->status == 'Cancelled')
            @php
                $signature = DB::table('deliveries')
                    ->where('order_no', $data->consolidate_order_no)
                    ->first();
                $remark = DB::table('cancel_remarks')
                    ->where('consolidate_order_no', $data->consolidate_order_no)
                    ->latest()
                    ->first();
            @endphp

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customer_order_id">Cancel Remark</label>
                    <input type="text" name="" readonly class="form-control"
                        value="{{ $remark->remark }}">
                </div>
                @if (!empty($remark->cancel_image))
                    <div class="col-md-6">
                        <label for="customer_order_id">Remark Image</label>
                        <img src="{{ $remark->cancel_image }}" alt="" srcset="" height="300">
                    </div>
                @endif
            </div>

        @endif



        <div class="table-responsive">
            <table class="text-center table table-responsive table-bordered"
                id="consolidate_Order_list_with_postal_code">
                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        {{-- <th>Product Price</th> --}}
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tfoot>
                    {{-- <tr>
                    <td colspan="4" style="text-align: end;">Total</td>
                    <td id="total_amount"></td>
                </tr> --}}
                </tfoot>
            </table>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <!-- <button type="submit" id="addUserForm1" class="btn btn-primary">Save</button> -->
    </div>
</form>
</div>
</div>
</div>

<script>
    $(document).ready(function() {
        consolidate_Order_list_with_postal_code = $('#consolidate_Order_list_with_postal_code').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength: 10,
            buttons: [
                $.extend(true, {}, {
                    text: 'Export to Excel',
                    extend: 'excelHtml5',
                    className: 'btn btn-primary',
                    // exportOptions: {
                    //     columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    // }
                })
            ],
            ajax: {
                url: "{{ route('consolidate_Order_list_with_postal_code') }}",
                type: 'GET',
                data: {
                    consolidate_order_no: "{{ $data->consolidate_order_no }}"
                },
            },
            // 'columnDefs': [{
            //     'targets': 0,
            //     'checkboxes': {
            //         'selectRow': true
            //     }
            // }],
            // 'select': {
            //     'style': 'multi'
            // },
            // rowCallback: function(row, data, index) {
            //     if (data[12] == true) {
            //         $('td:eq(0)', row).find('.select-checkbox').remove();
            //         $('td:eq(0)', row).find("input[type='checkbox']").remove();

            //     }
            // },



        });
        $(document).find('#postal_consolidate_order_table').wrap(
            '<div style="overflow-x:auto; width:100%;"></div>')

    })


    $(document).ready(function() {
        jQuery("#addConsolidateOrderForm").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules: {
                payment_status: {
                    required: true,
                },
                delivery_man_id: {
                    required: true,
                },
                pickupAddress: {
                    required: true,
                },
                description: {
                    // required: true,
                }
            },
            messages: {},
            submitHandler: function() {
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        jQuery.ajax({
                            url: "{{ route('SA-AddOnlineSaleDelivery') }}",
                            data: jQuery("#addConsolidateOrderForm").serialize(),
                            type: "post",
                            success: function(data) {
                                if (data.success != null) {
                                    toastr.success(data.success);
                                    $('#viewConsolidateOrder .close').click();
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
