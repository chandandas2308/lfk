@extends('frontend.layouts.head') @section('title','LFK | Register')

<link rel="stylesheet" href="{{ asset('backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" />

<section class="signin-page2 account">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="block text-center" style="margin-top:50px;">
          <a class="logo" href="/">
            <img src="{{ asset('frontend/images/ykpte-new-logo.png') }}" alt="logo">
          </a>
          <h2 class="text-center">Create Your Account</h2>
          <form class="text-left clearfix sign-up-form" method="POST" action="/register-us">
            @csrf
            <div class="form-group">
              <input id="is_admin" type="hidden" class="form-control" name="is_admin" value="0">
              <label for="firstName">First Name<span style="color: red;">*</span></label>
              <input type="text" name="firstName" value="{{old('firstName')}}" id="firstName" class="form-control" placeholder="First Name" > @error('firstName') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
            </div>
            <div class="form-group">
              <label for="lastName">Last Name<span style="color: red;">*</span></label>
              <input type="text" name="lastName" id="lastName" value="{{old('lastName')}}" class="form-control" placeholder="Last Name" > @error('lastName') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
            </div>
            <div class="form-group">
              <label for="lastName">Phone Number<span style="color: red;">*</span></label>
              <input type="text" name="phoneNumber" minlength="8" value="{{old('phoneNumber')}}" maxlength="8" id="phoneNumber" class="form-control" placeholder="Phone Number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' > @error('phoneNumber') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
            </div>
              <div class="form-group">
                <label for="dob">Birth Date<span style="color: red;">*</span></label>
                <div class="form-group">
                  <input type="text" name="dob" value="{{old('dob')}}" class="form-control" id="dob" placeholder="DD/MM/YYYY">
                </div>
              </div>
              <div class="form-group">
                <label for="Gender">Gender<span style="color: red;">*</span></label>
                <div class="form-group">
                  <select name="gender" class="form-control" id="Gender">
                    <option value="">Gender</option>
                    <option value="Male" @if(old('gender') == "Male") selected @endif>Male</option>
                    <option value="Female" @if(old('gender') == "Female") selected @endif>Female</option>
                    <option value="Other" @if(old('gender') == "Other") selected @endif>Other</option>
                  </select>
                </div>
              </div>
            <div class="form-group">
              <label for="email">Email ID<span style="color: red;">*</span></label>
              <input type="email" name="email" value="{{old('email')}}" id="email" class="form-control" placeholder="Email" > @error('email') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
            </div>
            <div class="form-group">
              <label for="postal">Postal Code<span style="color: red;">*</span></label>
              <input type="text" name="postalCode" value="{{old('postalCode')}}" id="regpostalCode" class="form-control" placeholder="Postal Code" > @error('postal') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <textarea type="text" name="address" id="regaddressId" class="form-control" placeholder="Address" readonly>{{old('address')}}</textarea>

            </div>
            <div class="form-group">
              <label for="unit">Unit Number<span style="color: red;">*</span></label>
              <input type="text" name="unitNumberName" value="{{old('unitNumberName')}}" id="unitNumber" class="form-control" placeholder="Unit Number" > @error('unit') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
            </div>
            <div class="form-group">
              <label for="password">Password<span style="color: red;">*</span></label>
              <input type="password" name="password" value="{{old('password')}}" id="password" class="form-control" placeholder="Minimum 6 characters with a number and a letter" > @error('password') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
              &nbsp;&nbsp;<input type="checkbox" id="showPasswd" onclick="myFunction()"> <label for="showPasswd">Show Password</label>
            </div>
            <div class="form-group">
              <label for="password-confirm">Confirm Password<span style="color: red;">*</span></label>
              <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" id="password-confirm" class="form-control" placeholder="Minimum 6 characters with a number and a letter" > @error('password') <span class="invalid-feedback" style="color:red;" role="alert">
                {{--<strong>{{ $message }}</strong>--}}
              </span> @enderror
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-main btn-lo text-center">Sign Up</button>
              <a href="{{ route('login-with-us1') }}" class="btn btn-main btn-lo text-center" style="color:#000;">Back</a>
            </div>
          </form>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Main jQuery -->

