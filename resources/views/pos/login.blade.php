@extends('frontend.layouts.head')
@section('title','YKPTE | Login')

<style>
  section{
    background-color: #fff !important;
  }
</style>

<section class="signin-page account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center">
          <a class="logo" href="/">
           <img src="{{ asset('frontend/images/ykpte-new-logo.png') }}" alt="logo">
          </a>
          <h2 class="text-center">POS Login</h2>
          <form class="text-left clearfix" action="{{ route('login.pos-login') }}" method="POST" >
            @csrf
            <div class="form-group">
              <label for="email">Email ID</label>
              <input type="email" id="email" class="form-control" name="email" placeholder="Email" required="">
              @error('email')
                <span class="invalid-feedback" style="color:red;" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" id="password" class="form-control" name="password" placeholder="Password" required="">
              @error('password')
                <span class="invalid-feedback" style="color:red;" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main text-center" >Login</button>
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
                    toastr.success("{{ session('success') }}");
                }
                if ("{{ !empty(session('error')) }}") {
                  toastr.error("{{ session('error') }}")
                }

              });
</script>