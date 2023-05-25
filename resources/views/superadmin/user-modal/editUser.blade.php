<!-- Modal -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editUserForm">
        <div class="modal-body bg-white px-3">
                <!-- info & alert section -->
                <!-- <div class="alert alert-success" id="editUserAlert" style="display:none"></div>
                  <div class="alert alert-danger" style="display:none">
                    <ul></ul>
                  </div> -->
                <!-- end -->

                <!-- info & alert section -->
                <div class="alert alert-success alert-dismissible fade show" id="editUserAlert" style="display:none;" role="alert">
                  <strong></strong> <span id="editUserSuccessAlert"></span>
                  <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                  <div class="alert alert-danger alert-dismissible fade show" id="editUserErrorAlert" style="display:none;" role="alert">
                    <strong></strong> <span id="editUserDangerAlert"></span>
                    <button type="button" class="close" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <!-- end -->
           
                <div class="">
                  <div class="">

                      <input type="text" name="id" id="editUserFormId" style="display: none;">

                      <!-- username -->
                      <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">User Name<span style="color:red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="username" id="usernameEdit" placeholder="User Name" require />
                        </div>
                      </div>
                      <!-- mobile number -->
                      <div class="form-group row">
                        <label for="mobilenumber" class="col-sm-3 col-form-label">Mobile Number<span style="color:red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="mobilenumber" id="mobilenumberEdit" placeholder="Mobile number" require />
                        </div>
                      </div>
                      <!-- phone number -->
                      <div class="form-group row">
                        <label for="phonnumber" class="col-sm-3 col-form-label">Home Number</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" name="phonenumber" id="phonnumberEdit" placeholder="Home Number" require />
                        </div>
                      </div>
                      <!-- Email ID -->
                      <div class="form-group row">
                        <label for="emailid" class="col-sm-3 col-form-label">Email ID<span style="color:red;">*</span></label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" name="emailid" id="emailidEdit" placeholder="Email" require />
                        </div>
                      </div>

                      <!-- checkbox -->
                      <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">User rights<span style="color:red;">*</span></label>
                      <div class="col-sm-9">
                        <div class="form-group" id="userRightsUpdate">
                          <div class="" style="font-size: smaller; color:red;" id="userRightsErrorEdit"></div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one" value="all" name="list" id="accessToAllEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Access To All
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" name="list" value="sales" id="salesEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Sales
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="purchase" name="list" id="purchaseEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2  !important;border-width: 2px;margin-top: 0px;" />&nbsp; Purchase
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="refferalAwards" name="list" id="refferalAwardsEdit"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Referral Awards
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="inventory" name="list" id="inventoryEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Inventory
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="loyalitysystem" name="list" id="loyalitysystemEdit"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Loyalty System
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="offerpackage" name="list" id="offerpackageEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Offer and Package
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="reports" name="list" id="reportsEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Reports
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="customerManagement" name="list" id="customerManagementEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Customer Management
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="deliveryManagement" name="list" id="deliveryManagementEdit" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Delivery Management
                                </label>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-check form-check-primary">
                                <label class="">
                                  <input type="checkbox" class="form-check-input require-one cb_child_edit" value="eCredit" name="list" id="eCreditEdit"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; E-Credit Options
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
            <button type="button" class="btn btn-primary" id="clearEditFormBtn">Clear</button>
            <button type="submit" id="editUserForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
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

var edit_status;

