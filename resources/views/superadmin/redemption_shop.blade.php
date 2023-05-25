@section('title','Redemption Shop | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<body onload="init()">

<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />

<div class="main-panel">
    <div class="content-wrapper pb-0">
        <ul id="tabs">
            <li><a href="#Voucher">Voucher</a></li>
            <li><a href="#Product">Product</a></li>
        </ul>

        <div class="tabContent" id="Voucher">
            @include('superadmin.redemption-shop.voucher')
        </div>
        <div class="tabContent" id="Product">
            @include('superadmin.redemption-shop.product')
        </div>
    </div>

<script src="{{ asset('inventorybackend/js/action.js')}}"></script>
</body>
@include('superadmin.layouts.footer')    