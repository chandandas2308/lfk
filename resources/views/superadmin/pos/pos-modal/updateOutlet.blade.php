<div class="modal fade" id="updateOutlet" tabindex="-1" role="dialog" aria-labelledby="BlogCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="BlogLongTitle">Update Outlet</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" id="updateOutletForm">
                @csrf
                <div class="modal-body bg-white px-3">

                    <input type="hidden" name="id" id="update_outlet_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_outletName">Name<span style="color:red;">*</span></label>
                                <input type="text" name="name" class="form-control" id="update_outletName" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_outletEmail">Email ID<span style="color:red;">*</span></label>
                                <input type="email" name="email" class="form-control" id="update_outletEmail" placeholder="Email ID">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_outlet_mobile_number">Mobile Number<span style="color:red;">*</span></label>
                                <input type="tel" name="mobile_number" class="form-control" id="update_outlet_mobile_number" placeholder="Mobile Number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_outletPostCode">Postcode<span style="color:red;">*</span></label>
                                <input type="text" name="postcode" class="form-control" id="update_outletPostCode" placeholder="Postcode">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_outlet_address">Address<span style="color:red;">*</span></label>
                                <!-- <select name="address" id="update_outlet_address" class="form-control">
                                            <option value="">Select Address</option>
                                        </select> -->
                                <textarea name="address" id="update_outlet_address" class="form-control" placeholder="Address"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="update_outletUnitCode">Unit<span style="color:red;">*</span></label>
                                <input type="text" name="unitCode" id="update_outletUnitCode" class="form-control" placeholder="unit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateOUtletForm">Clear</button>
                    <button type="submit" value="Submit" class="btn btn-primary">Save</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).on('click', '#updateOUtletForm', function() {
        $('#updateOutletForm')[0].reset();
    });

    $(document).ready(function() {
        jQuery('#updateOutletForm').submit(function(e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        }).validate({
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                mobile_number: {
                    required: true,
                },
                postcode: {
                    required: true,
                },
                address: {
                    required: true,
                },
                unitCode: {
                    required: true,
                },
            },
            message: {},
            submitHandler: function() {

                bootbox.confirm("DO YOU WANT TO SAVE?", function(result) {
                    if (result) {
                        const formData = new FormData($('#updateOutletForm')["0"]);
                        jQuery.ajax({
                            url: "{{ route('SA-PosUpdateOutlet') }}",
                            enctype: "multipart/form-data",
                            type: "post",
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function(result) {

                                if (result.success != null) {
                                    jQuery("#updateOutletForm")["0"].reset();
                                    successMsg(result.success);
                                    outlet_table_caption.ajax.reload();
                                    $('#updateOutlet .close').click();
                                } else {
                                    errorMsg(result.error);
                                }
                            }
                        });
                    }
                });
            }
        })
    });

    $(document).on('change', '#update_outletPostCode', function() {
        let fullAddress = $(this).val();

        if (fullAddress.toString().length == 6) {


            jQuery.ajax({
                url: "{{route('user.postaladdresses')}}",
                type: "get",
                data: {
                    postalcode: $(this).val()
                },
                beforeSend: function() {
                    $('#full_address').val('Loading...');
                },
                success: function(response) {
                    if (JSON.parse(response).found == 0) {
                        $('#update_outlet_address').val('');
                        $('#update_outletPostCode').val('');
                        toastr.error('Please Enter Valid Postal Code');

                    } else {
                        $('#update_outlet_address').val(JSON.parse(response).results[0].ADDRESS);

                    }

                }
            });
        } else {
            toastr.error('Please Enter 6 digits  Postal Code');

        }
    });
</script>