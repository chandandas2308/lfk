@extends('pos.layout.master')
@section('title','Customer | POS')
@section('body')
<?php
// print_r($product);
?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1 class="ms-5 ps-2">Edit Stock</h1>
        <br>
    </div>
    @if(session()->has('message'))
    <div class="alert alert-success" id="alert">
        {{ session()->get('message') }}
    </div>
    @endif
    <section class="section customer">
        <div class="row">
            <div class="col-12 mt-3">
                <div class="row">
                    <form action="{{url('/pos/stock-update',$new->id)}}" method="post" enctype="multipart">
                    @csrf 
                       <div class="row mb-3">
                            <div class="col-1"></div>
                            <div class="col-4">
                               <div class="col-12">
                                <label for="inputText" class="col-sm-5 col-form-label">Product Name :</label><br>
                                    <select name="product_name" id="product_name" onchange="getvarient10()" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($product as $key => $value)
                                        <option value="">{{$value->product_name}}</option>
                                        @endforeach
                                    </select>
                               </div>
                               <br>
                               <div class="col-12">
                                <label for="inputText" class="col-sm-5 col-form-label">Product Name :</label><br>
                                    <select name="product_name" id="product_name" class="form-control   ">
                                        <option value="">Select</option>
                                        @foreach($product as $key => $value)
                                        <option value="">{{$value->product_name}}</option>
                                        @endforeach
                                    </select>
                               </div>
                            </div>
                            <div class="col-2"></div>
                            <div class="col-4">
                                <div class="col-12">
                                    <label for="inputText" class="col-sm-5 col-form-label">Product Varient :</label><br>
                                    <select class="form-select w-100" name="product_varient" onchange="fetchData()" id="product_varient">
                                                
                                    </select>
                                </div>
                            </div>
                            <div class="col-1"></div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
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
                $('#product_varient').html('');
                $('#product_varient').append('<option value="">Select Varient</option>');
              $.each(response,function(key , value)
              {
                alert("hello");
            //     $('#product_varient').append(`
            //         <option value="${value['product_varient']}">${value['product_varient']}</option>
            //     `)
              })
            }
    });
}
function fetchData(){
    let product_name = $('#product_name').val();
    let product_varient = $('#product_varient').val();
    $.ajax({
            type : "GET",
            url : "{{route('Pos-GetAllData')}}",
            data: {
               "name": product_name,
                "varient" : product_varient,
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