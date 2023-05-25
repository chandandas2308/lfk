@extends('frontend.layouts.head')
@section('title', 'LFK | Login')

<section class="signin-page account">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="block text-center">
                    <div class="row">

                        <div class="col-md-6 col-md-offset-3 text-center">
                            <a class="logo" href="/">
                                <img src="{{ asset('frontend/images/ykpte-new-logo.png') }}" alt="logo">
                            </a>
                            <h2 class="text-center">{{ __('lang.login') }}</h2>
                        </div>
                    </div>

                    <!-- facebook login -->
                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end"></label>
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <a class="btn btn-primary btn-fb" href="{{ url('auth/facebook') }}"> <i
                                    class="fa fa-facebook" style="font-size: 90px; color: #fff;"></i> <br> <span
                                    style="color: #fff; font-weight: 500; font-size: 11px;">{{ __('lang.login_with_facebook') }}</span></a>
                        </div>

                    </div>

                    <!-- End facebook login -->
                    <form class="text-left clearfix" action="{{ route('login-with-us') }}" method="POST">
                        @csrf

                        <div class="text-center">
                            <p class="login-text">
                                {{ __('lang.or_login_With_email') }}
                            </p>
                            <!-- <button type="submit" class="btn btn-main text-center" >Login</button> -->
                            <a href="{{ route('phone-email-login') }}" class="btn btn-main btn-lo text-center"
                                style="color:#000;">{{ __('lang.login') }}</a>

                           

                        </div>

                    </form>
                   
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main jQuery -->
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        if ("{{ !empty(session('success')) }}") {
            // successMsg("{{ session('success') }}")
            toastr.success("{{ session('success') }}");
        }
        if ("{{ !empty(session('error')) }}") {
            toastr.error("{{ session('error') }}")
        }
    });
</script>
