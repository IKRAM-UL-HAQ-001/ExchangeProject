<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Cash;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenseRecords = Cash::with(['exchange', 'user'])
        ->where('cash_type', 'expense')
        ->get();
        return view('admin.expense.list',compact('expenseRecords'));
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
        $expense = Expense::find($request->id);
        
        if ($expense) {
            $expense->delete();
            return response()->json(['success' => true, 'message' => 'Expense deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Expense not found.'], 404);
    }
}
