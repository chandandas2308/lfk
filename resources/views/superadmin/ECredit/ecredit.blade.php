    <div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                E-Wallet
            </h4>
        </div>

            <!-- table start -->
            <div class="table-responsive">
            <table class="text-center table table-responsive table-bordered" id="eCredit_main_table" style="display: inline-table;">
                    <thead>
                        <tr>
                            <th class="text-center">S/N</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Mobile</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Available Balance</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
              
            <!-- table end here -->
    </div>

    @include('superadmin.ECredit.modal.add')
    @include('superadmin.ECredit.modal.edit')
    @include('superadmin.ECredit.modal.view')
<script>

    $(document).ready(function() {
        eCredit_main_table = $('#eCredit_main_table').DataTable({
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
                url: "{{ route('SA-FetchAllECredit') }}",
                type: 'GET',
            }
        });
    });

    // jQuery(document).ready(function() {
    //     getECredit();
    // });

    // All Product Details
    // function getECredit() {
    //     $.ajax({
    //         type: "GET",
    //         url: "{{ route('SA-FetchAllECredit') }}",
    //         success: function(response) {
    //             let i = 0;
    //             $('.Refferal-list').html('');
    //             $('.delivery-main-table').html('Total E-Credits : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {

    //                 $('.Refferal-list').append('<tr>\
    //                     <td class=" border border-secondary">' + ++i + '</td>\
    //                     <td class=" border border-secondary">' + value["customer_name"] + '</td>\
    //                     <td class=" border border-secondary">' + value["mobile"] + '</td>\
    //                     <td class=" border border-secondary">' + value["email"] + '</td>\
    //                     <td class=" border border-secondary">' + value["available_balanced"] + '</td>\
    //                     <td class=" border border-secondary"><a name="viewECredit"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewECredit"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     \
    //                 </tr>');
    //             });
    //             $('.ecredit-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.ecredit-pagination-refs').append(
    //                     '<li id="delivery_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         }
    //     });
    // }
    // End function here

    // pagination links css and access page
    // $(function() {
    //     $(document).on("click", "#delivery_pagination", function() {
    //         //get url and make final url for ajax
    //         var url = $(this).attr("href");
    //         var append = url.indexOf("?") == -1 ? "?" : "&";
    //         var finalURL = url + append;


    //         $.get(finalURL, function(response) {
    //             let i = response.from;

    //             $('.Refferal-list').html('');
    //             $('.delivery-main-table').html('Total E-Credits : ' + response.total);
    //             jQuery.each(response.data, function(key, value) {
    //                 $('.Refferal-list').append('<tr>\
    //                     <td class="border border-secondary">' + i++ + '</td>\
    //                     <td class=" border border-secondary">' + value["price"] + '</td>\
    //                     <td class=" border border-secondary">' + value["points"] + '</td>\
    //                     <td class=" border border-secondary"><a name="viewECredit"  data-toggle="modal" data-id="' + value["id"] + '"  data-target="#viewECredit"> <i class="mdi mdi-eye"></i> </a></td>\
    //                     <td class=" border border-secondary"><a name="updateECredit" data-toggle="modal" data-id="' + value["id"] + '" data-target="#updateECredit"> <i class="mdi mdi-pencil"></i> </a></td>\
    //                     <td  class=" border border-secondary"><a name="deleteECredit" data-toggle="modal" data-target="#removeModalBusinessManagement" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });
    //             $('.ecredit-pagination-refs').html('');
    //             jQuery.each(response.links, function(key, value) {
    //                 $('.ecredit-pagination-refs').append(
    //                     '<li id="delivery_pagination" class="page-item ' + ((value.active === true) ? 'active' : '') + '" ><a href="' + value['url'] + '" class="page-link" >' + value["label"] + '</a></li>'
    //                 );
    //             });
    //         });
    //         return false;
    //     });
    // });
    // end here   

        // edit detials
        $(document).on("click", "a[name = 'updateECredit']", function(e) {

            let id = $(this).data("id");
            getECreditDetials(id);

            function getECreditDetials(id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('SA-FetchSingleECredit')}}",
                    data: {
                        'id': id,
                    },
                    success: function(response) {
                            $('#idUpdate').val(response['id']);
                            $('#priceUpdate').val(response['price']);
                            $('#pointsUpdate').val(response['points']);
                    }
                });
            }
        });

            // view detials
            $(document).on("click", "a[name = 'viewECredit']", function(e) {

                let id = $(this).data("id");
                getECreditDetials(id);

                function getECreditDetials(id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('SA-FetchSingleECredit')}}",
                        data: {
                            'id': id,
                        },
                        success: function(response) {
                                $('#customer_name').val(response['customer_name']);
                                $('#mobile').val(response['mobile']);
                                $('#email').val(response['email']);
                                $('#available_balanced').val(response['available_balanced']);
                                $('#order_id').val(response['order_id']);
                        }
                    });
                }
            });

            
            // view detials
            $(document).on("click", "a[name = 'deleteECredit']", function(e) {

                let id = $(this).data("id");
                getECreditDetials(id);

                function getECreditDetials(id) {
                    bootbox.confirm("DO YOU WANT TO DELETE?", function(result) {
                        if(result){
                            $.ajax({
                                type: "GET",
                                url: "{{ route('SA-RemoeSingleECredit')}}",
                                data: {
                                    'id': id,
                                },
                                success: function(response) {
                                    successMsg(response.success);
                                    getECredit();
                                }
                            });
                        }
                    });
                }
            });

</script>
<!-- <td class=" border border-secondary"><a name="updateECredit" data-toggle="modal" data-id="' + value["id"] + '" data-target="#updateECredit"> <i class="mdi mdi-pencil"></i> </a></td>\
                        <td  class=" border border-secondary"><a name="deleteECredit" data-toggle="modal" data-target="#removeModalBusinessManagement" data-id="' + value["id"] + '" > <i class="mdi mdi-delete"></i> </a></td> -->