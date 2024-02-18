<?php

namespace App\Http\Controllers;

use App\Models\empleados;
use App\Models\personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $empleados = empleados::join('personas', 'personas.id', '=', 'empleados.id_persona')
            ->where('empleados.estatus', 1)
            ->where('personas.estatus', 1)
            ->select('personas.nombre', 'personas.apellido', 'personas.telefono', 'personas.email', 'personas.fecha_nacimiento', 'empleados.rol_empleado', 'empleados.fotografia')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        return view('empleados.index', compact('empleados'));
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
            $empleado = personas::create([
                'nombre' => $request->txtnombre,
                'apellido' => $request->txtapellido,
                'telefono' => $request->txttelefono,
                'email' => $request->txtemail,
                'estatus' => 1,

            ]);
        } catch (\Throwable $th) {
            //throw $th;
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
    public function edit(empleados $empleados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, empleados $empleados)
    {
        //
    }

    public function desactivar(Request $request, empleados $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(empleados $empleados)
    {
        //
    }
}
