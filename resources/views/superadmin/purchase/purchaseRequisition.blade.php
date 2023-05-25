<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">

        <style>
         .search{
                width: 240px;
            }
        </style>

            <h4 class="mb-0">
                Purchase Requisition Tab
            </h4>

            <!--  -->
            <div class="d-flex">
                <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addRequest"> New Request </a>
            </div>

        </div>
        <!-- alert section -->
                <div class="alert alert-success alert-dismissible fade show" id="delPurchaseReqAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delPurchaseReqAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        <!-- alert section end-->

        <!-- table start -->
            <table class="text-center table table-bordered" id="purchase_quotation_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Purchase Requisition</th>
                        <th class="text-center">Vendor Name</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        <!-- table end here -->
</div>

<!-- Model -->
@include('superadmin.purchase.purchase-req-modal.addRequest')
@include('superadmin.purchase.purchase-req-modal.editRequest')
@include('superadmin.purchase.purchase-req-modal.viewRequest')


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
        purchase_quotation_main_table = $('#purchase_quotation_main_table').DataTable({
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
                url: "{{ route('SA-RequestQuotation') }}",
                type: 'GET',
            }
        });
        $(document).find('#purchase_quotation_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });
    
    // $(document).ready(function(){
    //     getQuotationReq();
    // });

    
    // $(document).ready(function(){
    //     $('#resetPurchaseReqFilter').click(function(){
    //         $('#purchaseReqVendorNameFilter').val('');
    //         getQuotationReq();
    //     });
    // });

    // // All quotaion Details
    // function getQuotationReq(){
    //     $.ajax({
    //         type : "GET" ,
    //         url : "{{ route('SA-RequestQuotation') }}",
    //         success : function (response){
    //             let i = 0;
    //             jQuery('.quotation-list').html('');
    //             $('.purchase-quotation-main-table').html('Total Quotations : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.quotation-list').append('<tr>\
    //                     <td class="border border-secondary">'+ ++i +'</td>\
    //                     <td class="border border-secondary">'+ value["purchase_requisition"] +'</td>\
    //                     <td class="border border-secondary">'+ value['vendor_name'] +'</td>\
    //                     <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
    //                     <td class="border border-secondary">'+ ((value["confirmation"]!=null)?value["confirmation"]:"--") +'</td>\
    //                     <td class="border border-secondary"><a name="viewRequest"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewRequest"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="editRequest" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editRequest"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="deleteRequest" data-toggle="modal" data-target="#removeModalPurchaseReq" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });

    //             $('.purchase-quotation-pagination-refs').html('');
    //                         jQuery.each(response.links, function (key, value){
    //                             $('.purchase-quotation-pagination-refs').append(
    //                                 '<li id="purchase_quotation_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                             );
    //             });

    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //   $(document).on("click", "#purchase_quotation_pagination a", function() {
    //     //get url and make final url for ajax 
    //     var url = $(this).attr("href");
    //     var append = url.indexOf("?") == -1 ? "?" : "&";
    //     var finalURL = url + append;

    //     $.get(finalURL, function(response) {
    //         let i = response.from;
    //         jQuery('.quotation-list').html('');
    //         $('.purchase-quotation-main-table').html('Total Quotations : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.quotation-list').append('<tr>\
    //                     <td class="border border-secondary">'+ i++ +'</td>\
    //                     <td class="border border-secondary">'+ value["purchase_requisition"] +'</td>\
    //                     <td class="border border-secondary">'+ value['vendor_name'] +'</td>\
    //                     <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
    //                     <td class="border border-secondary">'+ ((value["confirmation"]!=null)?value["confirmation"]:"--") +'</td>\
    //                     <td class="border border-secondary"><a name="viewRequest"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewRequest"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="editRequest" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editRequest"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="deleteRequest" data-toggle="modal" data-target="#removeModalPurchaseReq" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');                  
    //             });

    //         $('.purchase-quotation-pagination-refs').html('');
    //         jQuery.each(response.links, function (key, value){
    //             $('.purchase-quotation-pagination-refs').append(
    //                     '<li id="purchase_quotation_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // end here    


    // edit quotation detials
    $(document).on("click", "a[name = 'editRequest']", function (e){
        let id = $(this).data("id");
        jQuery("#productTableBodyEQ").html('');
        getRequestQuotationInfo(id);
        function getRequestQuotationInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetSingleQuotation')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#requestQuotationId').val(value["id"]);
                        $('#vendorNameEQ').val(value["vendor_name"]);
                        $('#orderDeadlineEQ').val(value["order_deadline"]);
                        $('#gstTreatmentEQ').val(value["gst_treatment"]);
                        $('#receiptDateEQ').val(value["receipt_date"]);
                        $('#vendorReferenceEQ').val(value["vendor_reference"]);
                        // $('#askForConfirmEQ').val(value["confirmation"]);
                        $('#untaxtedAmountEQ').val(value["untaxted_amount"]);
                        $('#untaxtedAmountEQ1').val(value["untaxted_amount"]);
                        $('#notesEQ').val(value["note"]);
                        $('#gstValueEReq').val(value["gstpercentage"]);
                        $('#gstEQ').val(value["GST"]);
                        $('#gstEQ1').val(value["GST"]);
                        $('#quotationTotalEQ').val(value["total"]);
                        $('#quotationTotalEQ1').val(value["total"]);    
                        $('#gstValueEReq').val(value["gstpercentage"]);
                        
                        if(value["confirmation"] == "confirm"){
                            $("#askForConfirmEQ").prop( "checked", true );
                        }

                        if(value["tax_inclusive"] == 1)
                        {
                            $('#taxIncludeEQ').prop('checked', true);
                        }else{
                            $('#taxIncludeEQ').prop('checked', false);
                            $('#gstEQ').val('');
                        }

                        getProductsEQ(value["vendor_id"]);

                        let sno = 0;

                        let str = value["products"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value){
                            $('#productsTableEQ tbody').append('<tr class="child">\
                                    <td>'+ ++sno +'</td>\
                                    <td class="product_Id" style="display:none;">'+value["product_Id"]+'</td>\
                                    <td class="product_name">'+value["product_name"]+'</td>\
                                    <td class="product_category">'+value["category"]+'</td>\
                                    <td class="product_varient">'+value["product_varient"]+'</td>\
                                    <td class="sku_code">'+value["sku_code"]+'</td>\
                                    <td class="product_desc">'+value["description"]+'</td>\
                                    <td class="product_quantity">'+value["quantity"]+'</td>\
                                    <td class="unit_price">'+value["unitPrice"]+'</td>\
                                    <td class="taxes" style="display:none;" >'+value["taxes"]+'</td>\
                                    <td class="subtotal">'+value["subTotal"]+'</td>\
                                    <td class="netAmountEReq">'+value["netAmount"]+'</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="remCF1EQ">\
                                            <i class="mdi mdi-delete"></i>\
                                        </a>\
                                    </td>\
                                </tr>');
                        });
                    });
                }
            });
        }
    });

    // View Quotation
    $(document).on("click", "a[name = 'viewRequest']", function (e){
        let id = $(this).data("id");
        jQuery("#productTableBodyVQ").html('');
        getRequestQuotationInfo(id);
        function getRequestQuotationInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetSingleQuotation')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#vendorNameVQ').val(value["vendor_name"]);
                        $('#orderDeadlineVQ').val(value["order_deadline"]);
                        $('#gstTreatmentVQ').val(value["gst_treatment"]);
                        $('#receiptDateVQ').val(value["receipt_date"]);
                        $('#vendorReferenceVQ').val(value["vendor_reference"]);
                        $('#untaxtedAmountVQ').val(value["untaxted_amount"]);
                        $('#untaxtedAmountVQ1').val(value["untaxted_amount"]);
                        $('#purchaseReq_download_btn').attr("href", "/admin/purchase-q-generate-pdf/"+value['id']);
                        $('#notesVQ').val(value["note"]);
                        $('#gstValueEReqview').val(value["gstpercentage"]);
                        $('#gstVQ').val(value["GST"]);
                        $('#gstVQ1').val(value["GST"]);
                        $('#quotationTotalVQ').val(value["total"]);
                        $('#quotationTotalVQ1').val(value["total"]);    
                        
                        if(value["confirmation"] == "confirm"){
                            $("#askForConfirmVQ1").prop( "checked", true );
                        }

                        if(value["tax_inclusive"] == 1)
                        {
                            $('#taxIncludeVQ').prop('checked', true);
                        }else{
                            $('#taxIncludeVQ').prop('checked', false);
                            $('#gstVQ').val('');
                        }

                        let sno = 0;

                        let str = value["products"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value){
                            $('#productsTableVQ tbody').append('<tr class="child">\
                                    <td>'+ ++sno +'</td>\
                                    <td class="product_name">'+value["product_name"]+'</td>\
                                    <td class="product_category">'+value["category"]+'</td>\
                                    <td class="product_varient">'+value["product_varient"]+'</td>\
                                    <td class="sku_code">'+value["sku_code"]+'</td>\
                                    <td class="product_desc">'+value["description"]+'</td>\
                                    <td class="product_quantity">'+value["quantity"]+'</td>\
                                    <td class="unit_price">'+value["unitPrice"]+'</td>\
                                    <td class="taxes"  style="display: none;">'+value["taxes"]+'</td>\
                                    <td class="subtotal">'+value["subTotal"]+'</td>\
                                    <td class="netAmountEReq">'+value["netAmount"]+'</td>\
                                    <td></td>\
                                </tr>');
                        });
                    });
                }
            });
        }
    });



    // delete a single quotation using id
    $(document).on("click", "a[name = 'removeConfirmPurchaseReq']", function (e){
        let id = $(this).data("id");
        delRequest(id);
        function delRequest(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveSingleQuotation')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    purchase_quotation_main_table.ajax.reload();
                    $("#removeModalPurchaseReq .close").click();
                }
            });
        }
    });  
    
    
    // filter
    function purchaseReqFilter(){
        
        $user = $('#purchaseReqVendorNameFilter').val();
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-RequestAllQuotationsFilter') }}",
            data : {
                "user" : $user,
            },
            success : function (response){

                let i = 0;
                jQuery('.quotation-list').html('');
                $('.purchase-quotation-main-table').html('Total Quotations : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.quotation-list').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["purchase_requisition"] +'</td>\
                        <td class="border border-secondary">'+ value['vendor_name'] +'</td>\
                        <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
                        <td class="border border-secondary">'+ ((value["confirmation"]!=null)?value["confirmation"]:"--") +'</td>\
                        <td class="border border-secondary"><a name="viewRequest"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewRequest"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editRequest" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editRequest"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deleteRequest" data-toggle="modal" data-target="#removeModalPurchaseReq" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.purchase-quotation-pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.purchase-quotation-pagination-refs').append(
                                    '<li id="search_purchase_quotation_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                });

                }
            });

            // pagination links css and access page
            $(function() {
            $(document).on("click", "#search_purchase_quotation_pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append + "user="+$('#purchaseReqVendorNameFilter').val();

                $.get(finalURL, function(response) {
                    let i = response.from;
                    jQuery('.quotation-list').html('');
                    $('.purchase-quotation-main-table').html('Total Quotations : '+response.total);
                        jQuery.each(response.data, function (key, value){
                            $('.quotation-list').append('<tr>\
                                <td class="border border-secondary">'+ i++ +'</td>\
                                <td class="border border-secondary">'+ value["purchase_requisition"] +'</td>\
                                <td class="border border-secondary">'+ value['vendor_name'] +'</td>\
                                <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
                                <td class="border border-secondary">'+ ((value["confirmation"]!=null)?value["confirmation"]:"--") +'</td>\
                                <td class="border border-secondary"><a name="viewRequest"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewRequest"> <i class="mdi mdi-eye"></i> </a></td>\
                                <td class="border border-secondary"><a name="editRequest" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editRequest"> <i class="mdi mdi-pencil"></i> </a></td>\
                                <td class="border border-secondary"><a name="deleteRequest" data-toggle="modal" data-target="#removeModalPurchaseReq" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                            </tr>');                  
                        });

                    $('.purchase-quotation-pagination-refs').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.purchase-quotation-pagination-refs').append(
                                '<li id="search_purchase_quotation_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                            );
                        });
                    });
                    return false;
                });
            });
            // end here    
        }

                $(document).on("click", "a[name = 'deleteRequest']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedPurchaseReq').data('id', id);
                });
    
</script>


<div class="modal fade" id="removeModalPurchaseReq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmPurchaseReq" class="btn btn-primary" id="confirmRemoveSelectedPurchaseReq">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>