@section('title','Website | LFK')
@include('superadmin.layouts.header')
@include('superadmin.layouts.aside')
@include('superadmin.layouts.nav')

<body onload="init()">

    <!-- sales css file -->
    <link rel="stylesheet" href="{{ asset('inventorybackend/css/style.css')}}" />

    <div class="main-panel">
        <div class="content-wrapper pb-0 tabs">
            <div role="tablist website-tab" aria-label="Programming Languages">
                <button role="tab" aria-selected="true" class="btn btn-primary btn-sm mb-3" id="bussiness_sale">
                    Banners
                </button>
                <button role="tab" aria-selected="false" class="btn btn-primary btn-sm mb-3" id="online_sale">
                    Blogs
                </button>
               <!-- <button role="tab" aria-selected="false" class="btn btn-primary btn-sm mb-3" id="contact_queries">
                    Contact Queries
                </button> -->
                 <button role="tab" aria-selected="false" class="btn btn-primary btn-sm mb-3" id="live_date">
                    Live Date Configuration
                </button>
                <button role="tab" aria-selected="false" class="btn btn-primary btn-sm mb-3">
                    <a href="{{ route('Home') }}" target="_blank">Visit Website</a>
                </button>
            </div>
            <div role="tabpanel" aria-labelledby="bussiness_sale">
                @include('superadmin.OfferPackeges.banners')
            </div>
            <div role="tabpanel" aria-labelledby="online_sale" hidden>
                <div class="bg-secondary p-2">
                    <div class="pb-0">
                        
                        <ul id="tabs">
                            <li><a href="#imageBlog">Blog Images</a></li>
                            <li><a href="#videoBlog">Blog Videos</a></li>
                        </ul>

                        <div class="tabContent" id="imageBlog">
                            @include('superadmin.blog.blog-image')
                        </div>

                        <div class="tabContent" id="videoBlog">
                            @include('superadmin.blog.blog-video')
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" aria-labelledby="contact_queries" hidden>
                @include('superadmin.contacts')
            </div>
            <div role="tabpanel" aria-labelledby="live_date" hidden>
                @include('superadmin.live_date')
            </div>
        </div>
        

        <!-- sales js file -->
        <script src="{{ asset('inventorybackend/js/action.js')}}"></script>

</body>
@include('superadmin.layouts.footer')