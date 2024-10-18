<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("exchange.dashboard");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function exchangeList()
    {
        $exchangeRecords = Exchange::orderBy('created_at', 'desc')->get();
        return view("admin.exchange.list",compact('exchangeRecords'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Exchange::create([
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Exchange added successfully!'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Exchange $exchange)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exchange $exchange)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exchange $exchange)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $exchange = Exchange::find($request->id);
        
        if ($exchange) {
            $exchange->delete();
            return response()->json(['success' => true, 'message' => 'Exchange deleted successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Exchange not found.'], 404);
    }
}
