<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form method="post" id="salesEditInvoiceForm">
    <div class="modal-body bg-white px-3">
        <div class="form-group row">
            <div class="col-md-6">
                <img src="{{ $data->image ?? asset('frontend/images/avater.jpg') }}" alt="Customer Image" style="width: 200px">
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 col-form-label">Order No:</div>
                    <div class="col-md-6 col-form-label">
                        {{ $data->consolidate_order_no }}
                    </div>
                </div>
                @php
                    $address = DB::table('addresses')
                        ->where('id', $data->address_id)
                        ->first();
                @endphp
                <div class="row">
                    <div class="col-md-6 col-form-label">Customer Name:</div>
                    <div class="col-md-6 col-form-label" id="change_address_name">
                        {{ $address->name }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-form-label">Phone Number:</div>
                    <div class="col-md-6 col-form-label" id="change_address_phone_number">
                        {{ $address->mobile_number }}
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-2 col-form-label">Delivery Date.</div>
            <div class="col-md-4">
                <input type="text" name="delivery_date" placeholder="Delivery Date."
                    class="form-control text-dark date change_order_delivery_date" value="{{ $data->delivery_date }}" />
            </div>
            <div class="col-md-2 col-form-label">Delivery Address.</div>
            <input type="hidden" name="address_id" id="change_address_id">
            <div class="col-md-2 " id="address_and_unit">
                {{ $address->address }} {{ $address->unit }}
            </div>
            <div class="col-md-2">
                <a href="javascript::void(0)" style="color: blue" data-toggle="modal"
                    data-target="#change_address_modal" id="change_address_modal_btn"
                    data-order_id="{{ $data->id }}">Change</a>
            </div>
        </div>


        <div class="form-group row">
            <div class="col">
                <fieldset class="border border-secondary p-2">
                    <legend class="float-none w-auto p-2">Product Details</legend>
                    <div class="table-responsive-sm border border-secondary" style="overflow-x:scroll;">
                        <table class="table text-center border" id="user_order_product_list"
                            style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Order No</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            @php
                                
                            @endphp
                            <tbody>
                                {{-- @foreach ($products as $key => $item)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $item->order_no }}</td>
                                        <td><img src="{{ $item->product_image }}" alt="{{ $item->product_name }}"
                                                width="100px"></td>
                                        <td>{{ $item->product_name }}</td>
                                        <td><input type="text" name="" value="{{ $item->total_quantity }}"
                                                class="form-control" style="text-align: center;"
                                                onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57"
                                                onchange="update_product_quantity('{{ $item->consolidate_order_no }}','{{ $item->product_id }}','{{ $item->id }}',this)">
                                        </td>
                                        <td>{{ $item->product_price }}</td>
                                        <td>{{ $item->final_price }}</td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </fieldset>
            </div>
        </div>



    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary " data-dismiss="modal" aria-label="Close">Close</button>
        {{-- <button type="submit" id="salesEditInvoiceForm1" class="btn btn-primary">Save</button> --}}
    </div>
</form>

<style>
    :root {
        --card-line-height: 1.2em;
        --card-padding: 1em;
        --card-radius: 0.5em;
        --color-green: #EC1C24;
        --color-gray: #e2ebf6;
        --color-dark-gray: #c4d1e1;
        --radio-border-width: 2px;
        --radio-size: 1.5em;
    }

    .plan-details {
        border: var(--radio-border-width) solid var(--color-gray);
        border-radius: var(--card-radius);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        padding: var(--card-padding);
        transition: border-color 0.2s ease-out;
    }

    .card:hover .plan-details {
        border-color: var(--color-dark-gray);
    }

    .radio:checked~.plan-details {
        border-color: var(--color-green);
    }

    .radio:focus~.plan-details {
        box-shadow: 0 0 0 2px var(--color-dark-gray);
    }

    .radio:disabled~.plan-details {
        color: var(--color-dark-gray);
        cursor: default;
    }

    .radio:disabled~.plan-details .plan-type {
        color: var(--color-dark-gray);
    }

    .card:hover .radio:disabled~.plan-details {
        border-color: var(--color-gray);
        box-shadow: none;
    }

    .radio {
        font-size: inherit;
        margin: 0;
        position: absolute;
        right: calc(1em + var(--radio-border-width));
        top: calc(1em + var(--radio-border-width));
    }

    @supports (-webkit-appearance: none) or (-moz-appearance: none) {
        .radio {
            -webkit-appearance: none;
            -moz-appearance: none;
            background: #fff;
            border: var(--radio-border-width) solid var(--color-gray);
            border-radius: 50%;
            cursor: pointer;
            height: var(--radio-size);
            outline: none;
            transition: background 0.2s ease-out, border-color 0.2s ease-out;
            width: var(--radio-size);
        }

        .radio::after {
            border: var(--radio-border-width) solid #fff;
            border-top: 0;
            border-left: 0;
            content: "";
            display: block;
            height: 0.75rem;
            left: 25%;
            position: absolute;
            top: 50%;
            transform: rotate(45deg) translate(-50%, -50%);
            width: 0.375rem;
        }

        .radio:checked {
            background: var(--color-green);
            border-color: var(--color-green);
        }

        .card:hover .radio {
            border-color: var(--color-dark-gray);
        }

        .card:hover .radio:checked {
            border-color: var(--color-green);
        }
    }

    .plan-details {
        border: var(--radio-border-width) solid var(--color-gray);
        border-radius: var(--card-radius);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        padding: var(--card-padding);
        transition: border-color 0.2s ease-out;
    }

    .card:hover .plan-details {
        border-color: var(--color-dark-gray);
    }

    .radio:checked~.plan-details {
        border-color: var(--color-green);
    }

    .radio:focus~.plan-details {
        box-shadow: 0 0 0 2px var(--color-dark-gray);
    }

    .radio:disabled~.plan-details {
        color: var(--color-dark-gray);
        cursor: default;
    }

    .radio:disabled~.plan-details .plan-type {
        color: var(--color-dark-gray);
    }

    .card:hover .radio:disabled~.plan-details {
        border-color: var(--color-gray);
        box-shadow: none;
    }

    .card:hover .radio:disabled {
        border-color: var(--color-gray);
    }
</style>

<!-- Modal -->
<div class="modal fade" id="change_address_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content p-2">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Address</h5>
                <button type="button" class="close close_address">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bg-white px-3">
                <div class="row" id="all_address_modal">
                    {{-- <div class="grid" id="all_address_modal"> --}}
                    <img src="{{ asset('loading/loading.webp') }}" height="100"
                        style="transform: translateX(284px);border-radius: 312px;" id="loading_image"
                        style="display: none">
                    {{-- </div>  --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_address">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>



<script>
    function update_product_quantity(product_id, user_order_item_id, $this) {
        let quantity = $($this).val();
        $.ajax({
            url: "{{ route('update_user_order_product_quantity') }}",
            data: {
                user_order_item_id: user_order_item_id,
                product_id: product_id,
                quantity: quantity,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            type: 'POST',
            success: function(data) {
                console.log(data);
                if (data.status == 'success') {
                    successMsg(data.message);
                    user_order_product_list.ajax.reload();
                    getRetailCustomerOrdersDetials.ajax.reload();
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }


    $('.close_address').click(function() {
        $('#change_address_modal').modal('hide');
    });
    $(document).ready(function() {
        $('.date').datepicker({
            dateFormat: "dd/mm/yy",
            onSelect: function(date) {
                $.ajax({
                    url: "{{ route('change_order_delivery_date') }}",
                    method: "POST",
                    data: {
                        delivery_date: date,
                        consolidate_order_no: "{{ $data->consolidate_order_no }}",
                        _token:"{{ csrf_token() }}"
                    },
                    dataType:'json',
                    success: function(response) {
                        // console.log(response)
                        if(response.status == 'success'){
                            successMsg(response.message);
                            user_order_product_list.ajax.reload();
                            getRetailCustomerOrdersDetials.ajax.reload();
                        }
                    }
                });

            }
        });
    });

    $('#change_address_modal_btn').click(function() {
        let order_id = $(this).data('order_id');
        // console.log(order_id);
        $.ajax({
            url: "{{ route('get_all_address') }}",
            type: 'get',
            data: {
                order_id: order_id
            },
            dataType: 'json',
            beforeSend: function() {
                $('#loading_image').show();
            },
            success: function(data) {
                let select_address = $('#change_address_id').val() != '' ? $('#change_address_id')
                    .val() : "{{ $data->address_id }}";
                $('#loading_image').hide();
                $('#all_address_modal').empty();
                for (let i = 0; i < data.length; i++) {
                    $('#all_address_modal').append(` 
                    <div class="grid col-md-4" id="all_address_modal">
                    <label class="card">
                        <input name="address_id" class="radio" type="radio" data-name="${data[i]['name']}" data-address_id="${data[i]['id']}" data-address="${data[i]['address']}" data-unit="${data[i]['unit']}" data-phone="${data[i]['mobile_number']}"  ${data[i]['id'] == select_address ? 'checked': ''} onclick="change_address(this)">
                        <span class="plan-details">
                            <span class="plan-type">${data[i]["name"]}</span>
                            <span>postal Code:#${data[i]["postcode"]}</span>
                            <span>${data[i]["address"]}</span>
                            <span>Mobile No.:${data[i]["mobile_number"]}</span>
                            <span>Unit No.:${data[i]["unit"]}</span>
                        </span>
                    </label>
                    </div>
                    `);
                }
            },
            error: function(error) {
                console.log(error)
            }
        })
    });

    function change_address(data) {
        let address_id = $(data).data('address_id');
        let address = $(data).data('address');
        let phone = $(data).data('mobile_number');
        let unit = $(data).data('unit');
        let name = $(data).data('name');

        $('#address_and_unit').html(address + " " + unit);
        $('#change_address_phone_number').html(phone);
        $('#change_address_id').val(address_id)
        $('#change_address_name').html(name)

        update_address_in_order(address_id);
    }

    function update_address_in_order(address_id) {
        $.ajax({
            url: "{{ route('update_address_in_order') }}",
            type: 'POST',
            data: {
                consolidate_order_no: "{{ $data->consolidate_order_no }}",
                address_id: address_id,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                if (data.status == 'success') {
                    successMsg(data.message);
                    user_order_product_list.ajax.reload();
                    getRetailCustomerOrdersDetials.ajax.reload();
                }
            },
            error: function(error) {
                console.log(error)
            }
        });
    }

    $(document).ready(function() {
        get_user_order_product_list();
    })



    function get_user_order_product_list() {
        user_order_product_list = $('#user_order_product_list').DataTable({
            "aaSorting": [],
            "bDestroy": true,
            pageLength: 10,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            buttons: [],
            // responsive: 'false',
            dom: "Bfrtip",
            ajax: {
                url: "{{ route('user_order_item_details') }}",
                type: 'get',
                data: {
                    consolidate_order_no: "{{ $data->consolidate_order_no }}"
                }
            },
        });
        $(document).find('#user_order_product_list').wrap('<div style="overflow-x:auto; width:100%;"></div>')
    }
</script>
