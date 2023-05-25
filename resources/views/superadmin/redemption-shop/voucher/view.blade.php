                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Voucher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color:red;">*</span></label>
                                        <input type="text" name="name" value="{{$data->name}}" disabled class="form-control" id="name" required placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points">Points</label>
                                        <input type="text" name="points" value="{{$data->points}}" disabled class="form-control" id="points" required placeholder="Points">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_type">Discount<span style="color:red;">*</span></label>
                                    <div class="form-control d-flex justify-content-between">
                                        <div class="border-bottom">
                                            <label for="discount_by_value_btn2">Discount by Amount</label>
                                            <input type="radio" name="discount_type" id="discount_by_value_btn2" disabled value="discount_by_value_btn" @if($data->discount_type!="discount_by_precentage_btn") checked @endif onchange="discountRadioBtnFn3()" />
                                        </div>
                                        <div class="border-bottom">
                                            <label for="discount_by_precentage_btn2">Discount by Percentage</label>
                                            <input type="radio" name="discount_type" id="discount_by_precentage_btn2" disabled value="discount_by_precentage_btn" @if($data->discount_type!="discount_by_value_btn") checked @endif onchange="discountRadioBtnFn3()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="discount_by_precentage2">
                                    <div class="form-group">
                                        <label for="discount">Discount (By Percentage)<span style="color:red;">*</span></label>
                                        <input type="text" name="discount_percentage" value="{{$data->discount}}" disabled class="form-control" id="discount" placeholder="Discount">
                                    </div>
                                </div>
                                <div class="col-md-6" id="discount_face_value2">
                                    <div class="form-group">
                                        <label for="discount">Discount (By Amount)<span style="color:red;">*</span></label>
                                        <input type="text" name="discount_amount" value="{{$data->discount}}" disabled class="form-control" id="discount" placeholder="Discount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date<span style="color:red;">*</span></label>
                                        <input type="date" name="expiry_date" disabled value="{{$data->expiry_date}}" class="form-control" id="expiry_date" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <img src="{{$data->image}}" height="100" width="100" />
                                    </div>
                                </div>
                            </div>
                            @php $i = 0; @endphp
                                <table class="display nowrap" style="width:100%; overflow-x:auto;">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>User ID</th>
                                            <th>User Name</th>
                                            <th>Voucher Code</th>
                                            <th>Expiry Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($voucher as $key=>$value)
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td>{{$value->user_id}}</td>
                                                <td>{{$value->name}}</td>
                                                <td>{{$value->code}}</td>
                                                <td>{{$value->expiry_date}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                        </div>

                        <script>
                            
discountRadioBtnFn3();
    function discountRadioBtnFn3() {
        if ($('#discount_by_value_btn2').prop('checked') != true) {
            $('#discount_face_value2').hide();
            $('#discount_face_value2').attr('disabled', true);
            $('#discount_by_precentage2').show();
            $('#discount_by_precentage2').removeAttr('disabled');
        } else {
            $('#discount_face_value2').show();
            $('#discount_face_value2').removeAttr('disabled');
            $('#discount_by_precentage2').hide();
            $('#discount_by_precentage2').attr('disabled', true);
        }
    }
                        </script>