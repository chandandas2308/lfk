    <!-- Return Exchange Tab -->
    <div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Return Exchange
            </h4>
            <div class="d-flex">
                <a href="#" class="nav-link bg-addbtn mx-2 rounded"  data-toggle="modal" data-target="#addProductReturnExchange"> Add Return/Exchange </a>
            </div>
        </div>

        <!-- alert section -->
            <!-- <div class="alert alert-success" id="delProAlert" style="display:none"></div> -->
                <div class="alert alert-success alert-dismissible fade show" id="delProAlert" style="display:none" role="alert">
                  <strong>Info ! </strong> <span id="delProAlertMSG"></span>
                  <button type="button" class="close"  aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
        <!-- alert section end-->

        <!-- table start -->
        <!-- <div class="table-responsive"> -->
            <table class="text-center table table-responsive table-bordered" id="return_exchange_main_table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Invoice Type</th>
                        <th>Customer/Vendor Name</th>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
                        <th>Invoice Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        <!-- </div> -->
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

<!-- Add product model start -->
    @include('superadmin.inventory.return-exchange-model.addProduct')
<!-- Add product model end -->

<!-- Edit product model start -->
    @include('superadmin.inventory.return-exchange-model.editProduct')
<!-- Edit product model end -->

<!-- view product model start -->
    @include('superadmin.inventory.return-exchange-model.viewProduct')
<!-- view product model end -->

<!-- view 0 invoice model start -->
    @include('superadmin.inventory.return-exchange-model.invocProduct')
<!-- view 0 invoice model end -->

