<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
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
            return view('admin.report.list');
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
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
    public function exchangeIndex()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $exchangeId = auth()->user()->exchange_id; 
            $userId = auth()->user()->id;
            $reportRecords= Report::with(['exchange', 'user'])
                ->where('exchange_id', $exchangeId)
                ->where('user_id', $userId)
                ->get();

            return view("exchange.report.list",compact('reportRecords'));
        }
    }
    public function adminDailyReport(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $user = Auth::user();
            $shopId = $request->shop_id;
            $today = Carbon::today();

            $deposit = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereDate('created_at', $today)
                ->where('shop_id', $shopId)
                ->where('cash_type', 'deposit')
                ->sum('bonus_amount');

            // Get the latest cash entry for the shop
            $latestCashEntry = Cash::where('shop_id', $shopId)
                ->orderBy('created_at', 'desc')
                ->first();
                $latestBalance =    $deposit -  $withdrawal -  $expense;
            // Get the latest balance if entry exists
            // $latestBalance = $latestCashEntry ? $latestCashEntry->total_shop_balance : null;

            // Prepare the date for display
            $date = $today->format('Y-m-d');

            // Return the view with the collected data
            return view('shop.report.dailyReport', compact('deposit', 'expense', 'withdrawal', 'bonus', 'date', 'latestBalance'));
        }
    }

}
