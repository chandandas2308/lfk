<div class="p-3">
    <!-- invoice Tab -->
        <div class="page-header flex-wrap">
            <h4 class="mb-0">
            Referral Awards
            </h4>
            <div class="d-flex">
                <a href="#" onclick="jQuery('#delRefferalAlert').hide()" class="nav-link bg-addbtn mx-2 rounded" data-toggle="modal" data-target="#createReffereal"> Referral Point Setting </a>
            </div>
        </div>
        <!-- alert section -->
            <div class="alert alert-success" id="delRefferalAlert" style="display:none"></div>
        <!-- alert section end-->

        <!-- table start -->
        <div class="table-responsive">
        <table class="text-center table table-responsive table-bordered" id="refferal_main_table">
                <thead>
                    <tr>
                        <th class="text-center">S/N</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Customer Name</th>
                        <th class="text-center">Referral Code</th>
                        <th class="text-center">Referral By</th>
                        <th class="text-center">Points</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
          
        <!-- table end here -->
</div>

<!-- Create Invoice Model -->
@include('superadmin.refferal.refferal-modal.createrefferalModal')
<!-- Model -->

<!-- jQuery CDN -->
<script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
      integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<!-- backend js file -->

<script>

    $(document).ready(function() {
        refferal_main_table = $('#refferal_main_table').DataTable({
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
                url: "{{ route('SA-GetRefferals') }}",
                type: 'GET',
            }
        });
    });

    // $(document).ready(function(){
    //     GetRefferalDetails();
    // });
    // // All quotaion Details
    // function GetRefferalDetails(){
    //     $.ajax({
    //         type : "GET" ,
    //         url : "{{ route('SA-GetRefferals') }}",
    //         success : function (response){
    //             let i = 0;
    //             jQuery('.Refferal-list').html('');
    //             jQuery.each(response, function (key, value){
                    
    //                 $('.Refferal-list').append('<tr>\
    //                     <td class="p-2 border border-secondary">'+ ++i +'</td>\
    //                     <td class="p-2 border border-secondary">'+ value["id"] +'</td>\
    //                     <td class="p-2 border border-secondary">'+ value["created_at"] +'</td>\
    //                     <td class="p-2 border border-secondary">'+ value["created_at"] +'</td>\
    //                     <td class="p-2 border border-secondary">'+ value['customer_name'] +'</td>\
    //                     <td class="p-2 border border-secondary">'+ value["refferal_code"] +'</td>\
    //                     <td class="p-2 border border-secondary">'+ value["refferal_by"] +'</td>\
    //                     <td class="p-2 border border-secondary">'+ value["points"] +'</td>\
    //                     <td class="p-2 border border-secondary"><a name="deleteGetRefferal" data-id="'+value["id"]+'" > <i class="mdi mdi-delete"></i> </a></td>\
    //                 </tr>');
    //             });
    //         }
    //     });
    // }
    // // End function here
  
    // delete a single quotation using id
    $(document).on("click", "a[name = 'deleteGetRefferal']", function (e){
        let id = $(this).data("id");
        delRemoveRefferals(id);
        function delRemoveRefferals(id){
            $.ajax({
                type : "GET",
                url : "{{ route('SA-RemoveRefferals')}}",
                data : {
                    'id' : id,
                },
                success : function (response){
                    toastr.success(response.success);
                    refferal_main_table.ajax.reload();
                }
            });
        }
    });    
    
</script>