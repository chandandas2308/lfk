@extends('frontend.layouts.master')
@section('title', 'LFK | My Orders ')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li class="active">{{ __('lang.my_orders') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="" style="margin-bottom: 40px;">
        <div class="title text-center">
            <h2>{{ GoogleTranslate::trans('My Orders', app()->getLocale()) }}</h2>
        </div>
        <div class="container">


            <div class="container">



                <div class="tab-content">
                    <div class="tab-content">
                        <div id="pending" class="tab-pane fade in active">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="card">
                                        <ul class="user-profile-list-main bg-main" style="padding:30px; margin-top: 70px;">
                                            <li class="underline"><a href="{{ route('user.loyality-points') }}"
                                                    class="underline-a-{{ request()->is('/user/loyality-point') ? 'active' : '' }}">{{ GoogleTranslate::trans('Loyalty Points', app()->getLocale()) }}</a>
                                            </li>
                                            <li class="underline"><a href="{{ route('user.my_voucher') }}"
                                                    class="underline-a-{{ request()->is('/user/my-voucher') ? 'active' : '' }}">{{ GoogleTranslate::trans('My Vouchers', app()->getLocale()) }}</a>
                                            </li>
                                            <li class="underline"><a href="{{ route('user.Address') }}"
                                                    class="underline-a-{{ request()->is('/user/address') ? 'active' : '' }}">{{ GoogleTranslate::trans('Address', app()->getLocale()) }}</a>
                                            </li>
                                            <li class="underline"><a href="{{ route('user.my-orders') }}"
                                                    class="underline-a-{{ request()->is('/user/my-orders') ? 'active' : '' }}">{{ GoogleTranslate::trans('My Orders', app()->getLocale()) }}</a>
                                            </li>
                                            <li class="underline"><a href="{{ route('user.order-history') }}"
                                                    class="underline-a-{{ request()->is('/user/historyorder') ? 'active' : '' }}">{{ GoogleTranslate::trans('Order History', app()->getLocale()) }}</a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="col-md-10">
                                    <div class="dashboard-wrapper user-dashboard">
                                        <div class="table-responsive">
                                            <table id="userPandingOrderSelfTable" style="width:100%;">
                                                <thead style="background-color: #fac0a4;">
                                                    <tr>
                                                        <th>{{ GoogleTranslate::trans('S/N', app()->getLocale()) }}</th>
                                                        <th>{{ GoogleTranslate::trans('Order ID', app()->getLocale()) }}
                                                        </th>
                                                        <th>{{ GoogleTranslate::trans('Name', app()->getLocale()) }}</th>
                                                        <th>{{ GoogleTranslate::trans('Mobile Number', app()->getLocale()) }}
                                                        </th>
                                                        <th>{{ GoogleTranslate::trans('Payment Term', app()->getLocale()) }}
                                                        </th>
                                                        <th>{{ GoogleTranslate::trans('Order Price', app()->getLocale()) }}
                                                        </th>
                                                        <th>{{ GoogleTranslate::trans('Delivery Date', app()->getLocale()) }}
                                                        </th>
                                                        <th>{{ GoogleTranslate::trans('Address', app()->getLocale()) }}</th>
                                                        <th>{{ GoogleTranslate::trans('Status', app()->getLocale()) }}</th>
                                                        <th>{{ GoogleTranslate::trans('Remark', app()->getLocale()) }}</th>
                                                        <th>{{ GoogleTranslate::trans('Action', app()->getLocale()) }}</th>
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

    <div class="modal fade" id="viewOrderDetails3" tabindex="-1" role="dialog" aria-labelledby="viewOrderDetails3"
        aria-hidden="true">
        <div class="modal-dialog my-auto">
            <div class="modal-content" id="viewOrderDetailsData2">

            </div>
        </div>
    </div>

    <button class="btn btn-primary" style="display: none;" data-toggle="modal" id="viewMyOrderBtn"
        data-target="#viewOrderDetails3">View Btn</button>

    <script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js"></script>
    <script src="{{ asset('frontend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
        integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            addresses = $('#userPandingOrderSelfTable').DataTable({
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
                pageLength: 5,
                // responsive: 'false',
                dom: "Bfrtip",
                ajax: {
                    url: "{{ route('user.listorder') }}",
                    type: 'get',
                    data: {
                        id: 1
                    }
                },
            })
        });


        $(document).on('click', '#viewOrderDetails', function() {
            var classIs = $(this)[0].className.split(' ').reverse()[0];

            $.ajax({
                url: "{{ route('user.consolidateOrdersDetails') }}",
                method: "GET",
                data: {
                    id: $(this).data('id')
                },
                beforeSend: function() {
                    $('.' + classIs).html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    $('.' + classIs).html('View');
                    $('#viewMyOrderBtn').click();
                    $('#viewOrderDetailsData2').html(response);
                }
            })
        })
    </script>

@endsection
