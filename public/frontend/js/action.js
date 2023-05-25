// (function($) {
    // $(document).unbind('click').on('click', '.addToCartProduct', function (e) {
    $(document).on('click', '.addToCartProduct', function (e) {
        productId = $(this).data("id");
        let all_Quantity = $('#product-quantity').val();
    
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });
    
        $.ajax({
            type: "post",
            url: `/add-to-cart`,
            data: {
                pid: productId,
                quantity: all_Quantity
            },
            dataType: 'json',
            beforeSend: function () {
                $('#loading_btn').css('display', '');
            },
            success: function (response) {
                if (response.error == "error") {
                    window.location.href = "/login-with-us/lfk";
                }
                // console.log(response.status == 'error');
                if (response.status == 'success') {
                    get_cart_data();
                    successMsg(response.message);
                    $('#loading_btn').css('display', 'none');
                }
                if (response.status == "error") {
                    window.location.href = "checkout";
                    get_cart_data();
                    // errorMsg(response.message)
                    $('#loading_btn').css('display', 'none');
                }
            },
            error: function (error) {
                console.log(error);
                single_error(error)
    
    
                $('#loading_btn').css('display', 'none');
            }
        });
    
    });
    // });
    
    
    $(document).ready(function () {
        get_cart_data();
        getUserDetails();
        // userAlert();
    });
    
    function get_cart_data() {
        $.ajax({
            url: "/create-cart",
            type: 'get',
            dataType: 'json',
            success: function (data) {
                let len = data.length;
                $('#CartCount').html(data.length);
                $('#all_carts_products').html('');
                $('#cartPageItem').html('');
                $('span#cart_count').text(len);
                // $('#orderSummaryDetails').html('');
                let toalPrice = 0;
                let totalProductCount = 0;
    
                if (window.location.pathname == '/checkout' && len < 1) {
                    window.location.href = "/";
                }
    
                for (let i = 0; i < len; i++) {
                    let price = (Math.round((data[i]['discount_price'] == null ? (data[i]['product_price'] * data[i]['quantity']) : (data[i]['discount_price'] * data[i]['quantity'])) * 100) / 100).toFixed(2)
                    $('#all_carts_products').append(`
                        <div class="media">
                            <a class="pull-left" href="/product/${data[i]['product_id']}">
                                <img class="media-object" src="${data[i]['image']}" alt="${data[i]['product_name']}" />
                            </a>
                            <div class="media-body">
                            <h4 class="media-heading"><a href="/product/${data[i]['product_id']}">${data[i]['product_name']}</a></h4>
                            <div class="cart-price">
                                <span>${data[i]['quantity']}</span>
                                    x
                                <span>${data[i]['discount_price'] == null ? data[i]['product_price']: `<del style="color:red">${data[i]['product_price']}</del> ${data[i]['discount_price']}`}</span>
                            </div>
                            <h5><strong>$${price}</strong>${data[i]['total_quantity'] == 0 ? '<span style="color:red">(Out of stock)</span>' : '' }</h5>
                            </div>
                                <div class="container2 bars">
                                    
                                    <button class="cart-qty-minus" data-id="${data[i]['id']}" type="button" value="-">-</button>
                                    <input type="text"  name="qty" value="${data[i]["quantity"]}" class="input-text qty" data-id="${data[i]['id']}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"/>
                                    <button class="cart-qty-plus" data-id="${data[i]['id']}" type="button" value="+">+</button>
                                    
                                </div>
                            
                                <div class="cart-summary" style="display:${data[i]['total_quantity'] <= 20 ? '' : 'none'}">
    
                                <span class="total-price">${data[i]['total_quantity']}<span id="item_left"></span> item left</span>
    
                            </div>
                            
                            <a href="javascript:void(0)" class="remove cart__remove" data-id="${data[i]["id"]}" ><i class="tf-ion-close"></i></a>
                        </div>
                        `);
    
                    $('#cartPageItem').append(`
                            <tr>
                              <td>
                                  <img width="80" src="${data[i]["image"]}" alt="${data[i]['product_name']}" />
                              </td>
                              <td><a href="/product/${data[i]["product_id"]}">${data[i]["product_name"]}</a></td>
                              <td>
                                <div class="container2">
                                    
                                    <button class="cart-qty-minus" data-id="${data[i]['id']}" type="button" value="-">-</button>
                                    <input type="text"  name="qty" value="${data[i]["quantity"]}" class="input-text qty" data-id="${data[i]['id']}" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"/>
                                    <button class="cart-qty-plus" data-id="${data[i]['id']}" type="button" value="+">+</button>
                                    
                                </div>
                              </td>
                              <td>${data[i]['discount_price'] == null ? data[i]['product_price']: `<del style="color:red">${data[i]['product_price']}</del> ${data[i]['discount_price']}`}</td>
                              <td>
                              ${price}<br>
                              ${data[i]['total_quantity'] == 0 ? '<span style="color:red">(Out of stock)</span>' : '' }
                              </td>
                              <td>
                                <a class="product-remove cart__remove" data-id="${data[i]["id"]}" href="javascript:void(0)">Remove</a>
                              </td>
                            </tr>
                        `);
                    
                    toalPrice += parseFloat(price);
                    // toalPrice += parseFloat(data[i]['product_price']) * parseFloat(data[i]['quantity']);
                    ++totalProductCount;
                }

    
                $('.cart__remove').click(function () {
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
                        success: function (data) {
                            if (data.status == 'success') {
                                get_cart_data();
                                // successMsg(data.message);
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                });
                
                $('.qty').change(function () {
                    // var $n = $(this)
                    //     .parent(".container2")
                    //     .find(".qty");
                    // $n.val(Number($n.val()));
                    var quantity = Number($(this).val());
                    var id = $(this).data('id');
                    // console.log(id);
                    // console.log(quantity);
                    $.ajax({
                        url: "/update-quantity-to-cart",
                        method: "GET",
                        data: {
                            "quantity": quantity,
                            "id": id
                        },
                        success: function (response) {
                            get_cart_data();
                            // toastr.success(response.message);
                            if(response.message !='')
                                successMsg(response.message);
                            if (response.error != '') {
                                errorMsg(response.error);
                            }

                        }
                    })
                })


                // 
                var incrementPlus;
                var incrementMinus;
    
                var buttonPlus = $(".cart-qty-plus");
                var buttonMinus = $(".cart-qty-minus");
    
                var incrementPlus = buttonPlus.click(function () {
                    var $n = $(this)
                        .parent(".container2")
                        .find(".qty");
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
                        success: function (response) {
                            get_cart_data();
                            // toastr.success(response.message);
                            if(response.message !='')
                                successMsg(response.message);
                            if (response.error != '') {
                                errorMsg(response.error);
                            }

                        }
                    })
    
                });
    
                var incrementMinus = buttonMinus.click(function () {
                    var $n = $(this)
                        .parent(".container2")
                        .find(".qty");
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
                        success: function (response) {
                            get_cart_data();
                            // toastr.success(response.message);

                            if(response.message !='')
                                successMsg(response.message);
                            if (response.error != '') {
                                errorMsg(response.error);
                            }



                        }
                    })
                    // }
                });
    
    
                $('#carts_sub_total').html(toalPrice);
                // $('#subTotalOnCheckout').html(toalPrice);
                $('#products_count').html(totalProductCount);
                $('#products_sub_total').html(toalPrice);
    
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
    
    
    
    function getUserDetails() {
        $.ajax({
            type: "GET",
            url: "/products/paginate-data",
            beforeSend: function () {
                $('.homeProducts').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                $('.newproducts').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                // $('#allPaginateProductsCards').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
            },
            success: function (response) {
                // console.log(response);
                addDataToUI(response, null, null, null);
    
            }
        });
}
    
function format(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(date.getTime())) {
        var day = date.getDate().toString();
        var month = (date.getMonth() + 1).toString();
        // Months use 0 index.

        // return (month[1] ? month : '0' + month[0]) + '/' +
        //    (day[1] ? day : '0' + day[0]) + '/' + 
        //    date.getFullYear();
        return (day[1] ? day : '0' + day[0]) + '-' + (month[1] ? month : '0' + month[0]) + '-' + date.getFullYear();
    }
}
    
    // // get data using category dropdown filter
    // $(document).on('change', '#getCategoryWiseProducts', function () {
    //     let id = $(this).val();
    //     $.ajax({
    //         type: "GET",
    //         url: "/category-wise-products",
    //         data: {
    //             "id": id,
    //         },
    //         beforeSend: function () {
    //             $('#allPaginateProductsCards').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
    //         },
    //         success: function (response) {
    //             // console.log(response);
    //             addDataToUI(response, id, null, null)
    //         }
    //     });
    // });
    
    // // get data using range filter
    // $(document).on('click', '#getDataOnRangeFilter', function () {
    
    //     let minValue = $('#lower').val();
    //     let maxValue = $('#upper').val();
    
    //     $.ajax({
    //         type: "GET",
    //         url: "/products-by-range",
    //         data: {
    //             "minValue": minValue,
    //             "maxValue": maxValue,
    //         },
    //         success: function (response) {
    //             addDataToUI(response, null, minValue, maxValue)
    //         }
    //     });
    // });
    
    addDataToUI = function (response, id, minValue, maxValue) {
        // $('#allPaginateProductsCards').html('');
        $('.homeProducts').html('');
        $('.newproducts').html('');
    
        if (response.data.length <= 0) {
            $('.homeProducts').html('<span style="color:red;">No Records Found</span>');
            $('.newproducts').html('<span style="color:red;">No Records Found</span>');
            // $('#allPaginateProductsCards').html('<span style="color:red;">No Records Found</span>');
            $('#post_pagination').html('');
    
    
    
        } else {
            jQuery.each(response.data, function (key, value) {

                // let discount_percentage = (Math.round(value['discount_percentage'] * 100) / 100).toFixed(2);
                let discount_percentage = value['discount_percentage'];
                let discount_price = (Math.round(value['discount_price'] * 100) / 100).toFixed(2);
                let min_sale_price = (Math.round(value['min_sale_price'] * 100) / 100).toFixed(2);
                // let discount_price =(parseFloat(value['discount_price']).toFixed(2));
                // console.log(discount_price);
                $('.homeProducts').append(`
                        <div class="col-md-4 col-sm-4 col-xl-3 col-xxl-3">
                            <div class="product-item card">
                                <div class="product-thumb">
                                    <div class="first">
                                        <div class="d-flex justify-content-between align-items-center">
                                        ${value['discount_price'] != null ? 
                                        `<span class="discount">${value['discount_price'] != null && value['discount_price'] > 0 ? discount_percentage : ''}% OFF</span>`
                                        : ''} 
                                        </div>
                                    </div>
                                    <a href="/product/${value['product_id']}">
                                        <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" height="158.95px" width="262.5px" />
                                    </a>
                                    
                                </div>
                                <div class="product-content">
                                    <div class="product-title" style="height: 60px;">
                                        <h4><a href="/product/${value['id']}">${value['product_name']}</a></h4>
                                        <span style="color:red">${value['stock_check'] == 1 ? `(${out_of_stock})` : ''}</span>
                                    </div>
                                    ${value['discount_price'] == null ? `<p class="price">$${min_sale_price}</p>` : `<p class="price"><del style="color:red">$${min_sale_price}</del> $${discount_price}</p>`}</p>
                                    ${value['discount_price'] != null ? `<p style="color:red;background-color:transparent; ">Promotion Period: ${format(value['discount_start_date'])} to ${format(value['discount_end_date'])}</p>` : '<p>&nbsp&nbsp&nbsp&nbsp</p>'}
                                </div>
                                ${value['total_quantity'] > 0 && false ?
                        `<div class="text-center"><button class="add-cart addToCartProduct" data-id="${value['product_id']}">
                                        ${add_to_cart}
                                    </button> </div>`
                        :
                        '' }
                            </div>
                        </div>
                    `);
               
                $('.newproducts').append(`
                        <div class="col-md-4 col-sm-4 col-xl-3 col-xxl-3">
                            <div class="product-item card" >
                            
                                <div class="product-thumb">
                                    <div class="first">
                                    <div class="d-flex justify-content-between align-items-center">
                                        ${value['discount_price'] != null ? 
                                        `<span class="discount">${value['discount_price'] != null ? discount_percentage : ''}% OFF</span>`
                                        : ''} 
                                    </div>
                                    </div>
                                    <a href="/product/${value['product_id']}">
                                        <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" />
                                    </a>
                                   
                                </div>
                            
                                <div class="product-content" style="height: 180px;">
                                    <div class="product-title" style="height:40px">
                                        <h4><a href="/product/${value['id']}">${value['product_name']}</a></h4>
                                        <span style="color:red">${value['stock_check'] == 1 ? `(${out_of_stock})` : ''}</span>
                                    </div>
                                    ${value['discount_price'] == null ? `<p class="price">$${min_sale_price}</p>` : `<p class="price"><del style="color:red">$${min_sale_price}</del> $${discount_price}</p>`}</p>
                                    ${value['discount_price'] != null ? `<p style="color:red;background-color:transparent; ">Promotion Period: ${format(value['discount_start_date'])} to ${format(value['discount_end_date'])}</p>` : '<p>&nbsp&nbsp&nbsp&nbsp</p>'}

                                    ${value['total_quantity'] > 0 && false ?
                                    `<div class="text-center"><button class="add-cart addToCartProduct" data-id="${value['product_id']}">
                                                    ${add_to_cart}
                                                </button> </div>`
                                    :
                                    '' }

                                </div>
                            </div>
                        </div>
                    `);
    
    
                // $('#allPaginateProductsCards').append(`
                //         <div class="col-md-4 col-sm-4">
                //             <div class="product-item card">
                //                 <div class="product-thumb">
                //                     <div class="first">
                //                         <div class="d-flex justify-content-between align-items-center">
                                            
                //                         </div>
                //                     </div>
                //                     <a href="/product/${value['product_id']}">
                //                         <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" />
                //                     </a>
                //                     <div class="preview-meta">
                //                     <ul>
                //                         <li>
                //                         <span data-toggle="modal" data-target="#product-modal">
                //                             <a href="/product/${value['product_id']}">
                //                                 ${buy_now}
                //                             </a>
                //                         </span>
                //                         </li>
                //                     </ul>
                //                     </div>
                //                 </div>
                //                 <div class="product-content">
                //                     <div class="product-title" style="height: 60px;">
                //                         <h4><a href="/product/${value['product_id']}">${value['product_name']}</a></h4>
                //                         <span style="color:red">${value['total_quantity'] == 0 ? `(${out_of_stock})` : ''}</span>
                //                     </div>
                //                     <p class="price">$${value['min_sale_price']}</p>
                //                 </div>
                //                 ${value['total_quantity'] > 0 ?
                //         `<div class="text-center"><button class="add-cart addToCartProduct" data-id="${value['product_id']}">
                //                         ${add_to_cart}
                //                     </button> </div>`
                //         :
                //         `<div class="text-center">
                //                         <button class="add-cart" disabled>
                //                         ${add_to_cart}
                //                     </button> </div>` }
                //             </div>
                //         </div>
                //     `);
            });
    
    
            // $('#post_pagination').html('');
            // jQuery.each(response.links, function (key, value) {
            //     $('#post_pagination').append(
            //         '<li id="allPaginateProductsPagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
            //     );
            // });
        }
    
        // // pagination links css and access page
        // $(function () {
        //     $(document).on("click", "#allPaginateProductsPagination a", function () {
        //         //get url and make final url for ajax
        //         var url = $(this).attr("href");
        //         var append = url.indexOf("?") == -1 ? "?" : "&";
        //         var finalURL = url + append + "id=" + id + "&minValue=" + minValue + "&maxValue=" + maxValue;
        //         $.get(finalURL, function (response) {
    
        //             $('#allPaginateProductsCards').html('');
        //             jQuery.each(response.data, function (key, value) {
        //                 $('#allPaginateProductsCards').append(`
        //                 <div class="col-md-4 col-sm-4">
        //                     <div class="product-item card">
        //                         <div class="product-thumb">
        //                             <div class="first">
        //                                 <div class="d-flex justify-content-between align-items-center">
                                            
        //                                 </div>
        //                             </div>
        //                             <a href="/product/${value['product_id']}">
        //                                 <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" />
        //                             </a>
        //                             <div class="preview-meta">
        //                             <ul>
        //                                 <li>
        //                                 <span data-toggle="modal" data-target="#product-modal">
        //                                     <a href="/product/${value['product_id']}">
        //                                         ${buy_now}
        //                                     </a>
        //                                 </span>
        //                                 </li>
        //                             </ul>
        //                             </div>
        //                         </div>
        //                         <div class="product-content">
        //                             <div class="product-title" style="height: 60px;">
        //                                 <h4><a href="/product/${value['product_id']}">${value['product_name']}</a></h4>
        //                                 <span style="color:red">${value['total_quantity'] == 0 ? `(${out_of_stock})` : ''}</span>
        //                             </div>
        //                             <p class="price">$${value['min_sale_price']}</p>
        //                         </div>
        //                         ${value['total_quantity'] > 0 ?
        //                         `<div class="text-center"><button class="add-cart addToCartProduct" data-id="${value['product_id']}">
        //                                 ${add_to_cart}
        //                             </button> </div>`
        //                         :
        //                         `<div class="text-center">
        //                                 <button class="add-cart" disabled>
        //                                 ${add_to_cart}
        //                             </button> </div>` }
        //                     </div>
        //                 </div>
        //               `);
        //             });
        //             $('#post_pagination').html('');
        //             jQuery.each(response.links, function (key, value) {
        //                 $('#post_pagination').append(
        //                     '<li id="allPaginateProductsPagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
        //                 );
        //             });
        //         });
        //         return false;
        //     });
        // });
        // // end here
    
    
        // $(document).on('click', '#wishlist', function(){
    
        updateWishlist = function (product_id, status) {
            if (status != true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                });
                $.ajax({
                    type: "POST",
                    url: "/wishlist/add-to-wishlist",
                    data: {
                        "product_id": product_id,
                    },
                    success: function (response) {
                        if (response.success != null) {
                            successMsg(response.success);
                            getUserDetails();
                        } else {
                            errorMsg(response.error);
                        }
                    },
                    error: function (error) {
                        $(this).addClass('fa-heart-o');
                        $(this).removeClass('fa-heart');
                        single_error(error);
                        $('#loading_btn').css('display', 'none');
                    }
                });
            } else {
                $.ajax({
                    type: "GET",
                    url: "/wishlist/remove-from-wishlist",
                    data: {
                        "product_id": product_id,
                    },
                    success: function (response) {
                        if (response.success != null) {
                            successMsg(response.success);
                            getUserDetails();
                        } else {
                            errorMsg(response.error);
                        }
                    },
                    error: function (error) {
                        $(this).removeClass('fa-heart-o');
                        $(this).addClass('fa-heart');
                        single_error(error);
                        $('#loading_btn').css('display', 'none');
                    }
                });
            }
    
        }
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
    