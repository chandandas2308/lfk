<!-- Product Tab -->
<div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
            All Images
            </h4>
            <div class="d-flex">
                <a href="#" onclick="listCategory()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addMImage"> Add Images </a>
                
                <div class="nav-item rounded dropdown border-0 m-0 mx-2">
                    <div class="dropdown-menu navbar-dropdown bg-white w-100" aria-labelledby="profileDropdown">
                    </div>
                </div>

                <!-- <div class="nav-item rounded dropdown border-0 m-0 mx-2">
                    <a class="nav-link dropdown-toggle bg-primary text-black rounded" id="profileDropdown" href="#" data-toggle="dropdown">Stock Reports</a>
                    <div class="dropdown-menu navbar-dropdown bg-white w-100" aria-labelledby="profileDropdown">
                        <a href="#" class="dropdown-item" data-toggle="modal" data-target=".bulkStockUploads"> Upload</a>
                        <a href="{{ route('SA-StocksExcelFile') }}" class="dropdown-item" id="" > Download(.xlsx) </a>
                    </div>
                </div> -->

            </div>
        </div>
        <div class="page-header flex-warp">
            <div class="d-flex mx-auto ">
                <label for="searchProduct" id="searchLabel" class="reset-btn p-2 text-black">Search </label>
                <input type="search" name="searchProduct" onchange="productNameFilter()" id="searchProduct" class="" placeholder="product name">
                <!-- Category -->
                <select name="" id="selectCategory" onchange="getProductsFilter()" class="form-control m-2 "></select>
                
                <a href="#" id="resetProductFilter" class="reset-btn p-2 text-black" >Reset</a>
            </div>
        </div>

            <!-- alert section -->
                <!-- <div class="alert alert-success" id="delProductAlert" style="display:none"></div> -->
                <div class="alert alert-success alert-dismissible fade show" id="delProductAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delProductAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            <!-- alert section end-->

    <!-- table start -->
        <div class="table-responsive-sm" style="overflow-x:scroll;">
            <table class="text-center table table-responsive table-bordered">
                <caption class="product-img-table  fw-bold"></caption>
                <thead>
                    <tr class="col" style="border: 2px ridge #ccc;">
                        <th style="border: 2px ridge #ccc;">S/N</th>
                        <th style="border: 2px ridge #ccc;">Product Name</th>
                        <th style="border: 2px ridge #ccc;">Image 1</th>
                        <th style="border: 2px ridge #ccc;">Image 2</th>
                        <th style="border: 2px ridge #ccc;">Image 3</th>
                        <th style="border: 2px ridge #ccc;">Image 4</th>
                        <th style="border: 2px ridge #ccc;" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody class="tbody product-images" style="border: 1px ridge #ccc;"></tbody>
            </table>
        </div>
        <ul class="pagination-img pagination-referece-css pagination justify-content-center"></ul>
    <!-- table end here -->
</div>

<!-- Add Multi Images Model -->
@include('superadmin.inventory.multi-image-model.addMultiImage')
<!-- end model here -->

<!-- Edit Multi Images Model -->
@include('superadmin.inventory.multi-image-model.editMultiImage')
<!-- end model here -->

<!-- jQuery CDN -->
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<!-- backend js file -->


