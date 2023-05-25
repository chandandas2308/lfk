<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Details</h5>
        <button type="button" class="close" id="closeUser" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="addUserForm">
        <div class="modal-body bg-white px-3">
          <!-- info & alert section -->
          <div class="alert alert-success alert-dismissible fade show" id="addUserAlert" style="display:none" role="alert">
            <strong></strong> <span id="addUserSuccessAlert"></span>
            <button type="button" class="close" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="alert alert-danger alert-dismissible fade show" id="addUserErrorAlert" style="display:none" role="alert">
            <strong></strong> <span id="addUserDangerAlert"></span>
            <button type="button" class="close" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- end -->

          <div class="">
            <div class="">

              <!-- username -->
              <div class="form-group row">
                <label for="username" class="col-sm-3 col-form-label">User Name<span style="color:red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="username" id="username" placeholder="User Name" require />
                </div>
              </div>
              <!-- mobile number -->
              <div class="form-group row">
                <label for="mobilenumber" class="col-sm-3 col-form-label">Mobile Number<span style="color:red;">*</span></label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="mobilenumber" id="mobilenumber" placeholder="Mobile Number" require />
                </div>
              </div>
              <!-- phone number -->
              <div class="form-group row">
                <label for="phonnumber" class="col-sm-3 col-form-label">Home Number</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="phonenumber" id="phonnumber" placeholder="Home Number" require />
                </div>
              </div>
              <!-- Email ID -->
              <div class="form-group row">
                <label for="emailid" class="col-sm-3 col-form-label">Email ID<span style="color:red;">*</span></label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" name="emailid" id="emailid" placeholder="Email" require />
                </div>
              </div>
              <!-- Password -->
              <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Password<span style="color:red;">*</span></label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" require />
                </div>
              </div>
              <!-- checkbox -->

              <!-- checkbox -->
              <div class="form-group row">
                <label for="exampleInputPassword2" class="col-sm-3 col-form-label">User rights<span style="color:red;">*</span></label>
                <div class="col-sm-9">
                  <div class="form-group" id="userRights">
                    <div class="" style="font-size: smaller; color:red;" id="userRightsError"></div>
                    <div class="row ml-1">
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one" value="all" name="list" id="accessToAll" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Access To All
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" name="list" value="sales" id="sales" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Sales
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="purchase" name="list" id="purchase" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2  !important;border-width: 2px;margin-top: 0px;" />&nbsp; Purchase
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="refferalAwards" name="list" id="refferalAwards"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Referral Awards
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row ml-1">
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="inventory" name="list" id="inventory" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Inventory
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="loyalitysystem" name="list" id="loyalitysystem"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Loyalty System
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="offerpackage" name="list" id="offerpackage" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Offer and Package
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="reports" name="list" id="reports" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Reports
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="row ml-1">
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="customerManagement" name="list" id="customerManagement" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Customer Management
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="deliveryManagement" name="list" id="deliveryManagement" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Delivery Management
                          </label>
                        </div>
                      </div>
                      <div class="col-md-6 col-sm-6 col-lg-3">
                        <div class="form-check form-check-primary">
                          <label class="">
                            <input type="checkbox" class="form-check-input require-one cb_child" value="eCredit" name="list" id="eCredit"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; E-Credit Options
                          </label>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="clearFormBtn">Clear</button>
          <button type="submit" id="addUserForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  // validation script start here
  $(document).ready(function() {

    // var value = $("#password").val();
      // store data in db
    jQuery("#addUserForm").submit(function(e) {
      e.preventDefault();
      
      let userRightsAre = Array.from($('#userRights').find('input[type="checkbox"]')).filter((checkbox) => checkbox.checked).map((checkbox) => checkbox.value);

      if(userRightsAre.length == 0){
          $('#userRightsError').html('User Rights field required.');
        }else{
          $('#userRightsError').html('');
        }


      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
      });

      $.validator.addMethod("checkUsername", function(value) {
        return $("#username").val() != null;
      });

      $.validator.addMethod("isValidEmailAddress", function(value) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(value);
      });

    }).validate({
      rules: {
        username: {
          required: true,
          minlength: 3
        },
        phonenumber: {
          number: true,
          minlength: 7,
          maxlength: 15,
        },
        mobilenumber: {
          required: true,
          number: true,
          minlength: 7,
          maxlength: 15,
        },
        emailid: {
          required: true,
          isValidEmailAddress: true,
          email: true,
        },
        password: {
          required: true,
          minlength: 8,
        },
        // "list": {
        //   required: true,
        //   minlength: 1,
        // }
      },
      messages: {
        name: {
          minlength: "Username should be at least 3 characters"
        },
        phonenumber: {
          number: "Please enter your phone number as a numerical value",
          minlength: "Phone number should be at least 7 digits.",
          maxlength: "Your phone number can be 15 digits"
        },
        mobilenumber: {
          required: "Please enter your phone number",
          number: "Please enter your phone number as a numerical value",
          minlength: "Your phone number should be 7 digits",
          maxlength: "Your phone number can be 15 digits"
        },
        emailid: {
          email: "The email should be in the format: abc@domain.tld",
          isValidEmailAddress: "Please enter valid email address."
        },
        password: {
          required: "Please enter your password",
          minlength: "Password should be at least 8 digits",
        },
      },
      submitHandler:function(){

        let userRightsAre = Array.from($('#userRights').find('input[type="checkbox"]')).filter((checkbox) => checkbox.checked).map((checkbox) => checkbox.value);

        if(userRightsAre.length == 0){
          $('#userRightsError').html('User Rights field required.');
        }else{
          $('#userRightsError').html('');

          bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
            if(result){
              jQuery.ajax({
                url: "{{ route('SA-AddNewUser') }}",
                data: jQuery("#addUserForm").serialize()+"&userRightsAre="+userRightsAre,
                enctype: "multipart/form-data",
                type: "post",

                success: function(result) {
                  user_management_main_table.ajax.reload();
                  if (result.error != null) {
                    errorMsg(result.error);
                  } 
                  else if (result.barerror != null) {
                    jQuery("#addUserAlert").hide();
                    errorMsg(result.barerror);
                  } else if (result.success != null) {
                    jQuery("#addUserAlert").hide();
                    $('.modal .close').click();
                    successMsg(result.success);
                    jQuery("#addUserForm")["0"].reset();
                    user_management_main_table.ajax.reload();
                    $('#addUserErrorAlert').hide();
                  } else {
                    jQuery("#addUserAlert").hide();
                    jQuery("#addUserAlert").hide();
                  }
                },
              });
            }
          });

        }
      }
    });
  });
  // end here

  
  $('input[type="checkbox"]').click(function() {
    var allChecked = $('#accessToAll').prop('checked');
    var inventory = $('#inventory').prop('checked');
    var sales = $('#sales').prop('checked');
    var purchase = $('#purchase').prop('checked');
    var reports = $('#reports').prop('checked');
    var deliveryManagement = $('#deliveryManagement').prop('checked');
    var eCredit = $('#eCredit').prop('checked');
    var refferalAwards = $('#refferalAwards').prop('checked');
    var offerpackage = $('#offerpackage').prop('checked');
    var loyalitysystem = $('#loyalitysystem').prop('checked');
    var customerManagement = $('#customerManagement').prop('checked');
    if (allChecked || inventory || sales || purchase || reports || customerManagement || deliveryManagement || eCredit || refferalAwards || offerpackage || loyalitysystem) {
      $('#userRightsError').html('');
    } else {
      $('#userRightsError').html('User Rights field required.');
    }
  });

  // remove Access to all
  $('#accessToAll').change(function(){
    $('.cb_child').prop('checked',this.checked)
  })
  $('.cb_child').change(function(){
    if ( $('.cb_child:checked').length== $('.cb_child').length){
      $('#accessToAll').prop('checked',true);
    }else{
      $('#accessToAll').prop('checked',false);
    }
  })

  jQuery('#clearFormBtn').on('click', function() {
    jQuery("#addUserForm")["0"].reset();
  });
</script>