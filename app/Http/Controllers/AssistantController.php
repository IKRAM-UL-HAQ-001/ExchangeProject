<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use App\Models\Cash;
use App\Models\OwnerProfit;
use App\Models\Customer;
use App\Models\MasterSettling;
use App\Models\BankBalance;
use App\Models\User;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class AssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $today = Carbon::today();
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            
            $totalDepositDaily = Cash::where('cash_type', 'deposit')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');

            $totalWithdrawalDaily = Cash::where('cash_type', 'withdrawal')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');   

            $totalExpenseDaily = Cash::where('cash_type', 'expense')
                ->whereDate('created_at', $today)
                ->sum('cash_amount');  

            $totalBonusDaily = Cash::whereDate('created_at', $today)
                ->sum('bonus_amount');
            $totalOldCustomersDaily = Cash::whereDate('created_at', $today)
                ->distinct('reference_number')
                ->count('reference_number');
            
            $totalOwnerProfitDaily = OwnerProfit::whereDate('created_at', $today)
                ->sum('cash_amount');
                
            $totalCustomerDaily = Customer::whereDate('created_at', $today)
                ->distinct('id')
                ->count('id');

            $totalBalanceDaily =  $totalDepositDaily -  $totalWithdrawalDaily -  $totalExpenseDaily ;
            
            $totalDepositMonthly = Cash::where('cash_type', 'deposit')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
        
            $totalWithdrawalMonthly = Cash::where('cash_type', 'withdrawal')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
            
            $totalExpenseMonthly = Cash::where('cash_type', 'expense')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
        
            $totalBonusMonthly = Cash::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('bonus_amount');
                
            $totalOldCustomersMonthly = Cash::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('reference_number')
                ->count('reference_number');
            
            $totalMasterSettlingMonthly = MasterSettling::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->distinct('settle_point')
            ->sum('settle_point');
            
            $totalOwnerProfitMonthly= OwnerProfit::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
            
            $totalCustomerMonthly = Customer::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('id')
                ->count('id');
            
            $totalAmountAdd = BankBalance::where('cash_type', 'add')
                ->sum('cash_amount');

            $totalAmountSubtract = BankBalance::where('cash_type', 'minus')
                ->sum('cash_amount');

            $totalBankBalance = $totalAmountAdd - $totalAmountSubtract;
            
            $totalBalanceMonthly = $totalDepositMonthly - $totalWithdrawalMonthly - $totalExpenseMonthly;
            $totalUsers = User::count();
            $totalExchanges = Exchange::count();
            return view('/assistant.dashboard',compact('totalUsers','totalExchanges',
                'totalBalanceMonthly','totalDepositMonthly','totalWithdrawalMonthly',
                'totalExpenseMonthly','totalMasterSettlingMonthly',
                'totalBonusMonthly','totalOldCustomersMonthly','totalOwnerProfitMonthly',
                'totalCustomerMonthly','totalBalanceDaily','totalDepositDaily',
                'totalWithdrawalDaily','totalExpenseDaily','totalBonusDaily','totalOldCustomersDaily',
                'totalOwnerProfitDaily','totalCustomerDaily','totalBankBalance',
            ));
        }   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Assistant $assistant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assistant $assistant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assistant $assistant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assistant $assistant)
    {
        //
    }
}
