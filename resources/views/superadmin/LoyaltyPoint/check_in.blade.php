<div class="p-3">
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
                Check In Setting
            </h4>
            <div class="d-flex">
                <a href="javascript:void(0)" onclick="addCheckIn()" class="nav-link bg-addbtn mx-2 rounded">Add</a>
            </div>
        </div>

        <!-- table start -->
        <div class="table-responsive">
        <table class="table table-responsive text-center table-bordered text-center" id="sign_in_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">User Name</th>
                        <th class="text-center">Email ID</th>
                        <th class="text-center">Day</th>
                        <th class="text-center">Gain Points</th>
                    </tr>
                </thead>
            </table>
        </div>
          
        <!-- table end here -->
    </div>

    <div class="modal fade" id="addSignIn" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" id="addSignInData">
                <!--  -->
            </div>
        </div>
    </div>
    <button style="display: none;" data-toggle="modal" data-target="#addSignIn" id="addSignInBtn">addSignIn</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
        
    $(document).ready(function() {
        sign_in_main_table = $('#sign_in_main_table').DataTable({
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
                url: "{{ route('check_in.index') }}",
                type: 'get',
            },
        })
    });

    function addCheckIn(){
        jQuery.ajax({
            url: "{{ route('check_in.create') }}",
            type: 'get',
            data: {
                'status' : 1
            },
            success: function(response){
                $('#addSignInBtn').click();
                $('#addSignInData').html(response);
            }
        })
    }

    function viewSignIn(id){
        jQuery.ajax({
            url: "{{ route('sign_in.create') }}",
            type: 'get',
            data: {
                'id' : id,
                'status' : 2
            },
            success: function(response){
                $('#addSignInBtn').click();
                $('#addSignInData').html(response);
            }
        })
    }

    function updateSignIn(id){
        jQuery.ajax({
            url: "{{ route('sign_in.create') }}",
            type: 'get',
            data: {
                'id' : id,
                'status' : 3
            },
            success: function(response){
                $('#addSignInBtn').click();
                $('#addSignInData').html(response);
            }
        })
    }

    function removeSignIn(id){
        bootbox.confirm("DO YOU WANT TO DELETE?", function(result) {
            if(result){
                jQuery.ajax({
                    url: "{{ route('sign_in.create') }}",
                    type: 'get',
                    data: {
                        'id' : id,
                        'status' : 4
                    },
                    success: function(response){
                        if(response.status == 'success'){
                            toastr.success(response.message);
                            sign_in_main_table.ajax.reload();
                        }
                    }
                })
            }
        })
    }

</script>