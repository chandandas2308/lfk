<!-- Modal -->
<div class="modal fade" id="addAssetTracking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Asset Tracking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="assetTrackForm">
        <div class="modal-body bg-white px-3">

                <!-- info & alert section -->
                
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="addAssetTrackingAlert" style="display: none;">
                  <strong>Info!</strong> <span id="addAssetTrackingMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-warning alert-dismissible fade show" role="alert" id="addAssetTrackingwarning" style="display: none;">
                  <strong>Info!</strong> <span id="addAssetTrackingwarningMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>


                <!-- end -->
           
              <div class="card">
                  <div class="card-body">
                    <!-- Name -->
                      <div class="form-group">
                        <label for="name" class="required-field">Name</label>
                        <select name="name" id="assetName" onchange="getQuantity()" class="form-control"></select>
                      </div>

                      <!-- Quantity -->
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantityAssetTracking" class="form-control text-dark" placeholder="Quantity" readonly>
                      </div>

                      <!-- Price -->
                      <div class="form-group">
                        <label for="location" class="required-field">Location</label>
                        <input type="text" name="location" id="location" class="form-control text-dark" placeholder="Location">
                      </div>

                      <!-- GST -->
                      <div class="form-group">
                        <label for="status" class="required-field">Status</label>
                        <select name="status" id="status"  class="form-control">
                        <option value="">Select status</option>
                          <option value="active">Active</option>
                          <option value="inactive">Inactive</option>
                        </select>
                      </div>                      

                  </div>
                </div>    

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="addAssetTrackingClearBtn">Clear</button>
            <button type="submit" id="assetTrackForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>


$('#addAssetTrackingClearBtn').on('click', function(){
    $("#assetTrackForm")["0"].reset();
  });

// validation script start here
  $(document).ready(function() {
    $("#assetTrackForm").validate({
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
    function getQuantity(){
      let id = this.event.target.id;
      let value = $('#'+id).val();

        getAssetDetials();
        function getAssetDetials(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAssetQuantity')}}",
                data : {
                    'value' : value,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#quantityAssetTracking').val(value["quantity"]);
                  });
                }
              });
        }
    }

    // store data in db

        jQuery("#assetTrackForm").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

     
        jQuery.ajax({
            url: "{{ route('SA-AddAssetTrackingData') }}",
            data: jQuery("#assetTrackForm").serialize(),
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
                  jQuery("#addAssetTrackingAlert").hide();
                    jQuery("#addAssetTrackingwarning").show();
                    jQuery("#addAssetTrackingwarningMSG").html(result.barerror);
                }
                else if(result.success_stock_tracking != null){
                    jQuery("#addAssetTrackingAlert").show();
                    jQuery("#addAssetTrackingMSG").html(result.success_stock_tracking);
                    jQuery("#addAssetTrackingwarning").hide();
                    jQuery("#assetTrackForm")["0"].reset();
                    getAssetTrackingDetials();
                }else {
                  jQuery("#addAssetTrackingwarning").hide();
                  jQuery("#addAssetTrackingAlert").hide();
                }
            },
        });
    });
</script>