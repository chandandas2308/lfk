@extends('superadmin.layouts.master')
@section('title', 'Consolidate Orders | LFK')
@section('body')
    <div class="main-panel">
        <div class="content-wrapper pb-0">
            <!-- user management header -->
            <div class="page-header flex-wrap px-5">
                <h3 class="mb-0">
                    Consolidate Orders
                </h3>
            </div>

            <!-- main section -->
            <div class="p-3">
                <div class="page-header flex-wrap">
                    <h4 class="mb-0">
                        Consolidate Orders
                    </h4>
                </div>

                <!-- table start -->
                <div class="admin-card">
                    <div class="container">
                        <div class="p-3">

                            <p id="date_filter">
                                <span id="date-label-from" class="date-label">Delivery Date : </span>
                                <input placeholder="DD/MM/YYYY" class="date_range_filter date" type="text"
                                    id="postal_order_datepicker_from" autocomplete="off" value="{{ request()->date }}"/>
                                <button type="button" class="btn-sm btn-primary reset">Reset</button>

                                <span id="date-label-from" class="date-label">Driver List : </span>
                                <select name="" id="" class="postal_select2" id="postal_driver_list">
                                    <option value="">Select</option>
                                </select>
                            </p>

                            <table class="text-center table table-responsive table-bordered"
                                id="postal_consolidate_order_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">S/N</th>
                                        <th class="text-center">Consolidate Order No.</th>
                                        <th class="text-center">Customer Name</th>
                                        <th class="text-center">Recipient Name</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Mobile No.</th>
                                        <th class="text-center">Payment Term</th>
                                        <th class="text-center">Total Order</th>
                                        <th class="text-center">Cash Collectable</th>
                                        <th class="text-center">Delivery Date</th>
                                        <th class="text-center">Driver</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>

            </div>

        </div>


        <!-- Modal -->
        <div class="modal fade" id="viewConsolidateOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content p-2" id="viewConsolidateOrderData1">
                </div>
            </div>
        </div>

        <style>
            .select2 {
                width: 259px !important;
            }

            .select2-container .select2-selection--single {
                height: auto !important;
            }
        </style>

        <link rel="stylesheet" href="{{ asset('datatables/css/dataTables.checkboxes.css') }}">


    @section('javascript')
        <script src="//cdn.datatables.net/plug-ins/1.13.3/api/sum().js"></script>
        <script src="{{ asset('datatables/js/dataTables.checkboxes.min.js') }}"></script>
        <script>
            // $('.postal_select2').change(function() {
            //     console.log($('.assign_driver_by_post_code').val());
            // });


            $(function() {
                $('.postal_select2').select2();
            });

            function get_all_driver() {
                $.ajax({
                    url: "{{ route('get_all_driver') }}",
                    type: 'get',
                    dataType: 'json',
                    // data:function(data){
                    //     data.date = $('#postal_order_datepicker_from').val() == '' ? "{{ request()->date }}" : $('#postal_order_datepicker_from').val()
                    // },
                    data: {
                        date: $('#postal_order_datepicker_from').val() == '' ? "{{ request()->date }}" : $(
                            '#postal_order_datepicker_from').val()
                    },
                    beforeSend: function() {
                        $('.postal_select2').append('Loading...');
                    },
                    success: function(response) {
                        $('.postal_select2').empty();
                        $('.postal_select2').append(`<option value="">Select</option>`);
                        for (let i = 0; i <= response.length; i++) {
                            $('.postal_select2').append(
                                `<option value="${response[i]['driver_id']}">${response[i]['driver_name']} (${response[i]['total_order']})</option>`
                            );
                        }
                    }
                })
            }

            $(document).ready(function() {
                get_all_driver()

                $('#postal_order_datepicker_from').datepicker({
                    dateFormat: "dd/mm/yy"
                });

                $('#postal_order_datepicker_from').change(function() {
                    postal_consolidate_order_table.ajax.reload();
                    get_all_driver();
                });

                $('.reset').click(function() {
                    $('#postal_order_datepicker_from').val('');
                    $('#postal_order_datepicker_from').trigger('change');
                });

                postal_consolidate_order_table = $('#postal_consolidate_order_table').DataTable({
                    "aaSorting": [],
                    "bDestroy": true,
                    rowReorder: {
                        selector: 'td:nth-child(2)'
                    },
                    responsive: false,
                    // "scrollX": true,
                    dom: "Bfrtip",
                    pageLength: 10,
                    buttons: [
                        $.extend(true, {}, {
                            text: 'Export to Excel',
                            extend: 'excelHtml5',
                            className: 'btn btn-primary',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                            }
                        })
                    ],
                    ajax: {
                        url: "{{ route('list_order_by_post_code') }}",
                        type: 'GET',
                        data: function(data) {
                            data.post_code = "{{ request()->post_code }}",
                                data.date = $('#postal_order_datepicker_from').val() == '' ?
                                "{{ request()->date }}" : $('#postal_order_datepicker_from').val()
                        },
                    },
                    'columnDefs': [{
                        'targets': 0,
                        'checkboxes': {
                            'selectRow': true
                        }
                    }],
                    'select': {
                        'style': 'multi'
                    },
                    rowCallback: function(row, data, index) {
                        if (data[12] == true) {
                            $('td:eq(0)', row).find('.select-checkbox').remove();
                            $('td:eq(0)', row).find("input[type='checkbox']").remove();

                        }
                    },



                });
                $(document).find('#postal_consolidate_order_table').wrap(
                    '<div style="overflow-x:auto; width:100%;"></div>')



                // Handle form submission event
                $('.postal_select2').on('change', function(e) {
                    var select_driver = this;

                    var rows_selected = postal_consolidate_order_table.column(0).checkboxes.selected();

                    let order_no = [];
                    // Iterate over all selected checkboxes
                    $.each(rows_selected, function(index, rowId) {
                        // Create a hidden element
                        // console.log(rowId)
                        order_no.push(rowId);
                        // $.ajax({
                        //     url: "{{ route('SA-AddOnlineSaleDelivery1') }}",
                        //     type: 'GET',
                        //     data: {
                        //         driver_id: $('.postal_select2 option:selected').val(),
                        //         order_no: rowId,
                        //     },
                        //     success: function(response) {
                        //         if (response.success != null) {
                        //             toastr.success(response.success);
                        //             postal_consolidate_order_table.ajax.reload();
                        //             get_all_driver();
                        //         }
                        //         if (response.error != null) {
                        //             toastr.error(response.error);
                        //         }
                        //     }
                        // });
                    });


                    $.ajax({
                        url: "{{ route('SA-AddOnlineSaleDelivery1') }}",
                        type: 'GET',
                        data: {
                            driver_id: $('.postal_select2 option:selected').val(),
                            orders_no: order_no,
                        },
                        success: function(response) {
                            if (response.success != null) {
                                toastr.success(response.success);
                                postal_consolidate_order_table.ajax.reload();
                                get_all_driver();
                            }
                            if (response.error != null) {
                                toastr.error(response.error);
                            }
                        }
                    });


                });






            });

            $(document).on("click", "a[name = 'viewConsolidateOrder1']", function(e) {
                let id = $(this).data("id");

                $.ajax({
                    url: "{{ route('SA-ViewConsolidateOrderIndex') }}",
                    type: "GET",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        $('#viewConsolidateOrderData1').html(data);
                    }
                })

            });
        </script>
    @endsection

@endsection
