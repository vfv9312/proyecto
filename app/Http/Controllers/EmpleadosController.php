<?php

namespace App\Http\Controllers;

use App\Models\empleados;
use App\Models\personas;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
                    ->orWhere('users.name', 'LIKE', "%{$busqueda}%")
                    ->orWhere('roles.nombre', 'LIKE', "%{$busqueda}%");
            })
            ->select('users.id', 'users.name as nombre', 'users.email', 'users.id_rol', 'roles.nombre as nombreRol')
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
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            //para validar que sea una imagen el archivo cargado
            $request->validate([
                'file' => 'image|max:2048',
            ]);
            //Guardar imagen en storage
            if ($request->hasFile('file')) {
                //esto guardamos nuetra imagen en storage/app/public/imagenEmpleado
                //no olvidar ejecutar el comando php artisan storage:link para crear un acceso directo
                $file = $request->file('file')->store('public/imagenEmpleado');
                /**
                 * Genera la URL para un archivo almacenado en el almacenamiento.
                 *
                 * @param string $file La ruta del archivo.
                 * @return string La URL del archivo.
                 */
                $url = Storage::url($file);
                // Ahora puedes usar $filename para guardar el nombre del archivo en tu base de datos
            }
            // Insertar en la tabla 'personas'
            $persona = personas::create([
                'nombre' => $request->txtnombre,
                'apellido' => $request->txtapellido,
                'telefono' => $request->txttelefono,
                'email' => $request->txtemail,
                'fecha_nacimiento' => $request->txtfecha_nacimiento,
                'estatus' => 1,
            ]);
            // Insertar en la tabla 'empleados' usando el ID de persona
            $empleado = empleados::create([
                'id_persona' => $persona->id,
                'id_rol' => $request->txtrol,
                'comentario' => 'ninguno',
                'fotografia' => null, //cambiar por $url si ya quiere foto
                'estatus' => 1
            ]);
            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            /*si retorna un error de sql lo veremos en pantalla*/
            return $th->getMessage();
            //y que la ultima consulta sea false para mandar msj que salio mal la consulta
            $empleado = false;
        }
        if ($empleado && $persona) {
            session()->flash("correcto", "Producto registrado correctamente");
            return redirect()->route('empleados.index');
        } else {
            session()->flash("incorrect", "Error al registrar");
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
            $contraseña = $request->input('password');



            if ($contraseña === null) {
                $empleadoActualizado = $empleado->update([
                    'name' => $nombre,
                    'id_rol' => $rol,
                    'email' => $email,
                ]);
            } else {
                $empleadoActualizado = $empleado->update([
                    'name' => $nombre,
                    'id_rol' => $rol,
                    'email' => $email,
                    'password' => Hash::make($request->password),
                ]);
            }


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
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
