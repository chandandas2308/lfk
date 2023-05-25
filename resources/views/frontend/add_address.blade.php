<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog my-auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{ __('lang.add_address') }}</h4>
            </div>
            <form class="text-left clearfix" id="addAddressForm2" method="POST">
                @csrf
                <div class="modal-body">

                    <!--  -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="name"
                            placeholder="{{ __('lang.full_name') }}">
                    </div>

                    <!--  -->
                    <div class="form-group">
                        <input type="tel" class="form-control" name="mobile_number"
                            placeholder="{{ __('lang.mobile_number') }}">
                    </div>


                    <!--  -->
                    <div class="form-group">
                        <input type="text" name="postcode" id="customerPostalCode" class="form-control"
                            placeholder="{{ __('lang.postal_code') }}">
                    </div>

                    <!--  -->
                    <div class="form-group">
                        <textarea type="text" class="form-control" id="addressId" name="address" placeholder="{{ __('lang.address') }}"
                            readonly></textarea>
                    </div>

                    <!--  -->
                    <div class="form-group">
                        <input type="text" name="unit_number" id="unitNumber" class="form-control"
                            placeholder="{{ __('lang.unit_no') }}">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-small btn-solid-border" data-dismiss="modal">Close</button>
                    <button type="submit" id="completeSave" class="btn btn-small" disabled>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"
    integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).on('click', '#clearAddAddressForm', function() {
        $('#addAddressForm2')["0"].reset();
    })

    jQuery('#addAddressForm2').submit(function(e) {
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
                number: true,
                minlength: 8,
                maxlength: 8,
            },
            address: {
                required: true,
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
            address: {
                required: "Please enter valid postcode",
            },
            unit_number: {
                required: "Please enter unit number",
            },
            postcode: {
                required: "Please enter your postcode",
                minlength: "Please enter at least 6 digits."
            },
        },
        submitHandler: function() {
            $.ajax({
                url: "{{ route('Add-Address') }}",
                method: "POST",
                data: $('#addAddressForm2').serialize(),
                success: function(data) {
                    @if (isset($consolidate_order_no))
                        fetchAllAddress1();
                    @endif
                    toastr.success(data.success);
                    addresses.ajax.reload();
                    $('#addAddressForm2')["0"].reset();

                    $('#basicModal').click();

                    fetchAllAddress();
                    $('#basicModal').modal('hide');
                },
                error: function(data) {
                    toastr.error(data.success);
                }
            })
        }
    })

    // API for Address
    $(document).on('change', '#customerPostalCode', function() {
        let fullAddress = $(this).val();
        if (fullAddress.toString().length == 6) {
            jQuery.ajax({
                url: "{{ route('user.postaladdresses') }}",
                type: "get",
                data: {
                    postalcode: $(this).val()
                },

                beforeSend: function() {
                    $('#addressId').val('Loading...');
                },
                success: function(response) {
                    if (JSON.parse(response).found == 0) {
                        $('#addressId').val('');
                        $('#customerPostalCode').val('');
                        toastr.error('Please Enter Valid Postal Code');
                    } else {
                        $('#addressId').val(JSON.parse(response).results[0].ADDRESS);
                        $('#completeSave').removeAttr('disabled');
                    }
                }
            });
        } else {
            toastr.error('Please Enter 6 digits  Postal Code');

        }

    });

    function fetchAllAddress() {

        let k = 0;

        $.ajax({
            url: "{{ route('user.addressesCards') }}",
            type: 'get',
            beforeSend: function() {
                $('#addressesCards').html("Loading...");
            },
            success: function(response) {

                $('#addressesCards').html('');
                if (response.data.length > 0) {

                    $('.checkout-form > input[type=submit]').removeAttr('disabled');
                    $('.checkout-form > input[type=submit]').removeAttr('title');

                    // $('#subTotalOnCheckout').html(parseFloat(response.session.sub_total).toFixed(2));
                    // // add my code 
                    // $('#checkoutShipping').html('$' + parseFloat(response.session.shipping_charge).toFixed(
                    //     2));
                    // $('#grand_total').html('$' + parseFloat(response.session.final_price).toFixed(2));
                    // // end my code
                    // if (response.session.payment_mode == "hitpay") {
                    //     $('#paymentModeCOD').attr('disabled', true);
                    //     $('#paymentModeOnline').removeAttr('disabled');
                    //     $('#paymentModeCOD').removeAttr('checked');
                    //     $('#paymentModeOnline').attr('checked', true);
                    // } else if (response.session.payment_mode == "COD") {
                    //     $('#paymentModeOnline').attr('disabled', true);
                    //     $('#paymentModeOnline').removeAttr('checked');
                    //     $('#paymentModeCOD').removeAttr('disabled');
                    //     $('#paymentModeCOD').attr('checked', true);
                    // } else {
                    //     $('#paymentModeOnline').removeAttr('disabled');
                    //     $('#paymentModeOnline').removeAttr('checked');
                    //     $('#paymentModeCOD').removeAttr('disabled');
                    //     $('#paymentModeCOD').removeAttr('checked');
                    // }

                } else {
                    $('#addressesCards').html('Addresses Not Found!');
                    $('.checkout-form > input[type=submit]').attr('title', 'ADD ADDRESS TO PLACE ORDER');
                }
                let last_user_address = "{{ $last_user_address }}";
                $.each(response.data, function(key, value) {
                    $('#addressesCards').append(`
                    <label class="card">
                        <input name="address_id" class="radio" onClick="getAddress(${value["id"]})" value="${value["id"]}" ${last_user_address == value["id"]?"checked":""} type="radio" >
                        <span class="plan-details">
                            <span class="plan-type">${value["name"]}</span>
                            <span>postal Code:#${value["postcode"]}</span>
                            <span>${value["address"]}</span>
                            <span>Mobile No.:${value["mobile_number"]}</span>
                            <span>Unit No.:${value["unit"]}</span>
                        </span>
                    </label>
                `);
                    ++k;
                })

            }
        })
    }
</script>
