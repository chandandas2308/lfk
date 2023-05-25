@include('pos.layout.header')
@section('title','Customer | POS')
@section('body')
<?php
if(isset($pay));
?>
<main id="main" class="main">
    <div class="page-title">
        <div class="col-12 mt-3">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4"><a href="{{url('/pos/stock')}}" class="float-end btn btn-warning">Back</a></div>
            </div>
        </div>

        @if(session()->has('message'))
            <div class="alert alert-success" id="alert">
                {{ session()->get('message') }}
                <!-- <button type="button" class="close" data-dismiss="alert">x</button> -->
            </div>
         @endif
        <br>
        <div class="col-12 mt-2">
            <div class="row">
                <div class="heading">
                    <h3 class="ps-5">Add Stock</h3>
                </div>
            </di>
        </div>
        <br>
            <form action="{{route('Pos-AddStock2')}}" method="post">
                @csrf
               
                <div class="col-12 mt-3">
                    <div class="row">
                        <table class="table table-responsive ">
                            <table class="table table-borderd" id="" >
                                <thead class="thead-striped justify-content-center text-center">
                                    <tr>
                                        <th style="width:7%;">S/N</th>
                                        <th style="width: 9%;">SKU Code</th>
                                        <th style="width: 12%;">Product Name <span style="color:red;">*</span></th>
                                        <th style="width: 14%;">Product Variant <span style="color:red;">*</span></th>
                                        <th style="width: 9%;">Unit Price</th>
                                        <th style="width: 10%;">Quantity</th>
                                        <th style="width :10%;">Batch No</th>
                                    </tr>
                                </thead>
                                <tbody class="justify-content-center text-center">
                                    <tr>
                                        <td></td>
                                        <td>
                                            <input type="text" name="sku" id="sku" style="width: 140px;" class="form-control">
                                            @error('sku')
                                                <span class="text-danger">* required sku</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <select name="product_name" onchange="getvarient10()" id="product_name"  style="width:180px;" class="form-select">
                                                <option value="">Select</option>
                                                @foreach($product as $key => $value)
                                                    <option value="{{ $value->product_name }}">{{$value->product_name}}</option>
                                                @endforeach()
                                            </select>
                                            <br>
                                            @error('product_name')
                                                <span class="text-danger">* required product_name</span>
                                            @enderror
                                            
                                        </td>
                                        <td>
                                            <select class="form-select" name="product_variant" onchange="fetchData()" id="product_variant" style="width: 150px;">
                                                
                                            </select>       
                                        </td>
                                        <td>
                                            <input type="number" id="min_sale_price" name="min_sale_price" style="width: 140px;" class="form-control">
                                            <br>
                                            @error('unit')
                                                <span class="text-danger">* required unit</span>
                                            @enderror
                                        </td>
                                        <td>
                                            <input type="number" id="quantity" name="quantity" class="w-25 form-control">
                                            <br>
                                            @error('quantity')
                                                <span class="text-danger">* required quantity</span>
                                            @enderror
                                        </td>
                                        <td>
                                             
                                        </td>
                                        <td>
                                            <input type="text" id="batch_code" name="batch_code" class="w-25 form-control">
                                            <br>
                                            <!-- @error('batch_code')
                                                <span class="text-danger">* required batch_code</span>
                                            @enderror -->
                                        </td>                                      
                                    </tr>
                                </tbody>
                            </table>
                        </table>
                    </div>
                </div>
                <br>
                <div class="col-12">
                    <div class="row">
                        <div class="col-3">
                            <a href="#" class="btn btn-primary" style="width: 180px;">Add Item</a>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary" style="width: 180px;">Save</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</main>
<style>
    .w-25{
        width: 75% !important;
    }
</style>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script>
    function getvarient10(){
    let product_name = $('#product_name').val();
    // alert(product_name);
    $.ajax({
            type : "GET",
            url : "{{route('Pos-GetVarient')}}",
            data: {
               "name": product_name,
            },
            success : function (response){
                $('#product_variant').html('');
                $('#product_variant').append('<option value="">Select Varient</option>');
              $.each(response,function(key , value)
              {
                $('#product_variant').append(`
                    <option value="${value['product_variant']}">${value['product_variant']}</option>
                `)
              })
            }
    });
}
function fetchData(){
    let product_name = $('#product_name').val();
    let product_variant = $('#product_variant').val();
    $.ajax({
            type : "GET",
            url : "{{route('Pos-GetAllData')}}",
            data: {
               "name": product_name,
                "varient" : product_variant,
            },
            success : function (response){
              $.each(response,function(key , value){
                 $('#min_sale_price').val(value["min_sale_price"]);
              })
            }
    });
}
</script>
@endsection
@include('pos.layout.footer')
