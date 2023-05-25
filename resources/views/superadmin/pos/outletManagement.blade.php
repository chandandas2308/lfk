@extends('superadmin.layouts.master')
@section('title','Outlet Management | LFK')
@section('body')
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<style>
    .dt-head-center {text-align: center !important;}
    thead, th, td {text-align: center !important;}
    .dataTables_filter {
        display: none;
        }
</style>

<div class="main-panel">
    <div class="content-wrapper pb-0">
        <!--  -->
        <!--  -->
                            <div class="page-header flex-wrap mx-3" >
                                <h6>
                                    <!-- POS STOCK MANAGEMENT -->
                                    <input type="hidden" id="outletManagementOwnerId" value="{{ $id }}">
                                </h6>
                                <div class="d-flex">
                                    <a class="btn-sm btn-primary" id="addStockBtnId" data-toggle="modal" data-target="#addStock" href="javascript:void(0)">ADD STOCK</a>
                                </div>
                            </div>
                            <!--  -->
                            <div class="admin-card">
                                <div class="container">
                                <div class="table-responsive">
                                <table class="table" id="outletStockTable">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Product Name</th>
                                            <th>Product Variant</th>
                                            <th>Unit Price</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <!-- <tbody id="outletStockTableBody"></tbody> -->
                                </table>
                            </div>
                                </div>
                        
                            </div>
                           
        <!--  -->
    <!-- </div> -->
</div>
@include('superadmin.pos.pos-modal.addStock')
@include('superadmin.pos.pos-modal.updateStock')

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

// getAllOutletStockDetails($("#outletManagementOwnerId").val());

$(document).ready(function() {
        outlet_stock_table = $('#outletStockTable').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            //responsive: 'false',
            // dom: "Bfrtip",
            ajax: {
                url: "{{ route('SA-FetchAllOutletStockDetails') }}",
                type: 'get',
                data: {
                    "id" : $("#outletManagementOwnerId").val(),
                },
                // success : function(response){
            },
        })
    });


$(document).on('click', 'a[name="updateOutletStockInfo"]', function(key, value){
    $id = $(this).data('id');
    
    jQuery.ajax({
        url: "{{ route('SA-FetchSingleOutletStockDetails') }}",
        type: "get",
        data: {
            "id" : $id,
        },
        success : function(response){
            $('#updateStockId').val(response[0]["id"]);
            $('#update_posStockPName').val(response[0]["product_name"]);
            // getUpdateVariantName(response[0]["product_name"]);
            $('#update_posStockVariant').val(response[0]["product_variant"]);
            $('#update_pos_stock_unit_price').val(response[0]["unit_price"]);
            $('#update_posStockQuantity').val(response[0]["quantity"]);            
        }
    });

});

$(document).on('click', 'a[name="removeOutletStockInfo"]', function(key, value){
    $id = $(this).data('id');
    
    bootbox.confirm("DO YOU WANT TO DELETE?", function(result) {
        if(result){
            jQuery.ajax({
                url: "{{ route('SA-OutletRemoveStock') }}",
                type: "get",
                data: {
                    "id" : $id,
                },
                success : function(response){
                    if(response.success != null){
                        successMsg(response.success);
                        outlet_stock_table.ajax.reload();
                    }else{
                        errorMsg(response.error);
                    }
                }
            });
        }
    });
});

</script>

        <!-- backend js file -->
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


@endsection