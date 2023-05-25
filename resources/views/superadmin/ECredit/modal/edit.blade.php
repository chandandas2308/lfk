<!-- Modal -->
<div class="modal fade" id="updateECredit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editECreditForm">
        <div class="modal-body bg-white px-3">

        <input type="hidden" name="id" id="idUpdate">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="customer_name">Price <span style="color:red; font-size:medium">*</span></label>
                    <input type="text" name="price" class="form-control" id="priceUpdate" placeholder="Price" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="invoiceNo">Points <span style="color:red; font-size:medium">*</span></label>
                    <input type="text" name="points" class="form-control" id="pointsUpdate" placeholder="Total Points" />
                  </div>
                </div>
              </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="editECreditFormClr">Clear</button>
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


    jQuery('#editECreditFormClr').on('click', function() {
      jQuery("#editECreditForm")["0"].reset();
    });

   jQuery(document).ready(function() {
    jQuery("#editECreditForm").submit(function(e) {
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
              url: "{{ route('SA-UpdateSingleECredit') }}",
              data: jQuery("#editECreditForm").serialize(),
              type: "post",
              success: function(result) {
                if (result.error != null)
                {
                  errorMsg(result.error);
                }
                else if (result.barerror != null) 
                {
                  jQuery("#addReffelaingettingAlert").hide();
                  errorMsg(result.barerror);
                } 
                else if (result.success != null)
                {
                  jQuery(".alert-danger").hide();
                  successMsg(result.success);
                  getECredit();
                  $('.modal .close').click();
                  $("#lp").click();
                }
                 else 
                 {
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