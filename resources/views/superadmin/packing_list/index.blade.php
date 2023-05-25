    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444 !important;
            line-height: 14px;
            font-size: 14px;
            width: 103%;
        }
    </style>
    <div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Packing List
            </h4>
        </div>

        <!-- table start -->
        <div class="admin-card">
            <div class="container">
                <div class="p-3">
                    <p id="date_filter">
                        <span id="date-label-from" class="date-label">Delivery Date : </span>
                        <input placeholder="DD/MM/YYYY" class="date_range_filter date" type="text" id="datepicker_from" autocomplete="off"/>
                        <button type="button" onclick="updateTable1()" class="btn-sm btn-primary">Reset</button>
                    </p>

                    <table id="example" class="text-center table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center" >S/N</th>
                                <th style="text-align:center" >Order No.</th>
                                <th style="text-align:center" >Customer Name</th>
                                <th style="text-align:center" >Address</th>
                                <th style="text-align:center" >Delivery Date</th>
                                <th style="text-align:center" >Driver</th>
                                <th style="text-align:center" >Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="viewConsolidateOrder1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content p-2" id="viewConsolidateOrderData2">
            </div>
        </div>
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://common.olemiss.edu/_js/datatables/media/js/jquery.js"></script>
    <script src="https://common.olemiss.edu/_js/datatables/media/js/jquery.dataTables.js"></script>
    <script>
        $(function() {
            $('.select_2_input').select2();
        });

        function updateDriver(className) {
            var driver_id = $('.' + className).val();
            var consolidate_order_no = $('.' + className).data('id');

            $.ajax({
                url: "{{ route('SA-AddOnlineSaleDelivery1') }}",
                type: 'GET',
                data: {
                    driver_id: driver_id,
                    order_no: consolidate_order_no,
                },
                success: function(response) {
                    if (response.success != null) {
                        toastr.success(response.success);
                        example.ajax.reload();
                    }
                    if (response.error != null) {
                        toastr.error(response.error);
                    }
                }
            });
        }

        $(document).ready(function() {

            $('#datepicker_from').datepicker({
                dateFormat: "dd/mm/yy"
            });

        });


        $(document).ready(function() {
            example = $('#example').DataTable({
                "aaSorting": [],
                "bDestroy": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                drawCallback: function() {
                    $('.select_2_input').select2();
                },
                'processing': true,
                'serverSide': true,
                // responsive: false,
                // "scrollX": true,
                pageLength: 10,
                dom: "Bfrtip",
                buttons: [],
                ajax: {
                    url: "{{ route('SA-RetailCustomerOrdersPackingList') }}",
                    type: 'GET',
                    data : function(data){
                        var date = $('#datepicker_from').val();
                        data.date = date;
                    },
                },
            });
            $(document).find('#example').wrap('<div style="overflow-x:auto; width:100%;"></div>');

            $('#datepicker_from').change(function(){
                example.ajax.reload();
            });
        });

        function updateTable1() {
            $('.date_range_filter').val('');
            example.ajax.reload();
        }

        $(document).on('click', '#viewOrderedProductDetails', function() {

            let id = $(this).data('id');

            $.ajax({
                url: "{{ route('SA-viewOrderedProducts') }}",
                type: "GET",
                data: {
                    id: id,
                },
                success: function(data) {
                    $('#viewConsolidateOrderData2').html(data);
                }
            })

        });
    </script>