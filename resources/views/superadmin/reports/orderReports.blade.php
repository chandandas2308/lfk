    <div class="p-3">
        <div class="table-responsive-lg" style="overflow-x:scroll;">
            <table class="table text-center" id="sales_order_main_table_report">
                <thead>
                    <tr>
                    <th class="text-center">S/N</th>
                        <th class="text-center">RFQ No.</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Minimum Sale Price</th>
                        <th class="text-center">Previous Selling Price</th>
                        <th class="text-center">Order Deadline</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

<script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<!-- backend js file -->

<script>
        $(document).ready(function() {
        sales_order_main_table_report = $('#sales_order_main_table_report').DataTable({
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
                url: "{{ route('SA-getQuotationsorder') }}",
                type: 'GET',
            }
        });
    });
</script>