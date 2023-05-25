<div class="modal fade" id="addDelivery" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Delivery</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="forms-sample" id="addDeliveryForm1" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-body p-3 bg-white">

          <!-- info & alert section -->
          <div class="alert alert-success" id="addDeliveryAlert" style="display:none"></div>
          <div class="alert alert-danger" style="display:none">
            <ul></ul>
          </div>
          <!-- end -->

          <div class="bg-white">
            <!-- <div class="card-body"> -->

                    <!-- row 0 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="quotationno1">Order No.<span style="color: red; font-size:small;">*</span></label>
                            <select name="order_no" class="form-control" onchange="fetchOrdersDetails1()" id="selectOrder_no"></select>
                            <input type="hidden" id="deliver_order" name="deliver_order">
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="mt-3"> -->
                              <label for="mobile_no">Mobile Number </label>
                              <input type="text" class="form-control" id="mob_no_delivery" name="mobile_no" placeholder="Mobile Number..." readonly />
                            <!-- </div> -->
                        </div>
                    </div>

                                
                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customer_name">Customer Name </label>
                            <input type="text" class="form-control" id="customer_name_delivery" name="customer_name" placeholder="Customer Name" readonly />
                            <input type="text" name="customer_id" id="customer_id_delivery" style="display:none;" />
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="mt-3"> -->
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="invoice_date_delivery" name="date" readonly />
                            <!-- </div> -->
                        </div>
                    </div>

                    <!-- row 2 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label for="delivery_address">Delivery Address  </label>
                          <input type="text" class="form-control" id="delivery_address_delivery" name="delivery_address" placeholder="Address" readonly />
                        </div>
                        <div class="col-md-6">
                          <label for="deliveryman">Delivery Man <span style="color:red;">*</span> </label>
                          <select name="deliveryman" class="form-control" onchange="fetchDeliverymanId()" id="selectdeliveryman" ></select>
                          <input type="text" name="delivery_man_name" id="delivery_man_name" style="display:none;" />
                          <input type="text" name="delivery_man_user_id" id="delivery_man_user_id" style="display:none;" />
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label for="delivery_status">Delivery Status<span style="color:red;">*</span></label>
                          <input class="form-control" type="text" id="delivery_status" name="delivery_status" value="Packing" readonly>
                        </div>
                        <div class="col-md-6">
                          <label for="payment_status">Payment Status<span style="color:red;">*</span></label>
                          <select class="form-control" name="payment_status" id="payment_status">
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
                          <textarea class="form-control" placeholder="enter description..." id="category" name="description" cols="5" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                        <label for="pickup_address">Pickup Address</label>
                        <input type="text" class="form-control" placeholder="Pickup Address" id="pickupid" name="pickupname">
                        </div>
                    </div>

                    <!-- row 5 -->
                    <div class="form-group row">
                      <div class="col">
                        <fieldset class="border border-secondary p-2">
                          <legend class="float-none w-auto p-2">Product Details</legend>
                          <span style="color:red; font-size:small;" id="createdeliverytableEmptyError"></span>

                          <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                            <table class="table text-center border" id="productTableDelivery"  style="width: 100%; border-collapse: collapse;">
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
                              <tbody id="productTableBody9"></tbody>
                            </table>
                          </div>
                        </fieldset>
                      </div>
                    </div>
              <!-- </div> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="addDeliveryFormClearBtn">Clear</button>
            <button type="submit" id="addDeliveryForm" class="btn btn-primary">Save</button>
          </div>
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
  // clear form
  jQuery('#addDeliveryFormClearBtn').on('click', function() {
    jQuery("#addDeliveryForm1")["0"].reset();
  });

  // validation script start here
  $(document).ready(function() {

    jQuery("#addDeliveryForm1").submit(function(e) {
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
        order_no: {
          required: true,
        },
        payment_status: {
          required: true,
        },
        pickupname: {
          required: true,
        }
      },
      messages: {},
      submitHandler:function(){

        deliveryProductsDetails = [];
        deliveryProductsDetails.splice(0, deliveryProductsDetails.length);

        $("#productTableBody9 > tr").each(function(e) {
            let product_Id = $(this).find('.product_idDelivery').text();
            let productName3 = $(this).find('.product_nameDelivery').text();
            let varient = $(this).find('.product_varientDelivery').text();
            let category = $(this).find('.product_categoryDelivery').text();
            let description = $(this).find('.product_descDelivery').text();
            let quantity = $(this).find('.product_quantityDelivery').text();
            let unitPrice = $(this).find('.unit_priceDelivery').text();
            let taxes = $(this).find('.taxesDelivery').text();
            let subTotal = $(this).find('.subtotalDelivery').text();
            let netAmount = $(this).find('.netAmountDelivery').text();

            let dbData = {
                "product_Id": product_Id,
                "product_name": productName3,
                "product_varient": varient,
                "category": category,
                "description": description,
                "taxes": taxes,
                "quantity": quantity,
                "unitPrice": unitPrice,
                "taxes": taxes,
                "subTotal": subTotal,
                "netAmount": netAmount
            }
            deliveryProductsDetails.push(dbData);
        });

        bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
          if(result){

            jQuery.ajax({
              url: "{{ route('SA-AddDelivery') }}",
              data: jQuery("#addDeliveryForm1").serialize() + "&allProductDetails=" + JSON.stringify(deliveryProductsDetails),
              type: "post",

              success: function(result) {                
                if (result.error != null) {
                  errorMsg(result.error);
                } else if (result.barerror != null) {
                  jQuery("#addDeliveryAlert").hide();
                  errorMsg(result.barerror);
                } else if (result.success != null) {
                  successMsg(result.success);
                  getId();
                  $('#productTableBody9').html('');
                  $('.modal .close').click();
                  deliveryProductsDetails.splice(0, deliveryProductsDetails.length);
                  jQuery("#addDeliveryForm1")["0"].reset();
                  getDeliverCustomerOrdersDetials.ajax.reload();
                  getDeliveries();
                } else {
                  jQuery(".alert-danger").hide();
                  jQuery("#addDeliveryAlert").hide();
                }
              },
            });

          }
        });
      }
    });
  });
  // end here

  //Customer id fatch from sale orders.
  getId();

  let orderDetailsArr = [];

  function getId() {
    $.ajax({
      type: "GET",
      url: "{{ route('SA-FetchOrderDetails')}}",
      success: function(response) {

        $('#selectOrder_no').html('');
        $('#selectOrder_no').append('<option value="">Select Order No.</option>');

        orderDetailsArr = response;

        

        jQuery.each(response, function(key, value) {
          $('#selectOrder_no').append(
            '<option value="' + value['id'] + '">\
                ' + value['quotation_id'] + '\
            </option>');
        });

      }
    });
  }
