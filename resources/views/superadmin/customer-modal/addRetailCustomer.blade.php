<!-- Modal -->
<div class="modal fade" id="addRetailCustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="" method="post" id="addRetailCustomerForm">
        <div class="modal-body bg-white px-3">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="customerName" class="required-field">Customer Name</label>
                  <input type="text" name="customerName" id="customerName" class="form-control" placeholder="Customer Name" >
                </div>
              </div>
              <div class="col-md-6">
                <!-- <div class="form-group">
                  <label for="mobileNo" class="required-field" >Mobile Number</label>
                  <input type="text" name="mobileNo" id="mobileNo" class="form-control" minlength="7" maxlength="15" placeholder="Mobile Number" onkeypress="return /[0-9]/i.test(event.key)">
                </div> -->
                  <div class="form-group">
                    <label for="phoneNo" class="required-field" >Phone Number</label>
                    <input type="text" name="phoneNo" id="phoneNo" class="form-control" minlength="8" maxlength="8" placeholder="Phone Number" onkeypress="return /[0-9]/i.test(event.key)">
                  </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="emailId">Email ID</label>
                  <input type="email" name="emailId" id="emailId" class="form-control" placeholder="Email ID">
                </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                    <label for="postcode">Postal Code <span style="color:red;">*</span></label>
                    <input type="text" name="postcode" class="form-control" id="customer_postcode" placeholder="Postal Code">
                 </div>
              </div>
            </div>
            <div class="row">
              <!-- <div class="col-md-6">
                 <div class="form-group">
                    <label for="postcode">Password <span style="color:red;">*</span></label>
                    <input type="text" name="password" class="form-control" id="password" placeholder="Password">
                 </div>
              </div> -->
              
              <div class="col-md-6">
                <div class="form-group">
                  <label for="address">Address<span style="color:red;">*</span></label>
                  <textarea name="address" id="address2" placeholder="Address" class="form-control" rows="5"></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="unit">Unit <span style="color:red;">*</span></label>
                    <input type="text" name="unit" class="form-control" id="unit" rows="4" placeholder="Unit">
                </div>
              </div>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addCustomerClearBtn">Clear</button>
          <button type="submit" id="addCustomerForm1" class="btn btn-primary">Save</button>
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
  // store data in db

  $('#addCustomerClearBtn').on('click', function(){
    $('#addRetailCustomerForm')["0"].reset();
  });

  // validation script start here
  $(document).ready(function() {
    jQuery("#addRetailCustomerForm").submit(function(e) {
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
        // required: true,
      },
      // password: {
      //   required: true,
      // },
      postcode: {
        required: true,
      },
      unit: {
        required: true,
      },
        phoneNo: {
            required: true,
            number: true,
            minlength: 8,
            maxlength: 8,
          },
          
    },
    messages : {
      name: {
        minlength: "Name should be at least 3 characters"
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
            url: "{{ route('SA-AddRetailCustomer') }}",
            data: jQuery("#addRetailCustomerForm").serialize(),
            enctype: "multipart/form-data",
            type: "post",
            success: function(result) {
              if (result.error != null) {
                errorMsg(result.error);
              } else if (result.barerror != null) {
                jQuery("#addCustomerAlert").hide();
                errorMsg(result.barerror);
              } else if (result.success != null) {
                successMsg(result.success);
                $('.modal .close').click();
                jQuery("#addCustomerForm")["0"].reset();
                retail_customer_table.ajax.reload();
              } else {
                jQuery("addCustomerAlertwarning").hide();
                jQuery("#addCustomerAlert").hide();
              }
            },
          });
        }
      });
    }
    });
  });
// end here

</script>
<script>
    $(document).on('change', '#customer_postcode', function(){
        let postcode = $(this).val();

        jQuery.ajax({
            url: "{{route('user.postal.addresses.backend')}}",
            type: "get",
            data: {
                "postalcode" : postcode,
                // "returnGeom" : 'N',
                // "getAddrDetails" : 'Y',
            },
            beforeSend : function(){
              $('#address2').val('Loading...');
              $('#address2').attr('readonly', true);
            },
            success : function(response){
              
              if (JSON.parse(response).found == 0) {
                        $('#address2').val('');
                        $('#customer_postcode').val('');
                        toastr.error('Please Enter Valid Postal Code');
                    } else {
                        $('#address2').val(JSON.parse(response).results[0].ADDRESS);
                        $('#address2').removeAttr('readonly');
                    }
            }
        });
  });


  

</script>