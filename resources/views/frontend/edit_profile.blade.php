<div class="modal fade" id="updateProfile" tabindex="-1" role="dialog" aria-labelledby="updateProfile" aria-hidden="true">
  <div class="modal-dialog my-auto">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" id="closeUpdateProfile" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Update Profile</h4>
      </div>
      <form class="text-left clearfix" id="profileUpdate" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">

          <!--  -->
          <input type="hidden" id="" name="id_update" value="{{ Auth::User()->id }}">
          <!--  -->
          <div class="form-group">
            <label for="image">Profile Image</label>
            <input type="file" class="form-control " id="pro_Img" accept="image/*" name="profile_image" />
          </div>
          <!--  -->
          <div class="form-group">
            <label for="name">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ Auth::User()->name }}" id="full_name" name="fullName" placeholder="Full Name">
          </div>

          <!--  -->
          <div class="form-group">
            <label for="email">Email <span class="text-danger">*</span></label>
            <input type="email" class="form-control" value=" {{ Auth::User()->email }}" name="emailAddress" id="email_address" placeholder="Email">
          </div>
          <!--  -->
          <!-- <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" class="form-control" value="{{ ((Auth::User()->mobile_number != null)?Auth::User()->mobile_number : '--') }}" name="mobileNumber" id="mobile_number" placeholder="Mobile Number">
          </div> -->
          <!--  -->

          <!--  -->
          <div class="form-group">
            <label for="phone">Mobile Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" value="{{ Auth::User()->phone_number  }}" name="homeNumber" id="home_number" placeholder="Mobile Number">
          </div>

        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" id="clearUpdateAddressForm">Clear</button> -->
          <button type="button" class="btn btn-small btn-solid-border" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-small btn-solid-border" style="background-color: #742e31; color:white; border-color: #742e31;" id="editCompleteSave">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  jQuery('#clearUpdateAddressForm').on('click', function() {
    jQuery('#profileUpdate')["0"].reset();
  });

  jQuery('#profileUpdate').submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
    });

  }).validate({
    rules: {
      fullName: {
        required: true,
      },
      emailAddress: {
        required: true,

      },
      homeNumber: {
        required: true,
        number: true,
        minlength: 8,
        maxlength: 8,
      },
    },
    messages: {
      fullName: {
        required: "Please enter your full name",
      },
      emailAddress: {
        required: "Please enter your email",
      },
      // mobileNumber: {
      //   required: "Please enter unit number",
      //   minLength: "Please enter valid mobile number",

      // },
      homeNumber: {
        required: "Please enter your mobile number",
        minlength: "{{ __('lang.min_8') }}",
        maxlength: "{{ __('lang.no_more_8') }}",
      },
    },
    submitHandler: function() {
      const formData = new FormData($('#profileUpdate')["0"]);
      $.ajax({

        url: "{{ route('Edit-Profile') }}",
        method: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          // console.log(data);
          toastr.success(data.success);
          addresses.ajax.reload();
          $('#closeUpdateProfile').click();
          window.location.href="";


        },
        error: function(error) {
          toastr.error(error.success);
        }
      })
    }
  })
</script>