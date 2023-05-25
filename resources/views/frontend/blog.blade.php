@extends('frontend.layouts.master')
@section('title', 'LFK | Blog')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li class="active">{{ __('lang.blog') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="">
        <div class="title text-center">
            <h2>{{ __('lang.blog') }}</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    @foreach ($sorted as $blog)
                        <div class="post">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="post-media post-thumb">
                                        @if ($blog->status == 0)
                                            <a href="{{ route('single_blog', $blog->slug) }}">
                                                <img src="{{ asset($blog->image) }}" alt="" />
                                            </a>
                                        @else
                                            <a href="{{ route('single_blogVideo', $blog->slug) }}">
                                                <video width="320" height="240" controls autoplay loop>
                                                    <source src="{{ asset($blog->video) }}" type="video/mp4">
                                                </video>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="content">
                                        <h2 class="post-title">
                                            @if ($blog->status == 0)
                                                <a href="{{ route('single_blog', $blog->slug) }}">{{ $blog->title }}</a>
                                            @else
                                                <a
                                                    href="{{ route('single_blogVideo', $blog->slug) }}">{{ $blog->title }}</a>
                                            @endif

                                        </h2>
                                        <div class="post-meta">
                                            <ul>
                                                <li><i
                                                        class="tf-ion-ios-calendar"></i>{{ Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="post-content" style="width: 100%; overflow: hidden;">
                                            <p>
                                                {!! \Illuminate\Support\Str::limit($blog->description, 200, $end = '...') !!}
                                            </p>
                                            @if ($blog->status == 0)
                                                <a href="{{ route('single_blog', $blog->slug) }}" class="btn btn-main">
                                                    {{ __('lang.continue_reading') }}
                                                </a>
                                            @else
                                                <a href="{{ route('single_blogVideo', $blog->slug) }}" class="btn btn-main">
                                                    {{ __('lang.continue_reading') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{ $sorted->links() }}

                </div>


            </div>
        </div>


    </div>


@endsection
