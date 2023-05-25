@extends('pos.layout.master')
@section('title','Sales | POS')
@section('body')

<head>
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">
</head>

<main id="main" class="main"  style="padding: 20px 30px">
  <div class="pos">
    <div class="row p-2 m-3">
        <div class="d-flex justify-content-between">
        </div>
   </div>
   <div class="table table-responsive">
      <table class="table table-borderd" id="pos-sales-orders-table-list">
          <thead class="w-100">
             <tr>
                <th>S/N</th>
                <th>Date & Time</th>
                <th>Order No.</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
          </thead>
      </table>
   </div>
  </div>
</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1">
  <div class="modal-dialog modal-lg" style="width: 800px;">
    <div class="modal-content" id="sales-order-details">
    </div>
  </div>
</div>

<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script>
  
    pos_sales_table_orders = $('#pos-sales-orders-table-list').DataTable({
      "aaSorting": [],
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      // responsive: 'false',
      // dom: "Bfrtip",
      ajax: {
        url: "{{ route('pos.viewAllSalesOrdersDetails') }}",
        type: 'get'
      },
    })

    $(document).on('click','#viewOrders', function(){
      $.ajax({
        url : "{{ route('Pos.singleOrderDetails') }}",
        type : "GET",
        data : {
          "order_number" : $(this).data('id')
        },
        success : function(response){
          $('#exampleModal').modal('show');
          $('#sales-order-details').html(response);
        }
      })
    });

</script>

@endsection