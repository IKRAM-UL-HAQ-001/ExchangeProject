<?php

namespace App\Http\Controllers;

use App\Models\BankBalance;
use Illuminate\Http\Request;

class BankBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bankBalanceRecords = BankBalance::all();
        return view("admin.bank_balance.list",compact('bankBalanceRecords'));
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
    public function show(BankBalance $bankBalance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankBalance $bankBalance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankBalance $bankBalance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $bankBalance = BankBalance::find($request->id);
        
        if ($bankBalance) {
            $bankBalance->delete();
            return response()->json(['success' => true, 'message' => 'Bank Balance deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Bank Balance not found.'], 404);
    }
}
