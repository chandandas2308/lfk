<div class="p-3">
    <div class="table-responsive">
        <table class="text-center table table-responsive table-bordered sales-report" id="sales_invoice_main_table_report">
            <thead>
                <tr class="col">
                    <th class="text-center">S/N</th>
                    <th class="text-center">Order No.</th>
                    <th class="text-center">Invoice No.</th>
                    <th class="text-center">Invoice Date</th>
                    <th class="text-center">Due Date</th>
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody class="sales-report-table"></tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        sales_invoice_main_table_report = $('#sales_invoice_main_table_report').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:10,
            buttons: [],
            ajax: {
                url: "{{ route('SA-InvoiceList') }}",
                type: 'GET',
            }
        });
    });
</script>