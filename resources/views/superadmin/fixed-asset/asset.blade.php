<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Asset Tab
            </h4>
            <div class="d-flex">
                <a href="#" class="btn btn-sm ml-3 btn-primary" data-toggle="modal" data-target="#addAsset"> Add Asset </a>
            </div>
        </div>

        <style>
        .required-field::before {
  content: "*";
  color: red;
  float: right;
}
    </style>
        <!-- alert section -->
        <!-- <div class="alert alert-success" id="delVendorAlert" style="display:none"></div> -->
                <div class="alert alert-success alert-dismissible fade show" id="delVendorAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delVendorAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        <!-- alert section end-->

        <!-- table start -->
        <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
            <table class="table text-center border">
                <caption class="asset-main-main-table text-primary fw-bold"></caption>
                <thead>
                    <tr>
                        <th class="p-2 border border-secondary">Sr. No.</th>
                        <th class="p-2 border border-secondary">Asset ID</th>
                        <th class="p-2 border border-secondary">Asset Name</th>
                        <th class="p-2 border border-secondary">Quantity</th>
                        <th class="p-2 border border-secondary">Price</th>
                        <th class="p-2 border border-secondary">Tax</th>
                        <th class="p-2 border border-secondary" colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody class="tbody asset-details">
                </tbody>
            </table>
        </div>
        <ul class="asset-main-pagination-refs pagination pagination-referece-css justify-content-center"></ul>
        <!-- table end here -->        

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

<!-- Model -->
<!-- Add asset modal -->
@include('superadmin.fixed-asset.asset-modal.addAsset')
<!-- Edit asset modal -->
@include('superadmin.fixed-asset.asset-modal.editAsset')
<!-- View asset modal -->
@include('superadmin.fixed-asset.asset-modal.viewAsset')

<script>

    $(document).ready(function(){
        getAssetDetials();
    });

    // All Payment Details
    function getAssetDetials(){
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-GetAsset') }}",
            success : function (response){
                let i = 0;
                jQuery('.asset-details').html('');
                $('.asset-main-main-table').html('Total no. of products : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.asset-details').append('<tr>\
                        <td class="p-2 border border-secondary">'+ ++i +'</td>\
                        <td class="p-2 border border-secondary">'+ value["id"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["name"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["quantity"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["price"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["gst"] +'</td>\
                        <td class="p-2 border border-secondary"><a name="viewAsset"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewAsset"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="editAsset" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editAsset"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="delAsset" data-toggle="modal" data-target="#removeModalAsset" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });
                        $('.asset-main-pagination-refs').html('');
                        jQuery.each(response.links, function (key, value){
                            $('.asset-main-pagination-refs').append(
                                '<li id="asset_main_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                            );
                        });
            }
        });
    }
    // End function here


// pagination links css and access page
$(function() {
      $(document).on("click", "#asset_main_pagination a", function() {
        //get url and make final url for ajax
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append;


        $.get(finalURL, function(response) {
            let i = 0;
            jQuery('.asset-details').html('');
            $('.asset-main-main-table').html('Total no. of products : '+response.total);
            jQuery.each(response.data, function (key, value){
                $('.asset-details').append('<tr>\
                        <td class="p-2 border border-secondary">'+ ++i +'</td>\
                        <td class="p-2 border border-secondary">'+ value["id"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["name"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["quantity"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["price"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["gst"] +'</td>\
                        <td class="p-2 border border-secondary"><a name="viewAsset"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewAsset"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="editAsset" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editAsset"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="delAsset" data-toggle="modal" data-target="#removeModalAsset" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
            });
            $('.asset-main-pagination-refs').html('');
            jQuery.each(response.links, function (key, value){
                $('.asset-main-pagination-refs').append(
                        '<li id="asset_main_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                );
                });
            });
            return false;
        });
    });
    // end here        

    // get a single vendor
    $(document).on("click", "a[name = 'editAsset']", function (e){
        let id = $(this).data("id");
        getAssetDetials(id);
        function getAssetDetials(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAsset')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#assetId').val(value["id"]);
                        $('#nameEdit').val(value["name"]);
                        $('#quantityEdit').val(value["quantity"]);
                        $('#priceEdit').val(value["price"]);
                        $('#gstEdit').val(value["gst"]);
                    });
                }
            });
        }
    });

    $(document).on("click", "a[name = 'viewAsset']", function (e){
        let id = $(this).data("id");
        viewAssetDetials(id);
        function viewAssetDetials(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAsset')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#assetIdView').val(value["id"]);
                        $('#nameView').val(value["name"]);
                        $('#quantityView').val(value["quantity"]);
                        $('#priceView').val(value["price"]);
                        $('#gstView').val(value["gst"]);
                    });
                }
            });
        }
    });


   

    // delete a single vendor using id
    $(document).on("click", "a[name = 'removeConfirmAsset']", function (e){
        let id = $(this).data("id");
        delAsset(id);
        function delAsset(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveAsset')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery("#delVendorAlert").show();
                    jQuery("#delVendorAlertMSG").html(response.success);
                    getAssetDetials();

                    $("#removeModalAsset .close").click();

                }
            });
        }
    });

                $(document).on("click", "a[name = 'delAsset']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedAsset').data('id', id);
                });    

</script>

        <div class="modal fade" id="removeModalAsset" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmAsset" class="btn btn-primary" id="confirmRemoveSelectedAsset">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>