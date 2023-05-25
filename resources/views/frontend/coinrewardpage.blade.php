@extends('frontend.layouts.master')
@section('title', 'LFK | Redemption Shop')
@section('body')
    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li>
                            <a href="/">{{ __('lang.home') }}</a>
                        </li>
                        <li class="active">{{ __('lang.redemption_shop') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="about">

        <div class="title text-center" style="padding:0px !important;">
            <h2>{{ __('lang.redemption_shop') }}</h2>
        </div>
        <div class="container">
            <div class="row" style="margin-top:2rem;margin-bottom:2rem">
                <div class="col-md-8 col-sm-6 mt-3">
                    <div class="daily-reward">
                        <section class="reward-inner">
                            <div class="reward-title">
                                <h4>{{ __('lang.daily_check_in') }}</h4>
                            </div>
                            <div class="reward-main">
                                <ul class="daily-check-in">
                                    <div class="coin-card">
                                        <div class="coin-card-inner @if ($day == 1) activ @endif">
                                            <span class="number">+@if (!empty($data))
                                                    {{ $data->day1 }}
                                                @endif
                                            </span>
                                            <img class="coin-img" src="{{ asset('frontend/images/Star-Coin.png') }}"
                                                height="25px">
                                        </div>
                                        <span class="coin-card-date">{{ __('lang.today') }}</span>
                                    </div>
                                    <div class="coin-card">
                                        <div class="coin-card-inner @if ($day == 2) activ @endif">
                                            <span class="number">+@if (!empty($data))
                                                    {{ $data->day2 }}
                                                @endif
                                            </span>
                                            <img class="coin-img" src="{{ asset('frontend/images/Star-Coin.png') }}"
                                                height="25px">
                                        </div>
                                        <span class="coin-card-date">Day 2</span>
                                    </div>
                                    <div class="coin-card">
                                        <div class="coin-card-inner @if ($day == 3) activ @endif">
                                            <span class="number">+@if (!empty($data))
                                                    {{ $data->day3 }}
                                                @endif
                                            </span>
                                            <img class="coin-img" src="{{ asset('frontend/images/Star-Coin.png') }}"
                                                height="25px">
                                        </div>
                                        <span class="coin-card-date">Day 3</span>
                                    </div>
                                    <div class="coin-card">
                                        <div class="coin-card-inner @if ($day == 4) activ @endif">
                                            <span class="number">+@if (!empty($data))
                                                    {{ $data->day4 }}
                                                @endif
                                            </span>
                                            <img class="coin-img" src="{{ asset('frontend/images/Star-Coin.png') }}"
                                                height="25px">
                                        </div>
                                        <span class="coin-card-date">Day 4</span>
                                    </div>
                                    <div class="coin-card">
                                        <div class="coin-card-inner @if ($day == 5) activ @endif">
                                            <span class="number">+@if (!empty($data))
                                                    {{ $data->day5 }}
                                                @endif
                                            </span>
                                            <img class="coin-img" src="{{ asset('frontend/images/Star-Coin.png') }}"
                                                height="25px">
                                        </div>
                                        <span class="coin-card-date">Day 5</span>
                                    </div>
                                    <div class="coin-card">
                                        <div class="coin-card-inner @if ($day == 6) activ @endif">
                                            <span class="number">+@if (!empty($data))
                                                    {{ $data->day6 }}
                                                @endif
                                            </span>
                                            <img class="coin-img" src="{{ asset('frontend/images/Star-Coin.png') }}"
                                                height="25px">
                                        </div>
                                        <span class="coin-card-date">Day 6</span>
                                    </div>
                                    <div class="coin-card">
                                        <div class="coin-card-inner @if ($day == 7) activ @endif">
                                            <span class="number">+@if (!empty($data))
                                                    {{ $data->day7 }}
                                                @endif
                                            </span>
                                            <img class="coin-img" src="{{ asset('frontend/images/Star-Coin.png') }}"
                                                height="25px">
                                        </div>
                                        <span class="coin-card-date">Day 7</span>
                                    </div>
                                </ul>
                                @if (!Auth::check())
                                    <a href="{{ route('login-with-us') }}"><button data-inactive="false"
                                            data-smallsize="false"
                                            class="check-in-btn">{{ __('lang.sign_in_to_earn') }}</button></a>
                                @else
                                    <a
                                        @if ($status != true) href="javascript:void(0)" @else href="{{ route('checkIn.now') }}" @endif><button
                                            data-inactive="false" data-smallsize="false" class="check-in-btn">
                                            @if ($status != true) Come again
                                                tomorrow
                                            @else
                                                {{ __('lang.check_in_today_to_get_points') }}
                                            @endif
                                        </button></a>
                                @endif

                            </div>
                        </section>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mt-3">
                    <div class="coin-img">
                        <img src="{{ asset('frontend/images/coin-img.jpg') }}" alt=""
                            style="width:400px;height:26rem; border-radius: 10px !important;">
                        <div class="coin-text" style="position:absolute;top:70%;left:10%">
                            <h1 style="font-weight:700; color:white;">{{ __('lang.wallet_points') }}</h1>
                            @if (!empty($user))
                                <h2 style="font-weight:700; color:white;">
                                    @if ($user->loyalty_points > 0)
                                        {{ $user->loyalty_points }}
                                    @else
                                        0 @endif {{ __('lang.points') }}
                                </h2>
                            @else
                                <h2 style="font-weight:700; color:white;">0 {{ __('lang.points') }}</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <section style="overflow:hidden;margin-top:40px">
                <div class="container">
                    <div class="row">
                        <div class="title">
                            <h2>{{ __('lang.products') }}</h2>
                        </div>
                    </div>
                    <div class="row">


                        @foreach ($redemption_products as $key => $value)
                            <div class="col-md-3">
                                <div class="product-item card">
                                    <div class="product-thumb">
                                        <div class="first">
                                            <div class="d-flex justify-content-between align-items-center">

                                            </div>
                                        </div>
                                        <img class="img-responsive thumbnail-image"
                                            src="{{ json_decode($value->images)[0] }}" height="158.95px" width="262.5px" />
                                        <div class="preview-meta">
                                            <ul>
                                                <li>
                                                    @if (!empty($user))
                                                        @if ($user->loyalty_points >= $value->points)
                                                            <span data-toggle="modal" data-target="#product-modal">
                                                                <a
                                                                    href="{{ route('checkout.redemptionOrderSummary', $value->id) }}"> {{ __('lang.BUY_NOW') }}
                                                                </a>
                                                            </span>
                                                        @else
                                                            <span>
                                                                <a href="javascript:void(0)" id="point_not_avaliable">{{ __('lang.BUY_NOW') }}
                                                                </a>
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span>
                                                            <a href="javascript:void(0)" id="point_not_avaliable">{{ __('lang.BUY_NOW') }}
                                                            </a>
                                                        </span>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-content" style="padding-bottom: 20px;">
                                        <h4><a href="javascript:void(0)">{{ $value->product_name }}</a></h4>
                                        <p class="price">{{ $value->points }} {{ __('lang.points') }}</p>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="discount-secion">
                <div class="container">
                    <div class="row">
                        <div class="title">
                            <h2>{{ __('lang.voucher') }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($vouchers as $key => $value)
                            @if ($value->expiry_date <= date('Y-m-d'))
                                <a href="{{ route('checkout.voucherGenerator', $value->id) }}">
                                    <div class="col-md-4 mtb-3">
                                        <div class="discount-coupan dark-yellow"
                                            style="display:flex; background:url('{{ $value->image }}');">
                                            <div class="img-content">
                                                <p style="font-size: 2em; font-weight:bolder; color:red;">
                                                    @if ($value->discount_type != 'discount_by_precentage_btn')
                                                        ${{ $value->discount }} Discount
                                                    @else
                                                        {{ $value->discount }}% Discount
                                                    @endif
                                                </p>
                                                <p style="font-size: 2em; font-weight:bolder; color:red;">
                                                    ON
                                                </p>
                                                <p style="font-size: 3em; font-weight:bolder; color:red;">
                                                    {{ $value->points }} {{ __('lang.points') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            @endif
                        @endforeach

                    </div>
                </div>
            </section>
        </div>
    </section>
@section('javascript')

    <script>
        $(document).on('click', '#discount_code', function() {
            var code_is = $(this);
            code_is.select();
            navigator.clipboard.writeText(code_is.val());
            toastr.success(code_is.val() + ' Copied');
        })

        $('#point_not_avaliable').click(function() {
            toastr.error("Point Not Avaliable");
        })

        $(document).ready(function() {
            if ("{{ !empty(session('back_message')) }}") {
                toastr.error("{{ session('back_message') }}");
            }
        });
    </script>

@endsection
@endsection
