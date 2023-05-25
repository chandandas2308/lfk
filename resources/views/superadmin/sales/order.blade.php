<div class="p-3">
    <!-- invoice Tab -->
    <style>
        .pointer {cursor: pointer!important;}
        .pointer {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
        <div class="page-header flex-wrap">
            <!--  -->
            <h4 class="mb-0">
                Order Tab
            </h4>
        </div>


        <!-- table start -->
        <table class="text-center table table-bordered" id="sales_order_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">RFQ No.</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Minimum Sale Price</th>
                        <th class="text-center">Previous Selling Price</th>
                        <th class="text-center">Order Deadline</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Payment Status</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        <!-- table end here -->
</div>

<!-- Create Invoice Model -->

    @include('superadmin.sales.order-modal.vieworder')
<!-- Model -->

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
        sales_order_main_table = $('#sales_order_main_table').DataTable({
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
                url: "{{ route('SA-getQuotationsorder') }}",
                type: 'GET',
            }
        });
        $(document).find('#sales_order_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });


// view quotation detials
$(document).on("click", "a[name = 'viewQuotationORDER']", function (e){
        let id = $(this).data("id");
        jQuery("#productTableBodyVQ").html('');
        getQuotationInfo(id);
        function getQuotationInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetQuotation1')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#customerNameVQorder').val(value["customer_name"]);
                        $('#expirationVQorder').val(value["expiration"]);
                        $('#customerAddressVQorder').val(value["customer_address"]);
                        $('#paymentTermsVQorder').val(value["payment_terms"]);
                        $('#untaxtedAmountVQorder').val(value["untaxted_amount"]);
                        $('#untaxtedAmountVQ1order').val(value["untaxted_amount"]);
                        $('#quotation_download_btnorder').attr("href", "/admin/generate-q-pdf/"+value['id']);
                        $('#gstVQorder').val(value["GST"]);
                        $('#gstVQ1order').val(value["GST"]);
                        $('#gstValueVieworder').val(value["gstValue"]);
                        $('#quotationTotalVQorder').val(value["sub_total"]);
                        $('#quotationTotalVQ1order').val(value["sub_total"]);
                    
                        if(value["tax_inclusive"] == 1)
                        {
                            $('#taxIncludeVQorder').prop('checked', true);
                        }else{
                            $('#taxIncludeVQorder').prop('checked', false);
                            $('#gstVQorder').val('');
                        }

                    let sno = 0;

                    let str = value["products_details"];

                    let obj = JSON.parse(str);

                            $('#productTableBodyVQorder').html('');

                                jQuery.each(obj, function(key, value){
                                    $('#productsTableVQorder tbody').append('<tr class="child">\
                                        <td>'+ ++sno +'</td>\
                                        <td class="product_name">'+value["product_name"]+'</td>\
                                        <td class="product_category">'+value["category"]+'</td>\
                                        <td class="product_varient">'+value["product_varient"]+'</td>\
                                        <td class="sku_code">'+value["sku_code"]+'</td>\
                                        <td class="batch_code">'+value["batch_code"]+'</td>\
                                        <td class="product_desc">'+value["description"]+'</td>\
                                        <td class="product_quantity">'+value["quantity"]+'</td>\
                                        <td class="unit_price">'+value["unitPrice"]+'</td>\
                                        <td class="taxes" style="display:none;">'+value["taxes"]+'</td>\
                                        <td class="subtotal">'+value["subTotal"]+'</td>\
                                        <td class="netAmountVQ">'+value["netAmount"]+'</td>\
                                    </tr>');
                                });
                                
                                jQuery("#delQuotationAlertOrder").hide();
                                jQuery(".alert-danger").hide();
                                jQuery("#addQuotationAlert").hide();
                                jQuery("#editQuotationAlert").hide();

                            });
                }
            });
        }
    });

    // delete a single quotation using id
    $(document).on("click", "a[name = 'removeConfirmorderQuotation']", function (e){
        let id = $(this).data("id");
        delPayment(id);
        function delPayment(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveQuotation')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    sales_order_main_table.ajax.reload();
                    sales_quotation_main_table.ajax.reload();
                    $("#removeModalorderQuotation .close").click();
                }
            });
        }
    });  
        // delete a single quotation using id
        $(document).on("click", "a[name = 'statusConfirmOrderQuotation']", function (e){
        let id = $(this).data("id");
        delPayment(id);
        function delPayment(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-statusorderQuotation')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    sales_order_main_table.ajax.reload();
                    sales_quotation_main_table.ajax.reload();

                    $("#statusModalOrderQuotation .close").click();
                    
                    jQuery("#productTableInvoiceBody").html('');

                    getQuotationDetailsorder();
                    getQuotationDetails();
                    jQuery("#salesInvoiceForm")["0"].reset();
                }
            });
        }
    }); 
    
    // filter
    function salesQuotationSerFilter(){
        
        $user = $('#salesQuotationId').val();
        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-SalesQuotationFilter') }}",
            data : {
                "user" : $user,
            },
            success : function (response){
                
                let i = 0;
                jQuery('.quotation-order-list').html('');
                $('.sales-quotation-main-table').html('Total Order : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.quotation-order-list').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["quotation_id"] +'</td>\
                        <td class="border border-secondary">'+ value['customer_name'] +'</td>\
                        <td class="border border-secondary">'+ parseFloat(value["sub_total"]).toFixed(2) +'</td>\
                        <td class="border border-secondary">'+ parseFloat(value["sub_total"]).toFixed(2) +'</td>\
                        <td class="border border-secondary">'+ value["expiration"] +'</td>\
                        <td class="border border-secondary">'+ parseFloat(value["sub_total"]).toFixed(2) +'</td>\
                        <td class="border border-secondary">'+ value["payment_terms"] +'</td>\
                        <td style="" class="border border-secondary">'+((value["display"] != "none")?'<a data-toggle="modal"  data-target="#statusModalOrderQuotation" name="statusorderQuotation" data-id="'+value["id"]+'" >Cancel</a>':"Invoiced")+'</td>\
                        <td class="border border-secondary"><a name="viewQuotationORDER"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewQuotationORDER"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:'+ value["display"] +';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalorderQuotation" name="deleteQorder" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.sales-quotation-pagination-refsordr').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.sales-quotation-pagination-refsordr').append(
                                    '<li id="search_sales_quotation_paginationoeder" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                });
                
            }
        });

    // pagination links css and access page
    $(function() {
      $(document).on("click", "#search_sales_quotation_paginationoeder a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append+"user="+$('#salesQuotationId').val();

        $.get(finalURL, function(response) {
            let i = response.from;
            jQuery('.quotation-order-list').html('');
            $('.sales-quotation-main-table').html('Total Order : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.quotation-order-list').append('<tr>\
                        <td class="border border-secondary">'+ i++ +'</td>\
                        <td class="border border-secondary">'+ value["quotation_id"] +'</td>\
                        <td class="border border-secondary">'+ value['customer_name'] +'</td>\
                        <td class="border border-secondary">'+ parseFloat(value["sub_total"]).toFixed(2) +'</td>\
                        <td class="border border-secondary">'+ parseFloat(value["sub_total"]).toFixed(2) +'</td>\
                        <td class="border border-secondary">'+ value["expiration"] +'</td>\
                        <td class="border border-secondary">'+ parseFloat(value["sub_total"]).toFixed(2) +'</td>\
                        <td class="border border-secondary">'+ value["payment_terms"] +'</td>\
                        <td style="" class="border border-secondary">'+((value["display"] != "none")?'<a data-toggle="modal"  data-target="#statusModalOrderQuotation" name="statusorderQuotation" data-id="'+value["id"]+'" >Cancel</a>':"Invoiced")+'</td>\
                        <td class="border border-secondary"><a name="viewQuotationORDER"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewQuotationORDER"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:'+ value["display"] +';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalorderQuotation" name="deleteQorder" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');                    
                });

            $('.sales-quotation-pagination-refsordr').html('');
                jQuery.each(response.links, function (key, value){
                    $('.sales-quotation-pagination-refsordr').append(
                        '<li id="search_sales_quotation_paginationoeder" class="page-item '+((value.active===true)? 'active': '')+'" ><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here   

    }

                $(document).on("click", "a[name = 'deleteQorder']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedOrderrQuotation').data('id', id);
                });
                $(document).on("click", "a[name = 'statusorderQuotation']", function (e){
                    let id = $(this).data("id");
                    $('#confirmstatusSelectedorderrQuotation').data('id', id);
                });
    
</script>

<div class="modal fade" id="removeModalorderQuotation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmorderQuotation" class="btn btn-primary" id="confirmRemoveSelectedOrderrQuotation">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="statusModalOrderQuotation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Confirm Alert</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">DO YOU WANT TO CHANGE THE STATUS AS CANCEL?<span id="statusElementId"></span> </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                        <a name="statusConfirmOrderQuotation" class="btn btn-primary" id="confirmstatusSelectedorderrQuotation">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>