<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Invoice Tab
            </h4>
            <div class="d-flex">
            </div>
            <div class="d-flex">
                <a href="#" onclick="jQuery('delInvoiceAlert').hide()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#createInvoice"> Create Invoice </a>
            </div>
        </div>

        <!-- table start -->
        <table class="text-center table table-bordered" id="sales_invoice_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Order No.</th>
                        <th class="text-center">Invoice No.</th>
                        <th class="text-center">Invoice Date</th>
                        <th class="text-center">Due Date</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        <!-- table end here -->
</div>

<!-- Create Invoice Model -->
@include('superadmin.sales.invoice-modal.createInvoice')
@include('superadmin.sales.invoice-modal.editInvoice')
@include('superadmin.sales.invoice-modal.viewInvoice')


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
    jQuery(document).ready(function (){
        getInvoiceNo();
    });

    
    $(document).ready(function() {
        sales_invoice_main_table = $('#sales_invoice_main_table').DataTable({
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
                url: "{{ route('SA-InvoiceList') }}",
                type: 'GET',
            }
        });
        $(document).find('#sales_invoice_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });

    // Edit Invoice - start here
        // edit quotation detials
        $(document).on("click", "a[name = 'editInvoice']", function (e){
        let id = $(this).data("id");
        jQuery("#productTableEditInvoiceBody").html('');
        getInvoicesInfo(id);
        function getInvoicesInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-SingleInvoice')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){

                        editInvoiceFilterProducts(value["customer_id"]);

                        $('#invoiceID').val(value["id"]);
                        $('#quotationNumberEInvoice').val(value["quotation_no"]);
                        $('#refNextColumnEInvoice').val(value["invoice_no"]);
                        $('#referralNumberEInvoice').val(value["referral_no"]);
                        $('#customerNameEditInvoice').val(value["customer_name"]);
                        $('#invoiceCustomer_idEdit').val(value["customer_id"]);
                        $('#invoiceDateEInvoice').val(value["invoice_date"]);
                        $('#pymentReferenceEInvoice').val(value["payment_ref"]);
                        $('#invoiceDueEInvoice').val(value["due_date"]);
                        $('#selectTermsEInvoice').val(value["status"]);
                        $('#untaxtedAmountEInvoice').val(value["untaxed_amount"]);
                        $('#untaxtedAmountEInvoice1').val(value["untaxed_amount"]);               
                        $('#gstEInvoice').val(value["GST"]);
                        $('#gstEInvoice1').val(value["GST"]);
                        $('#invoiceETotal').val(value["total"]);
                        $('#invoiceETotal1').val(value["total"]);
                        $('#notesEInvoice').val(value['note']);

                        $('#gstValueInvoiceEdit').val(value["tax"]);

                        if(value["quotation_no"] != null){
                            $('#taxIncludeEditInvoice').prop('readonly', true);
                            $('#gstValueInvoiceEdit').prop('readonly', true);
                        }else{
                            $('#taxIncludeEditInvoice').prop('readonly', false);
                            $('#gstValueInvoiceEdit').prop('readonly', false);
                        }

                        let str = value["products"];

                        if(value["tax_inclusive"] == 1)
                        {
                            $('#taxIncludeEditInvoice').prop('checked', true);
                        }else{
                            $('#taxIncludeEditInvoice').prop('checked', false);
                            $('#gstEInvoice').val('');
                        }

                        let sno = 0;

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value){
                            $('#productTableEInvoice tbody').append('<tr class="child">\
                                    <td>'+ ++sno +'</td>\
                                    <td class="product_IdEInvoice" style="display:none;">'+value["product_Id"]+'</td>\
                                    <td class="product_nameEInvoice">'+value["product_name"]+'</td>\
                                    <td class="product_categoryEInvoice">'+value["category"]+'</td>\
                                    <td class="product_varientEInvoice">'+value["product_varient"]+'</td>\
                                    <td class="sku_CodeEInvoice">'+value["sku_code"]+'</td>\
                                    <td class="batch_CodeEInvoice">'+value["batch_code"]+'</td>\
                                    <td class="product_descEInvoice">'+value["description"]+'</td>\
                                    <td class="product_quantityEInvoice">'+value["quantity"]+'</td>\
                                    <td class="unit_priceEInvoice">'+value["unitPrice"]+'</td>\
                                    <td class="taxesEInvoice" style="display:none;">'+value["taxes"]+'</td>\
                                    <td class="subtotalEInvoice">'+value["subTotal"]+'</td>\
                                    <td class="netAmountEInvoice">'+value["netAmount"]+'</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="remCF1EditInvoice">\
                                            <i class="mdi mdi-delete"></i>\
                                        </a>\
                                    </td>\
                                </tr>');
                        });
                        jQuery("#delInvoiceAlert").hide();
                        jQuery(".alert-danger").hide();
                        jQuery("#addInvoiceAlert").hide();
                        jQuery("#editInvoiceAlert").hide();
                    });
                }
            });
        }
    });
    // end here

