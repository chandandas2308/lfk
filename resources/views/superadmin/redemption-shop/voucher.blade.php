    <div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Voucher
            </h4>
            <div class="d-flex">
                <a href="javascript:void(0)" onclick="addVoucher()" class="nav-link bg-addbtn mx-2 rounded">Add Voucher</a>
            </div>
        </div>

        <!-- table start -->
        <div class="table-responsive">
        <table class="text-center table table-responsive table-bordered" id="voucher_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Points</th>
                        <th class="text-center">Discount</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
         
        <!-- table end here -->
    </div>

    <div class="modal fade" id="addVoucher" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" id="addVoucherData">
                <!--  -->
            </div>
        </div>
    </div>
    <button style="display: none;" data-toggle="modal" data-target="#addVoucher" id="addVoucherBtn">addVoucher</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
        
    $(document).ready(function() {
        voucher_main_table = $('#voucher_main_table').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            responsive: false,
            dom: "Bfrtip",
            pageLength:10,
            buttons:[],
            ajax: {
                url: "{{ route('redemption_shop.index') }}",
                type: 'get',
            },
        })
    });

    function addVoucher(){
        jQuery.ajax({
            url: "{{ route('redemption_shop.create') }}",
            type: 'get',
            data: {
                'status' : 1
            },
            success: function(response){
                $('#addVoucherBtn').click();
                $('#addVoucherData').html(response);
            }
        })
    }

    function viewVoucher(id){
        jQuery.ajax({
            url: "{{ route('redemption_shop.create') }}",
            type: 'get',
            data: {
                'id' : id,
                'status' : 2
            },
            success: function(response){
                $('#addVoucherBtn').click();
                $('#addVoucherData').html(response);
            }
        })
    }

    function updateVoucher(id){
        jQuery.ajax({
            url: "{{ route('redemption_shop.create') }}",
            type: 'get',
            data: {
                'id' : id,
                'status' : 3
            },
            success: function(response){
                $('#addVoucherBtn').click();
                $('#addVoucherData').html(response);
            }
        })
    }

    function removeVoucher(id){
        bootbox.confirm("DO YOU WANT TO DELETE?", function(result) {
            if(result){
                jQuery.ajax({
                    url: "{{ route('redemption_shop.create') }}",
                    type: 'get',
                    data: {
                        'id' : id,
                        'status' : 4
                    },
                    success: function(response){
                        if(response.status == 'success'){
                            toastr.success(response.message);
                            voucher_main_table.ajax.reload();
                        }
                    }
                })
            }
        })
    }

</script>