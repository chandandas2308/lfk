<table>
    <thead>

        <tr>
            <td rowspan="2" colspan="5"></td>
            @foreach ($data as $vertical)
                <th style="font-weight: bold">{{ $vertical->product_name }}</th>
            @endforeach
        </tr>
        <tr></tr>
        <tr>
            <td style="background-color: #33ffff;"></td>
            <td style="background-color: #33ffff;"></td>
            <td style="background-color: #33ffff;"></td>
            <td style="background-color: #33ffff;"></td>
            <td style="background-color: #33ffff;"></td>
        </tr>
        <tr>


            <th rowspan="2" valign="middle" align="center" style="background-color: #c2c2c2;">Total</th>
            <th rowspan="2" valign="middle" align="center" style="background-color: #c2c2c2;">Payment</th>
            <th rowspan="2" valign="middle" align="center" style="background-color: #c2c2c2;">Name</th>
            <th rowspan="2" valign="middle" align="center" style="background-color: #c2c2c2;">Contact</th>
            <th rowspan="2" valign="middle" align="center" style="background-color: #c2c2c2;">Address</th>


        </tr>
        <tr></tr>


    </thead>
    <tbody>
        @foreach ($invoices as $invoice)
        @php
            $total_order_price = DB::table('user_orders')
            ->where('user_orders.consolidate_order_no',$invoice->order_no)->sum('final_price');
        @endphp
            <tr>
                <td>${{ $total_order_price }}</td>
                <td style="background-color: #ffff33;">{{ $invoice->payment_mode == 'hitpay' ? 'PAYNOW' : $invoice->payment_mode }}</td>
                <td>{{ $invoice->name }}</td>
                <td>{{ $invoice->mobile_no }}</td>
                <td style="font-weight: bold; text-align: center">{{ $invoice->address }}</td>



                @foreach ($data as $vertical)
                    @php
                        $quantity = DB::table('user_order_items')
                            ->where('consolidate_order_no', $invoice->order_no)
                            ->where('product_id', $vertical->id)
                            ->sum('quantity');
                    @endphp

                    <td style="font-weight: bold; text-align: center">{{ $quantity }}</td>
                @endforeach
            </tr>
        @endforeach
        <tr></tr>
        <tr></tr>
        <tr>
            {{-- <td rowspan="2" colspan="2">44</td> --}}
            <td  rowspan="4" colspan="4" style="font-weight: bold;text-align: center;">
                @php
                    $driver_details = DB::table('drivers')->where('id',$driver_id)->first();
                @endphp
                {{ $driver_details->driver_name }}<br>
                {{ !empty($date) ? $date : '' }}
            </td>
            {{-- <td ></td> --}}
            <td style="font-weight: bold; text-align: center">Total Quantity</td>
            @foreach ($data as $item)
                @php
                    $get_quantity = DB::table('user_order_items')
                        ->join('deliveries', 'deliveries.order_no', '=', 'user_order_items.consolidate_order_no')
                        ->where('deliveries.delivery_man_user_id', $driver_id)
                        ->where('user_order_items.product_id', $item->id);
                    if (!empty($date)) {
                        $get_quantity->where('deliveries.date',  date('Y-m-d', strtotime(str_replace('/', '-', $date))));
                    }
                    $get_quantity = $get_quantity->sum('user_order_items.quantity');

                @endphp
                <td style="font-weight: bold; text-align: center">{{ $get_quantity }}</td>
                
            @endforeach
        </tr>
        <tr>
            {{-- <td colspan="4"></td> --}}
            <td style="font-weight: bold; text-align: center">Commission</td>
           
            <td style="font-weight: bold; text-align: center">{{ $driver_details->commission * sizeof($invoices) ?? ''}}</td>
        </tr>

        <tr>
            {{-- <td colspan="4"></td> --}}
            <td style="font-weight: bold; text-align: center">Total Price</td>
            @php
                $total_price = DB::table('deliveries')->join('notifications', 'notifications.consolidate_order_no', '=', 'deliveries.order_no')
                ->join('user_orders', 'user_orders.order_no', '=', 'notifications.order_no')
                ->where('deliveries.delivery_man_user_id', $driver_id);
                if (!empty($date)) {
                    $total_price->where('deliveries.date',  date('Y-m-d', strtotime(str_replace('/', '-', $date))));
                }
                $total_price = $total_price->sum('user_orders.final_price');
            @endphp
            <td style="font-weight: bold; text-align: center">{{ $total_price }}</td>
        </tr>

        <tr>
            {{-- <td colspan="4"></td> --}}
            <td style="font-weight: bold; text-align: center">Total Collect Price</td>
            @php
                $total_collect_price = DB::table('deliveries')->join('notifications', 'notifications.consolidate_order_no', '=', 'deliveries.order_no')
                ->join('user_orders', 'user_orders.order_no', '=', 'notifications.order_no')
                ->join('user_order_payments','user_order_payments.id','=','user_orders.payment_id')
                ->where('user_order_payments.payment_type','COD')
                ->where('deliveries.delivery_man_user_id', $driver_id);
                if (!empty($date)) {
                    $total_collect_price->where('deliveries.date',  date('Y-m-d', strtotime(str_replace('/', '-', $date))));
                }
                $total_collect_price = $total_collect_price->sum('user_orders.final_price');


            @endphp
            <td style="font-weight: bold; text-align: center">{{ $total_collect_price }}</td>
        </tr>
      
           

    </tbody>

</table>
