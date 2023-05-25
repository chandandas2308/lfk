                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Add</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="addCheckInForm">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Points</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Day 1</td>
                                        <td>
                                            <input type="text" @if(!empty($data)) value="{{$data->day1}}" @endif name="day1" placeholder="Day 1 Points" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Day 2</td>
                                        <td>
                                            <input type="text" @if(!empty($data)) value="{{$data->day2}}" @endif name="day2" placeholder="Day 2 Points" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Day 3</td>
                                        <td>
                                            <input type="text" @if(!empty($data)) value="{{$data->day3}}" @endif name="day3" placeholder="Day 3 Points" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Day 4</td>
                                        <td>
                                            <input type="text" @if(!empty($data)) value="{{$data->day4}}" @endif name="day4" placeholder="Day 4 Points" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Day 5</td>
                                        <td>
                                            <input type="text" @if(!empty($data)) value="{{$data->day5}}" @endif name="day5" placeholder="Day 5 Points" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Day 6</td>
                                        <td>
                                            <input type="text" @if(!empty($data)) value="{{$data->day6}}" @endif name="day6" placeholder="Day 6 Points" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Day 7</td>
                                        <td>
                                            <input type="text" @if(!empty($data)) value="{{$data->day7}}" @endif name="day7" placeholder="Day 7 Points" class="form-control">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
<script>

    $(document).ready(function(){
        $('#addCheckInForm').submit(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                day1 : {
                    required : true,
                },
                day2 : {
                    required : true,
                },
                day3 : {
                    required : true,
                },
                day4 : {
                    required : true,
                },
                day5 : {
                    required : true,
                },
                day6 : {
                    required : true,
                },
                day7 : {
                    required : true,
                },
            },
            message:{},
            submitHandler: function(){
                
                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        const formData = new FormData($('#addCheckInForm')["0"]);
                        console.log(formData);
                        jQuery.ajax({
                            url: "{{ route('check_in.store') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                
                                if(result.status == 'success'){
                                    jQuery("#addCheckInForm")["0"].reset();
                                    successMsg(result.message);
                                    sign_in_main_table.ajax.reload();
                                    $('#addSignIn .close').click();
                                }else{
                                    toastr.error(result);
                                }

                            }
                        });
                    }
                });
            }
        })
    });
</script>