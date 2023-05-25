<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Transaction History
            </h4>
        </div>

        <!-- table start -->
        <div class="table-responsive">
        <table class="text-center table table-responsive table-bordered" id="loyaltyPointsHistory"  style="width: 100%;border: 2px ridge black; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email ID</th>
                        <th class="text-center">Gained Points</th>
                        <th class="text-center">Spend Points</th>
                        <th class="text-center">Remaining Points</th>
                        <th class="text-center">Transaction Date</th>
                    </tr>
                </thead>
            </table>
        </div>     

</div>

<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>

    $(document).ready(function() {
        loyaltyPointsHistory = $('#loyaltyPointsHistory').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            // "scrollX": true,
            dom: "Bfrtip",
            pageLength:8,
            buttons: [],
            ajax: {
                url: "{{ route('SA-loyaltyPoints') }}",
                type: 'GET',
            }
        });
    });

</script>