// end here

  // throe id fatch all details.
  function fetchOrdersDetails1() {
    let id = this.event.target.value;

    jQuery("#productTableBody9").html('');
    
          jQuery.each(orderDetailsArr, function(key, value) {

            if(value['id'] == id){

              $.ajax({
                type: "GET",
                data:{
                  id : value['customer_id'],
                },
                url: "{{ route('SA-GetCustomerDetails')}}",
                success: function(response) {
                  jQuery.each(response, function(k,v){
                    $('#mob_no_delivery').val(v['mobile_number']);
                    $('#delivery_address_delivery').val(v['address']);
                  })
                }
              });

              $('#customer_name_delivery').val(value['customer_name']);

              $('#deliver_order').val(value['quotation_id']);
              $('#customer_id_delivery').val(value['customer_id']);

              $('#invoice_date_delivery').val(value['expiration']);

              let sno = 1;
              
              let str = value["products_details"];

              let obj = JSON.parse(str);

              jQuery.each(obj, function(key, value) {

                $('#productTableBody9').append('<tr class="child">\
                                          <td>' + sno++ + '</td>\
                                          <td class="product_idDelivery" style="display:none;" >' + value["product_Id"] + '</td>\
                                          <td class="product_nameDelivery">' + value["product_name"] + '</td>\
                                          <td class="product_categoryDelivery">' + value["category"] + '</td>\
                                          <td class="product_varientDelivery">' + value["product_varient"] + '</td>\
                                          <td class="product_descDelivery">' + value["description"] + '</td>\
                                          <td class="product_quantityDelivery">' + value["quantity"] + '</td>\
                                          <td class="unit_priceDelivery">' + value["unitPrice"] + '</td>\
                                          <td class="taxesDelivery" style="display:none;" >' + value["taxes"] + '</td>\
                                          <td class="subtotalDelivery">' + value["subTotal"] + '</td>\
                                          <td class="netAmountDelivery">' + value["netAmount"] + '</td>\
                                              </a>\
                                          </td>\
                                      </tr>');
              });
            }
          });
        }

  //get deliveryman name and id.
  getdeliverymanname();

  let deliveryManDetials = [];

  function getdeliverymanname() {
    $.ajax({
      type: "GET",
      url: "{{ route('SA-deliverymanList')}}",
      success: function(response) {
        console.log(90,response);

        deliveryManDetials = response;

        $('#selectdeliveryman').html('');
        $('#selectdeliveryman').append('<option value="">Select Delivery Man</option>');

        jQuery.each(response, function(key, value) {
          $('#selectdeliveryman').append(
            '<option value="' + value["id"] + '">\
                            ' + value["driver_name"] + '\
                            </option>'
          );
        });
      }
    });
  }

  //Fatch deliveryman Id.
        function fetchDeliverymanId() {

          let id = $('#selectdeliveryman').val();

          jQuery.each(deliveryManDetials, function(key, value) {

            if(id == value['id']){
              $('#delivery_man_name').val(value['driver_name']);
              $('#delivery_man_user_id').val(value['driver_id']);
            }

          });
        }

</script>