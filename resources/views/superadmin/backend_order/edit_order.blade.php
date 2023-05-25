@extends('superadmin.layouts.master')
@section('title','Update Order | LFK')
@section('body')

<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #444;
        line-height: 100%;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper pb-0">

        <div class="p-3 bg-white">
            <div class="page-header flex-wrap">
                <h4 class="mb-0">
                    Update Order
                </h4>
            </div>

            <form action="{{route('SA-backend.updateOrder12')}}" method="post">
                @csrf
                <input type="hidden" name="consolidate_order_no" id="consolidate_order_no" value="{{$notification->consolidate_order_no}}">
                <!--  -->
                <div class="" style="overflow: hidden;">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customerName" class="required-field">Customer Name<span style="color:red;">*</span></label>
                                <input type="text" name="customerName" required readonly value="{{ $customer->customer_name!=null?$customer->customer_name:old('customer') }}" id="customerName" class="form-control" placeholder="Customer Name">
                                <input type="hidden" name="customer_id" value="{{$customer->id}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="recipientName" class="required-field">Recipient Name<span style="color:red;">*</span></label>
                                <input type="text" name="recipientName" required value="{{$user_order_details->name}}" id="recipientName" class="form-control" placeholder="Recipient Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobileNo" class="required-field">Mobile Number<span style="color:red;">*</span></label>
                                <input type="text" name="mobileNo" required id="mobileNo" value="{{$user_order_details->mobile_no}}" class="form-control" maxlength="8" minlength="8" placeholder="Mobile Number" onkeypress="return /[0-9]/i.test(event.key)">
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcode">Postal Code<span style="color:red;">*</span></label>
                                <input type="text" name="postcode" required class="form-control" value="{{$user_order_details->postcode}}" id="customer_postcode" value="{{ old('postcode')!=null?old('postcode'):$addresses[0]->postcode }}" maxlength="6" minlength="6" placeholder="Postal Code">
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address">Address<span style="color:red;">*</span></label>
                                <select name="address" id="address2" onchange="updateAddress()" required class="form-control select_2_input">
                                    <option value="">Select Address</option>
                                    @foreach($addresses as $key=>$value)
                                        <option value="{{$value->id}}" @if(old('address') == $value->id) selected @elseif($value->id == $address->id) selected @endif >{{$value->address}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="unit">Unit<span style="color:red;">*</span></label>
                                <input type="text" name="unit" value="{{ old('unit')!=null?old('unit'):$address->unit }}" required class="form-control" id="unit" rows="4" placeholder="Unit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="delivery_date">Delivery Date<span style="color:red;">*</span></label>
                                <input type="text" name="delivery_date" value="{{ old('delivery_date')!=null?old('delivery_date'):$notification->delivery_date }}" required class="form-control datepicker" id="delivery_date" placeholder="DD/MM/YYYY">
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_mode">Payment Mode<span style="color:red;">*</span></label>
                                <input type="text" name="payment_mode" required value="{{ $notification->payment_mode }}" readonly class="form-control" id="payment_mode" placeholder="Payment Mode">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>
                                        Product
                                    </th>
                                    <th>
                                        Quantity
                                    </th>
                                    <th>
                                        Unit Price
                                    </th>
                                    <th>
                                        Sub Total
                                    </th>
                                    <th>
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="ordertable">
                                @foreach($user_ordered_item as $key=>$value)
                                <tr>
                                    <td style="min-width:230px">
                                    <input type="hidden" name="list_id[]" value="{{$value->id}}">
                                    <input type="hidden" name="list_order_no[]" value="{{$value->order_no}}">
                                        <select class="productId select_2_input form-control select20" required onchange="check('select20')" name="product_id[]">
                                            <option value="">Select Product</option>
                                            @foreach($products as $key1=>$value1)
                                                <option value="{{$value1->product_id}}" @if($value->product_id == $value1->product_id) selected @endif>{{$value1->product_name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    
                                    <td style="min-width:230px">
                                        <input type="number" name="quantity[]" value="{{$value->quantity}}" required id="quantity" placeholder="Quantity">
                                    </td>
                                    <td style="min-width:230px">
                                    <input type="text" name="unit_price[]" value="{{$value->product_price}}" required id="unit_price" class="calculate" placeholder="Unit Price">
                                    </td>
                                    <td style="min-width:230px">
                                        <input type="text" id="sub_total" value="{{$value->total_price}}" readonly required name="sub_total[]" placeholder="Subtotal">
                                    </td>
                                    <td>
                                        <button type="button" id="clear" class="btn btn-danger remove-input-field">Remove</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="">
                                        <button type="button" id="addProductRow" class="btn btn-success"> Add </button>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="m-2 p-2">
                        <a type="button" class="btn btn-primary" href="{{route('SA-CustomerManagement')}}">Close</a>
                        <button type="submit" id="addCustomerForm1" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <!--  -->
            </form>
        </div>

        
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
        

        <script>
            
            $(document).ready(function(){

                $('#address2').select2({
                    tags:true,
                });

                $('.select_2_input').select2({
                    placeholder:"Select"
                });
                
            })

            $('#addProductRow').on('click', function() {
                let number = $('.ordertable tr').length;
                $('.ordertable').append(`
                        <tr>
                                <td style="min-width:230px">
                                    <select class="productId select_2_input form-control select2${number}" required onchange="check('select2${number}')" name="product_id[]">
                                        <option value="">Select Product</option>
                                        @foreach($products as $key=>$value)
                                            <option value="{{$value->product_id}}">{{$value->product_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                
                                <td style="min-width:230px">
                                    <input type="number" name="quantity[]" required id="quantity" placeholder="Quantity">
                                </td>
                                <td style="min-width:230px">
                                <input type="text" name="unit_price[]" value="0" required id="unit_price" class="calculate" placeholder="Unit Price">
                                </td>
                                <td style="min-width:230px">
                                    <input type="text" id="sub_total" readonly required name="sub_total[]" placeholder="Subtotal">
                                </td>
                                <td>
                                    <button type="button" id="clear" class="btn btn-danger remove-input-field">Remove</button>
                                </td>
                        </tr>
                `);
                $('.select_2_input').select2();
            });

            $(document).on('click', '.remove-input-field', function() {
                $(this).parents('tr').remove();
            });

            function check(abc){
                var product_id = $('.'+abc).val();

                @foreach($products as $key => $value)
                    if ("{{$value->product_id}}" == product_id) {
                        $('.'+abc).closest('tr').find('#unit_price').val("{{$value->min_sale_price}}");
                        $('.'+abc).closest('tr').find('#quantity').attr('max', "{{$value->total_quantity}}");
                    }
                @endforeach
            }

            $(document).on('change', '#quantity', function() {
                var quantity = $(this).val();

                var unit_price = $(this).closest('tr').find('#unit_price').val();

                var sub_total = parseInt(quantity) * parseFloat(unit_price);
                
                $(this).closest('tr').find('#sub_total').val(sub_total);
            });

            $(document).on('change', '#customer_postcode', function() {
                let postcode = $(this).val();
                console.log(postcode);

                jQuery.ajax({
                    url: "https://developers.onemap.sg/commonapi/search",
                    type: "get",
                    data: {
                        "searchVal": postcode,
                        "returnGeom": 'N',
                        "getAddrDetails": 'Y',
                    },
                    success: function(response) {
                        console.log(response);
                        $('#address2').html('');
                        $('#address2').append('<option value="">Select Address</option>');
                        $.each(response.results, function(key, value) {
                            $('#address2').append(`
                        <option value="${value["ADDRESS"]}">${value["ADDRESS"]}</option>
                    `);
                        });
                        // console.log(response);
                    }
                });
            });

            function updateAddress() {
                var id = $('#address2').val();

                @foreach($addresses as $key => $value)
                    if (id == "{{$value->id}}") {
                        $('#customer_postcode').val("{{$value->postcode}}");
                        $('#unit').val("{{$value->unit}}");
                    }
                @endforeach

            }

            $(document).ready(function() {
                @if($errors->any())

                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
                    
                @endif

                @if(session('status'))
                    toastr.success("{{ session('status') }}");
                @endif
            });

        </script>

@section('javascript')

<script>
    
    $(".datepicker").datepicker({
      dateFormat : "dd/mm/yy",
      minDate : new Date(),
    });
</script>

@endsection

        @endsection