@section('title','Loyalty Point | LFK')
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
                <li><a href="#purchaseRequisition">Transaction</a></li>
                <li><a href="#purchaseOrder">Wallets</a></li>
                <li><a href="#vendors">Loyalty Points</a></li>
                <li><a href="#signInSetting">Sign In Setting</a></li>
                <li><a href="#checkInSetting">Check In Setting</a></li>
            </ul>

            <!-- purchase Requisition Tab Content -->
            <div class="tabContent" id="purchaseRequisition">
                @include('superadmin.LoyaltyPoint.transaction')
            </div>        

            <!-- purchaseOrder Tab Content -->
            <div class="tabContent" id="purchaseOrder">
                @include('superadmin.LoyaltyPoint.wallets')
            </div>

            <!-- vendors Tab Content -->
            <div class="tabContent" id="vendors">
                @include('superadmin.LoyaltyPoint.points')
            </div>

            <div class="tabContent" id="signInSetting">
                @include('superadmin.LoyaltyPoint.sign_in_points')
            </div>
            
            <div class="tabContent" id="checkInSetting">
                @include('superadmin.LoyaltyPoint.check_in')
            </div>
    </div>
</body>
@include('superadmin.layouts.footer')