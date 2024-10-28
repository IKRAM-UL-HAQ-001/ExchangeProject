<?php

namespace App\Http\Controllers;

use App\Models\VenderPayment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VenderPaymentListExport;
use Auth;
use Carbon\Carbon;
class VenderPaymentController extends Controller
{

    public function venderPaymentExportExcel(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            return Excel::download(new VenderPaymentListExport(), 'venderPaymentRecord.xlsx');
        }
    }

    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); 
        $endOfWeek = Carbon::now()->endOfWeek();
        $venderPaymentRecords = VenderPayment::whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        return view('admin.vender_payment.list',compact('venderPaymentRecords'));
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
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        else{
            $validatedData = $request->validate([
                'paid_amount' => 'required|numeric',
                'remaining_amount' => 'required|numeric',
                'payment_type' => 'required|string',
                'remarks' => 'required|string|max:255',
            ]);
    
            try {
                // Create a new customer entry
                $venderPayment = VenderPayment::create([
                    'paid_amount' => $validatedData['paid_amount'],
                    'remaining_amount' => $validatedData['remaining_amount'],
                    'payment_type' => $validatedData['payment_type'],
                    'remarks' => $validatedData['remarks'],
                ]);
    
                // Return a JSON response
                return response()->json(['message' => 'vender Payment added successfully!', 'data' => $venderPayment], 201);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error adding owner profit: ' . $e->getMessage()], 500);
            }
        }
    }

    public function show(VenderPayment $venderPayment)
    {
        //
    }

    public function edit(VenderPayment $venderPayment)
    {
        //
    }

    public function update(Request $request, VenderPayment $venderPayment)
    {
        //
    }

    public function destroy(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $venderPayment = VenderPayment::find($request->id);
            if ($venderPayment) {
                $venderPayment->delete();
                return response()->json(['success' => true, 'message' => 'vender payment deleted successfully!']);
            }
            return response()->json(['success' => false, 'message' => 'vender payment not found.'], 404);
        }
    }
}
