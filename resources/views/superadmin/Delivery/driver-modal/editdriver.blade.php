<!-- Modal -->
<div class="modal fade" id="editdriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Driver</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="editDriverForm">
                <div class="modal-body bg-white px-3">

                    <input type="hidden" name="edit_id" id="edit_id">

                    <div class="form-group">
                        <label for="driver_name">Delivery Man Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="editdriver_name" name="driver_name"
                            placeholder="Driver Name" />
                    </div>

                    <div class="form-group">
                        <label for="driver_mobile_no">Delivery Man Mobile No <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="editdriver_mobile_no" name="driver_mobile_no"
                            maxlength="10" placeholder="Driver Mobile No"
                            onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                    </div>

                    <div class="form-group">
                        <label for="driver_email">Delivery Man Email <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="editdriver_email" name="driver_email"
                            placeholder="Driver Email" />
                    </div>

                    <div class="form-group">
                        <label for="Region">Commission </label>
                        <input type="text" class="form-control" id="editCommission" name="editCommission"
                            placeholder="Commission" />
                    </div>

                    <div class="form-group">
                        <label for="Region">Password </label>
                        <input type="text" class="form-control" id="edit_password" name="edit_password"
                            placeholder="Password" />
                    </div>

                    <!-- </div>
          </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="editDriverClearFormBtn">Clear</button>
                    <button type="submit" id="editDriverForm1" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // clear form
    jQuery('#editDriverClearFormBtn').on('click', function() {
        jQuery("#editDriverForm")["0"].reset();
    });

    // validation script start here
    $(document).ready(function() {
        // store data in db
        jQuery("#editDriverForm").submit(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });

            $.validator.addMethod("validate", function(value) {
                return /[A-Za-z]/.test(value);
            });

        }).validate({
            rules: {

                driver_name: {
                    required: true,
                },

                driver_mobile_no: {
                    required: true,
                    minlength: 7,
                    maxlength: 15,
                },

                driver_email: {
                    required: true,
                },
            },
            messages: {
                driver_name: {
                    required: "Please choose Driver name.",
                },
                driver_mobile_no: {
                    required: "Driver Mobile No is required.",
                },
                driver_email: {
                    required: "Driver Email is required.",
                },
            },
            submitHandler: function() {

                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        jQuery.ajax({
                            url: "{{ route('SA-EditDriver') }}",
                            data: jQuery("#editDriverForm").serialize(),
                            enctype: "multipart/form-data",
                            type: "post",

                            success: function(result) {
                                if (result.success != null) {
                                    jQuery(".alert-danger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#editDriverForm")["0"].reset();
                                    driver_main_table.ajax.reload();
                                }
                            },
                            error: function(error) {
                                show_error_msg(error);
                            }
                        });
                    }
                });

            }
        });
    });
    // end here

    $(document).ready(function() {
        $('#editdriver_mobile_no').on('blur', function() {
            var char = $(this).val();
            var charLength = $(this).val().length;
            if (charLength < 7) {
                $('#editdriver_mobile_no').val('');
            } else {

            }
        });
    });
</script>
