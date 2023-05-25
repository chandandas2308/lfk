@extends('pos.layout.master')
@section('title','Sales | POS')

<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.4.6/tailwind.min.css">
</head>

@section('body')

<style>
  /* footer{
    border-top:none !important;
    padding-top:40px !important;
  } */

  .filter-switch label {
    cursor: pointer;
  }
  .filter-switch-item input:checked + label{
    color: #000;
    font-weight: bolder;
  }
  .filter-switch-item input:not(:checked) + label {
    --bg-opacity: 0;
    box-shadow: none;
  }

  .order > .selected{
    background-color: lightblue;
  }

  .provider {
    flex: 0 1 auto;
    align-self: auto;
}

.provider:hover{
  cursor: pointer;
}

.displayCss{
  display: none !important;
}

.displayCss2{
  display: none !important;
}

</style>

<main id="main" class="main">
<div class="pos">
  <div class="pos-topheader">
    <div class="pos-branding">
      <div class="ticket-button">
        <a href="{{ route('pos.viewOrdersDashboard') }}" style="color:#000;">
          <div class="with-badge" badge="{{ $total_orders }}">
            <i class="fa fa-ticket" aria-hidden="true"></i>
            Orders
          </div>
        </a>
      </div>
    </div>
  </div>
    <div class="pos-content">
        <div class="window">
          <div class="subwindow">
            <div class="subwindow-container">
              <div class="subwindow-container-fix screens">
                <div class="product-screen screen">
                  <div class="screen-full-width">
                    <div class="leftpane pane-border">
                      <div class="order-container">
                        <div class="order p-2">
                          <div class="order-empty">
                            <i class="fa fa-shopping-cart" role="img" aria-label="Shopping cart" title="Shopping cart"></i>
                            <h1>This order is empty</h1>
                          </div>
                        </div>
                      </div>
                      
                      <div class="total mb-1">
                        <div class="row">
                          <div class="col-12">
                            <div class="row">
                            <div class="col-5 float-left"></div>
                            <div class="col-1 float-left"></div>
                            <div class="Total col-5 justify-content-end text-end">
                               <div class="col-4 float-left"></div>
                               <div class="amt col-8 float-right"><strong>Total:&nbsp; $<span id="totalBill">0.00</span></strong></div>
                            </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="pads">
                        <div class="control-buttons">
                          <div class="control-button">
                            <i class="fa fa-sticky-note"></i>
                            <span></span>
                            <span data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                Customer Note
                            </span>
                          </div>
                          <span class="control-button">
                            <i class="fa fa-barcode"></i>
                            <span></span>
                            <span data-bs-toggle="modal" data-bs-target="#coupon-modal">
                              Coupon Code  
                            </span>
                          </span>
                          <!-- <span class="control-button">
                            <i class="fa fa-star"></i>
                            <span></span>
                            <span>Reward</span>
                          </span> -->
                        </div>
                        <div class="subpads">
                          <div class="actionpad">
                            <a href="/pos/customers/{{$order_number}}" class="button set-partner">
                              <i class="fa fa-user" role="img" aria-label="Customer" name="customer" title="Customer" onclick="fetchdata()"></i> <h6 class="mt-3"><b>
                                @php
                                  $data = DB::table('pos__orders')->where('order_no', $order_number)->first();
                                @endphp

                                @if($data != null)
                                    @if($data->customer_name != null)
                                      {{$data->customer_name}}
                                    @else
                                      Customer
                                    @endif
                                  @else
                                    Customer
                                @endif
                              </b></h6> </a>
                               @if($data != null)
                                  @if($data->customer_name != null)
                                    <a href="/pos/payments/sales/{{$data->order_no}}" class="button pay validation">
                                      <div class="pay-circle">
                                        <i class="fa fa-chevron-right" role="img" aria-label="Pay" title="Pay"></i>
                                      </div>Payment
                                    </a>
                                  @else
                                    <a href="javascript:void(0)" class="button pay validation">
                                      <div class="pay-circle">
                                        <i class="fa fa-chevron-right" role="img" aria-label="Pay" title="Pay"></i>
                                      </div>Payment
                                    </a>
                                  @endif
                                @else
                                <a href="javascript:void(0)" class="button pay validation">
                                  <div class="pay-circle">
                                    <i class="fa fa-chevron-right" role="img" aria-label="Pay" title="Pay"></i>
                                  </div>Payment
                                </a>
                               @endif
                          </div>
                          <div class="numpad filter-switch">
                            <button class="input-button number-char" data-number="1">1</button>
                            <button class="input-button number-char" data-number="2">2</button>
                            <button class="input-button number-char" data-number="3">3</button>

                            <div class="filter-switch-item my-auto">
                              <input type="radio" name="filter1" value="qty" id="filter1-0" class="sr-only" checked>
                              <label for="filter1-0">
                                Qty
                              </label>
                            </div>

                            <button class="input-button number-char" data-number="4">4</button>
                            <button class="input-button number-char" data-number="5">5</button>
                            <button class="input-button number-char" data-number="6">6</button>

                            <div class="filter-switch-item my-auto">
                              <input type="radio" name="filter1" value="disc" id="filter1-1" class="sr-only">
                              <label for="filter1-1">
                                Disc
                              </label>
                            </div>

                            <button class="input-button number-char" data-number="7">7</button>
                            <button class="input-button number-char" data-number="8">8</button>
                            <button class="input-button number-char" data-number="9">9</button>

                            <div class="filter-switch-item my-auto">
                              <input type="radio" name="filter1" value="price" id="filter1-2" class="sr-only">
                              <label for="filter1-2">
                                Price
                              </label>
                            </div>

                            <button class="input-button numpad-minus">+/-</button>
                            <button class="input-button number-char" data-number="0">0</button>
                            <button class="input-button number-char" data-number=".">.</button>
                            <button class="input-button numpad-backspace" onclick="backspace()" id="cancel">
                              <img style="pointer-events: none;" src="{{ asset('pos/assets/img/backspace.png')}}" width="24" height="21" alt="Backspace">
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="rightpane">
                      <div class="products-widget">
                        <div class="products-widget-control">
                          <div class="rightpane-header border border-bottom">
                            <div class="search-bar-container sb-product">
                              <div class="pos-search-bar">
                                <i class="fa fa-search"></i>
                                <input placeholder="Search Products..." type="text" autofocus="autofocus" id="psearch">
                                <i class="fa fa-times search-clear-partner"></i>
                              </div>
                            </div>
                            <div class="categories-header">
                              <div class="breadcrumbs">
                                <span class="breadcrumb">
                                  <span class="breadcrumb-button breadcrumb-home my-auto">
                                    <i class="fa fa-home" role="img" aria-label="Home" title="Home"></i>
                                  </span>
                                  <input type="hidden" name="order_number" id="current_order_number" value="{{ $order_number }}">
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="product-list-container">
                          <div class="product-list"></div>
                          <div class="portal search-database-button no-results-message oe_hidden"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <div>
