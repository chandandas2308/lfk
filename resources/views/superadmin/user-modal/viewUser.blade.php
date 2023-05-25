<!-- Modal -->
<div class="modal fade" id="viewUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-2">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="post" id="viewUserForm">
        <div class="modal-body bg-white px-3">
           
                <div class="card">
                  <div class="card-body">

                      <!-- username -->
                      <div class="form-group row">
                        <label for="username" class="col-sm-3 col-form-label">User Name</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control text-dark" name="username" id="usernameView" placeholder="User Name" require disabled />
                        </div>
                      </div>
                      <!-- mobile number -->
                      <div class="form-group row">
                        <label for="mobilenumber" class="col-sm-3 col-form-label">Mobile Number</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control text-dark" name="mobilenumber" id="mobilenumberView" placeholder="Mobile number" require disabled />
                        </div>
                      </div>
                      <!-- phone number -->
                      <div class="form-group row">
                        <label for="phonnumber" class="col-sm-3 col-form-label">Home Number</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control text-dark" name="phonenumber" id="phonnumberView" placeholder="Home Number" require disabled />
                        </div>
                      </div>
                      <!-- Email ID -->
                      <div class="form-group row">
                        <label for="emailid" class="col-sm-3 col-form-label">Email ID</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control text-dark" name="emailid" id="emailidView" placeholder="Email" require disabled />
                        </div>
                      </div>

                      <!-- checkbox -->
                      <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">User rights<span style="color:red;">*</span></label>
                        <div class="col-sm-9">
                          <div class="form-group" id="userRightsView">
                            <div class="" style="font-size: smaller; color:red;" id="userRightsErrorView"></div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one" value="all" name="list" id="accessToAllView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Access To All
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" name="list" value="sales" id="salesView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Sales
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="purchase" name="list" id="purchaseView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2  !important;border-width: 2px;margin-top: 0px;" />&nbsp; Purchase
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="refferalAwards" name="list" id="refferalAwardsView"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Referral Awards
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="inventory" name="list" id="inventoryView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Inventory
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="loyalitysystem" name="list" id="loyalitysystemView"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Loyalty System
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="offerpackage" name="list" id="offerpackageView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Offer and Package
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="reports" name="list" id="reportsView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;"/>&nbsp; Reports
                                  </label>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="customerManagement" name="list" id="customerManagementView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Customer Management
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="deliveryManagement" name="list" id="deliveryManagementView" style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; Delivery Management
                                  </label>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-check form-check-primary">
                                  <label class="">
                                    <input type="checkbox" onclick="return false" class="form-check-input require-one cb_child_view" value="eCredit" name="list" id="eCreditView"  style="width: 18px;height: 18px;border-radius: 2px;border: solid #7057d2 !important;border-width: 2px;margin-top: 0px;" />&nbsp; E-Credit Options
                                  </label>
                                </div>
                              </div>

                            </div>
                          </div>
                        </div>
                      </div>             
                    
                  </div>
                </div>        

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>