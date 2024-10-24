<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="" target="_blank">
            <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Demo project</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
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
                                <i class="material-icons opacity-10">people</i>
                            </div>
                            <span class="nav-link-text ms-1">User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/exchange') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.exchange.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">swap_horiz</i>
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
                        <a class="nav-link text-white {{ request()->is('admin/deposit-withdrawal') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.deposit_withdrawal.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">attach_money</i>
                            </div>
                            <span class="nav-link-text ms-1">Deposit - Withdrawal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/expense') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.expense.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">monetization_on</i>
                            </div>
                            <span class="nav-link-text ms-1">Expense</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/masterSettling') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.master_settling.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">settings</i>
                            </div>
                            <span class="nav-link-text ms-1">Master Settling</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/bankBalance') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.bank_balance.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">account_balance_wallet</i>
                            </div>
                            <span class="nav-link-text ms-1">Bank Balance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/customer') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.customer.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">person_add</i>
                            </div>
                            <span class="nav-link-text ms-1">New Customer</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/ownerProfit') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.owner_profit.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">attach_money</i>
                            </div>
                            <span class="nav-link-text ms-1">Owner Profit</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('admin/report') ? 'active bg-gradient-primary' : '' }}" href="{{route('admin.report.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">assessment</i>
                            </div>
                            <span class="nav-link-text ms-1">Reports</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->role === "exchange")
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('exchange.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{route('exchange.dashboard')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">dashboard</i>
                            </div>
                            <span class="nav-link-text ms-1">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('exchange/cash') ? 'active bg-gradient-primary' : '' }}" href="{{route('exchange.cash.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">monetization_on</i>
                            </div>
                            <span class="nav-link-text ms-1">Cash</span>
                        </a>
                    </li>
                @endif
                @if(Auth::user()->role === "assistant")
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->routeIs('assistant.dashboard') ? 'active bg-gradient-primary' : '' }}" href="{{route('assistant.dashboard')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">dashboard</i>
                            </div>
                            <span class="nav-link-text ms-1">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('assistant/masterSettling') ? 'active bg-gradient-primary' : '' }}" href="{{route('assistant.master_settling.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">settings</i>
                            </div>
                            <span class="nav-link-text ms-1">Master Settling</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('assistant/bankBalance') ? 'active bg-gradient-primary' : '' }}" href="{{route('assistant.bank_balance.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">account_balance_wallet</i>
                            </div>
                            <span class="nav-link-text ms-1">Bank Balance</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ request()->is('assistant/deposit-withdrawal') ? 'active bg-gradient-primary' : '' }}" href="{{route('assistant.deposit_withdrawal.list')}}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">attach_money</i>
                            </div>
                            <span class="nav-link-text ms-1">Deposit - Withdrawal</span>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </div>
</aside>
