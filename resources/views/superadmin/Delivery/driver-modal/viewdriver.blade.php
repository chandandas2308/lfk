<head>
    <script src="//cdn.datatables.net/plug-ins/1.13.3/api/sum().js"></script>
    <style>
        table.dataTable tfoot th,
        table.dataTable tfoot td {
            padding: 10px 10px 6px 10px;
            border-top: 1px solid rgba(0, 0, 0, 0.3);
            text-align: end !important;
        }
    </style>
</head>
<!-- Modal -->
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Delivery Man Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>


<div class="modal-body bg-white px-3">

    <input type="text" name="id" id="editfg" style="display: none;">
    <div class="row">
        <div class="form-group col-md-6">
            <label for="driver_name">Delivery Man Name</label>
            <input type="text" class="form-control" id="viewdriver_name" value="{{ $data->driver_name }}"
                name="viewdriver_name" placeholder="Driver Name" disabled />
        </div>

        <div class="form-group col-md-6">
            <label for="driver_mobile_no">Delivery Man Mobile No.</label>
            <input type="text" class="form-control" id="viewdriver_mobile_no" value="{{ $data->driver_mobile_no }}"
                name="viewdriver_mobile_no" maxlength="10" disabled placeholder="Driver Mobile No"
                onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
        </div>

        <div class="form-group col-md-6">
            <label for="driver_email">Delivery Man Email</label>
            <input type="text" class="form-control" id="viewdriver_email" value="{{ $data->driver_email }}"
                name="viewdriver_email" placeholder="Driver Email" disabled />
        </div>

        <!-- <div class="form-group col-md-6">
        <label for="Region">Commission </label>
        <input type="text" class="form-control" id="viewCommission" value="{{ $data->commission }}" name="viewCommission" placeholder="Commission" disabled />
      </div> -->
    </div>

    <hr>
    {{-- <a href="deliver/export/">demo</a> --}}
    <form action="{{ route('deliver.report') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <p id="date_filter">
            <span id="date-label-from" class="date-label">Delivery Date : </span><input class="date_range_filter date"
                type="text" name="date" id="datepicker_from1" placeholder="DD/MM/YYYY" autocomplete="off" />
            <button type="button" onclick="updateTable()" class="btn-sm btn-primary">Reset</button>
        </p>
        <button type="submit" class="btn btn-primary">Export to Excel</button>

    </form>
    <div>
        <table id="order_details_driver1" class="text-center table table-responsive table-bordered">
            <thead>
                <tr>
                    <th style="text-align:center">Order No.</th>
                    <th style="text-align:center">Address</th>
                    <th style="text-align:center">Delivery Date</th>
                    <th style="text-align:center">Collectable Cash</th>
                    <th style="text-align:center">Total Quantity</th>
                    <th style="text-align:center">Status</th>
                    <th style="text-align:center">Remark</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="7">Total Collectable Cash</td>
                    <td id="collectable_cash"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>


<script>
    $(document).ready(function() {
        // $('#date_range_filter').datepicker({
        //     dateFormat: "dd/mm/yy"
        // });

        $('.date_range_filter').datepicker({
            dateFormat: "dd/mm/yy"
        });
    });

    $(document).on('click', '#viewProDetailsDriver1', function() {

        order_details_driver2 = $('#order_details_driver2').DataTable({
            destroy: true,
            ajax: {
                url: "{{ route('SA-RetailCustomerOrdersPackingList2') }}",
                type: 'GET',
                data: {
                    order_no: $(this).data('id'),
                }
            },

        });

    });

    function updateTable() {
        $('.date_range_filter').val('');
        order_details_driver.ajax.reload();
    }

    $('#datepicker_from1').on('change onkeyup onkeypress', function() {
        var date = $(this).val();

        order_details_driver1 = $('#order_details_driver1').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            "initComplete": function(settings, json) {
                var total_cash = order_details_driver1.column(3).data().sum();
                $('#collectable_cash').html('$' + parseFloat(total_cash).toFixed(2));
            },
            responsive: false,
            // "scrollX": true,
            pageLength: 10,
            dom: "Bfrtip",
            buttons: [],
            ajax: {
                url: "{{ route('SA-RetailCustomerOrdersPackingList1') }}",
                type: 'GET',
                data: {
                    id: "{{ $id }}",
                    date: date
                }
            },
        })

        var total_cash = order_details_driver1.column(4).data().sum();
        $('#collectable_cash').html(total_cash);

    });

    order_details_driver = $('#order_details_driver1').DataTable({
        destroy: true,
        // searching: true,
        // scrollX:true,
        "initComplete": function(settings, json) {
            var total_cash = order_details_driver.column(3).data().sum();
            $('#collectable_cash').html('$' + parseFloat(total_cash).toFixed(2));
        },
        ajax: {
            url: "{{ route('SA-RetailCustomerOrdersPackingList1') }}",
            type: 'GET',
            data: {
                id: "{{ $id }}"
            }
        },
    });

    $(document).find('#order_details_driver1').wrap('<div style="overflow-x:auto; width:100%;"></div>');
</script>
