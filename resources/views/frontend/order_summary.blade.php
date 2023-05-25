@extends('frontend.layouts.master') @section('title', 'LFK | Order Summary') @section('body') <div class="">
    <style>
        @media only screen and (max-width:767px) {
            #orderSummaryDetails .container2 {
                display: flex;
                flex-direction: column;
            }

            #orderSummaryDetails .container2 button,
            #orderSummaryDetails .container2 input {
                width: 100%
            }

            #orderSummaryDetails .container2 input {
                margin-top: 5px;
                margin-bottom: 5px;
            }
        }
    </style>
    <div class="checkout shopping" style="margin-top:2rem;margin-bottom:2rem">
        <div class="container">
            <div class="progress-main">
                <div class="circle active">
                    <span class="label">1</span>
                    <a href="#"><span class="title">{{ __('lang.order') }}</span></a>
                </div>
                <span class="bar done"></span>
                <div class="circle ">
                    <span class="label">2</span>
                    <a href="#"><span class="title">{{ __('lang.ADDRESS') }}</span></a>
                </div>
                <span class="bar"></span>
                <div class="circle ">
                    <span class="label">3</span>
                    <a href="#"><span class="title">{{ __('lang.delivery') }}</span></a>
                </div>
                <span class="bar"></span>
                <div class="circle ">
                    <span class="label">4</span>
                    <a href="#"><span class="title">{{ __('lang.billing') }}</span></a>
                </div>
                <span class="bar"></span>
                <div class="circle">
                    <span class="label">5</span>
                    <a href="#"><span class="title">{{ __('lang.done') }}</span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <h4 class="widget-title">{{ __('lang.order') }}</h4>
                    <div class="table-responsive">
                        <table class="table text-center table-bordered">

                            <thead>
                                <tr>
                                    <td>{{ __('lang.image') }}</td>
                                    <td>{{ __('lang.product_name') }}</td>
                                    <td>{{ __('lang.quantity') }}</td>
                                    <td>{{ __('lang.price') }}</td>
                                    <td>{{ __('lang.total_price') }}</td>
                                    <td>{{ __('lang.action') }}</td>
                                </tr>
                            </thead>
                            <tbody id="orderSummaryDetails"></tbody>
                        </table>
                    </div>

                </div>

            </div>
            <a href="{{ route('checkout.addressSummary') }}" style="pointer-events:none" id="confirm_order_btn"
                class="btn btn-main mt-20 firstNext">{{ __('lang.confirm_order') }}</a>
        </div>

    </div>
