@extends('pos.layout.master')
@section('title','Customer | POS')

@section('body')
<main id="main" class="main">
    <div class="pos">
        <div class="row">
            <div class="col-md-6">How would you like to receive your receipt?</div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <center>
                            <img src="{{ asset('frontend/images/ykpte-new-logo.png') }}" class="" alt="YKPTE">
                        </center>
                        <h5 class="card-title">YKPTE</h5>
                        <div>Tel:+1 (650) 555-0111</div>
                        <div>info@yourcompany.com</div>
                        <div>http://www.example.com</div>
                        <div class="cashier"><div>--------------------------------</div>
                        
                        <div class="d-flex justify-content-between" style="font-size:medium">
                            <div class="text-muted text-start">
                        

                                Name : ABC <br>
                                Order No. : 001 <br>
                        

                            </div>
                            <div></div>
                        </div>
                        

                        <hr>
                        @php 
                            $data = DB::table('pos__orders')
                                ->join('pos_stocks', 'pos_stocks.product_id','=','pos__orders.product_id')
                                ->where('order_no', $order_number)->get(["pos__orders.*", "pos_stocks.product_name"]);

                            $payments = DB::table('pos_payments')->where('order_no', $order_number)->get();
                            $total_bill_amount = DB::table('pos__orders')->where('order_no', $order_number)->sum('total');
                            $total_paid_amount = DB::table('pos_payments')->where('order_no', $order_number)->sum('amount');
                        @endphp

                       
                        @foreach($data as $key=>$value)
                            <div class="text-muted text-start d-flex justify-content-between" style="font-size:medium">
                                <div class="border-bottom">
                                   {{ $value->product_name }}<br>{{ $value->quantity }}X{{ $value->unit_price }}
                                </div>
                                <div class="">
                                    ${{ $value->total }}
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="cashier"><div>--------------------------------</div>
                            <div class="text-muted text-start d-flex justify-content-between" style="font-size:medium">
                                <div></div>
                                <div>
                                    <strong>Total</strong>
                                </div>
                                <div>
                                    ${{$total_bill_amount}}
                                </div>
                            </div>

                            @foreach($payments as $key=>$value)
                                <div class="text-muted text-start d-flex justify-content-between" style="font-size:medium">
                                    <div>
                                        {{ $value->payment_type }}
                                    </div>
                                    <div>
                                        {{ $value->amount }}
                                    </div>
                                </div>
                            @endforeach
                        

                            <div class="text-muted text-start d-flex justify-content-between" style="font-size:medium">
                                <div></div>
                                <div>
                                    <strong>Change</strong>
                                </div>
                                <div>
                                    ${{ $total_paid_amount - $total_bill_amount }}
                                </div>
                            </div>
                        <hr>
                            <center>END</center>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</main>
@endsection