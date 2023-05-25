@extends('frontend.layouts.master')
@section('title', 'LFK | Order Summary')
@section('body')

    <div class="">
        <div class="checkout shopping">
            <div class="container" style="margin-bottom: 2px;">
                <div class="progress-main">
                    <div class="circle active">
                        <span class="label">1</span>
                        <a href="#"><span class="title">{{ __('lang.order') }}</span></a>
                    </div>
                    <span class="bar done"></span>
                    <div class="circle">
                        <span class="label">2</span>
                        <a href="#"><span
                                class="title">{{ __('lang.ADDRESS') }}</span></a>
                    </div>
                    <span class="bar"></span>
                    <div class="circle ">
                        <span class="label">3</span>
                        <a href="#"><span class="title">{{ __('lang.delivery') }}</span></a>
                    </div>
                    <span class="bar"></span>
                    <div class="circle ">
                        <span class="label">4</span>
                        <a href="#"><span
                                class="title">{{ __('lang.billing') }}</span></a>
                    </div>
                    <span class="bar"></span>
                    <div class="circle">
                        <span class="label">5</span>
                        <a href="#"><span
                                class="title">{{ __('lang.done') }}</span></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <h4 class="widget-title">{{ __('lang.order') }}</h4>
                            <table class="table text-center table-bordered">
                                <thead></thead>
                                <tbody id="orderSummaryDetails">
                                        <tr>
                                            <td>
                                                <img src="{{json_decode($data->images)[0]}}" height="100" width="100" alt="">
                                            </td>
                                            <td>
                                                <span style="font-weight: bolder; font-size:large;" >{{$data->product_name}}</span>
                                            </td>
                                            <td>
                                                <span style="font-weight: bolder; font-size:large;" >{{$data->points}} Points</span>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                    </div>
                </div>
                <a href="{{route('checkout.redemptionAddressSummary',$data->id)}}" id="confirm_order_btn" class="btn btn-main mt-20">Confirm Order</a>
            </div>
        </div>
    </div>

    @section('javascript')
        <script>
            $(document).ready(function(){
                if("{{ !empty(session('back_message')) }}"){
                    toastr.error("{{ session('back_message') }}");
                }
            });
        </script>
    @endsection

@endsection
