@extends('frontend.layouts.master')
@section('title', 'LFK | Cart')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li class="active">{{ __('lang.carts') }}</li>
                        
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="page-wrapper">
        <div class="cart shopping">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="block">
                            <div class="product-list">
                                <form method="post">
                                    <div class="table-responsive">
                                    <table class="table table-bordered text-center" id="cartPageTable">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    {{ __('lang.image') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('lang.item_name') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('lang.quantity') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('lang.item_price') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('lang.total_price') }}
                                                </th>
                                                <th class="text-center">
                                                    {{ __('lang.action') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartPageItem">
                                            <!--  -->
                                        </tbody>
                                    </table>
                                    </div>
                                  
                                    <div class="text-right">
                                        <span
                                            style="margin-right:20px;font-weight: 600;font-size: 16px;"> {{ __('lang.subtotal') }}
                                            (<span id="products_count"></span> item): $<span
                                                id="products_sub_total" style="font-weight: 600;font-size: 16px;"></span></span>
                                        <a href="{{ route('checkout.orderSummary') }}"
                                            class="btn btn-main pull-right">{{ __('lang.checkout_cart') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection