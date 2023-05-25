@extends('frontend.layouts.master')
@section('title', 'LFK | Products')
@section('body')

    <section class="bg-gray page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ol class="breadcrumb">
                        <li><a href="/">{{ __('lang.home') }}</a></li>
                        <li class="active">{{ __('lang.products') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="products" style="overflow: hidden;">
        <div class="row">
            <div class="title text-center">
                <h2>{{ __('lang.products') }}</h2>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="widget">
                        <h4 class="widget-title">{{ GoogleTranslate::trans('Sort By', app()->getLocale()) }}</h4>
                        <select class="form-control" name="category_id" id="getCategoryWiseProducts">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if (request()->id == $category->id) selected @endif>
                                    @if (app()->getLocale() == 'en')
                                        {{ $category->name }}
                                    @else
                                        {{ $category->chinese_name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @php
                            $max_price = DB::table('products')->max('min_sale_price');
                        @endphp
                        <div class="wrapper-f">
                            <fieldset class="filter-price">
                                <h4 class="widget-title" style="margin-top: 30px;">
                                    {{ GoogleTranslate::trans('Price', app()->getLocale()) }}</h4>
                                <div class="price-field">
                                    <input type="range" min="10" max="5000" value="10" id="lower">
                                    <input type="range" min="10" max="{{ $max_price }}"
                                        value="{{ $max_price }}" id="upper">
                                </div>
                                <div class="price-wrap">

                                    <div class="price-container">
                                        <div class="price-wrap-1">

                                            <label for="one">$</label>
                                            <input id="one">
                                        </div>
                                        <div class="price-wrap_line">-</div>
                                        <div class="price-wrap-2">
                                            <label for="two">$</label>
                                            <input id="two">

                                        </div>
                                    </div>
                                    <!-- <span class="price-title">FILTER</span> -->
                                    <a href="javascript:void(0)" id="getDataOnRangeFilter"
                                        class="btn btn-small">{{ GoogleTranslate::trans('FILTER', app()->getLocale()) }}</a>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="widget product-category">
                        <h4 class="widget-title">{{ GoogleTranslate::trans('Categories', app()->getLocale()) }}</h4>
                        <div class="panel-group commonAccordion" id="accordion" role="tablist" aria-multiselectable="true">

                            @php $count = 0; @endphp

                            @foreach ($categories as $category)
                                @php ++$count; @endphp
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne{{ $category->id }}">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                href="#collapseOne{{ $category->id }}" aria-expanded="true"
                                                aria-controls="collapseOne{{ $category->id }}"
                                                class="{{ $count <= 1 ? '' : 'collapsed' }}">

                                                @if (app()->getLocale() == 'en')
                                                    {{ $category->name }}
                                                @else
                                                    {{ $category->chinese_name }}
                                                @endif
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne{{ $category->id }}"
                                        class="panel-collapse collapse {{ $count <= 1 ? 'in' : '' }}" role="tabpanel"
                                        aria-labelledby="headingOne{{ $category->id }}">
                                        <div class="panel-body">
                                            <ul>
                                                @foreach ($products as $product)
                                                    @if ($product->product_category == $category->id)
                                                        <li><a href="/product/{{ $product->product_id }}">
                                                                @if (app()->getLocale() == 'en')
                                                                    {{ $product->product_name }}
                                                                @else
                                                                    {{ $product->product_name_c }}
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
                <div class="col-md-9">
                    <div class="row">
                        <!--  -->

                        <span id="allPaginateProductsCards">
                            <!-- ALL PRODUCTS -->
                        </span>
                        <!--  -->
                    </div>

                    <div class="text-center">
                        <ul class="pagination post-pagination" id="post_pagination">
                            <!-- CARDS PAGINATION -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script>
        var lowerSlider = document.querySelector('#lower');
        var upperSlider = document.querySelector('#upper');

        document.querySelector('#two').value = upperSlider.value;
        document.querySelector('#one').value = lowerSlider.value;

        $(document).on('change', '#one', function() {
            $('#lower').val($(this).val());
        });

        $(document).on('change', '#two', function() {
            $('#upper').val($(this).val());
        });

        var lowerVal = parseInt(lowerSlider.value);
        var upperVal = parseInt(upperSlider.value);

        upperSlider.oninput = function() {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);

            if (upperVal < lowerVal + 4) {
                lowerSlider.value = upperVal - 4;
                if (lowerVal == lowerSlider.min) {
                    upperSlider.value = 4;
                }
            }
            document.querySelector('#two').value = this.value
        };

        lowerSlider.oninput = function() {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);
            if (lowerVal > upperVal - 4) {
                upperSlider.value = lowerVal + 4;
                if (upperVal == upperSlider.max) {
                    lowerSlider.value = parseInt(upperSlider.max) - 4;
                }
            }
            document.querySelector('#one').value = this.value
        };
    </script>
@section('javascript')

    <script>
        // get data using category dropdown filter
        $(document).on('change', '#getCategoryWiseProducts', function() {
            let id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/category-wise-products",
                data: {
                    "id": id,
                },
                beforeSend: function() {
                    $('#allPaginateProductsCards').html(
                        '<i class="fa fa-spinner fa-spin"></i> Loading...');
                },
                success: function(response) {
                    $('#allPaginateProductsCards').html('');
                    if (response.data.length <= 0) {
                        $('#allPaginateProductsCards').html(
                            '<span style="color:red;">No Records Found</span>');
                        $('#post_pagination').html('');
                    } else {
                        jQuery.each(response.data, function(key, value) {
                            let discount_percentage = value['discount_percentage'];
                            let discount_price = (Math.round(value['discount_price'] * 100) / 100).toFixed(2);
                            let min_sale_price = (Math.round(value['min_sale_price'] * 100) / 100).toFixed(2);
                            $('#allPaginateProductsCards').append(`
                                <div class="col-md-4 col-sm-4">
                                    <div class="product-item card">
                                        <div class="product-thumb">
                                            <div class="first">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    
                                                </div>
                                            </div>
                                            <a href="/product/${value['product_id']}">
                                                <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" />
                                            </a>
                                            
                                        </div>
                                        <div class="product-content">
                                            <div class="product-title" style="height: 60px;">
                                                <h4><a href="/product/${value['product_id']}">${value['product_name']}</a></h4>
                                                <span style="color:red">${value['stock_check'] == 1 ? `(${out_of_stock})` : ''}</span>
                                            </div>
                                            ${value['discount_price'] == null ? `<p class="price">$${min_sale_price}</p>` : `<p class="price"><del style="color:red">$${min_sale_price}</del> $${discount_price}</p>`}</p>
                                            ${value['discount_price'] != null ? `<p style="color:red;background-color:transparent; ">${format(value['discount_start_date'])} to ${format(value['discount_end_date'])}</p>` : '<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>'}
                                        </div>
                                        ${value['total_quantity'] > 0 && false ?
                                `<div class="text-center">
                                    <button class="add-cart addToCartProduct" data-id="${value['product_id']}">
                                        ${add_to_cart}
                                    </button> 
                                </div>`
                                :
                               ''
                                }
                                    </div>
                                </div>
                            `);
                        });

                        $('#post_pagination').html('');
                        jQuery.each(response.links, function(key, value) {
                            $('#post_pagination').append(
                                '<li id="allPaginateProductsPagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' +value['url'] + '" class="page-link" >' + value["label"] +
                                '</a></li>'
                            );
                        });

                        get_paginate_data(response, id, null, null);

                    }
                }
            });
        });


        // get data using range filter
        $(document).on('click', '#getDataOnRangeFilter', function() {

            let minValue = $('#lower').val();
            let maxValue = $('#upper').val();

            $.ajax({
                type: "GET",
                url: "/products-by-range",
                data: {
                    "minValue": minValue,
                    "maxValue": maxValue,
                },
                success: function(response) {
                    $('#allPaginateProductsCards').html('');
                    if (response.data.length <= 0) {
                        $('#allPaginateProductsCards').html(
                            '<span style="color:red;">No Records Found</span>');
                        $('#post_pagination').html('');
                    } else {
                        jQuery.each(response.data, function(key, value) {
                            let discount_percentage = value['discount_percentage'];
                            let discount_price = (Math.round(value['discount_price'] * 100) / 100).toFixed(2);
                            let min_sale_price = (Math.round(value['min_sale_price'] * 100) / 100).toFixed(2);
                            $('#allPaginateProductsCards').append(`
                                <div class="col-md-4 col-sm-4">
                                    <div class="product-item card">
                                        <div class="product-thumb">
                                            <div class="first">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    
                                                </div>
                                            </div>
                                            <a href="/product/${value['product_id']}">
                                                <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" />
                                            </a>
                                            
                                        </div>
                                        <div class="product-content">
                                            <div class="product-title" style="height: 60px;">
                                                <h4><a href="/product/${value['product_id']}">${value['product_name']}</a></h4>
                                                <span style="color:red">${value['stock_check'] == 1 ? `(${out_of_stock})` : ''}</span>
                                            </div>
                                            ${value['discount_price'] == null ? `<p class="price">$${min_sale_price}</p>` : `<p class="price"><del style="color:red">$${min_sale_price}</del> $${discount_price}</p>`}</p>
                                            ${value['discount_price'] != null ? `<p style="color:red;background-color:transparent; ">${format(value['discount_start_date'])} to ${format(value['discount_end_date'])}</p>` : '<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>'}
                                        </div>
                                        ${value['total_quantity'] > 0 && false?
                                `<div class="text-center">
                                    <button class="add-cart addToCartProduct" data-id="${value['product_id']}">
                                            ${add_to_cart}
                                    </button> 
                                </div>`
                                :
                                '' }
                                    </div>
                                </div>
                            `);
                        });

                        $('#post_pagination').html('');
                        jQuery.each(response.links, function(key, value) {
                            $('#post_pagination').append(
                                '<li id="allPaginateProductsPagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' +value['url'] + '" class="page-link" >' + value["label"] +
                                '</a></li>'
                            );
                        });
                        get_paginate_data(response, null, minValue, maxValue);
                    }
                }
            });
        });
    </script>



    @if (!empty(request()->id))
        <script>
            $(document).ready(function() {
                $('#getCategoryWiseProducts').trigger('change');
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                get_all_products()
            });

            function get_all_products() {
                $.ajax({
                    type: "GET",
                    url: "/products/paginate-data",
                    beforeSend: function() {
                        $('#allPaginateProductsCards').html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    },
                    success: function(response) {
                        $('#allPaginateProductsCards').html('');
                        if (response.data.length <= 0) {
                            $('#allPaginateProductsCards').html(
                                '<span style="color:red;">No Records Found</span>');
                            $('#post_pagination').html('');
                        } else {
                            jQuery.each(response.data, function(key, value) {
                                let discount_percentage = value['discount_percentage'];
                                let discount_price = (Math.round(value['discount_price'] * 100) / 100).toFixed(2);
                                let min_sale_price = (Math.round(value['min_sale_price'] * 100) / 100).toFixed(2);
                                $('#allPaginateProductsCards').append(`
                                <div class="col-md-4 col-sm-4">
                                    <div class="product-item card">
                                        <div class="product-thumb">
                                            <div class="first">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    
                                                </div>
                                            </div>
                                            <a href="/product/${value['product_id']}">
                                                <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" />
                                            </a>
                                           
                                        </div>
                                        <div class="product-content">
                                            <div class="product-title" style="height: 60px;">
                                                <h4><a href="/product/${value['product_id']}">${value['product_name']}</a></h4>
                                                <span style="color:red">${value['stock_check'] == 1 ? `(${out_of_stock})` : ''}</span>
                                            </div>
                                            ${value['discount_price'] == null ? `<p class="price">$${min_sale_price}</p>` : `<p class="price"><del style="color:red">$${min_sale_price}</del> $${discount_price}</p>`}</p>
                                            ${value['discount_price'] != null ? `<p style="color:red;background-color:transparent;">${format(value['discount_start_date'])} to ${format(value['discount_end_date'])}</p>` : '<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>'}
                                        </div>
                                        ${value['total_quantity'] > 0  && false?
                                `<div class="text-center"><button class="add-cart addToCartProduct" data-id="${value['product_id']}">
                                        ${add_to_cart}
                                    </button> </div>`
                                :
                               '' }
                                    </div>
                                </div>
                            `);
                            });

                            $('#post_pagination').html('');
                            jQuery.each(response.links, function(key, value) {
                                $('#post_pagination').append(
                                    '<li id="allPaginateProductsPagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
                                );
                            });


                            get_paginate_data(response, null, null, null);


                        }
                    }
                });
            }


            function get_paginate_data(response, id, minValue, maxValue) {
                // pagination links css and access page
                $(function() {
                    $(document).on("click", "#allPaginateProductsPagination a", function(e) {
                        e.preventDefault();
                        //get url and make final url for ajax
                        var url = $(this).attr("href");
                        var append = url.indexOf("?") == -1 ? "?" : "&";
                        var finalURL = url + append + "id=" + id + "&minValue=" + minValue + "&maxValue=" +
                            maxValue;
                        $.get(finalURL, function(response) {

                            $('#allPaginateProductsCards').html('');
                            jQuery.each(response.data, function(key, value) {
                                let discount_percentage = value['discount_percentage'];
                                let discount_price = (Math.round(value['discount_price'] * 100) / 100).toFixed(2);
                                let min_sale_price = (Math.round(value['min_sale_price'] * 100) / 100).toFixed(2);
                                $('#allPaginateProductsCards').append(`
                        <div class="col-md-4 col-sm-4">
                            <div class="product-item card">
                                <div class="product-thumb">
                                    <div class="first">
                                        <div class="d-flex justify-content-between align-items-center">
                                            
                                        </div>
                                    </div>
                                    <a href="/product/${value['product_id']}">
                                        <img class="img-responsive thumbnail-image" src="${value['img_path']}" alt="${value['product_name']}" />
                                    </a>
                                    
                                </div>
                                <div class="product-content">
                                    <div class="product-title" style="height: 60px;">
                                        <h4><a href="/product/${value['product_id']}">${value['product_name']}</a></h4>
                                        <span style="color:red">${value['stock_check'] == 1 ? `(${out_of_stock})` : ''}</span>
                                    </div>
                                    ${value['discount_price'] == null ? `<p class="price">$${min_sale_price}</p>` : `<p class="price"><del style="color:red">$${min_sale_price}</del> $${discount_price}</p>`}</p>
                                    ${value['discount_price'] != null ? `<p style="color:red;background-color:transparent; ">${format(value['discount_start_date'])} to ${format(value['discount_end_date'])}</p>` : '<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</p>'}
                                </div>
                                ${value['total_quantity'] > 0 && false ?
                                `<div class="text-center">
                                    <button class="add-cart addToCartProduct" data-id="${value['product_id']}">
                                        ${add_to_cart}
                                    </button> </div>`
                                :
                                '' }
                            </div>
                        </div>
                      `);
                            });
                            $('#post_pagination').html('');
                            jQuery.each(response.links, function(key, value) {
                                $('#post_pagination').append(
                                    '<li id="allPaginateProductsPagination" class="page-item ' +((value.active === true) ? 'active' : '') +'" ><a href="' + value['url'] +'" class="page-link" >' + value["label"] + '</a></li>'
                                );
                            });
                        });
                        return false;
                    });
                });
                // end here
            }
        </script>
    @endif
@endsection
@endsection
