@extends('frontend.layouts.head')
@section('title', 'LFK | Login')

<section class="signin-page account">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="block text-center">
                    <a class="logo" href="/">
                        <img src="{{ asset('frontend/images/ykpte-new-logo.png') }}" alt="logo">
                    </a>
                    <h2 class="text-center">{{ GoogleTranslate::trans('Login', app()->getLocale()) }}</h2>
                    <!-- facebook login -->
                    <!-- <div class="row mb-3 text-left">
            <label for="password" class="col-md-4 col-form-label text-md-end"></label>
            <div class="col-md-6">
              <a class="btn btn-primary" href="{{ url('auth/facebook') }}"> <i class="fa fa-facebook" style="font-size: 40px; color: #fff;"></i> <br> <span style="color: #fff; font-weight: 500; font-size: 11px;">Login with Facebook</span></a>
            </div>
          </div> -->
                    <!-- End facebook login -->
                    <form class="text-left clearfix sign-up-form" action="{{ route('login-with-us') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label
                                for="email">{{ GoogleTranslate::trans('Enter Email or Mobile Number', app()->getLocale()) }}</label>
                            <input type="text" id="email" class="form-control" name="email"
                                placeholder="{{ GoogleTranslate::trans('Email/Mobile Number', app()->getLocale()) }}"
                                required="">
                            @error('email')
                                <span class="invalid-feedback" style="color:red;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label
                                for="password">{{ GoogleTranslate::trans('Enter Password', app()->getLocale()) }}</label>
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="{{ GoogleTranslate::trans('Password', app()->getLocale()) }}"
                                required="">
                            @error('password')
                                <span class="invalid-feedback" style="color:red;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <p class="text-right"><a
                                href="{{ route('forgot-password') }}">{{ GoogleTranslate::trans('Forgot your password', app()->getLocale()) }}?</a>
                        </p>
                        <div class="text-center">
                            <button type="submit"
                                class="btn btn-main btn-lo text-center">{{ GoogleTranslate::trans('Login', app()->getLocale()) }}</button>

                            <!-- <a href="{{ route('register-with-us') }}" class="btn btn-main btn-lo text-center" style="color:#000;">Sign Up</a> -->

                        </div>

                    </form>
                    <p class="mt-20">{{ GoogleTranslate::trans('New to  LFK ', app()->getLocale()) }}?<a
                            href="{{ route('register-with-us') }}" class="text-info">
                            {{ GoogleTranslate::trans('Create New Account', app()->getLocale()) }}</a></p>
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
