<!-- Modal -->
<div class="modal fade" id="adddriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Delivery Man</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="post" id="addDriverForm">
                <div class="modal-body bg-white px-3">

                    <!-- <div class="card">
            <div class="card-body"> -->

                    <div class="form-group">
                        <label for="driver_name">Delivery Man Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="driver_name" name="driver_name"
                            placeholder="Driver Name" />
                    </div>

                    <div class="form-group">
                        <label for="driver_mobile_no">Delivery Man Mobile No <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="driver_mobile_no" name="driver_mobile_no"
                            maxlength="15" placeholder="Driver Mobile No"
                            onkeypress='return event.charCode >= 48 && event.charCode <= 57' />
                    </div>

                    <div class="form-group">
                        <label for="driver_email">Delivery Man Email <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="driver_email" name="driver_email"
                            placeholder="Driver Email" />
                    </div>
                    <div class="form-group">
                        <label for="Region">Commission </label>
                        <input type="text" class="form-control" id="commission" name="commission"
                            placeholder="Commission" />
                    </div>

                    <div class="form-group">
                        <label for="Region">Password <span style="color: red;">*</span></label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password" />
                    </div>

                    <!-- </div>
          </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="addDriverClearFormBtn">Clear</button>
                    <button type="submit" id="addDriverForm1" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // clear form
    jQuery('#addDriverClearFormBtn').on('click', function() {
        jQuery("#addDriverForm")["0"].reset();
    });

    // validation script start here
    $(document).ready(function() {
        // store data in db
        jQuery("#addDriverForm").submit(function(e) {
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
                    required: "Please choose Driver name",
                },
                driver_mobile_no: {
                    required: "Driver Mobile No is required",
                    minlength: "Driver phone number should be 7 digits",
                    maxlength: "Driver phone number should be 15 digits"
                },
                driver_email: {
                    required: "Driver Email is required",
                },
  
            },
            submitHandler: function() {
                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        jQuery.ajax({
                            url: "{{ route('SA-AddDriver') }}",
                            data: jQuery("#addDriverForm").serialize(),
                            enctype: "multipart/form-data",
                            type: "post",
                            dataType: 'json',
                            success: function(result) {
                                if (result.success != null) {
                                    jQuery(".alert-danger").hide();
                                    successMsg(result.success);
                                    $('.modal .close').click();
                                    jQuery("#addDriverForm")["0"].reset();
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
        $('#driver_mobile_no').on('blur', function() {
            var char = $(this).val();
            var charLength = $(this).val().length;
            if (charLength < 7) {
                $('#driver_mobile_no').val('');
            } else {

            }
        });
    });
</script>
