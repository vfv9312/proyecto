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
            'username' => 'required|string|max:200|lowercase',
            'password' => 'required|string|min:8|max:12|lowercase',
        ], [
            'username.required' => 'El campo nombre de usuario es obligatorio.',
            'username.lowercase' => 'El nombre de usuario debe estar en minúsculas.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 12 caracteres.',
            'password.lowercase' => 'La contraseña debe estar en minúsculas.',
        ]);

        if (Auth::attempt($request->only('username', 'password'), $request->boolean('remember'))) {

            return redirect()->route('inicio.index');
        }

        return redirect()->route('login')->withErrors(['message' => 'Credenciales inválidas. Por favor, inténtalo de nuevo.']);
    }
}
