<!-- Modal -->
<div class="modal fade" id="editAssetTracking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Asset Tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editAssetTrackForm">
        <div class="modal-body bg-white px-3">

                <!-- info & alert section -->
                
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="editAssetTrackingAlert" style="display: none;">
                  <strong>Info!</strong> <span id="editAssetTrackingAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-warning alert-dismissible fade show" role="alert" id="editAssetTrackingAlertwarning" style="display: none;">
                  <strong>Info!</strong> <span id="editAssetTrackingAlertwarningMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>


                <!-- end -->
           
              <div class="card">
                  <div class="card-body">

                    <input type="text" name="assetId" id="assetTrackingId" class="form-control" style="display: none;">

                    <!-- Name -->
                      <div class="form-group">
                        <label for="name" class="required-field">Name</label>
                        <input name="name" id="assetNameEdit" class="form-control" readonly>
                        <!-- <select name="name" id="assetNameEdit" onchange="getQuantityEdit()" class="form-control"></select> -->
                      </div>

                      <!-- Quantity -->
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantityAssetTrackingEdit" class="form-control text-dark" placeholder="Quantity" readonly>
                        <span style="display:none;color:red;" id="quantityerror">This is a required field</span>
                      </div>

                      <!-- Price -->
                      <div class="form-group">
                        <label for="location" class="required-field">Location</label>
                        <input type="text" name="location" id="locationEdit" class="form-control text-dark" placeholder="Location">
                        <span style="display:none;color:red;" id="locationerror">This is a required field</span>
                      </div>

                      <!-- GST -->
                      <div class="form-group">
                        <label for="status" class="required-field">Status</label>
                        <select name="status" id="statusEdit"  class="form-control">
                        <option value="">Select status</option>
                          <option value="active">Active</option>
                          <option value="inactive">Inactive</option>
                        </select>
                      </div>                      

                  </div>
                </div>    

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="editAssetTrackingClearBtn" >Clear</button>
            <button type="submit" id="editAssetTrackForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

$('#editAssetTrackingClearBtn').on('click', function(){
    $("#editAssetTrackForm")["0"].reset();
  });

  // validation script start here
  $(document).ready(function() {
    $("#editAssetTrackForm").validate({
    rules: {
      name : {
        required: true,
      },
      location: {
        required: true,
      },
      status:{
        required: true,
      }
    },
    messages : {
    }
    });
  });
// end here


    // get quantity by choose asset name
    function getQuantityEdit(){
      let id = this.event.target.id;
      let value = $('#'+id).val();

        getAssetDetialsEdit();
        function getAssetDetialsEdit(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAssetQuantity')}}",
                data : {
                    'value' : value,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#quantityAssetTrackingEdit').val(value["quantity"]);
                  });
                }
              });
        }
    }

    // store data in db

        jQuery("#editAssetTrackForm").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

     
        jQuery.ajax({
            url: "{{ route('SA-UpdateAssetTrackingDetails') }}",
            data: jQuery("#editAssetTrackForm").serialize(),
            enctype: "multipart/form-data",
            type: "post",

            success: function (result) {
                if(result.error !=null ){
                    // jQuery(".alert-danger>ul").html(
                    //         "<li> Info ! Please complete below mentioned fields : </li>"
                    //     );
                    // jQuery.each(result.error, function (key, value) {
                    //     jQuery(".alert-danger").show();
                    //     jQuery(".alert-danger>ul").append(
                    //         "<li>" + value + "</li>"
                    //     );
                    // });
                }
                else if(result.barerror != null){
                  jQuery("#editAssetTrackingAlert").hide();
                    jQuery("#editAssetTrackingAlertwarning").show();
                    jQuery("#editAssetTrackingAlertwarningMSG").html(result.barerror);
                }
                else if(result.update_success != null){
                  jQuery("#editAssetTrackingAlert").show();
                  jQuery("#editAssetTrackingAlertMSG").html(result.update_success);
                  getAssetTrackingDetials();
                  jQuery("#editAssetTrackingAlertwarning").hide();
                }else {
                  jQuery("#editAssetTrackingAlertwarning").hide();
                  jQuery("#editAssetTrackingAlert").hide();
                }
            },
        });
    });
</script>