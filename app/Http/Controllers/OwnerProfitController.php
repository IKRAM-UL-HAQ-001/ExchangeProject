<?php

namespace App\Http\Controllers;

use App\Models\OwnerProfit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OwnerProfitListExport;
use Auth;
class OwnerProfitController extends Controller
{
    public function ownerProfitListExportExcel(Request $request)
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
            return Excel::download(new OwnerProfitListExport($exchangeId), 'ownerProfitRecord.xlsx');
        }
    }

    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $ownerProfitRecords = OwnerProfit::all();
            return view('admin.owner_profit.list',compact('ownerProfitRecords'));
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
    public function show(OwnerProfit $ownerProfit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OwnerProfit $ownerProfit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OwnerProfit $ownerProfit)
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
            $ownerProfit = OwnerProfit::find($request->id);
            if ($ownerProfit) {
                $ownerProfit->delete();
                return response()->json(['success' => true, 'message' => 'owner Profit deleted successfully!']);
            }
            return response()->json(['success' => false, 'message' => 'Owner Profit not found.'], 404);
        }
    }
}
