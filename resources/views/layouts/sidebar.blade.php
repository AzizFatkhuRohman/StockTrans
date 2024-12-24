<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
      <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="{{url('/')}}" class="text-nowrap logo-img">
          <img src="{{asset('assets/images/logos/logo.png')}}" width="150" alt="" />
        </a>
        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
          <i class="ti ti-x fs-8"></i>
        </div>
      </div>
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
        <ul id="sidebarnav">
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Home</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{url('/')}}" aria-expanded="false">
              <span>
                <i class="ti ti-layout-dashboard"></i>
              </span>
              <span class="hide-menu">Dashboard</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Master</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{url('vendor')}}" aria-expanded="false">
              <span>
                <i class="ti ti-server"></i>
              </span>
              <span class="hide-menu">Vendor</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{url('customer')}}" aria-expanded="false">
              <span>
                <i class="ti ti-server"></i>
              </span>
              <span class="hide-menu">Customer</span>
            </a>
          </li>
          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Proccess</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{url('product')}}" aria-expanded="false">
              <span>
                <i class="ti ti-book"></i>
              </span>
              <span class="hide-menu">Produk</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="{{url('transaction')}}" aria-expanded="false">
              <span>
                <i class="ti ti-book"></i>
              </span>
              <span class="hide-menu">Transaksi</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>
  <div class="body-wrapper">
    <!--  Header Start -->
    <header class="app-header">
      <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item d-block d-xl-none">
            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
              <i class="ti ti-menu-2"></i>
            </a>
          </li>
        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
            <li class="nav-item dropdown">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                aria-expanded="false">
                <img src="{{asset('assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                <div class="message-body">
                  <a href="{{url('profile')}}" class="d-flex align-items-center gap-2 dropdown-item">
                    <i class="ti ti-user fs-6"></i>
                    <p class="mb-0 fs-3">My Profile</p>
                  </a>
                  <form action="{{route('logout')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</button>
                  </form>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>