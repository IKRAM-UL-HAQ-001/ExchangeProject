<?php

namespace App\Http\Controllers;

use App\Models\BankEntry;
use App\Models\Bank;
use Illuminate\Http\Request;
use Auth;
class BankEntryController extends Controller
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
            $bankEntryRecords= BankEntry::all();
            $bankRecords= Bank::all();
            return view('exchange.bank.list',compact('bankEntryRecords','bankRecords'));
        }    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $bankRecords = Bank::all();
            return view("exchange.bank.list",compact('bankRecords'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }

        $validatedData = $request->validate([
            'account_number' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'cash_amount' => 'required|numeric',
            'cash_type' => 'required|string',
            'remarks' => 'required|string',
        ]);

        try {
            $user = Auth::user();

            if ($user->role == "exchange") {
                $bankEntry = BankEntry::create([
                    'account_number' => $validatedData['account_number'],
                    'bank_name' => $validatedData['bank_name'],
                    'cash_amount' => $validatedData['cash_amount'],
                    'cash_type' => $validatedData['cash_type'],
                    'remarks' => $validatedData['remarks'],
                    'exchange_id' => $user->exchange_id,
                    'user_id' => $user->id,
                ]);

                return response()->json(['message' => 'Bank Entry Data saved successfully!', 'data' => $bankEntry], 201);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while saving Bank Entry Data: ' . $e->getMessage()], 500);
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(BankEntry $bankEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankEntry $bankEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankEntry $bankEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankEntry $bankEntry)
    {
        //
    }
    
    public function getBankBalance(Request $request) {
        $request->validate(['bank_name' => 'required|string']);
    
        $sumBalance = BankEntry::where('bank_name', $request->bank_name)
            ->selectRaw('SUM(CASE WHEN cash_type = "add" THEN cash_amount WHEN cash_type = "minus" THEN -cash_amount END) as balance')
            ->value('balance');
    
        return response()->json(['balance' => $sumBalance ?? 0]);
    }
}
