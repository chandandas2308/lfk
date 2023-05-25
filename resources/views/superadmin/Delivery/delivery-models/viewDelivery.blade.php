<div class="modal fade viewDelivery" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delivery Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-3 bg-white">

      <!-- <div class="card"> -->
            <!-- <div class="card-body"> -->

            
                    <!-- row 0 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="quotationno1">Order No.<span style="color: red; font-size:small;">*</span></label>
                            <input type="text" class="form-control" id="selectOrder_no_view" name="order_no" placeholder="Order No." disabled />
                            <!-- <select name="order_no" class="form-control" onchange="fetchOrdersDetails1()" id="selectOrder_no"></select> -->
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="mt-3"> -->
                              <label for="mobile_no">Mobile No. </label>
                              <input type="text" class="form-control" id="mob_no_delivery_view" name="mobile_no" placeholder="mobile_no" disabled />
                            <!-- </div> -->
                        </div>
                    </div>

                    <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="customer_name">Customer Name </label>
                            <input type="text" class="form-control" id="customer_name_delivery_view" name="customer_name" placeholder="Customer Name" disabled />
                        </div>
                        <div class="col-md-6">
                            <!-- <div class="mt-3"> -->
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="invoice_date_delivery_view" name="date" disabled />
                            <!-- </div> -->
                        </div>
                    </div>

                    <!-- row 2 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label for="delivery_address">Delivery Address</label>
                          <input type="text" class="form-control" id="delivery_address_delivery_view" name="delivery_address" placeholder="Address" disabled />
                        </div>
                        <div class="col-md-6">
                          <label for="deliveryman">Delivery Man <span style="color:red;">*</span> </label>
                          <!-- <select name="deliveryman" class="form-control" onchange="fetchDeliverymanIdUpdate()" id="selectdeliverymanED" ></select> -->
                          <input type="text" class="form-control" id="delivery_man_view" name="" disabled />
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="form-group row">
                        <div class="col-md-6">
                          <label for="delivery_status">Delivery Status<span style="color:red;">*</span></label>
                          <input type="text"  value="Packing" class="form-control" name="delivery_status" id="delivery_status_view" disabled>
                        </div>
                        <div class="col-md-6">
                          <label for="payment_status">Payment Status<span style="color:red;">*</span></label>
                          <select class="form-control" name="payment_status" id="payment_status_view" disabled>
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
                          <textarea class="form-control" placeholder="enter description..." id="description_view" name="description" cols="5" rows="2" disabled></textarea>
                        </div>
                        <div class="col-md-6">
                        <label for="pickup_address">Pickup Address</label>
                        <input type="text" class="form-control" placeholder="Pickup Address" id="viewpickupid" name="viewpickupname" disabled>
                        </div>
                    </div>

                    <!-- row 5 -->
                    <div class="form-group row">
                      <div class="col">
                        <fieldset class="border border-secondary p-2">
                          <legend class="float-none w-auto p-2">Product Details</legend>
                          <span style="color:red; font-size:small;" id="createdeliverytableEmptyError"></span>

                          <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                            <table class="table text-center border" id="productTableDelivery_view"  style="width: 100%; border-collapse: collapse;">
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
                              <tbody id="productTableBody9_view"></tbody>
                            </table>
                          </div>
                        </fieldset>
                      </div>
                    </div>
              </div>
          <!-- </div> -->
        <!-- </div> -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>