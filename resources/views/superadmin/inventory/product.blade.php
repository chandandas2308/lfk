<!-- Product Tab -->
<div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Product
            </h4>
            <div class="d-flex">
                <a href="#" onclick="listCategory()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addProduct"> Add Product </a>
                <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target=".addStock"> Add Stock </a>
                
                <div class="nav-item rounded dropdown border-0 m-0 mx-2">
                    <a class="nav-link dropdown-toggle bg-addbtn rounded" id="profileDropdown" href="#" data-toggle="dropdown">Product  Bulk Upload</a>
                    <div class="dropdown-menu navbar-dropdown bg-white w-100" aria-labelledby="profileDropdown">
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target=".bulkUploads"> Upload</a>
                        <a href="{{ route('SA-ProductsExcelFile') }}" class="dropdown-item" id="" > Download(.xlsx) </a>
                    </div>
                </div>

            </div>
        </div>
        <!-- <div class="table-responsive"> -->
            <table class="text-center table table-responsive table-bordered" id="product_main_table">
                    <thead>
                        <tr>
                            <th style="text-align:center;">S/N</th>
                            <th style="text-align:center;">Product ID</th>
                            <th style="text-align:center;">Image</th>
                            <th style="text-align:center;">Barcode</th>
                            <th style="text-align:center;">Product Name(English)</th>
                            <th style="text-align:center;">Product Name(Chinese)</th>
                            <th style="text-align:center;">Product Variant</th>
                            <th style="text-align:center;">Product Category</th>
                            <th style="text-align:center;">Quantity</th>
                            <th style="text-align:center;">UOM</th>
                            <th style="text-align:center;">Sale Price</th>
                            <th style="text-align:center;">Action</th>
                        </tr>
                    </thead>
            </table>
        <!-- </div> -->
</div>

    <!-- <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script> -->

<!-- Add Product Model -->
    @include('superadmin.inventory.product-models.addProduct')
<!-- end model here -->

<!-- Edit Product Model -->
    @include('superadmin.inventory.product-models.editProduct')
<!-- end model here -->



<!-- View Product Model -->
    @include('superadmin.inventory.product-models.viewProduct')
<!-- end model here -->

<!-- Add Stock Model -->
    @include('superadmin.inventory.product-models.addStock')
<!-- end model here -->

<!-- Add bulk upload -->
    @include('superadmin.inventory.product-models.bluckUpload')
<!-- end bulk upload -->

<!-- upload stock -->
    @include('superadmin.inventory.stock-aging-modal.bluckStockUpload')
<!-- end stock upload here -->