</div>

<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>

<div class="modal fade" id="coupon-modal" tabindex="-1">
        <div class="modal-dialog" role="document" style="left:40%;">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ GoogleTranslate::trans('COUPON', app()->getLocale()) }}
                    </h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true" style="font-size: xx-large; border: none; background-color: transparent; margin: 0; padding: 0; color:#000;">&times;</button>
                    
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="form-control" type="text"
                            placeholder="{{ GoogleTranslate::trans('Enter Coupon Code', app()->getLocale()) }}"
                            id="coupon_code" />
                    </div>
                    <button type="submit" class="bg-addbtn  mx-2 rounded" id="apply_coupon_btn" style="font-size:14px;">
                        <i class="fa fa-spinner fa-spin" id="apply_coupon_spinner" style="display: none"></i>
                        {{ GoogleTranslate::trans('Apply Coupon', app()->getLocale()) }}</button>
                </div>
            </div>
        </div>
    </div>

<script>
      var task="qty";
      var value="0";

      $("input[name=filter1]").on('click', function(){
        task = $(this).val();
        $('.order').find('.selected').data("count", 0);
      });

      $(".numpad > button").on('click', function(){
        value = $(this).data('number');
        updateOrder(task, value);
      });

      function updateOrder(task, value){

        let product_id = $('.order').find('.selected').data('id');
        let final_price;

        if(task == "qty"){

          let quantity = $('.order').find('.selected').find('.quantity').text();

          if(quantity == 0){
            $('.order').find('.selected').find('.quantity').html(value);

            quantity = $('.order').find('.selected').find('.quantity').text();

            let price = $('.order').find('.selected').find('.product_price').text();

            let total = parseInt(quantity)*parseFloat(price);

            $('.order').find('.selected').find('.total').html(total);

            updateOrderQuantity(product_id, quantity);
            
          }else{

            let count = $('.order').find('.selected').data('count');
            
            if(count <= 0){
              
              $('.order').find('.selected').find('.quantity').html(value);
              $('.order').find('.selected').data("count", ++count);

              quantity = $('.order').find('.selected').find('.quantity').text();

              let price = $('.order').find('.selected').find('.product_price').text();

              let total = parseInt(quantity)*parseFloat(price);

              $('.order').find('.selected').find('.total').html(total);

              updateOrderQuantity(product_id, quantity);
            }else{
              
              $('.order').find('.selected').find('.quantity').append(value);

              quantity = $('.order').find('.selected').find('.quantity').text();

              let price = $('.order').find('.selected').find('.product_price').text();

              let total = parseInt(quantity)*parseFloat(price);

              $('.order').find('.selected').find('.total').html(total);

              updateOrderQuantity(product_id, quantity);
            }

          }
          
        }else if(task == "disc"){

          // Discount
          disc = $('.order').find('.selected').find('.disc').text();

          if(disc == 0){
            $('.order').find('.selected').find('.disc-section').show();
            $('.order').find('.selected').find('.disc-section').removeClass('displayCss');
            $('.order').find('.selected').find('.disc').html(value);
            $('.order').find('.selected').data("count", 1);
            price = $('.order').find('.selected').find('.product_price').data('price');
            discount = $('.order').find('.selected').find('.disc').text();
            discount_value = (parseFloat(price)*parseFloat(discount))/100;
            
            $('.order').find('.selected').find('.product_price').html(price-discount_value);
            price = $('.order').find('.selected').find('.product_price').text();
            quantity = $('.order').find('.selected').find('.quantity').text();
            
            let total = parseInt(quantity)*parseFloat(price);
            
            $('.order').find('.selected').find('.total').html(total);

            addProductDiscount(product_id, discount);

          }else{
            let count = $('.order').find('.selected').data('count');
            
            if(count <= 0){
              $('.order').find('.selected').find('.disc').html(value);
              var discount = $('.order').find('.selected').find('.disc').text();
              if(parseInt(discount) <= 0){
                $('.order').find('.selected').find('.disc-section').hide();
                $('.order').find('.selected').find('.disc-section').addClass('displayCss');
              }
              $('.order').find('.selected').data("count", 1);
              
            price = $('.order').find('.selected').find('.product_price').data('price');
            discount = $('.order').find('.selected').find('.disc').text();
            discount_value = (parseFloat(price)*parseFloat(discount))/100;
            $('.order').find('.selected').find('.product_price').html(price-discount_value);
            price = $('.order').find('.selected').find('.product_price').text();
            quantity = $('.order').find('.selected').find('.quantity').text();
            
            let total = parseInt(quantity)*parseFloat(price);
            
            $('.order').find('.selected').find('.total').html(total);

            addProductDiscount(product_id, discount);

            }else{
              $('.order').find('.selected').find('.disc').append(value);
              
            price = $('.order').find('.selected').find('.product_price').data('price');
            discount = $('.order').find('.selected').find('.disc').text();
            discount_value = (parseFloat(price)*parseFloat(discount))/100;
            
            $('.order').find('.selected').find('.product_price').html(price-discount_value);
            price = $('.order').find('.selected').find('.product_price').text();
            quantity = $('.order').find('.selected').find('.quantity').text();
            
            let total = parseInt(quantity)*parseFloat(price);
            
            $('.order').find('.selected').find('.total').html(total);

            addProductDiscount(product_id, discount);

            }

          }

        }else{

          // PRICE
          product_price = $('.order').find('.selected').find('.product_price').text();
          if(product_price == 0){
            
            $('.order').find('.selected').find('.product_price').html(value);
            $('.order').find('.selected').find('.product_price').data('price',value);
            price = $('.order').find('.selected').find('.product_price').text();
            updateOrderPrice(product_id, price);
            
            quantity = $('.order').find('.selected').find('.quantity').text();
            
            let total = parseInt(quantity)*parseFloat(price);
            
            $('.order').find('.selected').find('.total').html(total);

            totalBill();

          }else{
            let count = $('.order').find('.selected').data('count');
            if(count <= 0){
              $('.order').find('.selected').find('.product_price').html(value);
              $('.order').find('.selected').find('.product_price').data('price',value);
              $('.order').find('.selected').data("count", ++count);
              price = $('.order').find('.selected').find('.product_price').text();
              updateOrderPrice(product_id, price);
              
              quantity = $('.order').find('.selected').find('.quantity').text();
              let total = parseInt(quantity)*parseFloat(price);
              $('.order').find('.selected').find('.total').html(total);
              
              totalBill();
            }else{
              $('.order').find('.selected').find('.product_price').append(value);
              $('.order').find('.selected').find('.product_price').data('price',value);
              price = $('.order').find('.selected').find('.product_price').text();
              updateOrderPrice(product_id, price);
              quantity = $('.order').find('.selected').find('.quantity').text();
              let total = parseInt(quantity)*parseFloat(price);
              $('.order').find('.selected').find('.total').html(total);

              totalBill();
            }
          }
        }
      }

    // })

    function totalBill(){
      let total = 0;
      $('.order > div').each(function(){
        total += parseFloat($(this).find('.total').text());
      })
      $('#totalBill').text(total);
    }

      function backspace(){
        if(task == 'qty'){
          let quantity = $('.order').find('.selected').find('.quantity').text();
          let arr = quantity.split("");
          arr.pop();
          let final_quantity = arr.join("");
          
          if(final_quantity == 0){
            $('.order').find('.selected').find('.quantity').html(0);
          }else{
            $('.order').find('.selected').find('.quantity').html(arr.join(""));
          }
        }else if(task == 'disc'){
          
          let disc = $('.order').find('.selected').find('.disc').text();
          let arr = disc.split("");
          arr.pop();
          let final_disc = arr.join("");

          if(final_disc == 0 || arr.length == 0){
            $('.order').find('.selected').find('.disc-section').addClass('displayCss2');
            $('.order').find('.selected').find('.disc-section').hide();
            $('.order').find('.selected').find('.disc').html(arr.join(""));
          }else{
            $('.order').find('.selected').find('.disc').html(arr.join(""));
          }

        }else{
          let product_price = $('.order').find('.selected').find('.product_price').text();
          let arr = product_price.split("");
          arr.pop();
          let final_price = arr.join("");
          
          if(final_price == 0){
            $('.order').find('.selected').find('.product_price').html(0);
          }else{
            $('.order').find('.selected').find('.product_price').html(arr.join(""));
          }
        }
      }



         $(document).on("keyup","#psearch" ,function(){
            let product_name = $('#psearch').val();
            $.ajax({
              type: "GET",
              url : "{{route('Pos-ProductSearch')}}",
              data : {
                  "product_name":product_name,
              },
              success : function (response) {

                    $('.product-list').html("");

                    if(response.length == 0){
                        $('.product-list').addClass('bg-white');
                        $('.product-list').append(`<center><img src="{{asset('pos/assets/img/no-record.png')}}"></center>`);
                    }else{
                      $('.product-list').html("");
                      $('.product-list').removeClass('bg-white');
                      $.each(response, function(key , value){
                          $('.product-list').append(`
                              <article class="product" tabindex="0" data-product-id="5" aria-labelledby="article_product_5" onclick="addToCart(${value["id"]})">
                                    <div class="product-img">
                                      <img src="${value['img_path']}" alt="${value['product_name']}">
                                    </div>
                                    <div class="product-content">
                                      <div class="product-name" id="article_product_5">${value['product_name']}</div>
                                      <span class="price-tag">$${value['min_sale_price']}</span>
                                    </div>
                              </article>
                          `)
                      });
                    }
                  }
                })
              })

  function addToCart(id){
    $.ajax({
      type : "get",
      url : "{{ route('pos.add-to-pos-order') }}",
      data: {
        "product_id": id,
        "order_number" : $('#current_order_number').val(),
      },
      success : function (response){
        getAllOrders();     
      }
    });
  }

  $(document).ready(function (){
     getAllOrders();
  });


  function getAllOrders(){
    $.ajax({
      type : "get",
      data : {
        "order_number" : $('#current_order_number').val(),
      },
      url : "{{route('pos.fetch-order-details')}}",
      success : function (response){
        if(response.data.length > 0){
          $('.order').html('');
          let j=0;
          let totalBill =  0;
          $.each(response.data, function(key , value){
            $('.order').append(`
              <div tabindex="0" id="order-tab${++j}" class="p-2 provider" data-count="0" data-id="${value['product_id']}">
                <div class="d-flex justify-content-between">
                  <div class="fw-bold">${value['product_name']}</div>
                  <div class="fw-bold">$
                    <span class="total">
                      ${value["discount"] != null?`${(parseFloat(value['unit_price'])-((parseFloat(value['unit_price'])*parseFloat(value['discount']))/100))*parseFloat(value['quantity'])}`:`${(parseFloat(value['unit_price'])*parseFloat(value['quantity']))}`}
                    </span>
                  </div>
                </div>
                <div class="d-flex" style="font-size:smaller;">
                  <span class="fw-bold quantity">${value['quantity']}</span>/Units at $
                    <span class="product_price" data-price="${value["unit_price"]}">
                      ${value["discount"] != null?`${parseFloat(value['unit_price'])-((parseFloat(value['unit_price'])*parseFloat(value['discount']))/100)}`:`${parseFloat(value['unit_price'])}`}
                    </span>/Units
                </div>
                <div class="d-flex" style="font-size:smaller;">
                    <div class="fw-bold disc-section ${value["discount"] != null?'':'displayCss'}">With a <span class="disc">${value["discount"] != null?`${value["discount"]}`:''}</span>% discount</div>
                </div>
              </div>
            `);
            totalBill += parseFloat(value["total"]);
          });

          $('#totalBill').text(totalBill);
             
          var doc = document;
          var providers = doc.getElementsByClassName("provider");

              for (var i = 0; i < providers.length; i++) {
                  providers[i].onclick = function() {
                    $('.order').find('.selected').data('count', 0);
                    $('.order').find('.selected').removeClass('selected');
                    $(this).addClass('selected');
                  };
              }
        }

      }
    })
  }   
          $.ajax({
                type : "GET",
                url : "/pos/product/get-product",
                success : function (response){
                    if(response.length <= 0){
                        
                        $('.product-list-container').addClass('bg-white');
                        $('.product-list-container').append(`<center><img src="{{asset('pos/assets/img/no-record.png')}}"></center>`);

                    }else{
                      $('.product-list').html('');
                      $.each(response, function(key , value){
                        $('.product-list').append(`
                            <article class="product" tabindex="0" data-product-id="5" aria-labelledby="article_product_5" onclick="addToCart(${value['id']})">
                                  <div class="product-img">
                                    <img src="${value['img_path']}" alt="Office Chair">
                                  </div>
                                  <div class="product-content">
                                    <div class="product-name" id="article_product_5">${value['product_name']}</div>
                                    <span class="price-tag">$${value['min_sale_price']}</span>
                                  </div>
                            </article>
                        `)
                      })
                    }
                  }
              });

              // update quantity
              function updateOrderQuantity(product_id,quantity){
                $.ajax({
                  type : "GET",
                  url : "{{ route('pos.update-quantity') }}",
                  data : {
                    'product_id' : product_id,
                    'quantity' : quantity,
                    "order_number" : $('#current_order_number').val(),
                  },
                  success : function(response){
                    console.log(response.message);
                  }
                });
              }
              // end here
              
              // update quantity
              function updateOrderPrice(product_id,price){
                $.ajax({
                  type : "GET",
                  url : "{{ route('pos.update-product-price') }}",
                  data : {
                    'product_id' : product_id,
                    'price' : price,
                    "order_number" : $('#current_order_number').val(),
                  },
                  success : function(response){
                    console.log(response.message);
                  }
                });
              }
              // end here
              
              // add discount
              function addProductDiscount(product_id,discount){
                $.ajax({
                  type : "GET",
                  url : "{{ route('pos.add-product-price-discount') }}",
                  data : {
                    'product_id' : product_id,
                    'discount' : discount,
                    "order_number" : $('#current_order_number').val(),
                  },
                  success : function(response){
                    console.log(response.message);
                  }
                });
              }
              // end here

</script>
</main>