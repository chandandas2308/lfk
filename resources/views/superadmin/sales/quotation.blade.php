<div class="p-3">
    <!-- invoice Tab -->
    <div class="page-header flex-wrap">
        <style>
            .pointer {
                cursor: pointer !important;
            }

            .search {
                width: 240px;
            }

            .pointer {
                animation: blinker 1s linear infinite;
            }

            @keyframes blinker {
                50% {
                    opacity: 0;
                }
            }
        </style>
        <!--  -->
        <h4 class="mb-0">
            Quotation Tab
        </h4>
        <!--  -->
        <div class="d-flex">
            <a href="#" onclick="jQuery('#delQuotationAlert').hide()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#createQuotation"> Create Quotation </a>
        </div>

    </div>
    <!-- alert section -->
    <div class="alert alert-success alert-dismissible fade show" id="delQuotationAlert" style="display:none" role="alert">
        <strong>Info ! </strong> <span id="delQuotationAlertMSG"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- alert section end-->

    <!-- table start -->
    <table class="text-center table table-bordered" id="sales_quotation_main_table">
                        <thead class="fw-bold text-dark">
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
</div>

<!-- Create Invoice Model -->
@include('superadmin.sales.quotation-modal.createQuotation')
@include('superadmin.sales.quotation-modal.editQuotation')
@include('superadmin.sales.quotation-modal.viewQuotation')
<!-- Model -->

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>

    $(document).ready(function() {
        sales_quotation_main_table = $('#sales_quotation_main_table').DataTable({
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
                url: "{{ route('SA-GetQuotations') }}",
                type: 'GET',
            }
        });
        $(document).find('#sales_quotation_main_table').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });

    // edit quotation details
    $(document).on("click", "a[name = 'editQuotation']", function(e) {

        let id = $(this).data("id");
        jQuery("#productTableBodyQE").html('');
        getQuotationInfo(id);

        function getQuotationInfo(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetQuotation1')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {

                        editQuotationFilterProducts(value["customer_id"]);

                        $('#quotationId').val(value["id"]);
                        $('#customerNameQEdit').val(value["customer_id"]);
                        $('#qCustomer_nameEdit').val(value["customer_name"]);
                        $('#expirationQE').val(value["expiration"]);
                        $('#customerAddressQE').val(value["customer_address"]);
                        $('#paymentTermsQE').val(value["payment_terms"]);
                        $('#untaxtedAmountQE').val(value["untaxted_amount"]);
                        $('#untaxtedAmountQE1').val(value["untaxted_amount"]);
                        $('#gstQE').val(value["GST"]);
                        $('#gstQE1').val(value["GST"]);
                        $('#gstValueEdit').val(value["gstValue"]);
                        $('#quotationTotalQE').val(value["sub_total"]);
                        $('#quotationTotalQE1').val(value["sub_total"]);
                        $('#notesQE').val(value['note']);

                        if (value["tax_inclusive"] == 1) {
                            $('#taxIncludeQEdit').prop('checked', true);
                        } else {
                            $('#taxIncludeQEdit').prop('checked', false);
                            $('#gstQE').val('');
                        }

                        let sno = 0;

                        let str = value["products_details"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value) {
                            $('#productsTableQE tbody').append('<tr class="child">\
                                    <td>' + ++sno + '</td>\
                                    <td class="product_Id" style="display:none;">' + value["product_Id"] + '</td>\
                                    <td class="product_name">' + value["product_name"] + '</td>\
                                    <td class="product_category">' + value["category"] + '</td>\
                                    <td class="product_varient">' + value["product_varient"] + '</td>\
                                    <td class="sku_code">' + value["sku_code"] + '</td>\
                                    <td class="batch_code">' + value["batch_code"] + '</td>\
                                    <td class="product_desc">' + value["description"] + '</td>\
                                    <td class="product_quantity">' + value["quantity"] + '</td>\
                                    <td class="unit_price">' + value["unitPrice"] + '</td>\
                                    <td class="taxes" style="display:none;" >' + value["taxes"] + '</td>\
                                    <td class="subtotal">' + value["subTotal"] + '</td>\
                                    <td class="netAmountQE">' + value["netAmount"] + '</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="remCF1QE">\
                                            <i class="mdi mdi-delete"></i>\
                                        </a>\
                                    </td>\
                                </tr>');
                        });

                        if ($('#taxIncludeQEdit').prop('checked')) {} else {
                            $('#gstQE').style('display', 'none');
                        }

                        jQuery("#delQuotationAlert").hide();
                        jQuery(".alert-danger").hide();
                        jQuery("#addQuotationAlert").hide();
                        jQuery("#editQuotationAlert").hide();
                    });
                }
            });
        }
    });


    // view quotation detials
    $(document).on("click", "a[name = 'viewQuotation']", function(e) {

        console.log('view fn called');

        let id = $(this).data("id");
        jQuery("#productTableBodyVQ").html('');
        getQuotationInfo(id);

        function getQuotationInfo(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetQuotation1')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#customerNameVQ').val(value["customer_name"]);
                        $('#expirationVQ').val(value["expiration"]);
                        $('#customerAddressVQ').val(value["customer_address"]);
                        $('#paymentTermsVQ').val(value["payment_terms"]);
                        $('#untaxtedAmountVQ').val(value["untaxted_amount"]);
                        $('#untaxtedAmountVQ1').val(value["untaxted_amount"]);
                        $('#quotation_download_btn').attr("href", "/admin/generate-q-pdf/" + value['id']);
                        $('#gstVQ').val(value["GST"]);
                        $('#gstVQ1').val(value["GST"]);
                        $('#gstValueView').val(value["gstValue"]);
                        $('#quotationTotalVQ').val(value["sub_total"]);
                        $('#quotationTotalVQ1').val(value["sub_total"]);
                        $('#notesVQ').val(value['note']);


                        if (value["tax_inclusive"] == 1) {
                            $('#taxIncludeVQ').prop('checked', true);
                        } else {
                            $('#taxIncludeVQ').prop('checked', false);
                            $('#gstVQ').val('');
                        }

                        let sno = 0;

                        let str = value["products_details"];

                        let obj = JSON.parse(str);


                        jQuery.each(obj, function(key, value) {
                            $('#productsTableVQ tbody').append('<tr class="child">\
                                        <td>' + ++sno + '</td>\
                                        <td class="product_name">' + value["product_name"] + '</td>\
                                        <td class="product_category">' + value["category"] + '</td>\
                                        <td class="product_varient">' + value["product_varient"] + '</td>\
                                        <td class="sku_code">' + value["sku_code"] + '</td>\
                                        <td class="batch_code">' + value["batch_code"] + '</td>\
                                        <td class="product_desc">' + value["description"] + '</td>\
                                        <td class="product_quantity">' + value["quantity"] + '</td>\
                                        <td class="unit_price">' + value["unitPrice"] + '</td>\
                                        <td class="taxes" style="display:none;">' + value["taxes"] + '</td>\
                                        <td class="subtotal">' + value["subTotal"] + '</td>\
                                        <td class="netAmountVQ">' + value["netAmount"] + '</td>\
                                    </tr>');
                        });

                        jQuery("#delQuotationAlert").hide();
                        jQuery(".alert-danger").hide();
                        jQuery("#addQuotationAlert").hide();
                        jQuery("#editQuotationAlert").hide();

                    });
                }
            });
        }
    });

    // delete a single quotation using id
    $(document).on("click", "a[name = 'removeConfirmSalesQuotation']", function(e) {
        let id = $(this).data("id");
        delPayment(id);

        function delPayment(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RemoveQuotation')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    sales_quotation_main_table.ajax.reload();
                    $("#removeModalSalesQuotation .close").click();
                    getQuotationDetailsorder();
                }
            });
        }
    });
    // delete a single quotation using id
    $(document).on("click", "a[name = 'statusConfirmSalesQuotation']", function(e) {
        let id = $(this).data("id");
        delPayment(id);

        function delPayment(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-statusQuotation')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    $("#statusModalSalesQuotation .close").click();
                    sales_quotation_main_table.ajax.reload();
                    sales_order_main_table.ajax.reload();

                    getQuotationDetails();
                    getQuotationDetailsorder();

                }
            });
        }
    });

    // filter
    function salesQuotationFilterSer() {

        $user = $('#salesQuotation').val();
        $.ajax({
            type: "GET",
            url: "{{ route('SA-SalesQuotationFilter') }}",
            data: {
                "user": $user,
            },
            success: function(response) {

                let i = 0;
                $('.quotation-list').html('');
                $('.sales-quotation-main-table').html('Total Quotations : ' + response.total);
                jQuery.each(response.data, function(key, value) {
                    $('.quotation-list').append('<tr>\
                        <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["quotation_id"] + '</td>\
                        <td class="border border-secondary">' + value['customer_name'] + '</td>\
                        <td class="border border-secondary">' + parseFloat(value["sub_total"]).toFixed(2) + '</td>\
                        <td class="border border-secondary">' + parseFloat(value["sub_total"]).toFixed(2) + '</td>\
                        <td class="border border-secondary">' + value["expiration"] + '</td>\
                        <td class="border border-secondary">' + parseFloat(value["sub_total"]).toFixed(2) + '</td>\
                        <td class="border border-secondary">' + value["payment_terms"] + '</td>\
                        <td class="border border-secondary">\
                            ' + ((value["status"] != "Pending") ? "Confirmed" : '<a class="' + $status + '" data-toggle="modal" data-target="#statusModalSalesQuotation" name="statusQuotation" data-id="' + value["id"] + '" >' + value["status"] + '</a>') + '\
                        </td>\
                        <td class="border border-secondary"><a name="viewQuotation"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewQuotation"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a name="editQuotation" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editQuotation"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesQuotation" name="deleteQuotation" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.sales-quotation-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.sales-quotation-pagination-refs').append(
                        '<li id="search_sales_quotation_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                    );
                });

            }
        });

        // pagination links css and access page
        $(function() {
            $(document).on("click", "#search_sales_quotation_pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append + "user=" + $('#salesQuotation').val();

                $.get(finalURL, function(response) {
                    let i = 0;
                    jQuery('.quotation-list').html('');
                    $('.sales-quotation-main-table').html('Total Quotations : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.quotation-list').append('<tr>\
                        <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["quotation_id"] + '</td>\
                        <td class="border border-secondary">' + value['customer_name'] + '</td>\
                        <td class="border border-secondary">' + parseFloat(value["sub_total"]).toFixed(2) + '</td>\
                        <td class="border border-secondary">' + parseFloat(value["sub_total"]).toFixed(2) + '</td>\
                        <td class="border border-secondary">' + value["expiration"] + '</td>\
                        <td class="border border-secondary">' + parseFloat(value["sub_total"]).toFixed(2) + '</td>\
                        <td class="border border-secondary">' + value["payment_terms"] + '</td>\
                        <td class="border border-secondary">\
                            ' + ((value["status"] != "Pending") ? "Confirmed" : '<a class="' + $status + '" data-toggle="modal" data-target="#statusModalSalesQuotation" name="statusQuotation" data-id="' + value["id"] + '" >' + value["status"] + '</a>') + '\
                        </td>\
                        <td class="border border-secondary"><a name="viewQuotation"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewQuotation"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a name="editQuotation" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editQuotation"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesQuotation" name="deleteQuotation" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                    });

                    $('.sales-quotation-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.sales-quotation-pagination-refs').append(
                            '<li id="search_sales_quotation_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                        );
                    });
                });
                return false;
            });
        });
        // end here   

    }

    $(document).on("click", "a[name = 'deleteQuotation']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveSelectedSalesQuotation').data('id', id);
    });
    $(document).on("click", "a[name = 'statusQuotation']", function(e) {
        let id = $(this).data("id");
        $('#confirmstatusSelectedSalesQuotation').data('id', id);
    });
</script>

<div class="modal fade" id="removeModalSalesQuotation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a name="removeConfirmSalesQuotation" class="btn btn-primary" id="confirmRemoveSelectedSalesQuotation">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="statusModalSalesQuotation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Confirm Alert</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">DO YOU WANT TO CONFIRM THIS QUOTATION?<span id="statusElementId"></span> </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                <a name="statusConfirmSalesQuotation" class="btn btn-primary" id="confirmstatusSelectedSalesQuotation">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>