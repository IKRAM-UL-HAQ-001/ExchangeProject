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
            return view("exchange.report.list");
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


    public function report(Request $request)
    {
        try {
            // Ensure the user is authenticated
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'exchange_id' => 'required|exists:exchanges,id',
            ]);

            $start_date = Carbon::parse($validated['start_date'])->startOfDay();
            $end_date = Carbon::parse($validated['end_date'])->endOfDay();
            $exchangeId = $validated['exchange_id'];

            // Calculate sums
            $deposit = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'deposit') // Confirm if 'deposit' is correct for bonuses
                ->sum('bonus_amount');

            // Calculate latest balance
            $latestBalance = $deposit - $withdrawal - $expense;

            // Prepare response data
            $response = [
                'deposit' => $deposit,
                'withdrawal' => $withdrawal,
                'expense' => $expense,
                'bonus' => $bonus,
                'latestBalance' => $latestBalance,
                'date_range' => [
                    'start' => $validated['start_date'],
                    'end' => $validated['end_date'],
                ],
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Report Generation Failed: ' . $e->getMessage());

            // Return a generic error message
            return response()->json(['error' => 'Failed to generate report. Please try again later.'], 500);
        }
    }

    public function exchangeReport(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'exchange_id' => 'required|exists:exchanges,id',
            ]);
            $start_date = Carbon::parse($validated['start_date'])->startOfDay();
            $end_date = Carbon::parse($validated['end_date'])->endOfDay();
            $exchangeId = $validated['exchange_id'];

            // Calculate sums
            $deposit = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'deposit')
                ->sum('cash_amount');

            $withdrawal = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'withdrawal')
                ->sum('cash_amount');

            $expense = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'expense')
                ->sum('cash_amount');

            $bonus = Cash::whereBetween('created_at', [$start_date, $end_date])
                ->where('exchange_id', $exchangeId)
                ->where('cash_type', 'deposit') // Confirm if 'deposit' is correct for bonuses
                ->sum('bonus_amount');

            // Calculate latest balance
            $latestBalance = $deposit - $withdrawal - $expense;

            // Prepare response data
            $response = [
                'deposit' => $deposit,
                'withdrawal' => $withdrawal,
                'expense' => $expense,
                'bonus' => $bonus,
                'latestBalance' => $latestBalance,
                'date_range' => [
                    'start' => $validated['start_date'],
                    'end' => $validated['end_date'],
                ],
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Report Generation Failed: ' . $e->getMessage());

            // Return a generic error message
            return response()->json(['error' => 'Failed to generate report. Please try again later.'], 500);
        }
    }
   
}
