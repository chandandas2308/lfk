<div class="">
    <h5 class="bg-primary px-3 py-2 text-white text-center">Exchange Goods Warehouse</h5>
    <!-- table start -->
    <!-- <div class="table-responsive"> -->
            <table class="text-center table table-responsive table-bordered" id="exchange_goods_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">User Name</th>
                        <th class="text-center">Invoice Date</th>
                        <th class="text-center">Product Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Unit Price</th>
                    </tr>
                </thead>
            </table>
        <!-- </div> -->
    <!-- table end here -->
</div>

<script>

    $(document).ready(function() {
        exchange_goods_main_table = $('#exchange_goods_main_table').DataTable({
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
                url: "{{ route('SA-GetReturnGoodsWarehouseDetails') }}",
                type: 'GET',
                data : {
                    "type" : "exchange",
                },
            }
        });
        $(document).find('#exchange_goods_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    });
    
</script>