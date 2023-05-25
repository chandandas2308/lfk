@section('title','Fixed Asset Management | LFK')
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
                <li><a href="#asset">Asset</a></li>
                <li><a href="#assetTracking">Asset Tracking</a></li>
            </ul>

            <!-- purchase Requisition Tab Content -->
            <div class="tabContent" id="asset">
                @include('superadmin.fixed-asset.asset')
            </div>

            <!-- purchaseOrder Tab Content -->
            <div class="tabContent" id="assetTracking">
                @include('superadmin.fixed-asset.assetTracking')
            </div>
            
    </div>
</body>
@include('superadmin.layouts.footer')