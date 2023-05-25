    <!--  -->
    <style>
        .required-field::before {
            content: "*";
            color: red;
            float: right;
        }

        a{
            cursor: pointer!important;
        }

        .search {
            width: 210px;
        }
    </style>

    <div class="p-3">
        <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Retail Customer
            </h4>
            <div class="d-flex">
                <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addRetailCustomer"> Add Customer </a>
            </div>
        </div>

        <!-- table start -->
        <div class="table-responsive">
            <table class="text-center table table-responsive table-bordered" id="retail_customer_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Phone Number</th>
                        <th class="text-center">Email ID</th>
                        <th class="text-center">Postal Code</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Unit</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- table end here -->
    </div>

    <!-- Model -->
    @include('superadmin.customer-modal.addRetailCustomer')
    @include('superadmin.customer-modal.viewRetailCustomer')

    <div class="modal fade" id="addRetailCustomerOrderDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content p-2" id="showRetailCustomerOrderDetails">
            </div>
        </div>
    </div>


    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- // backend js file -->

    <script>

        $(document).ready(function(){
            @if(session('status'))
                toastr.success("{{ session('status') }}");
            @endif
        });

        $(document).ready(function() {
            retail_customer_table = $('#retail_customer_table').DataTable({
                "aaSorting": [],
                "bDestroy": true,
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: false,
                // "scrollX": true,
                dom: "Bfrtip",
                pageLength: 10,
                buttons: [],
                ajax: {
                    url: "{{ route('SA-RetailCustomer') }}",
                    type: 'GET',
                }
            });
        });

        // add order for retail customer
        $(document).on("click", "a[name = 'addRCustomerOrder']", function(e) {
            let id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RetailCustomerOrder')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    $('#showRetailCustomerOrderDetails').html(response);
                }
            });
        });

        // view single customer details
        $(document).on("click", "a[name = 'viewCustomer']", function(e) {
            let id = $(this).data("id");
            viewCustomerInfo(id);

            function viewCustomerInfo(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-SingleRetailCustomer')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        
                        jQuery.each(response.customer, function(key, value) {
                            $('#customerViewName12').val(value["customer_name"]);
                            $('#customerViewPhNo12').val(value["phone_number"]);
                            $('#CustomerViewMobNo12').val(value["mobile_number"]);
                            $('#CustomerViewEmailId12').val(value["email_id"]);
                            $('#CustomerViewPostal12').val(value["postal_code"]);
                            $('#CustomerViewAddress12').val(value["address"]);
                            $('#CustomerViewUnit12').val(value["unit_number"]);
                            $('#viewRetailCustomerId').val(value["id"]);
                            $('#blockCustomer').val(value["status"]);
                        });
                        $('#CustomerViewPoints12').val(response.points);
                    }
                });

                $(document).ready(function() {
                    addresses = $('#invoice_details_table120').DataTable({
                        "aaSorting": [],
                        rowReorder: {
                            selector: 'td:nth-child(2)'
                        },
                        pageLength: 5,
                        // responsive: 'false',
                        dom: "Bfrtip",
                        "bDestroy": true,
                        buttons: [],
                        ajax: {
                            url: "{{ route('SA-FetchRetailCustomerWiseProduct')}}",
                            type: 'get',
                            data: {
                                id: id
                            }
                        },
                    })
                });

            }
        });


        // delete a single customer detials using id
        $(document).on("click", "a[name = 'removeConfirmCustomerManagement']", function(e) {
            let id = $(this).data("id");
            delCustomer(id);

            function delCustomer(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-RemoveCustomer')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        jQuery("#delCustomerAlert1").show();
                        jQuery("#delCustomerAlertMSG1").html(response.success);
                        retail_customer_table.ajax.reload();
                        $("#removeModalCustomerManagement1 .close").click();
                    }
                });
            }
        });

        // filter
        function customerManagementFilter1() {
            $user = $('#customerManagement1').val();
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RetailCustomerFilter') }}",
                data: {
                    "user": $user,
                },
                success: function(response) {

                    let i = 0;
                    jQuery('.customer-details1').html('');
                    $('.customer-management-main-main-table1').html('Total resutls : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.customer-details1').append('<tr>\
                    <td class="p-2 border border-secondary">' + ++i + '</td>\
                        <td class="p-2 border border-secondary">' + value["customer_name"] + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["mobile_number"] != null) ? ((value["mobile_number"] != 0) ? value["mobile_number"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["email_id"] != null) ? ((value["email_id"] != 0) ? value["email_id"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["postal_code"] != null) ? ((value["postal_code"] != 0) ? value["postal_code"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["address"] != null) ? ((value["address"] != 0) ? value["address"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["unit_number"] != null) ? ((value["unit_number"] != 0) ? value["unit_number"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary"><a name="viewCustomer" data-toggle="modal" data-id="' + value["customer_id"] + '" data-target="#viewRetailCustomerDetails"> <i class="mdi mdi-eye"></i> </a></td>\
                    </tr>');
                    });
                    $('.customer-management-main-pagination-refs1').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.customer-management-main-pagination-refs1').append(
                            '<li id="search_customer_management_main_pagination2" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
                        );
                    });
                }
            });

            // pagination links css and access page
            $(function() {
                $(document).on("click", "#search_customer_management_main_pagination2 a", function() {
                    //get url and make final url for ajax
                    var url = $(this).attr("href");
                    var append = url.indexOf("?") == -1 ? "?" : "&";
                    var finalURL = url + append + "&user=" + $('#customerManagement1').val();

                    $.get(finalURL, function(response) {
                        let i = response.from;
                        jQuery('.customer-details1').html('');
                        $('.customer-management-main-main-table1').html('Total resutls : ' + response.total);
                        jQuery.each(response.data, function(key, value) {
                            $('.customer-details1').append('<tr>\
                            <td class="p-2 border border-secondary">' + ++i + '</td>\
                        <td class="p-2 border border-secondary">' + value["customer_name"] + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["mobile_number"] != null) ? ((value["mobile_number"] != 0) ? value["mobile_number"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["email_id"] != null) ? ((value["email_id"] != 0) ? value["email_id"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["postal_code"] != null) ? ((value["postal_code"] != 0) ? value["postal_code"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["address"] != null) ? ((value["address"] != 0) ? value["address"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["unit_number"] != null) ? ((value["unit_number"] != 0) ? value["unit_number"] : '--') : '--') + '</td>\
                        <td class="p-2 border border-secondary"><a name="viewCustomer" data-toggle="modal" data-id="' + value["customer_id"] + '" data-target="#viewRetailCustomerDetails"> <i class="mdi mdi-eye"></i> </a></td>\
                                </tr>');
                        });
                        $('.customer-management-main-pagination-refs1').html('');
                        jQuery.each(response.links, function(key, value) {
                            $('.customer-management-main-pagination-refs1').append(
                                '<li id="search_customer_management_main_pagination2" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
                            );
                        });
                    });
                    return false;
                });
            });
            // end here
        }

        $(document).on("click", "a[name = 'deleteCustomer1']", function(e) {
            let id = $(this).data("id");
            $('#confirmRemoveSelectedCustomerManagement1').data('id', id);
        });


        $(document).ready(function() {
                @if($errors->any())
                    toastr.error("{{ implode('', $errors->all(':message')) }}");
                @endif
                @if(session('success'))
                    toastr.success("{{ session('success') }}");
                @endif
            });

    </script>

    <!-- End here -->

    <!-- </div> -->

    <div class="modal fade" id="removeModalCustomerManagement1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <a name="removeConfirmCustomerManagement" class="btn btn-primary" id="confirmRemoveSelectedCustomerManagement1">
                        YES
                    </a>
                </div>
            </div>
        </div>
    </div>