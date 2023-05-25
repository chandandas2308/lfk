<!-- Modal -->
<div class="modal fade" id="createReffereal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Referral point Setting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="Rewardcreate">
        <div class="modal-body bg-white px-3"> 
            <!-- invoice body start here -->

            <!-- info & alert section -->
                <div class="alert alert-success" id="addReffelaingettingAlert" style="display:none"></div>
                <div class="alert alert-danger" style="display:none">
                    <ul></ul>
                </div>
              <!-- end -->

            <!-- row 1 -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="points">Reward Points Per Person</label>
                    <input type="text" name="points" id="points" class="form-control" placeholder="Reward Points Per Person">
                </div>
                <div class="col-md-6">
                    <label for="additionalpoints">Additional Points</label>
                    <input type="text" name="additionalpoints" id="additionalpoints" class="form-control" placeholder="Additional Points">
                </div>
            </div>

            <!-- end here -->

        </div>
        <div class="modal-footer">
            <button type="button" id="lp" class="btn btn-primary" data-dismiss="modal">Close</button>
            <button type="submit" id="Rewardcreate1" class="btn btn-primary">Save</button>
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
<script>
    $(document).ready(function(){
        getRefferal();
    });
        
        // get customer list
        function getRefferal(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RefergetId')}}",
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $("#points").val(value["reward_points"]);
                        $("#additionalpoints").val(value["additional_points"]);
                    });
                }
            });
        }

       
</script>
<script>
   jQuery(document).ready(function() {
    jQuery("#Rewardcreate").submit(function(e) {
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
      });

      bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
        if(result){
          $.ajax({
            url: "{{ route('SA-EditRewardcreate') }}",
            data: jQuery("#Rewardcreate").serialize(),
            type: "post",
            success: function(result) {
              refferal_main_table.ajax.reload();
              if (result.error != null) {

                errorMsg(result.error);

              } else if (result.barerror != null) {

                jQuery("#addReffelaingettingAlert").hide();
                errorMsg(result.barerror);
                
              } else if (result.success != null) {

                jQuery(".alert-danger").hide();
                successMsg(result.success);
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
    });
  });
</script>