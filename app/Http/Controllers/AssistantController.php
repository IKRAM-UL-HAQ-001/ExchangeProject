<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use Illuminate\Http\Request;

class AssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("assistant.dashboard");
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
    public function show(Assistant $assistant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assistant $assistant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assistant $assistant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assistant $assistant)
    {
        //
    }
}
