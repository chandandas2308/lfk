@extends('pos.layout.master')
@section('title','Customer | POS')
@section('body')
<?php
if(isset($product));
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Product</h1>
        <br>
    </div>
  <div class="row mt-1 mb-4">
   
    <div class="col-7">
        <div class="row">
            <div class="col-6">
            <input type="text" class="form-control float-start w-100" name="psearch"  id="psearch" placeholder="Search Product">
            </div>
            <div class="col-6">
                <select class="form-select float-end w-75" onchange="getdata()" id="category" >
                    <option value="0">Select</option>
                    @foreach($product as $key => $value)
                        <option value="{{ $value->product_category }}">{{$value->product_category}}</option>
                    @endforeach
                </select>
            </div>
        </div>             
    </div>
    <div class="col-3">
        <div class="float-start">
            <a href="" class="bg-addbtn nav-link mx-2 rounded mt-0">Reset</a>
        </div>
    </div>
    <div class="col-2"></div>
  </div>
    <div class="col-12 mt-5">
        <div class="row product-card">
        </div>
    </div>
</main>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<style>
    .product-item {
    margin-bottom: 30px;
    background-color: #fff;
    border: none;
    border-radius: 10px;
    width: 100%;
    box-shadow: 0 4px 8px 0 rgb(0 0 0 / 20%), 0 6px 20px 0 rgb(0 0 0 / 19%);
}
.product-item .product-thumb {
    position: relative;
}
.product-item .product-thumb:before {
    transition: 0.3s all;
    opacity: 0;
    background: rgba(0, 0, 0, 0.6);
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    border-radius: 10px;
}

.product-item .product-thumb .preview-meta {
    position: absolute;
    text-align: center;
    bottom: 0;
    left: 0;
    width: 100%;
    justify-content: center;
    opacity: 0;
    transition: 0.2s;
    -webkit-transform: translateY(10px);
    transform: translateY(10px);
}
.product-item .product-content {
    text-align: center;
}
.product-item .product-content h4 {
    font-size: 16px;
    font-weight: 800;
    margin-top: 15px;
    margin-bottom: 6px;
}
.product-item .product-content h4 a {
    color: #000;
}
.price {
    font-size: 18px;
    font-weight: 600;
    color: #000;
    padding-left: 10px;
}
.add-cart {
    padding: 5px 10px;
    background: #ef5056;
    border: none;
    font-weight: 500;
    border-radius: 3px;
    margin-top: 5px;
    margin-bottom: 20px;
    color: #000;
}
.add-cart:hover{
    
    color: #fff;
}
</style>
<script>
            let id = $('#category').val();
            $.ajax({
                type : "GET",
                url : "/pos/product/get-product",
                success : function (response){
                    $('.product-card').html("");
                    if(response.length == 0){
                        $('.product-card').append(`<center><img src="{{asset('pos/assets/img/no-record.png')}}"></center>`);
                    }else{
                        $.each(response, function(key , value){
                            $('.product-card').append(`
                            <div class="col-xxl-2 col-md-4" style="width: 250px;">
                                <div class="card">
                                    <img src="${value['img_path']}" class="card-img-top" height="150" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">${value['product_name']}</h5>
                                        <hr>
                                        <p class="card-text">
                                            <div class="row">
                                                <div class="col-5" style="font-size:smaller;">Category :</div>
                                                <div class="col-7" style="font-size:smaller;">${value['product_category']}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-5" style="font-size:smaller;">Price :</div>
                                                <div class="col-7" style="font-size:smaller;">$${value['min_sale_price']}</div>
                                            </div>
                                        </p>
                                    </div>
                                </div>                         
                            </div>
                            `)
                        })
                    }
                }
            });

    function getdata(){
        let category = $('#category').val();
        $.ajax({
            type: "GET",
            url : "/pos/product/get-perticular-product",
            data : {
                "category":category,
            },
            success : function (response) {    
                    $('.product-card').html("");
                    if(response.length == 0){
                        $('.product-card').append(`<center><img src="{{asset('pos/assets/img/no-record.png')}}"></center>`);
                    }else{
                        $.each(response, function(key , value){
                                $('.product-card').append(`
                                <div class="col-xxl-2 col-md-4" style="width: 250px;">
                                    <div class="card">
                                        <img src="${value['img_path']}" class="card-img-top" height="150" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">${value['product_name']}</h5>
                                            <hr>
                                            <p class="card-text">
                                                <div class="row">
                                                    <div class="col-5" style="font-size:smaller;">Category :</div>
                                                    <div class="col-7" style="font-size:smaller;">${value['product_category']}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5" style="font-size:smaller;">Price :</div>
                                                    <div class="col-7" style="font-size:smaller;">$${value['min_sale_price']}</div>
                                                </div>
                                            </p>
                                        </div>
                                    </div>                         
                                </div> `)
                        })
                    }
            }
        })
    }
</script>
<script>
    $(document).on("keyup","#psearch" ,function(){
        let product_name = $('#psearch').val();
        $.ajax({
            type: "GET",
            url : "{{route('Pos-ProductSearch')}}",
            data : {
                "product_name":product_name,
            },
            success : function (response) {   
                $('.product-card').html("");
                    if(response.length == 0){
                        $('.product-card').append(`<center><img src="{{asset('pos/assets/img/no-record.png')}}"></center>`);
                    }else{
                        $('.product-card').html(""),
                        $.each(response, function(key , value){
                                $('.product-card').append(`
                                <div class="col-xxl-2 col-md-4" style="width: 250px;">
                                    <div class="card">
                                        <img src="${value['img_path']}" class="card-img-top" height="150" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">${value['product_name']}</h5>
                                            <hr>
                                            <p class="card-text">
                                                <div class="row">
                                                    <div class="col-5" style="font-size:smaller;">Category :</div>
                                                    <div class="col-7" style="font-size:smaller;">${value['product_category']}</div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-5" style="font-size:smaller;">Price :</div>
                                                    <div class="col-7" style="font-size:smaller;">$${value['min_sale_price']}</div>
                                                </div>
                                            </p>
                                        </div>
                                    </div>                         
                                </div> `)
                        })
                    }
           }
    });
});
</script>

@endsection