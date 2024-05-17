<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validated = $request->validateWithBag('updatePassword', [
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'min:8', 'max:12', 'lowercase', Password::defaults(), 'confirmed'],
            ], [
                'current_password.current_password' => 'No coincide con la contraseña actual',
                'current_password.required' => 'Contraseña actual es requerida',
                'password.required' => 'La nueva contraseña es requerida',
                'password.min' => 'Se requiere minimo 8 caracteres',
                'password.max' => 'Maximo 12 caracteres',
                'password.lowercase' => 'La contraseña debe ser minuscula',
                'password.confirmed' => 'No coincide la Nueva contraseña con Confirmar contraseña'
            ]);

            $request->user()->update([
                'password' => Hash::make($validated['password']),
            ]);
            DB::commit();

            session()->flash("correcto", "Usuario actualizado con éxito.");
            return back()->with('status', 'password-updated');
        } catch (ValidationException $e) {
            session()->flash("incorrect", "Hubo un error al actualizar el usuario.");
            throw $e; // Laravel manejará esta excepción
        } catch (\Throwable $th) {
            DB::rollback();
            // Redirigir al usuario a una página después de la actualización
            session()->flash("incorrect", "Hubo un error al actualizar el usuario.");
            return back()->with('status', 'password-updated');
        }
    }
}
