<style>
    .myclassupper 
{
    text-transform:capitalize;
}
</style>
<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Asset Tracking Tab
            </h4>
            <div class="d-flex">
                <a href="#" class="btn btn-sm ml-3 btn-primary" data-toggle="modal" data-target="#addAssetTracking"> Add Asset Tracking </a>
            </div>
        </div>

        
        <!-- alert section -->
            <!-- <div class="alert alert-success" id="delAssetTrackingAlert" style="display:none"></div> -->
                <div class="alert alert-success alert-dismissible fade show" id="delAssetTrackingAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delAssetTrackingAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        <!-- alert section end-->

        <!-- table start -->
        <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
            <table class="table text-center border">
                <caption class="asset-tracking-main-table text-primary fw-bold"></caption>
                <thead>
                    <tr>
                        <th class="p-2 border border-secondary">Sr. No.</th>
                        <th class="p-2 border border-secondary">Asset Name</th>
                        <th class="p-2 border border-secondary">Quantity</th>
                        <th class="p-2 border border-secondary">Location</th>
                        <th class="p-2 border border-secondary">Status</th>
                        <th class="p-2 border border-secondary" colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody class="tbody asset-tracking-details">
                </tbody>
            </table>
        </div>
        <ul class="asset-tracking-main-pagination-refs pagination pagination-referece-css justify-content-center"></ul>
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
@include('superadmin.fixed-asset.asset-tracking-modal.addAssetTracking')
<!-- Edit asset modal -->
@include('superadmin.fixed-asset.asset-tracking-modal.editAssetTracking')
<!-- View asset modal -->
@include('superadmin.fixed-asset.asset-tracking-modal.viewAssetTracking')

<script>

    $(document).ready(function(){
        getAssetTrackingDetials();
    });

    // All Payment Details
    function getAssetTrackingDetials(){
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-AssetTrackingDetails') }}",
            success : function (response){
                let i = 0;
                jQuery('.asset-tracking-details').html('');
                $('.asset-tracking-main-table').html('Total no. of products : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.asset-tracking-details').append('<tr>\
                        <td class="p-2 border border-secondary">'+ ++i +'</td>\
                        <td class="p-2 border border-secondary">'+ value["name"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["quantity"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["location"] +'</td>\
                        <td class="p-2 border border-secondary myclassupper">'+ value["status"] +'</td>\
                        <td class="p-2 border border-secondary"><a name="viewAssetTracking"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewAssetTracking"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="editAssetTracking" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editAssetTracking"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="delAssetTracking" data-toggle="modal" data-target="#removeModalAssetTracking" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });
                $('.asset-tracking-main-pagination-refs').html('');
                        jQuery.each(response.links, function (key, value){
                            $('.asset-tracking-main-pagination-refs').append(
                                '<li id="asset_tracking_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                            );
                        });
            }
        });
    }
    // End function here

    // pagination links css and access page
$(function() {
      $(document).on("click", "#asset_tracking_pagination a", function() {
        //get url and make final url for ajax
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append;


        $.get(finalURL, function(response) {
            let i = 0;
            jQuery('.asset-tracking-details').html('');
            $('.asset-tracking-main-table').html('Total no. of products : '+response.total);
            jQuery.each(response.data, function (key, value){
                $('.asset-tracking-details').append('<tr>\
                        <td class="p-2 border border-secondary">'+ ++i +'</td>\
                        <td class="p-2 border border-secondary">'+ value["name"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["quantity"] +'</td>\
                        <td class="p-2 border border-secondary">'+ value["location"] +'</td>\
                        <td class="p-2 border border-secondary myclassupper">'+ value["status"] +'</td>\
                        <td class="p-2 border border-secondary"><a name="viewAssetTracking"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewAssetTracking"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="editAssetTracking" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editAssetTracking"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="delAssetTracking" data-toggle="modal" data-target="#removeModalAssetTracking" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
            });
            $('.asset-tracking-main-pagination-refs').html('');
            jQuery.each(response.links, function (key, value){
                $('.asset-tracking-main-pagination-refs').append(
                        '<li id="asset_tracking_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                );
                });
            });
            return false;
        });
    });
    // end here      

        getAssetNames();

        function getAssetNames(){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-getAssetList')}}",
                success : function (response){
                    $("#assetName").html('');
                    $("#assetName").append("<option value=''>Select asset name</option>");
                    $("#assetNameEdit").append("<option value=''>Select asset name</option>");
                    jQuery.each(response, function(key, value){
                        $("#assetName").append(
                            '<option value="'+value["name"]+'">\
                            '+value["name"]+'\
                            </option>'
                        );
                        $("#assetNameEdit").append(
                            '<option value="'+value["name"]+'">\
                            '+value["name"]+'\
                            </option>'
                        );
                    });
                }
            });
        }

    // get a single asset tracking details
    $(document).on("click", "a[name = 'editAssetTracking']", function (e){
        let id = $(this).data("id");
        editAssetDetails(id);
        function editAssetDetails(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAssetTrackingDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#assetTrackingId').val(value["id"]);
                        $('#assetNameEdit').val(value["name"]);
                        $('#quantityAssetTrackingEdit').val(value["quantity"]);
                        $('#locationEdit').val(value["location"]);
                        $('#statusEdit').val(value["status"]);
                    });
                }
            });
        }
    });

    // view a single asset tracking details
    $(document).on("click", "a[name = 'viewAssetTracking']", function (e){
        let id = $(this).data("id");
        viewAssetDetails(id);
        function viewAssetDetails(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchAssetTrackingDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#viewAssetTrackingId').val(value["id"]);
                        $('#assetNameView').val(value["name"]);
                        $('#quantityAssetTrackingView').val(value["quantity"]);
                        $('#locationView').val(value["location"]);
                        $('#statusView').val(value["status"]);
                    });
                }
            });
        }
    });

   

    // delete a single asset tracking detials using id
    $(document).on("click", "a[name = 'removeConfirmAssetTracking']", function (e){
        let id = $(this).data("id");
        delAsset(id);
        function delAsset(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveAssetTrackingDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery("#delAssetTrackingAlert").show();
                    jQuery("#delAssetTrackingAlertMSG").html(response.success);
                    getAssetTrackingDetials();

                    $("#removeModalAssetTracking .close").click();

                }
            });
        }
    });

                $(document).on("click", "a[name = 'delAssetTracking']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedAssetTracking').data('id', id);
                });

</script>

        <div class="modal fade" id="removeModalAssetTracking" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmAssetTracking" class="btn btn-primary" id="confirmRemoveSelectedAssetTracking">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>