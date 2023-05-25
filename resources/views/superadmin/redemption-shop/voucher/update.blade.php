                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Update Voucher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="updateVoucherForm">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color:red;">*</span></label>
                                        <input type="text" name="name" value="{{$data->name}}" class="form-control" id="name" required placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points">Points<span style="color:red;">*</span></label>
                                        <input type="text" name="points" value="{{$data->points}}" class="form-control" id="points" required placeholder="Points">
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount">Discount(%)<span style="color:red;">*</span></label>
                                        <input type="text" name="discount" value="{{$data->discount}}" class="form-control" id="discount" required placeholder="Discount">
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    <label for="discount_type">Discount<span style="color:red;">*</span></label>
                                    <div class="form-control d-flex justify-content-between">
                                        <div class="border-bottom">
                                            <label for="discount_by_value_btn1">Discount by Amount</label>
                                            <input type="radio" name="discount_type" id="discount_by_value_btn1" value="discount_by_value_btn" @if($data->discount_type!="discount_by_precentage_btn") checked @endif onchange="discountRadioBtnFn2()" />
                                        </div>
                                        <div class="border-bottom">
                                            <label for="discount_by_precentage_btn1">Discount by Percentage</label>
                                            <input type="radio" name="discount_type" id="discount_by_precentage_btn1" value="discount_by_precentage_btn" @if($data->discount_type!="discount_by_value_btn") checked @endif onchange="discountRadioBtnFn2()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="discount_by_precentage1">
                                    <div class="form-group">
                                        <label for="discount">Discount (By Percentage)<span style="color:red;">*</span></label>
                                        <input type="text" name="discount_percentage" value="{{$data->discount}}" class="form-control" id="discount" placeholder="Discount">
                                    </div>
                                </div>
                                <div class="col-md-6" id="discount_face_value1">
                                    <div class="form-group">
                                        <label for="discount">Discount (By Amount)<span style="color:red;">*</span></label>
                                        <input type="text" name="discount_amount" value="{{$data->discount}}" class="form-control" id="discount" placeholder="Discount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date<span style="color:red;">*</span></label>
                                        <input type="date" name="expiry_date" value="{{$data->expiry_date}}" class="form-control" id="expiry_date" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image<span style="color:red;">*</span></label>
                                        <input type="file" name="image" id="image" required class="form-control">
                                        <img src="{{$data->image}}" height="100" width="100" alt="" />
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


discountRadioBtnFn2();
    function discountRadioBtnFn2() {
        if ($('#discount_by_value_btn1').prop('checked') != true) {
            $('#discount_face_value1').hide();
            $('#discount_face_value1').attr('disabled', true);
            $('#discount_by_precentage1').show();
            $('#discount_by_precentage1').removeAttr('disabled');
        } else {
            $('#discount_face_value1').show();
            $('#discount_face_value1').removeAttr('disabled');
            $('#discount_by_precentage1').hide();
            $('#discount_by_precentage1').attr('disabled', true);
        }
    }

    $(document).ready(function(){
        $('#updateVoucherForm').submit(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
                
                bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                    if(result){
                        jQuery.ajax({
                            url: "{{ route('redemption_shop.update', $data->id) }}",
                            enctype: "multipart/form-data",
                            type: "PUT",
                            data: $('#updateVoucherForm').serialize(),
                            dataType : 'JSON',
                            // contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {
                                
                                if(result.status == 'success'){
                                    jQuery("#updateVoucherForm")["0"].reset();
                                    successMsg(result.message);
                                    voucher_main_table.ajax.reload();
                                    $('#addVoucher .close').click();
                                }else{
                                    toastr.error(result);
                                }

                            }
                        });
                    }
                });
            // }
        })
    });
</script>