
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
                Purchase Order Tab
            </h4>
            <div class="d-flex">
                <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addOrder"> Add Purchase Order </a>
            </div>
        </div>
        
                <div class="alert alert-success alert-dismissible fade show" id="delPurchaseOrderAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delPurchaseOrderAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

        <table class="text-center table table-bordered" id="purchase_invoice_main_table" style="width:100%;">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Order No.</th>
                        <th class="text-center">Quotation No.</th>
                        <th class="text-center">Vendor Name</th>
                        <th class="text-center">Receipt Date</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Billing Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
</div>

<!-- Model -->
<!-- Add Order -->
@include('superadmin.purchase.purchase-order-modal.addOrder')
<!-- Edit Order -->
@include('superadmin.purchase.purchase-order-modal.editOrder')
<!-- View Order -->
@include('superadmin.purchase.purchase-order-modal.viewOrder')

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
        purchase_invoice_main_table = $('#purchase_invoice_main_table').DataTable({
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
                url: "{{ route('SA-GetOrdersDetails') }}",
                type: 'GET',
            }
        });
        $(document).find('#purchase_invoice_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });

    // $(document).ready(function(){
    //     $('#resetPurchaseOrderFilter').click(function(){
    //         $('#purchaseVendorNameFilter').val('');
    //         getPurchaseOrderDetails();
    //     });
    // });

    // $(document).ready(function(){
    //     getPurchaseOrderDetails();
    // });

    // // All Purchase Orders Details
    // function getPurchaseOrderDetails(){
    //     $.ajax({
    //         type : "GET" ,
    //         url : "{{ route('SA-GetOrdersDetails') }}",
    //         success : function (response){
    //             let i = 0;
    //             jQuery('.purchase-order-list').html('');
    //             $('.purchase-invoice-main-table').html('Total Purchase Order : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.purchase-order-list').append('<tr>\
    //                     <td class="border border-secondary">'+ ++i +'</td>\
    //                     <td class="border border-secondary">'+ ((value["ord_no"] != null)?value["ord_no"]:'--') +'</td>\
    //                     <td class="border border-secondary">'+ ((value['qut_no'] != null)?value['qut_no']:"--") +'</td>\
    //                     <td class="border border-secondary">'+ value["vendor_name"] +'</td>\
    //                     <td class="border border-secondary">'+ value["receipt_date"] +'</td>\
    //                     <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
    //                     <td class="border border-secondary">'+ value["billing_status"] +'</td>\
    //                     <td class="border border-secondary"><a name="viewOrder"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewOrder"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="editOrder" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editOrder"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="delOrder" data-toggle="modal" data-target="#removeModalPurchaseOrder" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });

    //             $('.purchase-invoice-pagination-refs').html('');
    //                         jQuery.each(response.links, function (key, value){
    //                             $('.purchase-invoice-pagination-refs').append(
    //                                 '<li id="purchase-invoice-pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                             );
    //             });
    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //   $(document).on("click", "#purchase-invoice-pagination a", function() {
    //     //get url and make final url for ajax 
    //     var url = $(this).attr("href");
    //     var append = url.indexOf("?") == -1 ? "?" : "&";
    //     var finalURL = url + append;

    //     $.get(finalURL, function(response) {
    //         let i = response.from;
    //         jQuery('.purchase-order-list').html('');
    //         $('.purchase-invoice-main-table').html('Total Purchase Order : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.purchase-order-list').append('<tr>\
    //                     <td class="border border-secondary">'+ i++ +'</td>\
    //                     <td class="border border-secondary">'+ ((value["ord_no"] != null)?value["ord_no"]:'--') +'</td>\
    //                     <td class="border border-secondary">'+ ((value['qut_no'] != null)?value['qut_no']:"--") +'</td>\
    //                     <td class="border border-secondary">'+ value["vendor_name"] +'</td>\
    //                     <td class="border border-secondary">'+ value["receipt_date"] +'</td>\
    //                     <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
    //                     <td class="border border-secondary">'+ value["billing_status"] +'</td>\
    //                     <td class="border border-secondary"><a name="viewOrder"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewOrder"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="editOrder" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editOrder"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="border border-secondary"><a name="delOrder" data-toggle="modal" data-target="#removeModalPurchaseOrder" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');                  
    //             });

    //         $('.purchase-invoice-pagination-refs').html('');
    //         jQuery.each(response.links, function (key, value){
    //             $('.purchase-invoice-pagination-refs').append(
    //                     '<li id="purchase-invoice-pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // end here        


    // edit quotation detials
    $(document).on("click", "a[name = 'editOrder']", function (e){
        let id = $(this).data("id");
        jQuery("#productTableBodyOrderEdit").html('');
        getRequestQuotationInfo(id);
        function getRequestQuotationInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetOrderDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#orderId').val(value["id"]);
                        $('#purchaseQuotationNumEdit').val(value["quotation_no"]);
                        $('#refOrderNumEdit').val(value["order_no"]);
                        $('#vendorNameOrderEdit').val(value["vendor_name"]);
                        $('#addOrderDeadlineEdit').val(value["order_deadline"]);
                        $('#gstTreatmentOrderEdit').val(value["gst_treatment"]);
                        $('#receiptDateOrderEdit').val(value["receipt_date"]);
                        $('#vendorReferenceOrderEdit').val(value["vendor_reference"]);
                        $('#billingStatusEdit').val(value["billing_status"]);
                        $('#untaxtedAmountOrderEdit').val(value["untaxted_amount"]);
                        $('#untaxtedAmountOrderEdit1').val(value["untaxted_amount"]);
                        $('#notesOrderEdit').val(value["notes"]);
                        $('#gstOrderEdit').val(value["GST"]);
                        $('#gstOrderEdit1').val(value["GST"]);
                        $('#quotationTotalOrderEdit').val(value["total"]);
                        $('#quotationTotalOrderEdit1').val(value["total"]);    
                        $('#gstValueOrderEdit').val(value['tax']);
                        
                        if(value["confirmation"] == "confirm"){
                            $("#askForConfirmOrderEdit").prop( "checked", true );
                        }

                        if(value["tax_inclusive"] == 1)
                        {
                            $('#taxIncludeOrderEdit').prop('checked', true);
                        }else{
                            $('#taxIncludeOrderEdit').prop('checked', false);
                            $('#gstOrderEdit').val('');
                        }

                        if(value["quotation_no"] != null){
                            $('#taxIncludeOrderEdit').attr('readonly', true);
                            $('#gstValueOrderEdit').attr('readonly', true);
                            $('#taxIncludeOrderEdit').prop('checked', true);
                        }else{
                            $('#taxIncludeOrderEdit').removeAttr('readonly');
                            $('#gstValueOrderEdit').removeAttr('readonly');
                        }

                        getProductsOrderEdit(value["vendor_id"]);

                        let sno = 0;

                        let str = value["products"];

                        let obj = JSON.parse(str);

                        // <td class="sku_code">'+value["sku_code"]+'</td>\

                        jQuery.each(obj, function(key, value){
                            $('#productsTableOrderEdit tbody').append('<tr class="child">\
                                    <td>'+ ++sno +'</td>\
                                    <td class="product_Id" style="display:none;">'+value["product_Id"]+'</td>\
                                    <td class="product_name">'+value["product_name"]+'</td>\
                                    <td class="product_category">'+value["category"]+'</td>\
                                    <td class="product_varient">'+value["product_varient"]+'</td>\
                                    <td class="product_desc">'+value["description"]+'</td>\
                                    <td class="product_quantity">'+value["quantity"]+'</td>\
                                    <td class="unit_price">'+value["unitPrice"]+'</td>\
                                    <td class="taxes"  style="display: none;" >'+value["taxes"]+'</td>\
                                    <td class="subtotal">'+value["subTotal"]+'</td>\
                                    <td class="netAmountEdit">'+value["netAmount"]+'</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="remCF1EditOrder">\
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
    $(document).on("click", "a[name = 'viewOrder']", function (e){
        let id = $(this).data("id");
        jQuery("#productTableBodyOrderView").html('');
        getRequestQuotationInfo(id);
        function getRequestQuotationInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetOrderDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#orderIdView').val(value["id"]);
                        $('#purchaseQuotationNumView').val(value["quotation_no"]);
                        $('#refOrderNumView').val(value["order_no"]);
                        $('#vendorNameOrderView').val(value["vendor_name"]);
                        $('#addOrderDeadlineView').val(value["order_deadline"]);
                        $('#gstTreatmentOrderView').val(value["gst_treatment"]);
                        $('#receiptDateOrderView').val(value["receipt_date"]);
                        $('#vendorReferenceOrderView').val(value["vendor_reference"]);
                        $('#billingStatusView').val(value["billing_status"]);
                        $('#untaxtedAmountOrderView').val(value["untaxted_amount"]);
                        $('#purchaseOrder_download_btn').attr("href", "/admin/purchase-invoice-generate-pdf/"+value['id']);
                        $('#notesOrderView1').val(value["notes"]);
                        $('#gstOrderView').val(value["GST"]);
                        $('#quotationTotalOrderView').val(value["total"]);
                        $('#gstValueOrderView').val(value['tax']);
                        
                        if(value["confirmation"] == "confirm"){
                            $("#askForConfirmPurchaseOrderView1").prop( "checked", true);
                        }

                        if(value["tax_inclusive"] == 1)
                        {
                            $('#taxIncludeOrderView').prop('checked', true);
                        }else{
                            $('#taxIncludeOrderView').prop('checked', false);
                            $('#gstOrderView').val('');
                        }

                        let sno = 0;

                        let str = value["products"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value){
                            $('#productsTableOrderView tbody').append('<tr class="child">\
                                    <td>'+ ++sno +'</td>\
                                    <td class="product_name">'+value["product_name"]+'</td>\
                                    <td class="product_category">'+value["category"]+'</td>\
                                    <td class="product_varient">'+value["product_varient"]+'</td>\
                                    <td class="product_desc">'+value["description"]+'</td>\
                                    <td class="product_quantity">'+value["quantity"]+'</td>\
                                    <td class="unit_price">'+value["unitPrice"]+'</td>\
                                    <td class="taxes"  style="display: none;" >'+value["taxes"]+'</td>\
                                    <td class="subtotal">'+value["subTotal"]+'</td>\
                                    <td class="netAmountView">'+value["netAmount"]+'</td>\
                                    <td></td>\
                                </tr>');
                        });
                    });
                }
            });
        }
    });



    // delete a single quotation using id
    $(document).on("click", "a[name = 'removeConfirmPurchaseOrder']", function (e){
        let id = $(this).data("id");
        delRequest(id);
        function delRequest(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveOrderDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    purchase_invoice_main_table.ajax.reload();
                    $("#removeModalPurchaseOrder .close").click();
                }
            });
        }
    });

    // filter
    function purchaseOrderFilter(){
        $user = $('#purchaseVendorNameFilter').val();
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-PurchaseOrderFilter') }}",
            data : {
                "user" : $user,
            },
            success : function (response){
                    let i = 0;
                    jQuery('.purchase-order-list').html('');
                    $('.purchase-invoice-main-table').html('Total Purchase Order : '+response.total);
                    jQuery.each(response.data, function (key, value){
                        $('.purchase-order-list').append('<tr>\
                            <td class="border border-secondary">'+ ++i +'</td>\
                            <td class="border border-secondary">'+ ((value["ord_no"] != null)?value["ord_no"]:'--') +'</td>\
                            <td class="border border-secondary">'+ ((value['qut_no'] != null)?value['qut_no']:"--") +'</td>\
                            <td class="border border-secondary">'+ value["vendor_name"] +'</td>\
                            <td class="border border-secondary">'+ value["receipt_date"] +'</td>\
                            <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
                            <td class="border border-secondary">'+ value["billing_status"] +'</td>\
                            <td class="border border-secondary"><a name="viewOrder"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewOrder"> <i class="mdi mdi-eye"></i> </a></td>\
                            <td class="border border-secondary"><a name="editOrder" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editOrder"> <i class="mdi mdi-pencil"></i> </a></td>\
                            <td class="border border-secondary"><a name="delOrder" data-toggle="modal" data-target="#removeModalPurchaseOrder" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                    $('.purchase-invoice-pagination-refs').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.purchase-invoice-pagination-refs').append(
                            '<li id="search-purchase-invoice-pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                        );
                    });
                }
            });

            // pagination links css and access page
            $(function() {
            $(document).on("click", "#search-purchase-invoice-pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append;

                $.get(finalURL, function(response) {
                    let i = 0;
                    jQuery('.purchase-order-list').html('');
                    $('.purchase-invoice-main-table').html('Total Purchase Order : '+response.total);
                        jQuery.each(response.data, function (key, value){
                            $('.purchase-order-list').append('<tr>\
                                <td class="border border-secondary">'+ ++i +'</td>\
                                <td class="border border-secondary">'+ ((value["ord_no"] != null)?value["ord_no"]:'--') +'</td>\
                                <td class="border border-secondary">'+ ((value['qut_no'] != null)?value['qut_no']:"--") +'</td>\
                                <td class="border border-secondary">'+ value["vendor_name"] +'</td>\
                                <td class="border border-secondary">'+ value["receipt_date"] +'</td>\
                                <td class="border border-secondary">'+ parseFloat(value["total"]).toFixed(2) +'</td>\
                                <td class="border border-secondary">'+ value["billing_status"] +'</td>\
                                <td class="border border-secondary"><a name="viewOrder"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewOrder"> <i class="mdi mdi-eye"></i> </a></td>\
                                <td class="border border-secondary"><a name="editOrder" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editOrder"> <i class="mdi mdi-pencil"></i> </a></td>\
                                <td class="border border-secondary"><a name="delOrder" data-toggle="modal" data-target="#removeModalPurchaseOrder" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                            </tr>');                  
                        });

                    $('.purchase-invoice-pagination-refs').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.purchase-invoice-pagination-refs').append(
                                '<li id="search-purchase-invoice-pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                            );
                        });
                    });
                    return false;
                });
            });
            // end here   

    }

                $(document).on("click", "a[name = 'delOrder']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedPurchaseOrder').data('id', id);
                });

</script>
<style>
    .search{
        width: 240px;
}
</style>
<div class="modal fade" id="removeModalPurchaseOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmPurchaseOrder" class="btn btn-primary" id="confirmRemoveSelectedPurchaseOrder">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>