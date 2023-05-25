@section('title','Delivery | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<style>
    .btn.btn-sm{
        padding: 1px 8px !important;
    }
</style>

<body>

<!-- sales css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />

<div class="main-panel">
    <div class="content-wrapper pb-0 tabs">
        <div role="tablist" aria-label="Programming Languages">
            
            <button role="tab" aria-selected="true" class="btn btn-primary btn-sm btn-tablist" id="driver">
                Delivery Man
            </button>
            {{-- <button role="tab" aria-selected="false" class="btn btn-primary btn-sm btn-tablist" id="backend_delivery">
                Business Delivery
            </button> --}}
            <button role="tab" aria-selected="false" class="btn btn-primary btn-sm btn-tablist" id="consolidateOrders">
                Consolidate Orders
            </button>
            <button role="tab" aria-selected="false" class="btn btn-primary btn-sm btn-tablist" id="cancelOrders">
                Cancel Orders
            </button>
            {{-- <button role="tab" aria-selected="false" class="btn btn-primary btn-sm btn-tablist" id="packingList">
                Packing List
            </button> --}}
            <button role="tab" aria-selected="false" class="btn btn-primary btn-sm btn-tablist" id="deliverydate">
                Delivery Date
            </button>
            <button role="tab" aria-selected="false" class="btn btn-primary btn-sm btn-tablist" id="route">
                Route Planing
            </button>
        </div>
        <div role="tabpanel" aria-labelledby="driver">
            @include('superadmin.Driver.order2')
        </div>
        {{-- <div role="tabpanel" aria-labelledby="backend_delivery" class="bg-secondary p-2" hidden> 
            <div class="bg-secondary p-2">
                <div class="pb-0">
                    <!--  -->
                    <ul id="tabs">
                        <li><a href="#delivery">Delivery</a></li>
                        <li><a href="#order">Order Management</a></li>
                        <!-- <li><a href="#driver">Driver</a></li> -->
                    </ul>

                    <!-- Order Tab Content -->
                    <div class="tabContent" id="delivery">
                        @include('superadmin.Delivery.delivery')
                    </div>        

                    <!-- Order Tab Content -->
                    <div class="tabContent" id="order">
                        @include('superadmin.Delivery.order')
                    </div>        
                </div>
            </div>           
        </div> --}}
        <div role="tabpanel" aria-labelledby="consolidateOrders" class="bg-secondary p-2" hidden>
            {{-- old code --}}
            {{-- @include('superadmin.consolidate-order.order') --}}
            {{-- end old code --}}
            @include('superadmin.consolidate-order.list_of_postal_districts')


        </div>
        <div role="tabpanel" aria-labelledby="cancelOrders" hidden>
            @include('superadmin.cancel-orders.order')
        </div>
        {{-- <div role="tabpanel" aria-labelledby="packingList" hidden>
            @include('superadmin.packing_list.index')
        </div> --}}
        <div role="tabpanel" aria-labelledby="deliverydate" hidden>
            @include('superadmin.driverdate.driverdate')
        </div>
        <div role="tabpanel" aria-labelledby="route" hidden>
            {{-- @include('superadmin.Delivery.routes') --}}
            @include('superadmin.Delivery.show_route')
        </div>
       
    </div>
    <!--  -->
    <script src="{{ asset('inventorybackend/js/action.js')}}"></script>
</body>
@include('superadmin.layouts.footer')