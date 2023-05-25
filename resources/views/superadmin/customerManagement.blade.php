<style>
    .search {
        width: 240px;
    }

    .required-field::before {
        content: "*";
        color: red;
        float: right;
    }
</style>
<!-- Customer Managment System Tab start here -->

<div class="p-3">
    <!-- invoice Tab -->
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Business Customer
        </h4>
        <div class="d-flex">
            <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addCustomer"> Add Customer </a>
        </div>
    </div>

    <!-- table start -->
    <div class="table-responsive">
        <table class="text-center table table-responsive table-bordered" id="business_customer_table">
            <thead>
                <tr>
                    <th class="text-center">S/N</th>
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Mobile Number</th>
                    <th class="text-center">Email ID</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Special Price</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- table end here -->
</div>

<!-- Model -->
@include('superadmin.customer-modal.editCustomer')
@include('superadmin.customer-modal.addCustomer')
@include('superadmin.customer-modal.viewCustomer')
@include('superadmin.customer-modal.specialPrice')


<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- // backend js file -->

<script>

    $(document).ready(function() {
        business_customer_table = $('#business_customer_table').DataTable({
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
                url: "{{ route('SA-CustomersListPaginate') }}",
                type: 'GET',
            }
        });
    });

    // $(document).ready(function() {
    //     getCustomerDetials();
    // });

    // $(document).ready(function() {
    //     $('#resetcustomerManagementBtn').click(function() {
    //         $('#customerManagement').val('');
    //         getCustomerDetials();
    //     })
    // });

    // // All Customer Details
    // function getCustomerDetials() {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('SA-CustomersListPaginate') }}",
    //         success: function(response) {
    //             let i = 0;
    //             jQuery('.customer-details').html('');
    //             $('.customer-management-main-main-table').html('Total no. of Customer : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.customer-details').append('<tr>\
    //                     <td class="p-2 border border-secondary">' + ++i + '</td>\
    //                     <td class="p-2 border border-secondary">' + value["customer_name"] + '</td>\
    //                     <td class="p-2 border border-secondary">' + value["mobile_number"] + '</td>\
    //                     <td class="p-2 border border-secondary">' + ((value["email_id"] != null) ? value["email_id"] : "--") + '</td>\
    //                     <td class="p-2 border border-secondary">' + value['address'] + '</td>\
    //                     <td class="p-2 border border-secondary"><a name="addSpecialPrice" onclick="getSpecialPriceList(' + value['id'] + ')" class="btn btn-primary btn-sm text-white" style="cursor:pointer;" data-toggle="modal" data-id="' + value["id"] + '" data-target="#addSpecialPrice"> Add Price </a></td>\
    //                     <td class="p-2 border border-secondary"><a name="viewCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#viewCustomerDetails"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="p-2 border border-secondary"><a name="editCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editCustomerDetails"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="p-2 border border-secondary"><a name="deleteCustomer" data-toggle="modal" data-target="#removeModalCustomerManagement" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });
    //             $('.customer-management-main-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.customer-management-main-pagination-refs').append(
    //                     '<li id="customer_management_main_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         }
    //     });
    // }
    // // End function here

    // // pagination links css and access page
    // $(function() {
    //     $(document).on("click", "#customer_management_main_pagination a", function() {
    //         //get url and make final url for ajax
    //         var url = $(this).attr("href");
    //         var append = url.indexOf("?") == -1 ? "?" : "&";
    //         var finalURL = url + append;


    //         $.get(finalURL, function(response) {
    //             let i = response.from;
    //             jQuery('.customer-details').html('');
    //             $('.customer-management-main-main-table').html('Total no. of Customer : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.customer-details').append('<tr>\
    //                     <td class="p-2 border border-secondary">' + i++ + '</td>\
    //                     <td class="p-2 border border-secondary">' + value["customer_name"] + '</td>\
    //                     <td class="p-2 border border-secondary">' + value["mobile_number"] + '</td>\
    //                     <td class="p-2 border border-secondary">' + ((value["email_id"] != null) ? value["email_id"] : "--") + '</td>\
    //                     <td class="p-2 border border-secondary">' + value['address'] + '</td>\
    //                     <td class="p-2 border border-secondary"><a name="addSpecialPrice" onclick="getSpecialPriceList(' + value['id'] + ')" class="btn btn-primary btn-sm text-white" style="cursor:pointer;" data-toggle="modal" data-id="' + value["id"] + '" data-target="#addSpecialPrice"> Add Price </a></td>\
    //                     <td class="p-2 border border-secondary"><a name="viewCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#viewCustomerDetails"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class="p-2 border border-secondary"><a name="editCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editCustomerDetails"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td class="p-2 border border-secondary"><a name="deleteCustomer" data-toggle="modal" data-target="#removeModalCustomerManagement" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });
    //             $('.customer-management-main-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.customer-management-main-pagination-refs').append(
    //                     '<li id="customer_management_main_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // // end here        

    // view special price
    function getSpecialPriceList(id) {
        //     jQuery.ajax({
        //         type : "GET",
        //         url : "{{ route('SA-GetCustomerDetails')}}",
        //         data : {
        //           'id': id,
        //         },
        //         success : function (response){
        //             $.each(response, function(key, value){
        //                     let str = value['specialPrice'];
        //                     let sno = 0;
        // let obj = JSON.parse(str);
        // console.log(str);
        // $('#productsTableSpecialPrice tbody').html('');
        // jQuery.each(str, function(key, value){
        //     $('#productsTableSpecialPrice tbody').append('<tr class="child">\
        //             <td>'+ ++sno +'</td>\
        //             <td class="product_Id">'+value["id"]+'</td>\
        //             <td class="product_name">'+value["product_name"]+'</td>\
        //             <td class="product_varient">'+value["product_varient"]+'</td>\
        //             <td class="product_category">'+value["category"]+'</td>\
        //             <td class="unit_price">'+value["unitPrice"]+'</td>\
        //             <td class="subtotal">'+value["specialPrice"]+'</td>\
        //             <td>\
        //                 <a href="javascript:void(0);" class="remPriceList">\
        //                     <i class="mdi mdi-delete"></i>\
        //                 </a>\
        //             </td>\
        //         </tr>');
        // });
        //             })
        //         }
        //     });
    };
    // end special price here


    // edit customer details
    $(document).on("click", "a[name = 'editCustomer']", function(e) {
        let id = $(this).data("id");
        getCustomerInfo(id);

        function getCustomerInfo(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCustomerDetails1')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#editCustomerFormId').val(value["id"]);
                        $('#customerEditName').val(value["customer_name"]);
                        $('#customerAddress').val(value["address"]);
                        $('#customerPhoneNo').val(value["phone_number"]);
                        $('#CustomerMobileNo').val(value["mobile_number"]);
                        $('#CustomerEmailId').val(value["email_id"]);
                        $('#customerGst').val(value["gst"]);
                    });
                }
            });
        }
    });

    // view single customer details
    $(document).on("click", "a[name = 'viewCustomer']", function(e) {
        let id = $(this).data("id");
        viewCustomerInfo(id);

        function viewCustomerInfo(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCustomerDetails')}}",
                data: {
                    'id': id,
                },
                success: function(response) {

                    // jQuery.each(response, function(key, value){
                    $('#customerViewName').val(response[1]["customer_name"]);
                    $('#customerViewAddress').val(response[1]["address"]);
                    $('#customerViewPhNo').val(response[1]["phone_number"]);
                    $('#CustomerViewMobNo').val(response[1]["mobile_number"]);
                    $('#CustomerViewEmailId1').val(response[1]["email_id"]);
                    $('#customerViewGst').val(response[1]["gst"]);

                    $('#invoice_details_table').html('');
                    let sn = 0;
                    jQuery.each(response[0], function(k1, v1) {
                        // console.log('Invoice No. is : ', v1['invoice_no']);
                        let products = JSON.parse(v1['products']);
                        // console.log('Products details are : ',products);
                        jQuery.each(products, function(k, v) {
                            $('#invoice_details_table').append(
                                '<tr>\
                                    <td>' + ++sn + '</td>\
                                    <td>' + v1['invoice_no'] + '</td>\
                                    <td>' + v["product_Id"] + '</td>\
                                    <td>' + v["product_name"] + '</td>\
                                    <td>' + v["quantity"] + '</td>\
                                    <td>' + v["subTotal"] + '</td>\
                                    </tr>'
                            );
                        });
                    })

                    // });
                }
            });

        }
    });

    $(document).on("click", "a[name = 'addSpecialPrice']", function(e) {
        let id = $(this).data("id");
        addSpecialPrice(id);

        function addSpecialPrice(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetCustomerDetails')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    $('#special_price_customer_id').val(response[1]['id']);
                    $('#special_price_customer_id1').val(response[1]['id']);
                    $('#special_price_customer_name').val(response[1]['customer_name']);
                    $('#special_price_customer_email').val(response[1]['email_id']);

                    let products = JSON.parse(response[1]['specialPrice']);

                    $('#productsTableSpecialPrice tbody').html('');
                    let sno = 0;
                    jQuery.each(products, function(key, value) {
                        $('#productsTableSpecialPrice tbody').append('<tr class="child">\
                                    <td>' + ++sno + '</td>\
                                    <td class="product_Id">' + value["id"] + '</td>\
                                    <td class="product_name">' + value["product_name"] + '</td>\
                                    <td class="product_variant">' + value["product_variant"] + '</td>\
                                    <td class="product_category">' + value["category"] + '</td>\
                                    <td class="unit_price">' + value["unitPrice"] + '</td>\
                                    <td class="subtotal">' + value["specialPrice"] + '</td>\
                                    <td>\
                                        <a href="javascript:void(0);" class="remPriceList">\
                                            <i class="mdi mdi-delete"></i>\
                                        </a>\
                                    </td>\
                                </tr>');
                    });
                }
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
                    successMsg(response.success);
                    business_customer_table.ajax.reload();
                    $("#removeModalCustomerManagement .close").click();
                }
            });
        }
    });

    // filter
    function customerManagementFilter() {
        $user = $('#customerManagement').val();
        $.ajax({
            type: "GET",
            url: "{{ route('SA-CustomerFilter') }}",
            data: {
                "user": $user,
            },
            success: function(response) {

                let i = 0;
                jQuery('.customer-details').html('');
                $('.customer-management-main-main-table').html('Total resutls : ' + response.total);
                jQuery.each(response.data, function(key, value) {
                    $('.customer-details').append('<tr>\
                        <td class="p-2 border border-secondary">' + ++i + '</td>\
                        <td class="p-2 border border-secondary">' + value["customer_name"] + '</td>\
                        <td class="p-2 border border-secondary">' + value["mobile_number"] + '</td>\
                        <td class="p-2 border border-secondary">' + ((value["email_id"] != null) ? value["email_id"] : "--") + '</td>\
                        <td class="p-2 border border-secondary">' + value['address'] + '</td>\
                        <td class="p-2 border border-secondary"><a name="addSpecialPrice" onclick="getSpecialPriceList(' + value['id'] + ')" class="btn btn-primary btn-sm text-white" style="cursor:pointer;" data-toggle="modal" data-id="' + value["id"] + '" data-target="#addSpecialPrice"> Add Price </a></td>\
                        <td class="p-2 border border-secondary"><a name="viewCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#viewCustomerDetails"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="editCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editCustomerDetails"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td class="p-2 border border-secondary"><a name="deleteCustomer" data-toggle="modal" data-target="#removeModalCustomerManagement" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });
                $('.customer-management-main-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.customer-management-main-pagination-refs').append(
                        '<li id="search_customer_management_main_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
                    );
                });
            }
        });

        // pagination links css and access page
        $(function() {
            $(document).on("click", "#search_customer_management_main_pagination a", function() {
                //get url and make final url for ajax
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append;


                $.get(finalURL, function(response) {
                    let i = 0;
                    jQuery('.customer-details').html('');
                    $('.customer-management-main-main-table').html('Total resutls : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.customer-details').append('<tr>\
                                    <td class="p-2 border border-secondary">' + ++i + '</td>\
                                    <td class="p-2 border border-secondary">' + value["customer_name"] + '</td>\
                                    <td class="p-2 border border-secondary">' + value["mobile_number"] + '</td>\
                                    <td class="p-2 border border-secondary">' + ((value["email_id"] != null) ? value["email_id"] : "--") + '</td>\
                                    <td class="p-2 border border-secondary">' + value['address'] + '</td>\
                                    <td class="p-2 border border-secondary"><a name="addSpecialPrice" onclick="getSpecialPriceList(' + value['id'] + ')" class="btn btn-primary btn-sm text-white" style="cursor:pointer;" data-toggle="modal" data-id="' + value["id"] + '" data-target="#addSpecialPrice"> Add Price </a></td>\
                                    <td class="p-2 border border-secondary"><a name="viewCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#viewCustomerDetails"> <i class="mdi mdi-eye"></i> </a></td>\
                                    <td class="p-2 border border-secondary"><a name="editCustomer" data-toggle="modal" data-id="' + value["id"] + '" data-target="#editCustomerDetails"> <i class="mdi mdi-pencil"></i> </a></td>\
                                    <td class="p-2 border border-secondary"><a name="deleteCustomer" data-toggle="modal" data-target="#removeModalCustomerManagement" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                                </tr>');
                    });
                    $('.customer-management-main-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.customer-management-main-pagination-refs').append(
                            '<li id="search_customer_management_main_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
                        );
                    });
                });
                return false;
            });
        });
        // end here
    }

    $(document).on("click", "a[name = 'deleteCustomer']", function(e) {
        let id = $(this).data("id");
        $('#confirmRemoveSelectedCustomerManagement').data('id', id);
    });
</script>

<!-- End here -->

<!-- </div> -->

<div class="modal fade" id="removeModalCustomerManagement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a name="removeConfirmCustomerManagement" class="btn btn-primary" id="confirmRemoveSelectedCustomerManagement">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>