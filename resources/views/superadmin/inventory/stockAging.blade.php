    <!-- Stock Aging Tab -->
    <div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Stock Ageing
            </h4>

                <div class="alert alert-success alert-dismissible fade show" id="delStockAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delStockAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        </div>

            <!-- table start -->
            <div class="mt-3">
                <table class="text-center table table-responsive table-bordered" id="stock_aging_main_table">
                    <thead>
                        <tr>
                            <th class="text-center">S/N</th>
                            <th class="text-center">Warehouse Name</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Product Variant</th>
                            <th class="text-center">Product Category</th>
                            <th class="text-center">Batch Code</th>
                            <th class="text-center">On hand Quantity</th>
                            <th class="text-center">Expiry Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
    </div>

    <!-- <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script> -->

    @include('superadmin.inventory.stock-aging-modal.editStock')


<script>

    let batchEditStockArr = [];

    $(document).ready(function() {
        stock_aging_main_table = $('#stock_aging_main_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:10,
            buttons: [],
            ajax: {
                url: "{{ route('SA-StockDetails') }}",
                type: 'GET',
            },
        });
        $(document).find('#stock_aging_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    });

    // get a single stock details
    $(document).on("click", "a[name = 'editStock']", function (e){
        let id = $(this).data("id");
        getStockedit(id);
        function getStockedit(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetStockDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#stockId').val(value["id"]);
                        $('#stockWarehouseListEdit').val(value["warehouse_name"]);
                        $('#racksListEditStock').val(value["rack"]);
                        $('#stockProductListEdit').val(value["product_name"]);
                        $('#listStockVarientsEdit').val(value["product_varient"]);
                        $('#product_category_editStock').val(value["product_category"]);
                        $('#quantityEdit').val(value["quantity"]);
                        $('#skuCodeAddStockEdit').val(value["batch_code"]);
                        $('#expiryDateEdit').val(value["expiry_date"]);
                    });
                    jQuery(".alert-danger").hide();
                    jQuery("#editStockAlert").hide();
                }
            });
        }
    });

    // delete a single stock details using id
    $(document).on("click", "a[name = 'removeConfirmStockAging']", function (e){
        let id = $(this).data("id");
        delStock(id);
        function delStock(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveStockDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    stock_aging_main_table.ajax.reload();

                    $("#removeModalStockAging .close").click();
                }
            });
        }
    });

    // filter
    function fetchStockAgingFilter(){
        $product_name = $('#stockAgingFilter').val();
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-FilterStockDetails') }}",
            data : {
                "product_name" : $product_name,
            },
            success : function (response){
                let i = 0;
                jQuery('.stockAgingBody').html('');
                $('.stock-aging-main-table').html('Total No. of Stock Ageing : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.stockAgingBody').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["warehouse_name"] +'</td>\
                        <td class="border border-secondary">'+ value["product_name"] +'</td>\
                        <td class="border border-secondary">'+ value["product_varient"] +'</td>\
                        <td class="border border-secondary">'+ value["product_category"] +'</td>\
                        <td class="border border-secondary">'+ value["batch_code"] +'</td>\
                        <td class="border border-secondary">'+ value["quantity"] +'</td>\
                        <td class="border border-secondary">'+ ((value["expiry_date"]!=null)?value["expiry_date"]:"--") +'</td>\
                        <td class="border border-secondary"><a name="editStock" data-toggle="modal" data-id="'+value["id"]+'" data-target=".editStock"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td  class="border border-secondary"><a data-toggle="modal" data-target="#removeModalStockAging" name="delStock" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.stock-aging-pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.stock-aging-pagination-refs').append(
                                    '<li id="search_stock_aging_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                });   
            }
        });

        // pagination links css and access page
        $(function() {
        $(document).on("click", "#search_stock_aging_pagination a", function() {
            //get url and make final url for ajax 
            var url = $(this).attr("href");
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append;

            $.get(finalURL, function(response) {
                let i = 0;
                jQuery('.stockAgingBody').html('');
                $('.stock-aging-main-table').html('Total No. of Stock Ageing : '+response.total);
                    jQuery.each(response.data, function (key, value){
                        $('.stockAgingBody').append('<tr>\
                            <td class="border border-secondary">'+ ++i +'</td>\
                            <td class="border border-secondary">'+ value["warehouse_name"] +'</td>\
                            <td class="border border-secondary">'+ value["product_name"] +'</td>\
                            <td class="border border-secondary">'+ value["product_varient"] +'</td>\
                            <td class="border border-secondary">'+ value["product_category"] +'</td>\
                            <td class="border border-secondary">'+ value["quantity"] +'</td>\
                            <td class="border border-secondary">'+ value["batch_code"] +'</td>\
                            <td class="border border-secondary">'+ ((value["expiry_date"]!=null)?value["expiry_date"]:"--") +'</td>\
                            <td class="border border-secondary"><a name="editStock" data-toggle="modal" data-id="'+value["id"]+'" data-target=".editStock"> <i class="mdi mdi-pencil"></i> </a></td>\
                            <td  class="border border-secondary"><a data-toggle="modal" data-target="#removeModalStockAging" name="delStock" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                $('.stock-aging-pagination-refs').html('');
                jQuery.each(response.links, function (key, value){
                    $('.stock-aging-pagination-refs').append(
                                        '<li id="search_stock_aging_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                    );
                    });
                });
                return false;
            });
        });
        // end here

    }

    
                $(document).on("click", "a[name = 'delStock']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedStockAging').data('id', id);
                });

</script>      


        <div class="modal fade" id="removeModalStockAging" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmStockAging" class="btn btn-primary" id="confirmRemoveSelectedStockAging">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>