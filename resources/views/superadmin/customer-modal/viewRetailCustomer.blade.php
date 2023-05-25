<!-- Modal -->
<div class="modal fade" id="viewRetailCustomerDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Retail Customer Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="viewCustomerForm">
        <div class="modal-body bg-white px-3">
           
                  <div class="row">
                    <div class="col-md-6">
                      <input type="hidden" name="" id="viewRetailCustomerId">
                    <!-- Customer Name -->
                    <div class="form-group">
                        <label for="customerName">Customer Name</label>
                        <input type="text" name="customerName" id="customerViewName12" class="form-control" placeholder="Customer Name" disabled>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <label for="emailId">Email ID</label>
                        <input type="email" name="emailId" id="CustomerViewEmailId12" class="form-control" placeholder="Email ID"  disabled>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <!-- Customer Phone Number -->
                      <!-- <div class="form-group">
                        <label for="phoneNo">Home Number</label>
                        <input type="text" name="phoneNo" id="customerViewPhNo12" class="form-control" placeholder="Home Number"  disabled>
                      </div> -->
                      <div class="form-group">
                        <label for="mobileNo">Phone Number</label>
                        <input type="text" name="mobileNo" id="CustomerViewMobNo12" class="form-control" placeholder="Phone Number"  disabled>
                      </div>
                    </div>
                    <div class="col-md-6">

                    <div class="form-group">
                        <label for="blockCustomer">Block Customer</label>
                        <select name="block" id="blockCustomer" class="form-control" onchange="updateCustomerStatus()">
                          <option value="">Select</option>
                          <option value="1">Yes</option>
                          <option value="0">No</option>
                        </select>
                      </div>
                      
                    </div>
                  </div>

                  <div class="row">
                    
                    <div class="col-md-6">
                       <div class="form-group">
                          <label for="postcode">Postal Code</label>
                          <input type="text" name="postcode" id="CustomerViewPostal12" class="form-control" placeholder="Postal Code" disabled>
                       </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                          <label for="address">Address</label>
                          <input type="text" name="address" id="CustomerViewAddress12" class="form-control" placeholder="Address" disabled>
                       </div>
                    </div>

                  </div>
                  <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                          <label for="unit">Unit</label>
                          <input type="text" name="unit" id="CustomerViewUnit12" class="form-control" placeholder="Unit" disabled>
                       </div>
                    </div>
                    
                    <div class="col-md-6">
                       <div class="form-group">
                          <label for="points">Points</label>
                          <input type="text" name="points" id="CustomerViewPoints12" class="form-control" placeholder="Points" disabled>
                       </div>
                    </div>
                    <div class="col-md-6">
                       
                    </div>
                  </div>

                      <label>Order Details</label>
                      <div style="overflow-x:auto;">    
                        <table class="table table-bordered" id="invoice_details_table120">
                          <thead>
                            <th>S/N</th>
                            <th>Order No.</th>
                            <th>Name</th>
                            <th>Mobile Number</th>
                            <th>Payment Status</th>
                            <th>Total Bill Amount</th>
                            <th>Delivery Date</th>
                            <th>Delivery Status</th>
                            <th>Action</th>
                          </thead>
                        </table>
                      </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

  <div class="modal fade" id="viewOrderDetails3" tabindex="-1" role="dialog" aria-labelledby="viewOrderDetails3" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">      
        <div class="modal-content" id="viewOrderDetailsData2">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Order Products Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body bg-white px-3">
                    <div style="overflow: auto;" class="table-responsive">
                        <table id="orderProductDetails" class="text-center table table-striped">
                            <thead>
                                <tr>
                                    <th>Product Image</th>                      
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Product Price</th>
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>      
        </div>
    </div>
</div>

<button class="btn btn-primary" style="display: none;" data-toggle="modal" id="viewMyOrderBtn" data-target="#viewOrderDetails3">View Btn</button>

<script>

$(document).on('click', '#viewOrderDetails', function(){
  var classIs = $(this)[0].className.split(' ').reverse()[0];

    $.ajax({
      url : "{{ route('SA-FetchRetailCustomerWiseProductDetails') }}",
      method : "GET",
      data : {
        id : $(this).data('id')
      },
      beforeSend : function(){
        $('.'+classIs).html('<i class="fa fa-spinner fa-spin"></i>');
      },
      success : function(response){
        $('.'+classIs).html('View');
        $('#viewMyOrderBtn').click();
        
        $('#orderProductDetails').dataTable({
            data: response,
            pageLength : 3,
            "bFilter": false,
            dom: "Bfrtip",
            buttons: [],
            "bDestroy": true,
            columns: [
                { 
                    data: function(fn){
                        return `<img src="${fn["product_image"]}" height="80" style="transform: scale(0.7)">`
                    },
                    title: 'Image'
                },
                { 
                    data: 'product_name',
                    title: 'Name' 
                },
                { 
                    data: 'quantity',
                    title: 'Quantity'
                },
                { 
                    data: function(fn){
                        return '$'+fn["product_price"]
                    },
                    title: 'Product Price'
                },
                { 
                    data: function(fn){
                        return '$'+fn["total_price"]
                    },
                    title: 'Total Price' 
                },
                {
                    data: function(fn){
                        return new Date(fn["created_at"]).toISOString().slice(0,10).split('-').reverse().toString().replaceAll(',','-');
                    },
                    title: 'Order Date'
                },
            ]
        });
        
      }
    })
  })

  var status1 = $('#blockCustomer').val();

  function updateCustomerStatus(){

      let status = $('#blockCustomer').val();
      let id = $('#viewRetailCustomerId').val();
      bootbox.confirm("DO YOU WANT TO BLOCK THE CUSTOMER?", function(result) {
        if(result){
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
          });

          status1 = status;
        
          $.ajax({
            type : "POST",
            url : "{{ route('SA-UpdateRetailCustomerStatus')}}",
            data : {
              "status": status,
              "id": id,
            },
            success : function (response){
              successMsg(response.success);
              errorMsg(response.error);
            }
          });
        }else{
          $('#blockCustomer').val(status1);
        }
      });
  }
</script>