<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Cash;
Use App\Exports\ExpenseListExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Auth;

class ExpenseController extends Controller
{
    public function expenseExportExcel(Request $request)
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
            return Excel::download(new ExpenseListExport($exchangeId), 'expenseRecord.xlsx');
        }
    }
    
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $expenseRecords = Cash::with(['exchange', 'user'])
            ->get();
            return view('admin.expense.list',compact('expenseRecords'));
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
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
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
            $expense = Cash::find($request->id);
            if ($expense) {
                $expense->delete();
                return response()->json(['success' => true, 'message' => 'Expense deleted successfully!']);
            }
            return response()->json(['success' => false, 'message' => 'Expense not found.'], 404);
        }
    }
}
