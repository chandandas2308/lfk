{{-- @extends('frontend.layouts.master')
@section('title', 'LFK | Products')
@section('body') --}}
<style>
    /*Fun begins*/
    .tab_container {
        width: 90%;
        margin: 0 auto;

        position: relative;
    }

    .tab_container input,
    .tab_container section {
        clear: both;
        padding-top: 10px;
        display: none;
    }

    .tab_container label {
        font-weight: 700;
        font-size: 18px;
        display: block;
        float: left;
        width: 33.33%;
        padding: 1.5em;
        color: #757575;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        background: #ffffff;
        border-bottom: 2px solid #aaaaaa;
    }

    #tab1:checked~#content1,
    #tab2:checked~#content2,
    #tab3:checked~#content3,
    #tab4:checked~#content4,
    #tab5:checked~#content5 {
        display: block;
        padding: 20px;
        background: #fff;
        color: #999;
    }


    .tab_container .tab-content h3 {
        text-align: center;
    }

    .tab_container [id^="tab"]:checked+label {
        background: #fff;
        border-bottom: 2px solid #ec1c24;
    }




    /*Media query*/
    @media only screen and (max-width: 930px) {
        .tab_container label span {
            font-size: 14px;
        }

    }

    @media only screen and (max-width: 769px) {

        .earncoin {
            justify-content: left !important;
            padding-left: 20px;
        }
    }

    @media only screen and (max-width: 768px) {


        .tab_container {
            width: 98%;
        }
    }

    /*Content Animation*/
    @keyframes fadeInScale {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .coinn-main {
        display: flex;
    }

    .total-coin {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .coin-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 10px;
    }

    .coin-content span {
        font-size: 16px;
        color: #757575;
    }

    .earncoin {
        height: 5em;
        display: flex;
        align-items: center;
        justify-content: end;
    }

    .earncoin span {
        font-size: 20px !important;
        color: #f28d03;
        font-size: 600;
    }

    .daily-check-in {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #f0f0f0;
        animation: fadeInScale 0.7s ease-in-out;
    }

    .daily-check-in .left {
        display: flex;
        align-items: center;

    }

    .daily-check-in .left .content {
        display: flex;
        flex-direction: column;

    }

    .daily-check-in .left .content span {
        color: #757575;
    }

    .daily-check-in .right span {
        font-size: 20px;
        color: #f28d03;
        font-weight: 600;
    }
</style>

<body id="body">

    <section class="" style="margin-bottom: 40px;">
        {{-- <div class="title text-center">
            <h2>LFk Wallet</h2>
        </div> --}}
        @php
            $final_total_point = DB::table('loyalty_pointshops')->where('user_id',Auth::user()->id)->first();
        @endphp
        <div class="container">
            <div class="row">
                <div class="coin-top">
                    <div class="col-md-8 col-sm-6">
                        <div class="coinn-main">
                            <div class="total-coin">
                                <img src="{{ asset('frontend/images/Star-Coin.png') }}" alt="" height="70">
                                <span
                                    style="font-size: 30px; color: #fcc200;">{{ $final_total_point->loyalty_points }}</span>
                            </div>

                            <div class="coin-content">
                                <span>Points avialble</span>
                                <span>{{ $final_total_point->loyalty_points }} Points</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="contact-section">
            <div class="tab_container">
                <input id="tab1" type="radio" name="tabs" checked>
                <label for="tab1"><span>HISTORY</span></label>

                <input id="tab2" type="radio" name="tabs">
                <label for="tab2"><span>EARNING</span></label>

                <input id="tab3" type="radio" name="tabs">
                <label for="tab3"><span>SPENDING</span></label>



                <section id="content1" class="tab-content">
                    @php
                        $list_points = DB::table('loyalty_points')
                            ->where('user_id', Auth::user()->id)
                            ->get();
                    @endphp
                    @foreach ($list_points as $item)
                    @if ($item->gained_points > 0)
                        <div class="daily-check-in">
                            <div class="left">
                                <div class="img">
                                    <img src="{{ asset('frontend/images/Star-Coin.png') }}" alt=""
                                        height="100">
                                </div>
                                <div class="content">
                                    <span>{{ $item->log }}</span>
                                    <span>coin reward from {{ $item->log }}</span>
                                    <span>{{ $item->created_at }}</span>
                                </div>

                            </div>
                            <div class="right">
                                <span>+{{ $item->gained_points }}
                                </span>
                            </div>
                        </div>
                        @endif
                        @if ($item->spend_points > 0)
                            <div class="daily-check-in">
                                <div class="left">
                                    <div class="img">
                                        <img src="{{ asset('frontend/images/Star-Coin.png') }}" alt=""
                                            height="100">
                                    </div>
                                    <div class="content">
                                        <span>{{ $item->log }}</span>
                                        <span>coin reward from {{ $item->log }}</span>
                                        <span>{{ $item->created_at }}</span>
                                    </div>

                                </div>
                                <div class="right">
                                    <span>-{{ $item->spend_points }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </section>

                <section id="content2" class="tab-content">
                    @foreach ($list_points as $item)
                        @if ($item->gained_points > 0)
                            <div class="daily-check-in">
                                <div class="left">
                                    <div class="img">
                                        <img src="{{ asset('frontend/images/Star-Coin.png') }}" alt=""
                                            height="100">
                                    </div>
                                    <div class="content">
                                        <span>{{ $item->log }}</span>
                                        <span>coin reward from {{ $item->log }}</span>
                                        <span>{{ $item->created_at }}</span>
                                    </div>

                                </div>
                                <div class="right">
                                    <span>+{{ $item->gained_points }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </section>

                <section id="content3" class="tab-content">
                    @foreach ($list_points as $item)
                        @if ($item->spend_points > 0)
                            <div class="daily-check-in">
                                <div class="left">
                                    <div class="img">
                                        <img src="{{ asset('frontend/images/Star-Coin.png') }}" alt="" height="100">
                                    </div>
                                    <div class="content">
                                        <span>{{ $item->log }}</span>
                                        <span>coin reward from {{ $item->log }}</span>
                                        <span>{{ $item->created_at }}</span>
                                    </div>

                                </div>
                                <div class="right">
                                    <span>-{{ $item->spend_points }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </section>


            </div>
            <!-- end container -->
        </div>
    </section>

    {{-- @endsection --}}
