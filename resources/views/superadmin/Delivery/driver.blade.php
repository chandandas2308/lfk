<div class="p-3">
    <!-- invoice Tab -->
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Delivery Man Tab
        </h4>
        <div class="d-flex">
            <a href="#" onclick="jQuery('#deldriverAlert').hide()" class="nav-link bg-addbtn mx-2 rounded"
                data-toggle="modal" data-target="#adddriver"> Add Delivery Driver </a>
        </div>
    </div>

    <!-- alert section -->
    <div class="alert alert-success alert-dismissible fade show" id="deldriverAlert" style="display:none" role="alert">
        <strong>Info ! </strong> <span id="deldriverAlertMSG"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- alert section end-->

    <!-- table start -->
    <!-- <div class="table-responsive"> -->
    <table class="text-center table table-responsive table-bordered" id="driver_main_table1">
        <thead>
            <tr>
                <th class="text-center">S/N</th>
                <th class="text-center">Delivery Man ID</th>
                <th class="text-center">Delivery Man Name</th>
                <th class="text-center">Delivery Man Mobile No.</th>
                <th class="text-center">Delivery Man Email</th>
                <!-- <th class="text-center">Delivery Man Address</th> -->
                <!-- <th class="text-center">Region</th> -->
                <!-- <th class="text-center">Order Delivered</th> -->
                <!-- <th class="text-center">Delivery Man Status</th> -->
                <th class="text-center">Action</th>
            </tr>
        </thead>
    </table>
    <!-- </div> -->

    <!-- table end here -->

</div>


<div class="modal fade" id="viewdriver2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2" id="view_driver_details">
        </div>
    </div>
</div>

<div class="modal fade" id="viewProDetailsDriver" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel2"
    aria-hidden="true">
    <div class="modal-dialog modal-lg bg-white" role="document">
        <div class="modal-content p-2" id="view_pro_details_driver_details">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table id="order_details_driver2" class="text-center table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center">S/N</th>
                            <th style="text-align:center">Product Name</th>
                            <th style="text-align:center">Variant</th>
                            <th style="text-align:center">Quantity</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->


<!-- Model -->
@include('superadmin.Delivery.driver-modal.adddriver')

@include('superadmin.Delivery.driver-modal.editdriver')

