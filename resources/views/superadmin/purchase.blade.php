@section('title','Purchase | LFK')
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
                <li><a href="#purchaseRequisition">Purchase Requisition</a></li>
                <li><a href="#purchaseOrder">Purchase Order</a></li>
                <li><a href="#vendors">Vendors</a></li>
            </ul>

            <!-- purchase Requisition Tab Content -->
            <div class="tabContent" id="purchaseRequisition">
                @include('superadmin.purchase.purchaseRequisition')
            </div>        

            <!-- purchaseOrder Tab Content -->
            <div class="tabContent" id="purchaseOrder">
                @include('superadmin.purchase.purchaseOrder')
            </div>

            <!-- vendors Tab Content -->
            <div class="tabContent" id="vendors">
                @include('superadmin.purchase.vendors')
            </div>
            
    </div>
</body>
@include('superadmin.layouts.footer')