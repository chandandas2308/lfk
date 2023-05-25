@extends('pos.layout.master')
@section('title','Stock | YKPTE POS')
<head>
<link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
</head>
@section('body')

<main id="main" class="main">
    <section class="section customer ">
        <div class="col-12 mb-2 p-3">
            <h4><strong>STOCK</strong></h4>
        </div>
        <div class="col-12 mt-3">
            <div class="row">
                <div class="table table-responsive">
                    <table class="table table-borderd" id="pos_stock_table_orders_list" style="width:100%;">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Product Name</th>
                                <th>Product Variant</th>
                                <th>Unit Price</th>
                                <th>Quantity Available</th>
                                <th> Barcode </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Stock Information</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                             <div class="col-12">
                                <div class="row">
                                    <!-- <div class="col-12">
                                        <label for="" class="form-label" style="width: 200px;">ID :</label>
                                        <span id="stock-id" class="w-50"></span>
                                    </div>   -->
                                    <br>
                                    <div class="col-12">
                                        <div class="row">
                                            <label for="name" class="form-label mt-1" >Product Name :</label>
                                            <input type="text" name="stock-name" id="stock-name" class="form-control" disabled>
                                        </div>
                                    </div>                                 
                                    <br>
                                    <div class="col-12 mt-3">
                                       <div class="row">
                                                <label for="varient" class="form-label mt-1" style="width: 200px;">Product Variant :</label>
                                                <input type="text" name="stock-variant" id="stock-variant" class="form-control" disabled>
                                          
                                       </div>
                                    </div>                                 
                                    <div class="col-12 mt-3">
                                       <div class="row">
                                            <label for="unit" class="form-label mt-1" >Unit Price :</label>
                                            <input type="text" name="stock-unit-price" id="stock-unit-price" class="form-control" disabled>
                                       </div>
                                    </div>                                 
                                    <div class="col-12 mt-3">
                                        <div class="row">
                                            <label for="" class="form-label mt-1" >Quantity :</label>
                                            <input type="text" name="stock-quantity" id="stock-quantity" class="form-control" disabled>
                                        </div>
                                    </div>                                 
                                </div>
                             </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="bg-addbtn nav-link mx-2 rounded" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){
    pos_stock_table_orders_list = $('#pos_stock_table_orders_list').DataTable({
      "aaSorting": [],
      rowReorder: {
        selector: 'td:nth-child(2)'
      },
      // responsive: 'false',
      // dom: "Bfrtip",
      ajax: {
        url: "{{ route('pos.viewPosStockDetails') }}",
        type: 'get',
      },
    })
})

    $(document).on('click','#show-stock' ,function(){
        var stockURL = $(this).data('url');
        $.get(stockURL ,function (data){
            $('#exampleModal').modal('show');
            $('#stock-name').val(data.product_name);
            $('#stock-variant').val(data.product_variant);
            $('#stock-unit-price').val(data.unit_price);
            $('#stock-quantity').val(data.quantity);
        });
    });
</script>

@endsection

