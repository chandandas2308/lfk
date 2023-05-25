<div class="modal fade" id="updateAddress" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog my-auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{ __('lang.update_address') }}</h4>
            </div>
            <form class="text-left clearfix" id="updateAddress2" method="POST">
                @csrf
                <div class="modal-body">

                    <!--  -->
                    <input type="hidden" name="id" id="address_id">
                    <!--  -->

                    <!--  -->
                    <div class="form-group">
                        <input type="text" class="form-control" id="customer_full_name" name="name"
                            placeholder="{{ __('lang.full_name') }}">
                    </div>

                    <!--  -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile_number" id="address_mobile_number"
                            placeholder="{{ __('lang.mobile_number') }}">
                    </div>
                    <!--  -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="postcode" id="current_postcode"
                            placeholder="{{ __('lang.postal_code') }}">
                    </div>
                    <!--  -->
                    <div class="form-group">
                        <textarea type="text" class="form-control" id="full_address" name="editAddress"
                            placeholder="{{ __('lang.address') }}" readonly></textarea>
                    </div>
                    <!--  -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="unit_number" id="unit_number"
                            placeholder="{{ __('lang.unit_no') }}">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-small btn-solid-border" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="editCompleteSave">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('frontend/plugins/jquery/dist/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    jQuery('#clearUpdateAddressForm').on('click', function() {
        jQuery('#updateAddress2')["0"].reset();
    });

    jQuery('#updateAddress2').submit(function(e) {
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
            mobile_number: {
                required: true,
                minlength: 8,
                maxlength: 8,
            },
            unit_number: {
                required: true,
            },
            postcode: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            name: {
                required: "Please enter your full name",
            },
            mobile_number: {
                required: "Please enter your mobile number",
                minLength: "{{ __('lang.min_8') }}",
                maxlength: "{{ __('lang.no_more_8') }}"
            },
            unit_number: {
                required: "Please enter unit number",
            },
            postcode: {
                required: "Please enter valid postcode",
                minlength: "Please enter at least 6 digits.",
            },
        },
        submitHandler: function() {
            $.ajax({
                url: "{{ route('Update-Address') }}",
                method: "POST",
                data: $('#updateAddress2').serialize(),
                success: function(data) {
                    toastr.success(data.success);
                    addresses.ajax.reload();
                    $('#updateAddress2')['0'].reset();
                    $('#updateAddress').modal('hide');
                },
                error: function(error) {
                    toastr.error(error.success);
                }
            })
        }
    })

    // edit user details
    $(document).on("click", "a[name = 'updateAddress']", function(e) {
        let id = $(this).data("id");
        updateAddress(id);

        function updateAddress(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('Fetch-Single-Address') }}",
                data: {
                    'id': id,
                },
                success: function(response) {
                    $('#address_id').val(response['id']);
                    $('#customer_full_name').val(response['name']);
                    $('#full_address').val(response['address']);
                    // $('#full_address').append(`<option value="${response['address']}">${response['address']}</option>`);
                    $('#unit_number').val(response['unit']);
                    $('#current_postcode').val(response['postcode']);
                    $('#address_mobile_number').val(response['mobile_number']);
                }
            });
        }
    });
    // API
    $(document).on('change', '#current_postcode', function() {
        let fullAddress = $(this).val();

        if (fullAddress.toString().length == 6) {

            jQuery.ajax({

                url: "{{ route('user.postaladdresses') }}",
                type: "get",
                data: {
                    postalcode: $(this).val()
                },
                beforeSend: function() {
                    $('#full_address').val('Loading...');
                },
                success: function(response) {
                    if (JSON.parse(response).found == 0) {
                        $('#full_address').val('');
                        $('#current_postcode').val('');
                        toastr.error('Please Enter Valid Postal Code');

                    } else {
                        $('#full_address').val(JSON.parse(response).results[0].ADDRESS);
                        // $('#editCompleteSave').removeAttr('disabled');

                    }


                }
            });
        } else {
            toastr.error('Please Enter 6 digits  Postal Code');

        }
    });
</script>
