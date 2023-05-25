<div class="p-3">
    <!-- invoice Tab -->
    <div class="page-header flex-wrap">

        <!--  -->
        <h4 class="mb-0">
        Order Management
        </h4>

        <!--  -->
        <div class="d-flex">
            <label for="ordermgt" id="searchLabel" class="text-black reset-btn p-2">Search </label>
            <input type="search" onkeypress="ordermgtFilter()" name="" id="ordermgt" placeholder="Search by customer name">
            <!-- Reset Filter -->
            <a href="#" id="resetordermgtBtn" class="text-black reset-btn p-2">Reset</a>
        </div>

        <!--  -->
        <div class="d-flex">
            <a href="{{route('SA-CancleOrder')}}" onclick="jQuery('#delQuotationAlert').hide()" class="btn btn-sm ml-3 reset-btn text-black"> Cancel Orders </a>
        </div>

    </div>
    <!-- alert section -->
    <!-- <div class="alert alert-success" id="delQuotationAlert" style="display:none"></div> -->
    <div class="alert alert-success alert-dismissible fade show" id="delQuotationAlert" style="display:none" role="alert">
        <strong>Info ! </strong> <span id="delQuotationAlertMSG"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="alert alert-success alert-dismissible fade show" id="cancelQuotationAlert" style="display:none" role="alert">
        <strong>Info ! </strong> <span id="cancelQuotationAlertMSG"></span>
        <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <!-- alert section end-->

    <!-- table start -->
    <!-- <div class="table-responsive"> -->
        <table class="text-center table table-bordered">
            <caption class="deliveryordr-quotation-main-table text-danger"></caption>
              <thead class="fw-bold text-dark">
                  <tr>
                      <th class="border border-secondary">S/N</th>
                      <th class="border border-secondary">Order No.</th>
                      <th class="border border-secondary">Customer Name</th>
                      <th class="border border-secondary">Contact No.</th>
                      <th class="border border-secondary">Product Description</th>
                      <th class="border border-secondary">Amount</th>
                      <th class="border border-secondary">Delivery Status</th>
                      <th class="border border-secondary">Payment Status</th>
                      <th class="border border-secondary">Action</th>
                  </tr>
              </thead>
            <tbody class="tbody order-list">
                <!--  -->
            </tbody>
        </table>
    <!-- </div> -->
    <ul class="mt-3 orderdlivry-quotation-pagination-refs pagination-referece-css pagination justify-content-center mt-3"></ul>
    <!-- table end here -->
</div>

