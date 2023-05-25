@extends('frontend.layouts.master')
@section('title', 'LFK | Loyalty Points')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li class="active">{{ __('lang.loyalty_points') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="" style="margin-bottom: 40px;">
        <div class="title text-center">
            <h2>{{ __('lang.loyalty_points') }}</h2>
        </div>
        <div class="container">


            <div class="container">



                <div class="tab-content">
                    <div id="menu4" class="tab-pane fade in active">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="card">
                                    <ul class="user-profile-list-main bg-main" style="padding:30px; margin-top: 70px;">
                                        <li class="underline"><a href="{{ route('user.loyality-points') }}"
                                                class="underline-a-{{ request()->is('/user/loyality-point') ? 'active' : '' }}">{{ __('lang.loyalty_points') }}</a>
                                        </li>
                                        <li class="underline"><a href="{{ route('user.my_voucher') }}"
                                                    class="underline-a-{{ request()->is('/user/my-voucher') ? 'active' : '' }}">{{ __('lang.my_vouchers') }}</a>
                                        </li>
                                        <li class="underline"><a href="{{ route('user.Address') }}"
                                                class="underline-a-{{ request()->is('/user/address') ? 'active' : '' }}">{{ __('lang.address') }}</a>
                                        </li>
                                        <li class="underline"><a href="{{ route('user.my-orders') }}"
                                                class="underline-a-{{ request()->is('/user/my-orders') ? 'active' : '' }}">{{ __('lang.my_orders') }}</a>
                                        </li>
                                        <li class="underline"><a href="{{ route('user.order-history') }}"
                                                class="underline-a-{{ request()->is('/user/historyorder') ? 'active' : '' }}">{{ __('lang.order_history') }}</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                            <div class="col-md-10">
                                <div class="dashboard-wrapper user-dashboard">
                                    <div class="table-responsive">
                                        <table id="loyalty_points_details_table" style="width:100%;">
                                            <thead style="background-color: #fac0a4;">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>{{ GoogleTranslate::trans('Gained Points', app()->getLocale()) }}
                                                    </th>
                                                    <th>{{ GoogleTranslate::trans('Spend Points', app()->getLocale()) }}
                                                    </th>
                                                    <th>{{ GoogleTranslate::trans('Remaining Points', app()->getLocale()) }}
                                                    </th>
                                                    <th>{{ GoogleTranslate::trans('Transaction Date', app()->getLocale()) }}
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
        integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            loyalty_points_details_table = $('#loyalty_points_details_table').DataTable({
                "aaSorting": [],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                language: {
                    'paginate': {
                        'previous': '<span class="prev-icon"></span>',
                        'next': '<span class="next-icon"></span>'
                    },
                    search: "{{ __('lang.search') }}",
                    "emptyTable": "{{ __('lang.no_data_table') }}",
                },
                // responsive: 'false',
                dom: "Bfrtip",
                ajax: {
                    url: "{{ route('user.loyaltyPoints') }}",
                    type: 'get'
                },
            })
        });
    </script>

@endsection
