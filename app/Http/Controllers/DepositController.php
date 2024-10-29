<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Models\Cash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class DepositController extends Controller
{
    
    public function depositExportExcel(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            if(Auth::user()->role == "admin" || Auth::user()->role == "assistant"){
                $exchangeId = null;
            }
            else{
                $exchangeId = Auth::user()->exchange_id;
            }
            return Excel::download(new DepositListExport($exchangeId), 'depositRecord.xlsx');
        }
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $exchangeId = auth()->user()->exchange_id;
        $userId = auth()->user()->id;
        $depositRecords = Cash::with(['exchange', 'user'])
            ->where('exchange_id', $exchangeId) 
            ->where('user_id', $userId) 
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();
        return view('exchange.deposit.list', compact('depositRecords'));
    }

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
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}
