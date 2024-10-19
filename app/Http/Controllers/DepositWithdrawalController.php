<?php

namespace App\Http\Controllers;

use App\Models\DepositWithdrawal;
use App\Models\Cash;
use Illuminate\Http\Request;

class DepositWithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $depositWithdrawalRecords = Cash::with(['exchange', 'user'])
        ->get();
        return view('admin.deposit_withdrawal.list',compact('depositWithdrawalRecords'));
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
        $depositWithdarwal = DepositWithdarwal::find($request->id);
        
        if ($depositWithdarwal) {
            $depositWithdarwal->delete();
            return response()->json(['success' => true, 'message' => 'Deposit/Withdarwal deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Deposit/Withdarwal not found.'], 404);
    }
}
