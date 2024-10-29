<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Cash;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
Use App\Exports\WithdrawalListExport;
use Carbon\Carbon;
use Auth;
class WithdrawalController extends Controller
{
    
    public function withdrawalExportExcel(Request $request)
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
            return Excel::download(new WithdrawalListExport($exchangeId), 'withdrawalRecord.xlsx');
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
        $withdrawalRecords = Cash::with(['exchange', 'user'])
            ->where('exchange_id', $exchangeId) 
            ->where('user_id', $userId) 
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();
        return view('exchange.withdrawal.list', compact('withdrawalRecords'));
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
    public function show(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Withdrawal $withdrawal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Withdrawal $withdrawal)
    {
        //
    }
}
