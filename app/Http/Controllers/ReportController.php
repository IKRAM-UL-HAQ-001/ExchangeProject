<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Exchange;
use App\Models\Cash;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

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
            $exchangeRecords = Exchange::all();
            $exchangeId = auth()->user()->exchange_id; 
            $userId = auth()->user()->id;
            $reportRecords= Report::with(['exchange', 'user'])
                ->where('exchange_id', $exchangeId)
                ->where('user_id', $userId)
                ->get();

            return view("exchange.report.list",compact('reportRecords'));
        }
    }



    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $exchangeRecords = Exchange::all();
            return view('admin.report.list',compact('exchangeRecords'));
        }
    }


    public function report(Request $request){
        if (!auth()->check()) {
            return redirect()->route('firstpage');
        }
        else{
            $today = Carbon::now();
            $exchangeRecords = Exchange::all();

            $start_date =$request->start_date;
            $end_date =$request->end_date;
            $exchangeId =$request->exchange_id;


            $deposit = Cash::whereBetween('created_at', ['start_date','end_date'])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereBetween('created_at', ['start_date','end_date'])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereBetween('created_at', ['start_date','end_date'])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereBetween('created_at', ['start_date','end_date'])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'deposit')
                ->sum('bonus_amount');

            // Get the latest cash entry for the shop
            $latestCashEntry = Cash::where('exchange_id', $exchangeId)
                ->orderBy('created_at', 'desc')
                ->first();
                $latestBalance =    $deposit -  $withdrawal -  $expense;
                
                $date = $today->format('Y-m-d');


            return view('admin.report.list', compact('deposit', 'expense', 'withdrawal', 'bonus', 'date', 'latestBalance','exchangeRecords'));
        }
    }

}
