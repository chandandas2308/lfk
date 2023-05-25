                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Update Points</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="updateSignInForm">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points">Points<span style="color:red;">*</span></label>
                                        <input type="text" name="points" value="{{$data->points}}" class="form-control" id="points" required placeholder="Points">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status<span style="color:red;">*</span></label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="">--Select--</option>
                                            <option value="true" @if($data->status == true) selected @endif >Yes</option>
                                            <option value="false" @if($data->status == false) selected @endif >No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-primary">Clear</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
<script>
    $(document).ready(function(){
        $('#updateSignInForm').submit(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules:{
                points : {
                    required : true,
                },
                status : {
                    required : true,
                },
            },
            message:{},
            submitHandler: function(){
                
                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('sign_in.update', $data->id) }}",
                            enctype: "multipart/form-data",
                            type: "PUT",
                            data: $('#updateSignInForm').serialize(),
                            dataType : 'JSON',
                            // contentType: false,
                            // cache: false,
                            // processData: false,
                            success: function(result) {
                                
                                if(result.status == 'success'){
                                    jQuery("#updateSignInForm")["0"].reset();
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