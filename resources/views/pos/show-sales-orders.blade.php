<div class="modal-header">
    <h5 class="modal-title">Order Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
                    
<div class="modal-body">
    <div class="table table-responsive">
      <table class="table table-borderd" id="pos_sales_table_orders_list" style="width:100%;">
          <thead class="w-100">
             <tr>
                <th>S/N</th>
                <th>Product Name</th>
                <th>Variant</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
          </thead>
      </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="bg-addbtn  mx-2 rounded" data-bs-dismiss="modal">Close</button>
</div>

<script>
    pos_sales_table_orders_list = $('#pos_sales_table_orders_list').DataTable({
      "aaSorting": [],
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      // responsive: 'false',
      // dom: "Bfrtip",
      ajax: {
        url: "{{ route('pos.viewSingleSalesOrdersDetails') }}",
        type: 'get',
        data: {
            "order_number" : "{{ $order_number }}",
        }
      },
    })
</script>