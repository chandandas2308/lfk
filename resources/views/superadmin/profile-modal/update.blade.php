@extends('superadmin.layouts.master')
@section('title','Customer Management | ELRICA')
@section('body')
<div class="main-panel">
    <div class="content-wrapper pb-0">
        <form action="" method="post" id="updateProfileForm">
            <div class="modal-header bg-primary text-white rounded">
                Update Details
            </div>
            <div class="border border-secondary p-4 rounded bg-white">
                                <!-- info & alert section -->
                                    <!-- <div class="alert alert-success" id="updateProfileAlert" style="display:none"></div>
                                    <div class="alert alert-danger" style="display:none">
                                        <ul></ul>
                                    </div> -->
                                <!-- end -->
                <!-- name -->
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" value="{{ Auth::User()->name }}" class="form-control" placeholder="Name">
                    <input type="text" name="id" id="id" value="{{ Auth::User()->id }}" class="form-control" placeholder="Id" style="display: none;">
                </div>
                <!-- email -->
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" value="{{ Auth::User()->email }}" class="form-control" placeholder="Email">
                </div>
                <!-- phone number -->
                <div class="form-group">
                    <label for="phno" class="form-label">Phone number</label>
                    <input type="tel" name="phno" id="phno" value="{{ Auth::User()->phone_number }}" class="form-control" placeholder="Phone number">
                </div>
                <!-- mobile number -->
                <div class="form-group">
                    <label for="mobno" class="form-label">Mobile number</label>
                    <input type="tel" name="mobno" id="mobno" value="{{ Auth::User()->mobile_number }}" class="form-control" placeholder="Mobile number">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>

        <!-- update OR reset password -->
        <form action="" method="post" id="updatePasswordForm">
            <div class="modal-header  p-2 mt-4 h6 rounded">
                Update Password
            </div>
            <div class="border border-secondary p-4 rounded bg-white">
                                <!-- info & alert section -->
                                    <!-- <div class="alert alert-success" id="updatePasswordAlert" style="display:none"></div>
                                    <div class="alert alert-danger password-danger" style="display:none">
                                        <ul></ul>
                                    </div> -->
                                <!-- end -->
                
                <!-- old password -->
                <div class="form-group">
                    <label for="oldPassword" class="form-label">Old Password</label>
                    <input type="text" name="current_password" id="oldPassword" class="form-control" placeholder="Old Password">
                    <input type="hidden" name="id" id="id" class="form-control" placeholder="ID" value="{{ Auth::User()->id }}">
                </div>
                <!-- phone number -->
                <div class="form-group">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="tel" name="password" id="newPassword" class="form-control" placeholder="New Password">
                </div>
                <!-- mobile number -->
                <div class="form-group">
                    <label for="repeatPassword" class="form-label">Confirm New Password</label>
                    <input type="tel" name="password_confirmation" id="repeatPassword" class="form-control" placeholder="Confirm New Password">
                </div>
                <!--  -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot password') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
<!-- </div> -->

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
        $('#updateProfileForm').submit(function (e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        
            jQuery.ajax({
                url: "{{ route('SA-UpdateProfile') }}",
                data: jQuery("#updateProfileForm").serialize(),
                enctype: "multipart/form-data",
                type: "post",

                success: function (result) {
                    if(result.error !=null ){
                        // jQuery(".alert-danger>ul").html(
                        //         "<li> Info ! Please complete below mentioned fields : </li>"
                        //     );
                        jQuery.each(result.error, function (key, value) {

                            errorMsg(value);

                            // jQuery(".alert-danger").show();
                            // jQuery(".alert-danger>ul").append(
                            //     "<li>" + key + " : " + value + "</li>"
                            // );
                        });
                    }
                    else if(result.barerror != null){
                        jQuery("#updateProfileAlert").hide();
                        // jQuery(".alert-danger").show();
                        // jQuery(".alert-danger").html(result.barerror);
                        errorMsg(result.barerror);
                    }
                    else if(result.success != null){
                        jQuery(".alert-danger").hide();
                        // jQuery("#updateProfileAlert").html(result.success);
                        // jQuery("#updateProfileAlert").show()
                        sucessMsg(result.success);
                        fetchUpdateDetials();
                    }else {
                        jQuery(".alert-danger").hide();
                        jQuery("#updateProfileAlert").hide();
                    }
                },
            });
        });

        // update password
        $('#updatePasswordForm').submit(function (e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        
            jQuery.ajax({
                url: "{{ route('SA-UpdatePassword') }}",
                data: jQuery("#updatePasswordForm").serialize(),
                enctype: "multipart/form-data",
                type: "post",

                success: function (result) {
                    console.log(result);
                    if(result.error !=null ){
                        // jQuery(".password-danger>ul").html(
                        //         "<li> Info ! Please complete below mentioned fields : </li>"
                        //     );
                        jQuery.each(result.error, function (key, value) {
                            // jQuery(".password-danger").show();
                            // jQuery(".password-danger>ul").append(
                            //     "<li>" + key + " : " + value + "</li>"
                            // );
                            errorMsg(value);
                        });
                    }
                    else if(result.barerror != null){
                        // jQuery("#updatePasswordAlert").hide();
                        // jQuery(".password-danger").show();
                        // jQuery(".password-danger").html(result.barerror);
                        errorMsg(result.barerror);
                    }
                    else if(result.success != null){
                        jQuery(".password-danger").hide();
                        // jQuery("#updatePasswordAlert").html(result.success);
                        // jQuery("#updatePasswordAlert").show()
                        errorMsg(result.success);
                        fetchUpdateDetials();
                    }else {
                        jQuery(".password-danger").hide();
                        jQuery("#updatePasswordAlert").hide();
                    }
                },
            });
        });

</script>
@endsection