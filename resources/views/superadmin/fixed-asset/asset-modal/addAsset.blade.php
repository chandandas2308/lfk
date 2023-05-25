<!-- Modal -->
<div class="modal fade" id="addAsset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Asset</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="addAssetForm">
        <div class="modal-body bg-white px-3">

                <!-- info & alert section -->
                <!-- <div class="alert alert-success"  style="display:none"></div> -->

                <div class="alert alert-success alert-dismissible fade show" role="alert" id="addAssetAlert"  style="display: none;">
                  <strong>Info!</strong> <span id="addAssetAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="alert alert-warning alert-dismissible fade show" role="alert" id="addAssetAlertwarning"  style="display: none;">
                  <strong>Info!</strong> <span id="addAssetAlertwarningMSG"></span>
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
                        <input type="text" name="name" id="name" class="form-control text-dark" placeholder="Name">
                        
                      </div>

                      <!-- Quantity -->
                      <div class="form-group">
                        <label for="quantity" class="required-field">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control text-dark" placeholder="Quantity">
                        
                      </div>

                      <!-- Price -->
                      <div class="form-group">
                        <label for="price" class="required-field">Price</label>
                        <input type="number" name="price" id="price" class="form-control text-dark" placeholder="Price">
                        
                      </div>

                      <!-- GST -->
                      <div class="form-group">
                        <label for="gst" >GST</label>
                        <input type="number" name="gst" id="gst" class="form-control text-dark" placeholder="GST">
                        
                      </div>                      

                  </div>
                </div>    

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="addAssetClearBtn">Clear</button>
            <button type="submit" id="addAssetForm1" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

  $('#addAssetClearBtn').on('click', function(){
    $("#addAssetForm")["0"].reset();
  });

// validation script start here
  $(document).ready(function() {
    $("#addAssetForm").validate({
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
        jQuery("#addAssetForm").submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

     
        jQuery.ajax({
            url: "{{ route('SA-AddAsset') }}",
            data: jQuery("#addAssetForm").serialize(),
            enctype: "multipart/form-data",
            type: "post",

            success: function (result) {
                if(result.error !=null ){
                    jQuery(".alert-danger>ul").html(
                            "<li> Info ! Please complete below mentioned fields : </li>"
                        );
                    jQuery.each(result.error, function (key, value) {
                        // jQuery(".alert-danger").show();
                        // jQuery(".alert-danger>ul").append(
                        //     "<li>" + value + "</li>"
                        // );
                    });
                }
                else if(result.barerror != null){
                  jQuery("#addAssetAlert").hide();
                    jQuery("#addAssetAlertwarning").show();
                    jQuery("#addAssetAlertwarningMSG").html(result.barerror);
                }
                else if(result.success != null){
                  jQuery("#addAssetAlertwarning").hide();
                    jQuery("#addAssetAlertMSG").html(result.success);
                    jQuery("#addAssetAlert").show();
                    jQuery("#addAssetForm")["0"].reset();
                    getAssetDetials();
                }else {
                  jQuery("#addAssetAlertwarning").hide();
                  jQuery("#addAssetAlert").hide();
                }
            },
        });
    });
</script>