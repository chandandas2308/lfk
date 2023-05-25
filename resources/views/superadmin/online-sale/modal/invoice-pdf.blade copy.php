<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice | LFK</title>

    <style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
  
    table {
        font-size: x-small;
    }

    tbody {
        min-height: 500px !important;
    }

    tfoot tr td {
        font-weight: bold;
        font-size: x-small;
    }

    .gray {
        background-color: lightgray
    }

    .terms {
        height: 100px;
        width: 60%;
        padding: 2px;
    }

    a.button {
        display: block;
        position: relative;
        float: left;
        text-decoration: none;
        width: 120px;
        padding: 0;
        margin: 10px 20px 10px 0;
        font-weight: 600;
        text-align: center;
        line-height: 50px;
        color: #FFF;
        border-radius: 5px;
        transition: all 0.2s;
    }

    .btnBlueGreen {
        background: #00AE68;
    }

    .btnBlueGreen.btnPush {
        box-shadow: 0px 5px 0px 0px #007144;
    }

    .btnPush:hover {
        margin-top: 15px;
        margin-bottom: 5px;
    }

    .btnBlueGreen.btnPush:hover {
        box-shadow: 0px 0px 0px 0px #007144;
    }

    .blue {
        background: #5DC8CD;
    }

    .green {
        background: #FFAA40;
    }

    .sky {
        background: #8D336A;
    }
    </style>
</head>

<body>

    <table width="100%">
        <tr> 
            
            <td valign="top" style="font-size: 50px;">LFK</td>
            <td align="right">
                <h3>Living Free Korea</h3>
                <pre>
                    +65 8839 3132{{ Auth::User()->phone_number }}
                    {{ Auth::User()->email }}
                    XPET4S647CXXXX
                </pre>
            </td>
            
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td>
                <b> Invoice No.: {{ $details->consolidate_order_no }} </b><br>
                <b> Invoice Date: </b>  {{ $details->created_at }} <br>
                <b> Full Name: </b> {{ $details->name }} <br>
            </td>
        </tr>

    </table>
    <br />


    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody style="height: 100px;">
            @foreach ($data as $key => $obj)
            <tr>
                <td style="text-align:center">{{ ++$key }}</td>
                <td style="text-align:center">{{ $obj->product_name }}</td>
                <td style="text-align:center">{{ $obj->quantity }}</td>
                <td style="text-align:center">${{ number_format($obj->product_price,2) }}</td>
                <td style="text-align:center">${{ number_format($obj->total_price,2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot style="background-color: lightgray;">
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td style="text-align:center">Sub Total </td>
                <td style="text-align:center">${{ number_format($sum-$shipping_charge,2) }}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="text-align:center">Shipping Charge</td>
                <td style="text-align:center">${{number_format($shipping_charge,2)}}</td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td style="text-align:center">Grand Total </td>
                <td style="text-align:center" class="gray">${{number_format($sum,2)}}</td>
            </tr>
        </tfoot>
    </table>
    <!-- <label> <b>Term and Condition</b> </label><br>

    <div class="terms">
        
    </div> -->

    <h3 class="heading">Payment Mode: {{$payment_mode->payment_mode}}</h3>

    <p>&copy; Copyright 2021 - {{ 'YKPTE' ?? ''}}. All rights reserved.</p>

</body>

</html>