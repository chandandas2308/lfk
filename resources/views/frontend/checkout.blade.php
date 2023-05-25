@extends('frontend.layouts.master')
@section('title', 'LFK | Checkout')
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
                    <a href="{{ route('checkout.addressSummary') }}">
                        <div class="circle done">
                            <span class="label">2</span>
                            <span class="title">{{ __('lang.address') }}</span>
                        </div>
                    </a>
                    <span class="bar done"></span>
                    <a href="javascript::void(0)">
                        <div class="circle done">
                            <span class="label">3</span>
                            <span class="title">{{ __('lang.delivery') }}</span>
                        </div>
                    </a>
                    <span class="bar done"></span>
                    <div class="circle active">
                        <span class="label">4</span>
                        <span class="title">{{ __('lang.billing') }}</span>
                    </div>
                    <span class="bar done"></span>
                    <div class="circle">
                        <span class="label">5</span>
                        <span class="title">{{ __('lang.done') }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="widget-title">{{ __('lang.billing_details') }}</h4>
                        <form class="checkout-form" method="POST" action="{{ route('checkout.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="address_id" value="{{ $address_id }}">
                            <input type="hidden" name="coupon" value="{{ $coupon }}">
                            <input type="hidden" name="delivery_date" value="{{ $delivery_date }}">
                            <input type="hidden" name="remark" value="{{ $remark }}">

                            <label for="paymentMode">{{ __('lang.payment_mode') }}</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="card" style="box-shadow:none;">
                                        <input name="mode" class="radio" value="hitpay" id="paymentModeOnline"
                                            @if ($payment_mode == 'hitpay') checked @elseif($payment_mode == 'cod' || $payment_mode == 'COD') disabled @endif
                                            type="radio" required style="margin: -2px 0 0;">
                                        <span class="plan-details">
                                            Paynow
                                        </span>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="card" style="box-shadow:none;" id="paymentMode">
                                        <input name="mode" class="radio" value="cod" id="paymentModeCOD"
                                            type="radio"
                                            @if ($payment_mode == 'cod' || $payment_mode == 'COD') checked @elseif ($payment_mode == 'hitpay') disabled @endif
                                            required style="margin: -2px 0 0;">
                                        <span class="plan-details">
                                            {{ __('lang.cash_on_delivery') }}
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <input type="submit" value="{{ __('lang.place_order') }}" class="btn btn-main mt-20" />
                        </form>
                    </div>
                    <div class="col-md-4">
                        <h4 class="widget-title">{{ __('lang.all_order_history') }}</h4>
                        @php
                            $details = DB::table('user_order_items')
                                ->select('user_order_items.*',DB::raw('SUM(quantity) as quantity'),DB::raw('SUM(final_price_with_coupon_offer) as product_order_total'))
                                ->where('consolidate_order_no', $consolidate_order_is)
                                ->groupBy('product_id')
                                ->get();
                            $bill_sum1 = DB::table('user_orders')
                                ->where('consolidate_order_no', $consolidate_order_is)
                                ->sum('final_price');
                            
                            $old_order_shipping_charge = DB::table('user_orders')
                                ->where('consolidate_order_no', $consolidate_order_is)
                                ->sum('ship_charge');
                        @endphp
                        @if ($consolidate_order_is != null || $consolidate_order_is != '')
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>{{ __('lang.image') }}</th>
                                        <th>{{ __('lang.product_name') }}</th>
                                        <th>{{ __('lang.quantity') }}</th>
                                        <th>{{ __('lang.price') }}</th>
                                        <th>{{ __('lang.total') }}</th>
                                        <th>{{ __('lang.points') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $final_sub_total_with_quantity = 0;
                                    @endphp
                                    @foreach ($details as $key => $value)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle;"><img
                                                    src="{{ $value->product_image }}" alt="" style="height: 44px;">
                                            </td>
                                            <th class="text-center" style="vertical-align: middle;">
                                                {{ $value->product_name }}</th>
                                            <th class="text-center" style="vertical-align: middle;">{{ $value->quantity }}
                                            </th>
                                            <th class="text-center" style="vertical-align: middle;">
                                                ${{ number_format($value->product_price,2) }}</th>
                                            <th class="text-center" style="vertical-align: middle;">{{ $value->product_order_total }}</th>
                                            <th class="text-center" style="vertical-align: middle;">
                                                {{ $value->points != null ? $value->points : '-' }}</th>
                                        </tr>
                                        @php
                                            $final_sub_total_with_quantity += $value->product_order_total;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: end;font-weight: 800;">
                                <span>{{ __('lang.subtotal') }} : </span><span>$
                                    {{ number_format($final_sub_total_with_quantity, 2) }}
                                </span>
                            </div>
                            <div style="text-align: end;font-weight: 800;">
                                <span>{{ __('lang.shipping') }} : </span><span>$
                                    {{ number_format($old_order_shipping_charge, 2) }}
                                </span>
                            </div>
                            <div style="text-align: end;font-weight: 800;">
                                <span>{{ __('lang.previous') }} {{ __('lang.total') }} : </span><span>$
                                    {{ number_format($bill_sum1,2) }}
                                </span>
                            </div>
                        @endif
                        <div class="product-checkout-details">
                            <h4 class="widget-title">{{ __('lang.total_pay_amt') }}</h4>
                            <div class="block">
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
                                                                style="height: 44px;"></td>
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
                                        <span class="price">$<span id="subTotalOnCheckout">
                                                {{ number_format($sub_total, 2) }}
                                            </span></span>
                                    </li>
                                    <li>
                                        @if ($shipping_charge == -8)
                                            <span id="shippingChargeTitle">{{ __('lang.shipping_discount') }}:</span>
                                        @else
                                            <span id="shippingChargeTitle">{{ __('lang.shipping') }}:</span>
                                        @endif
                                        <span id="checkoutShipping">
                                            ${{ number_format($shipping_charge, 2) }}
                                        </span>
                                    </li>
                                    @if (!empty($discount_amount))
                                        <li id="coupon_section">
                                            @if ($coupon_type == 'voucher')
                                                <span>{{ __('lang.voucher') }}:</span>
                                            @else
                                                <span>{{ __('lang.coupon') }}:</span>
                                            @endif
                                            <span id="coupon_discount">
                                                - ${{ number_format($discount_amount, 2) }}
                                            </span>
                                        </li>
                                    @endif

                                </ul>
                                <div class="summary-total">
                                    <span>{{ __('lang.total') }}</span>
                                    <span id="grand_total">
                                        ${{ number_format($final_price, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('.bars').hide();
            }, 5000);
        });
    </script>
@endsection
