@extends('superadmin.layouts.master')
@section('title','User Management | LFK')
@section('body')
<div class="main-panel">
    <div class="content-wrapper pb-0">
        <!-- user management header -->
        <div class="page-header flex-wrap px-5">
            <h3 class="mb-0">
                User Management
            </h3>
            <div class="d-flex">
                <a href="#" id="newbutton" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#addUser"> Add User </a>
            </div>
        </div>

        <div class="alert alert-success alert-dismissible fade show" id="delCustomerAlert" style="display:none" role="alert">
            <strong></strong> <span id="delCustomerAlertMSG"></span>
            <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- main section -->
        <div class="admin-card">
            <div class="container">
                <div class="p-3">
                    <div class="table-responsive">
                    <table class="table table-bordered table-responsive text-center" id="user_management_main_table">
                    <thead style="text-align: center;">
                        <tr>
                            <th style="text-align: center;">S/N</th>
                            <th style="text-align: center;">User Name</th>
                            <th style="text-align: center;">Email ID</th>
                            <th style="text-align: center;">Mobile Number</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                </table>
                    </div>
                
                </div>
            </div>
        </div>
        
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- // backend js file -->

    @include('superadmin.user-modal.addUser')
    @include('superadmin.user-modal.editUser')
    @include('superadmin.user-modal.viewUser')
    

    <script>

    $(document).ready(function() {
        user_management_main_table = $('#user_management_main_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:10,
            buttons:[],
            ajax: {
                url: "{{ route('SA-FetchUsersDetials') }}",
                type: 'GET',
            },
        })
    });

        
        // edit User
        $(document).on("click", "a[name = 'editUser']", function(e) {
            let id = $(this).data("id");
            viewUserDetials(id);

            function viewUserDetials(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-EditUser')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        jQuery.each(response, function(key, value) {
                            $('#editUserFormId').val(value["id"]);
                            $('#usernameEdit').val(value["name"]);
                            $('#phonnumberEdit').val(value["phone_number"]);
                            $('#mobilenumberEdit').val(value["mobile_number"]);
                            $('#emailidEdit').val(value["email"]);

                            const rights = value["assigned_modules"];
                            const rightsArr = rights.split(/\s*,\s*/);

                            checkArra();

                            (jQuery.inArray('all', rightsArr) != -1) ? $('#accessToAllEdit').prop('checked', true): $('#accessToAllEdit').prop('checked', false);
                            (jQuery.inArray('inventory', rightsArr) != -1) ? $('#inventoryEdit').prop('checked', true): $('#inventoryEdit').prop('checked', false);
                            (jQuery.inArray('sales', rightsArr) != -1) ? $('#salesEdit').prop('checked', true): $('#salesEdit').prop('checked', false);
                            (jQuery.inArray('purchase', rightsArr) != -1) ? $('#purchaseEdit').prop('checked', true): $('#purchaseEdit').prop('checked', false);
                            (jQuery.inArray('reports', rightsArr) != -1) ? $('#reportsEdit').prop('checked', true): $('#reportsEdit').prop('checked', false);
                            (jQuery.inArray('deliveryManagement', rightsArr) != -1) ? $('#deliveryManagementEdit').prop('checked', true): $('#deliveryManagementEdit').prop('checked', false);
                            (jQuery.inArray('refferalAwards', rightsArr) != -1) ? $('#refferalAwardsEdit').prop('checked', true): $('#refferalAwardsEdit').prop('checked', false);
                            (jQuery.inArray('eCredit', rightsArr) != -1) ? $('#eCreditEdit').prop('checked', true): $('#eCreditEdit').prop('checked', false);
                            (jQuery.inArray('offerpackage', rightsArr) != -1) ? $('#offerpackageEdit').prop('checked', true): $('#offerpackageEdit').prop('checked', false);
                            (jQuery.inArray('loyalitysystem', rightsArr) != -1) ? $('#loyalitysystemEdit').prop('checked', true): $('#loyalitysystemEdit').prop('checked', false);
                            (jQuery.inArray('customerManagement', rightsArr) != -1) ? $('#customerManagementEdit').prop('checked', true): $('#customerManagementEdit').prop('checked', false);

                        });
                    }
                });
            }
        });

        // view customer details
        $(document).on("click", "a[name = 'viewUser']", function(e) {
            let id = $(this).data("id");
            viewCustomerInfo(id);

            function viewCustomerInfo(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-ViewUser')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        jQuery.each(response, function(key, value) {
                            $('#usernameView').val(value["name"]);
                            $('#phonnumberView').val(value["phone_number"]);
                            $('#mobilenumberView').val(value["mobile_number"]);
                            $('#emailidView').val(value["email"]);

                            const rights = value["assigned_modules"];
                            const rightsArr = rights.split(/\s*,\s*/);

                            (jQuery.inArray('all', rightsArr) != -1) ? $('#accessToAllView').prop('checked', true): $('#accessToAllView').prop('checked', false);
                            (jQuery.inArray('inventory', rightsArr) != -1) ? $('#inventoryView').prop('checked', true): $('#inventoryView').prop('checked', false);
                            (jQuery.inArray('sales', rightsArr) != -1) ? $('#salesView').prop('checked', true): $('#salesView').prop('checked', false);
                            (jQuery.inArray('purchase', rightsArr) != -1) ? $('#purchaseView').prop('checked', true): $('#purchaseView').prop('checked', false);
                            (jQuery.inArray('reports', rightsArr) != -1) ? $('#reportsView').prop('checked', true): $('#reportsView').prop('checked', false);
                            (jQuery.inArray('deliveryManagement', rightsArr) != -1) ? $('#deliveryManagementView').prop('checked', true): $('#deliveryManagementView').prop('checked', false);
                            (jQuery.inArray('refferalAwards', rightsArr) != -1) ? $('#refferalAwardsView').prop('checked', true): $('#refferalAwardsView').prop('checked', false);
                            (jQuery.inArray('eCredit', rightsArr) != -1) ? $('#eCreditView').prop('checked', true): $('#eCreditView').prop('checked', false);
                            (jQuery.inArray('offerpackage', rightsArr) != -1) ? $('#offerpackageView').prop('checked', true): $('#offerpackageView').prop('checked', false);
                            (jQuery.inArray('loyalitysystem', rightsArr) != -1) ? $('#loyalitysystemView').prop('checked', true): $('#loyalitysystemView').prop('checked', false);
                            (jQuery.inArray('customerManagement', rightsArr) != -1) ? $('#customerManagementView').prop('checked', true): $('#customerManagementView').prop('checked', false);

                        });
                    }
                });
            }
        });

        // delete a single user detials using id
        $(document).on("click", "a[name = 'removeConfirmAdminUser']", function(e) {
            let id = $(this).data("id");
            delUser(id);

            function delUser(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-DeleteUser')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                        user_management_main_table.ajax.reload();
                        successMsg(response.success);
                        // getUserDetails();

                        $("#removeModal .close").click();
                    }
                });
            }
        });

        $(document).on("click", "a[name = 'delUser']", function(e) {
            let id = $(this).data("id");
            $('#confirmRemoveSelectedElement').data('id', id);
        });
    </script>


    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <a name="removeConfirmAdminUser" class="btn btn-primary" id="confirmRemoveSelectedElement">
                        YES
                    </a>
                </div>
            </div>
        </div>
    </div>

    @endsection