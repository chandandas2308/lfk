@section('title','POS | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<body onload="init()">

<!-- sales css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />

    <div class="main-panel">
        <div class="content-wrapper pb-0 tabs">
            <div role="tablist website-tab" aria-label="Programming Languages">
                <!-- <button role="tab" aria-selected="true" class="btn btn-primary btn-sm mb-3" id="pos_stock">
                    POS Stock
                </button> -->
                <!-- <button role="tab" aria-selected="false" class="btn btn-primary btn-sm mb-3" id="outlet_management">
                    Outlet Management
                </button> -->
            </div>
            <!-- <div role="tabpanel" aria-labelledby="pos_stock">
                'test'
            </div> -->
            <div role="tabpanel" aria-labelledby="outlet_management">
                @include('superadmin.pos.posOutlet')
            </div>
        </div>
    <!-- </div> -->

<!-- sales js file -->
<script src="{{ asset('inventorybackend/js/action.js')}}"></script>

</body>
@include('superadmin.layouts.footer')