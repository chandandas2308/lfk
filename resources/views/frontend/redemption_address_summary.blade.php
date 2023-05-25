@extends('frontend.layouts.master')
@section('title', 'LFK | Address Summary')
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
                    <div class="circle active">
                        <span class="label">2</span>
                        <span class="title">{{ __('lang.address') }}</span>
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
                        <h4 class="widget-title">{{ __('lang.address_details') }}</h4>
                        <form action="{{ route('checkout.redemptionDeliveryDateSummary', $product_redemption_shops_id) }}"
                            method="post">
                            @csrf
                            <div class="add-addr" style="display: flex; flex-direction: row-reverse;">
                                <a href="#" class="btn  btn-add-front" data-toggle="modal" data-target="#basicModal"
                                    onclick="open_add_address_modal()">
                                    {{ __('lang.add_address') }}
                                </a>
                            </div>
                            <div class="grid" id="addressesCards">
                                <img src="{{ asset('loading/loading.webp') }}" height="100"
                                    style="transform: translateX(284px);border-radius: 312px;">
                            </div>
                            <input type="submit" class="btn btn-main mt-20" value="Confirm Address">
                        </form>
                    </div>
                    <div class="col-md-4">
                        <div class="product-checkout-details">
                            <div class="block">

                                <ul class="summary-prices" style="border-style: none">
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
                                                 $redemption_products = DB::table('products')->where('id',$item->product_id)->first();
                                            @endphp
                                                <tr>
                                                    <td class="text-center" style="vertical-align: middle;"><img
                                                            src="{{ $redemption_products->img_path }}" alt="" style="height: 44px;">
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


                                </ul>



                            </div>
                        </div>
                    </div>
                </div>





            </div>
        </div>
    </div>

    @include('frontend.add_address')
    <!--  -->
    @include('frontend.edit_address')

@section('javascript')
    <script>
        function getAddress(params) {
            $.ajax({
                url: "{{ route('session-updateAddress') }}",
                method: "POST",
                data: {
                    id: params,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    $('#grand_total').html('$' + (response.final_price).toFixed(2));
                    $('#checkoutShipping').html(parseFloat(response.shipping_charge).toFixed(2));
                    if (response.shipping_charge == -8) {
                        $('#shippingChargeTitle').html('Shipping Discount');
                    }
                    $('#subTotalOnCheckout').html(parseFloat(response.sub_total).toFixed(2));
                }
            })
        }

        fetchAllAddress();
    </script>
@endsection
@endsection
