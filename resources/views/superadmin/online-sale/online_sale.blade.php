<div class="p-3 mt-3 bg-white">
    <!-- invoice Tab -->
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Online Sale
        </h4>
        <div class="d-flex">
            <a class="btn btn-primary" href="{{ route('retail_customer_order.create') }}">Add Order</a>
        </div>
    </div>

    <!-- table start -->
    <!-- <div class="table-responsive"> -->
    <table class="text-center table table-responsive table-bordered" id="retail_customer_12_details">
        <thead class="fw-bold text-dark">
            <tr>
                <th class="p-2 border border-secondary">S/N</th>
                <th class="p-2 border border-secondary">Order No.</th>
                <th class="p-2 border border-secondary">Customer Name</th>
                <th class="p-2 border border-secondary">Mobile No.</th>
                <th class="p-2 border border-secondary">Payment Term</th>
                <th class="p-2 border border-secondary">Remark</th>
                <th class="p-2 border border-secondary">Total Amount</th>
                <th class="p-2 border border-secondary">Delivery Date</th>
                <th class="p-2 border border-secondary">Action</th>
            </tr>
        </thead>
    </table>
    <!-- </div> -->


    <!-- Model -->

    <div class="modal fade" id="edit_online_sale_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content p-2" id="edit_online_sale_modal_content">
            </div>
        </div>
    </div>

    <script>
        $(document).on("click", "a[name = 'edit_online_sale_btn']", function(e) {
            let consolidate_order_no = $(this).data('consolidate_order_no');
            $.ajax({
                url: "{{ route('get_online_Sale_data') }}",
                data: {
                    consolidate_order_no: consolidate_order_no,
                },
                type: 'get',
                success: function(data) {
                    if (data) {
                        $('#edit_online_sale_modal').modal('show');
                        $('#edit_online_sale_modal_content').html(data);
                    }
                }

            })
        });


        $(document).ready(function() {
            getRetailCustomerOrdersDetials = $('#retail_customer_12_details').DataTable({
                "aaSorting": [],
                "bDestroy": true,
                pageLength: 40,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                buttons: [],
                // responsive: 'false',
                dom: "Bfrtip",
                ajax: {
                    url: "{{ route('SA-RetailCustomerOrders') }}",
                    type: 'get',
                    data: {
                        'data': 1
                    }
                },
            });
            $(document).find('#retail_customer_12_details').wrap('<div style="overflow-x:auto; width:100%;"></div>')
        });
    </script>
