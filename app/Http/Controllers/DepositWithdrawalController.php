<?php

namespace App\Http\Controllers;

use App\Models\DepositWithdrawal;
Use App\Exports\WithdrawalListExport;
Use App\Exports\DepositListExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Cash;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class DepositWithdrawalController extends Controller
{
    
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $depositWithdrawalRecords = Cash::with(['exchange', 'user'])
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();
            return view('admin.deposit_withdrawal.list',compact('depositWithdrawalRecords'));
        }
    }
    
    public function assistantIndex()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();

            $depositWithdrawalRecords = Cash::with(['exchange', 'user'])
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->get();
            return view('assistant.deposit_withdrawal.list',compact('depositWithdrawalRecords'));
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
    public function show(DepositWithdrawal $depositWithdrawal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepositWithdrawal $depositWithdrawal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DepositWithdrawal $depositWithdrawal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $depositWithdarwal = Cash::find($request->id);
            if ($depositWithdarwal) {
                $depositWithdarwal->delete();
                return response()->json(['success' => true, 'message' => 'Deposit/Withdarwal deleted successfully!']);
            }
            return response()->json(['success' => false, 'message' => 'Deposit/Withdarwal not found.'], 404);
        }
    }
    

}
