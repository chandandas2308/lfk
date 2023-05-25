@extends('frontend.layouts.master')
@section('title', 'LFK | Checkout')
@section('body')

    <div class="">
        <div class="checkout shopping" style="margin-top:2rem;margin-bottom:2rem">
            <div class="container">
                <div class="progress-main">
                    <div class="circle done">
                        <span class="label">1</span>
                        <span class="title">{{ __('lang.order') }}</span>
                    </div>
                    <span class="bar done"></span>
                    <div class="circle done">
                        <span class="label">2</span>
                        <span class="title">{{ __('lang.ADDRESS') }}</span>
                    </div>
                    <span class="bar done"></span>
                    <div class="circle done">
                        <span class="label">3</span>
                        <span class="title">{{ __('lang.delivery') }}</span>
                    </div>
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
                        <h4 class="widget-title">Billing Details</h4>
                        <form class="checkout-form" method="POST" action="{{ route('checkout.redemptionShop') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <label for="paymentMode">Payment Mode</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="card" style="box-shadow:none;" id="paymentMode">
                                        <input name="mode" class="radio" value="points" id="paymentModePoints"
                                            type="radio" required style="margin: -2px 0 0;">
                                        <span class="plan-details">
                                            Pay with Loyalty Points
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="address_id" value="{{ $address_id }}">
                            <input type="hidden" name="product_id" value="{{ $data->id }}">
                            <input type="hidden" name="delivery_date" value="{{ $deliver_date }}">
                            <input type="hidden" name="remark" value="{{ $remark }}">
                            <input type="submit" value="Place Order" class="btn btn-main mt-20" />
                        </form>
                    </div>
                    <div class="col-md-4">
                        <!-- <hr> -->
                        <h4 class="widget-title">{{ __('lang.all_order_history') }}</h4>
                        @php
                            $details = DB::table('user_order_items')
                                ->select('user_order_items.*',DB::raw('SUM(quantity) as quantity'))
                                ->where('consolidate_order_no', $order_no)
                                ->groupBy('product_id')
                                ->get();
                            $bill_sum = DB::table('user_order_items')
                                ->where('consolidate_order_no', $order_no)
                                ->sum('product_price');
                            $shipping_charge = DB::table('sessions')
                                ->where('id', Session::getId())
                                ->first();
                            $cart_sum = DB::table('carts')
                                ->where('use_id', Auth::user()->id)
                                ->sum('total_price');
                        @endphp

                        @if ($order_no != null || $order_no != '')
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>{{ __('lang.product_name') }}</th>
                                        <th>{{ __('lang.quantity') }}</th>
                                        <th>{{ __('lang.price') }}</th>
                                        <th>{{ __('lang.points') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($details as $key => $value)
                                        <tr>
                                            <th>{{ $value->product_name }}</th>
                                            <th>{{ $value->quantity }}</th>
                                            <th>${{ $value->product_price }}</th>
                                            <th>{{ $value->points != null ? $value->points : '-' }}</th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif


                        <div class="product-checkout-details">
                            <h4 class="widget-title">{{ __('lang.current_order') }}</h4>
                            <div class="block">
                                <ul class="summary-prices">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{ __('lang.image') }}</th>
                                                <th>{{ __('lang.product_name') }}</th>
                                                {{-- <th>{{ __('lang.quantity') }}</th> --}}
                                                <th>{{ __('lang.points') }}</th>
                                                {{-- <th>{{ __('lang.total_price') }}</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $product_redemption_shops = DB::table('product_redemption_shops')
                                                    ->where('id', $product_redemption_shops_id)
                                                    ->get();
                                                
                                            @endphp
                                            @foreach ($product_redemption_shops as $item)
                                                @php
                                                    $redemption_products = DB::table('products')
                                                        ->where('id', $item->product_id)
                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <td class="text-center" style="vertical-align: middle;"><img
                                                            src="{{ $redemption_products->img_path }}" alt=""
                                                            style="height: 44px;">
                                                    </td>
                                                    <th class="text-center" style="vertical-align: middle;">
                                                        {{ $item->product_name }}</th>
                                                    {{-- <th class="text-center" style="vertical-align: middle;">
                                                    {{ $item->quantity }}</th> --}}
                                                    <th class="text-center" style="vertical-align: middle;">
                                                        {{ $item->points }}
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <li>
                                        <span>{{ __('lang.subtotal') }}:</span>
                                        <span class="price"><span id="subTotalOnCheckout">
                                            {{ $data->points }} Points
                                            </span></span>
                                    </li>
                        
                                </ul>
                                <div class="summary-total">
                                    <span>{{ __('lang.total') }}</span>
                                    <span id="grand_total">
                                        {{ $data->points }} Points
                                    </span>
                                </div>
                            </div>
                        </div>




                        {{-- <div class="product-checkout-details">
                            <div class="block">
                                <ul class="summary-prices">
                                    <li>
                                        <span>{{ __('lang.subtotal') }}:</span>
                                        <span>{{ $data->points }} Points</span>
                                    </li>
                                </ul>
                                <div class="summary-total">
                                    <span>Total</span>
                                    <span>{{ $data->points }} Points</span>
                                </div>
                            </div>
                        </div> --}}





                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
