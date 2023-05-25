@section('title','Offer & Packages | LFK')
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
                <li><a href="#loyaltypointchart">Offers</a></li>
                <li><a href="#LoyaltyShop">Coupon</a></li>
                <!-- <li><a href="#banners">Banner</a></li> -->
            </ul>

            <!-- purchase Requisition Tab Content -->
            <div class="tabContent" id="loyaltypointchart">
                @include('superadmin.OfferPackeges.offer')
            </div>

            <!-- purchaseOrder Tab Content -->
            <div class="tabContent" id="LoyaltyShop">
                @include('superadmin.OfferPackeges.coupon')
            </div>
            
            <!-- Banners Tab Content -->
            <!-- <div class="tabContent" id="banners"> -->
                <!-- include('superadmin.OfferPackeges.banners') -->
            <!-- </div> -->
            
    </div>
</body>
@include('superadmin.layouts.footer')