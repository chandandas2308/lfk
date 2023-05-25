                    <div class="modal-header">
                        <h5 class="modal-title" id="BlogLongTitle">Add Voucher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="addVoucherForm">
                        @csrf
                        <div class="modal-body bg-white px-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color:red;">*</span></label>
                                        <input type="text" name="name" class="form-control" id="name" required placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="points">Points<span style="color:red;">*</span></label>
                                        <input type="text" name="points" class="form-control" id="points" required placeholder="Points">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="discount_type">Discount<span style="color:red;">*</span></label>
                                    <div class="form-control d-flex justify-content-between">
                                        <div class="border-bottom">
                                            <label for="discount_by_value_btn">Discount by Amount</label>
                                            <input type="radio" name="discount_type" id="discount_by_value_btn" value="discount_by_value_btn" checked onchange="discountRadioBtnFn1()" />
                                        </div>
                                        <div class="border-bottom">
                                            <label for="discount_by_precentage_btn">Discount by Percentage</label>
                                            <input type="radio" name="discount_type" id="discount_by_precentage_btn" value="discount_by_precentage_btn" onchange="discountRadioBtnFn1()" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="discount_by_precentage">
                                    <div class="form-group">
                                        <label for="discount">Discount (By Percentage)<span style="color:red;">*</span></label>
                                        <input type="text" name="discount_percentage" class="form-control" id="discount" placeholder="Discount">
                                    </div>
                                </div>
                                <div class="col-md-6" id="discount_face_value">
                                    <div class="form-group">
                                        <label for="discount">Discount (By Amount)<span style="color:red;">*</span></label>
                                        <input type="text" name="discount_amount" class="form-control" id="discount" placeholder="Discount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry_date">Expiry Date<span style="color:red;">*</span></label>
                                        <input type="date" name="expiry_date" placeholder="dd-mm-yyyy" class="form-control" id="expiry_date" required placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">Image<span style="color:red;">*</span></label>
                                        <input type="file" name="image" id="image" required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-primary">Clear</button>
                            <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>


                    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
                    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
                    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

                    <script>

discountRadioBtnFn1();
    function discountRadioBtnFn1() {
        if ($('#discount_by_value_btn').prop('checked') != true) {
            $('#discount_face_value').hide();
            $('#discount_face_value').attr('disabled', true);
            $('#discount_by_precentage').show();
            $('#discount_by_precentage').removeAttr('disabled');
        } else {
            $('#discount_face_value').show();
            $('#discount_face_value').removeAttr('disabled');
            $('#discount_by_precentage').hide();
            $('#discount_by_precentage').attr('disabled', true);
        }
    }

                        $(document).ready(function() {
                            $('#addVoucherForm').submit(function(e) {
                                e.preventDefault();
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    },
                                });

                                    bootbox.confirm(" DO YOU WANT TO SAVE?", function(result) {
                                        if (result) {
                                            const formData = new FormData($('#addVoucherForm')["0"]);
                                            jQuery.ajax({
                                                url: "{{ route('redemption_shop.store') }}",
                                                enctype: "multipart/form-data",
                                                type: "post",
                                                data: formData,
                                                contentType: false,
                                                cache: false,
                                                processData: false,
                                                success: function(result) {

                                                    if (result.status == 'success') {
                                                        jQuery("#addVoucherForm")["0"].reset();
                                                        successMsg(result.message);
                                                        voucher_main_table.ajax.reload();
                                                        $('#addVoucher .close').click();
                                                    } else {
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