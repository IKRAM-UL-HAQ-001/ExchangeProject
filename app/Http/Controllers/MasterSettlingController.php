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

    public function exchangeIndex()
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $exchangeId = auth()->user()->exchange_id; 
            $userId = auth()->user()->id;
            $masterSettlingRecords= MasterSettling::with(['exchange', 'user'])
                ->where('exchange_id', $exchangeId)
                ->where('user_id', $userId)
                ->get();
            return view("exchange.master_settling.list",compact('masterSettlingRecords'));
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'You need to be logged in to perform this action.'], 401);
        }
        else{
            $validatedData = $request->validate([
                'white_label' => 'nullable|string|max:255',
                'credit_reff' => 'nullable|string',
                'settling_point' => 'nullable|numeric',
                'price' => 'nullable|numeric',
            ]);        
            try {
                $exchangeId = auth()->user()->exchange_id;
                $userId = auth()->user()->id;
                $total_amount = ($validatedData['price'] ?? 0) * ($validatedData['settling_point'] ?? 0);
                $masterSettling = MasterSettling::create([
                    'white_label' => $validatedData['white_label'],
                    'credit_reff' => $validatedData['credit_reff'],
                    'settling_point' => $validatedData['settling_point'],
                    'price' => $validatedData['price'],
                    'total_amount' => $total_amount,
                    'exchange_id' => $exchangeId,
                    'user_id' => $userId,
                ]);
                return response()->json(['message' => 'Master Settling added successfully!', 'data' => $masterSettling], 201);
        
            } catch (\Exception $e) {
                return $e; 
                return response()->json(['error' => 'An error occurred while adding the master settling.'], 500);
            }
        }
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
