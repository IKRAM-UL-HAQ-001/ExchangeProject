<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Exchange;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exchangeRecords =  Exchange::all();
        return view("auth.login",compact('exchangeRecords'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($request->only('name', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === "admin") {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === "exchange") {
                return redirect()->route('exchange.dashboard');
            } elseif ($user->role === "assistant") {
                return redirect()->route('assistant.dashboard');
            }else{
                return back()->withErrors([
                    'user_name' => 'The provided credentials do not match our records.',
                ]);
            }
        }
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
    public function show(Auth $auth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auth $auth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auth $auth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auth $auth)
    {
        //
    }

    public function logout(Request $request){
        if (!auth()->check()) {
            return redirect()->route('auth.login');
        }
        elseif (auth()->check()) {
            Auth::logout();
            return redirect()->route('auth.login');
        }
    }
}