// validation script start here
$(document).ready(function() {
  // store data in db
  jQuery("#editUserForm").submit(function (e) {

    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
    });

    let userRightsAreEdit = Array.from($('#userRightsUpdate').find('input[type="checkbox"]')).filter((checkbox) => checkbox.checked).map((checkbox) => checkbox.value);

    if(userRightsAreEdit.length == 0){
      $('#userRightsErrorEdit').html('User Rights field required.');
    }else{
      $('#userRightsErrorEdit').html('');
    }

    $.validator.addMethod("checkUsername", function(value) {
      return $("#username").val()!=null;
    });

    $.validator.addMethod("isValidEmailAddress", function(value) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(value);
    });

  }).validate({
      rules: {
        username : {
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
          isValidEmailAddress:true,
          email: true,
        },
      },
      messages : {
        name: {
          minlength: "Username should be at least 3 characters"
        },
        mobilenumber: {
          required: "Please enter your phone number",
          checkUsername : "Please enter username first",
          number: "Please enter your phone number as a numerical value",
          min: "Your phone number should be 7 digits",
          max: "Your phone number can be 15 digits"
        },
        phonenumber: {
          number: "Please enter your phone number as a numerical value",
          min: "Your phone number should be 7 digits",
          max: "Your phone number can be 15 digits"
        },
        emailid: {
          email: "The email should be in the format: abc@domain.tld",
          isValidEmailAddress: "Please enter valid email address."
        },
      },
      submitHandler:function(){
        let userRightsAreEdit = Array.from($('#userRightsUpdate').find('input[type="checkbox"]')).filter((checkbox) => checkbox.checked).map((checkbox) => checkbox.value);

        if(userRightsAreEdit.length == 0){
          $('#userRightsErrorEdit').html('User Rights field required.');
        }else{

          $('#userRightsErrorEdit').html('');

          bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
            if(result){
              jQuery.ajax({
                url: "{{ route('SA-UpdateUser') }}",
                data: jQuery("#editUserForm").serialize()+"&userRightsAre="+userRightsAreEdit,
                enctype: "multipart/form-data",
                type: "post",

                success: function (result) {
                  user_management_main_table.ajax.reload();
                  if(result.error !=null ){
                    errorMsg(result.error);
                  }
                  else if(result.barerror != null){
                      errorMsg(result.barerror);
                      jQuery("#editUserAlert").hide();
                  }
                  else if(result.success != null){
                    user_management_main_table.ajax.reload();
                      jQuery("#editUserErrorAlert").hide();
                        successMsg(result.success);
                        $('.modal .close').click();
                  }else {
                      jQuery("#editUserErrorAlert").hide();
                      jQuery("#editUserAlert").hide();
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

function checkArra(){
          $('#userRightsErrorEdit').html('');
}

      

      $('input[type="checkbox"]').click(function() {
        var allCheckedEdit = $('#accessToAllEdit').prop('checked');
        var inventoryEdit = $('#inventoryEdit').prop('checked');
        var salesEdit = $('#salesEdit').prop('checked');
        var purchaseEdit = $('#purchaseEdit').prop('checked');
        var reportsEdit = $('#reportsEdit').prop('checked');
        var deliveryManagementEdit = $('#deliveryManagementEdit').prop('checked');
        var eCreditEdit = $('#eCreditEdit').prop('checked');
        var refferalAwardsEdit = $('#refferalAwardsEdit').prop('checked');
        var offerpackageEdit = $('#offerpackageEdit').prop('checked');
        var loyalitysystemEdit = $('#loyalitysystemEdit').prop('checked');
        var customerManagementEdit = $('#customerManagementEdit').prop('checked');

        if (allCheckedEdit || inventoryEdit || salesEdit || purchaseEdit || reportsEdit || customerManagementEdit || deliveryManagementEdit || eCreditEdit || refferalAwardsEdit || offerpackageEdit || loyalitysystemEdit) {
          $('#userRightsErrorEdit').html('');
        } else {
          $('#userRightsErrorEdit').html('User Rights field required.');
        }
      });

      // remove Access to all
      $('#accessToAllEdit').change(function(){
        $('.cb_child_edit').prop('checked',this.checked)
      })
      $('.cb_child_edit').change(function(){
        if ( $('.cb_child_edit:checked').length== $('.cb_child_edit').length){
          $('#accessToAllEdit').prop('checked',true);
        }else{
          $('#accessToAllEdit').prop('checked',false);
        }
      })

      jQuery('#clearEditFormBtn').on('click', function (){
        jQuery("#editUserForm")["0"].reset();
      });

</script>