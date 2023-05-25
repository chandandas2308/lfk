<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LFK</title>
    {{-- <link rel="stylesheet" href="table.css"> --}}

    <style type="text/css" media="print">
        @page {
            size: auto;
            /* auto is the initial value */
            margin-top: 1px;
            /* this affects the margin in the printer settings */
            margin-bottom: 1px;
        }
    </style>




    <style>
        /* .top_rw td{
    border-bottom: 2px solid #000;
} */
        button {
            padding: 5px 10px;
            font-size: 14px;
        }

        .invoice-box {
            max-width: 890px;
            margin: auto;
            padding: 10px;


            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: rgb(0, 0, 0);

        }

        .table-invoice {


            border-collapse: collapse;
            width: 100%;
        }

        .table-invoice td,
        th {
            border: 1px solid #000;
            text-align: left;
            padding: 8px;
        }

        h2 {
            padding: 0;
            margin: 0;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;

        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: middle;
        }

        /* .invoice-box table tr td:nth-child(2) {
    text-align: right;
} */
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            font-size: 12px;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }
    </style>

</head>

<body id="body">

    <div class="invoice-box" id="ll">
        <table cellpadding="0" cellspacing="0">
            <tbody>
                <tr class="top_rw " style="padding-bottom: 20px;">
                    <td colspan="2">
                        <img src="{{ asset('backend/images/ykpte-new-logo.png') }}" />
                        {{-- <img src="{{ public_path('backend/images/ykpte-new-logo.png') }}" alt="" srcset=""> --}}
                        <br> <br>
                        <span>9 Kaki Bukit Road 2, #01-17,<br>
                            Gordon Warehouse Building <br>
                            Singapore 417842</span>
                        <!-- <span>Y K Private Limited<br>
                            8 Boon Lay Way @Tradehub 21#02-14<br>
                            Singapore 609964<br> -->

                        </span> <br><br>
                        <span>{{ $address->name }}<br>{{ $address->address }}<br>{{ $address->unit }}<br>

                            
                        </span>
                        <span style=" color:#000;   font-size: 18px;
                        font-weight: bold;">
                            Remark: {{ $remark->remark }}<br>
                        </span> <br>

                        <span style=" color:#000;   font-size: 18px;
                        font-weight: bold;">
                            Contact Number: {{ $address->mobile_number }}
                        </span> <br>

                        <span style=" color:#000;   font-size: 18px;
                        font-weight: bold;">
                            Delivery Date: {{ $data->delivery_date }}
                        </span> <br>
                    </td>
                    <td colspan="2" style="text-align: right;">
                        <span style=" color:#000;   font-size: 18px;
                   font-weight: bold;">TAX
                            INVOICE</span> <br> <br>
                        <table class="table-invoice" style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td
                                        style="
color: #000000;
background-color: #C0C0F0;
font-size: 18px;
font-weight: bold;
border: 1px solid #000;
">
                                        INVOICE#
                                    </td>
                                    <td
                                        style="
color: #000000;
background-color: #C0C0F0;
font-size: 18px;
font-weight: bold;
border: 1px solid #000;
">
                                        DATE
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="
color: #000000;
/* background-color: #C0C0F0; */
font-size: 18px;
font-weight: bold;
border: 1px solid #000;
">
                                        {{ $user_order->consolidate_order_no }}
                                    </td>
                                    <td
                                        style="
color: #000000;
/* background-color: #C0C0F0; */
font-size: 18px;
font-weight: bold;
border: 1px solid #000;
">
                                        {{ $user_order->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table><br><br>
                        <span>GST Registration No. 200807729G<br>


                        </span>
                    </td>
                </tr>
            </tbody>
        </table> <br> <br>

        <table class="table-invoice">
            <thead>
                <tr>
                    <td
                        style="
    color: #000000;
    background-color: #C0C0F0;
    font-size: 18px;
    font-weight: bold;
    border: 1px solid #000;
    /* width: 380px; */
">
                        <strong> DESCRIPTION</strong>
                    </td>
                    <td
                        style="
    color: #000000;
    background-color: #C0C0F0;
    font-size: 18px;
    font-weight: bold;
    border: 1px solid #000;
">
                        <strong>QTY</strong>
                    </td>
                    <td
                        style="
    color: #000000;
    background-color: #C0C0F0;
    font-size: 18px;
    font-weight: bold;
    border: 1px solid #000;
">
                        <strong>UNIT PRICE ($)</strong>
                    </td>
                    <td
                        style="
    color: #000000;
    background-color: #C0C0F0;
    font-size: 18px;
    font-weight: bold;
    border: 1px solid #000;
">
                        <strong>AMOUNT ($)</strong>
                    </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($user_order_item as $key => $obj)
                    <tr>
                        <td>{{ $obj->product_name }}</td>
                        <td>{{ $obj->quantity }}</td>
                        <td>{{ number_format($obj->product_price, 2) }}</td>
                        <td>{{ number_format($obj->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <table>
            <tbody>
                <tr>
                    <td style="
    width: 64%; text-align: center;
"><em><strong>Thank You For Your
                                Business!</strong></em>

                    </td>

                    <td>

                        <table class="table-invoice" style="margin-left: 7px;">
                            <tbody>
                                <tr>
                                    <th><strong>Tax (8%)</strong></th>
                                    <th><strong>${{ number_format($tax_total, 2) }}</strong></th>
                                </tr>
                                @if ($sum < 70)
                                    <tr>
                                        <th><strong>Delivery Charge</strong></th>
                                        <th><strong>${{ number_format(8, 2) }}</strong></th>
                                    </tr>
                                @endif
                                @if (!empty($check_voucher_apply))
                                    <tr>
                                        <th><strong>Voucher</strong></th>
                                        <th><strong>-${{ number_format($check_voucher_apply->discount_amount, 2) }}</strong>
                                        </th>
                                    </tr>
                                @endif
                                <tr>
                                    <th><strong>Total</strong></th>
                                    <th><strong>${{ number_format($sum, 2) }}</strong></th>
                                </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table> <br> <br>


        <table>
            <tr>
                <td style="
    text-align: center;
">
                    Mode of Payment
                </td>
                <td style="
    text-align: center;
">
                    {{ $data->payment_mode == 'hitpay' ? 'Paynow' : $data->payment_mode }}
                </td>
                <td style="
    text-align: center;
">
                    All Price are Inclusive of 8% GST
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="
                    text-align: center;
                ">
                    <!-- Please Paynow to the company UEN, do let me know after you have transferred. Thank You! -->
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td style="
                    text-align: center;
                ">
                    Thank You. We look forward to being of service to you again.
                </td>
            </tr>
        </table>

        <div style="text-align: center">
            <button type="button" class="btn btn-primary" id="print_this"
                style="cursor: pointer; background: #e89041;
            border: none;
            padding: 10px;">Print
            </button>
        </div>
    </div>

    <script src="{{ asset('auth/js/jquery.min.js') }}"></script>
    <script src="{{ asset('printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#print_this').click(function() {
                $(this).hide();
                $('body').printThis()
                setTimeout(function() {
                    $('#print_this').show();
                }, 500);
                return false;

            });
        });
    </script>

</body>

</html>
