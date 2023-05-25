<style>
    .dt-head-center {text-align: center !important;}
    thead, th {text-align: center !important;}
    .dataTables_filter {
        display: none;
        }
</style>


      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="CancelOrderForm">
        <div class="modal-body bg-white px-3">

        @csrf

        <!--  -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="consolidate_order_id">Consolidate Order No.</label>
                    <select name="consolidate_order_id" id="consolidate_order_id" class="form-control" readonly>
                        <option value="">Select</option>
                        @foreach($orders as $key=>$value)
                            <option value="{{$value->consolidate_order_no}}">
                                {{$value->consolidate_order_no}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customer_name_cons1">Customer Name</label>
                    <input type="text" id="customer_name_cons1" class="form-control" placeholder="Customer Name"  readonly />
                </div>
                <div class="col-md-6">
                    <label for="customer_email_cons1">Email ID</label>
                    <input type="email" id="customer_email_cons1" class="form-control" placeholder="Email ID" readonly />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customer_mob_no_cons1">Mobile No.</label>
                    <input type="text" id="customer_mob_no_cons1"  class="form-control" placeholder="Mobile No." readonly />
                </div>
                <div class="col-md-6">
                    <label for="customer_zipcode_cons1">Postal Code</label>
                    <input type="text" id="customer_zipcode_cons1"  class="form-control" placeholder="Postal Code" readonly />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="customer_delivery_date1">Delivery Date</label>
                    <input type="text" id="customer_delivery_date1" class="form-control" placeholder="Delivery date" readonly  />
                </div>
                <div class="col-md-6">
                    <label for="amt1">Total Amount</label>
                    <input type="number" id="amt1" class="form-control" placeholder="Total Amount" readonly />
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="address1">Address</label>
                    <textarea id="address1" placeholder="Address"  class="form-control" readonly ></textarea>
                </div>
                <div class="col-md-6">
                    <label for="order_Status">Status</label>
                    <select name="status" id="order_Status" required class="form-control">
                        <option value="">Select Status</option>
                        <option value="Canceled">Canceled</option>
                        <option value="Ongoing">Ongoing</option>
                    </select>
                </div>
            </div>

        <!--  -->
            <table class="text-center table table-bordered" id="consolidateOrderTable12" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Product Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody id="consolidateOrderTable123">

                </tbody>
            </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
          <button type="submit" id="addUserForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
    $('#consolidate_order_id').on('change', function(){
        var order_id = $(this).val();

        @foreach($userOrder as $key=>$value)
            if(order_id == "{{$value->consolidate_order_no}}"){
                $('#customer_name_cons1').val("{{$value->name}}");
                $('#customer_email_cons1').val("{{$value->email}}");
                $('#customer_mob_no_cons1').val("{{$value->mobile_no}}");
                $('#customer_zipcode_cons1').val("{{$value->postcode}}");
                $('#customer_delivery_date1').val("{{$value->order_delivery_date}}");
                $('#amt1').val("{{$value->final_price}}");
                $('#address1').val("{{$value->address}}");
                $('#order_Status').val('{{$value->order_status}}');
            }
        @endforeach

        $('#consolidateOrderTable123').html('');

        @foreach($ordersItem as $key=>$value)
            if(order_id == "{{$value->consolidate_order_no}}"){
                $('#consolidateOrderTable123').append(`
                        <tr>
                            <th>{{$value->order_no}}</th>
                            <th>{{$value->product_name}}</th>
                            <th>{{$value->quantity}}</th>
                            <th>{{$value->product_price}}</th>
                            <th>{{$value->total_price}}</th>
                        </tr>
                `);
            }
        @endforeach

    });


        $(document).ready(function() {
            jQuery("#CancelOrderForm").submit(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                });
            }).validate({
                rules: {
                    status: {
                        required: true,
                    },
                },
                messages: {},
                submitHandler:function(){
                    bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                        if(result){
                            jQuery.ajax({
                                url: "{{ route('SA-CancelOrder') }}",
                                data: jQuery("#CancelOrderForm").serialize(),
                                type: "post",
                                success: function(data) {
                                    if(data.success != null){
                                        toastr.success(data.success);
                                        $('#viewCancelOrder .close').click();
                                    }
                                    if(data.error != null){
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