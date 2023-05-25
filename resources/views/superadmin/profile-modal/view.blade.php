@extends('superadmin.layouts.master')
@section('title','Customer Management | ELRICA')
@section('body')
<div class="main-panel">
    <div class="content-wrapper pb-0">
          <!-- <div class="card"> -->
            <div class="border border-secondary p-4 rounded bg-white">
                <!-- name -->
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="nameView"  class="form-control" placeholder="Name" disabled />
                </div>
                <!-- email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="emailView" class="form-control" placeholder="Email" disabled />
                </div>
                <!-- phone number -->
                <div class="form-group">
                    <label for="phno" class="form-label">Home number</label>
                    <input type="tel" name="phno" id="phnoView" class="form-control" placeholder="Home Number" disabled />
                </div>
                <!-- mobile number -->
                <div class="form-group">
                    <label for="mobno" class="form-label">Mobile number</label>
                    <input type="tel" name="mobno" id="mobnoView" class="form-control" placeholder="Mobile Number" disabled />
                </div>
                <!-- password reset link -->
                <div class="form-group">
                  <a class="btn btn-primary" href="{{route('SA-UpdateProfilePath')}}"> Update Details </a>
                </div>
            <!-- </div> -->
          <!-- </div> -->
    </div>
</div>


<!-- jQuery CDN -->
<script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<!-- // backend js file -->

<script>
    fetchUpdateDetials();

            function fetchUpdateDetials(){
              jQuery.ajax({
                url: "{{ route('SA-GetProfile') }}",
                enctype: "multipart/form-data",
                type: "GET",

                success: function (result) {
                  jQuery.each(result, function (key, value){
                    $('#nameView').val(value['name']);
                    $('#emailView').val(value['email']);
                    $('#phnoView').val(value['phone_number']);
                    $('#mobnoView').val(value['mobile_number']);
                  });
                }
              });
            }
</script>
@endsection