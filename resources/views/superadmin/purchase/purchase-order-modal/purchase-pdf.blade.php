<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Purchase Order | LFK</title>

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
            <!-- <td colspan="3" style="color: grary;">Purchase Invoice</td> -->
            <td valign="top" style="font-size: 50px;">LFK</td>
            <td align="right">
                <h3>YKPTE PTE. LTD.</h3>
                <pre>
                    +91 {{ Auth::User()->phone_number }}
                    {{ Auth::User()->email }}
                    XPET4S647CXXXX
                </pre>
            </td>
            
        </tr>
    </table>

    @foreach($data as $k => $v)
    <table width="100%">
        <tr>
            <td>
                <b> Invoice No.: {{ $v->order_no }} </b><br>
                <b> Invoice Date: </b>  {{ date("l jS \of F Y h:i:s A") }} <br>
                <b> Full Name: </b> {{ $v->vendor_name }} <br>
            </td>
        </tr>

    </table>
    <br />


    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody style="height: 100px;">
            @foreach (json_decode($products) as $key => $obj)
            <tr>
                <td style="text-align:center">{{ ++$key }}</td>
                <td style="text-align:center">{{ $obj->product_name }}</td>
                <td style="text-align:center">{{ $obj->description }}</td>
                <td style="text-align:center">{{ $obj->quantity }}</td>
                <td style="text-align:center">{{ $obj->unitPrice }}</td>
                <td style="text-align:center">{{ $obj->subTotal }}</td>
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
                <th></th>
            </tr>
        </tfoot>
        <tfoot>
            <tr>
                <td colspan="4"></td>
                <td style="text-align:center">Sub Total </td>
                <td style="text-align:center">{{$v->untaxted_amount}}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td style="text-align:center">GST </td>
                <td style="text-align:center">{{$v->GST}}</td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td style="text-align:center">Grand Total </td>
                <td style="text-align:center" class="gray">{{$v->total}}</td>
            </tr>
        </tfoot>
    </table>
    <label> <b>Term and Condition</b> </label><br>

    <div class="terms">
        {{$v->note}}
    </div>

    <p>&copy; Copyright 2021 - {{ 'YKPTE' ?? ''}}. All rights reserved.</p>

@endforeach
</body>

</html>