<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="{{ asset('backend/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

<script>
  jQuery(document).ready(function() {
    if ("{{ !empty(session('success')) }}") {
      // successMsg("{{ session('success') }}")
      toastr.success("{{ session('success') }}");
    }
    if ("{{ !empty(session('error')) }}") {
      toastr.error("{{ session('error') }}");
    }

    $('#dob').datepicker({
      format:"dd-mm-yyyy"
    });

    @if($errors->any())
      @foreach($errors->all(':message') as $key=>$value)
        toastr.error("{{$value}}");
      @endforeach
    @endif

  });

  function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

  // API for Address
  $(document).on('change', '#regpostalCode', function() {
    let fullAddress = $(this).val();

    if (fullAddress.toString().length == 6) {

      jQuery.ajax({
        url: "{{route('user.postalRegAddresses')}}",
        type: "get",
        data: {
          postalcode: $(this).val()
        },
        beforeSend: function() {
          $('#regaddressId').val('Lodding...');
        },
        success: function(response) {
          if (JSON.parse(response).found == 0) {
            $('#regaddressId').val('');
            $('#regpostalCode').val('');
            toastr.error('Please Enter Valid Postal Code');

          } else {
            $('#regaddressId').val(JSON.parse(response).results[0].ADDRESS);
            // $('#completeSave').removeAttr('disabled');

          }

        }
      });
    } else {
      toastr.error('Please Enter 6 digits  Postal Code');

    }
  });

  // Date Of Birth
  var Days = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]; // index => month [0-11]
  $(document).ready(function() {
    var option = '<option value="day">day</option>';
    var selectedDay = "day";
    for (var i = 1; i <= Days[0]; i++) { //add option days
      option += '<option value="' + i + '">' + i + '</option>';
    }
    $('#day').append(option);
    $('#day').val(selectedDay);

    var option = '<option value="month">month</option>';
    var selectedMon = "month";
    for (var i = 1; i <= 12; i++) {
      option += '<option value="' + i + '">' + i + '</option>';
    }
    $('#month').append(option);
    $('#month').val(selectedMon);

    var option = '<option value="month">month</option>';
    var selectedMon = "month";
    for (var i = 1; i <= 12; i++) {
      option += '<option value="' + i + '">' + i + '</option>';
    }
    $('#month2').append(option);
    $('#month2').val(selectedMon);

    var d = new Date();
    var option = '<option value="year">year</option>';
    selectedYear = "year";
    for (var i = 1930; i <= d.getFullYear(); i++) { // years start i
      option += '<option value="' + i + '">' + i + '</option>';
    }
    $('#year').append(option);
    $('#year').val(selectedYear);
  });

  function isLeapYear(year) {
    year = parseInt(year);
    if (year % 4 != 0) {
      return false;
    } else if (year % 400 == 0) {
      return true;
    } else if (year % 100 == 0) {
      return false;
    } else {
      return true;
    }
  }

  function change_year(select) {
    if (isLeapYear($(select).val())) {
      Days[1] = 29;

    } else {
      Days[1] = 28;
    }
    if ($("#month").val() == 2) {
      var day = $('#day');
      var val = $(day).val();
      $(day).empty();
      var option = '<option value="day">day</option>';
      for (var i = 1; i <= Days[1]; i++) { //add option days
        option += '<option value="' + i + '">' + i + '</option>';
      }
      $(day).append(option);
      if (val > Days[month]) {
        val = 1;
      }
      $(day).val(val);
    }
  }

  function change_month(select) {
    var day = $('#day');
    var val = $(day).val();
    $(day).empty();
    var option = '<option value="day">day</option>';
    var month = parseInt($(select).val()) - 1;
    for (var i = 1; i <= Days[month]; i++) { //add option days
      option += '<option value="' + i + '">' + i + '</option>';
    }
    $(day).append(option);
    if (val > Days[month]) {
      val = 1;
    }
    $(day).val(val);
  }
</script>