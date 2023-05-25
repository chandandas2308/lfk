@extends('frontend.layouts.master')
@section('title', 'LFK | Thanks For Shopping')
@section('body')

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        #delivery_date_picker {
            border-radius: 0 !important;
            box-shadow: none !important;
            height: auto !important;
            outline: firebrick !important;
            font-weight: 100 !important;
            font-size: 14px !important;
        }

        td.day {
            background: #ec1c24 !important;
            color: #fff;
        }

        td.disabled {
            background: white !important;
        }

        .datepicker table tr td.day.focused,
        .datepicker table tr td.day:hover {
            background: #eee;
            cursor: pointer;
            background: #fac0a4 !important;
            color: #ec1c24;
        }
    </style>
    <!-- Page Wrapper -->
    <section class="page-wrapper success-msg">
        <div class="container">
            <div class="progress-main">
                <div class="circle done">
                    <span class="label">1</span>
                    <a href="#"><span
                            class="title">{{ __('lang.order') }}</span></a>
                </div>
                <span class="bar done"></span>
                <div class="circle done">
                    <span class="label">2</span>
                    <a href="#"><span
                            class="title">{{ __('lang.ADDRESS') }}</span></a>
                </div>
                <span class="bar done"></span>
                <div class="circle done">
                    <span class="label">3</span>
                    <a href="#"><span
                            class="title">{{ __('lang.delivery') }}</span></a>
                </div>
                <span class="bar done"></span>
                <div class="circle done">
                    <span class="label">4</span>
                    <a href="#"><span
                            class="title">{{ __('lang.billing') }}</span></a>
                </div>
                <span class="bar done"></span>
                <div class="circle active">
                    <span class="label">5</span>
                    <a href="#"><span
                            class="title">{{ __('lang.done') }}</span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <?php