<script>

    
        getProductsImg();
    
        getCategory00();

    $(document).ready(function(){
        $('#resetProductFilter').click(function(){
            $('#selectCategory').prop('selectedIndex',0);
            $('#searchProduct').val('');
            getProductsImg();
        })
    });

    var product_table_response = [];

    // All Product Details
    function getProductsImg(){
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-GetProductsImages') }}",
            success : function (response){
                            let i = 0;
                            $('.product-images').html('');
                            $('.product-img-table').html('Total No. of Products Images: '+response.total);
                            jQuery.each(response.data, function (key, value){
                                    $('.product-images').append('<tr>\
                                        <td class="border border-primary">'+ ++i +'</td>\
                                        <td class="border border-primary">'+ value["product"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image1'] != null)?value['Image1'].substring(value['Image1'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image2'] != null)?value['Image2'].substring(value['Image2'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image3'] != null)?value['Image3'].substring(value['Image3'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image4'] != null)?value['Image4'].substring(value['Image4'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"><a name="editImage" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editImages"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
                            });

                            $('.pagination-img').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.pagination-img').append(
                                    '<li id="img_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                            });
                        }
        });
    }
    // End function here
    
    // pagination links css and access page
    $(function() {
      $(document).on("click", "#img_pagination a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append;


        $.get(finalURL, function(response) {
            let i = response.from;
            $('.product-images').html('');
            $('.product-img-table').html('Total No. of Products Images : '+response.total);
            jQuery.each(response.data, function (key, value){
                $('.product-images').append('<tr>\
                                        <td class="border border-primary">'+ i++ +'</td>\
                                        <td class="border border-primary">'+ value["product"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image1'] != null)?value['Image1'].substring(value['Image1'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image2'] != null)?value['Image2'].substring(value['Image2'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image3'] != null)?value['Image3'].substring(value['Image3'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['Image4'] != null)?value['Image4'].substring(value['Image4'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"><a name="editImage" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editImages"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
            });
            $('.pagination-img').html('');
            jQuery.each(response.links, function (key, value){
                $('.pagination-img').append(
                    '<li id="img_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a  class="page-link" href="'+value['url']+'">'+value["label"]+'</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here

    
    $(document).ready(function(){
        listCategory100();
    });
      

    // get a single product
    $(document).on("click", "a[name = 'editImage']", function (e){
        let barcode = $(this).data("id");
        // listCategory200();
        // listCategory();
        getProduct(barcode);
        function getProduct(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetImageSection')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    console.log(response)
                    jQuery.each(response, function(key, value){
                        $('#editproduct_id').val(value["category"]);
                        $('#editproduct_name').val(value["product"]);
                        $('#edit_image1').attr("src",'/products/'+((value['Image1'] != null)?value['Image1'].substring(value['Image1'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'');
                        $('#edit_image2').attr("src",'/products/'+((value['Image2'] != null)?value['Image2'].substring(value['Image2'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'');
                        $('#edit_image3').attr("src",'/products/'+((value['Image3'] != null)?value['Image3'].substring(value['Image3'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'');
                        $('#edit_image4').attr("src",'/products/'+((value['Image4'] != null)?value['Image4'].substring(value['Image4'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'');
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
                    // jQuery("#delProductAlert").show();
                    // jQuery("#delProductAlertMSG").html(response.success);
                    getProducts();

                    $("#removeModalProduct .close").click();
                }
            });
        }
    });

    

     // All Category Details (filter)
     function getCategory00(){
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

    

    // All Filter Product Details
    function getProductsFilter00(){
        
        let category = jQuery('#selectCategory').val();
        // let varient = jQuery('#selectVarient').val();

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-ListProductsFilter') }}",
            data : {
                "category" : category,
            },
            success : function (response){
                let i = 0;
                $('.product-images').html('');
                $('.product-img-table').html('Total No. of Products : '+response.total);
                jQuery.each(response.data, function (key, value){
                    
                                    $('.product-images').append('<tr>\
                                        <td class="border border-primary">'+ ++i +'</td>\
                                        <td class="border border-primary">'+ value["id"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                        <td class="border border-primary">'+ value["product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                        <td class="border border-primary">'+ value["product_category"] +'</td>\
                                        <td class="border border-primary">'+ value["uom"] +'</td>\
                                        <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                        <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                        <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                        <td class="border border-primary"><a name="editImage" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editImages"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
                            });

                            $('.pagination-img').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.pagination-img').append(
                                    '<li id="search_img_pagination1" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                            });
            }
        });


        // Bottom
        $(function() {
            $(document).on("click", "#search_img_pagination1 a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append +"category="+jQuery('#selectCategory').val();

                $.get(finalURL, function(response) {
                    let i = response.from;
                    $('.product-images').html('');
                    $('.product-img-table').html('Total No. of Products : '+response.total);
                    jQuery.each(response.data, function (key, value){
                                            $('.product-images').append('<tr>\
                                                <td class="border border-primary">'+ i++ +'</td>\
                                                <td class="border border-primary">'+ value["id"] +'</td>\
                                                <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                                <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                                <td class="border border-primary">'+ value["product_name"] +'</td>\
                                                <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                                <td class="border border-primary">'+ value["product_category"] +'</td>\
                                                <td class="border border-primary">'+ value["uom"] +'</td>\
                                                <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                                <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                                <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                                <td class="border border-primary"><a name="editImage" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editImages"> <i class="mdi mdi-pencil"></i> </a></td>\
                                                <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                            </tr>');
                    });
                    $('.pagination-img').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.pagination-img').append(
                            '<li id="search_img_pagination1" class="page-item '+((value.active===true)? 'active': '')+'" ><a  class="page-link" href="'+value['url']+'">'+value["label"]+'</a></li>'
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
    function productNameFilter00(){
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
                            $('.product-images').html('');
                            $('.product-img-table').html('Total No. of Products : '+response.total);
                            jQuery.each(response.data, function (key, value){
                                    $('.product-images').append('<tr>\
                                        <td class="border border-primary">'+ ++i +'</td>\
                                        <td class="border border-primary">'+ value["id"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                        <td class="border border-primary">'+ value["product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                        <td class="border border-primary">'+ value["product_category"] +'</td>\
                                        <td class="border border-primary">'+ value["uom"] +'</td>\
                                        <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                        <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                        <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                        <td class="border border-primary"><a name="editImage" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editImages"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
                            });

                            $('.pagination-img').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.pagination-img').append(
                                    '<li id="search_img_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                            });

                });
            }
        });

            // pagination links css and access page
    $(function() {
      $(document).on("click", "#search_img_pagination a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append +"product_name="+jQuery('#searchProduct').val();


        $.get(finalURL, function(response) {
            let i = response.from;
            $('.product-images').html('');
            $('.product-img-table').html('Total No. of Products : '+response.total);
            jQuery.each(response.data, function (key, value){
                                    $('.product-images').append('<tr>\
                                        <td class="border border-primary">'+ i++ +'</td>\
                                        <td class="border border-primary">'+ value["id"] +'</td>\
                                        <td class="border border-secondary"> <img src= "/products/'+((value['img_path'] != null)?value['img_path'].substring(value['img_path'].lastIndexOf('/') + 1):'dummy-ykpte.jpg')+'" /></td>\
                                        <td class="border border-primary"> '+ value["barcode"] +'</td>\
                                        <td class="border border-primary">'+ value["product_name"] +'</td>\
                                        <td class="border border-primary">'+ value["product_varient"] +'</td>\
                                        <td class="border border-primary">'+ value["product_category"] +'</td>\
                                        <td class="border border-primary">'+ value["uom"] +'</td>\
                                        <td class="border border-primary">'+ value["min_sale_price"] +'</td>\
                                        <td class="border border-primary" style="display:none;">'+ value["tax"] +'</td>\
                                        <td class="border border-primary"><a name="viewProducts"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewProduct"> <i class="mdi mdi-eye"></i> </a></td>\
                                        <td class="border border-primary"><a name="editImage" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editImages"> <i class="mdi mdi-pencil"></i> </a></td>\
                                        <td  class="border border-primary"><a name="deleteProducts"data-toggle="modal" data-target="#removeModalProduct" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                                    </tr>');
            });
            $('.pagination-img').html('');
            jQuery.each(response.links, function (key, value){
                $('.pagination-img').append(
                    '<li id="search_img_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a  class="page-link" href="'+value['url']+'">'+value["label"]+'</a></li>'
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

