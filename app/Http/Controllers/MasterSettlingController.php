<?php

namespace App\Http\Controllers;

use App\Models\MasterSettling;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MasterSettlingMonthlyListExport;
use App\Exports\MasterSettlingWeeklyListExport;
use Auth;

class MasterSettlingController extends Controller
{
    public function masterSettlingListMonthlyExportExcel(Request $request)
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
            return Excel::download(new MasterSettlingMonthlyListExport($exchangeId), 'MonthlyMasterSettlingRecord.xlsx');
        }
    }

    public function masterSettlingListWeeklyExportExcel(Request $request)
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
            return Excel::download(new MasterSettlingWeeklyListExport($exchangeId), 'WeeklyMasterSettlingRecord.xlsx');
        }
    }

    public function index()
    {

        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $masterSettlingRecords= MasterSettling::with(['exchange', 'user'])
                ->get();

            return view("admin.master_settling.list",compact('masterSettlingRecords'));
        }
    }
    public function indexAssistant()
    {

        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $masterSettlingRecords= MasterSettling::with(['exchange', 'user'])
                ->get();

            return view("assistant.master_settling.list",compact('masterSettlingRecords'));
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
    public function show(MasterSettling $masterSettling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSettling $masterSettling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterSettling $masterSettling)
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
            $masterSettling = MasterSettling::find($request->id);
            if ($masterSettling) {
                $masterSettling->delete();
                return response()->json(['success' => true, 'message' => 'Master Settling deleted successfully!']);
            }
            return response()->json(['success' => false, 'message' => 'Master Settling not found.'], 404);
        }
    }
}
