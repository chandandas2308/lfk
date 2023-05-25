@extends('pos.layout.master')
@section('title','Orders | POS')
@section('body')

<head>
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="{{ asset('toastr/toastr.css') }}">
</head>

<main id="main" class="main"  style="padding: 20px 30px">
  <div class="pos">
    <div class="row p-2 m-3">
        <div class="d-flex justify-content-between">
            <div></div>
            <div>
              <a href="{{url('/pos/sales')}}" class="bg-addbtn nav-link mx-2 rounded">New Order</a>
            </div>
        </div>
   </div>
   <div class="table">
      <table class="table table-borderd" id="pos-sales-orders-table">
          <thead class="w-100">
             <tr>
                <th>S/N</th>
                <th>Created At</th>
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

<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script>
  
    pos_sales_table_orders = $('#pos-sales-orders-table').DataTable({
      "aaSorting": [],
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      // responsive: 'false',
      // dom: "Bfrtip",
      ajax: {
        url: "{{ route('pos.viewOrdersDetails') }}",
        type: 'get'
      },
    })

    $(document).on('click','#removeOrder', function(){

          let orderNo = $(this).data('orderno');
          let total = $(this).data('total');
      
            bootbox.confirm({
              size: "large",
              message: `ORDER ${orderNo} HAS A TOTAL AMOUNT OF $${total},<br> ARE YOU SURE YOU WANT TO DELETE THIS ORDER?`,
              callback: function(result){
                if (result) {
                  $.ajax({
                    url : "{{route('pos.remove-single-sales-order')}}",
                    type : "GET",
                    data : {
                      'order_number' : orderNo
                    },
                    success : function(data){
                      pos_sales_table_orders.ajax.reload();
                      if(data.status){
                        toastr.success(data.message);
                      }else{
                        toastr.error(data.message);
                      }
                    }
                  })
                }
              }
            })
    })

</script>

@endsection