<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="" class="logo d-flex align-items-center justify-content-center">
        <img src="{{ asset('pos/assets/img/ykpte-new-logo.png') }}" alt="">
        <!-- <span class="d-none d-lg-block">POS</span> -->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3 ">
          <a class="nav-link nav-profile d-flex align-items-center pe-0 me-2" href="#" data-bs-toggle="dropdown">
           
            <span class="dropdown-toggle ps-2 me-1">{{Auth::user()->name }}</span>
         </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{Auth::user()->name }}</h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{url('/pos/profile')}}">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#logoutModalforUser">
                <i class="bi bi-box-arrow-right"></i>
                   <span >Sign Out</span>  
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

    
  </header><!-- End Header -->
        <div class="modal fade" id="logoutModalforUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Alert</h5>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">DO YOU WANT TO END SESSION?<span id="removeElementId"></span> </div>
                    <div class="modal-footer">
                        <button class="btn btn-warning" type="button" data-bs-dismiss="modal">NO</button>
                        <form action="{{route('login.pos-logout')}}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item"><i class="fa-sharp fa-solid fa-arrow-right-from-bracket text-danger"></i> YES </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>