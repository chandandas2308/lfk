@extends('frontend.layouts.master')
@section('title', 'LFK | My Profile')
@section('body')

<style>
    .dropdown-menu{
        padding: 0 !important;
    }
</style>

<section class="bg-gray page-header">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li><a href="/">{{ __('lang.home') }}</a>
                    </li>
                    <li class="active">{{ __('lang.my_profile') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="title text-center">
    <h2>{{ __('lang.my_profile') }}</h2>
</div>
<div class="container">
    <div>
        <div class="row">
            <div class="col-12">
                <div class=" mt-2 d-flex flex-row-reverse">
                    <a href="#" class="btn  btn-add-front" data-toggle="modal" data-target="#updateProfile">
                        {{ __('lang.edit') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="dashboard-wrapper dashboard-user-profile">
                    <div class="media">
                        <div class="pull-left text-center" href="#!">
                            <img class="media-object user-img" src="{{ Auth::User()->image != null ? Auth::User()->image : asset('frontend/images/avater.jpg') }}" alt="Profile" />
                        </div>
                        <div class="media-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="user-profile-list">
                                        <li><span>{{ GoogleTranslate::trans('Full Name', app()->getLocale()) }}
                                                :</span> {{ Auth::User()->name }} </li>
                                        <li><span>{{ GoogleTranslate::trans('Email', app()->getLocale()) }}
                                                :</span> {{ Auth::User()->email }} </li>
                                        <li><span>{{ GoogleTranslate::trans('Phone No', app()->getLocale()) }}.
                                                :</span>
                                            @php
                                            $data = DB::table('addresses')
                                            ->where('user_id', Auth::user()->id)
                                            ->first();
                                            @endphp
                                            {{ !empty(Auth::User()->phone_number) ? Auth::User()->phone_number : ($data ? $data->mobile_number : '--') }}
                                        </li>
                                    </ul>
                                </div>

                                <!-- <div class="col-md-6">
                                    <ul class="user-profile-list-main">
                                        <li><a href="{{ route('user.loyality-points') }}">{{ GoogleTranslate::trans('Loyalty Points', app()->getLocale()) }}</a>
                                        </li>
                                        <li><a href="{{ route('user.my_voucher') }}">{{ GoogleTranslate::trans('My Vouchers', app()->getLocale()) }}</a></li>
                                        <li><a href="{{ route('user.Address') }}">{{ GoogleTranslate::trans('Address', app()->getLocale()) }}</a>
                                        </li>
                                        <li><a href="{{ route('user.order-history') }}">{{ GoogleTranslate::trans('Order History', app()->getLocale()) }}</a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="user-dashboard" style="margin-bottom: 40px;">
    <div class="container">
        <!-- <div class="container"><div> -->
        <ul class="nav nav-pills text-center list-inline dashboard-menu text-center">
            <li class=" nav-item active"><a data-toggle="pill" href="#menu4">{{ GoogleTranslate::trans('Order History', app()->getLocale()) }}</a></li>
            <li><a data-toggle="pill" href="#menu3">{{ GoogleTranslate::trans('Address', app()->getLocale()) }}</a></li>
            <li class="">
                <a class="nav-link" data-toggle="tab" role="tab"  href="#menu1">{{ GoogleTranslate::trans('Loyalty Points', app()->getLocale()) }}</a></li>
            <li><a data-toggle="pill" href="#menu2">{{ GoogleTranslate::trans('My Vouchers', app()->getLocale()) }}</a></li>
        </ul>
        <div class="tab-content">
            <div id="menu1" class="tab-pane ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-wrapper user-dashboard">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-11">
                                        <div class="dashboard-wrapper user-dashboard">
                                            {{-- <div class="table-responsive"> --}}
                                                {{-- <table id="loyalty_points_details_table" style="width:100%;">
                                                    <thead style="background-color: #fac0a4;">
                                                        <tr>
                                                            <th>{{ GoogleTranslate::trans('S/N', app()->getLocale()) }}</th>
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
                                                </table> --}}
                                                @include('frontend.profile_loyalty')
                                            {{-- </div> --}}
                                           
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-wrapper user-dashboard">
                            <div class="table-responsive">
                                <table id="voucherTable" style="width:100%;">
                                    <thead style="background-color: #fac0a4;">
                                        <tr>
                                            <th>{{ GoogleTranslate::trans('S/N', app()->getLocale()) }}</th>
                                            <th>{{ GoogleTranslate::trans('Voucher Code', app()->getLocale()) }}
                                            </th>
                                            <th>{{ GoogleTranslate::trans('Status', app()->getLocale()) }}</th>
                                            <th>{{ GoogleTranslate::trans('Expiry Date', app()->getLocale()) }}
                                            </th>
                                            <th>{{ GoogleTranslate::trans('Created At', app()->getLocale()) }}
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu3" class="tab-pane">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-wrapper user-dashboard">
                            <div class=" mt-2 d-flex flex-row-reverse">
                                <a href="#" class="btn  btn-add-front" data-toggle="modal" data-target="#basicModal" style="margin-bottom: 10px">
                                    {{ GoogleTranslate::trans('Add Address', app()->getLocale()) }}
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table id="user_all_addresses_table" style="width:100%;">
                                    <thead style="background-color: #fac0a4;">
                                        <tr>
                                            <th>{{ GoogleTranslate::trans('S/N', app()->getLocale()) }}</th>
                                            <th>{{ GoogleTranslate::trans('Name', app()->getLocale()) }}</th>
                                            <th>{{ GoogleTranslate::trans('Mobile Number', app()->getLocale()) }}
                                            </th>
                                            <th>{{ GoogleTranslate::trans('Postal Code', app()->getLocale()) }}
                                            </th>
                                            <th>{{ GoogleTranslate::trans('Address', app()->getLocale()) }}</th>
                                            <th>{{ GoogleTranslate::trans('Unit Number', app()->getLocale()) }}
                                            </th>
                                            <th>{{ GoogleTranslate::trans('Status', app()->getLocale()) }}</th>
                                            <th>{{ GoogleTranslate::trans('Action', app()->getLocale()) }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu4" class="tab-pane active">
                <div class="row">
                    <div class="col-md-12">
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
</section>

    <div class="modal fade" id="viewOrderDetails2" tabindex="-1" role="dialog" aria-labelledby="viewOrderDetails2" aria-hidden="true">
        <div class="modal-dialog my-auto">
            <div class="modal-content" id="viewOrderDetailsData"></div>
        </div>
    </div>

    <button class="btn btn-primary" style="display: none;" data-toggle="modal" id="viewOrderHistoryBtn" data-target="#viewOrderDetails2">View Btn</button>

{{-- <script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js"></script>
<script src="{{ asset('frontend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<!--  -->
@include('frontend.add_address')
<!--  -->
@include('frontend.edit_address')
<!--  -->
@include('frontend.edit_profile')
<!--  -->

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
            });

            voucher = $('#voucherTable').DataTable({
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
                    url: "{{ route('user.my_vouchers.details') }}",
                    type: 'get',
                },
            });

            addresses = $('#user_all_addresses_table').DataTable({
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
                    url: "{{ route('user.addresses') }}",
                    type: 'get'
                },
            });
            // $(document).find('#user_all_addresses_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')

            order_history = $('#userPandingOrderSelfTable').DataTable({
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
                        id: 0
                    }
                },
            });
        });

        function removeAddress(id) {
            $.ajax({
                url: "/remove-address/" + id,
                type: "get",
                success: function(data) {
                    toastr.success(data.success);
                    addresses.ajax.reload();
                },
                error: function(data) {
                    toastr.success(data.error);
                }
            });
        }

        function makeDefaultAddress(id) {
            $.ajax({
                url: "/default-address/" + id,
                type: "get",
                success: function(data) {
                    toastr.success(data.success);
                    addresses.ajax.reload();
                },
                error: function(data) {
                    toastr.success(data.error);
                }
            });
        }

        $(document).on('click', 'a[name="viewOrderDetails"]', function() {
            $.ajax({
                url: "{{ route('user.consolidateOrdersDetails') }}",
                method: "GET",
                data: {
                    id: $(this).data('id')
                },
                beforeSend: function() {
                    $('#viewOrderDetails').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    $('#viewOrderDetails').html('View');
                    $('#viewOrderHistoryBtn').click();
                    $('#viewOrderDetailsData').html(response);
                }
            });
        });

</script>

@endsection