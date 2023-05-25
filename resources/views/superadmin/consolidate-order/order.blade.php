<div class="p-3">
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Consolidate Orders
        </h4>
    </div>

    <!-- table start -->
    <div class="admin-card">
        <div class="container">
            <div class="p-3">
                    <table class="text-center table table-responsive table-bordered" id="consolidate_order_table">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-center">Consolidate Order No.</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Recipient Name</th>
                                <th class="text-center">Mobile No.</th>
                                <th class="text-center">Payment Term</th>
                                <th class="text-center">Total Order</th>
                                <th class="text-center">Cash Collectable</th>
                                <th class="text-center">Delivery Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
            </div>

        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="viewConsolidateOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2" id="viewConsolidateOrderData1">
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {

        var buttonCommon = {
            exportOptions: {
                columns: ':visible:not(:last-child)',
                stripHtml: false,
                format: {
                    body: function ( data, row, column, node ) {
                        return column === 7 ?
                            data.substr(data.length - 10) :
                            data;
                    }
                }
            }
        };
        
        consolidate_order_table = $('#consolidate_order_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength: 10,
            buttons: [
                $.extend( true, {}, buttonCommon, {
                    text: 'Export to Excel',
                    extend: 'excelHtml5',
                    className: 'btn btn-primary',
                } )
            ],
            ajax: {
                url: "{{ route('SA-RetailCustomerOrders') }}",
                type: 'GET',
                data: 0,
            }
        });
        $(document).find('#consolidate_order_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    });

    $(document).on("click", "a[name = 'viewConsolidateOrder1']", function(e) {
        let id = $(this).data("id");

        $.ajax({
            url: "{{ route('SA-ViewConsolidateOrderIndex') }}",
            type: "GET",
            data: {
                id: id,
            },
            success: function(data) {
                $('#viewConsolidateOrderData1').html(data);
            }
        })

    });
</script>