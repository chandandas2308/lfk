        <div class="p-3">
            <!-- orders Tab -->
            <div class="page-header flex-wrap" >
                <h4 class="mb-0">
                    Outlet Management
                </h4>
                <div class="d-flex">
                    <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addOutlet"> Add </a>
                </div>
            </div>

            <!-- table start -->
            <div class="admin-card">
                <div class="container">
                <div class="table-responsive">
                       <table class="text-center table table-responsive table-bordered" id="outlet_table_caption">
                               <thead>
                                   <tr>
                                       <th class="text-center">S/N</th>
                                       <th class="text-center">Name</th>
                                       <th class="text-center">Email ID</th>
                                       <th class="text-center">Mobile Number</th>
                                       <th class="text-center">Postcode</th>
                                       <th class="text-center">Manage Stock</th>
                                       <th class="text-center">Action</th>
                                   </tr>
                               </thead>
                       </table>
        </div>
                </div>
            </div>
      
           
            <!-- table end here -->
        </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- backend js file -->
    
<script>

    $(document).ready(function() {
        outlet_table_caption = $('#outlet_table_caption').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:8,
            buttons: [],
            ajax: {
                url: "{{ route('SA-FetchAllOutLet') }}",
                type: 'GET',
            }
        });
    });

        // edit quotation detials
        $(document).on("click", "a[name = 'updateOutletDetails']", function(e) {

            let id = $(this).data("id");

                $.ajax({
                    type: "GET",
                    url: `{{ route('SA-FetchSingleOutletDetails')}}`,
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        $('#update_outlet_address').html('');

                            $('#update_outlet_id').val(response[0]["user_id"]);

                            $('#update_outletName').val(response[0]["name"]);

                            $('#update_outletEmail').val(response[0]["email"]);

                            $('#update_outlet_mobile_number').val(response[0]["mobile_number"]);

                            $('#update_outletPostCode').val(response[0]["postcode"]);

                            $('#update_outlet_address').append(`<option value="${response[0]["address"]}" selected >${response[0]["address"]}</option>`);

                            $('#update_outletUnitCode').val(response[0]["unit"]);
                    }
                });
        });
        // end here

    

        // view individuals orders
        $(document).on("click", "a[name = 'viewOutLetDetails']", function(e) {
            let id = $(this).data("id");
            getOrderssInfo(id);

            function getOrderssInfo(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-FetchSingleOutletDetails')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                          
                            jQuery.each(response, function(key, value) {

                                $('#view_outlet_id').val(value["user_id"]);

                                $('#view_outletName').val(value["name"]);

                                $('#view_outletEmail').val(value["email"]);

                                $('#view_outlet_mobile_number').val(value["mobile_number"]);

                                $('#view_outletPostCode').val(value["postcode"]);

                                $('#view_outlet_address').val(value["address"]);

                                $('#view_outletUnitCode').val(value["unit"]);

                                $('#view_outletPassword').val(value["password"]);
                            });
                    }
                });
            }
        });
        // end here    


        // delete a single orders using id
        $(document).on("click", "a[name = 'removeConfirmSalesOrders']", function(e) {
            let id = $(this).data("id");
            delOrders(id);

            function delOrders(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-PosRemoveOutletDetails')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        successMsg(response.success);
                        outlet_table_caption.ajax.reload();
                        $("#removeModalOutletDetails .close").click();

                    }
                });
            }
        });


        $(document).on("click", "a[name = 'deleteOrders']", function(e) {
            let id = $(this).data("id");
            $('#confirmRemoveSelectedOutletDetails').data('id', id);
        });

        $(document).on('click', '#stockUserStockManagementModel', function()
        {
            $('#addStockOwnerId').val($(this).data("id"));
            $('#updateStockOwnerId').val($(this).data("id"));
            // getAllOutletStockDetails($(this).data("id"));

        });

    </script>

    <div class="modal fade" id="removeModalOutletDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Alert</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">DO YOU WANT TO DELETE?<span id="removeElementId"></span> </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                    <a name="removeConfirmSalesOrders" class="btn btn-primary" id="confirmRemoveSelectedOutletDetails">
                        YES
                    </a>
                </div>
            </div>
        </div>
    </div>

<!-- Create Outlet -->
@include('superadmin.pos.pos-modal.createOutlet')
@include('superadmin.pos.pos-modal.updateOutlet')
@include('superadmin.pos.pos-modal.viewOutlet')

<!-- STOCK -->
@include('superadmin.pos.pos-modal.stock')