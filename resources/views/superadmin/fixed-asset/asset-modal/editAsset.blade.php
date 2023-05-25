<!-- Modal -->
<div class="modal fade" id="editAsset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Asset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="editAssetForm">
        <div class="modal-body bg-white px-3">

                <!-- info & alert section -->
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="editAssetAlert" style="display: none;">
                  <strong>Info!</strong> <span id="editAssetAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-warning alert-dismissible fade show" role="alert" id="editAssetAlertwarning"  style="display: none;">
                  <strong>Info!</strong> <span id="editAssetAlertwarningMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              <!-- end -->
           
              <div class="card">
                  <div class="card-body">
                    <!-- Id -->
                    <input type="text" name="assetId" id="assetId" class="form-control" style="display: none;" />
                    <!-- Name -->
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="nameEdit" class="form-control text-dark" placeholder="Name">
                        
                      </div>

                      <!-- Quantity -->
                      <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantityEdit" class="form-control text-dark" placeholder="Quantity">
                        
                      </div>

                      <!-- Price -->
                      <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="priceEdit" class="form-control text-dark" placeholder="Price">
                        
                      </div>

                      <!-- GST -->
                      <div class="form-group">
                        <label for="gst">GST</label>
                        <input type="number" name="gst" id="gstEdit" class="form-control text-dark" placeholder="GST">
                        
                      </div>                      

                  </div>
                </div>    

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="editAssetClearBtn">Clear</button>
            <button type="submit" id="editAssetForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

$('#editAssetClearBtn').on('click', function(){
    $("#editAssetForm")["0"].reset();
  });

  // validation script start here
  $(document).ready(function() {
    $("#editAssetForm").validate({
    rules: {
      name : {
        required: true,
        minlength: 3
      },
      quantity: {
        required: true,
        number: true,
        min: 1,
      },
      price: {
        required: true,
      },
    },
    messages : {
      name: {
        minlength: "Name should be at least 3 characters"
      },
      quantity: {
        required: "Please enter quantity.",
        number: "Please enter valid numerical value.",
      },
    }
    });
  });
// end here

    // store data in db

        jQuery("#editAssetForm").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

     
        jQuery.ajax({
            url: "{{ route('SA-UpdateAsset') }}",
            data: jQuery("#editAssetForm").serialize(),
            enctype: "multipart/form-data",
            type: "post",

            success: function (result) {
                if(result.error !=null ){
                    jQuery(".alert-danger>ul").html(
                            "<li> Info ! Please complete below mentioned fields : </li>"
                        );
                    jQuery.each(result.error, function (key, value) {
                        jQuery(".alert-danger").show();
                        jQuery(".alert-danger>ul").append(
                            "<li>" + value + "</li>"
                        );
                    });
                }
                else if(result.barerror != null){
                  jQuery("#editAssetAlert").hide();
                    jQuery("#editAssetAlertwarning").show();
                    jQuery("#editAssetAlertwarningMSG").html(result.barerror);
                }
                else if(result.success != null){
                  jQuery("#editAssetAlertwarning").hide();
                    jQuery("#editAssetAlertMSG").html(result.success);
                    jQuery("#editAssetAlert").show();
                    jQuery("#addAssetForm")["0"].reset();
                    getAssetDetials();
                }else {
                  jQuery("#editAssetAlertwarning").hide();
                  jQuery("#editAssetAlert").hide();
                }
            },
        });
    });
</script>