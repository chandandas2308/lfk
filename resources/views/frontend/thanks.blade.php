@extends('frontend.layouts.master')
@section('title', 'LFK | Thanks For Shopping')
@section('body')

    <!-- Page Wrapper -->
    <section class="page-wrapper success-msg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="block text-center">
                        <i class="tf-ion-android-checkmark-circle"></i>
                        <h2 class="text-center">
                            {{ GoogleTranslate::trans('Thank You For Order With Us', app()->getLocale()) }}!</h2>
                        <hr>
                        <div class="wishlist-table table-content table-responsive">
                            <h4 class="text-capitalize">
                                {{-- <caption>{{ GoogleTranslate::trans('Shopping Details', app()->getLocale()) }}</caption> --}}
                                <caption>{{ __('lang.order_summary') }}</caption>
                            </h4>
                            @php
                                $all_order_details = DB::table('notifications')->where('consolidate_order_no',request()->id)->first();
                                $all_order_address = DB::table('addresses')->where('id',$all_order_details->address_id)->first();
                            @endphp
                            <div class="row ">
                                <div class="col-md-6">
                                    <span class="plan-details">
                                        <span class="plan-type"></span>
                                        <span>{{ __('lang.consolidate_order_no') }}:#{{ $all_order_details->consolidate_order_no }}</span>
                                        <span>{{ __('lang.delivery_date') }}:{{ $all_order_details->delivery_date }}</span>
                                        <span>{{ __('lang.payment_method') }}:{{ $all_order_details->payment_mode == 'hitpay' ? 'Paynow' : $all_order_details->payment_mode }}</span>
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <span class="plan-details">
                                        <span class="plan-type"></span>
                                        {{-- <span>postal Code:#{{ $all_order_address->postcode }}</span> --}}
                                        <span>{{ $all_order_address->address }}</span>
                                        <span>Mobile No.:{{ $all_order_address->mobile_number }}</span>
                                        <span>Unit No.:{{ $all_order_address->unit }}</span>
                                    </span>
                                </div>
                            </div>
                            <table class="table table-bordered mt-4 mb-4">
                                <thead>
                                    <tr>
                                        <th class="product-name text-center alt-font">
                                            S/N
                                        </th>
                                        <th class="product-price text-center alt-font">
                                            {{ __('lang.image') }}</th>
                                        <th class="product-price text-center alt-font">
                                            {{ __('lang.product_name') }}</th>
                                        <th class="product-name alt-font text-center">
                                            {{ __('lang.quantity') }}</th>
                                        <th class="product-price text-center alt-font">
                                            {{ __('lang.price') }}</th>
                                        <th class="product-price text-center alt-font">
                                            {{ __('lang.points') }}</th>
                                        <th class="stock-status text-center alt-font">
                                            {{ __('lang.total_price') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $id = 0;

                                        $order_details = DB::table('notifications')
                                        ->where('user_id', Auth::user()->id)
                                        ->orderBy('id', 'desc')
                                        ->first();

                                        $order_number = $order_details->order_no;
                                        $bill_sum = DB::table('user_orders')->where('consolidate_order_no',$order_details->consolidate_order_no)->sum('final_price');
                                        $all_order_shipping_charge = DB::table('user_orders')->where('consolidate_order_no',$order_details->consolidate_order_no)->sum('ship_charge');
                                        $all_order_subtotal = 0;
                                        $all_total_quantity = DB::table('user_order_items')->where('consolidate_order_no',$order_details->consolidate_order_no)->sum('quantity');
                                    @endphp
                                    
                                    @foreach ($details as $item)
                                        <tr>
                                            <td class="text-center" valign="middle">{{ ++$id }}</td>
                                            <td class="text-center"><img src="{{ $item->product_image }}" alt="" style="width: 44px"></td>
                                            <td class="text-center">{{ $item->product_name1 }}</td>
                                            <td class="product-name text-center">{{ $item->quantity }}</td>
                                            <td class="product-price text-center"><span
                                                    class="amount">${{ number_format($item->product_price,2) }}</span></td>
                                            <td class="product-price text-center"> {{ $item->points != null ? $item->points : '-' }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="in-stock">${{ number_format($item->product_order_total,2) }}</span>
                                                    @php
                                                       $all_order_subtotal += $item->product_order_total;
                                                    @endphp
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                <div style="text-align: end;font-weight: 800;">
                                    <span>{{ __('lang.subtotal') }} : </span><span>$
                                        {{ number_format($all_order_subtotal,2) }}
                                    </span>
                                </div>
                                <div style="text-align: end;font-weight: 800;">
                                    <span>{{ __('lang.shipping') }} : </span><span>$
                                        {{ number_format($all_order_shipping_charge,2) }}
                                    </span>
                                </div>
                                <div style="text-align: end;font-weight: 800;">
                                    <span>{{ __('lang.total') }} : </span><span>$
                                        {{ number_format($bill_sum,2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="text-center">
                                <a href="/"
                                    class="btn btn-main mt-20">{{ __('lang.continue_shopping') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.page-warpper -->

@endsection
