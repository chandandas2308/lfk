<!-- Delivery Transaction Tab -->
<div class="p-3">
    <div class="page-header flex-wrap">
        <h4 class="mb-0">
            Delivery Management
        </h4>
        <div class="d-flex">
            <a href="#" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addDelivery"> Add Delivery </a>
        </div>
    </div>

    <!-- alert section -->
    <div class="alert alert-success" id="delDeliveryAlert" style="display:none"></div>
    <!-- alert section end-->

    <!-- table start -->
    <!-- <div class="table-responsive-sm" style="overflow-x:scroll;"> -->
        <table class="table text-center border" id="deliver_driver_detail">
            <!-- <caption class="delivery-main-table  text-danger"></caption> -->
            <thead class="fw-bold text-dark">
                <tr>
                    <th class=" border border-secondary">S/N</th>
                    <th class=" border border-secondary">Order No.</th>
                    <th class=" border border-secondary">Customer Name</th>
                    <th class=" border border-secondary">Mobile No.</th>
                    <th class=" border border-secondary">Delivery Man</th>
                    <th class=" border border-secondary">Delivery Address</th>
                    <th class=" border border-secondary">Date</th>
                    <th class=" border border-secondary">Status</th>
                    <th class=" border border-secondary">Payment Status</th>
                    <th class=" border border-secondary" >Action</th>
                </tr>
            </thead>
        </table>
    <!-- </div> -->
</div>

<!-- Add Delivery Model -->
@include('superadmin.Delivery.delivery-models.addDelivery')
<!-- end model here -->

<!-- Edit Delivery Model -->
@include('superadmin.Delivery.delivery-models.editDelivery')
<!-- end model here -->

<!-- View Delivery Model -->
@include('superadmin.Delivery.delivery-models.viewDelivery')
<!-- end model here -->

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- backend js file -->

<script>

    // Start data table
    $(document).ready(function() {
        getDeliverCustomerOrdersDetials = $('#deliver_driver_detail').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            // responsive: 'false',
            buttons : [],
            dom: "Bfrtip",
            ajax: {
                url: "{{ route('SA-GetDeliveries') }}",
                type: 'get',
            },
        });
        $(document).find('#deliver_driver_detail').wrap('<div style="overflow-x:auto; width:100%;"></div>');
    });
    // End dta table


    // get a single product
    $(document).on("click", "a[name = 'editdeliverys']", function(e) {
        let id = $(this).data("id");
        getDelivery(id);

        function getDelivery(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetDelivery')}}",
                data: {
                    'id': id,
                },
                success: function(response) {

                    jQuery.each(response, function(key, value) {
                        $('#editDeliveryId').val(value["id"]);
                        $('#customer_id_delivery_ed').val(value["customer_id"]);
                        $('#customer_name_delivery_ed').val(value["customer_name"]);
                        $('#mob_no_delivery_ed').val(value["mobile_no"]);
                        $('#invoice_date_delivery_ed').val(value["date"]);
                        $('#selectOrder_no_ed').val(value["order_no"]);
                        $('#delivery_man_name_ed').val(value["delivery_man"]);
                        $('#selectdeliverymanED').val(value["delivery_man_id"]);
                        $('#delivery_man_user_id_ed').val(value["delivery_man_user_id"]);
                        $('#delivery_address_delivery_ed').val(value["delivery_address"]);
                        $('#editpickupid').val(value["pickup_address"]);
                        $('#description_ed').val(value["description"]);
                        $('#delivery_status_ed').val(value["delivery_status"]);
                        $('#payment_status_ed').val(value["payment_status"]);

                        let sno = 0;
                        let str = value["product_details"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value) {

                            $('#productTableBody9_ed').html('');
                            $('#productTableBody9_ed').append('<tr class="child">\
                                          <td>' + ++sno + '</td>\
                                          <td class="product_idDelivery" style="display:none;" >' + value["product_Id"] + '</td>\
                                          <td class="product_nameDelivery">' + value["product_name"] + '</td>\
                                          <td class="product_categoryDelivery">' + value["category"] + '</td>\
                                          <td class="product_varientDelivery">' + value["product_varient"] + '</td>\
                                          <td class="product_descDelivery">' + value["description"] + '</td>\
                                          <td class="product_quantityDelivery">' + value["quantity"] + '</td>\
                                          <td class="unit_priceDelivery">' + value["unitPrice"] + '</td>\
                                          <td class="taxesDelivery" style="display:none;" >' + value["taxes"] + '</td>\
                                          <td class="subtotalDelivery">' + value["subTotal"] + '</td>\
                                          <td class="netAmountDelivery">' + value["netAmount"] + '</td>\
                                              </a>\
                                          </td>\
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

    $(document).on('click', '.remCF1deliveryQE', function() {
        $(this).parent().parent().remove();
        calculate();
        $('#productTableBody8 tr').each(function(i) {
            $($(this).find('td')[0]).html(i + 1);
        });
    });

    // delete a single product using id
    $(document).on("click", "a[name = 'deleteDelivery']", function(e) {
        let id = $(this).data("id");
        getDelivery(id);

        function getDelivery(id) {
            bootbox.confirm(" DO YOU WANT TO DELETE?", function(result) {
            if(result){
            $.ajax({
                type: "GET",
                url: "{{ route('SA-RemoveDelivery')}}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    successMsg(response.success);
                    getDeliverCustomerOrdersDetials.ajax.reload();
                    

                }
            });
        }
    });
        }
    });


    // view a single product using id
    $(document).on("click", "a[name = 'viewdeliverys']", function(e) {
        let id = $(this).data("id");
        getDelivery(id);

        function getDelivery(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-GetDelivery')}}",
                data: {
                    'id': id,
                },
                success: function(response) {

                    jQuery.each(response, function(key, value) {
                        $('#customer_id_delivery_view').val(value["customer_id"]);
                        $('#customer_name_delivery_view').val(value["customer_name"]);
                        $('#mob_no_delivery_view').val(value["mobile_no"]);
                        $('#invoice_date_delivery_view').val(value["date"]);
                        $('#selectOrder_no_view').val(value["order_no"]);
                        $('#delivery_man_view').val(value["delivery_man"]);
                        $('#delivery_address_delivery_view').val(value["delivery_address"]);
                        $('#description_view').val(value["description"]);
                        $('#viewpickupid').val(value["pickup_address"]);
                        $('#delivery_status_view').val(value["delivery_status"]);
                        $('#payment_status_view').val(value["payment_status"]);

                        let sno = 0;
                        let str = value["product_details"];

                        let obj = JSON.parse(str);

                        jQuery.each(obj, function(key, value) {

                            $('#productTableBody9_view').html('');
                                      $('#productTableBody9_view').append(
                                        '<tr class="child">\
                                          <td>' + ++sno + '</td>\
                                          <td class="product_idDelivery" style="display:none;" >' + value["product_Id"] + '</td>\
                                          <td class="product_nameDelivery">' + value["product_name"] + '</td>\
                                          <td class="product_categoryDelivery">' + value["category"] + '</td>\
                                          <td class="product_varientDelivery">' + value["product_varient"] + '</td>\
                                          <td class="product_descDelivery">' + value["description"] + '</td>\
                                          <td class="product_quantityDelivery">' + value["quantity"] + '</td>\
                                          <td class="unit_priceDelivery">' + value["unitPrice"] + '</td>\
                                          <td class="taxesDelivery" style="display:none;" >' + value["taxes"] + '</td>\
                                          <td class="subtotalDelivery">' + value["subTotal"] + '</td>\
                                          <td class="netAmountDelivery">' + value["netAmount"] + '</td>\
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



</script>