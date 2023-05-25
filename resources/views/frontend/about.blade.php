@extends('frontend.layouts.master')
@section('title', 'LFK | About Us')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li class="active">{{ __('lang.about_us') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-responsive" src="{{ asset('frontend/images/new-img/about.jpg') }}" />
                </div>
                <div class="col-md-6">
                    <h2 class="mt-40">{{ __('lang.about_our_shop') }}</h2>
                    <p>
                    {{ GoogleTranslate::trans('LFK Singapore is a retail and wholesaler for numerous Korean brands. The company specialises in
                        cookware, kitchenware, food and beverages products suitable for all households. LFK Singapore is
                        headquartered in Singapore, distributing products in Southeast Asia region.
                        Established in 2008, with a humble beginning of retailing in wet markets, currently, the company
                        consists of 30+ employees, focusing on providing our clients and customers with the best goods and
                        services.', app()->getLocale()) }}
                    </p>
                </div>
            </div>
        </div>
    </section>

@endsection
