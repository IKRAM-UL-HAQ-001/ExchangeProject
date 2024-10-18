<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $bankRecords = Bank::all();
        return view("admin.bank.list",compact('bankRecords'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Bank::create([
            'name' => $request->name
        ]);
        return response()->json(['message' => 'Bank added successfully!'], 201);
    }

    public function show(Bank $bank)
    {

    }

    public function edit(Bank $bank)
    {
        //
    }

    public function update(Request $request, Bank $bank)
    {
        //
    }

    public function destroy(Request $request)
    {
        $bank = Bank::find($request->id);
        
        if ($bank) {
            $bank->delete();
            return response()->json(['success' => true, 'message' => 'Bank deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Bank not found.'], 404);
    }
}
