<!-- Modal -->
<div class="modal fade" id="editCustomerDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Customer Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editCustomerForm" onsubmit="if (!validateFormqq(this)) event.preventDefault();">
        <div class="modal-body bg-white px-3">

                <div class="alert alert-success alert-dismissible fade show" role="alert" id="editCustomerAlert"  style="display: none;">
                  <strong>Info!</strong> <span id="addCustomerAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
          <div class="alert alert-danger" style="display:none">
            <ul></ul>
          </div>
          <!-- end -->

              <!-- customer edit -->
              <input type="text" name="id" id="editCustomerFormId" class="form-control" style="display:none;">

              <div class="row">
                <div class="col-md-6">
                    <!-- Customer Name -->
                    <div class="form-group">
                      <label for="customerName" class="required-field">Customer Name</label>
                      <input type="text" name="customerName" id="customerEditName" class="form-control" placeholder="Customer Name">
                      <span style="display:none;color:red;" id="errorcustomerEditName">This is a required field</span>
                    </div>
                </div>
                <div class="col-md-6">
                  <!-- Customer Address -->
                  <div class="form-group">
                      <label for="emailId">Email ID</label>
                      <input type="email" name="emailId" id="CustomerEmailId" class="form-control" placeholder="Email ID">
                      <span style="display:none;color:red;" id="caretq">Not a valid e-mail address</span>
                      <span style="display:none;color:red;" id="errorCustomerEmailId">This is a required field</span>
                  </div>
                </div>
              </div>



              <div class="row">
                <div class="col-md-6">
                <!-- Customer Mobile Number -->
                <div class="form-group">
                <label for="phoneNo" class="required-field">Phone Number</label>
                <!-- <input type="text" name="mobileNo" id="CustomerMobileNo" minlength="7" maxlength="15" class="form-control" placeholder="Mobile Number"> -->
                <input type="text" name="phoneNo" id="phoneNo" minlength="8" maxlength="8" class="form-control" placeholder="Phone Number">
                
              </div>
                </div>
                <div class="col-md-6">
              <!-- Customer Phone Number -->
              <div class="form-group">
                <!-- <label for="phoneNo">Home Number</label>
                
                
              </div> -->
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
              <!-- Customer Email ID -->
              <div class="form-group">
                    <label for="address" class="required-field">Address</label>
                    <textarea name="address" class="form-control" id="customerAddress" rows="4" placeholder="Address"></textarea>
              </div>
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="editCustomerClearBtn">Clear</button>
          <button type="submit" id="editCustomerForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- // backend js file -->

<script>


// validation script start here
$(document).ready(function() {
  jQuery("#editCustomerForm").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
    });

    $.validator.addMethod("isValidEmailAddress", function(value) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(value);
    });

  }).validate({
  rules: {
    customerName : {
      required: true,
      minlength: 3
    },
    address: {
      required: true,
    },
    phoneNo: {
          number: true,
          minlength: 7,
          maxlength: 15,
        },
        // mobileNo: {
        //   required: true,
        //   number: true,
        //   minlength: 7,
        //   maxlength: 15,
        // },
    },
    messages : {
      name: {
        minlength: "Name should be at least 3 characters"
      },
      phonenumber: {
          required: "Please enter your phone number",
          checkUsername : "Please enter username first",
          number: "Please enter your phone number as a numerical value",
          minlength: "Your phone number should be 8 digits",
          maxlength: "Your phone number can be 8 digits"
        },
        mobilenumber: {
          number: "Please enter your phone number as a numerical value",
          minlength: "Your phone number should be 8 digits",
          maxlength: "Your phone number can be 8 digits"
        },
    },
    submitHandler:function(){
      bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
        if(result){
          jQuery.ajax({
            url: "{{ route('SA-EditCustomerDetails') }}",
            data: jQuery("#editCustomerForm").serialize(),
            enctype: "multipart/form-data",
            type: "post",

            success: function(result) {
              if (result.error != null) {
                errorMsg(result.error);
              } else if (result.barerror != null) {
                jQuery("#editCustomerAlert").hide();
                errorMsg(result.barerror);
              } else if (result.success != null) {
                successMsg(result.success);
                $('.modal .close').click();
                jQuery("#editCustomerAlert").show();
                business_customer_table.ajax.reload();
              } else {
                jQuery(".alert-danger").hide();
                jQuery("#editCustomerAlert").hide();
              }
            },
          });
        }
      });
    }
});
});
// end here

  // store data in db

  $('#editCustomerClearBtn').on('click', function(){
    $('#editCustomerForm')["0"].reset();
  });

</script>