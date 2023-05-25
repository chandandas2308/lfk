@section('title','E-Credit Management | LFK')
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
                <li><a href="#ecredit">E-Wallet Management</a></li>
            </ul>

            <!-- retail Tab Content -->
            <div class="tabContent" id="ecredit">
                @include('superadmin.ECredit.ecredit')
            </div>
        </div>
</body>

@include('superadmin.layouts.footer')