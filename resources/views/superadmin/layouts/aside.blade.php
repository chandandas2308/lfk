<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="text-center sidebar-brand-wrapper d-flex align-items-center">
          <a class="sidebar-brand brand-logo fw-bold h3" href="{{route('SA-Dashboard')}}"><img src="{{ asset('backend/images/ykpte-new-logo.png')}}" /></a>
          <a class="sidebar-brand brand-logo-mini pt-3 p-0" href="{{route('SA-Dashboard')}}"><img src="{{ asset('backend/images/new-logo.png')}}" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
              
            
            @if(Auth::user()->is_admin == 2)
              <div class="nav-profile-image">
                <img src="{{ asset('backend/images/superadmin.png')}}" alt="profile" />
                <span class="login-status online"></span>
              </div>
              <div class="nav-profile-text d-flex flex-column pr-3">
                <span class="font-weight-medium mb-2 fw-bold h5 mx-auto" style="color:#444">Super Admin</span>
              </div>
            @else
              <div class="nav-profile-image">
                <img src="{{ asset('backend/images/admin.png')}}" alt="profile" />
                <span class="login-status online"></span>
              </div>
              <div class="nav-profile-text d-flex flex-column pr-3">
                <span class="font-weight-medium mb-2 text-white fw-bold h5 mx-auto">Admin</span>
              </div>
            @endif


            </a>
          </li>
          <li class="nav-item {{request()->is('admin') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('SA-Dashboard')}}">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

        @if(Auth::user()->is_admin == 2)          
          <li class="nav-item">
            <a class="nav-link" href="{{route('SA-ListUser')}}">
              <i class="mdi mdi-account menu-icon"></i>
              <span class="menu-title">User Management</span>
            </a>
          </li>
        @endif  

          <?php
            use Illuminate\Support\Facades\Auth;
            $assigned = explode(",", Auth::user()->assigned_modules)
          ?>

        @if (in_array("inventory", $assigned) || Auth::user()->is_admin==2)
          <li class="nav-item">
            <a class="nav-link" href="{{route('SA-Inventory')}}">
              <i class="mdi mdi-sitemap menu-icon"></i>
              <span class="menu-title">Inventory</span>
            </a>
          </li>
        @endif
        @if (in_array("sales", $assigned) || Auth::user()->is_admin==2)
          <li class="nav-item">
            <a class="nav-link" href="{{route('SA-SalesTab')}}">
              <i class="mdi mdi-briefcase-upload menu-icon"></i>
              <span class="menu-title">Sales</span>
            </a>
          </li>
        @endif       
        @if (in_array("purchase", $assigned) || Auth::user()->is_admin==2)
          <li class="nav-item">
            <a class="nav-link" href="{{route('SA-Purchase')}}">
              <i class="mdi mdi-briefcase-download menu-icon"></i>
              <span class="menu-title">Purchase</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('SA-Delivery')}}">
              <i class="mdi mdi-motorbike menu-icon"></i>
              <span class="menu-title">Delivery</span>
            </a>
          </li>
          <li class="nav-item">
      <a class="nav-link" href="{{route('SA-Refferal')}}">
        <i class="mdi mdi-share menu-icon"></i>
        <span class="menu-title">Referral Awards</span>
      </a>
    </li>
        @endif
        
        <li class="nav-item">
            <a class="nav-link" href="{{route('SA-OfferPackages')}}">
              <i class="mdi mdi-star menu-icon"></i>
              <span class="menu-title">Offer & Packages</span>
            </a>
          </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('SA-ECredit')}}">
              <i class="mdi mdi-star menu-icon"></i>
              <span class="menu-title">E-Wallet Options</span>
            </a>
          </li>
        @if (in_array("customerManagement", $assigned) || Auth::user()->is_admin==2)
          <li class="nav-item">
            <a class="nav-link" href="{{route('SA-CustomerManagement')}}">
              <i class="mdi mdi-account-multiple menu-icon"></i>
              <span class="menu-title">Customer Management</span>
            </a>
          </li>
        @endif
        
          <li class="nav-item">
            <a class="nav-link" href="{{route('SA-LoyaltyPoint')}}">
              <i class="mdi mdi-star menu-icon"></i>
              <span class="menu-title">Loyalty Point</span>
            </a>
          </li>
 
            @if (in_array("redemption", $assigned) || Auth::user()->is_admin==2)
              <li class="nav-item">
                <a class="nav-link" href="{{route('redemption_shop.dashboard')}}">
                  <i class="mdi mdi-chart-line menu-icon"></i>
                  <span class="menu-title">Redemption Shop</span>
                </a>
              </li>
            @endif

            @if (in_array("reports", $assigned) || Auth::user()->is_admin==2)
              <li class="nav-item">
                <a class="nav-link" href="{{route('SA-Reports')}}">
                  <i class="mdi mdi-chart-line menu-icon"></i>
                  <span class="menu-title">Reports</span>
                </a>
              </li>
            @endif
            @if (in_array("contact", $assigned) || Auth::user()->role_id==0)
            <!-- <li class="nav-item">
              <a class="nav-link" href="{{route('SA-Contact')}}">
                <i class="mdi mdi-chart-line menu-icon" style="color: #6e0000;"></i>
                <span class="menu-title">Contact Queries</span>
              </a>
            </li> -->
            @endif
            @if (in_array("newsletter", $assigned) || Auth::user()->role_id==0)
            <!-- <li class="nav-item">
              <a class="nav-link" href="{{route('SA-Newsletter')}}">
                <i class="mdi mdi-chart-line menu-icon" style="color: #6e0000;"></i>
                <span class="menu-title">News Letter</span>
              </a>
            </li> -->
            @endif

            <li class="nav-item">
              <a class="nav-link" href="{{route('SA-WebsiteDashboard')}}">
                <i class="mdi mdi-earth menu-icon" style="color: #6e0000;"></i>
                <span class="menu-title">Website</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route('SA-POSDASHBOARD')}}">
                <i class="mdi mdi-earth menu-icon" style="color: #6e0000;"></i>
                <span class="menu-title">POS</span>
              </a>
            </li>
            
        </ul>
      </nav>