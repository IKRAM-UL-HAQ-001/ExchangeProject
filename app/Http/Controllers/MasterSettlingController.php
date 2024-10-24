<?php

namespace App\Http\Controllers;

use App\Models\MasterSettling;
use Illuminate\Http\Request;

class MasterSettlingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masterSettlingRecords = MasterSettling::all();
        return view("admin.master_settling.list",compact('masterSettlingRecords'));
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
        $masterSettling = MasterSettling::find($request->id);
        if ($masterSettling) {
            $masterSettling->delete();
            return response()->json(['success' => true, 'message' => 'Master Settling deleted successfully!']);
        }
        return response()->json(['success' => false, 'message' => 'Master Settling not found.'], 404);
    }
}
