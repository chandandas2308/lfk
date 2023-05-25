@extends('frontend.layouts.master')
{{-- @section('title', 'LFK | ' . $category_name) --}}
@section('title', 'LFK | ' . $product_name)
@section('body')


    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li><a href="{{ route('AllProducts') }}">{{ __('lang.products') }}</a>
                        </li>
                        <li class="active">{{ $category_name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    @foreach ($data as $k => $v)
        <section class="single-product">
            <div class="container">
                <div class="row mt-20">
                    <div class="col-md-5">
                        <div class="single-product-slider">
                            <div id="carousel-custom" class="carousel slide" data-ride="carousel">
                                <div class="carousel-outer">
                                    <div class="first">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($v['discount_price'] != null)
                                                @if ($v['discount_price'] != null && $v['discount_price'] > 0)
                                                    <span class="discount">
                                                        {{ $v['discount_percentage'] }}
                                                        % OFF
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <!-- me art lab slider -->
                                    <div class="carousel-inner">

                                        <div class="item active">
                                            <div class="first">
                                                <div class="d-flex justify-content-between align-items-center">

                                                    @php
                                                        $wishlist = (bool) $v['wishlist'];
                                                        
                                                        if ($v['wishlist'] == 'true') {
                                                            $class = 'fa fa-heart';
                                                            $url = '/wishlist/remove-wishlist/' . $v['id'];
                                                        } else {
                                                            $class = 'fa fa-heart-o';
                                                            $url = '/wishlist/store-wishlist/' . $v['id'];
                                                        }
                                                    @endphp

                                                </div>
                                            </div>
                                            <img src="{{ $v['img_path'] }}" alt=""
                                                data-zoom-image="{{ $v['img_path'] }}" />
                                        </div>

                                        @foreach (json_decode($v['images']) as $key => $value)
                                            <div class="item">
                                                <div class="first">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                    </div>
                                                </div>
                                                <img src="{{ $value }}" alt="{{ $value }}"
                                                    data-zoom-image="{{ $value }}" />
                                            </div>
                                        @endforeach

                                    </div>

                                    <!-- sag sol -->
                                    <a class="left carousel-control" data-target="#carousel-custom" data-slide="prev">
                                        <i class="tf-ion-ios-arrow-left"></i>
                                    </a>
                                    <a class="right carousel-control" data-target="#carousel-custom" data-slide="next">
                                        <i class="tf-ion-ios-arrow-right"></i>
                                    </a>
                                </div>

                                <!-- thumb -->
                                <ol class="carousel-indicators mCustomScrollbar meartlab">
                                    <li data-target="#carousel-custom" data-slide-to="0" class="active">
                                        <img src="{{ $v['img_path'] }}" alt="" />
                                    </li>
                                    @php $k = 0; @endphp
                                    @foreach (json_decode($v['images']) as $key => $value)
                                        <li data-target="#carousel-custom" data-slide-to="{{ ++$k }}">
                                            <img src="{{ $value }}" alt="" />
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                    @php
                        $check_stock = DB::table('stocks')
                            ->where('product_id', $v->id)
                            ->sum('quantity');
                    @endphp
                    <div class="col-md-7">
                        <div class="single-product-details">

                            @if (app()->getLocale() == 'en')
                                <h2>{{ $v['product_name'] }}</h2>
                            @else
                                <h2>{{ $v['chinese_product_name'] }}</h2>
                            @endif

                            <form action="{{ route('SA-Addtocart') }}" method="post">

                                <div class="product-category">
                                    <span>Price:</span>
                                    @if ($v['discount_price'] == null)
                                        <span class="price">${{ number_format($v['min_sale_price'], 2) }}</span>
                                    @else
                                        <del style="color:red">${{ $v['min_sale_price'] }}</del>
                                        <span class="price">${{ number_format($v['discount_price'], 2) }}</span>
                                    @endif
                                    @if ($v['discount_price'] != null)
                                        <p style="color:red;background-color:transparent; ">
                                            Promotion Period: {{ date('d-m-Y', strtotime($v['discount_start_date'])) }} to
                                            {{ date('d-m-Y', strtotime($v['discount_end_date'])) }}
                                        </p>
                                    @endif
                                </div>

                                @csrf
                                <input type="hidden" name="pid" value="{{ $v['id'] }}">
                                <div class="product-quantity">
                                    <span>{{ __('lang.quantity') }}:</span>
                                    <div class="product-quantity-slider">
                                        <input id="product-quantity" type="text" value="1" min="1"
                                            name="quantity" style="text-align: center;" />
                                    </div>
                                </div>
                                @if ($v['stock_check'] == 1)
                                    <span style="color: red">({{ __('lang.out_of_stock') }})</span>
                                @endif

                                <div class="product-category">
                                    <span>{{ __('lang.category') }}:</span>
                                    @php
                                        $product_category = DB::table('categories')
                                            ->where('id', $v['product_category'])
                                            ->first();
                                    @endphp
                                    {{-- {{ $v['product_category'] }} --}}
                                    {{ $product_category->name ?? '' }}
                                </div>

                                <div class="product-category">
                                    <span style="width: 100%;">{{ __('lang.product_description') }}:</span>
                                </div>
                                {!! $v['description'] !!}

                                <span class="total-price"></span>
                                <br>

                                {{-- @if ($check_stock > 0)
                                    <a href="javascript:void(0)" class="btn btn-main mt-20 addToCartProduct"
                                        data-id="{{ $v['id'] }}">
                                        {{ __('lang.add_to_cart') }}
                                    </a>
                                    <input type="submit" value="{{ __('lang.checkout') }}" class="btn btn-main mt-20">
                                @endif --}}
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    <section class="bg-gray" style="overflow-x: hidden;margin-top: 40px;">
        <div class="row">
            <div class="title">
                <h2>{{ __('lang.recommended_products') }}</h2>


            </div>
        </div>
        <div class="card-slider container">

            @foreach ($products as $product)
                {{-- @foreach ($rc_product as $product) --}}
                @php
                    $all_check_stock = DB::table('stocks')
                        ->where('product_id', $product->main_product_id)
                        ->sum('quantity');
                @endphp
                <div class="col-md-4">
                    <div class="product-item card">
                        <div class="product-thumb">
                            <div class="first">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="first">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($product->discount_price != null)
                                                @if ($product->discount_price != null && $product->discount_price > 0)
                                                    <span class="discount">
                                                        {{ $product->discount_percentage }}
                                                        % OFF
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="/product/{{ $product->product_id }}">
                                <img class="img-responsive thumbnail-image" src="{{ $product->img_path }}"
                                    alt="{{ $product->product_name }}" />
                            </a>
                            {{-- <div class="preview-meta">
                                <ul>
                                    <li>
                                        <span data-toggle="modal" data-target="#product-modal">
                                            <a href="/product/{{ $product->product_id }}">
                                                {{ __('lang.BUY_NOW') }}
                                            </a>
                                        </span>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="product-content">
                            <div class="product-title" style="height: 50px;">
                                <h4><a href="/product/{{ $product->product_id }}">
                                        <!-- product_name_c -->
                                        @if (app()->getLocale() == 'en')
                                            {{ $product->product_name }}
                                        @else
                                            {{ $product->product_name_c }}
                                        @endif
                                    </a></h4>
                                @if ($product->stock_check == 1)
                                    <span style="color: red">({{ __('lang.out_of_stock') }})</span>
                                @endif
                            </div>

                            @if ($product->discount_price == null)
                                <p class="price">${{ number_format($product->min_sale_price, 2) }}</p>
                            @else
                                <p class="price">
                                    <del style="color:red">${{ number_format($product->min_sale_price, 2) }}</del>
                                    ${{ number_format($product->discount_price, 2) }}
                                </p>
                                </p>
                            @endif
                            @if ($product->discount_price != null)
                                <p style="color:red;background-color:transparent; ">

                                    {{ date('d-m-Y', strtotime($product->discount_start_date)) }} to
                                    {{ date('d-m-Y', strtotime($product->discount_end_date)) }}
                                </p>
                            @else
                                <p>&nbsp&nbsp&nbsp&nbsp</p>
                            @endif
                        </div>
                        <div class="text-center">
                            {{-- @if ($all_check_stock > 0)
                                <button class="add-cart addToCartProduct" data-id="{{ $product->product_id }}">
                                    {{ __('lang.add_to_cart') }}
                                </button>
                            @else
                                <button class="add-cart" disabled data-id="{{ $product->product_id }}">
                                    {{ __('lang.add_to_cart') }}
                                </button>
                            @endif --}}

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
    <script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $('.carousel-control.left').click(function() {
            $('#carousel-custom').carousel('prev');
        });

        $('.carousel-control.right').click(function() {
            $('#carousel-custom').carousel('next');
        });
    </script>
@endsection