use App\Models\UserOrder;
use Illuminate\Support\Facades\Auth;

                        $order_details = DB::table('notifications')
                            ->where('user_id', Auth::user()->id)
                            ->orderBy('id', 'desc')
                            ->first();
                        $deliver_date = $order_details->delivery_date;

                        $total_amount = DB::table('user_orders')->where('consolidate_order_no', $order_details->consolidate_order_no)->sum('final_price');

                        ?>
                        <div class="">

                                    <div style="border: 1px ridge lightgray; min-height: 500px; padding:10px; width: 50%; margin:auto;">
                                        {{-- <h3 class="card-title">{{ __('lang.order_summary') }}</h3> --}}
                                        <h3 class="card-title">{{ __('lang.delivery_confirmation') }}</h3>
                                        <hr>
                                        <form class="text-left" action="{{ route('Add-Delivery') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="order_no" value="{{ $order_details->consolidate_order_no }}">
                                            <!-- <div class="form-group">
                                                <label for="orderNumber">Consolidate Order Number</label>
                                                <input type="text" disabled value="{{ $order_details->consolidate_order_no }}" class="form-control" id="orderNumber" aria-describedby="emailHelp" placeholder="Consolidate Order Number">
                                            </div>
                                            <div class="form-group">
                                                <label for="orderNumber">Order Number</label>
                                                <input type="text" disabled value="{{ $order_details->order_no }}" class="form-control" id="orderNumber" aria-describedby="emailHelp" placeholder="Order Number">
                                                <input type="hidden" name="user_order_no" value="{{ $order_details->order_no }}">
                                            </div> -->
                                            <div class="form-group">
                                                <label for="delivery_date_picker">Date</label>
                                                <input type="text" @if($deliver_date != '') value="{{ $deliver_date }}" style="display:none;" @endif class="form-control" name="delivery_date" required id="delivery_date_picker" placeholder="Delivery Date">
                                                @if($deliver_date != '')
                                                    <input type="text" value="{{ $deliver_date }}" disabled class="form-control" name="" required id="delivery_date_picker" placeholder="Delivery Date">
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="remark">{{ __('lang.remark') }}</label>
                                                <input type="text" class="form-control" disabled value="{{$order_details->remark}}" name="remark" id="remark" placeholder="{{ __('lang.remark') }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="total_price">{{ __('lang.total_price') }}</label>
                                                <input type="text" class="form-control" disabled value="${{number_format($total_amount,2)}}" name="remark" id="total_price" placeholder="{{ __('lang.total_price') }}">
                                            </div>
                                            @if($deliver_date != '')<div class="alert alert-danger">
                                                <!-- Your orders will deliver on  -->
                                                {{ __('lang.order_delivered_on') }} {{ $deliver_date }}</div>@endif
                                            @if($deliver_date != '')
                                                <button type="submit" class="btn btn-main mt-20">OK</button>
                                            @else
                                                <button type="submit" class="btn btn-main mt-20">Submit</button>
                                            @endif
                                        </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap 4 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}
    <script>
        let finalArr = [];
        let finalArr1 = [];
        let slotDate;

        @foreach (DB::select('SELECT delivery_date, count(*) as count FROM notifications GROUP BY delivery_date') as $key => $value)
            @foreach (DB::table('driver_dates')->get() as $key1 => $value1)


                var date_time = "{{ $value1->date_time }}";
                date_time = date_time; //
                var delivery_date = "{{ $value->delivery_date }}";

                var limit = "{{ $value->count }}";
                var count = "{{ $value1->limit }}";

                if (date_time == delivery_date && limit == count) {
                    finalArr.push("{{ $value1->date_time }}"); //
                }

                var date_time1 = "{{ $value1->date_time }}";
                date_time1 = date_time1.split('-').reverse().toString().replaceAll(',', '/'); //
                var delivery_date1 = "{{ $value->delivery_date }}";
                var limit1 = "{{ $value->count }}";
                var count1 = "{{ $value1->limit }}";

                if (date_time1 == delivery_date && limit == count) {
                    finalArr1.push("{{ $value1->date_time }}".split('-').reverse().toString().replaceAll(',', '/')); //
                }
            @endforeach
        @endforeach

        @foreach (DB::table('driver_dates')->get() as $key1 => $value1)
            @if ($value1->limit == '0')
                finalArr.push("{{ $value1->date_time }}"); //
                finalArr1.push("{{ $value1->date_time }}".split('-').reverse().toString().replaceAll(',', '/')); //
            @endif
        @endforeach

        function checkSlot(slotCountVal) {

            startSlotDate = new Date();

            let slotArr = [];
            for (var k = 1; k <= slotCountVal; k++) {
                slotArr.push(new Date(new Date().setDate(new Date().getDate() + k)).toISOString().slice(0, 10)); //
            }

            // let todayDate = new Date().toISOString().slice(0,10);
            slotDate = new Date(new Date().setDate(new Date().getDate() + slotCountVal)).toISOString().slice(0, 10); //

            let myArr1 = [];

            $.each(finalArr, function(key, value) {
                if (slotArr[0] <= value && value <= slotDate) {
                    // console.log('in if : ',value);
                    myArr1.push(value)
                } else {
                    // console.log('in else');
                }
            })

            const compareArrays = (a, b) => {
                if (a.length != b.length) return false;
                else {
                    for (var i = 0; i < a.length; i++) {
                        if (a[i] !== b[i]) {
                            return false;
                        }
                    }
                    return true;
                }
            };

            let status = compareArrays(myArr1.sort(), slotArr.sort());

            if (status != true) {
                return false;
            } else {
                slotCountVal += 14;
                checkSlot(slotCountVal);
            }

        }

        let slotCountVal = 14;

        let status1 = checkSlot(slotCountVal);

        let currentDate = new Date();
        let datehere;

        if (status1 != true) {
            datehere = slotDate;
        } else {
            slotCountVal += 14;
            status = checkSlot(slotCountVal);
        }

        finalArr2 = [];

        finalArr1.forEach(element => {
            finalArr2.push(element);
        });

        let tomorrow = new Date();
        let today = new Date();
        let dateIs = tomorrow.setDate(today.getDate() + 1);

        $("#delivery_date_picker").datepicker({
            autoclose: true,
            startDate: new Date(dateIs),
            format: "dd/mm/yyyy",
            datesDisabled: finalArr2,
            endDate: new Date(datehere),
        });
    </script>

@endsection
