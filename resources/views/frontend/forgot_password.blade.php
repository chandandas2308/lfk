@extends('frontend.layouts.head')
@section('title','LFK | Forgot Password')

<section class="forget-password-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="/">
            <img src="{{ asset('frontend/images/ykpte-new-logo.png') }}" alt="logo">
          </a>
          <h2 class="text-center">Welcome Back</h2>
          <form class="text-left clearfix sign-up-form" method="POST" action="{{ route('password.email') }}" >
            <p>Please enter the email address for your account. A verification code will be sent to you. Once you have received the verification code, you will be able to choose a new password for your account.</p>
            
            @csrf

            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            <div class="form-group">
              <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Account email address">
              @error('email')
                <span class="invalid-feedback" style="color: red;" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main btn-lo text-center">Request password reset</button>
            </div>
          </form>
          <p class="mt-20"><a href="{{ route('login-with-us') }}">Back to log in</a></p>
        </div>
      </div>
    </div>
  </div>
</section>