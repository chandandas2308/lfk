@extends('superadmin.layouts.master')
@section('title','Blogs | YONG SENG')
@section('body')


<!-- sales css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />
<!-- sales js file -->
<script src="{{ asset('inventorybackend/js/action.js')}}"></script>
<div class="main-panel">
    <div class="content-wrapper pb-0">

        <div class="p-3">
            <!-- orders Tab -->
            <div class="page-header flex-wrap" >
                <h4 class="mb-0">
                    News Letter
                </h4>
            </div>
            <!-- alert section -->
            <!-- <div class="alert alert-success" id="delOrdersAlert" style="display:none"></div> -->
            <div class="alert alert-success alert-dismissible fade show" id="delOrdersAlert" style="display:none" role="alert">
                <strong></strong> <span id="delOrdersAlertMSG"></span>
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- alert section end-->

            <!-- table start -->
            <div class="bg-white p-0 p-md-4" style="overflow-x:auto;">
                <table class="table text-center table-hover">
                    <caption class="sales-orders-main-table1 text-dark fw-bold"></caption>
                    <thead class="fw-bold text-dark">
                        <tr>
                            <th class=" border border-secondary">S/N</th>
                            <th class=" border border-secondary">Email ID</th>
                            <th class=" border border-secondary">Status</th>
                            <th class=" border border-secondary">Action</th>
                        </tr>
                    </thead>
                    <tbody class="tbody orders-list1">

                    </tbody>
                </table>
            </div>
            <ul class="sales-orders-pagination-refs mt-0 mt-md-3 pagination-referece-css pagination justify-content-center"></ul>
            <!-- table end here -->
        </div>

    </div>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- backend js file -->
    

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.ckeditor').ckeditor();
            });
        </script>
<script>
        jQuery(document).ready(function() {
            updateContacts();
        });

        // All Product Details
        function updateContacts() {
            $.ajax({
                type: "GET",
                url: "{{ route('SA-allNewsletter') }}",
                success: function(response) {
                    let i = 0;
                    jQuery('.orders-list1').html('');
                    $('.sales-orders-main-table1').html('Total Contact Queries : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.orders-list1').append('<tr>\
                            <td class=" border border-secondary">' + ++i + '</td>\
                            <td class=" border border-secondary">' + value["email"] + '</td>\
                            <td class=" border border-secondary">' + value["status"] + '</td>\
                            <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesOrders" name="deleteOrders" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                    $('.sales-orders-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.sales-orders-pagination-refs').append(
                            '<li id="sales_orders_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                        );
                    });


                }
            });
        }
        // End function here

        // pagination links css and access page
        $(function() {
            $(document).on("click", "#sales_orders_pagination a", function() {
                //get url and make final url for ajax 
                var url = $(this).attr("href");
                var append = url.indexOf("?") == -1 ? "?" : "&";
                var finalURL = url + append;

                $.get(finalURL, function(response) {
                    let i = response.from;
                    jQuery('.orders-list1').html('');
                    $('.sales-orders-main-table1').html('Total Orders : ' + response.total);
                    jQuery.each(response.data, function(key, value) {
                        $('.orders-list1').append('<tr>\
                        <td class=" border border-secondary">' + ++i + '</td>\
                        <td class=" border border-secondary">' + value["email"] + '</td>\
                            <td class=" border border-secondary">' + value["status"] + '</td>\
                            <td style="" class=" border border-secondary"><a data-toggle="modal" data-target="#removeModalSalesOrders" name="deleteOrders" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
                        </tr>');
                    });

                    $('.sales-orders-pagination-refs').html('');
                    jQuery.each(response.links, function(key, value) {
                        $('.sales-orders-pagination-refs').append(
                            '<li id="sales_orders_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '"><a class="page-link" href="' + value['url'] + '" >' + value["label"] + '</a></li>'
                        );
                    });
                });
                return false;
            });
        });
        // end here      

       

    

     


        // delete a single orders using id
        $(document).on("click", "a[name = 'removeConfirmSalesOrders']", function(e) {
            let id = $(this).data("id");
            delOrders(id);

            function delOrders(id) {
                
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-destroyNewsletter')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {

                        alertHideFun();
                        
                        jQuery("#delOrdersAlert").show();
                        jQuery("#delOrdersAlertMSG").html(response.success);
                        updateContacts();

                        $("#removeModalSalesOrders .close").click();

                    }
                });
            }
        });


        $(document).on("click", "a[name = 'deleteOrders']", function(e) {
            let id = $(this).data("id");
            $('#confirmRemoveSelectedSalesOrders').data('id', id);
        });
    </script>

    <div class="modal fade" id="removeModalSalesOrders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <a name="removeConfirmSalesOrders" class="btn btn-primary" id="confirmRemoveSelectedSalesOrders">
                        YES
                    </a>
                </div>
            </div>
        </div>
    </div>

    @endsection