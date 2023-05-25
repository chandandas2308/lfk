@extends('frontend.layouts.master')
@section('title','LFK | Blog')
@section('body')

<section class="bg-gray page-header">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <ol class="breadcrumb">
            <li><a href="/">{{ __('lang.home') }}</a></li>
            <li><a href="{{ route('blog') }}">{{ __('lang.blog') }}</a></li>
            <li class="active">{{$blogVideo->title }}</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="post post-single">
            <div class="post-thumb">
             

                <video class="img-responsive"  style="max-height: 500px; width: 100%; border-radius: 20px;" controls autoplay loop>  
                <source src="{{ asset($blogVideo->video) }}" type="video/mp4">  
              </video> 
            </div>
            <h2 class="post-title">{{ $blogVideo->title }}</h2>
            <div class="post-meta">
              <ul>
                <li><i class="tf-ion-ios-calendar"></i>{{ Carbon\Carbon::parse($blogVideo->created_at)->diffForHumans() }}</li>
              </ul>
            </div>
            <div class="post-content post-excerpt">
              <p>
                {!! $blogVideo->description !!}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection