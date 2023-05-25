<div class="modal fade viewWarehouse" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Warehouse Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="card">
          <div class="card-body">

            <!-- Warehouse Name  -->
            <div class="form-group row">
              <label for="name" class="col-sm-3 col-form-label fw-bolder">Warehouse Name</label>
              <div class="col-sm-9">
                <input type="text" class="form-control text-dark" id="nameView" name="name" placeholder="Warehouse Name" disabled />
              </div>
            </div>

            <!-- Short Code -->
            <div class="form-group row">
              <label for="shortCode" class="col-sm-3 col-form-label fw-bolder">Short Code</label>
              <div class="col-sm-9">
                <input type="text" class="form-control text-dark" id="shortCodeView" name="shortCode" placeholder="Short Code" disabled />
              </div>
            </div>

            <!-- Address -->
            <div class="form-group row">
              <label for="address" class="col-sm-3 col-form-label fw-bolder">Address</label>
              <div class="col-sm-9">
                <textarea name="address" id="addressView" class="form-control text-dark" cols="30" rows="5" placeholder="Address" disabled></textarea>
              </div>
            </div>

            <!-- Warehouse Detials -->
            <div class="form-group row">
              <label for="address" class="col-sm-3 col-form-label fw-bolder">Details</label>
              <div class="col-sm-9">
                <span id="warehouseBtnSection"></span>
              </div>
            </div>
            <!-- table start -->
            <div class="table-responsive" style="overflow-x:scroll;">
              <div class="table-responsive border border-secondary" style="overflow-x:scroll;">
                <table class="table text-center table-bordered" style="width: 100%;" id="rackProductsInfoTableView">
                  <thead>
                    <tr>
                      <th class="p-2 border border-secondary">S/N</th>
                      <th class="p-2 border border-secondary">Product ID</th>
                      <th class="p-2 border border-secondary">Product Name</th>
                      <th class="p-2 border border-secondary">Product Category</th>
                      <th class="p-2 border border-secondary">Product Variant</th>
                      <th class="p-2 border border-secondary">Quantity</th>
                      <th class="p-2 border border-secondary">Batch Code</th>
                      <th class="p-2 border border-secondary">Location</th>
                    </tr>
                  </thead>
                  <tbody class="stock-wise-products">
               
                </tbody>
                </table>
              </div>
            </div>
            <!-- table end here -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!--  -->

<script>
  // view a single warehouse details using id
  $(document).on("click", "a[name = 'rackDetials']", function(e) {
    var rack = $(this).data("id");
    var warehouse = $(this).data("nameView");

    $.ajax({
      type: "GET",
      url: "{{ route('SA-RackWarehouseInfo')}}",
      data: {
        'rack': rack,
        'warehouse': warehouse
      },
      success: function(response) {
        jQuery('.rack-assign-products-details-view').html('');

        $('#warehouseNameRackInfo').val(warehouse);
        $('#rackNameRackInfo').val(rack);

        jQuery.each(response, function(k, v) {

          let slno = $('#rackProductsInfoTableView tr').length;
          $('.rack-assign-products-details-view').append(
            '<tr>\
                            <td class="border border-secondary">' + slno + '</td>' +
            '<td class="border border-secondary">' + v["product_id"] + '</td>' +
            '<td class="border border-secondary">' + v["product_name"] + '</td>' +
            '<td class="border border-secondary">' + v["product_category"] + '</td>' +
            '<td class="border border-secondary">' + v["product_varient"] + '</td>' +
            '<td class="border border-secondary">' + v["quantity"] + '</td>' +
            '<td class="border border-secondary">' + v["batch_code"] + '</td>\
                        </tr>'
          );

        });
      }
    });
  });
</script>

<!-- Modal -->
<div class="modal fade" id="viewRackProductsInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content p-3 shadow-lg p-3 mb-5 bg-white rounded">
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
              <label for="customerName" class="col-sm-4 col-form-label"> Warehouse Name </label>
              <div class="col-sm-8">
                <input type="text" id="warehouseNameRackInfo" class="form-control" placeholder="Warehouse Name" disabled>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="row">
              <label for="statusTracking" class="col-sm-4 col-form-label">Rack</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="rackNameRackInfo" placeholder="Rack" disabled />
              </div>
            </div>
          </div>
        </div>
        <!-- row 2 -->
        <div class="form-group row">
          <!-- table start -->
          <div class="table-responsive border border-secondary" style="overflow-x:scroll;">
            <table class="table text-center border" id="rackProductsInfoTableView">
              <thead>
                <tr>
                  <th class="p-2 border border-secondary">S/N</th>
                  <th class="p-2 border border-secondary">Product ID</th>
                  <th class="p-2 border border-secondary">Product Name</th>
                  <th class="p-2 border border-secondary">Product Category</th>
                  <th class="p-2 border border-secondary">Product Variant</th>
                  <th class="p-2 border border-secondary">Quantity</th>
                  <th class="p-2 border border-secondary">Batch Code</th>
                </tr>
              </thead>
              <tbody class="rack-assign-products-details-view">

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