</div>
</div>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@accessible360/accessible-slick@1.0.1/slick/slick.min.js"></script>
@section('javascript')
    <script>
        $(document).ready(function() {

            setTimeout(() => {
                $('.bars').hide();
            }, 5000);

            get_cart_data2();
        })


        function get_cart_data2() {
            $.ajax({
                url: "{{ route('order_summary') }}",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#orderSummaryDetails').html("<i class='fa fa-spinner fa-spin'></i> Loading...");
                },
                success: function(data) {
                    let len = data.length;
                    // $('span#cart_count').text(len);
                    $('#orderSummaryDetails').html('');
                    $('#confirm_order_btn').css('pointer-events', '');
                    let toalPrice = 0;
                    let totalProductCount = 0;
                    if (window.location.pathname == '/order-summary' && len < 1) {
                        window.location.href = "/";
                    }
                    for (let i = 0; i < len; i++) {
                        let price = (Math.round((data[i]['discount_price'] == null ? (data[i]['product_price'] * data[i]['quantity']) : (data[i]['discount_price'] * data[i]['quantity'])) * 100) / 100).toFixed(2)
                        $('#orderSummaryDetails').append(`

                            
	<tr>
		<td>
			<img width="80" src="${data[i]["image"]}" alt="${data[i]['product_name']}" />
		</td>
		<td>
            <a href="/product/${data[i]["product_id"]}">
                                ${data[i]["product_name"]}
            </a>
		</td>
		<td>
			<div class="container2">
				
                <button class="cart-qty-minus-checkout" data-id="${data[i]['id']}" type="button" value="-">-</button>
				<input type="text" id="updateQty" data-id="${data[i]['id']}" name="qty" value="${data[i]["quantity"]}" class="input-text qty" onkeyup="if(this.value<0){this.value= this.value * -1}" />
                <button class="cart-qty-plus-checkout" data-id="${data[i]['id']}" type="button" value="+">+</button>
				
			</div>
		</td>
		<td>$${data[i]['discount_price'] == null ? data[i]['product_price']: `<del style="color:red">${data[i]['product_price']}</del> ${data[i]['discount_price']}`}</td>
		<td>$${price}</td>
		<td>
			<a class="product-remove cart__remove_checkout btn" data-id="${data[i]["id"]}" href="javascript:void(0)">
				<i class="fa fa-trash"></i>
			</a>
		</td>
	</tr>
                        `);
                        toalPrice += parseFloat(price);
                        // toalPrice += parseFloat(data[i]['product_price']) * parseFloat(data[i]['quantity']);
                        ++totalProductCount;
                    }
                    $('.cart__remove_checkout').click(function() {
                        console.log('checkout');
                        let id = $(this).data('id');
                        let url = "/destroy-cart/" + id;
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            },
                        });
                        $.ajax({
                            url: url,
                            type: 'delete',
                            dataType: 'json',
                            data: {
                                id: id,
                            },
                            success: function(data) {
                                if (data.status == 'success') {
                                    $('#coupon_discount').html('-$' + parseFloat(data
                                        .coupon_discount).toFixed(2));
                                    $('#grand_total').html('$' + parseFloat(data
                                        .final_price).toFixed(2));
                                    $('#checkoutShipping').html(parseFloat(data
                                        .shipping_charge).toFixed(2));
                                    if (data.shipping_charge == -8) {
                                        $('#shippingChargeTitle').html('Shopping Discount');
                                    }
                                    $('#subTotalOnCheckout').html(parseFloat(data.sub_total)
                                        .toFixed(2));
                                    get_cart_data2();
                                    get_cart_data();
                                }
                            },
                            error: function(error) {
                                console.log(error);
                            }
                        });
                    });

                    // updateQty
                    $(document).on('change', '#updateQty', function() {
                        var change_value = $(this).val();
                        const id = $(this).data('id');
                        $.ajax({
                            url: "/update-quantity-to-cart",
                            method: "GET",
                            data: {
                                "quantity": change_value,
                                "id": id
                            },
                            success: function(response) {
                                // $('#coupon_discount').html('-$' + parseFloat(response
                                //     .coupon_discount).toFixed(2));
                                // $('#grand_total').html('$' + (response.final_price).toFixed(
                                //     2));
                                // $('#checkoutShipping').html(parseFloat(response
                                //     .shipping_charge).toFixed(2));
                                // if (response.shipping_charge == -8) {
                                //     $('#shippingChargeTitle').html('Shopping Discount');
                                // }
                                // $('#subTotalOnCheckout').html(parseFloat(response.sub_total)
                                //     .toFixed(2));
                                get_cart_data();
                                get_cart_data2();
                                toastr.success(response.message);
                            }
                        })
                    });

                    // 
                    var incrementPlus;
                    var incrementMinus;
                    var buttonPlus = $(".cart-qty-plus-checkout");
                    var buttonMinus = $(".cart-qty-minus-checkout");
                    var incrementPlus = buttonPlus.click(function() {
                        var $n = $(this).parent(".container2").find(".qty");
                        $n.val(Number($n.val()) + 1);
                        const quantity = Number($n.val());
                        const id = $(this).data('id');
                        $.ajax({
                            url: "/update-quantity-to-cart",
                            method: "GET",
                            data: {
                                "quantity": quantity,
                                "id": id
                            },
                            success: function(response) {
                                // $('#coupon_discount').html('-$' + parseFloat(response
                                //     .coupon_discount).toFixed(2));
                                // $('#grand_total').html('$' + (response.final_price).toFixed(
                                //     2));
                                // $('#checkoutShipping').html(parseFloat(response
                                //     .shipping_charge).toFixed(2));
                                // if (response.shipping_charge == -8) {
                                //     $('#shippingChargeTitle').html('Shopping Discount');
                                // }
                                // $('#subTotalOnCheckout').html(parseFloat(response.sub_total)
                                //     .toFixed(2));
                                get_cart_data();
                                get_cart_data2();
                                toastr.success(response.message);
                            }
                        })
                    });
                    var incrementMinus = buttonMinus.click(function() {
                        var $n = $(this).parent(".container2").find(".qty");
                        var amount = Number($n.val());
                        if (amount > 1) {
                            $n.val(amount - 1);
                        }
                        const quantity = Number(amount - 1);
                        // if (quantity > 0) {
                        const id = $(this).data('id');
                        $.ajax({
                            url: "/update-quantity-to-cart",
                            method: "GET",
                            data: {
                                "quantity": quantity,
                                "id": id
                            },
                            success: function(response) {
                                // $('#coupon_discount').html('-$' + parseFloat(response
                                //     .coupon_discount).toFixed(2));
                                // $('#grand_total').html('$' + (response.final_price)
                                //     .toFixed(2));
                                // $('#checkoutShipping').html(parseFloat(response
                                //     .shipping_charge).toFixed(2));
                                // if (response.shipping_charge == -8) {
                                //     $('#shippingChargeTitle').html('Shopping Discount');
                                // }
                                // $('#subTotalOnCheckout').html(parseFloat(response
                                //     .sub_total).toFixed(2));
                                get_cart_data();
                                get_cart_data2();
                                toastr.success(response.message);
                            }
                        })
                        // }
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }
    </script>@endsection @endsection
