<body id="body">
    <section class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="number text-left">
                        <i class="fa fa-phone"></i><a href="https://wa.me/6588393132?text=" target="_blank">+ 65 8839
                            3132</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="lang text-right">
                        <!-- <div id='google_translate_element'></div> -->
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Start Top Header Bar -->
    <section class="top-section">
        <div class="top-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 col-sm-2 col-xs-12 col-sm-4">
                        <!-- Site Logo -->
                        <div class="logo text-center">
                            <a href="/">
                                <!-- replace logo here -->
                                <img src="{{ asset('frontend/images/ykpte-new-logo.png') }}" alt="logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 mt-2 col-sm-8">
                        <form action="{{ route('product.search') }}" method="post" role="search">
                            @csrf
                            <div class="searchBar">
                                <input id="searchQueryInput" type="text" class="" name="search"
                                    placeholder="{{ __('lang.search_for_products')."..." }}"
                                    style="color: #8d8d8d;">

                                <button id="searchQuerySubmit" type="submit" name="searchQuerySubmit">
                                    <svg style="width:24px;height:24px; margin-top:5px;" viewBox="0 0 24 24">
                                        <path fill="#666666"
                                            d="M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z" />
                                    </svg>
                                </button>
                            </div>
                            {{-- <div class="form1">

                                <input type="text" class="" name="search"
                                    placeholder="{{ GoogleTranslate::trans('Search for Products...', app()->getLocale()) }}"
                                    style="color: #8d8d8d;">
                                    <button type="submit" class="left-pan">
                                        <!-- <span > -->
                                            <i class="fa fa-search"></i>
                                        <!-- </span> -->
                                    </button>

                            </div> --}}
                        </form>
                    </div>


                    <!-- ========================================================================================================================= -->
                    <!-- ========================================================================================================================= -->
                    <!-- TOP HEAD SECTION -->
                    <!-- ========================================================================================================================= -->
                    <!-- ========================================================================================================================= -->
                    <!-- Lang switch -->

                    <div class="col-md-7 col-sm-6 col-xs-12 col-sm-12">
                        <ul class="top-menu list-inline">
                            <!-- <li class="dropdown cart-nav dropdown-slide">
                                <div class="col-md-4">
                                    <select class="form-select changeLang">
                                        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>
                                            English</option>
                                        <option value="zh" {{ session()->get('locale') == 'zh' ? 'selected' : '' }}>
                                            Chinese</option>
                                    </select>
                                </div>
                            </li> -->
                            <li>
                                <div class="switch-field">
                                    <input type="radio" class="changeLang" id="radio-one" name="switch-one"
                                        value="en" {{ session()->get('locale') == 'en' ? 'checked' : '' }}>
                                    <label for="radio-one" style="font-weight:600;">ENG</label>
                                    <input type="radio" class="changeLang" id="radio-two" name="switch-one"
                                        value="zh" {{ session()->get('locale') == 'zh' ? 'checked' : '' }}>
                                    <label for="radio-two" style="font-weight:600;">中文</label>
                                </div>
                            </li>


                            {{-- <li class="dropdown cart-nav dropdown-slide">
                                <i class="fa fa-shopping-cart"><span id="cart_count">0</span></i>
                                <a href="#!" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                    style="margin-left:5px;">{{ __('lang.carts') }}</a>
                                <div class="dropdown-menu cart-dropdown" style="max-height: 420px; overflow-y: auto;">

                                    <span id="all_carts_products">

                                    </span>

                                    <div class="cart-summary">
                                        <span>Total</span>
                                        <span class="total-price">$<span id="carts_sub_total"></span></span>
                                    </div>
                                    <ul class="text-center cart-buttons">
                                        <li>
                                            <a href="{{ route('SA-IndexCart') }}" class="btn btn-small">
                                                {{ __('lang.view_cart') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('checkout.orderSummary') }}"
                                                class="btn btn-small btn-solid-border">
                                                {{ __('lang.checkout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li> --}}
                            <!-- / Cart -->



                            <!-- / Lang Switch -->
                            {{-- @if (!Auth::check())
                                <li class="dropdown cart-nav dropdown-slide">
                                    <i class="fa fa-user"></i><a
                                        href="{{ route('login-with-us1') }}">{{ __('lang.login') }}</a>
                                </li>
                            @endif --}}
                            <!-- Search -->
                            {{-- @if (Auth::check())
                                <li class="dropdown dropdown-slide">
                                    <i class="fa fa-user-circle"></i><a href="#!" class="dropdown-toggle"
                                        data-toggle="dropdown" data-hover="dropdown">{{ Auth::User()->name }}</a>
                                    <ul class="dropdown-menu">
                                        <li style="padding-top: 2px; padding-bottom: 2px;">
                                            <i class="fa fa-address-book-o text-info"></i><a
                                                href="{{ route('user.profile') }}"
                                                style="display: inline; padding:3px 10px;">{{ __('lang.my_profile') }}</a>
                                        </li>
                                        <li style="padding-top: 2px; padding-bottom: 2px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                style="height:12px;">
                                                <path fill="red"
                                                    d="M160 112c0-35.3 28.7-64 64-64s64 28.7 64 64v48H160V112zm-48 48H48c-26.5 0-48 21.5-48 48V416c0 53 43 96 96 96H352c53 0 96-43 96-96V208c0-26.5-21.5-48-48-48H336V112C336 50.1 285.9 0 224 0S112 50.1 112 112v48zm24 96c-13.3 0-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24s-10.7 24-24 24zm200-24c0 13.3-10.7 24-24 24s-24-10.7-24-24s10.7-24 24-24s24 10.7 24 24z" />
                                            </svg>
                                            <a href="{{ route('user.my-orders') }}"
                                                style="display: inline; padding:3px 10px;">{{ __('lang.my_orders') }}</a>
                                        </li>
                                        <li style="padding-top: 2px; padding-bottom: 2px;">
                                            <form action="{{ route('logout-with-normal-user') }}" method="POST">
                                                @csrf
                                                <i class="fa fa-sign-out text-danger"></i>
                                                <button type="submit" class="border-0 mx-auto"
                                                    style="border: none; background-color:white;">
                                                    {{ __('lang.log_out') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif --}}

                        </ul>
                        <!-- / .nav .navbar-nav .navbar-right -->
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="menu">
        <nav class="navbar navbar-expand-lg navbar-light bg-light navigation">
            <div class="container">
                <div class="navbar-header">
                    <h2 class="menu-title">{{ __('lang.main_menu') }}</h2>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse text-center" id="navbar">
                    <ul class="navbar-nav mr-auto" style="width: 100%">

                        <li class="dropdown">
                            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">{{ __('lang.home') }}
                            </a>
                        </li>

                        {{-- <li class="nav-item dropdown full-width dropdown-slide">
                            <a class="nav-link dropdown-toggle {{ request()->is('YKPTE/products') ? 'active' : '' }}" href="{{ route('AllProducts') }}" id="navbarDropdown" role="button"
                                 >
                                PRODUCTS
                                <b>
                                    <span class="tf-ion-ios-arrow-down" style="font-weight:1000;margin-left: 5px">
                                    </span>
                                </b>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="row">

                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($categories as $category)
                                        @if ($i <= 2)
                                            <div class="col-sm-2 col-xs-12">
                                                <ul>
                                                    <li class="dropdown-header">
                                                        @if (app()->getLocale() == 'en')
                                                            {{ $category->name }}
                                                        @else
                                                            {{ $category->chinese_name }}
                                                        @endif
                                                    </li>
                                                    <li role="separator" class="divider"></li>
                                                    @php $j = 0; @endphp
                                                    @foreach ($products as $product)
                                                        @if ($category->id == $product->product_category)
                                                            @if ($j <= 4)
                                                                <li><a href="/product/{{ $product->product_id }}">
                                                                        @if (app()->getLocale() == 'en')
                                                                            {{ $product->product_name }}
                                                                        @else
                                                                            {{ $product->product_name_c }}
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                @php ++$j @endphp
                                                            @else
                                                            @break;
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @php ++$i @endphp
                                            </ul>
                                        </div>
                                    @else
                                    @break;
                                @endif
                            @endforeach


                            <div class="col-sm-2 col-xs-12">
                                <ul>
                                    <li class="dropdown-header">
                                        {{ GoogleTranslate::trans('Categories', app()->getLocale()) }}</li>
                                    <li role="separator" class="divider"></li>
                                    @php
                                        $k = 0;
                                    @endphp
                                    @foreach ($categories as $category)
                                        @if ($k <= 5)
                                            <li>
                                                <a href="javascript:void(0)">
                                                    @if (app()->getLocale() == 'en')
                                                        {{ $category->name }}
                                                    @else
                                                        {{ $category->chinese_name }}
                                                    @endif
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                    @php ++$k; @endphp
                                </ul>
                            </div>

                            <div class="col-sm-3 col-xs-12">
                                <a href="{{ route('AllProducts') }}">
                                    <img class="img-responsive"
                                        src="{{ asset('frontend/images/new-img/about.jpg') }}"
                                        alt="menu image" />
                                </a>
                            </div>


                        </div>
                    </div>
                </li> --}}

                <li style="padding: 0;margin-top: -1px;">
                    <ul class="nav navbar-nav nested-ul" style="display: flex;justify-content: center;">
                       <!-- / Product -->
                       <li class="dropdown main1">
                         <a href="{{ route('AllProducts') }}"
                             class="{{ request()->is('YKPTE/products') ? 'active' : '' }}">{{ GoogleTranslate::trans('PRODUCTS', app()->getLocale()) }}</a>
                       </li>
    
                        <!-- PRODUCTS -->
                        <li class="dropdown main2 full-width dropdown-slide">
    
                               <a><b><span class="tf-ion-ios-arrow-down"
                                           style="font-weight:1000;margin-left: 5px"></span></b> </a>
    
                               <div class="dropdown-menu">
                               <div class="row">
                                   @php
                                       $i = 0;
                                   @endphp
                                   @foreach ($categories as $category)
                                       @if ($i <= 2)
                                           <div class="col-sm-2 col-xs-12">
                                               <ul>
                                                   <li class="dropdown-header">
                                                       @if(app()->getLocale() == 'en')
                                                           {{ $category->name }}
                                                       @else
                                                           {{ $category->chinese_name }}
                                                       @endif
                                                   </li>
                                                   <li role="separator" class="divider"></li>
                                                   @php $j = 0; @endphp
                                                   @foreach ($products as $product)
                                                       @if ($category->id == $product->product_category)
                                                           @if ($j <= 4)
                                                               <li><a href="/product/{{ $product->product_id }}">
                                                                       @if(app()->getLocale() == 'en')
                                                                           {{ $product->product_name }}
                                                                       @else
                                                                           {{ $product->product_name_c }}
                                                                       @endif
                                                                   </a>
                                                               </li>
                                                               @php ++$j @endphp
                                                           @else
                                                           @break;
                                                       @endif
                                                   @endif
                                               @endforeach
                                               @php ++$i @endphp
                                           </ul>
                                       </div>
                                   @else
                                   @break;
                                      @endif
                                      @endforeach
                                      <div class="col-sm-2 col-xs-12">
                                      <ul>
                                   <li class="dropdown-header">
                                       {{ GoogleTranslate::trans('Categories', app()->getLocale()) }}</li>
                                   <li role="separator" class="divider"></li>
                                   @php
                                       $k = 0;
                                   @endphp
                                   @foreach ($categories as $category)
                                       @if ($k <= 5)
                                           <li>
                                               <a href="{{ route('AllProducts',['id' => $category->id]) }}">
                                                   @if(app()->getLocale() == 'en')
                                                           {{ $category->name }}
                                                   @else
                                                       {{ $category->chinese_name }}
                                                   @endif
                                               </a>
                                           </li>
                                       @endif
                                   @endforeach
                                   @php ++$k; @endphp
                                      </ul>
                                      </div>
                                      <!-- Mega Menu -->
                                      <div class="col-sm-3 col-xs-12">
                                      <a href="{{ route('AllProducts') }}">
                                   <img class="img-responsive"
                                       src="{{ asset('frontend/images/new-img/about.jpg') }}"
                                       alt="menu image" />
                                      </a>
                                      </div>
                                  </div>
                                  <!-- / .row -->
                                  </div>
                                   <!-- / .dropdown-menu -->
                        </li>
                        <!-- / PRODUCTS -->
                    </ul>
                </li>

                <!-- / .row -->

                {{-- <li class="dropdown main1">
                    <a href="{{ route('checkIn.rewards') }}"
                        class="{{ request()->is('rewards/check-in-coins') ? 'active' : '' }}">
                        {{ GoogleTranslate::trans('REDEMPTION SHOP', app()->getLocale()) }}

                    </a>
                </li> --}}

                <li class="dropdown">
                    <a href="{{ route('blog') }}" class="{{ request()->is('blogs-list') ? 'active' : '' }}">
                        {{ GoogleTranslate::trans('Blog', app()->getLocale()) }}
                    </a>
                </li>
                <li class="dropdown">
                    <a href="{{ route('about-us') }}"
                        class="{{ request()->is('about-us') ? 'active' : '' }}">
                        {{ GoogleTranslate::trans('Company Overview', app()->getLocale()) }}
                    </a>
                </li>
                <li class="dropdown ">
                    <a href="{{ route('contact-us') }}"
                        class="{{ request()->is('contact-us') ? 'active' : '' }}">
                        {{ GoogleTranslate::trans('Contact US', app()->getLocale()) }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</section>



<style>
.datepicker-plot-area {
    z-index: 1151 !important;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    var url = "";

    $(".changeLang").change(function() {
        window.location.href = "{{ route('changeLang') }}" + "?lang=" + $(this).val();
    });
</script>
