<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Roles::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'rol' => 'required|integer|exists:roles,id',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => ucwords(strtolower($request->name)),
                'email' => strtolower($request->email),
                'id_rol' => $request->rol,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            // Auth::login($user);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('empleados.index');
        }

        session()->flash("correcto", "Producto registrado correctamente");
        return redirect()->route('empleados.index');
    }
}
