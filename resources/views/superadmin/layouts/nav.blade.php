<div class="container-fluid page-body-wrapper">
  <div id="theme-settings" class="settings-panel">
    <i class="settings-close mdi mdi-close"></i>
    <p class="settings-heading">SIDEBAR SKINS</p>
    <div class="sidebar-bg-options selected" id="sidebar-default-theme">
      <div class="img-ss rounded-circle bg-light border mr-3"></div> Default
    </div>
    <div class="sidebar-bg-options" id="sidebar-dark-theme">
      <div class="img-ss rounded-circle bg-dark border mr-3"></div> Dark
    </div>
    <p class="settings-heading mt-2">HEADER SKINS</p>
    <div class="color-tiles mx-0 px-4">
      <div class="tiles light"></div>
      <div class="tiles dark"></div>
    </div>
  </div>
  <nav class="navbar col-lg-12 col-12 p-lg-0 fixed-top d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-stretch justify-content-between">
      <!-- <a class="navbar-brand brand-logo-mini align-self-center d-lg-none" href=""><img src="{{ asset('backend/images/ykpte-new-logo.png')}}" height="50px" width="90px" alt="logo" /></a> -->
      <button class="navbar-toggler navbar-toggler align-self-center mr-2" type="button" data-toggle="minimize">
        <i class="mdi mdi-menu"></i>
      </button>
      <!-- <ul class="navbar-nav">
        <li class="nav-item nav-search border-0 ml-1 ml-md-3 ml-lg-5 d-none d-md-flex">
          <form class="nav-link form-inline mt-2 mt-md-0">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search" />
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-magnify"></i>
                </span>
              </div>
            </div>
          </form>
        </li>
      </ul> -->
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
      <ul class="navbar-nav navbar-nav-right ml-lg-auto">

      
      @if( Session::has("error") )
      <div class="alert alert-danger alert-block" role="alert">
        <button class="close" data-dismiss="alert"></button>
        {{ Session::get("error") }}
      </div>
      @endif
    

        <li class="nav-item nav-profile dropdown border-0">
          <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown">
            <img class="nav-profile-img mr-2" alt="" src="{{ asset('backend/images/superadmin.png')}}" />
            <span class="profile-name text-uppercase" style="font-weight: 500;"> {{ Auth::User()->name }} </span>
          </a>
          <div class="dropdown-menu navbar-dropdown bg-white w-100" aria-labelledby="profileDropdown">
            <a class="dropdown-item" href="{{ route('SA-Profile') }}">
              <i class="mdi mdi-account mr-2 text-success"></i> Profile
            </a>
            <a class="dropdown-item" data-toggle="modal" data-target="#logoutModalforUser">
              Log Out
            </a>
          </div>
        </li>
      </ul>
      
    </div>
  </nav>

        <div class="modal fade" id="logoutModalforUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Alert</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">DO YOU WANT TO END SESSION?<span id="removeElementId"></span> </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="mdi mdi-logout text-primary"></i> YES </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