<!-- Create Invoice Model -->
@include('superadmin.Delivery.order-modal.viewOrder')
@include('superadmin.Delivery.order-modal.viewOrder')
@include('superadmin.Delivery.order-modal.viewOrder')
<!-- Model -->

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>
    $(document).ready(function() {
        getOrderDetails();
    });

    $(document).ready(function() {
        $('#resetordermgtBtn').click(function() {
            $('#ordermgt').val('');
            getOrderDetails();
        })
    });

    // All quotaion Details
    function getOrderDetails() {
        var url =  $(location).attr('href').replace(/\/+$/,''), //rtrim `/`
    parts = url.split("/"),
    last_part = parts[parts.length-1];
    url1 ="{{ route('SA-GetOrdercancel') }}";
    url2 ="{{ route('SA-GetOrder') }}";
        $.ajax({
            type: "GET",
            url: (last_part=='cancel-orders'? url1 : url2),
            success: function(response) {
                let i = 0;
                jQuery('.order-list').html('');
                $('.deliveryordr-quotation-main-table').html('Total Order : ' + response.total);
                jQuery.each(response.data, function(key, value) {
                    $('.order-list').append('<tr>\
                        <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["order_number"] + '</td>\
                        <td class="border border-secondary">' + value["customer_name"] + '</td>\
                        <td class="border border-secondary">' + ((value["contact_no"] != null)?value["contact_no"]:"--") + '</td>\
                        <td class="border border-secondary">' + value["product_description"] + '</td>\
                        <td class="border border-secondary">' + value["amount"] + '</td>\
                        <td class="border border-secondary">' + value["delivery_status"] + '</td>\
                        <td class="border border-secondary">' + value["payment_staus"] + '</td>\
                        <td class="border border-secondary"><a name="viewcnclorder"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewcnclorder" title="View Order"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#cancelModalordermgt" name="cancelQuotation" title="Cancel Order" data-id="' + value["id"] + '" > <i class="mdi mdi-close-outline"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalordermgt" name="deleteQuotation" title="Delete Order" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.orderdlivry-quotation-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.orderdlivry-quotation-pagination-refs').append(
                        '<li id="order_quotation_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                    );
                });
            }
        });
    }
    // End function here

    // pagination links css and access page
    $(function() {
        $(document).on("click", "#order_quotation_pagination a", function() {
            //get url and make final url for ajax 
            var url = $(this).attr("href");
            var append = url.indexOf("?") == -1 ? "?" : "&";
            var finalURL = url + append;

            $.get(finalURL, function(response) {
                let i = response.from;
                jQuery('.order-list').html('');
                $('.deliveryordr-quotation-main-table').html('Total Order : ' + response.total);
                jQuery.each(response.data, function(key, value) {
                    $('.order-list').append('<tr>\
                    <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["order_number"] + '</td>\
                        <td class="border border-secondary">' + value['customer_name'] + '</td>\
                        <td class="border border-secondary">' + ((value["contact_no"] != null)?value["contact_no"]:"--") + '</td>\
                        <td class="border border-secondary">' + value["product_description"] + '</td>\
                        <td class="border border-secondary">' + value["amount"] + '</td>\
                        <td class="border border-secondary">' + value["delivery_status"] + '</td>\
                        <td class="border border-secondary">' + value["payment_staus"] + '</td>\
                        <td class="border border-secondary"><a name="viewcnclorder"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewcnclorder" title="View Order"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#cancelModalordermgt" name="cancelQuotation" title="Cancel Order" data-id="' + value["id"] + '" > <i class="mdi mdi-close-outline"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalordermgt" name="deleteQuotation" title="Delete Order" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.orderdlivry-quotation-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.orderdlivry-quotation-pagination-refs').append(
                        '<li id="order_quotation_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                    );
                });
            });
            return false;
        });
    });
    // end here    



    // view quotation detials
    $(document).on("click", "a[name = 'viewcnclorder']", function(e) {

        console.log('view fn called');

        let id = $(this).data("id");
        jQuery("#productTableBodyVQ").html('');
        getOrderInfo(id);

        function getOrderInfo(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-getOrderview')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery.each(response, function(key, value) {
                        $('#vieworder_number').val(value["order_number"]);
                        $('#viewcustomer_name').val(value["customer_name"]);
                        $('#viewcontact_no').val(value["contact_no"]);
                        $('#viewproduct_description').val(value["product_description"]);
                        $('#viewamount').val(value["amount"]);
                        $('#viewpickup_address').val(value["pickup_address"]);
                        $('#viewdelivery_address').val(value["delivery_address"]);
                        $('#viewregion').val(value["region"]);
                        $('#viewdelivery_date').val(value["delivery_date"]);
                        $('#viewdriver').val(value["driver"]);
                        $('#viewdelivery_status').val(value["delivery_status"]);
                        $('#viewcharges').val(value["charges"]);
                        $('#viewpayment_staus').val(value["payment_staus"]);


                        if (value["tax_inclusive"] === 1) {
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
    $(document).on("click", "a[name = 'removeConfirmordermgt']", function(e) {
        let id = $(this).data("id");
        delPayment(id);

        function delPayment(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-removeOrder')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery("#delQuotationAlert").show();
                    jQuery("#delQuotationAlertMSG").html(response.success);
                    getOrderDetails();

                    $("#removeModalordermgt .close").click();

                }
            });
        }
    });
     // cancel a single quotation using id
     $(document).on("click", "a[name = 'cancelConfirmordermgt']", function(e) {
        let id = $(this).data("id");
        canPayment(id);

        function canPayment(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-cancelOrder')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    jQuery("#cancelQuotationAlert").show();
                    jQuery("#cancelQuotationAlertMSG").html(response.success);
                    getOrderDetails();

                    $("#cancelModalordermgt .close").click();

                }
            });
        }
    });

    // filter
    function ordermgtFilter() {
        $user = $('#ordermgt').val();
        $.ajax({
            type: "GET",
            url : "{{ route('SA-OrderFilter') }}",
            data: {
                "user": $user,
            },
            success: function(response) {

                let i = 0;
                jQuery('.order-list').html('');
                $('.deliveryordr-quotation-main-table').html('Total Order : ' + response.total);
                jQuery.each(response.data, function(key, value) {
                    $('.order-list').append('<tr>\
                        <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["order_number"] + '</td>\
                        <td class="border border-secondary">' + value['customer_name'] + '</td>\
                        <td class="border border-secondary">' + ((value["contact_no"] != null)?value["contact_no"]:"--") + '</td>\
                        <td class="border border-secondary">' + value["product_description"] + '</td>\
                        <td class="border border-secondary">' + value["amount"] + '</td>\
                        <td class="border border-secondary">' + value["delivery_status"] + '</td>\
                        <td class="border border-secondary">' + value["payment_staus"] + '</td>\
                        <td class="border border-secondary"><a name="viewcnclorder"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewcnclorder" title="View Order"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#cancelModalordermgt" name="cancelQuotation" title="Cancel Order" data-id="' + value["id"] + '" > <i class="mdi mdi-close-outline"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalordermgt" name="deleteQuotation" title="Delete Order" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                });

                $('.orderdlivry-quotation-pagination-refs').html('');
                jQuery.each(response.links, function(key, value) {
                    $('.orderdlivry-quotation-pagination-refs').append(
                        '<li id="ordersearch_order_quotation_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                    );
                });

            }
        });

        // pagination links css and access page
        $(function() {
            $(document).on("click", "#ordersearch_order_quotation_pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append;

                $.get(finalURL, function(response) {
                    let i = 0;
                    jQuery('.order-list').html('');
                    $('.deliveryordr-quotation-main-table').html('Total Order : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.order-list').append('<tr>\
                        <td class="border border-secondary">' + ++i + '</td>\
                        <td class="border border-secondary">' + value["order_number"] + '</td>\
                        <td class="border border-secondary">' + value['customer_name'] + '</td>\
                        <td class="border border-secondary">' + ((value["contact_no"] != null)?value["contact_no"]:"--") + '</td>\
                        <td class="border border-secondary">' + value["product_description"] + '</td>\
                        <td class="border border-secondary">' + value["amount"] + '</td>\
                        <td class="border border-secondary">' + value["delivery_status"] + '</td>\
                        <td class="border border-secondary">' + value["payment_staus"] + '</td>\
                        <td class="border border-secondary"><a name="viewcnclorder"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewcnclorder" title="View Order"> <i class="mdi mdi-eye"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#cancelModalordermgt" name="cancelQuotation" title="Cancel Order" data-id="' + value["id"] + '" > <i class="mdi mdi-close-outline"></i> </a></td>\
                        <td style="display:' + value["display"] + ';" class="border border-secondary"><a data-toggle="modal" data-target="#removeModalordermgt" name="deleteQuotation" title="Delete Order" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                    </tr>');
                    });

                    $('.orderdlivry-quotation-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.orderdlivry-quotation-pagination-refs').append(
                            '<li id="ordersearch_order_quotation_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
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
        $('#confirmRemoveSelectedordermgt').data('id', id);
    });
    $(document).on("click", "a[name = 'cancelQuotation']", function(e) {
        let id = $(this).data("id");
        $('#confirmCancelSelectedordermgt').data('id', id);
    });
</script>

<div class="modal fade" id="removeModalordermgt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <a name="removeConfirmordermgt" class="btn btn-primary" id="confirmRemoveSelectedordermgt">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelModalordermgt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Confirm Alert</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">DO YOU WANT TO CANCEL?<span id="removeElementId1"></span> </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                <a name="cancelConfirmordermgt" class="btn btn-primary" id="confirmCancelSelectedordermgt">
                    YES
                </a>
            </div>
        </div>
    </div>
</div>