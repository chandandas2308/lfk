<div class="p-3">
    
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">

        <style>
         .search{
                width: 240px;
            }
        </style>

        <!-- End Style -->
            <h4 class="mb-0">
                Vendors Tab
            </h4>
            
            <div class="d-flex">
                <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addVendors"> Add Vendor </a>
            </div>
        </div>

        
        <!-- alert section -->
                <div class="alert alert-success alert-dismissible fade show" id="delVendorAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delVendorAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        <!-- alert section end-->

        <!-- table start -->
        <table class="text-center table table-bordered" id="vendors_main_table" style="width:100%;">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Vendor Name</th>
                        <th class="text-center">Contact Person Name</th>
                        <th class="text-center">Home Number</th>
                        <th class="text-center">Mobile Number</th>
                        <th class="text-center">Email ID</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        <!-- table end here -->        

</div>

<!-- Model -->
@include('superadmin.purchase.vendors-modal.addVendors')
@include('superadmin.purchase.vendors-modal.editVendors')
@include('superadmin.purchase.vendors-modal.viewVendors')


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

    
    $(document).ready(function() {
        vendors_main_table = $('#vendors_main_table').DataTable({
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
                url: "{{ route('SA-GetVendors') }}",
                type: 'GET',
            }
        });
        $(document).find('#vendors_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });

    // $(document).ready(function(){
    //     getVendorsDetails();
    // });

    // $(document).ready(function(){
    //     $('#resetVendorFilterSection').click(function(){
    //         $('#VendorSectionFilter').val('');
    //         getVendorsDetails();
    //     });
    // });

    // // All Payment Details
    // function getVendorsDetails(){
    //     $.ajax({
    //         type : "GET" ,
    //         url : "{{ route('SA-GetVendors') }}",
    //         success : function (response){
    //             let i = 0;
    //             jQuery('.vendors-details').html('');
    //             $('.vendors-main-table').html('Total Vendors : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.vendors-details').append('<tr>\
    //                     <td class="border border-secondary">'+ ++i +'</td>\
    //                     <td class="border border-secondary">'+ value["vendor_name"] +'</td>\
    //                     <td class="border border-secondary">'+ value['contact_person_name'] +'</td>\
    //                     <td class="border border-secondary">'+ ((value["phone_no"] != null)?value["phone_no"]:"--") +'</td>\
    //                     <td class="border border-secondary">'+ value["mobile_no"] +'</td>\
    //                     <td class="border border-secondary">'+ ((value["email"] != null)?value["email"]:"--") +'</td>\
    //                     <td class="border border-secondary">'+ ((value["address"] != null)?value['address']:"--") +'</td>\
    //                     <td class="border border-secondary"><a name="viewVendor"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewVendor"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="editVendor" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editVendor"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="deleteVendor" data-toggle="modal" data-target="#removeModalPurchaseVendor" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });

    //             $('.vendors-pagination-refs').html('');
    //                         jQuery.each(response.links, function (key, value){
    //                             $('.vendors-pagination-refs').append(
    //                                 '<li id="vendors_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                             );
    //             });                

    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //   $(document).on("click", "#vendors_pagination a", function() {
    //     //get url and make final url for ajax 
    //     var url = $(this).attr("href");
    //     var append = url.indexOf("?") == -1 ? "?" : "&";
    //     var finalURL = url + append;

    //     $.get(finalURL, function(response) {
    //         let i = response.from;
    //         jQuery('.vendors-details').html('');
    //         $('.vendors-main-table').html('Total Vendors : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.vendors-details').append('<tr>\
    //                     <td class="border border-secondary">'+ i++ +'</td>\
    //                     <td class="border border-secondary">'+ value['contact_person_name'] +'</td>\
    //                     <td class="border border-secondary">'+ ((value["phone_no"] != null)?value["phone_no"]:"--") +'</td>\
    //                     <td class="border border-secondary">'+ value["mobile_no"] +'</td>\
    //                     <td class="border border-secondary">'+ ((value["email"] != null)?value["email"]:"--") +'</td>\
    //                     <td class="border border-secondary">'+ ((value["address"] != null)?value['address']:"--") +'</td>\
    //                     <td class="border border-secondary"><a name="viewVendor"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewVendor"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="editVendor" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editVendor"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="deleteVendor" data-toggle="modal" data-target="#removeModalPurchaseVendor" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');                 
    //             });

    //         $('.vendors-pagination-refs').html('');
    //         jQuery.each(response.links, function (key, value){
    //             $('.vendors-pagination-refs').append(
    //                 '<li id="vendors_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // // end here       

    // get a single vendor
    $(document).on("click", "a[name = 'editVendor']", function (e){
        let id = $(this).data("id");
        getVendorInfo(id);
        function getVendorInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetVendor')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#idEV').val(value["id"]);
                        $('#vendorNameEV').val(value["vendor_name"]);
                        $('#contactPersonNameEV').val(value["contact_person_name"]);
                        $('#addressEV').val(value["address"]);
                        $('#phoneNoEV').val(value["phone_no"]);
                        $('#mobileNoEV').val(value["mobile_no"]);
                        $('#emailIdEV').val(value["email"]);
                        $('#gstEV').val(value["GST"]);
                        $('#VendoerIDEV').val(value['id']);
                    });
                }
            });
        }
    });

    // view a single vendor
    $(document).on("click", "a[name = 'viewVendor']", function (e){
        let id = $(this).data("id");
        getVendorVInfo(id);
        function getVendorVInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetVendor')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#idV').val(value["id"]);
                        $('#vendorNameV').val(value["vendor_name"]);
                        $('#contactPersonNameV').val(value["contact_person_name"]);
                        $('#addressV').val(value["address"]);
                        $('#phoneNoV').val(value["phone_no"]);
                        $('#mobileNoV').val(value["mobile_no"]);
                        $('#emailIdV').val(value["email"]);
                        $('#gstV').val(value["GST"]);
                        $('#VendoerIDView').val(value["id"]);
                    });
                }
            });
        }
    });


   

    // delete a single vendor using id
    $(document).on("click", "a[name = 'removeConfirmPurchaseVendor']", function (e){
        let id = $(this).data("id");
        delVendor(id);
        function delVendor(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveVendor')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    vendors_main_table.ajax.reload();
                    getVendorNames();                    
                    $("#removeModalPurchaseVendor .close").click();
                }
            });
        }
    });


        // filter
        function VendorFilterSection(){
            $user = $('#VendorSectionFilter').val();
            $.ajax({
                type : "GET" ,
                url : "{{ route('SA-FilterPurchaseVendor') }}",
                data : {
                    "user" : $user,
                },
                success : function (response){

                    let i = 0;
                jQuery('.vendors-details').html('');
                $('.vendors-main-table').html('Total Vendors : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.vendors-details').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["vendor_name"] +'</td>\
                        <td class="border border-secondary">'+ value['contact_person_name'] +'</td>\
                        <td class="border border-secondary">'+ ((value["phone_no"] != null)?value["phone_no"]:"--") +'</td>\
                        <td class="border border-secondary">'+ value["mobile_no"] +'</td>\
                        <td class="border border-secondary">'+ ((value["email"] != null)?value["email"]:"--") +'</td>\
                        <td class="border border-secondary">'+ ((value["address"] != null)?value['address']:"--") +'</td>\
                        <td class="border border-secondary"><a name="viewVendor"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewVendor"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editVendor" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editVendor"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deleteVendor" data-toggle="modal" data-target="#removeModalPurchaseVendor" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                    $('.vendors-pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.vendors-pagination-refs').append(
                                    '<li id="search_vendors_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                    });     

                }
            });

            // pagination links css and access page
            $(function() {
            $(document).on("click", "#search_vendors_pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append + "user="+$('#VendorSectionFilter').val();

                $.get(finalURL, function(response) {
                    let i = response.from;
                    jQuery('.vendors-details').html('');
                    $('.vendors-main-table').html('Total Vendors : '+response.total);
                        jQuery.each(response.data, function (key, value){
                            $('.vendors-details').append('<tr>\
                                <td class="border border-secondary">'+ i++ +'</td>\
                                <td class="border border-secondary">'+ value["vendor_name"] +'</td>\
                                <td class="border border-secondary">'+ value['contact_person_name'] +'</td>\
                                <td class="border border-secondary">'+ ((value["phone_no"] != null)?value["phone_no"]:"--") +'</td>\
                                <td class="border border-secondary">'+ value["mobile_no"] +'</td>\
                                <td class="border border-secondary">'+ ((value["email"] != null)?value["email"]:"--") +'</td>\
                                <td class="border border-secondary">'+ ((value["address"] != null)?value['address']:"--") +'</td>\
                                <td class="border border-secondary"><a name="viewVendor"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewVendor"> <i class="mdi mdi-eye"></i> </a></td>\
                                <td class="border border-secondary"><a name="editVendor" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editVendor"> <i class="mdi mdi-pencil"></i> </a></td>\
                                <td class="border border-secondary"><a name="deleteVendor" data-toggle="modal" data-target="#removeModalPurchaseVendor" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                            </tr>');                 
                        });

                    $('.vendors-pagination-refs').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.vendors-pagination-refs').append(
                            '<li id="search_vendors_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                            );
                        });
                    });
                    return false;
                });
            });
            // end here  

        }

                $(document).on("click", "a[name = 'deleteVendor']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedPurchaseVendor').data('id', id);
                });

</script>

        <div class="modal fade" id="removeModalPurchaseVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmPurchaseVendor" class="btn btn-primary" id="confirmRemoveSelectedPurchaseVendor">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>