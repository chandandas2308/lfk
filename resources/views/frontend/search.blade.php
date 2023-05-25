@extends('frontend.layouts.master')
@section('title','LFK | Products')
@section('body')

<section class="bg-gray page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="/">{{ __('lang.home') }}</a></li>
                    <li class="active">{{ GoogleTranslate::trans('Result', app()->getLocale()) }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="products" style="overflow: hidden;">
    <div class="row">
        <div class="title text-center">
            <h2>{{ GoogleTranslate::trans('Result', app()->getLocale()) }}</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    @if(sizeof( $data) > 0)

                    
                   @foreach($data as $key => $value)
                   <div class="col-md-4 col-sm-6">
                        <div class="product-item card">
                            <div class="product-thumb">
                                <!-- <div class="first">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="wishlist"><i class="fa fa-heart-o" id="wishlist" data-id="{{$value->id}}"></i></span>
                                    </div>
                                </div> -->
                                <img class="img-responsive thumbnail-image" src="{{$value->img_path}}" alt="{{$value->product_name}}" />
                                <div class="preview-meta">
                                <ul>
                                    <li>
                                    <span data-toggle="modal" data-target="#product-modal">
                                        <a href="/product/{{$value->product_id}}">
                                            {{ __('lang.buy_now') }}
                                        </a>
                                    </span>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            <div class="product-content">
                                <h4><a href="/product/{{$value->product_id}}">{{$value->product_name}}</a></h4>
                                <p class="price">{{$value->min_sale_price}}</p>
                            </div>
                            <div class="text-center"><button class="add-cart addToCartProduct" data-id="{{$value->product_id}}">
                                {{ __('lang.add_to_cart') }}
                            </button> </div>
                        </div>
                    </div>
                   @endforeach
@else
<span style="color:red">No record found</span>
@endif
                </div>

                <div class="text-center">
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<script>
    var lowerSlider = document.querySelector('#lower');
    var upperSlider = document.querySelector('#upper');

    document.querySelector('#two').value = upperSlider.value;
    document.querySelector('#one').value = lowerSlider.value;

    var lowerVal = parseInt(lowerSlider.value);
    var upperVal = parseInt(upperSlider.value);

    upperSlider.oninput = function () {
      lowerVal = parseInt(lowerSlider.value);
      upperVal = parseInt(upperSlider.value);

      if (upperVal < lowerVal + 4) {
        lowerSlider.value = upperVal - 4;
        if (lowerVal == lowerSlider.min) {
          upperSlider.value = 4;
        }
      }
      document.querySelector('#two').value = this.value
    };

    lowerSlider.oninput = function () {
      lowerVal = parseInt(lowerSlider.value);
      upperVal = parseInt(upperSlider.value);
      if (lowerVal > upperVal - 4) {
        upperSlider.value = lowerVal + 4;
        if (upperVal == upperSlider.max) {
          lowerSlider.value = parseInt(upperSlider.max) - 4;
        }
      }
      document.querySelector('#one').value = this.value
    }; 

  </script>


@endsection