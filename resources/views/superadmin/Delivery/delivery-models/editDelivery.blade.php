<div class="modal fade" id="edit_Delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Delivery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" id="editDeliveryForm1" method="post">
        @csrf
        <div class="modal-body p-3 bg-white">

          <!-- info & alert section -->
          <div class="alert alert-success" id="editDeliveryAlert" style="display:none"></div>
          <div class="alert alert-danger" style="display:none">
            <ul></ul>
          </div>

          <input type="text" name="id" id="editDeliveryId" style="display: none;">

          <div class="bg-white">
            <!-- <div class="card-body"> -->

            
                    <!-- row 0 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="quotationno1">Order No.<span style="color: red; font-size:small;">*</span></label>
                            <input type="text" class="form-control" id="selectOrder_no_ed" name="order_no" placeholder="Order No." readonly />
                            <!-- <select name="order_no" class="form-control" onchange="fetchOrdersDetails1()" id="selectOrder_no"></select> -->
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="mt-3"> -->
                              <label for="mobile_no">Mobile No. </label>
                              <input type="text" class="form-control" id="mob_no_delivery_ed" name="mobile_no" placeholder="mobile_no" readonly />
                            <!-- </div> -->
                        </div>
                    </div>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customer_name">Customer Name </label>
                            <input type="text" class="form-control" id="customer_name_delivery_ed" name="customer_name" placeholder="Customer Name" readonly />
                            <input type="text" name="customer_id" id="customer_id_delivery_ed" style="display:none;" />
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="mt-3"> -->
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="invoice_date_delivery_ed" name="date" readonly />
                            <!-- </div> -->
                        </div>
                    </div>

                    <!-- row 2 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label for="delivery_address">Delivery Address</label>
                          <input type="text" class="form-control" id="delivery_address_delivery_ed" name="delivery_address" placeholder="Address" readonly />
                        </div>
                        <div class="col-md-6">
                          <label for="deliveryman">Delivery Man <span style="color:red;">*</span> </label>
                          <select name="deliveryman" class="form-control" onchange="fetchDeliverymanIdUpdate()" id="selectdeliverymanED" ></select>
                          <input type="text" name="delivery_man_name" id="delivery_man_name_ed" style="display:none;" />
                          <input type="text" name="delivery_man_user_id" id="delivery_man_user_id_ed" style="display:none;" />
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label for="delivery_status">Delivery Status<span style="color:red;">*</span></label>
                          <input type="text" name="delivery_status" class="form-control" value="Packing"  id="delivery_status_ed" readonly >
                        </div>
                        <div class="col-md-6">
                          <label for="payment_status">Payment Status<span style="color:red;">*</span></label>
                          <select class="form-control" name="payment_status" id="payment_status_ed">
                            <option value="">Select Payment Status</option>
                            <option value="Paid">Paid</option>
                            <option value="Unpaid">Unpaid</option>
                          </select>
                        </div>
                    </div>

                    <!-- row 4 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label for="description">Description</label>
                          <textarea class="form-control" placeholder="enter description..." id="description_ed" name="description" cols="5" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                        <label for="pickup_address">Pickup Address<span style="color:red;">*</span></label>
                        <input type="text" class="form-control" placeholder="Pickup Address" id="editpickupid" name="editpickupname">
                        
                        </div>
                    </div>

                    <!-- row 5 -->
                    <div class="form-group row">
                      <div class="col">
                        <fieldset class="border border-secondary p-2">
                          <legend class="float-none w-auto p-2">Product Details</legend>
                          <span style="color:red; font-size:small;" id="createdeliverytableEmptyError"></span>

                          <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                            <table class="table text-center border" id="productTableDelivery_ed"  style="width: 100%; border-collapse: collapse;">
                              <thead>
                                <tr>
                                  <th>S/N</th>
                                  <th>Product Name</th>
                                  <th>Category</th>
                                  <th>Variant</th>
                                  <th>Description</th>
                                  <th>Quantity</th>
                                  <th>Unit Price</th>
                                  <th>Gross Amount</th>
                                  <th>Net Amount</th>
                                </tr>
                              </thead>
                              <tbody id="productTableBody9_ed"></tbody>
                            </table>
                          </div>
                        </fieldset>
                      </div>
                    </div>
              <!-- </div> -->
          </div>
    </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="addDeliveryFormClearBtnED">Clear</button>
          <button type="submit" id="editDeliveryForm" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>

    //get deliveryman name and id.
    getdeliverymannameUpdate();

    let deliveryManDetialsED = [];

    function getdeliverymannameUpdate() {
      $.ajax({
        type: "GET",
        url: "{{ route('SA-deliverymanList')}}",
        success: function(response) {

          deliveryManDetialsED = response;

          $('#selectdeliverymanED').html('');
          $('#selectdeliverymanED').append('<option value="">Select Delivery Man</option>');
          
          jQuery.each(response, function(key, value) {
            $('#selectdeliverymanED').append(
              '<option value="' + value["driver_id"] + '">\
                ' + value["driver_name"] + '\
              </option>'
            );
          });

        }
      });
    }

  
    //Fatch deliveryman Id.
    function fetchDeliverymanIdUpdate() {
      let id = $('#selectdeliverymanED').val();
      jQuery.each(deliveryManDetialsED, function(key, value) {
        if(id == value['id']){
          $('#delivery_man_name_ed').val(value['driver_name']);
          $('#delivery_man_user_id_ed').val(value['driver_ID']);
        }

      });
      }

// clear form
  jQuery('#addDeliveryFormClearBtnED').on('click', function() {
    jQuery("#editDeliveryForm1")["0"].reset();
  });

  // validation script start here
  $(document).ready(function() {

jQuery("#editDeliveryForm1").submit(function(e) {
  e.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    },
  });

  $.validator.addMethod("validate", function(value) {
    return /[A-Za-z]/.test(value);
  });

  }).validate({
    rules: {
      deliveryman: {
        required: true,
      },
      delivery_status: {
        required: true,
      },
      payment_status: {
        required: true,
      }
    },
    messages: {},
    submitHandler:function(){

      bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
          if(result){
            $.ajax({
              url: "{{ route('SA-EditDelivery') }}",
              data: jQuery("#editDeliveryForm1").serialize(),
              type: "post",
              success: function(result) {

                // alertHideFun();
                
                jQuery(".alert-danger>ul").html(
                  "<li> Info ! Please complete below mentioned fields : </li>"
                );
                if (result.error != null) {
                  // jQuery.each(result.error, function(key, value) {
                  //   jQuery(".alert-danger").show();
                  //   jQuery(".alert-danger>ul").append(
                  //     "<li>" + key + " : " + value + "</li>"
                  //   );
                  // });
                  errorMsg(result.error);
                } else if (result.barerror != null) {
                  jQuery("#editDeliveryAlert").hide();
                  // errorMsg(result.barerror);
                  // jQuery(".alert-danger").show();
                  // jQuery(".alert-danger").html(result.barerror);
                  errorMsg(result.barerror);
                } else if (result.success != null) {
                  jQuery(".alert-danger").hide();
                  $('.modal .close').click();
                  // successMsg(result.success);
                  // jQuery("#editDeliveryAlert").html(result.success);
                  // jQuery("#editDeliveryAlert").show();
                  // getDeliveries();
                  successMsg(result.success);
                  getRetailCustomerOrdersDetials.ajax.reload();
                } else {
                  jQuery(".alert-danger").hide();
                  jQuery("#editDeliveryAlert").hide();
                }
              }
            });
          }
        });
    }
  });
});
// end here

</script>