<script>

    $(document).ready(function() {
        product_main_table = $('#product_main_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            "initComplete": function(settings, json) {
                $('#product_main_table').find('svg').attr('width', 100);
            },
            "drawCallback": function( settings ) {
                $('#product_main_table').find('svg').attr('width', 100);
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:10,
            buttons: [],
            ajax: {
                url: "{{ route('SA-GetProducts') }}",
                type: 'GET',
            },
        });
        $(document).find('#product_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    });
    
    $(document).ready(function(){
        listCategory1();
        listSelCategory();
    });
      // Add multi Product image 
      $(document).on("click", "a[name = 'multiImage']", function (e){
        let barcode = $(this).data("id");
        listCategory2();
        // listCategory();
        getProduct(barcode);
        function getProduct(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetProductSection')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#multiproduct_id').val(value["id"]);
                        $('#multiproduct_image').attr("src",'/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'');
                        $('#multiproduct_name').val(value["product_name"]);
                    });
                }
            });
        }
    });

    var updateImages = [];

    // get a single product
    $(document).on("click", "a[name = 'editProducts']", function (e){
        let barcode = $(this).data("id");
        listCategory2();
        // listCategory();
        getProduct(barcode);
        function getProduct(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetProductSection')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#product_id').val(value["id"]);
                        $('#product_image').attr("src",'/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'');
                        $('#product_name').val(value["product_name"]);
                        $('#editchinese_product_name').val(value["chinese_product_name"]);
                        $('#product_varient').val(value["product_varient"]);
                        $('#productCategory1').val(value["product_category"]);
                        $('#sku_code').val(value["sku_code"]);
                        $('#u_om').val(value["uom"]);
                        $('#bar_code').val(value["barcode"]);
                        $('#min_ScalePrice').val(value["min_sale_price"]);
                        $('#tax_').val(value["tax"]);
                        $('#vendoerIDPro').val(value["supplier_id"]);
                        $('#sup_code_id').val(value["supplier_code"]);
                        $('#barcodeEdit').val(value['barcode_id']);

                        
                        if(value['stock_check'] == 1){
                            $('#edit_stock_check').prop('checked', true);
                        }else{
                            $('#edit_stock_check').prop('checked', false);
                        }
                        
                        if(value['featured_product'] == 1){
                            $('#featured_products_update').prop('checked', true);
                        }else{
                            $('#featured_products_update').prop('checked', false);
                        }

                        updateImages.length = 0;

                        // $('#descriptionE').val(value['description']);
                        CKEDITOR.instances['descriptionE'].setData(value['description']);

                        $('.increment').html('');
                        $('#previousImages').html('');
                        jQuery.each(JSON.parse(value['images']), function(key, value){
                            updateImages.push(value);
                            $('#previousImages').append(`
                                <div class="imageDiv">
                                    <img id="image${key}" data-id="${key}" src="/products/images/${value.substring(value.lastIndexOf('/') + 1)}" height="100" width="100">
                                    <label id="imageLabel${key}" class="imageLabel" for="image${key}" onclick="removeImage(${key})">X</label>
                                </div>
                            `);
                        })

                    });
                }
            });
        }
    });

    // delete a single product using id
    $(document).on("click", "a[name = 'removeConfirmProduct']", function (e){
        
        let id = $(this).data("id");
        getProduct(id);
        function getProduct(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveProduct')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    product_main_table.ajax.reload();
                    $("#removeModalProduct .close").click();

                    setTimeout(() => {
                        $('#product_main_table').find('svg').attr('width', 100);
                    }, 3000);

                }
            });
        }
    });

    // view a single product using id
    $(document).on("click", "a[name = 'viewProducts']", function (e){
        let id = $(this).data("id");
        getProduct(id);
        function getProduct(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-ViewProduct')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#product_barcode_view').html(value['barcode']);
                        $('#product_id1').val(value["id"]);
                        $('#product_imageView').attr("src",'/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'');
                        $('#product_name1').val(value["product_name"]);
                        $('#chinese_product_name1').val(value["chinese_product_name"]);
                        $('#product_varient1').val(value["product_varient"]);
                        $('#product_category1').val(value["product_category"]);
                        $('#sku_code1').val(value["sku_code"]);
                        $('#bar_code1').val(value["barcode"]);
                        $('#u_om1').val(value["uom"]);
                        $('#min_ScalePrice1').val(value["min_sale_price"]);
                        $('#tax_1').val(value["tax"]);
                        $('#vendoerIDProView').val(value['supplier_id']);
                        $('#sup_code1').val(value["supplier_code"]);
                        $('#descriptionV').html(value['description']);
                        
                        if(value['featured_product'] == 1){
                            $('#featured_products_view').prop('checked', true);
                        }else{
                            $('#featured_products_view').prop('checked', false);
                        }

                        $('#previousImagesView').html('');
                        jQuery.each(JSON.parse(value['images']), function(key, value){
                            $('#previousImagesView').append(`
                                <img src="/products/images/${value.substring(value.lastIndexOf('/') + 1)}" height="100" width="100">
                            `);
                        })

                        setTimeout(() => {
                            $('#product_barcode_view').find('svg').attr('width', 100);
                        }, 1000);

                    });     
                }
            });
        }
    });

     // All Category Details (filter)
     function getCategory(){
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-ListCategories') }}",
            success : function (response){
                jQuery('#selectCategory').html('');
                jQuery('#selectCategory').append('<option  value="" class="bg-info text-white" style="font-size:smaller;">Select Category</option>');
                jQuery.each(response, function (key, value){
                    $('#selectCategory').append(
                        '<option value="'+value['name']+'">'+value['name']+'</option>'
                    );
                });
            }
        });
    }
    // End function here

    // download products excel file.
    $('#downloadProductExcelFile').on('click', function(){
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-ProductsExcelFile') }}",
            success : function (response){
            }
        });
    });
    // function end here

    // All Filter Product Details
    function getProductsFilter(){
        
        let category = jQuery('#selectCategory').val();

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-ListProductsFilter') }}",
            data : {
                "category" : category,
            },
            success : function (response){
                let i = 0;
                $('.product-table').html('');
                $('.product-main-table').html('Total No. of Products : '+response.total);
                jQuery.each(response.data, function (key, value){
                    
                                    $('.product-table').append('<tr>\
                                        <td class="border border-primary">'+ ++i +'</td>\
                                        <td class="border border-primary">'+ value["productId"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                        <td class="border border-primary">'+ value["product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["chinese_product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                        <td class="border border-primary">'+ value["product_category"] +'</td>\
                                        <td class="border border-primary">'+ ((value["total_quantity"] != null)?value["total_quantity"]:"0") +'</td>\
                                        <td class="border border-primary">'+ value["uom"] +'</td>\
                                        <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                        <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                        <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                        <td class="border border-primary"><a name="editProducts" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProduct"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
                            });

                            $('.pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.pagination-refs').append(
                                    '<li id="search_product_pagination1" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                            });
            }
        });


        // Bottom
        $(function() {
            $(document).on("click", "#search_product_pagination1 a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append +"category="+jQuery('#selectCategory').val();

                $.get(finalURL, function(response) {
                    let i = response.from;
                    $('.product-table').html('');
                    $('.product-main-table').html('Total No. of Products : '+response.total);
                    jQuery.each(response.data, function (key, value){
                                            $('.product-table').append('<tr>\
                                                <td class="border border-primary">'+ i++ +'</td>\
                                                <td class="border border-primary">'+ value["productId"] +'</td>\
                                                <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                                <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                                <td class="border border-primary">'+ value["product_name"] +'</td>\
                                                <td class="border border-primary">'+ value["chinese_product_name"] +'</td>\
                                                <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                                <td class="border border-primary">'+ value["product_category"] +'</td>\
                                                <td class="border border-primary">'+ ((value["total_quantity"] != null)?value["total_quantity"]:"0") +'</td>\
                                                <td class="border border-primary">'+ value["uom"] +'</td>\
                                                <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                                <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                                <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                                <td class="border border-primary"><a name="editProducts" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProduct"> <i class="mdi mdi-pencil"></i> </a></td>\
                                                <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                            </tr>');
                    });
                    $('.pagination-refs').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.pagination-refs').append(
                            '<li id="search_product_pagination1" class="page-item '+((value.active===true)? 'active': '')+'" ><a  class="page-link" href="'+value['url']+'">'+value["label"]+'</a></li>'
                            );
                        });
                    });
                    return false;
                });
            });
    // end here        

    }
    // End function here

    // search by name 
    function productNameFilter(){
        let product_name = jQuery('#searchProduct').val();

        $('#selectCategory').val('');

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-ListProNameFilter') }}",
            data : {
                "product_name" : product_name
            },
            success : function (response){
                let i = 0;
                jQuery('.tbody').html('');
                jQuery.each(response, function (key, value){

                            let i = 0;
                            $('.product-table').html('');
                            $('.product-main-table').html('Total No. of Products : '+response.total);
                            jQuery.each(response.data, function (key, value){
                                    $('.product-table').append('<tr>\
                                        <td class="border border-primary">'+ ++i +'</td>\
                                        <td class="border border-primary">'+ value["productId"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                        <td class="border border-primary">'+ value["product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["chinese_product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                        <td class="border border-primary">'+ value["product_category"] +'</td>\
                                        <td class="border border-primary">'+ ((value["total_quantity"] != null)?value["total_quantity"]:"0") +'</td>\
                                        <td class="border border-primary">'+ value["uom"] +'</td>\
                                        <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                        <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                        <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                        <td class="border border-primary"><a name="editProducts" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProduct"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
                            });

                            $('.pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.pagination-refs').append(
                                    '<li id="search_product_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                            });

                });
            }
        });

            // pagination links css and access page
    $(function() {
      $(document).on("click", "#search_product_pagination a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append +"product_name="+jQuery('#searchProduct').val();


        $.get(finalURL, function(response) {
            let i = response.from;
            $('.product-table').html('');
            $('.product-main-table').html('Total No. of Products : '+response.total);
            jQuery.each(response.data, function (key, value){
                                    $('.product-table').append('<tr>\
                                        <td class="border border-primary">'+ i++ +'</td>\
                                        <td class="border border-primary">'+ value["productId"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                        <td class="border border-primary">'+ value["product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["chinese_product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                        <td class="border border-primary">'+ value["product_category"] +'</td>\
                                        <td class="border border-primary">'+ ((value["total_quantity"] != null)?value["total_quantity"]:"0") +'</td>\
                                        <td class="border border-primary">'+ value["uom"] +'</td>\
                                        <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                        <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                        <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                        <td class="border border-primary"><a name="editProducts" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProduct"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
            });
            $('.pagination-refs').html('');
            jQuery.each(response.links, function (key, value){
                $('.pagination-refs').append(
                    '<li id="search_product_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a  class="page-link" href="'+value['url']+'">'+value["label"]+'</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here

    }

    
                $(document).on("click", "a[name = 'deleteProducts']", function (e){
                    let id = $(this).data("id");
                    console.log(id);
                    $('#confirmRemoveSelectedElementProduct').data('id', id);
                });

</script>



<div class="modal fade" id="removeModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Alert</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">DO YOU WANT TO DELETE?<span id="removeElementId"></span> </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                        <a name="removeConfirmProduct" class="btn btn-primary" id="confirmRemoveSelectedElementProduct">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>