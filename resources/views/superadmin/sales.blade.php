@section('title','Sales | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<body onload="init()">

<!-- sales css file -->
<link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />

    <div class="main-panel">
        <div class="content-wrapper pb-0 tabs">
            <div role="tablist" aria-label="Programming Languages">
                <button role="tab" aria-selected="true" class="btn btn-primary btn-sm btn-tablist" id="online_sale">
                    Online Sale
                </button>
                <button role="tab" aria-selected="false" class="btn btn-primary btn-sm btn-tablist" id="bussiness_sale">
                    Business Sale
                </button>
            </div>
            <div role="tabpanel" aria-labelledby="bussiness_sale" hidden>
                <!--  -->

                    <div class="bg-secondary p-2">
                        <div class="pb-0">
                            <ul id="tabs">
                                <li><a href="#quotation">Quotation</a></li>
                                <li><a href="#Order">Order</a></li>
                                <li><a href="#invoice">Invoice</a></li>
                                <li><a href="#payments">Payments</a></li>
                            </ul>

                            <div class="tabContent" id="quotation">
                                @include('superadmin.sales.quotation')
                            </div>        

                            <div class="tabContent" id="Order">
                                @include('superadmin.sales.order')
                            </div>

                            <div class="tabContent" id="invoice">
                                @include('superadmin.sales.invoice')
                            </div>

                            <div class="tabContent" id="payments">
                                @include('superadmin.sales.payments')
                            </div>     

                        </div>
                    </div>

                <!--  -->
            </div>
            <div role="tabpanel" aria-labelledby="online_sale" >
                @include('superadmin.online-sale.online_sale')
            </div>
        </div>
    </div>

<!-- sales js file -->
<script src="{{ asset('inventorybackend/js/action.js')}}"></script>

</body>
@include('superadmin.layouts.footer')