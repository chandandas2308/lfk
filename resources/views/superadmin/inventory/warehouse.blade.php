<div class="p-3">
<!-- categories Tab -->
        <div class="page-header flex-wrap">
            <!-- col 1 -->
            <h4 class="mb-0">
                Warehouse
            </h4>

            <!-- col 3 -->
            <div class="d-flex">
                <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target=".addWarehouse"> Add Warehouse </a>
            </div>

        </div>
        <!-- alert section -->
                <div class="alert alert-success alert-dismissible fade show" id="delWarehouseAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delWarehouseAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            <!-- alert section end-->

    <!-- table start -->
        <!-- <div class="table-responsive"> -->
            <table class="text-center table table-responsive table-bordered" id="warehouse_main_table" style="display: inline-table;">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Warehouse Name</th>
                        <th class="text-center">Short Code</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        <!-- </div> -->
    <!-- table end here -->
    @include('superadmin.inventory.return_goods_warehouse')
    @include('superadmin.inventory.exchange_goods_warehouse')
</div>

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

<!-- Add Model -->
@include('superadmin.inventory.warehouse-modals.addWarehouse')
@include('superadmin.inventory.warehouse-modals.editWarehouse')
@include('superadmin.inventory.warehouse-modals.viewWarehouse')
<!-- End  model -->

<script>

    $(document).ready(function() {
        warehouse_main_table = $('#warehouse_main_table').DataTable({
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
                url: "{{ route('SA-GetWarehouseDetails') }}",
                type: 'GET',
            }
        });
        $(document).find('#warehouse_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });     

    // get a single warehouse details
    $(document).on("click", "a[name = 'editWarehouse']", function (e){
        let id = $(this).data("id");
        rackArr = [];
        varietnsArr = [];
        getWarehouseDetailsEdit(id);
        function getWarehouseDetailsEdit(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-singleWarehouseDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#warehouseId').val(value["id"]);
                        $('#nameWarehouseEdit').val(value["name"]);
                        $('#shortCodeEdit').val(value["short_code"]);
                        $('#addressEdit').val(value["address"]);

                            const racksList = value['racks'];
                            rackArr = racksList.split(',');

                            $('#rack-list-edit').html('');

                            $.each(rackArr, function(k,v){
                                let tagItem = document.createElement("div");
                                tagItem.classList.add("item");

                                tagItem.innerHTML = `
                                    <span class="delete-btn" onclick="deleteEditTag(this, '${v}')">
                                    &times;
                                    </span>
                                    <span>${v}</span>
                                `;

                                document.querySelector("#rack-list-edit").appendChild(tagItem);
                
                            });
                    });
                }
            });
        }
    });
function deleteEditTag(ref, tag){
  let parent = ref.parentNode.parentNode;
  parent.removeChild(ref.parentNode);
  let index = rackArr.indexOf(tag);

  Array.prototype.removeAt = function (iIndex){
    var vItem = this[iIndex];
    if (vItem) {
        this.splice(iIndex, 1);
    }
    return vItem;
  };

  rackArr.removeAt(index);
}

    // view a single warehouse details using id
    $(document).on("click", "a[name = 'viewWarehouse']", function (e){
        let id = $(this).data("id");
        viewWarehouseDetials(id);
        function viewWarehouseDetials(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-singleWarehouseDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    // jQuery.each(response.data, function(key, value){
                        $('#nameView').val(response.data.name);
                        $('#shortCodeView').val(response.data.short_code);
                        $('#addressView').val(((response.data.address!=null)?response.data.address:"--"));



                        // const rack = value['racks'];
                        // const rackArr = rack.split(/\s*,\s*/);

                        // $('#warehouseBtnSection').html('');

                        // let warehouseName = value['name'];

                        // jQuery.each(rackArr, function(k, v){
                        //     $('#warehouseBtnSection').append("<a class='btn-sm btn-primary m-2' data-toggle='modal' data-target='#viewRackProductsInfo' name='rackDetials' href='#' data-value='"+warehouseName+"' data-id='"+v+"'>"+v+"</a>");
                        // });
                    // });
                    $('.stock-wise-products').html();
                    let i = 0;
                    jQuery.each(response.stock, function(key, value){
                        $('.stock-wise-products').append(`
                            <tr>
                                <td>${++i}</td>
                                <td>${value['product_id']}</td>
                                <td>${value['product_name']}</td>
                                <td>${value['product_category']}</td>
                                <td>${value['product_varient']}</td>
                                <td>${value['quantity']}</td>
                                <td>${value['batch_code']}</td>
                                <td>${value['rack']!=null?value['rack']:""}</td>
                            </tr>
                        `);
                    })
                }
            });
        }
    });

    // delete a single warehouse details using id
    $(document).on("click", "a[name = 'removeConfirmWarehouse']", function (e){
        let id = $(this).data("id");
        delWarehouse(id);
        function delWarehouse(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveWarehouseDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    warehouse_main_table.ajax.reload();
                    $("#removeModalWarehouse .close").click();
                }
            });
        }
    });

    // filter
    function warehouseFiler(){
        $warehouse = $('#warehousefilter').val();
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-WarehouseFilter') }}",
            data : {
                "warehouse" : $warehouse,
            },
            success : function (response){
                let i = 0;
                jQuery('.warehouse-details').html('');
                $('.warehouse-main-table').html('Total No. of Warehouse : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.warehouse-details').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["name"] +'</td>\
                        <td class="border border-secondary">'+ value["short_code"] +'</td>\
                        <td class="border border-secondary">'+ ((value["address"]!=null)?value["address"]:"--") +'</td>\
                        <td class="border border-secondary"><a name="viewWarehouse"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewWarehouse"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editWarehouse" data-toggle="modal" data-id="'+value["id"]+'" data-target=".editWarehouse"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a data-toggle="modal" data-target="#removeModalWarehouse" name="delWarehouse" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.warehouse-pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.warehouse-pagination-refs').append(
                                    '<li id="search_warehouse_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                });
            }
        });

            // pagination links css and access page
    $(function() {
      $(document).on("click", "#search_warehouse_pagination a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append;

        $.get(finalURL, function(response) {
            let i = 0;
            jQuery('.warehouse-details').html('');
            $('.warehouse-main-table').html('Total No. of Warehouse : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.warehouse-details').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["name"] +'</td>\
                        <td class="border border-secondary">'+ value["short_code"] +'</td>\
                        <td class="border border-secondary">'+ ((value["address"]!=null)?value["address"]:"--") +'</td>\
                        <td class="border border-secondary"><a name="viewWarehouse"  data-toggle="modal" data-id="'+value["id"]+'"  data-target=".viewWarehouse"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editWarehouse" data-toggle="modal" data-id="'+value["id"]+'" data-target=".editWarehouse"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a data-toggle="modal" data-target="#removeModalWarehouse" name="delWarehouse" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

            $('.warehouse-pagination-refs').html('');
            jQuery.each(response.links, function (key, value){
                    $('.warehouse-pagination-refs').append(
                        '<li id="search_warehouse_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here 
}


                $(document).on("click", "a[name = 'delWarehouse']", function (e){
                    let id = $(this).data("id");
                    console.log(id);
                    $('#confirmRemoveSelectedElementWarehouse').data('id', id);
                });
</script>

        <div class="modal fade" id="removeModalWarehouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmWarehouse" class="btn btn-primary" id="confirmRemoveSelectedElementWarehouse">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>