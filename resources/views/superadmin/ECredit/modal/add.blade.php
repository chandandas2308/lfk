<!-- Modal -->
<div class="modal fade" id="addECredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="addECreditForm">
        <div class="modal-body bg-white px-3"> 

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="customer_name">Price <span style="color:red; font-size:medium">*</span></label>
                    <input type="text" name="price" class="form-control" id="price" placeholder="Price" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="invoiceNo">Points <span style="color:red; font-size:medium">*</span></label>
                    <input type="text" name="points" class="form-control" id="points" placeholder="Total Points" />
                  </div>
                </div>
              </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="addECreditFormClr">Clear</button>
            <button type="submit" id="Rewardcreate1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!--  -->
<!--  -->
<!-- 

 -->
 
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
<script>
 

    $(document).ready(function(){
        getRefferal();
    });

    jQuery('#addECreditFormClr').on('click', function() {
      jQuery("#addECreditForm")["0"].reset();
    });
        
        // get customer list
        function getRefferal(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RefergetId')}}",
                success : function (response){
                    //$('#customerName').append('<option value="">Select Customer</option>');
                    jQuery.each(response, function(key, value){
                        $("#points").val(value["reward_points"]);
                        $("#additionalpoints").val(value["additional_points"]);
                    });
                }
            });
        }

   jQuery(document).ready(function() {
    jQuery("#addECreditForm").submit(function(e) {
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
      });
    }).validate({
      rules:{
        price:{
          required:true,
          number:true,
          min:1,
        },
        price:{
          required:true,
          number:true,
          min:1
        }
      },
      message:{

      },
      submitHandler:function(){
        bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
          if(result){
            $.ajax({
              url: "{{ route('SA-StoreECredit') }}",
              data: jQuery("#addECreditForm").serialize(),
              type: "post",
              success: function(result) {
                // jQuery(".alert-danger>ul").html(
                //   "<li> Info ! Please complete below mentioned fields : </li>"
                // );
                if (result.error != null) {
                  // jQuery.each(result.error, function(key, value) {
                  //   jQuery(".alert-danger").show();
                  //   jQuery(".alert-danger>ul").append(
                  //     "<li>" + key + " : " + value + "</li>"
                  //   );
                  // });
                  errorMsg(result.error);
                } else if (result.barerror != null) {
                  jQuery("#addReffelaingettingAlert").hide();
                  // jQuery(".alert-danger").show();
                  // jQuery(".alert-danger").html(result.barerror);
                  errorMsg(result.barerror);
                } else if (result.success != null) {
                  jQuery(".alert-danger").hide();
                  // jQuery("#addReffelaingettingAlert").html(result.success);
                  // jQuery("#addReffelaingettingAlert").show();
                  successMsg(result.success);
                  getECredit();
                  $('.modal .close').click();
                  $("#lp").click();
                } else {
                  jQuery(".alert-danger").hide();
                  jQuery("#addReffelaingettingAlert").hide();
                }
              }
            });
          }
        });
      }
    });
    // });
  });
</script>