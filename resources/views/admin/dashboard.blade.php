@extends("layout.main")
@section('content')
<div class="container-fluid">
    <!-- Daily Bases Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-header p-0 position-relative mb-3">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                    <p style="color: white;"><strong>Daily Bases</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl position-relative">
                            <i class="material-icons opacity-10">attach_money</i>
                        </div>
                        <div class="text-end ms-3">
                            <p class="text-sm mb-0 text-capitalize">Total Bank Balance</p>
                            <h4 class="mb-0">{{ $totalBankBalance }}</h4>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
            </div>
        </div>
        @foreach ([
            ['Today Margin', $totalBalanceDaily, 'bg-gradient-success', 'attach_money'],
            ['Total Deposit', $totalDepositDaily, 'bg-gradient-info', 'arrow_upward'],
            ['Total Withdrawal', $totalWithdrawalDaily, 'bg-gradient-warning', 'arrow_downward'],
            ['Total Expense', $totalExpenseDaily, 'bg-gradient-danger', 'money_off'],
            ['Total Bonus', $totalBonusDaily, 'bg-gradient-dark', 'star'],
            ['Total Exchanges', $totalExchanges, 'bg-gradient-primary', 'swap_horiz'],
            ['Total Users', $totalUsers, 'bg-gradient-secondary', 'people'],
            ['Customers', $totalOldCustomersDaily, 'bg-gradient-info', 'person'],
            ['Today Profit', $totalOwnerProfitDaily, 'bg-gradient-success', 'money'],
            ['Total New Customer', $totalCustomersDaily, 'bg-gradient-warning', 'group_add'],
            ['Total Open Close Balance', $totalOpenCloseBalanceDaily, 'bg-gradient-warning', 'group_add'],
            ['Total Paid Amount', $totalPaidAmountDaily, 'bg-gradient-warning', 'group_add'],
        ] as $card)
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape {{ $card[2] }} shadow-{{ strtolower($card[2]) }} text-center border-radius-xl position-relative">
                                <i class="material-icons opacity-10">{{ $card[3] }}</i> <!-- Icon for each card -->
                            </div>
                            <div class="text-end ms-3">
                                <p class="text-sm mb-0 text-capitalize">{{ $card[0] }}</p>
                                <h4 class="mb-0">{{ $card[1] }}</h4>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
            </div>
        @endforeach
    </div>

    <!-- Monthly Bases Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-header p-0 position-relative mb-3">
                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 d-flex justify-content-between align-items-center px-3">
                    <p style="color: white;"><strong>Monthly Bases</strong></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-header p-3">
                    <div class="d-flex align-items-center">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl position-relative">
                            <i class="material-icons opacity-10">attach_money</i> <!-- Monthly Profit -->
                        </div>
                        <div class="text-end ms-3">
                            <p class="text-sm mb-0 text-capitalize">Monthly Margin</p>
                            <h4 class="mb-0">{{ $totalBalanceMonthly }}</h4>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
            </div>
        </div>

        @foreach ([
            ['Total Deposit', $totalDepositMonthly, 'bg-gradient-info', 'arrow_upward'],
            ['Total Withdrawal', $totalWithdrawalMonthly, 'bg-gradient-warning', 'arrow_downward'],
            ['Total Expense', $totalExpenseMonthly, 'bg-gradient-danger', 'money_off'],
            ['Total Bonus', $totalBonusMonthly, 'bg-gradient-dark', 'star'],
            ['Total Exchanges', $totalExchanges, 'bg-gradient-primary', 'swap_horiz'],
            ['Total Users', $totalUsers, 'bg-gradient-secondary', 'people'],
            ['Customers', $totalOldCustomersMonthly, 'bg-gradient-info', 'person'],
            ['Monthly Profit', $totalOwnerProfitMonthly, 'bg-gradient-success', 'money'],
            ['Total New Customer', $totalCustomersMonthly, 'bg-gradient-warning', 'group_add'],
            ['Total Settling Points', $totalMasterSettlingMonthly, 'bg-gradient-danger', 'point_of_sale'],
        ] as $card)
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-header p-3">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-lg icon-shape {{ $card[2] }} shadow-{{ strtolower($card[2]) }} text-center border-radius-xl position-relative">
                                <i class="material-icons opacity-10">{{ $card[3] }}</i> <!-- Icon for each card -->
                            </div>
                            <div class="text-end ms-3">
                                <p class="text-sm mb-0 text-capitalize">{{ $card[0] }}</p>
                                <h4 class="mb-0">{{ $card[1] }}</h4>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
