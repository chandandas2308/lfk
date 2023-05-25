@section('title', 'Inventory | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<!-- inventory css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css') }}" />
<!-- inventory js file -->
<script src="{{ asset('inventorybackend/js/action.js') }}"></script>

<body onload="init()">

    <div class="main-panel">
        <div class="content-wrapper pb-0">
            <ul id="tabs">
                <li><a href="#tab1">Categories</a></li>
                <li><a href="#tab2">Product</a></li>
                {{-- <li><a href="#img">Multiple Image</a></li> --}}
                <li><a href="#tab3">Return & Exchange</a></li>
                <li><a href="#tab4">Stock Tracking</a></li>
                <li><a href="#tab5">Stock Ageing</a></li>
                <li><a href="#tab6">Warehouse</a></li>
            </ul>

            <!-- Product Tab Content -->
            <div class="tabContent" id="tab2">
                @include('superadmin.inventory.product')
            </div>

            <!-- Categories Tab Content -->
            <div class="tabContent" id="tab1">
                @include('superadmin.inventory.categories')
            </div>

            <!-- Return & Exchange Tab Content -->
            <div class="tabContent" id="tab3">
                @include('superadmin.inventory.returnExchange')
            </div>

            <!-- Stock Tracking Tab Content -->
            <div class="tabContent" id="tab4">
                @include('superadmin.inventory.stockTracking')
            </div>

            <!-- Stock Aging Tab Content -->
            <div class="tabContent" id="tab5">
                @include('superadmin.inventory.stockAging')
            </div>

            <!-- Warehouse Tab Content -->
            <div class="tabContent" id="tab6">
                @include('superadmin.inventory.warehouse')
            </div>

        </div>
        
</body>

@include('superadmin.layouts.footer')
