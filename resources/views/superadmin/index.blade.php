@extends('superadmin.layouts.master')
@section('title','Dashboard | LFK')
@section('body')

<div class="main-panel">
    <div class="content-wrapper pb-0">

        <!-- start row -->
        <div class="row">
            <div class="col-xl-3 col-md-3 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card bg-warning d-card">
                    <div class="card-body px-3 py-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="color-card">
                                <!-- <p class="mb-0 color-card-head">Sales</p> -->
                                <h2 class="" id="availableProducts"> 1088 </h2>
                            </div>
                            <i class="card-icon-indicator mdi mdi-basket bg-inverse-icon-warning"></i>
                        </div>
                        <h6 class="">New Orders (Pending)</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card d-card" style="background-color: #f26722;">
                    <div class="card-body px-3 py-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="color-card">
                                <!-- <p class="mb-0 color-card-head">Margin</p> -->
                                <h2 class="" id="totalSale"> 81 </h2>
                            </div>
                            <i class="card-icon-indicator mdi mdi-cube-outline bg-inverse-icon-danger"></i>
                        </div>
                        <h6 class="">Orders Pending Delivery</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card d-card" style="background-color: #ffbd00f0;">
                    <div class="card-body px-3 py-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="color-card">
                                <!-- <p class="mb-0 color-card-head">Orders</p> -->
                                <h2 class="" id="totalPurchase"> $2870 </h2>
                            </div>
                            <i class="card-icon-indicator mdi mdi-briefcase-outline bg-inverse-icon-primary"></i>
                        </div>
                        <h6 class="">Total Sales Today</h6>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
                <div class="card d-card" style="background-color: #ec1c24c2;">
                    <div class="card-body px-3 py-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="color-card">
                                <!-- <p class="mb-0 color-card-head">Orders</p> -->
                                <h2 class="" id="totalOrder"> 311 </h2>
                            </div>
                            <i class="card-icon-indicator mdi mdi-briefcase-outline bg-inverse-icon-primary"></i>
                        </div>
                        <h6 class="">Total Orders Today</h6>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->
        <div id="chart_div" style="width: 100%; height: 500px;"></div>
    </div>
    @endsection


    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- // backend js file -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        //   FetchChartMonthWiseSale
        $.ajax({
            type: "GET",
            url: "{{ route('SA-FetchChartMonthWiseSale') }}",
            success: function(response) {
                console.log(response)
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawVisualization);


                function drawVisualization() {
                    var data = google.visualization.arrayToDataTable(
                        response,false
                    );

                    var options = {
                        title: 'Monthly Sales',
                        vAxis: {
                            title: 'Dollar($)'
                        },
                        hAxis: {
                            title: 'Month'
                        },
                        seriesType: 'bars',
                        series: {
                            5: {
                                type: 'line'
                            }
                        },
                        vAxis: {
                            title: "Dollar($)",
                            titleFontStyle: "normal",
                            titleFontSize: 14,
                        }
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            }
        });
    </script>

    {{-- <script>
        // Total No Of Products
        $.ajax({
            type: "GET",
            url: "{{ route('SA-GetNoOfProducts') }}",
            success: function(response) {
                $('#availableProducts').text(response);
            }
        });

        // Total Sale
        $.ajax({
            type: "GET",
            url: "{{ route('SA-TotalSale') }}",
            success: function(response) {
                $('#totalSale').text(response);
            }
        });

        // Total Purchase
        $.ajax({
            type: "GET",
            url: "{{ route('SA-TotalPurchase') }}",
            success: function(response) {
                $('#totalPurchase').text(response);
            }
        });

        // Total Order
        $.ajax({
            type: "GET",
            url: "{{ route('SA-TotalOrders') }}",
            success: function(response) {
                $('#totalOrder').text(response);
            }
        });
    </script> --}}