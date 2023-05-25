@extends('frontend.layouts.master')
@section('title', 'LFK | Address Summary')
@section('body')

    <div class="">
        <div class="checkout shopping" style="margin-top:2rem;margin-bottom:2rem">
            <div class="container">

                <div class="progress-main">
                    <a href="{{ route('checkout.orderSummary') }}">
                        <div class="circle done">
                            <span class="label">1</span>
                            <span class="title">{{ __('lang.order') }}</span>
                        </div>
                    </a>
                    <span class="bar done"></span>
                    <div class="circle active">
                        <span class="label">2</span>
                        <span class="title">{{ __('lang.ADDRESS') }}</span>
                    </div>
                    <span class="bar done"></span>
                    <div class="circle">
                        <span class="label">3</span>
                        <span class="title">{{ __('lang.delivery') }}</span>
                    </div>
                    <span class="bar"></span>
                    <div class="circle ">
                        <span class="label">4</span>
                        <span class="title">{{ __('lang.billing') }}</span>
                    </div>
                    <span class="bar"></span>
                    <div class="circle">
                        <span class="label">5</span>
                        <span class="title">{{ __('lang.done') }}</span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <form action="{{ route('checkout.deliveryDate') }}" method="post">
                            @csrf
                            <h4 class="widget-title">{{ __('lang.address_details') }}</h4>
                            <div class="add-addr" style="display: flex; flex-direction: row-reverse;">
                                {{-- <a href="#" class="btn  btn-add-front" data-toggle="modal" data-target="#basicModal" --}}
                                <a href="javascript::void(0)" class="btn  btn-add-front" onclick="open_add_address_modal()">
                                    {{ __('lang.add_address') }}
                                </a>
                            </div>
                            <div class="grid" id="addressesCards">
                                <img src="{{ asset('loading/loading.webp') }}" height="100"
                                    style="transform: translateX(284px);border-radius: 312px;">
                            </div>
                            <input type="hidden" name="store_coupon_in_input_field" id="store_coupon_in_input_field">
                            {{-- <a href="{{ route('checkout.deliveryDate') }}" id="confirm_address_btn"
                                class="btn btn-main mt-20">{{ __('lang.confirm_address') }}</a> --}}
                            <input type="submit" value="{{ __('lang.confirm_address') }}" class="btn btn-main mt-20">
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="product-checkout-details">


                            <div class="block">
                                <div class="discount-code" id="have_a_discount">
                                    <p>
                                        {{ __('lang.have_a_discount') }} ?
                                        <a data-toggle="modal" data-target="#coupon-modal" href="#!"
                                            style="color:#0000ffab;">{{ __('lang.enter_it_here') }}</a>
                                    </p>
                                </div>
                                <div class="discount-code" style="display: none" id="delete_coupon_discount_section">
                                    <p id="show_coupon_code">

                                    </p>
                                    <a href="#" id="remove_coupon_code">{{ __('lang.remove') }}</a>
                                </div>
                                <ul class="summary-prices">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.image') }}</th>
                                                <th>{{ __('lang.product_name') }}</th>
                                                <th>{{ __('lang.quantity') }}</th>
                                                <th>{{ __('lang.price') }}</th>
                                                <th>{{ __('lang.total_price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cart_data = DB::table('carts')
                                                    ->where('use_id', Auth::user()->id)
                                                    ->get();
                                            @endphp
                                            @foreach ($cart_data as $item)
                                                @php
                                                    $address_products = DB::table('products')
                                                        ->where('id', $item->product_id)
                                                        ->first();
                                                    $check_stock = DB::table('stocks')
                                                        ->where('product_id', $item->product_id)
                                                        ->groupBy('product_id')
                                                        ->sum('quantity');
                                                @endphp
                                                @if ($check_stock)
                                                    <tr>
                                                        <td class="text-center" style="vertical-align: middle;"><img
                                                                src="{{ $item->image }}" alt=""
                                                                style="height: 44px;">
                                                        </td>
                                                        <th class="text-center" style="vertical-align: middle;">
                                                            {{ $item->product_name }}</th>
                                                        <th class="text-center" style="vertical-align: middle;">
                                                            {{ $item->quantity }}</th>
                                                        <th class="text-center" style="vertical-align: middle;">
                                                            @if (!empty($address_products->discount_price))
                                                                <del style='color: red'>{{ number_format($address_products->min_sale_price, 2) }}
                                                                </del>
                                                                {{ number_format($address_products->discount_price, 2) }}
                                                            @else
                                                                {{ number_format($address_products->min_sale_price, 2) }}
                                                            @endif
                                                        </th>
                                                        <th class="text-center" style="vertical-align: middle;">
                                                            {{ !empty($address_products->discount_price) ? number_format($address_products->discount_price * $item->quantity, 2) : number_format($address_products->min_sale_price * $item->quantity,2) }}
                                                        </th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <li>
                                        <span>{{ __('lang.subtotal') }}:</span>
                                        <span class="price">
                                            $<span id="subTotalOnCheckout">
                                                {{ number_format($sub_total, 2) }}
                                            </span>
                                        </span>
                                    </li>
                                    <li>
                                        @if ($shipping_charge == -8)
                                            <span id="shippingChargeTitle">{{ __('lang.shipping_discount') }}:</span>
                                        @else
                                            <span id="shippingChargeTitle">{{ __('lang.shipping') }}:</span>
                                        @endif
                                        <span id="checkoutShipping">${{ number_format($shipping_charge, 2) }}</span>
                                    </li>
                                    {{-- <li id="offerDiscountSection">
                                        <span>{{ __('lang.offer_discount') }}:</span>
                                        <span id="offerDiscount"></span>
                                    </li> --}}
                                    <li style="display: none" id="coupon_section">
                                        <span id="coupon_lable">{{ __('lang.coupon') }}:</span>
                                        <span id="coupon_discount"></span>
                                    </li>
                                </ul>
                                <div class="summary-total">
                                    <span>{{ __('lang.total') }}</span>
                                    <span id="grand_total">${{ number_format($final_price, 2) }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="coupon-modal"
        aria-hidden="true">
        <div class="modal-dialog my-auto">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('lang.COUPON') }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="{{ __('lang.enter_coupon_code') }}"
                            id="coupon_code" />
                    </div>
                    <button type="submit" class="btn btn-main" id="apply_coupon_btn">
                        <i class="fa fa-spinner fa-spin" id="apply_coupon_spinner" style="display: none"></i>
                        {{ __('lang.apply_coupon') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('frontend.add_address')
    <!--  -->
    @include('frontend.edit_address')

@section('javascript')
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.bars').hide();
            }, 5000);
        });

        function open_add_address_modal() {
            $('#basicModal').modal('show');
        }



        function getAddress(params) {
            $.ajax({
                url: "{{ route('session-updateAddress') }}",
                method: "POST",
                data: {
                    id: params,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    $('#grand_total').html('$' + (parseFloat(response.final_price)).toFixed(2));
                    $('#checkoutShipping').html('$' + parseFloat(response.shipping_charge).toFixed(2));
                    if (response.shipping_charge == -8) {
                        $('#shippingChargeTitle').html('Shipping Discount');
                    }
                    // console.log(!$('#show_coupon_code').text())
                    if ($('#store_coupon_in_input_field').val() != '') {
                        check_coupon_code($('#store_coupon_in_input_field').val(), 1);
                    }
                    // $('#subTotalOnCheckout').html(parseFloat(response.data.sub_total).toFixed(2));
                }
            })
        }

        fetchAllAddress();

        $(document).ready(function() {
            addresses = $('#user_all_addresses_table').DataTable({
                "aaSorting": [],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                ajax: {
                    url: "{{ route('user.addresses') }}",
                    type: 'get'
                },
            })
        });


        $('#apply_coupon_btn').click(function(e) {
            e.preventDefault()
            let coupon = $('#coupon_code').val();
            if (coupon == '') {
                errorMsg('Please Enter Coupon');
            } else {
                check_coupon_code(coupon, null);
            }
        });

        function check_coupon_code(coupon, optional) {
            $.ajax({
                url: "{{ route('check_coupon_code') }}",
                type: 'post',
                data: {
                    coupon: coupon,
                    address_id: $('input[name=address_id]:checked').val(),
                    _token: "{{ csrf_token() }}"
                },
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#apply_coupon_spinner').css('display', '');
                    $('#apply_coupon_btn').prop('disabled', true);
                },
                success: function(data) {
                    $('#apply_coupon_spinner').css('display', 'none');
                    $('#apply_coupon_btn').prop('disabled', false);
                    if (data.coupon_discount) {
                        $('#coupon_section').css('display', '');
                        if(data.coupon_typ == 'voucher'){
                            $('#coupon_lable').html("{{ __('lang.voucher') }}");
                        }else{
                            $('#coupon_lable').html("{{ __('lang.coupon') }}");
                        }
                        $('#coupon_discount').html('-$' + parseFloat(data.coupon_discount).toFixed(2));
                        // $('#grand_total').html("$" + data.grand_total);
                        // $('#order_total_amount').val(parseFloat(data.grand_total).toFixed(2));

                        $('#grand_total').html('$' + parseFloat(data.final_price).toFixed(2));
                        $('#checkoutShipping').html('$'+parseFloat(data.shipping_charge).toFixed(2));
                        if (data.shipping_charge == -8) {
                            $('#shippingChargeTitle').html('Shipping Discount');
                        }
                        // $('#subTotalOnCheckout').html(parseFloat(data.sub_total).toFixed(2));

                        $('#delete_coupon_discount_section').css('display', '');
                        $('#show_coupon_code').html(coupon);
                        $('#coupon-modal').modal('hide');
                        $('#store_coupon_in_input_field').val(coupon);
                        // $('#controller_coupon_code').val(coupon);
                        // $('#have_a_discount').css('display', 'none');
                        // $('#coupon-modal .close').click();

                        // offer_discount

                        // location.reload();

                    }
                    if (data.error != '') {
                        errorMsg(data.error);
                    }
                    if (data.success != '' && optional == null) {
                        successMsg(data.success);
                        $('#coupon_code').val('');
                    }
                    if (data.not_apply_for_this != '') {
                        errorMsg(data.not_apply_for_this);
                    }
                },
                error: function(error) {
                    console.log(error)
                    $('#apply_coupon_spinner').css('display', 'none');
                    $('#apply_coupon_btn').prop('disabled', false);
                    single_error(error);
                }
            })
        }

        $('#remove_coupon_code').click(function() {

            $.ajax({
                url: "{{ route('session-removeCoupon') }}",
                method: "POST",
                data: {
                    address_id: $('input[name=address_id]:checked').val(),
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    $('#delete_coupon_discount_section').css('display', 'none');
                    $('#have_a_discount').css('display', '');

                    $('#coupon_section').css('display', 'none');
                    $('#coupon_discount').html('');
                    $('#grand_total').html('$' + parseFloat(response.final_price).toFixed(2));
                    $('#checkoutShipping').html('$' + parseFloat(response.shipping_charge).toFixed(2));
                    if (response.shipping_charge == -8) {
                        $('#shippingChargeTitle').html('Shipping Discount');
                    }
                    $('#store_coupon_in_input_field').val('');
                    // $('#subTotalOnCheckout').html(parseFloat(response.sub_total).toFixed(2));
                    // $('#controller_coupon_code').val('');
                    // location.reload();
                }
            })
        })
    </script>
@endsection
@endsection