<script>


    $(document).ready(function() {
        return_exchange_main_table = $('#return_exchange_main_table').DataTable({
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
                url: "{{ route('SA-GetREProducts') }}",
                type: 'GET',
            },
        });
        $(document).find('#return_exchange_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    });
    
    // jQuery(document).ready(function (){
    //     getDetials();
    // });

    // $(document).ready(function(){
    //     $('#resetREFilter').click(function(){
    //         $('#selectReturnExchange').prop('selectedIndex',0);
    //         getDetials();
    //     })
    // });

    // All Return & exchange Details
    // function getDetials(){
    //     $.ajax({
    //         type : "GET" ,
    //         url : "{{ route('SA-GetREProducts') }}",
    //         success : function (response){
    //             let i = 0;
    //             jQuery('.returnExchangeBody').html('');
    //             $('.return-exchange-main-table').html('Total no. of Return Exchange : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.returnExchangeBody').append('<tr>\
    //                     <td class=" border border-secondary">'+ ++i +'</td>\
    //                     <td class=" border border-secondary">'+ value["type"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["user_name"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["both_sale_pur"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["invoice_amount"] +'</td>\
    //                     <td class=" border border-secondary">'+ ((value["type"] != 'sale')?"--":'<a name="invocProductRE"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#invocProductRE"> Zero Invoice </a>')+'</td>\
    //                     <td class=" border border-secondary"><a name="viewRE"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewProductRE"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class=" border border-secondary"><a name="editRE" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProductReturnExchange"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalreturnExchange" name="deleteRE" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });

    //             $('.return-exchange-pagination-refs').html('');
    //                         jQuery.each(response.links, function (key, value){
    //                             $('.return-exchange-pagination-refs').append(
    //                                 '<li id="return_exchange_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                             );
    //             });

    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //   $(document).on("click", "#return_exchange_pagination a", function() {
    //     //get url and make final url for ajax 
    //     var url = $(this).attr("href");
    //     var append = url.indexOf("?") == -1 ? "?" : "&";
    //     var finalURL = url + append;

    //     $.get(finalURL, function(response) {
    //         let i = response.from;
    //         jQuery('.returnExchangeBody').html('');
    //         $('.return-exchange-main-table').html('Total no. of Return Exchange : '+response.total);
    //             jQuery.each(response.data, function (key, value){
    //                 $('.returnExchangeBody').append('<tr>\
    //                 <td class=" border border-secondary">'+ ++i +'</td>\
    //                     <td class=" border border-secondary">'+ value["type"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["user_name"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["both_sale_pur"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
    //                     <td class=" border border-secondary">'+ value["invoice_amount"] +'</td>\
    //                     <td class=" border border-secondary">'+ ((value["type"] != 'sale')?"--":'<a name="invocProductRE"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#invocProductRE"> Zero Invoice </a>')+'</td>\
    //                     <td class=" border border-secondary"><a name="viewRE"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewProductRE"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class=" border border-secondary"><a name="editRE" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProductReturnExchange"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalreturnExchange" name="deleteRE" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');                
    //             });

    //         $('.return-exchange-pagination-refs').html('');
    //             jQuery.each(response.links, function (key, value){
    //                 $('.return-exchange-pagination-refs').append(
    //                     '<li id="return_exchange_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // end here     


    // fetch a single product
    $(document).on("click", "a[name = 'editRE']", function (e){
        let id = $(this).data("id");
        getProduct(id);
        function getProduct(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-FetchREProducts')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#reuniqueId').val(value["id"]);
                        $('#edit-re-type').val(value['type']);
                        $('#edit_user_name_re').val(value['user_name']);
                        $('#edit_user_nameRE').val(value['user_name']);
                        $('#edit-re-invoice').val(value['invoice_no']);
                        $('#edit_invoice_date_re').val(value['invoice_date']);
                        $('#edit_invoice_amount_re').val(value['invoice_amount']);

                        let str = value["orders"];
                        
                        let sno = 0;

                        let obj = JSON.parse(str);

                        $('#productRETableEdit tbody').html('');

                        jQuery.each(obj, function(key, value){
                            $('#productRETableEdit tbody').append('<tr class="child">\
                                    <td class="border border-secondary ">'+ ++sno +'</td>\
                                    <td class="border border-secondary product_idRETable" style="display:none;" >'+value["product_Id"]+'</td>\
                                    <td class="border border-secondary product_nameRETable">'+value["product_name"]+'</td>\
                                    <td class="border border-secondary product_varientRETable">' + value["product_varient"] + '</td>\
                                    <td class="border border-secondary quantity_RETable">'+value["quantity"]+'</td>\
                                    <td class="border border-secondary unit_price_RETable">'+value["unit_price"]+'</td>\
                                    <td class="border border-secondary sub_totalRETable">'+value["subTotal"]+'</td>\
                                    <td class="border border-secondary status_RETable">'+value["status"]+'</td>\
                                    <td class="border border-secondary quantity_return_RETable">'+value["quantityRAC"]+'</td>\
                                    <td class="border border-secondary edit_remark_RETable">'+value["remark"]+'</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="editremCF21">\
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


       // Invoice a single product
       $(document).on("click", "a[name = 'invocProductRE']", function(e) {
            let id = $(this).data("id");
            getProduct(id);

            function getProduct(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-ViewREProducts') }}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        jQuery.each(response, function(key, value) {
                            $('#reuniqueIdinvoic').val(value["id"]);
                            $('#view-re-typeinvoic').val(value['type']);
                            $('#view_user_name_reinvoic').val(value['user_name']);
                            $('#view_user_nameREinvoic').val(value['user_name']);
                            $('#view-re-invoiceinvoic').val(value['invoice_no']);
                            $('#view_invoice_date_re1').val(value['invoice_date']);
                            $('#view_invoice_amount_re1').val(0);
                            $('#return_and_exchanges_date').val(value['date']);
                            
                            if(value['date'] != null){
                                $('#return_and_exchanges_date').attr('disabled', true);
                            }else{
                                $('#return_and_exchanges_date').removeAttr('disabled');
                            }

                            let str;
                            let dateColumn;

                            if(value['date'] != null){
                                $('#zeroInvoiceSubmitBtn').attr('disabled', true);
                                str = value["zeroInvoiceOrders"];
                                dateColumn = value['date'];
                            }else{
                                $('#zeroInvoiceSubmitBtn').removeAttr('disabled');
                                str = value["orders"];
                                dateColumn = null;
                            }

                            // let str = value["orders"];

                            let sno = 0;

                            let obj = JSON.parse(str);

                            $('#productRETableViewinvoic tbody').html('');

                            jQuery.each(obj, function(key, value) {

                                
                                let classNameIs = 'batch_code_zero_invoice'+sno;
                                getBatchCode(value['product_name'], value['product_varient'], classNameIs);

                                $('#productRETableViewinvoic tbody').append(`<tr class="child">
                                        <td class=" border border-secondary">${ ++sno }</td>
                                        <td class=" border border-secondary product_id" style="display:none;" >${ value["product_Id"] }</td>
                                        <td class=" border border-secondary product_name">${ value["product_name"] }</td>
                                        <td class=" border border-secondary varient">${ value["product_varient"] }</td>
                                        <td class=" border border-secondary quantity">${ value["quantity"] }</td>
                                        <td class=" border border-secondary subTotal">${ value["unit_price"] }</td>
                                        <td class=" border border-secondary status">${ value["status"] }</td>
                                        <td class=" border border-secondary requantity">${ value["quantityRAC"] }</td>
                                        <td class="  border border-secondary remark">${ value["remark"] }</td>
                                        <td class="border border-secondary batchCode">
                                        ${

                                            ((value['batchCode']!=null)?value['batchCode']:`<select name="batch_code" id="batch_code_zero_invoice" class="${classNameIs} classNameIs form-control text-dark"><option value="">Select Batch Code...</option>`)
                                            
                                        }
                                        </td>
                                    </tr>`);

                                    function getBatchCode(proName, proVariant, classNameIs){
                                            jQuery.ajax({
                                                type: "GET",
                                                url: "{{ route('SA-GetAllBatchCode1')}}",
                                                data: {
                                                    product_name : proName,
                                                    varient : proVariant,
                                                },
                                                success: function(response1) {
                                                    $(`.${classNameIs}`).html('');
                                                    $(`.${classNameIs}`).append('<option value="">Select Batch Code...</option>');

                                                    // if(value['batchCode']!=null){
                                                    //     value['batchCode']
                                                    // }else{
                                                        // '<select name="batch_code" id="batch_code_zero_invoice" class="form-control text-dark"><option value="">Select Batch Code...</option>'
                                                        jQuery.each(response1, function(key, value) {

                                                            $(`.${classNameIs}`).append(
                                                                '<option value="' + value['batch_code'] + '">' + value['batch_code'] + '</option>'
                                                            );
                                                            

                                                        });
                                                        // '</select>';
                                                    // }
                                                }      
                                            });
                                    }
                            });
                        });
                    }
                });
            }
        });


    // delete a single product using id
    $(document).on("click", "a[name = 'removeConfirmReturnExchange']", function (e){
        let id = $(this).data("id");
        delCategory(id);
        function delCategory(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveREProducts')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    return_exchange_main_table.ajax.reload();

                    $("#removeModalreturnExchange .close").click();
                }
            });
        }
    });
    
    // view a single product
    $(document).on("click", "a[name = 'viewRE']", function (e){
        let id = $(this).data("id");
        getProduct(id);
        function getProduct(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-ViewREProducts')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#view-re-type').val(value['type']);
                        $('#view_user_name_re').val(value['user_name']);
                        $('#view_user_nameRE').val(value['user_name']);
                        $('#view-re-invoice').val(value['invoice_no']);
                        $('#view_invoice_date_re').val(value['invoice_date']);
                        $('#view_invoice_amount_re').val(value['invoice_amount']);

                        let str = value["orders"];
                        
                        let sno = 0;

                        let obj = JSON.parse(str);

                        $('#productRETableView tbody').html('');

                        jQuery.each(obj, function(key, value){
                            $('#productRETableView tbody').append('<tr class="child">\
                                    <td class="border border-secondary">'+ ++sno +'</td>\
                                    <td class="border border-secondary product_idRETable" style="display:none;" >'+value["product_Id"]+'</td>\
                                    <td class="border border-secondary product_nameRETable">'+value["product_name"]+'</td>\
                                    <td class="border border-secondary product_varientRETable">' + value["product_varient"] + '</td>\
                                    <td class="border border-secondary quantity_RETable">'+value["quantity"]+'</td>\
                                    <td class="border border-secondary unit_price_RETable">'+value["unit_price"]+'</td>\
                                    <td class="border border-secondary sub_totalRETable">'+value["subTotal"]+'</td>\
                                    <td class="border border-secondary status_RETable">'+value["status"]+'</td>\
                                    <td class="border border-secondary quantity_return_RETable">'+value["quantityRAC"]+'</td>\
                                    <td class="border border-secondary edit_remark_RETable">'+value["remark"]+'</td>\
                                </tr>');
                        });

                    });
                }
            });
        }
    });

    // All Filter Return & Exchange Details
    function getREFilter(){
        
        let status = jQuery('#selectReturnExchange').val();

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-ViewREFilter') }}",
            data : {
                "status" : status
            },
            success : function (response){
                let i = response.from;
                jQuery('.returnExchangeBody').html('');
                jQuery.each(response, function (key, value){
                    $('.returnExchangeBody').append('<tr>\
                        <td class=" border border-secondary">'+ i++ +'</td>\
                        // <td class=" border border-secondary"> <img src= "/Return&Exchange/'+ value["product_image_path"] +'" /></td>\
                        <td class=" border border-secondary">'+ value["product_name"] +'</td>\
                        <td class=" border border-secondary">'+ value["product_varient"] +'</td>\
                        <td class=" border border-secondary">'+ value["product_categories"] +'</td>\
                        <td class=" border border-secondary">'+ value["customer_name"] +'</td>\
                        <td class=" border border-secondary">'+ value["sku_code"] +'</td>\
                        <td class=" border border-secondary">'+ value["quantity"] +'</td>\
                        <td class=" border border-secondary">'+ value["return_exchange_status"] +'</td>\
                        <td class=" border border-secondary">'+ value["status"] +'</td>\
                        <td class=" border border-secondary"><a name="viewRE"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewProductRE"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class=" border border-secondary"><a name="editRE" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProductReturnExchange"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalreturnExchange" name="deleteRE" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });
            }
        });
    }
    // End function here

    // All Filter Return & Exchange Details
    function returnExchangeFilter(){
        
        let user = jQuery('#returnExchange').val();
        
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-InputREFilter') }}",
            data : {
                "user" : user
            },
            success : function (response){
                let i = 0;
                jQuery('.returnExchangeBody').html('');
                $('.return-exchange-main-table').html('Total no. of Return Exchange : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.returnExchangeBody').append('<tr>\
                    <td class=" border border-secondary">'+ ++i +'</td>\
                        <td class=" border border-secondary">'+ value["type"] +'</td>\
                        <td class=" border border-secondary">'+ value["user_name"] +'</td>\
                        <td class=" border border-secondary">'+ value["both_sale_pur"] +'</td>\
                        <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class=" border border-secondary">'+ value["invoice_amount"] +'</td>\
                        <td class=" border border-secondary">'+ ((value["type"] != 'sale')?"--":'<a name="invocProductRE"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#invocProductRE"> Zero Invoice </a>')+'</td>\
                        <td class=" border border-secondary"><a name="viewRE"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewProductRE"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class=" border border-secondary"><a name="editRE" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProductReturnExchange"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalreturnExchange" name="deleteRE" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.return-exchange-pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.return-exchange-pagination-refs').append(
                                    '<li id="search_return_exchange_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                });
            }
        });

            // pagination links css and access page
    $(function() {
      $(document).on("click", "#search_return_exchange_pagination a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append;

        $.get(finalURL, function(response) {
            let i = response.from;
            jQuery('.returnExchangeBody').html('');
            $('.return-exchange-main-table').html('Total no. of Return Exchange : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.returnExchangeBody').append('<tr>\
                    <td class=" border border-secondary">'+ ++i +'</td>\
                        <td class=" border border-secondary">'+ value["type"] +'</td>\
                        <td class=" border border-secondary">'+ value["user_name"] +'</td>\
                        <td class=" border border-secondary">'+ value["both_sale_pur"] +'</td>\
                        <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class=" border border-secondary">'+ value["invoice_amount"] +'</td>\
                        <td class=" border border-secondary">'+ ((value["type"] != 'sale')?"--":'<a name="invocProductRE"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#invocProductRE"> Zero Invoice </a>')+'</td>\
                        <td class=" border border-secondary"><a name="viewRE"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewProductRE"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class=" border border-secondary"><a name="editRE" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editProductReturnExchange"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalreturnExchange" name="deleteRE" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');                
                });

            $('.return-exchange-pagination-refs').html('');
                jQuery.each(response.links, function (key, value){
                    $('.return-exchange-pagination-refs').append(
                        '<li id="search_return_exchange_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here  

    }
    // End function here

    
                $(document).on("click", "a[name = 'deleteRE']", function (e){
                    let id = $(this).data("id");
                    console.log(id);
                    $('#confirmRemoveSelectedElementReturnExchange').data('id', id);
                });

</script>

    <div class="modal fade" id="removeModalreturnExchange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmReturnExchange" class="btn btn-primary" id="confirmRemoveSelectedElementReturnExchange">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>