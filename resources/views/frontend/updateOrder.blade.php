@extends('frontend.layouts.master')
@section('title', 'LFK | Update Orders ')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ GoogleTranslate::trans('Home', app()->getLocale()) }}</a></li>
                        <li class="active">{{ GoogleTranslate::trans('Orders', app()->getLocale()) }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="" style="margin-bottom: 40px;">
        <div class="title text-center">
            <h2>{{ GoogleTranslate::trans('Update Address', app()->getLocale()) }}</h2>
        </div>
        <div class="container">

        <!-- onclick="open_add_address_modal()" -->
            <div class="container">

                <div class="tab-content">
                    <form method="POST" action="{{ route('checkout.updateAddress') }}">
                    @csrf
                        <div class="add-addr" style="display: flex; flex-direction: row-reverse;">
                            <a href="#" class="btn add_address btn-add-front" data-toggle="modal" data-target="#basicModal"
                                
                                >
                                {{ GoogleTranslate::trans('Add Address', app()->getLocale()) }}
                            </a>
                        </div>

                        <div class="grid" id="addressesCards1">
                            <img src="{{ asset('loading/loading.webp') }}" height="100" style="transform: translateX(284px);border-radius: 312px;">
                        </div>

                        <input type="hidden" name="consolidate_order_no" value="{{$consolidate_order_no}}" id="">
                        <center>
                            <button class="btn btn-main mt-20" type="submit">{{ GoogleTranslate::trans('Confirm Address', app()->getLocale()) }}</button>
                        </center>

                    </form>
                </div>

            </div>
    </section>

    <script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js"></script>
    <script src="{{ asset('frontend/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
        integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        @include('frontend.add_address')

        @section('javascript')
        <script>
            // function open_add_address_modal() {
            //     $('#basicModal').modal('show');
            // }

            
        fetchAllAddress1();

        function fetchAllAddress1() {

            let k = 0;

            $.ajax({
                url: "{{ route('user.addressesCards') }}",
                type: 'get',
                beforeSend: function() {
                    $('#addressesCards1').html("Loading...");
                },
                success: function(response) {
                    $('#addressesCards1').html('');
                    let last_user_address = "{{ $last_user_address }}";
                    $.each(response.data, function(key, value) {
                        $('#addressesCards1').append(`
                                <label class="card">
                                    <input name="address_id" class="radio" onClick="getAddress(${value["id"]})" value="${value["id"]}" ${last_user_address == value["id"]?"checked":""} type="radio" >
                                    <span class="plan-details">
                                        <span class="plan-type">${value["name"]}</span>
                                        <span>postal Code:#${value["postcode"]}</span>
                                        <span>${value["address"]}</span>
                                        <span>Mobile No.:${value["mobile_number"]}</span>
                                        <span>Unit No.:${value["unit"]}</span>
                                    </span>
                                </label>
                            `);
                        ++k;
                    });
                }
            });
        }

        </script>
        @endsection        
@endsection
