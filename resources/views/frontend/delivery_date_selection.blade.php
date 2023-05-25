@extends('frontend.layouts.master')
@section('title', 'LFK | Delivery Date')
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
                <a href="{{ route('checkout.orderSummary') }}">
                    <div class="circle done">
                        <span class="label">1</span>
                        <span class="title">{{ __('lang.order') }}</span>
                    </div>
                </a>
                <span class="bar done"></span>
                <a href="{{ route('checkout.addressSummary') }}">
                    <div class="circle done">
                        <span class="label">2</span>
                        <span class="title">{{ __('lang.address') }}</span>
                    </div>
                </a>
                <span class="bar done"></span>
                <div class="circle active">
                    <span class="label">3</span>
                    <a href="#"><span class="title">{{ __('lang.delivery') }}</span></a>
                </div>
                <span class="bar done"></span>
                <div class="circle">
                    <span class="label">4</span>
                    <a href="#"><span class="title">{{ __('lang.billing') }}</span></a>
                </div>
                <span class="bar"></span>
                <div class="circle">
                    <span class="label">5</span>
                    <a href="#"><span class="title">{{ __('lang.done') }}</span></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="block text-center">
                        <div class="">

                            <div
                                style="border: 1px ridge lightgray; min-height: 300px; padding:10px; width: 50%; margin:auto;">
                                <h3 class="card-title">{{ __('lang.select_delivery_date') }}</h3>
                                <hr>
                                {{-- <form class="text-left" action="{{ route('checkout.storeDeliveryDate') }}" method="POST"> --}}
                                <form class="text-left" action="{{ route('select_payment_option') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="delivery_date_picker">{{ __('lang.date') }}</label>
                                        <input type="text" class="form-control"
                                            @if ($deliver_date != '') value="{{ $deliver_date }}" disabled @else value="" @endif
                                            name="delivery_date" required id="delivery_date_picker"
                                            placeholder="{{ __('lang.delivery_date') }}" autocomplete="off">
                                        @error('delivery_date')
                                            <span style="color: red">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="remark">{{ __('lang.remark') }}</label>
                                        <input type="text" class="form-control"
                                            @if ($remark != '') value="{{ $remark }}" @else value="" @endif
                                            name="remark" id="remark" placeholder="{{ __('lang.remark') }}">
                                    </div>
                                    <input type="hidden" name="address_id" value="{{ empty($address_id) ? old('address_id') : $address_id }}">
                                    <input type="hidden" name="coupon" value="{{ $coupon }}">
                                    <button type="submit"
                                        class="btn btn-main mt-20">{{ __('lang.confirm_delivery_date') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap 4 JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        let finalArr = [];
        let finalArr1 = [];
        let slotDate;

        $(document).ready(function() {
            setTimeout(() => {
                $('.bars').hide();
            }, 5000);
        });

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
