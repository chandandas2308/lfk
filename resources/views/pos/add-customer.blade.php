<!-- Modal -->
<div class="modal fade" id="addCustomer" tabindex="-1">
  <div class="modal-dialog modal-lg" style="width: 800px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <form action="" method="POST" id="CustomerStore">
          @csrf
          <div class="row mb-3">
            <div class="col-md-6 col-sm-12">
              <label for="customer_name" class="fw-bold form-label">Customer Name<span style="color:red;">*</span></label>
              <input type="text" name="customer_name" id="customer_name" value="" class="form-control" placeholder="Customer Name">

              @error('customer_name')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="col-md-6 col-sm-12">
              <label for="dob" class="fw-bold form-label">DOB<span style="color:red;">*</span></label>
              <input type="date" name="dob" id="dob" value="" class="form-control">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6 col-sm-12">
              <label for="mobile_number" class="fw-bold form-label">Mobile Number<span style="color:red;">*</span></label>
              <input type="number" name="mobile_number" id="mobile_number" value="" class="form-control" placeholder="Mobile Number">
              @error('mobile_number')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="col-md-6 col-sm-12">
              <label for="email_id" class="fw-bold form-label">Email ID<span style="color:red;">*</span></label>
              <input type="email" name="email_id" id="email_id" value="" class="form-control" placeholder="Email ID">
              @error('email_id')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6 col-sm-12">
              <label for="phone_number" class="fw-bold form-label">Phone Number</label>
              <input type="number" name="phone_number" id="phone_number" value="" class="form-control" placeholder="Phone Number">
            </div>

            <div class="col-md-6 col-sm-12">
              <label for="outletPostCode" class="fw-bold form-label">Postal Code<span style="color:red;">*</span></label>
              <input type="text" name="postcode" id="outletPostCode" value="" class="form-control" placeholder="Postal Code">
              @error('postcode')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6 col-sm-12">
              <label for="outlet_address" class="fw-bold form-label">Address<span style="color:red;">*</span></label>
              <!-- <select name="address" id="outlet_address" class="form-control">
                <option value="">Select Address</option>
              </select> -->
              <textarea name="address" id="outlet_address" class="form-control"></textarea>
            </div>

            <div class="col-md-6 col-sm-12">
              <div class="form-group">
                <label for="outletUnitCode" class="fw-bold form-label">Unit<span style="color:red;">*</span></label>
                <input type="text" name="unitCode" id="outletUnitCode" class="form-control" placeholder="Unit">
              </div>
            </div>
          </div>
          <br>
          <div style="text-align:end !important;">
            <button type="submit" class="bg-addbtn  mx-2 rounded">Save</button>
            <button type="reset" id="clearOutletForm" class="bg-addbtn  mx-2 rounded">Clear</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script type="text/javascript">
    function hide() {
      document.get("alert").style.visibility = "hidden";
    }
    setTimeout("hide", 3000);
  </script>
  <script>
    $(document).on('click', '#clearOutletForm', function() {
      $('#CustomerStore')[0].reset();
    });

    $(document).ready(function() {
      jQuery('#CustomerStore').submit(function(e) {
        e.preventDefault();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          },
        });
      }).validate({
        rules: {
          customer_name: {
            required: true,
          },
          dob: {
            required: true,
          },
          mobile_number: {
            required: true,
          },
          email_id: {
            required: true,
          },
          postcode: {
            required: true,
          },
          address: {
            required: true,
          },
          unitCode: {
            required: true,
          },
        },
        message: {},
        submitHandler: function() {
          bootbox.confirm({
              size: "large",
              message: "DO YOU WANT TO SAVE?",
              callback: function(result){
                if (result) {
                  const formData = new FormData($('#CustomerStore')["0"]);
                  jQuery.ajax({
                    url: "{{ route('Pos-PostCustomer') }}",
                    enctype: "multipart/form-data",
                    type: "post",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {

                      if (result.success != null) {
                        jQuery("#CustomerStore")["0"].reset();
                        customer_all_list_table.ajax.reload();
                        $('#addCustomer').modal('hide');
                        toastr.success(result.success);
                      } else {
                        toastr.error(result.error["email_id"]);
                      }

                    }
                  });
                }
              }
          })
          // bootbox.confirm(message:"DO YOU WANT TO SAVE?", callback:function(result) {
          //   if (result) {
          //     const formData = new FormData($('#CustomerStore')["0"]);
          //     jQuery.ajax({
          //       url: "{{ route('Pos-Customer') }}",
          //       enctype: "multipart/form-data",
          //       type: "post",
          //       data: formData,
          //       contentType: false,
          //       cache: false,
          //       processData: false,
          //       success: function(result) {

          //         if (result.success != null) {
          //           jQuery("#CustomerStore")["0"].reset();
          //           customer_all_list_table.ajax.reload();
          //           $('#addCustomer').modal('hide');
          //           toastr.success(result.success);
          //         } else {
          //           toastr.error(result.error["email_id"]);
          //         }

          //       }
          //     });
          //   }
          // });
        }
      })
    });

    // 
    $(document).on('change', '#outletPostCode', function() {
      let postcode = $(this).val();
      if (postcode.toString().length == 6) {

      jQuery.ajax({
        url: "{{route('user.postaladdresses')}}",
                type: "get",
                data: {
                    postalcode: $(this).val()
                },

                beforeSend: function() {
                    $('#outlet_address').val('Lodding...');
                },
        success: function(response) {
          if (JSON.parse(response).found == 0) {
            $('#outlet_address').val('');
            $('#outletPostCode').val('');
            toastr.error('Please Enter Valid Postal Code');

          }else{
            $('#outlet_address').val(JSON.parse(response).results[0].ADDRESS);

          }

          
        }
      });
    }else {
            toastr.error('Please Enter 6 digits  Postal Code');

        }
    });
  </script>