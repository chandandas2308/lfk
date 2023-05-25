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
                        id="postal_districts_datepicker_from" autocomplete="off" />
                    <button type="button" onclick="reset_list_of_postal_districts_table()"
                        class="btn-sm btn-primary">Reset</button>
                </p>

                <table class="text-center table table-responsive table-bordered" id="list_of_postal_districts_table">
                    <thead>
                        <tr>
                            <th class="text-center">Postal District.</th>
                            <th class="text-center">Postal Sector</th>
                            <th class="text-center">General Location</th>
                            <th class="text-center">Total Orders.</th>
                            <th class="text-center">Unassigned Orders.</th>
                            {{-- <th class="text-center">Action</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>

</div>

<script>
    function reset_list_of_postal_districts_table() {
        $('.date_range_filter').val('');
        list_of_postal_districts_table.ajax.reload();
    }

    $(document).ready(function() {
        $('#postal_districts_datepicker_from').datepicker({
            dateFormat: "dd/mm/yy"
        });


        list_of_postal_districts_table = $('#list_of_postal_districts_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength: 30,
            buttons: [
                $.extend(true, {}, {
                    text: 'Export to Excel',
                    extend: 'excelHtml5',
                    className: 'btn btn-primary',
                    stripHtml: false,
                    decodeEntities: true,
                    columns: ':visible',
                    modifier: {
                        selected: true
                    },
                    exportOptions: {
                        format: {
                            body: function(data, column, row) {
                                return data.replace(/<.*?>/ig, "");
                            }
                        }
                    }
                })
            ],
            ajax: {
                url: "{{ route('list_of_postal_districts') }}",
                type: 'GET',
                data: function(data) {
                    var date = $('#postal_districts_datepicker_from').val();
                    data.date = date;
                },
            }
        });
        $(document).find('#list_of_postal_districts_table').wrap('<div style="overflow-x:auto; width:100%;"></div>')


        $('#postal_districts_datepicker_from').change(function() {
            console.log($('#postal_districts_datepicker_from').val())
            list_of_postal_districts_table.ajax.reload();
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