<script>
    $(document).ready(function() {
        driver_main_table = $('#driver_main_table1').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // scrollX: true,
            dom: "Bfrtip",
            paging: false,
            // pageLength: 10,
            buttons: [],
            ajax: {
                url: "{{ route('SA-GetdriverList') }}",
                type: 'GET',
            }
        });
        $(document).find('#driver_main_table1').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });

    $(document).ready(function() {
        getInvoiceNo();
    });

    // get invoice number
    function getInvoiceNo() {
        $.ajax({
            type: "GET",
            url: "#",
            success: function(response) {

                $('#chooseCustomerName').html('');
                $('#chooseCustomerName').append('<option value="">Select Customer</option>');
                $('#customerNameEditOndriver').html('');
                $('#customerNameEditOndriver').append('<option value="">Select Customer</option>');

                jQuery.each(response, function(key, value) {

                    $('#chooseCustomerName').append(
                        '<option value="' + value['customer_id'] + '">' + value[
                        'customer_name'] + '</option>'
                    );

                    $('#customerNameEditOndriver').append(
                        '<option value="' + value['customer_id'] + '">' + value[
                        'customer_name'] + '</option>'
                    );

                });
            }
        });
    }

    // edit driver
    // get a single driver
    $(document).on("click", "a[name = 'editdriver']", function(e) {
        let id = $(this).data("id");
        getdriverInfo(id);

        function getdriverInfo(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchDriver') }}",
                data: {
                    'id': id,
                    'status': 1,
                },
                success: function(response) {
                    jQuery.each(response.data, function(key, value) {
                        $('#edit_id').val(value["driver_id"]);
                        $('#editdriver_name').val(value["driver_name"]);
                        $('#editdriver_mobile_no').val(value["driver_mobile_no"]);
                        $('#editdriver_email').val(value["driver_email"]);
                        $('#editdriver_address').val(value["driver_address"]);
                        $('#editRegion').val(value["region"]);
                        $('#editCommission').val(value["commission"]);
                        $('#edit_password').val(value['show_password']);
                    });
                    jQuery("#deldriverAlert").hide();
                    jQuery(".alert-danger").hide();
                    jQuery("#adddriverAlert").hide();
                    jQuery("#editdriverAlert").hide();
                }
            });
        }
    });


    // view a single driver
    $(document).on("click", "a[name = 'viewdriver']", function(e) {
        let id = $(this).data("id");
        viewdriverInfo(id);

        function viewdriverInfo(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-FetchDriver') }}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    $('#view_driver_details').html(`<i class="fa fa-spinner fa-spin"></i>`);
                    $('#view_driver_details').html(response);

                    // jQuery.each(response.data, function(key, value){
                    //     $('#viewdriver_name').val(value["driver_name"]);
                    //     $('#viewdriver_mobile_no').val(value["driver_mobile_no"]);
                    //     $('#viewdriver_email').val(value["driver_email"]);
                    //     $('#viewdriver_address').val(value["driver_address"]);
                    //     $('#viewRegion').val(value["region"]);
                    //     $('#viewCommission').val(value["commission"]);
                    // });

                    // jQuery.each(response.orders, function(key,value){
                    //     $('#assign_delivery_order_no').append(
                    //         `<span class="bg-white p-2 border mt-2">${value["order_no"]}</span>`
                    //     );
                    // });

                    // jQuery("#deldriverAlert").hide();
                    // jQuery(".alert-danger").hide();
                    // jQuery("#adddriverAlert").hide();
                    // jQuery("#editdriverAlert").hide();
                }
            });
        }
    });

    // delete a single driver using id
    $(document).on("click", "a[name = 'removeConfirmSalesdriver']", function(e) {
        let id = $(this).data("id");
        deldriver(id);

        function deldriver(id) {

            $.ajax({
                type: "GET",
                url: "{{ route('SA-RemoveDriver') }}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    $("#removeModalSalesdriver .close").click();
                    driver_main_table.ajax.reload();
                    jQuery(".alert-danger").hide();
                    jQuery("#adddriverAlert").hide();
                    jQuery("#editdriverAlert").hide();


                }
            });


        }
    });

    // filter drivers
    function salesdriverFilter() {
        $status = $('#selectSalesdriverStatus').val();

        // console.log($status);

        $.ajax({
            type: "GET",
            url: "#",
            data: {
                "status": $status,
            },
            success: function(response) {
                // console.log(response);
                let i = 0;
                jQuery('.driver-details').html('');
                jQuery.each(response, function(key, value) {
                    $('.driver-details').append('<tr>\
                    <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["driver_man_id"] + '</td>\
                        <td class="border border-secondary">' + value["driver_name"] + '</td>\
                        <td class="border border-secondary">' + value['driver_mobile_no'] + '</td>\
                        <td class="border border-secondary">' + value["driver_email"] + '</td>\
                        <td class="border border-secondary">' + value["driver_address"] + '</td>\
                        <td class="border border-secondary">' + value["region"] + '</td>\
                        <td class="border border-secondary">' + value["order_delivered"] + '</td>\
                        <td class="border border-secondary">' + value["status"] + '</td>\
                        <td class="border border-secondary"><a name="viewdriver"  data-toggle="modal" data-id="' +
                        value["id"] + '"  data-target="#viewdriver"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editdriver" data-toggle="modal" data-id="' +
                        value["id"] +
                        '" data-target="#editdriver"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deletedriver" data-toggle="modal" data-target="#removeModalSalesdriver" data-id="' +
                        value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });
            }
        });
    }

    $(document).ready(function() {
        $('#resetSalesdriverFilter').click(function() {
            $('#driverCustomerName').val('');
            $('#selectSalesdriverStatus').prop('selectedIndex', 0);
            getdriverDetials();
        });
    });


    // filter
    function salesInvoiceFilterName() {
        $user = $('#driverCustomerName').val();
        $.ajax({
            type: "GET",
            url: "#",
            data: {
                "user": $user,
            },
            success: function(response) {

                let i = 0;
                jQuery('.driver-details').html('');
                $('.driver-main-table').html('Total Drivers : ' + response.total);
                jQuery.each(response.data, function(key, value) {
                    $('.driver-details').append('<tr>\
                    <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["driver_man_id"] + '</td>\
                        <td class="border border-secondary">' + value["driver_name"] + '</td>\
                        <td class="border border-secondary">' + value['driver_mobile_no'] + '</td>\
                        <td class="border border-secondary">' + value["driver_email"] + '</td>\
                        <td class="border border-secondary">' + value["driver_address"] + '</td>\
                        <td class="border border-secondary">' + value["region"] + '</td>\
                        <td class="border border-secondary">' + value["order_delivered"] + '</td>\
                        <td class="border border-secondary">' + value["status"] + '</td>\
                        <td class="border border-secondary"><a name="viewdriver"  data-toggle="modal" data-id="' +
                        value["id"] + '"  data-target="#viewdriver"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editdriver" data-toggle="modal" data-id="' +
                        value["id"] +
                        '" data-target="#editdriver"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deletedriver" data-toggle="modal" data-target="#removeModalSalesdriver" data-id="' +
                        value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.driver-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.driver-pagination-refs').append(
                        '<li id="search_driver_pagination" class="page-item ' + ((value
                            .active === true) ? 'active' : '') + '" ><a href="' + value['url'] +
                        '" class="page-link" >' + value["label"] + '</a></li>'
                    );
                });

            }
        });

        // pagination links css and access page
        $(function() {
            $(document).on("click", "#search_driver_pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append;

                $.get(finalURL, function(response) {
                    let i = response.from;
                    jQuery('.driver-details').html('');
                    $('.driver-main-table').html('Total Drivers : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.driver-details').append('<tr>\
                        <td class="border border-secondary">' + i++ + '</td>\
                        <td class="border border-secondary">' + value["invoice_no"] + '</td>\
                        <td class="border border-secondary">' + value["invoice_date"] + '</td>\
                        <td class="border border-secondary">' + value['customer_name'] + '</td>\
                        <td class="border border-secondary">' + value["driver_date"] + '</td>\
                        <td class="border border-secondary">' + value["amount"] + '</td>\
                        <td class="border border-secondary">' + value["partialamount"] + '</td>\
                        <td class="border border-secondary"> ' + ((value["driver_status"] === 'partial') ? (value[
                                "amount"] - value["partialamount"]) : '0') + ' </td>\
                        <td class="border border-secondary">' + value["driver_type"] + '</td>\
                        <td class="border border-secondary">' + value["driver_status"] + '</td>\
                        <td class="border border-secondary"><a name="viewdriver"  data-toggle="modal" data-id="' +
                            value["id"] + '"  data-target="#viewdriver"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="border border-secondary"><a name="editdriver" data-toggle="modal" data-id="' +
                            value["id"] +
                            '" data-target="#editdriver"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="border border-secondary"><a name="deletedriver" data-toggle="modal" data-target="#removeModalSalesdriver" data-id="' +
                            value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                    });

                    $('.driver-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.driver-pagination-refs').append(
                            '<li id="search_driver_pagination" class="page-item ' +
                            ((value.active === true) ? 'active' : '') +
                            '" ><a href="' + value['url'] +
                            '" class="page-link" >' + value["label"] + '</a></li>'
                        );
                    });
                });
                return false;
            });
        });
        // end here   

    }

    $(document).on("click", "a[name = 'deletedriver']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveSelectedSalesdriver').data('id', id);
    });
</script>

<div class="modal fade" id="removeModalSalesdriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                <a name="removeConfirmSalesdriver" class="btn btn-primary" id="confirmRemoveSelectedSalesdriver">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>
