@section('title','Reports | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<body onload="init()">

<!-- sales css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />
<!-- sales js file -->
<script src="{{ asset('inventorybackend/js/action.js')}}"></script>

<div class="main-panel">
    <div class="content-wrapper pb-0">
        <ul id="tabs">
            <li><a href="#salesReport">Sales Report</a></li>
            <li><a href="#invoice">Order Report</a></li>
            <!-- <li><a href="#payments">Top Selling Report</a></li> -->
        </ul>

        <!-- Sales Report Tab Content -->
        <div class="tabContent" id="salesReport">
            @include('superadmin.reports.salesReports')
        </div>        

        <!-- Invoice Tab Content -->
        <div class="tabContent" id="invoice">
            @include('superadmin.reports.orderReports')
        </div>

        <!-- Payment Tab Content -->
        {{-- <div class="tabContent" id="payments">
        @include('superadmin.reports.topSellingReports')
        </div>     --}}

    </div>
    </body>
@include('superadmin.layouts.footer')