@extends('frontend.layouts.master')
@section('title', 'LFK | ' . $category_name)
@section('body')


    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ route('AllProducts') }}">Product</a></li>
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

                                        @foreach(json_decode($v['images']) as $key => $value)
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
                                    <a class="left carousel-control" href="#carousel-custom" data-slide="prev">
                                        <i class="tf-ion-ios-arrow-left"></i>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-custom" data-slide="next">
                                        <i class="tf-ion-ios-arrow-right"></i>
                                    </a>
                                </div>

                                <!-- thumb -->
                                <ol class="carousel-indicators mCustomScrollbar meartlab">
                                    <li data-target="#carousel-custom" data-slide-to="0" class="active">
                                        <img src="{{ $v['img_path'] }}" alt="" />
                                    </li>
                                    @php $k = 0; @endphp
                                    @foreach(json_decode($v['images']) as $key => $value)
                                        <li data-target="#carousel-custom" data-slide-to="{{++$k}}">
                                            <img src="{{ $value }}" alt="" />
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="single-product-details">
                            <h2>{{ $v['product_name'] }}</h2>
                            <p class="product-price"><b id="product-price">${{ $v['min_sale_price'] }}</b></p>


                            <form action="{{ route('SA-Addtocart') }}" method="post">
                                @csrf
                                <input type="hidden" name="pid" value="{{ $v['id'] }}">
                                <div class="product-quantity">
                                    <span>Quantity:</span>
                                    <div class="product-quantity-slider">
                                        <input id="product-quantity" type="text" value="1" min="1"
                                            name="quantity" />
                                    </div>
                                </div>

                                <div class="product-category">
                                    <span>Categories:</span>
                                    <ul>
                                        <li><a href="javascript:void(0)">{{ $v['product_category'] }}</a></li>
                                    </ul>
                                </div>

                                {!! $v['description'] !!}

                                <span class="total-price"></span>
                                <a href="javascript:void(0)"
                                    class="btn btn-main mt-20 addToCartProduct" data-id="{{ $v['id'] }}">Add To
                                    Cart</a>
                                <input type="submit" value="Checkout" class="btn btn-main mt-20">
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
                <h2>new product</h2>


            </div>
        </div>
        <div class="card-slider container">

            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="product-item card">
                        <div class="product-thumb">
                            <div class="first">
                                <div class="d-flex justify-content-between align-items-center">
                                </div>
                            </div>
                            <img class="img-responsive thumbnail-image" src="{{ $product->img_path }}"
                                alt="{{ $product->product_name }}" />
                            <div class="preview-meta">
                                <ul>
                                    <li>
                                        <span data-toggle="modal" data-target="#product-modal">
                                            <a href="/product/{{ $product->product_id }}">BUY NOW</a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4><a href="/product/{{ $product->product_id }}"> {{ $product->product_name }} </a></h4>
                            <p class="price">${{ $product->min_sale_price }}</p>
                        </div>
                        <div class="text-center"><button class="add-cart addToCartProduct"
                                data-id="{{ $product->id }}">Add to Cart</button> </div>
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
