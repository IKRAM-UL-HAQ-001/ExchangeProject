<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Cash;
use App\Models\OwnerProfit;
use App\Models\Customer;
use App\Models\MasterSettling;
use App\Models\BankEntry;
use App\Models\OpenCloseBalance;
use App\Models\User;
use App\Models\Exchange;
use App\Models\VenderPayment;
use Carbon\Carbon;
use Auth;
use DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $today = Carbon::today();

            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            $totalOpenCloseBalanceDaily = 0;
            $totalOpenCloseBalanceMonthly = 0;
            
            // Get the latest entries for today
            $latestEntriesDaily = OpenCloseBalance::select('exchange_id', DB::raw('MAX(created_at) as latest_created_at'))
                ->groupBy('exchange_id')
                ->get();
            // dd($latestEntriesDaily);
            $totalOpenCloseBalanceDaily = OpenCloseBalance::whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))
                      ->from('open_close_balances')
                      ->groupBy('exchange_id');
            })->get(['exchange_id', 'close_balance', 'created_at']);
            // foreach ($latestEntriesDaily as $entry) {
            //     $latestEntry = OpenCloseBalance::where('exchange_id', $entry->exchange_id)
            //         ->where('created_at', $entry->latest_created_at)
            //         ->first();
            
            //     if ($latestEntry) {
            //         $totalOpenCloseBalanceDaily += $latestEntry->close_balance;
            //     }
            // }
                dd($totalOpenCloseBalanceDaily);
            // Get the latest entries for the current month
            $latestEntriesMonthly = OpenCloseBalance::select('exchange_id', DB::raw('MAX(created_at) as latest_created_at'))
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->groupBy('exchange_id')
                ->get();
            
            foreach ($latestEntriesMonthly as $entry) {
                $latestEntry = OpenCloseBalance::where('exchange_id', $entry->exchange_id)
                    ->where('created_at', $entry->latest_created_at)
                    ->first();
            
                if ($latestEntry) {
                    $totalOpenCloseBalanceMonthly += $latestEntry->close_balance;
                }
            }

            $totalPaidAmountDaily = VenderPayment::whereDate('created_at', $today)
                ->sum('paid_amount');

            $totalPaidAmountMonthly = VenderPayment::whereMonth('created_at', $currentMonth)
            ->sum('paid_amount');

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
                
            $totalCustomersDaily = Customer::whereDate('created_at', $today)
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
            ->distinct('settling_point')
            ->sum('settling_point');
            
            $totalOwnerProfitMonthly= OwnerProfit::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('cash_amount');
            
            $totalCustomersMonthly = Customer::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->distinct('id')
                ->count('id');
            
            $totalAmountAdd = BankEntry::where('cash_type', 'add')
                ->sum('cash_amount');

            $totalAmountSubtract = BankEntry::where('cash_type', 'minus')
                ->sum('cash_amount');

            $totalBankBalance = $totalAmountAdd - $totalAmountSubtract;
            
            $totalBalanceMonthly = $totalDepositMonthly - $totalWithdrawalMonthly - $totalExpenseMonthly;
            $totalUsers = User::count();
            $totalExchanges = Exchange::count();
            $viewData = compact(
                'totalUsers', 'totalExchanges', 'totalBalanceMonthly', 'totalDepositMonthly', 
                'totalWithdrawalMonthly', 'totalExpenseMonthly', 'totalMasterSettlingMonthly',
                'totalOpenCloseBalanceMonthly', 'totalPaidAmountMonthly', 'totalBonusMonthly',
                'totalOldCustomersMonthly', 'totalOwnerProfitMonthly', 'totalCustomersMonthly',
                'totalBalanceDaily', 'totalDepositDaily', 'totalWithdrawalDaily', 'totalExpenseDaily',
                'totalBonusDaily', 'totalOldCustomersDaily', 'totalOwnerProfitDaily', 'totalCustomersDaily',
                'totalBankBalance', 'totalOpenCloseBalanceDaily', 'totalPaidAmountDaily'
            );
            return response()
            ->view('admin.dashboard', $viewData)
            // ->header('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;")
            ->header('X-Frame-Options', 'DENY');
        }   
    }    

}
