@extends('frontend.layouts.master')
@section('title', 'LFK | Address')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a>
                        </li>
                        <li class="active">
                            {{ __('lang.address') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="" style="margin-bottom: 40px;">
        <div class="title text-center">
            <h2>{{ __('lang.address') }}</h2>
        </div>
        <div class="container">


            <div class="container">


                <div class="tab-content">
                    <div id="menu2" class="tab-pane fade in active">
                        <!-- Button trigger modal -->

                        <!--  -->
                        <div class="row">
                            <div class="col-12">
                                <div class=" mt-2 d-flex flex-row-reverse">
                                    <a href="#" class="btn  btn-add-front" data-toggle="modal"
                                        data-target="#basicModal">
                                        {{ __('lang.add') }}
                                    </a>
                                </div>
                            </div>
                        </div>
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
                                    <!-- <div class="table-responsive"> -->
                                        <table id="user_all_addresses_table" style="width:100%;">
                                            <thead style="background-color: #fac0a4;">
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>{{ __('lang.name') }}</th>
                                                    <th>{{ __('lang.mobile_number') }}
                                                    </th>
                                                    <th>{{ __('lang.postal_code') }}
                                                    </th>
                                                    <th>{{ __('lang.address') }}</th>
                                                    <th>{{ __('lang.unit_number') }}
                                                    </th>
                                                    <th>Status</th>
                                                    <th>{{ __('lang.action') }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    <!-- </div> -->
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>

        </div>
    </section>
    <script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.1 -->
    <script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js"></script>
    <!-- Bootstrap Touchpin -->
    <script src="{{ asset('frontend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
        integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
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
            })

            // $(document).find('#user_all_addresses_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
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
    </script>

    @include('frontend.add_address')
    <!--  -->
    @include('frontend.edit_address')

@endsection
