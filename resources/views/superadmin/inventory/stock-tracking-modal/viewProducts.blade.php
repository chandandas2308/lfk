<!-- Modal -->
<div class="modal fade" id="viewProducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body bg-white p-3">
            <!-- row 1 -->
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="row">
                                <label for="customerName"  class="col-sm-4 col-form-label"> Customer / Vendor Name </label>
                                <div class="col-sm-8">
                                    <input type="text" id="customerName" class="form-control" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="row">
                                <label for="statusTracking" class="col-sm-4 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="statusTracking" placeholder="Status" disabled />
                                </div>
                            </div>
                        </div>
                    </div> 
            <!-- row 2 -->
                    <div class="form-group row">
                        <!-- table start -->
                        <div class="table-responsive border border-secondary" style="overflow-x:scroll;">
                            <table class="table text-center border" id="stockTrackingTableView">
                                <thead>
                                    <tr>
                                        <th class="p-2 border border-secondary">S/N</th>
                                        <th class="p-2 border border-secondary">Product Name</th>
                                        <th class="p-2 border border-secondary">Product Variant</th>
                                        <th class="p-2 border border-secondary">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody class="stock-tracking-details-view">

                                </tbody>
                            </table>
                        </div>
                    </div>            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>