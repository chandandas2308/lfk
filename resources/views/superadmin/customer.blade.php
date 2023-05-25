@section('title','Customer Management | LFK')
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
            <li><a href="#bussiness">Retail Customer</a></li>
            <li><a href="#retail">Business Customer</a></li>
        </ul>

        <!-- Invoice Tab Content -->
        <div class="tabContent" id="bussiness">
            @include('superadmin.retailCustomerManagement')
        </div>

        <!-- retail Tab Content -->
        <div class="tabContent" id="retail">
            @include('superadmin.customerManagement')
        </div> 

    </div>
</body>
@include('superadmin.layouts.footer')