<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Payments Tab
            </h4>
            <div class="d-flex">
                <a href="#" onclick="jQuery('#delPaymentAlert').hide()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addPayment"> Add Payment </a>
            </div>
        </div>

        <!-- table start -->
        <table class="text-center table table-bordered" id="payment_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Invoice No.</th>
                        <th class="text-center">Invoice Date</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Partial Amount</th>
                        <th class="text-center">Balance Amount</th>
                        <th class="text-center">Payment Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>

</div>

<!-- Model -->
@include('superadmin.sales.payment-modal.editPayment')
@include('superadmin.sales.payment-modal.addPayment')
@include('superadmin.sales.payment-modal.viewPayment')
@include('superadmin.customer-modal.addCustomer')


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
        payment_main_table = $('#payment_main_table').DataTable({
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
                url: "{{ route('SA-GetPaymentList') }}",
                type: 'GET',
            }
        });
        $(document).find('#payment_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });


    $(document).ready(function(){
        getInvoiceNo();
        // getPaymentDetials();
    });

    // get invoice number
    function getInvoiceNo(){
        $.ajax({
            type : "GET" ,
            url : "{{route('SA-GetAllInvoiceForPayment')}}",
            success : function(response){

                // console.log(response);

                $('#chooseCustomerName').html('');
                $('#chooseCustomerName').append('<option value="">Select Customer</option>');
                $('#customerNameEditOnPayment').html('');
                $('#customerNameEditOnPayment').append('<option value="">Select Customer</option>');

                    jQuery.each(response, function(key, value){

                        $('#chooseCustomerName').append(
                            '<option value="'+value['customer_id']+'">'+value['customer_name']+'</option>'
                        );
                        
                        $('#customerNameEditOnPayment').append(
                            '<option value="'+value['customer_id']+'">'+value['customer_name']+'</option>'
                        );

                    });
            }
        });
    }

    // edit payment
    // get a single payment
    $(document).on("click", "a[name = 'editPayment']", function (e){
        let id = $(this).data("id");
        getPaymentInfo(id);
        function getPaymentInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetPaymentDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    console.log(response);
                    jQuery.each(response, function(key, value){
                        $('#editFormId').val(value["id"]);
                        $('#customerNameEditOnPayment').val(value["customer_id"]);
                        $('#customer_id_payment_on_edit').val(value["customer_name"]);
                        $('#editInvoiceNoPayments').val(value["invoice_no"]);
                        $('#editAmount').val(value["amount"]);
                        $('#editAmount2').val(value["amount"]);
                        $('#editpartialamount').val(value["partialamount"]);
                        $('#editpartialamount2').val(value["partialamount"]);
                        $('#editPaymentDate').val(value["payment_date"]);
                        $('#editPaymentDate').val(value["payment_date"]);
                        $('#editinvoicedaate').val(value["invoice_date"]);
                        $('#editPaymentStatusSales').val(value["payment_status"]);
                        $('#editPaymentType').val(value['payment_type']);
                    });
                    jQuery("#delPaymentAlert").hide();
                    jQuery(".alert-danger").hide();
                    jQuery("#addPaymentAlert").hide();
                    jQuery("#editPaymentAlert").hide();
                }
            });
        }
    });


    // view a single payment
    $(document).on("click", "a[name = 'viewPayment']", function (e){
        let id = $(this).data("id");
        viewPaymentInfo(id);
        function viewPaymentInfo(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-GetPaymentDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    jQuery.each(response, function(key, value){
                        $('#viewInvoiceNo').val(value["invoice_no"]);
                        $('#view_customer_name').val(value["customer_name"]);
                        $('#viewAmount').val(value["amount"]);
                        $('#viewPaymentDate').val(value["payment_date"]);
                        $('#viewPaymentType').val(value["payment_type"]);
                        $('#viewPaymentStatus').val(value["payment_status"]);
                    });
                    jQuery("#delPaymentAlert").hide();
                    jQuery(".alert-danger").hide();
                    jQuery("#addPaymentAlert").hide();
                    jQuery("#editPaymentAlert").hide();
                }
            });
        }
    });

    // delete a single payment using id
    $(document).on("click", "a[name = 'removeConfirmSalesPayment']", function (e){
        let id = $(this).data("id");
        delPayment(id);
        function delPayment(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemovePaymentDetails')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    successMsg(response.success);
                    payment_main_table.ajax.reload();
                    jQuery(".alert-danger").hide();
                    jQuery("#addPaymentAlert").hide();
                    jQuery("#editPaymentAlert").hide();

                    $("#removeModalSalesPayment .close").click();

                }
            });
        }
    });

    // filter payments
     function salesPaymentFilter(){
        $status = $('#selectSalesPaymentStatus').val();
        $('#paymentCustomerName').val('');

        // console.log($status);

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-FilterPaymentDetails') }}",
            data : {
                "status" : $status,
            },
            success : function (response){
                // console.log(response);
                let i = 0;
                jQuery('.payment-details').html('');
                jQuery.each(response.data, function (key, value){
                    $('.payment-details').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["inv_no"] +'</td>\
                        <td class="border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class="border border-secondary">'+ value['customer_name'] +'</td>\
                        <td class="border border-secondary">'+ value["payment_date"] +'</td>\
                        <td class="border border-secondary">'+ value["amount"] +'</td>\
                        <td class="border border-secondary">'+ ((value["partialamount"] != null)?value["partialamount"]:"--") +'</td>\
                        <td class="border border-secondary"> '+ ((value["pending_amt"] != null)?value["pending_amt"]:'--') +' </td>\
                        <td class="border border-secondary">'+ value["payment_type"] +'</td>\
                        <td class="border border-secondary">'+ value["payment_status"] +'</td>\
                        <td class="border border-secondary"><a name="viewPayment"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewPayment"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editPayment" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editPayment"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deletePayment" data-toggle="modal" data-target="#removeModalSalesPayment" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.payment-pagination-refs').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.payment-pagination-refs').append(
                            '<li id="search_payment_pagination3" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                        );
                    });
            }
        });

    $(function() {
      $(document).on("click", "#search_payment_pagination3 a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append+"status="+$('#selectSalesPaymentStatus').val();

        $.get(finalURL, function(response) {
            let i = response.from;
            jQuery('.payment-details').html('');
            $('.payment-main-table').html('Total payments : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.payment-details').append('<tr>\
                        <td class="border border-secondary">'+ i++ +'</td>\
                        <td class="border border-secondary">'+ value["inv_no"] +'</td>\
                        <td class="border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class="border border-secondary">'+ value['customer_name'] +'</td>\
                        <td class="border border-secondary">'+ value["payment_date"] +'</td>\
                        <td class="border border-secondary">'+ value["amount"] +'</td>\
                        <td class="border border-secondary">'+ ((value["partialamount"] != null)?value["partialamount"]:"--") +'</td>\
                        <td class="border border-secondary"> '+ ((value["pending_amt"] != null)?value["pending_amt"]:'--') +' </td>\
                        <td class="border border-secondary">'+ value["payment_type"] +'</td>\
                        <td class="border border-secondary">'+ value["payment_status"] +'</td>\
                        <td class="border border-secondary"><a name="viewPayment"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewPayment"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editPayment" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editPayment"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deletePayment" data-toggle="modal" data-target="#removeModalSalesPayment" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');                 
                });

                $('.payment-pagination-refs').html('');
                jQuery.each(response.links, function (key, value){
                    $('.payment-pagination-refs').append(
                        '<li id="search_payment_pagination3" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here  


    }

    $(document).ready(function(){
        $('#resetSalesPaymentFilter').click(function(){
            $('#paymentCustomerName').val('');
            $('#selectSalesPaymentStatus').prop('selectedIndex',0);
            sales_invoice_main_table.ajax.reload();
        });
    });


     // filter
     function salesInvoiceFilterName2(){
        $user = $('#paymentCustomerName').val();
        $('#selectSalesPaymentStatus').val('');

        $.ajax({
            type : "GET" ,
            url : "{{ route('SA-GetPaymentFilter') }}",
            data : {
                "user" : $user,
            },
            success : function (response){
                
                let i = 0;
                jQuery('.payment-details').html('');
                $('.payment-main-table').html('Total payments : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.payment-details').append('<tr>\
                        <td class="border border-secondary">'+ ++i +'</td>\
                        <td class="border border-secondary">'+ value["inv_no"] +'</td>\
                        <td class="border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class="border border-secondary">'+ value['customer_name'] +'</td>\
                        <td class="border border-secondary">'+ value["payment_date"] +'</td>\
                        <td class="border border-secondary">'+ value["amount"] +'</td>\
                        <td class="border border-secondary">'+ ((value["partialamount"] != null)?value["partialamount"]:"--") +'</td>\
                        <td class="border border-secondary"> '+ ((value["pending_amt"] != null)?value["pending_amt"]:'--') +' </td>\
                        <td class="border border-secondary">'+ value["payment_type"] +'</td>\
                        <td class="border border-secondary">'+ value["payment_status"] +'</td>\
                        <td class="border border-secondary"><a name="viewPayment"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewPayment"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editPayment" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editPayment"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deletePayment" data-toggle="modal" data-target="#removeModalSalesPayment" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                    $('.payment-pagination-refs').html('');
                    jQuery.each(response.links, function (key, value){
                        $('.payment-pagination-refs').append(
                            '<li id="search_payment_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                        );
                    });
                
            }
        });

            // pagination links css and access page
    $(function() {
      $(document).on("click", "#search_payment_pagination a", function() {
        //get url and make final url for ajax 
        var url = $(this).attr("href");
        var append = url.indexOf("?") == -1 ? "?" : "&";
        var finalURL = url + append+"user="+$('#paymentCustomerName').val();

        $.get(finalURL, function(response) {
            let i = response.from;
            jQuery('.payment-details').html('');
            $('.payment-main-table').html('Total payments : '+response.total);
                jQuery.each(response.data, function (key, value){
                    $('.payment-details').append('<tr>\
                        <td class="border border-secondary">'+ i++ +'</td>\
                        <td class="border border-secondary">'+ value["inv_no"] +'</td>\
                        <td class="border border-secondary">'+ value["invoice_date"] +'</td>\
                        <td class="border border-secondary">'+ value['customer_name'] +'</td>\
                        <td class="border border-secondary">'+ value["payment_date"] +'</td>\
                        <td class="border border-secondary">'+ value["amount"] +'</td>\
                        <td class="border border-secondary">'+ ((value["partialamount"] != null)?value["partialamount"]:"--") +'</td>\
                        <td class="border border-secondary"> '+ ((value["pending_amt"] != null)?value["pending_amt"]:'--') +' </td>\
                        <td class="border border-secondary">'+ value["payment_type"] +'</td>\
                        <td class="border border-secondary">'+ value["payment_status"] +'</td>\
                        <td class="border border-secondary"><a name="viewPayment"  data-toggle="modal" data-id="'+value["id"]+'"  data-target="#viewPayment"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editPayment" data-toggle="modal" data-id="'+value["id"]+'" data-target="#editPayment"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deletePayment" data-toggle="modal" data-target="#removeModalSalesPayment" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');                 
                });

                $('.payment-pagination-refs').html('');
                jQuery.each(response.links, function (key, value){
                    $('.payment-pagination-refs').append(
                        '<li id="search_payment_pagination" class="page-item '+((value.active===true)? 'active': '')+'" ><a href="'+value['url']+'" class="page-link" >'+value["label"]+'</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here   

    }

                $(document).on("click", "a[name = 'deletePayment']", function (e){
                    let id = $(this).data("id");
                    $('#confirmRemoveSelectedSalesPayment').data('id', id);
                });

</script>

        <div class="modal fade" id="removeModalSalesPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <a name="removeConfirmSalesPayment" class="btn btn-primary" id="confirmRemoveSelectedSalesPayment">
                            YES 
                        </a>
                    </div>
                </div>
            </div>
        </div>