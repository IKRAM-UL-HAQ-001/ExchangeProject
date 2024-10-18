<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="" target="_blank">
        <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">Demo project</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        @if(Auth::check())
          @if(Auth::user()->role === "admin")
              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.dashboard')}}">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">dashboard</i>
                      </div>
                      <span class="nav-link-text ms-1">Dashboard</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('admin/user') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.user.list')}}">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">person</i>
                      </div>
                      <span class="nav-link-text ms-1">User</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('admin/exchange') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.exchange.list')}}">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">Exchange</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('admin/bank') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.bank.list')}}">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">account_balance</i>
                      </div>
                      <span class="nav-link-text ms-1">Bank</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('admin/expense') ? 'active bg-gradient-primary' : '' }}" href="">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">Deposit - Withdrawal</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('admin/expense') ? 'active bg-gradient-primary' : '' }}" href="">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">Expense</span>
                  </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('admin/masterSettling') ? 'active bg-gradient-primary' : '' }}" href="">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">Master Settling</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('admin/bankBalance') ? 'active bg-gradient-primary' : '' }}" href="">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">Bank Balance</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white " href="">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">Created IDs</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white " href="">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">HK</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white " href="">
                      <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                      <i class="material-icons opacity-10">store</i>
                      </div>
                      <span class="nav-link-text ms-1">Reports</span>
                  </a>
              </li>
          @endif
          @if(Auth::user()->role === "exchange")
              <li class="nav-item">
              <a class="nav-link text-white active bg-gradient-primary" href="{{route('admin.dashboard')}}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">dashboard</i>
                  </div>
                  <span class="nav-link-text ms-1">Dashboard</span>
              </a>
              </li>
          @endif
          @if(Auth::user()->role === "assistant")
              <li class="nav-item">
              <a class="nav-link text-white active bg-gradient-primary" href="{{route('admin.dashboard')}}">
                  <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                  <i class="material-icons opacity-10">dashboard</i>
                  </div>
                  <span class="nav-link-text ms-1">Dashboard</span>
              </a>
              </li>
          @endif
        @endif
      </ul>
    </div>
  </aside>