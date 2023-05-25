@extends('frontend.layouts.master')
@section('title', 'LFK | E-commerce Store')
@section('body')

<div class="hero-slider">
    @foreach ($banners as $banner)
    <a @if($banner->product_id != null) @if($banner->product_id != 'Select Product') href="/product/{{$banner->product_id}}" @else href="javascript:void(0)" @endif @else href="javascript:void(0)" @endif>
        <div class="slider-item th-fullpage hero-area" style="background-image: url('{{ $banner->image }}')">
            <div class="container">
            </div>
        </div>
    </a>
    @endforeach
</div>

<section class="live-countdown text-center">
    <div class="countdown-main container">
        <h2>{{ __('lang.until_the_new_live') }}</h2>
        <div class="countdown">
            <div>
                <span class="number days"></span>
                <span>{{ __('lang.days') }}</span>
            </div>
            <div>
                <span class="number hours"></span>
                <span>{{ __('lang.hours') }}</span>
            </div>
            <div>
                <span class="number minutes"></span>
                <span>{{ __('lang.minutes') }}</span>
            </div>
            <div>
                <span class="number seconds"></span>
                <span>{{ __('lang.seconds') }}</span>
            </div>
        </div>
        <div class="live-link">
            <a id="live-link" target="_blank" class="btn btn-main">{{ __('lang.live_link') }}</a>
        </div>
    </div>
    </div>
</section>
<section class="products bg-gray">
    <div class="container">
        <div class="row">
            <div class="title text-center">
                <h2>{{ __('lang.featured_products') }}</h2>
            </div>
        </div>
        <div class="row">
            @foreach($feature_products as $key=>$value)
                @php
                    $all_check_stock = DB::table('stocks')->where('product_id',$value->main_product_id)->sum('quantity');
                @endphp
            <div class="col-md-4 col-sm-4 col-xl-3 col-xxl-3">
                <div class="product-item card">
                    <div class="product-thumb">
                        <div class="first">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="first">
                                    <div class="d-flex justify-content-between align-items-center">
                                        @if ($value->discount_price != null)
                                            @if ($value->discount_price != null && $value->discount_price > 0)
                                                <span class="discount">
                                                    {{ $value->discount_percentage }}
                                                    % OFF
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="/product/{{$value->product_id}}">
                            <img class="img-responsive thumbnail-image" src="{{$value->img_path}}" alt="{{$value->product_name}}" />
                        </a>
                        {{-- <div class="preview-meta">
                            <ul>
                                <li>
                                    <span data-toggle="modal" data-target="#product-modal">
                                        <a href="/product/{{$value->product_id}}">
                                            {{ __('lang.buy_now') }}
                                        </a>
                                    </span>
                                </li>
                            </ul>
                        </div> --}}
                    </div>
                    <div class="product-content">
                        <div class="product-title" style="height: 50px;">
                            <h4><a href="/product/{{$value->product_id}}">
                                @if(app()->getLocale() == 'en')
                                    {{ $value->product_name }}
                                @else
                                    {{ $value->product_name_c }}
                                @endif
                            </a></h4>
                            <span style="color:red">@if($value->stock_check == 1)
                                ({{ __('lang.out_of_stock') }})
                            @endif</span>
                        </div>
                            @if($value->discount_price == null)
                                 <p class="price">${{ number_format($value->min_sale_price,2) }}</p>
                             @else 
                                <p class="price">
                                    <del style="color:red">${{ number_format($value->min_sale_price,2) }}</del> 
                                    ${{ number_format($value->discount_price,2) }}</p>
                            </p>
                            @endif
                            @if($value->discount_price != null) 
                                <p style="color:red;background-color:transparent; ">
                                    Promotion Period: {{ date("d-m-Y", strtotime($value->discount_start_date))  }} to {{ date("d-m-Y", strtotime($value->discount_end_date)) }}
                                </p>
                            @else
                                <p>&nbsp&nbsp&nbsp&nbsp</p>
                            @endif
                    </div>
                    <div class="text-center">
                        {{-- @if ($all_check_stock == 0)
                            <button class="add-cart" disabled>
                                {{ __('lang.add_to_cart') }}
                           </button> 
                        @else
                            <button class="add-cart addToCartProduct" data-id="{{$value->product_id}}">
                             {{ __('lang.add_to_cart') }}
                            </button> 
                        @endif --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-gray" style="overflow: hidden;margin-top: 40px;">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2>{{ __('lang.products') }}</h2>
            </div>
        </div>
        <div class="row newproducts">
            <i class="fa fa-spinner fa-spin"></i>{{ __('lang.loading') }}
        </div>
    </div>
</section>
@section('javascript')

<script>

    $(document).ready(function() {
        fetch_update_dat_time();
    });

    var newDate;
    var message;

    fetch_update_dat_time();

    function fetch_update_dat_time() {
        $.ajax({
            url: "/configuration/fetch-update-dat-time",
            type: 'get',
            dataType: 'json',
            success: function(data) {
                //   console.log(data);F
                // ==============================
                if (data.length == 0) {
                    $('.live-countdown').hide();
                } else {
                    newDate = new Date(data[0]["date"]).getTime()
                    message = data[0]["message"];

                    $('#live-link').attr('href', message);

                    if (newDate == undefined || newDate == '') {
                        alert('No Live date specified');
                    } else {

                        // ==============================
                        const countdown = setInterval(() => {

                            const date = new Date().getTime()
                            const diff = newDate - date

                            const month = Math.floor((diff % (1000 * 60 * 60 * 24 * (365.25 / 12) *
                                365)) / (1000 * 60 * 60 * 24 * (365.25 / 12)))
                            const days = Math.floor(diff % (1000 * 60 * 60 * 24 * (365.25 / 12)) / (
                                1000 * 60 * 60 * 24))
                            const hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 *
                                60))
                            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))
                            const seconds = Math.floor((diff % (1000 * 60)) / 1000)

                            document.querySelector(".seconds").innerHTML = seconds < 10 ? '0' +
                                seconds : seconds
                            document.querySelector(".minutes").innerHTML = minutes < 10 ? '0' +
                                minutes : minutes
                            document.querySelector(".hours").innerHTML = hours < 10 ? '0' + hours :
                                hours
                            document.querySelector(".days").innerHTML = days < 10 ? '0' + days :
                                days

                            if (diff < 0) {
                                clearInterval(countdown)
                                document.querySelector(".countdown-main").innerHTML = '';
                            }

                        }, 1000);
                        // ==============================
                    }
                }
            }
        });
    }

    window.history.replaceState('', document.title, window.location.pathname);
</script>
@endsection
@endsection