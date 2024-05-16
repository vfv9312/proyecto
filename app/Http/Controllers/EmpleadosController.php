<?php

namespace App\Http\Controllers;

use App\Models\empleados;
use App\Models\personas;
use App\Models\Roles;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $busqueda = $request->query('adminlteSearch');
        //
        $empleados = User::join('roles', 'roles.id', '=', 'users.id_rol')
            ->where(function ($query) use ($busqueda) {
                $query->where('users.email', 'LIKE', "%{$busqueda}%")
                    ->orWhere('users.username', 'LIKE', "%{$busqueda}")
                    ->orWhere('users.name', 'LIKE', "%{$busqueda}%")
                    ->orWhere('roles.nombre', 'LIKE', "%{$busqueda}%");
            })
            ->select('users.id', 'users.name as nombre', 'users.email', 'users.id_rol', 'roles.nombre as nombreRol', 'users.username')
            ->orderBy('users.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        $roles = Roles::all();

        return view('empleados.index', compact('empleados', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {


            //return $request;
            $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|lowercase|max:255|unique:users,username',
                'password' => ['required', 'confirmed', 'string', 'max:12', 'min:8', 'lowercase'],
                'rol' => 'required|integer|exists:roles,id',
            ], [
                'name.required' => 'El campo nombre es obligatorio.',
                'username.required' => 'El campo nombre de usuario es obligatorio.',
                'username.lowercase' => 'El nombre de usuario debe estar en minúsculas.',
                'username.unique' => 'El nombre de usuario ya está en uso.',
                'password.required' => 'El campo contraseña es obligatorio.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.max' => 'La contraseña no puede tener más de 12 caracteres.',
                'password.lowercase' => 'La contraseña debe ser minuscula',
                'rol.required' => 'El campo rol es obligatorio.',
                'rol.integer' => 'El rol debe ser un número entero.',
                'rol.exists' => 'El rol seleccionado no existe.',
            ]);

            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => 'empleado' . time() . '@test.com',
                'id_rol' => $request->rol,
                'password' => Hash::make($request->password),
                'email_verified_at' => Carbon::now(),
            ]);

            //event(new Registered($user));

            //Auth::login($user);

            DB::commit();
            session()->flash("correcto", "Guardado correctamente");
            return redirect()->route('empleados.index');
        } catch (ValidationException $e) {
            session()->flash("incorrect", "Hubo un error al crear el usuario.");
            throw $e; // Laravel manejará esta excepción

        } catch (\Throwable $th) {
            DB::rollback();
            // Redirigir al usuario a una página después de la actualización
            session()->flash("incorrect", "Hubo un error al crear el usuario.");
            return redirect()->route('empleados.index');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(empleados $empleados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $empleado)
    {

        $persona = $empleado;
        $rol = Roles::join('users', 'users.id', '=', 'users.id_rol')
            ->where('roles.id', $empleado->id_rol)
            ->first();
        $roles = Roles::all();


        //enviar los dos datos a la vista
        return view('empleados.edit', compact('empleado', 'persona', 'rol', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $empleado)
    {

        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            $nombre = ucwords(strtolower($request->input('txtnombre')));
            $rol = $request->input('txtrol');
            $email = $request->input('email');
            $contrasena =  is_null($request->password) ? $empleado->password : Hash::make($request->password);

            $empleadoActualizado = $empleado->update([
                'name' => $nombre,
                'id_rol' => $rol,
                // 'email' => $empleado->email,
                'password' => $contrasena,
            ]);

            // if ($contraseña === null) {
            //     $empleadoActualizado = $empleado->update([
            //         'name' => $nombre,
            //         'id_rol' => $rol,
            //         'email' => $email,
            //     ]);
            // } else {
            //     $empleadoActualizado = $empleado->update([
            //         'name' => $nombre,
            //         'id_rol' => $rol,
            //         'email' => $email,
            //         'password' => Hash::make($request->password),
            //     ]);
            // }


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            info($th->getMessage());
            /*si retorna un error de sql lo veremos en pantalla*/
            //return $th->getMessage();
            //y que la ultima consulta sea false para mandar msj que salio mal la consulta
            session()->flash("incorrect", "Error al actualizar el registro");
            return redirect()->route('empleados.index');
        }
        session()->flash("correcto", "Producto actualizado correctamente");
        return redirect()->route('empleados.index');
    }

    public function desactivar(Request $request, empleados $id)
    {
        /*  DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {

            $persona = personas::where('id', $id->id_persona)
                ->where('estatus', 1)
                ->first();

            // Actualizar la tabla empleado
            $id->estatus = 0;
            $id->deleted_at = now();
            $empleadoDesactivado = $id->save();

            // Actualizar la tabla personas
            $persona->estatus = 0;
            $persona->deleted_at = now();
            $personaDesactivada = $persona->save();




            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            return $th->getMessage();
            $personaDesactivada = false;
        }
        if ($empleadoDesactivado && $personaDesactivada) {
            session()->flash("correcto", "Producto eliminado correctamente");
            return redirect()->route('empleados.index');
        } else {
            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('empleados.index');
        }*/
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $empleado)
    {
        $empleado->delete();

        session()->flash("correcto", "Empleado eliminado correctamente");
        return redirect()->route('empleados.index');
    }
}
