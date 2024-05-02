<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:200',
            'password' => 'required|string|max:200',
        ]);

        if (Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {

            return redirect()->route('inicio.index');
        }

        return redirect()->route('login');
    }
}