// view individuals invoice
    $(document).on("click", "a[name = 'viewInvoice']", function (e){
        let id = $(this).data("id");
        jQuery("#productTableViewInvoiceBody").html('');
        getInvoicesInfo(id);
        function getInvoicesInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-SingleInvoice')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    console.log(response);
                    jQuery.each(response, function(key, value){
                        $('#invoiceID').val(value["id"]);
                        $('#quotationNumberVInvoice').val(value["quotation_no"]);
                        $('#refNextColumnVInvoice').val(value["invoice_no"]);
                        $('#referralNumberVInvoice').val(value["referral_no"]);
                        $('#customerNameVInvoice').val(value["customer_name"]);
                        $('#invoiceDateVInvoice').val(value["invoice_date"]);
                        $('#pymentReferenceVInvoice').val(value["payment_ref"]);
                        $('#invoiceDueVInvoice').val(value["due_date"]);
                        $('#selectTermsVInvoice').val(value["status"]);
                        $('#untaxtedAmountVInvoice').val(value["untaxed_amount"]);
                        $('#invoice_download_btn').attr("href", "/admin/generate-pdf/"+value['id']);
                        $('#btnPrintSalesInvoice').attr('href', "/admin/print-pdf/"+value['id']);
                        $('#gstVInvoice').val(value["GST"]);
                        $('#invoiceVTotal').val(value["total"]);
                        $('#notesVInvoice').val(value['note']);

                        $('#gstValueInvoiceView').val(value["tax"]);

                        if(value["tax_inclusive"] == 1)
                        {
                            $('#taxIncludeViewInvoice').prop('checked', true);
                        }else{
                            $('#taxIncludeViewInvoice').prop('checked', false);
                            $('#gstVInvoice').val('');
                        }

                        let str = value["products"];
                        
                        let sno = 0;

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value){
                            $('#productTableVInvoice tbody').append('<tr class="child">\
                                    <td>'+ ++sno +'</td>\
                                    <td class="product_nameEInvoice">'+value["product_name"]+'</td>\
                                    <td class="product_categoryEInvoice">'+value["category"]+'</td>\
                                    <td class="product_varientEInvoice">'+value["product_varient"]+'</td>\
                                    <td class="sku_CodeEInvoice">'+value["sku_code"]+'</td>\
                                    <td class="batch_CodeEInvoice">'+value["batch_code"]+'</td>\
                                    <td class="product_descEInvoice">'+value["description"]+'</td>\
                                    <td class="product_quantityEInvoice">'+value["quantity"]+'</td>\
                                    <td class="unit_priceEInvoice">'+value["unitPrice"]+'</td>\
                                    <td class="taxesEInvoice" style="display:none;">'+value["taxes"]+'</td>\
                                    <td class="subtotalEInvoice">'+value["subTotal"]+'</td>\
                                    <td class="netAmountEInvoice">'+value["netAmount"]+'</td>\
                                </tr>');
                        });
                        jQuery("#delInvoiceAlert").hide();
                        jQuery(".alert-danger").hide();
                        jQuery("#addInvoiceAlert").hide();
                        jQuery("#editInvoiceAlert").hide();

                        //pdf data
                        //$('#invoice_pdf_no').html(value["id"]);
                        
                    });
                }
            });
        }
    });
    // end here    


    // delete a single invoice using id
    $(document).on("click", "a[name = 'removeConfirmSalesInvoice']", function (e){
        let id = $(this).data("id");
        delInvoice(id);
        function delInvoice(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveInvoice')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    sales_invoice_main_table.ajax.reload();
                    successMsg(response.success);
                    $("#removeModalSalesInvoice .close").click();
                }
            });
        }
    });

    // filter invoice number
    function salesInvoiceFilter(){
        $status = $('#selectInvoiceStatus').val();
        $('#salesInvoiceName1').val('');

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-FilterInvoice') }}",
            data : {
                "status" : $status,
            },

            success : function (response){
                let i = 0;
                jQuery('.invoice-list').html('');
                jQuery.each(response.data, function (key, value){
                    $('.invoice-list').append('<tr>\
                        <td class=" border border-secondary">'+ ++i +'</td>\
                        <td class=" border border-secondary">'+ ((value["quot_no"] != null)?value["quot_no"]:"--") +'</td>\
                        <td class=" border border-secondary">'+ ((value["inv_no"] != null)?value["inv_no"]:"--") +'</td>\
                        <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class=" border border-secondary">'+ ((value["due_date"] != null)?value["due_date"]:"--") +'</td>\
                        <td class=" border border-secondary">'+ value["customer_name"] +'</td>\
                        <td class=" border border-secondary">'+ value["status"] +'</td>\
                        <td class=" border border-secondary"><a name="viewInvoice" data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewInvoice"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:'+ value["display"] +'" class=" border border-secondary"><a name="editInvoice" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editInvoice"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td style="display:'+ value["display"] +'" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesInvoice" name="deleteInvoice" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });
                $('.sales-invoice-pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.sales-invoice-pagination-refs').append(
                                    '<li id="search_sales_invoice_pagination1" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                });
                getInvoiceNo();
            }
        });

       // pagination links css and access page
       $(function() {
            $(document).on("click", "#search_sales_invoice_pagination1 a", function() {
            //get url and make final url for ajax 
            var url = $(this).attr("href");
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append+"status="+$('#selectInvoiceStatus').val();

            $.get(finalURL, function(response) {
                let i = response.from;

                jQuery('.invoice-list').html('');
                $('.sales-invoice-main-table').html('Total Invoices : '+response.total);
                    jQuery.each(response.data, function (key, value){
                        
                        $('.invoice-list').append('<tr>\
                            <td class=" border border-secondary">'+ i++ +'</td>\
                            <td class=" border border-secondary">'+ ((value["quot_no"] != null)?value["quot_no"]:"--") +'</td>\
                            <td class=" border border-secondary">'+ ((value["inv_no"] != null)?value["inv_no"]:"--") +'</td>\
                            <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
                            <td class=" border border-secondary">'+ ((value["due_date"] != null)?value["due_date"]:"--") +'</td>\
                            <td class=" border border-secondary">'+ value["customer_name"] +'</td>\
                            <td class=" border border-secondary">'+ value["status"] +'</td>\
                            <td class=" border border-secondary"><a name="viewInvoice" data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewInvoice"> <i class="mdi mdi-eye"></i> </a></td>\
                            <td style="display:'+ value["display"] +'" class=" border border-secondary"><a name="editInvoice" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editInvoice"> <i class="mdi mdi-pencil"></i> </a></td>\
                            <td style="display:'+ value["display"] +'" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesInvoice" name="deleteInvoice" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                $('.sales-invoice-pagination-refs').html('');
                jQuery.each(response.links, function (key, value){
                    $('.sales-invoice-pagination-refs').append(
                        '<li id="search_sales_invoice_pagination1" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                    );
                    });
                });
                return false;
            });
        });
        // end here          

    }

    $(document).ready(function(){
        $('#resetSalesInvoiceFilter').click(function(){
            $('#selectInvoiceStatus').prop('selectedIndex',0);
            $('#salesInvoiceName1').val('');
            sales_invoice_main_table.ajax.reload();
        });
    });

    // filter
    function salesInvoiceFilterName1(){
        let user = $('#salesInvoiceName1').val();
        $('#selectInvoiceStatus').val('');

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-FilterInvoiceName') }}",
            data : {
                "user" : user,
            },
            success : function (response){
                
                let i = 0;
                jQuery('.invoice-list').html('');
                $('.sales-invoice-main-table').html('Total Invoices : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.invoice-list').append('<tr>\
                        <td class=" border border-secondary">'+ ++i +'</td>\
                        <td class=" border border-secondary">'+ ((value["quot_no"] != null)?value["quot_no"]:"--") +'</td>\
                        <td class=" border border-secondary">'+ ((value["inv_no"] != null)?value["inv_no"]:"--") +'</td>\
                        <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class=" border border-secondary">'+ ((value["due_date"] != null)?value["due_date"]:"--") +'</td>\
                        <td class=" border border-secondary">'+ value["customer_name"] +'</td>\
                        <td class=" border border-secondary">'+ value["status"] +'</td>\
                        <td class=" border border-secondary"><a name="viewInvoice" data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewInvoice"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:'+ value["display"] +'" class=" border border-secondary"><a name="editInvoice" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editInvoice"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td style="display:'+ value["display"] +'" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesInvoice" name="deleteInvoice" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.sales-invoice-pagination-refs').html('');
                            jQuery.each(response.links, function (key, value){
                                $('.sales-invoice-pagination-refs').append(
                                    '<li id="search_sales_invoice_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                                );
                });
                // getInvoiceNo();
                
            }
        });

        // pagination links css and access page
        $(function() {
            $(document).on("click", "#search_sales_invoice_pagination a", function() {
            //get url and make final url for ajax 
            var url = $(this).attr("href");
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append+"user="+$('#salesInvoiceName').val();

            $.get(finalURL, function(response) {
                let i = response.from;


                jQuery('.invoice-list').html('');
                $('.sales-invoice-main-table').html('Total Invoices : '+response.total);
                    jQuery.each(response.data, function (key, value){
                        
                        $('.invoice-list').append('<tr>\
                            <td class=" border border-secondary">'+ i++ +'</td>\
                            <td class=" border border-secondary">'+ ((value["quot_no"] != null)?value["quot_no"]:"--") +'</td>\
                            <td class=" border border-secondary">'+ ((value["inv_no"] != null)?value["inv_no"]:"--") +'</td>\
                            <td class=" border border-secondary">'+ value["invoice_date"] +'</td>\
                            <td class=" border border-secondary">'+ ((value["due_date"] != null)?value["due_date"]:"--") +'</td>\
                            <td class=" border border-secondary">'+ value["customer_name"] +'</td>\
                            <td class=" border border-secondary">'+ value["status"] +'</td>\
                            <td class=" border border-secondary"><a name="viewInvoice" data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewInvoice"> <i class="mdi mdi-eye"></i> </a></td>\
                            <td style="display:'+ value["display"] +'" class=" border border-secondary"><a name="editInvoice" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editInvoice"> <i class="mdi mdi-pencil"></i> </a></td>\
                            <td style="display:'+ value["display"] +'" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesInvoice" name="deleteInvoice" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                $('.sales-invoice-pagination-refs').html('');
                jQuery.each(response.links, function (key, value){
                    $('.sales-invoice-pagination-refs').append(
                        '<li id="search_sales_invoice_pagination" class="page-item '+((value.active===true)? 'active': '')+'"><a class="page-link" href="'+value['url']+'" >'+value["label"]+'</a></li>'
                    );
                    });
                });
                return false;
            });
        });
        // end here  

    }

                $(document).on("click", "a[name = 'deleteInvoice']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedSalesInvoice').data('id', id);
                });    

</script>

        <div class="modal fade" id="removeModalSalesInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmSalesInvoice" class="btn btn-primary" id="confirmRemoveSelectedSalesInvoice">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>