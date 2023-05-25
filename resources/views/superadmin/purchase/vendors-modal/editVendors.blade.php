<!-- Modal -->
<div class="modal fade" id="editVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Vendors</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="updateVendorForm">
        <div class="modal-body bg-white px-3">

                <!-- info & alert section -->
                <div class="alert alert-success" id="updateVendorAlert" style="display:none"></div>
                  <div class="alert alert-danger" style="display:none">
                    <ul></ul>
                  </div>
              <!-- end -->
            <input type="text" name="id" id="idEV" class="form-control text-dark" style="display: none;">
              <!-- <div class="card">
                  <div class="card-body"> -->


                  <div class="row">
                    <div class="col-md-6">
                        <!-- Customer Name -->
                        <div class="form-group">
                        <label for="vendorName">Vendor Name<span style="font-size: small; color:red;">*</span></label>
                        <input type="text" name="vendorName" id="vendorNameEV" class="form-control text-dark" placeholder="Vendor Name">
                      </div>
                    </div>
                    <div class="col-md-6">
                    <!-- Contact Person Name -->
                      <div class="form-group">
                        <label for="vendorID">Vendor ID</label>
                        <input type="text" name="vendorID" id="VendoerIDEV" class="form-control text-dark" placeholder="Vendor ID" disabled>
                      </div>
                    </div>
                  </div>

                      <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="contactPersonName">Contact Person Name<span style="font-size: small; color:red;">*</span></label>
                        <input type="text" name="contactPersonName" id="contactPersonNameEV" class="form-control text-dark" placeholder="Contact Person Name">
                      </div>
                    </div>
                    <div class="col-md-6">
                      
                    <!-- Vendor Phone Number -->
                    <div class="form-group">
                        <label for="phoneNo">Home Number</label>
                        <input type="tel" name="phoneNo" maxlength="15" id="phoneNoEV" class="form-control text-dark" placeholder="Home Number" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                      </div>
                    </div>
                  </div>

                 


                  <div class="row">
                    <div class="col-md-6">
                      <!-- Vendor Mobile Number -->
                      <div class="form-group">
                        <label for="mobileNo">Mobile Number<span style="font-size: small; color:red;">*</span></label>
                        <input type="tel" name="mobileNo" maxlength="15" id="mobileNoEV" class="form-control text-dark" placeholder="Mobile Number" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                      </div>
                    </div>
                    <div class="col-md-6">
                      
                      <!-- Vendor Email ID -->
                      <div class="form-group">
                        <label for="emailId">Email ID</label>
                        <input type="email" name="emailId" id="emailIdEV" class="form-control text-dark" placeholder="Email ID">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                    <!-- Vendor Address -->
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea
                          name="address"
                          class="form-control text-dark"
                          id="addressEV"
                          rows="4"
                          placeholder="Address"
                        ></textarea>
                      </div>     
                    </div>
                    <div class="col-md-6">
                      
                    </div>
                  </div>



                      <!-- GST -->
                      <!-- <div class="form-group">
                        <label for="gst">GST</label>
                        <select name="gst" id="gstEV" class="form-control text-dark">
                            <option value="">Select GST treatment</option>
                            <option value="A">Demo</option>
                            <option value="B">Demo1</option>
                            <option value="C">Demo2</option>
                        </select>
                      </div> -->
                  <!-- </div>
                </div>     -->

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editVendorsFormClearBtn" >Clear</button>
            <button type="submit" id="updateVendorForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

  // validation script start here
  $(document).ready(function() {

    // store data in db
    jQuery("#updateVendorForm").submit(function (e) {
          e.preventDefault();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
              },
          });    
    
          $.validator.addMethod("validate", function(value) {
            return /[A-Za-z]/.test(value);
          });

          $.validator.addMethod("isValidEmailAddress", function(value) {
              var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
              return pattern.test(value);
          });

        }).validate({
    rules: {

      vendorName : {
        required: true,
        validate: true,
      },

      contactPersonName : {
        required: true,
      },

      // address : {
      //   required: true,
      // },

      phoneNo : {
        // required: true,
        minlength: 7,
        maxlength: 15,
      },

      mobileNo : {
        required: true,
        minlength: 7,
        maxlength: 15,
      },

      // emailId : {
      //   required: true,
      //   isValidEmailAddress:true,
      //   email: true,
      // },

    },
    messages : {
      vendorName: {
        required: "Please enter valid vendor name.",
        validate : "Please enter valid vendor name.",
      },
      contactPersonName: {
          required: "Contact person name required.",
      },
      // address: {
      //   required: "Address field required.",
      // },
      phoneNo: {
        required: "Please enter valid phone number",
        minlength: "Your phone number should be 7 digits",
        maxlength: "Your phone number should be 15 digits"
      },
      mobileNo: {
        minlength: "Your phone number should be 7 digits",
        maxlength: "Your phone number should be 15 digits"
      },
      // emailId : {
      //   email: "The email should be in the format: abc@domain.tld",
      //   isValidEmailAddress: "Please enter valid email address."
      // },
    },
    submitHandler:function(){
        bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
          if(result){
            jQuery.ajax({
              url: "{{ route('SA-UpdateVendor') }}",
              data: jQuery("#updateVendorForm").serialize(),
              enctype: "multipart/form-data",
              type: "post",

              success: function (result) {
                  
                  if(result.error !=null ){
                      errorMsg(result.error);
                  }
                  else if(result.barerror != null){
                      jQuery("#updateVendorAlert").hide();
                      errorMsg(result.barerror);
                  }
                  else if(result.success != null){
                      successMsg(result.success);
                      $('.modal .close').click();
                      jQuery("#updateVendorForm")["0"].reset();
                      vendors_main_table.ajax.reload();
                      getVendorNamesEQ();
                      getVendorNamesVQ();
                  }else {
                      jQuery(".alert-danger").hide();
                      jQuery("#updateVendorAlert").hide();
                  }
              },
          });
        }
      });
    }

    });
  });
// end here

    jQuery('#editVendorsFormClearBtn').on('click', function (){
        jQuery("#updateVendorForm")["0"].reset();
    });

</script>