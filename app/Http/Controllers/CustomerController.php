<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Auth;
class CustomerController extends Controller
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
            $customerRecords = Customer::all();
            return view("admin.customer.list",compact('customerRecords'));
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
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        else{
            $user = Auth::user();
            $exchangeId = $user->exchange_id;
            $userId = $user->id;

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'cash_amount' => 'required|numeric',
                'reference_number' => 'required|string|max:255',
                'remarks' => 'required|string|max:255',
            ]);
    
            try {
                // Create a new customer entry
                $customer = Customer::create([
                    'name' => $validatedData['name'],
                    'reference_number' => $validatedData['reference_number'],
                    'cash_amount' => $validatedData['cash_amount'],
                    'remarks' => $validatedData['remarks'],
                    'exchange_id' => $exchangeId,
                    'user_id' => $userId,
                ]);
    
                // Return a JSON response
                return response()->json(['message' => 'Customer added successfully!', 'data' => $customer], 201);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Error adding customer: ' . $e->getMessage()], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
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
            $customer = Customer::find($request->id);
            if ($customer) {
                $customer->delete();
                return response()->json(['success' => true, 'message' => 'Customer deleted successfully!']);
            }
            return response()->json(['success' => false, 'message' => 'Customer not found.'], 404);
        }
    }

    public function exchangeIndex(){
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        else{
            $user = Auth::user();
            $customerRecords = Customer::where('exchange_id', $user->exchange_id)
                ->where('user_id', $user->id)
                ->get();
            return view("exchange.customer.list",compact('customerRecords'));
        }
    }
}
