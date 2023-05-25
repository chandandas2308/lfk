@extends('superadmin.layouts.master')
@section('title', 'Add Order | LFK')
@section('body')

    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 100%;
        }
    </style>

    <style>
        :root {
            --card-line-height: 1.2em;
            --card-padding: 1em;
            --card-radius: 0.5em;
            --color-green: #EC1C24;
            --color-gray: #e2ebf6;
            --color-dark-gray: #c4d1e1;
            --radio-border-width: 2px;
            --radio-size: 1.5em;
        }

        .plan-details {
            border: var(--radio-border-width) solid var(--color-gray);
            border-radius: var(--card-radius);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            padding: var(--card-padding);
            transition: border-color 0.2s ease-out;
        }

        .card:hover .plan-details {
            border-color: var(--color-dark-gray);
        }

        .radio:checked~.plan-details {
            border-color: var(--color-green);
        }

        .radio:focus~.plan-details {
            box-shadow: 0 0 0 2px var(--color-dark-gray);
        }

        .radio:disabled~.plan-details {
            color: var(--color-dark-gray);
            cursor: default;
        }

        .radio:disabled~.plan-details .plan-type {
            color: var(--color-dark-gray);
        }

        .card:hover .radio:disabled~.plan-details {
            border-color: var(--color-gray);
            box-shadow: none;
        }

        .radio {
            font-size: inherit;
            margin: 0;
            position: absolute;
            right: calc(1em + var(--radio-border-width));
            top: calc(1em + var(--radio-border-width));
        }

        @supports (-webkit-appearance: none) or (-moz-appearance: none) {
            .radio {
                -webkit-appearance: none;
                -moz-appearance: none;
                background: #fff;
                border: var(--radio-border-width) solid var(--color-gray);
                border-radius: 50%;
                cursor: pointer;
                height: var(--radio-size);
                outline: none;
                transition: background 0.2s ease-out, border-color 0.2s ease-out;
                width: var(--radio-size);
            }

            .radio::after {
                border: var(--radio-border-width) solid #fff;
                border-top: 0;
                border-left: 0;
                content: "";
                display: block;
                height: 0.75rem;
                left: 25%;
                position: absolute;
                top: 50%;
                transform: rotate(45deg) translate(-50%, -50%);
                width: 0.375rem;
            }

            .radio:checked {
                background: var(--color-green);
                border-color: var(--color-green);
            }

            .card:hover .radio {
                border-color: var(--color-dark-gray);
            }

            .card:hover .radio:checked {
                border-color: var(--color-green);
            }
        }

        .plan-details {
            border: var(--radio-border-width) solid var(--color-gray);
            border-radius: var(--card-radius);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            padding: var(--card-padding);
            transition: border-color 0.2s ease-out;
        }

        .card:hover .plan-details {
            border-color: var(--color-dark-gray);
        }

        .radio:checked~.plan-details {
            border-color: var(--color-green);
        }

        .radio:focus~.plan-details {
            box-shadow: 0 0 0 2px var(--color-dark-gray);
        }

        .radio:disabled~.plan-details {
            color: var(--color-dark-gray);
            cursor: default;
        }

        .radio:disabled~.plan-details .plan-type {
            color: var(--color-dark-gray);
        }

        .card:hover .radio:disabled~.plan-details {
            border-color: var(--color-gray);
            box-shadow: none;
        }

        .card:hover .radio:disabled {
            border-color: var(--color-gray);
        }
    </style>


    <div class="main-panel">
        <div class="content-wrapper pb-0">

            <div class="p-3 bg-white">
                <div class="page-header flex-wrap">
                    <h4 class="mb-0">
                        Add Order
                    </h4>
                </div>

                <form id="add_new_order_form">
                    @csrf
                    <!--  -->
                    <div class="" style="overflow: hidden;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customerName" class="required-field">Customer Name<span
                                            style="color:red;">*</span></label>
                                    <!-- <input type="text" name="customerName" required id="customerName" class="form-control" placeholder="Customer Name"> -->
                                    <select name="customer_id" id="add_order_customerName"
                                        class="form-control select_2_input">
                                        <option value="">Select</option>
                                        @foreach ($customer as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="recipientName" class="required-field">Recipient Name<span
                                            style="color:red;">*</span></label>
                                    <input type="text" name="recipientName" required id="recipientName"
                                        class="form-control" placeholder="Recipient Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobileNo" class="required-field">Mobile Number<span
                                            style="color:red;">*</span></label>
                                    <input type="text" name="mobileNo" required id="mobileNo" class="form-control"
                                        maxlength="8" minlength="8" placeholder="Mobile Number"
                                        onkeypress="return /[0-9]/i.test(event.key)">
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                            {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcode">Postal Code<span style="color:red;">*</span></label>
                                <input type="text" name="postcode" required class="form-control" id="customer_postcode" maxlength="6" minlength="6" placeholder="Postal Code">
                            </div> 
                        </div> --}}
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="address">Address<span style="color:red;">*</span></label>
                                    <input type="text" name="address" id="add_order_address" readonly
                                        class="form-control">
                                    <input type="hidden" name="address_id" id="add_order_address_id">
                                </div>
                            </div>
                            <div class="col-md-1" style="margin-top: 27px;">
                                <div class="form-group">
                                    <label for="address"></label>
                                    <a href="javascript:void(0)" id="select_address">Select <i
                                            class="fa fa-circle-o-notch fa-spin" style="margin-right: -2px;display: none"
                                            id="loder_select"></i></a>
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit">Unit<span style="color:red;">*</span></label>
                                    <input type="text" name="unit" required class="form-control" id="add_order_unit"
                                        rows="4" placeholder="Unit" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="delivery_date">Delivery Date<span style="color:red;">*</span></label>
                                    <input type="text" name="delivery_date" value="{{ old('delivery_date') }}" required
                                        class="form-control datepicker" id="delivery_date" placeholder="DD/MM/YYYY"
                                        autocomplete="off">
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="row"> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_mode">Payment Mode<span style="color:red;">*</span></label>
                                    <input type="text" name="payment_mode" required value="COD" readonly
                                        class="form-control" id="payment_mode" placeholder="Payment Mode">
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
                                            Product Price
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
                                    <tr>
                                        <td style="min-width:230px">
                                            <select
                                                class="product_id select_2_input form-control select20 add_order_product_id"
                                                required onchange="get_product_details(this)" name="product_id[]">
                                                {{-- <option value="">Select Product</option> --}}
                                                {{-- @foreach ($products as $key => $value)
                                                    <option selected value="{{ $value->product_id }}">{{ $value->product_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </td>

                                        <td style="min-width:230px">
                                            <input type="text" name="quantity[]" required id="quantity"
                                                placeholder="Quantity" class="form-control add_order_quantity"
                                                onchange="add_quantity_with_price(this)" style="text-align: center;"
                                                onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </td>
                                        <td style="min-width:230px">
                                            <p class="add_order_product_price"
                                                style="text-align: center;margin: auto;font-weight: bold;"></p>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" name="unit_price[]" value="0" required
                                                id="unit_price" class="form-control add_order_unit_price"
                                                placeholder="Unit Price" style="text-align: center;" readonly>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" id="sub_total" readonly required name="sub_total[]"
                                                placeholder="Subtotal" class="form-control add_order_sub_total"
                                                style="text-align: center;">
                                        </td>
                                        <td>
                                            <button type="button" id="clear"
                                                class="btn btn-danger remove-input-field">Remove</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="min-width:230px">
                                            <select
                                                class="product_id select_2_input form-control select21 add_order_product_id"
                                                onchange="get_product_details(this)" name="product_id[]">
                                                {{-- <option value="">Select Product</option> --}}
                                                {{-- @foreach ($products as $key => $value)
                                                    <option value="{{ $value->product_id }}">{{ $value->product_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </td>

                                        <td style="min-width:230px">
                                            <input type="text" name="quantity[]" id="quantity"
                                                placeholder="Quantity" class="form-control add_order_quantity"
                                                onchange="add_quantity_with_price(this)" style="text-align: center;"
                                                onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </td>
                                        <td style="min-width:230px">
                                            <p class="add_order_product_price"
                                                style="text-align: center;margin: auto;font-weight: bold;"></p>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" name="unit_price[]" value="0" id="unit_price"
                                                class="calculate form-control add_order_unit_price"
                                                placeholder="Unit Price" style="text-align: center;" readonly>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" id="sub_total" readonly name="sub_total[]"
                                                placeholder="Subtotal" class="form-control add_order_sub_total"
                                                style="text-align: center;">
                                        </td>
                                        <td>
                                            <button type="button" id="clear"
                                                class="btn btn-danger remove-input-field">Remove</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="min-width:230px">
                                            <select
                                                class="product_id select_2_input form-control select22 add_order_product_id"
                                                onchange="get_product_details(this)" name="product_id[]">
                                                {{-- <option value="">Select Product</option> --}}
                                                {{-- @foreach ($products as $key => $value)
                                                    <option value="{{ $value->product_id }}">{{ $value->product_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </td>

                                        <td style="min-width:230px">
                                            <input type="text" name="quantity[]" id="quantity"
                                                placeholder="Quantity" class="form-control add_order_quantity"
                                                onchange="add_quantity_with_price(this)" style="text-align: center;"
                                                onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </td>
                                        <td style="min-width:230px">
                                            <p class="add_order_product_price"
                                                style="text-align: center;margin: auto;font-weight: bold;"></p>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" name="unit_price[]" value="0" id="unit_price"
                                                class="form-control calculate add_order_unit_price"
                                                placeholder="Unit Price" style="text-align: center;" readonly>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" id="sub_total" readonly name="sub_total[]"
                                                placeholder="Subtotal" class="form-control add_order_sub_total"
                                                style="text-align: center;">
                                        </td>
                                        <td>
                                            <button type="button" id="clear"
                                                class="btn btn-danger remove-input-field">Remove</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="min-width:230px">
                                            <select
                                                class="product_id select_2_input form-control select23 add_order_product_id"
                                                onchange="get_product_details(this)" name="product_id[]">
                                                {{-- <option value="">Select Product</option> --}}
                                                {{-- @foreach ($products as $key => $value)
                                                    <option value="{{ $value->product_id }}">{{ $value->product_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </td>

                                        <td style="min-width:230px">
                                            <input type="text" name="quantity[]" id="quantity"
                                                placeholder="Quantity" class="form-control add_order_quantity"
                                                onchange="add_quantity_with_price(this)" style="text-align: center;"
                                                onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </td>
                                        <td style="min-width:230px">
                                            <p class="add_order_product_price"
                                                style="text-align: center;margin: auto;font-weight: bold;"></p>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" name="unit_price[]" value="0" id="unit_price"
                                                class="form-control calculate add_order_unit_price"
                                                placeholder="Unit Price" style="text-align: center;" readonly>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" id="sub_total" readonly name="sub_total[]"
                                                placeholder="Subtotal" class="form-control add_order_sub_total"
                                                style="text-align: center;">
                                        </td>
                                        <td>
                                            <button type="button" id="clear"
                                                class="btn btn-danger remove-input-field">Remove</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="min-width:230px">
                                            <select
                                                class="product_id select_2_input form-control select24 add_order_product_id"
                                                onchange="get_product_details(this)" name="product_id[]">
                                                {{-- <option value="">Select Product</option>
                                                @foreach ($products as $key => $value)
                                                    <option value="{{ $value->product_id }}">{{ $value->product_name }}
                                                    </option>
                                                @endforeach --}}
                                            </select>
                                        </td>

                                        <td style="min-width:230px">
                                            <input type="text" name="quantity[]" id="quantity"
                                                placeholder="Quantity" class="form-control add_order_quantity"
                                                onchange="add_quantity_with_price(this)" style="text-align: center;"
                                                onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                                        </td>
                                        <td style="min-width:230px">
                                            <p class="add_order_product_price"
                                                style="text-align: center;margin: auto;font-weight: bold;"></p>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" name="unit_price[]" value="0" id="unit_price"
                                                class="form-control calculate add_order_unit_price"
                                                placeholder="Unit Price" style="text-align: center;" readonly>
                                        </td>
                                        <td style="min-width:230px">
                                            <input type="text" id="sub_total" readonly name="sub_total[]"
                                                placeholder="Subtotal" class="form-control add_order_sub_total"
                                                style="text-align: center;">
                                        </td>
                                        <td>
                                            <button type="button" id="clear"
                                                class="btn btn-danger remove-input-field">Remove</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="">
                                            <button type="button" id="addProductRow" class="btn btn-success"> Add
                                            </button>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>


                        <div class="m-2 p-2 row">
                            <div id="previous_order_section" style="display: none" class="col-md-6">
                                <span style="font-weight: 800;text-decoration: underline">Previous Order</span>
                                <div style="font-weight: 800;">
                                    <span>{{ __('lang.subtotal') }} : </span>
                                    <span id="previous_order_final_sub_total">
                                        $0.00
                                    </span>
                                </div>
                                <div style="font-weight: 800;">
                                    <span>{{ __('lang.shipping') }} : </span>
                                    <span id="previous_order_shipping_charge">
                                        $0.00
                                    </span>
                                </div>
                                <div style="font-weight: 800;">
                                    <span>{{ __('lang.total_price') }} : </span>
                                    <span id="previous_order_final_price">
                                        $0.00
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2" id="latest_order_section">
                                <div style="text-align: end;font-weight: 800;">
                                    <span>{{ __('lang.subtotal') }} : </span>
                                    <span id="add_order_final_sub_total">
                                        $0.00
                                    </span>
                                </div>
                                <div style="text-align: end;font-weight: 800;">
                                    <span>{{ __('lang.shipping') }} : </span>
                                    <span id="add_order_shipping_charge">
                                        $0.00
                                    </span>
                                </div>
                                <div style="text-align: end;font-weight: 800;">
                                    <span>{{ __('lang.total_price') }} : </span>
                                    <span id="add_order_final_price">
                                        $0.00
                                    </span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="products">
                        <div class="m-4 p-2" style="float: right">
                            <a type="button" class="btn btn-primary"
                                href="{{ route('SA-CustomerManagement') }}">Close</a>
                            <button type="submit" id="add_new_order_form_btn" class="btn btn-primary">Save
                                <i class="fa fa-circle-o-notch fa-spin" style="margin-right: -2px;display: none"
                                    id="loder_for_add_new_order_btn"></i>
                            </button>
                        </div>

                    </div>
                    <!--  -->
                </form>
            </div>



            <div class="modal fade" id="add_order_address_modal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content p-2">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Address</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body bg-white px-3">
                            <div style="float: right;">
                                <a data-toggle="modal" data-target="#add_new_address" href="#!"
                                    class="btn btn-secondary">Add Address</a>
                            </div>
                            <div class="row" id="add_order_all_address_modal">
                                {{-- <div class="grid" id="all_address_modal"> --}}
                                <img src="{{ asset('loading/loading.webp') }}" height="100"
                                    style="transform: translateX(284px);border-radius: 312px;" id="loading_image"
                                    style="display: none">
                                {{-- </div>  --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary " data-dismiss="modal"
                                aria-label="Close">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="add_new_address" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content p-2">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Address</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="text-left clearfix" id="add_new_address_form" method="POST">
                            <div class="modal-body bg-white px-3">
                                @csrf
                                <div class="modal-body">

                                    <!--  -->
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="{{ __('lang.full_name') }}">
                                    </div>

                                    <!--  -->
                                    <div class="form-group">
                                        <input type="tel" class="form-control" name="mobile_number"
                                            placeholder="{{ __('lang.mobile_number') }}">
                                    </div>


                                    <!--  -->
                                    <div class="form-group">
                                        <input type="text" name="postcode" class="form-control"
                                            placeholder="{{ __('lang.postal_code') }}" id="customer_postcode">
                                    </div>

                                    <!--  -->
                                    <div class="form-group">
                                        <textarea type="text" class="form-control" name="address" placeholder="{{ __('lang.address') }}" readonly
                                            id="customer_address"></textarea>
                                    </div>

                                    <!--  -->
                                    <div class="form-group">
                                        <input type="text" name="unit" class="form-control"
                                            placeholder="{{ __('lang.unit_no') }}">
                                    </div>


                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary " data-dismiss="modal"
                                    aria-label="Close">Close</button>
                                <button type="button" class="btn btn-primary" id="add_new_address_form_btn">Save <i
                                        class="fa fa-circle-o-notch fa-spin" style="margin-right: -2px;display: none"
                                        id="loder_for_new_address_btn"></i></button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>







        @section('javascript')


            <script>
                $('#add_new_order_form_btn').click(function(e) {
                    e.preventDefault();
                    let form = $('#add_new_order_form')[0];
                    let data = new FormData(form);
                    $.ajax({
                        url: "{{ route('add_new_order') }}",
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#loder_for_add_new_order_btn').show()
                        },
                        success: function(data) {
                            $('#loder_for_add_new_order_btn').hide()
                            console.log(data)
                            if(data.status == 'success'){
                                successMsg(data.message);
                                setTimeout(() => {
                                    window.location.href = data.url;
                                }, 1000);
                            }
                        },
                        error: function(error) {
                            $('#loder_for_add_new_order_btn').hide()
                            show_error_msg(error);
                        }
                    });
                });



                get_list_product();

                function get_list_product() {
                    let product_id_array = [];
                    $('.add_order_product_id option:selected').each(function() {
                        // console.log($(this).val())
                        if ($(this).val() != '')
                            product_id_array.push($(this).val())
                    });

                    $.ajax({
                        url: "{{ route('get_all_product_list') }}",
                        type: 'get',
                        dataType: 'json',
                        data: {
                            product_id_array: product_id_array
                        },
                        success: function(data) {
                            // console.log(data);
                            $('.add_order_product_id').each(function() {
                                if ($(this).val() == '') {
                                    $(this).empty();
                                }
                            });
                            $('.add_order_product_id').append(`<option value="">Select</option>`);
                            for (let i = 0; i < data.length; i++) {
                                $('.add_order_product_id').each(function() {
                                    if ($(this).val() == '') {
                                        $(this).append(
                                            `<option value="${data[i]['id']}">${data[i]['product_name']}</option>`
                                        );
                                    }
                                });
                            }
                            // $('.select_2_input').select2();
                        }
                    })
                }



                function add_quantity_with_price($this) {
                    let unit_price = $($this).closest('tr').find('.add_order_unit_price').val();
                    let quantity = $($this).val();
                    let sub_total = parseFloat(unit_price) * quantity
                    $($this).closest('tr').find('.add_order_sub_total').val(sub_total.toFixed(2));

                    calculate_all_subtotal()
                }

                function calculate_all_subtotal() {
                    let subtotal = 0;
                    $('.add_order_sub_total').each(function() {
                        if ($(this).val() != '')
                            subtotal = parseFloat(subtotal) + parseFloat($(this).val());
                    });
                    let shipping_charge = 0;
                    let final_price = 0;
                    if (subtotal <= 70) {
                        final_price = parseFloat(subtotal) + 8;
                        shipping_charge = 8;
                    } else {
                        final_price = subtotal;
                    }

                    get_previous_order_details($('#add_order_address_id').val(), $('#add_order_customerName').val());

                    $('#add_order_final_sub_total').html('$' + subtotal.toFixed(2))
                    // $('#add_order_shipping_charge').html("$" + shipping_charge.toFixed(2));
                    $('#add_order_final_price').html("$" + final_price.toFixed(2))
                    // console.log(subtotal);


                }


                $('#add_new_address_form_btn').click(function(e) {
                    e.preventDefault();
                    let form = $('#add_new_address_form')[0];
                    let data = new FormData(form);
                    data.append('user_id', $('#add_order_customerName option:selected').val())
                    $.ajax({
                        url: "{{ route('add_new_address') }}",
                        type: 'post',
                        dataType: 'json',
                        data: data,
                        processData: false,
                        contentType: false,
                        beforeSend: function(data) {
                            $('#loder_for_new_address_btn').show();
                        },
                        success: function(data) {
                            // console.log(data);
                            $('#loder_for_new_address_btn').hide();
                            if (data.status == 'success') {
                                successMsg(data.message);
                                $('#add_new_address').modal('hide');
                                $('#select_address').click();
                            }
                        },
                        error: function(error) {
                            // console.log(error);
                            $('#loder_for_new_address_btn').hide();
                            show_error_msg(error)
                        }
                    });
                });


                function get_product_details($this) {
                    let product_id = $($this).val();
                    // console.log();
                    // $($this).closest("input[name='unit_price[]']").val(111)
                    console.log($($this).closest('tr').find('.add_order_unit_price').val(2));
                    $.ajax({
                        url: "{{ route('get_product_details') }}",
                        type: 'get',
                        data: {
                            product_id: product_id,
                        },
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            if (data.discount_price != null) {
                                $($this).closest('tr').find('.add_order_product_price').html(
                                    `<del style="color:red">$${data.min_sale_price}</del>$${data.discount_price}`)
                                $($this).closest('tr').find('.add_order_unit_price').val(`${data.discount_price}`)
                            } else {
                                $($this).closest('tr').find('.add_order_product_price').html(`$${data.min_sale_price}`)
                                $($this).closest('tr').find('.add_order_unit_price').val(`${data.min_sale_price}`)
                            }

                        }
                    });
                    get_list_product();
                }

                $('#select_address').click(function() {
                    if ($('#add_order_customerName option:selected').val() != '') {
                        $.ajax({
                            url: "{{ route('get_all_address') }}",
                            type: 'get',
                            data: {
                                user_id: $('#add_order_customerName option:selected').val()
                            },
                            dataType: 'json',
                            beforeSend: function() {
                                $('#loading_image').show();
                                $('#loder_select').show();
                            },
                            success: function(data) {
                                let select_address = $('#change_address_id').val() != '' ? $(
                                        '#change_address_id')
                                    .val() : '';
                                $('#loading_image').hide();
                                $('#loder_select').hide();
                                $('#add_order_address_modal').modal('show');
                                $('#add_order_all_address_modal').empty();
                                if (data.length > 0) {
                                    for (let i = 0; i < data.length; i++) {
                                        $('#add_order_all_address_modal').append(` 
                                        <div class="grid col-md-4" id="add_order_all_address_modal">
                                        <label class="card">
                                            <input name="address_id" class="radio" type="radio" data-name="${data[i]['name']}" data-user_id="${data[i]['user_id']}" data-address_id="${data[i]['id']}" data-address="${data[i]['address']}" data-unit="${data[i]['unit']}" data-phone="${data[i]['mobile_number']}"  ${data[i]['id'] == select_address ? 'checked': ''} onclick="change_address(this)">
                                            <span class="plan-details">
                                                <span class="plan-type">${data[i]["name"]}</span>
                                                <span>postal Code:#${data[i]["postcode"]}</span>
                                                <span>${data[i]["address"]}</span>
                                                <span>Mobile No.:${data[i]["mobile_number"]}</span>
                                                <span>Unit No.:${data[i]["unit"]}</span>
                                            </span>
                                        </label>
                                        </div>
                                        `);
                                    }
                                } else {
                                    $('#add_order_all_address_modal').html(
                                        '<span style="color:red">Address Not Found</span>');

                                }
                            },
                            error: function(error) {
                                console.log(error)
                            }
                        })
                    } else {
                        console.log(1223)
                        errorMsg('Please Select Customer');
                    }
                });


                function change_address(data) {
                    let address_id = $(data).data('address_id');
                    let address = $(data).data('address');
                    let phone = $(data).data('mobile_number');
                    let unit = $(data).data('unit');
                    let name = $(data).data('name');
                    let user_id = $(data).data('user_id');

                    $('#add_order_address_id').val(address_id);
                    $('#add_order_address').val(address);
                    $('#add_order_unit').val(unit)
                    $('#recipientName').val(name);


                    get_previous_order_details(address_id, user_id);

                }

                function get_previous_order_details(address_id, user_id) {
                    let subtotal = 0;
                    $('.add_order_sub_total').each(function() {
                        if ($(this).val() != '')
                            subtotal = parseFloat(subtotal) + parseFloat($(this).val());
                    });

                    $.ajax({
                        url: "{{ route('get_previous_order_details') }}",
                        data: {
                            address_id: address_id,
                            user_id: user_id,
                            price: subtotal
                        },
                        type: 'get',
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            if (data.delivery_date != '') {
                                $('#delivery_date').val(data.delivery_date);
                                $('#delivery_date').attr('readonly', true);
                                $("#delivery_date").datepicker("destroy")
                            } else {
                                // if ($('#delivery_date').val() == '') { 
                                    $('#delivery_date').val('');
                                    $('#delivery_date').attr('readonly', false);
                                    $(".datepicker").datepicker({
                                        dateFormat: "dd/mm/yy",
                                        minDate: new Date(),
                                    });
                                // }
                            }

                            if (data.old_order_total_amount > 0) {
                                $('#previous_order_section').show();
                                $('#latest_order_section').removeClass('col-md-12')
                                $('#latest_order_section').addClass('col-md-6')

                                $('#previous_order_final_sub_total').html('$' + data.old_order_product_sub_total);
                                $('#previous_order_shipping_charge').html('$' + data.old_order_shipping_charge);
                                $('#previous_order_final_price').html('$' + data.old_order_total_amount);
                            } else {
                                $('#previous_order_section').hide();
                                $('#latest_order_section').addClass('col-md-12')
                            }

                            $('#add_order_shipping_charge').html('$' + data.shipping_charge)
                            // let latest_order = parseFloat(data.latest_order_final_price) + parseFloat(data.shipping_charge)
                            $('#add_order_final_price').html('$' + data.latest_order_final_price);

                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                }


                $('#add_order_customerName').change(function() {
                    let customer_id = $(this).val();
                    $.ajax({
                        'url': "{{ route('get_customer_details') }}",
                        type: 'get',
                        dataType: 'json',
                        data: {
                            customer_id: customer_id
                        },
                        success: function(data) {
                            
                            $('#recipientName').val(data.name);
                            $('#mobileNo').val(data.phone_number);
                            $('#add_order_address').val('');
                            $('#add_order_address_id').val('');
                            $('#delivery_date').val('');
                            $('#add_order_unit').val('');

                        }
                    });

                });




                $(document).ready(function() {

                    $('#address2').select2({
                        tags: true,
                    });

                    $('.select_2_input').select2({
                        placeholder: "Select"
                    });

                })

                $('#addProductRow').on('click', function() {
                    let number = $('.ordertable tr').length;
                    $('.ordertable').append(`
                    <tr>
                            <td style="min-width:230px">
                                <select class="product_id select_2_input form-control add_order_product_id"   name="product_id[]" onchange="get_product_details(this)">
                                </select>
                            </td>
                            <td style="min-width:230px">
                                <input type="text" name="quantity[]" onchange="add_quantity_with_price(this)" id="quantity" placeholder="Quantity" style="text-align: center;" class="form-control add_order_quantity" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57">
                            </td>
                            <td style="min-width:230px">
                                <p class="add_order_product_price" style="text-align: center;margin: auto;font-weight: bold;"></p>
                            </td>
                            <td style="min-width:230px">
                            <input type="text" name="unit_price[]" value="0"  id="unit_price" class="form-control calculate add_order_unit_price" placeholder="Unit Price" readonly style="text-align: center;">
                            </td>
                            <td style="min-width:230px">
                                <input type="text" id="sub_total" readonly  name="sub_total[]" placeholder="Subtotal" style="text-align: center;" class="form-control add_order_sub_total">
                            </td>
                            <td>
                                <button type="button" id="clear" class="btn btn-danger remove-input-field">Remove</button>
                            </td>
                    </tr>
            `);
                    get_list_product();
                    $('.select_2_input').select2();

                });

                $(document).on('click', '.remove-input-field', function() {
                    $(this).parents('tr').remove();
                    calculate_all_subtotal();
                });

                $(document).on('change', '#customer_postcode', function() {
                    let postcode = $(this).val();
                    jQuery.ajax({
                        url: "https://developers.onemap.sg/commonapi/search",
                        type: "get",
                        data: {
                            "searchVal": postcode,
                            "returnGeom": 'N',
                            "getAddrDetails": 'Y',
                        },
                        beforeSend: function() {
                            $('#customer_address').val('Loading...');
                        },
                        success: function(response) {

                            if (response.found == 0) {
                                $('#customer_address').val('');
                                $('#customer_postcode').val('');
                                errorMsg('Please Enter Valid Postal Code');
                            } else {
                                $.each(response.results, function(key, value) {
                                    $('#customer_address').val(value['ADDRESS']);
                                });
                            }
                        }
                    });
                });
            </script>

            <script>
                $(".datepicker").datepicker({
                    dateFormat: "dd/mm/yy",
                    minDate: new Date(),
                });
            </script>


        @endsection
    @endsection
