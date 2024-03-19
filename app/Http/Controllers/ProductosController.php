<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Marcas;
use App\Models\Modo;
use App\Models\precios_productos;
use App\Models\productos;
use App\Models\Tipo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->query('adminlteSearch');

        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->where('productos.estatus', 1)
            ->where('precios_productos.estatus', 1)
            ->where(function ($query) use ($busqueda) {
                $query->where('productos.nombre_comercial', 'LIKE', "%{$busqueda}%")
                    ->orWhere('marcas.nombre', 'LIKE', "%{$busqueda}%")
                    ->orWhere('modos.nombre', 'LIKE', "%{$busqueda}%");
            })
            ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'marcas.nombre as nombreMarca', 'modos.nombre as nombreModo', 'colors.nombre as nombreColor', 'modos.id as idModo', 'colors.id as idColor', 'marcas.id as idMarca', 'tipos.nombre as nombreTipo', 'tipos.id as idTipos', 'productos.fotografia', 'precios_productos.precio')
            ->orderBy('productos.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        $marcas = Marcas::orderBy('nombre')->get();
        $categorias = Tipo::orderBy('nombre')->get();
        $modos = Modo::orderBy('nombre')->get();
        $colores = Color::all();


        return view('Productos.productos', compact('productos', 'marcas', 'categorias', 'modos', 'colores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
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

            if ($request->hasFile('file')) {
                //esto guardamos nuetra imagen en storage/app/public/imagenProducto
                //no olvidar ejecutar el comando php artisan storage:link para crear un acceso directo
                // $file = $request->file('file')->store('public/imagenProductos');

                // Obtén el ID del usuario
                $userId = auth()->id();

                // Obtén la fecha y hora actual
                $now = Carbon::now()->format('YmdHis');

                // Genera un hash único
                $uniqueHash = Str::random(10);

                // Combina todo para generar un nombre de archivo único
                $fileName = "producto_{$userId}_{$now}_{$uniqueHash}.webp";

                $request->file('file')->move(public_path('imagenProductos'), $fileName);
                $url = asset('imagenProductos/' . $fileName);
                /**
                 * Genera la URL para un archivo almacenado en el almacenamiento.
                 *
                 * @param string $file La ruta del archivo.
                 * @return string La URL del archivo.
                 */
                // $url = Storage::url($file);
                // Ahora puedes usar $filename para guardar el nombre del archivo en tu base de datos
            }

            // Insertar en la tabla 'productos'
            $producto = productos::create([
                'nombre_comercial' => $request->txtnombre,
                'modelo' => $request->txtmodelo,
                'id_color' => $request->txtcolor,
                'id_tipo' => $request->txttipo,
                'id_modo' => $request->txtmodo,
                'id_marca' => $request->txtmarca,
                'descripcion' => $request->txtdescripcion,
                'fotografia' => $url,
                'estatus' => 1
            ]);

            // Insertar en la tabla 'precios_productos' usando el ID del producto
            $precioProducto = precios_productos::create([
                'id_producto' => $producto->id,
                'precio' => $request->txtprecio,
                //'descripcion' => $request->txtdescripcion,
                'estatus' => 1
            ]);

            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            return $th->getMessage();
            $precioProducto = 0;
        }
        if ($precioProducto == true) {
            session()->flash("correcto", "Producto registrado correctamente");
            return redirect()->route('productos.index');
        } else {
            session()->flash("incorrect", "Error al registrar");
            return redirect()->route('productos.index');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(productos $producto)
    {
        //conseguir el primer precio del producto que esten con estatus 1 y tengan el mismo id_producto
        $precioProducto = precios_productos::where('id_producto', $producto->id)
            ->where('estatus', 1)
            ->first();
        $datosProducto = productos::join('marcas', 'marcas.id', '=', 'productos.id_marca')
            ->join('tipos', 'tipos.id', '=', 'productos.id_tipo')
            ->join('modos', 'modos.id', '=', 'productos.id_modo')
            ->join('colors', 'colors.id', '=', 'productos.id_color')
            ->where('productos.estatus', 1)
            ->where('productos.id', $producto->id)
            ->select('marcas.id as idMarca', 'marcas.nombre as nombreMarca', 'tipos.id as idTipo', 'tipos.nombre as nombreTipo', 'modos.id as idModo', 'modos.nombre as nombreModo', 'colors.id as idColor', 'colors.nombre as nombreColor')
            ->first();

        $marcas = Marcas::orderBy('nombre')->get();
        $categorias = Tipo::orderBy('nombre')->get();
        $modos = Modo::orderBy('nombre')->get();
        $colores = Color::all();

        //enviar los dos datos a la vista
        return view('Productos.edit', compact('producto', 'precioProducto', 'marcas', 'categorias', 'datosProducto', 'colores', 'modos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, productos $producto)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            //Actualizar la tabla producto
            $productoActualizado = $producto->update([
                'nombre_comercial' => $request->txtnombre,
                'modelo' => $request->txtmodelo,
                'id_color' => $request->txtcolor,
                'id_marca' => $request->txtmarca,
                'id_tipo' => $request->txttipo,
                'id_modo' => $request->txtmodo,
                'descripcion' => $request->txtdescripcion,
                'estatus' => 1
            ]);

            //para validar que sea una imagen el archivo cargado
            $request->validate([
                'file' => 'image|max:2048',
            ]);


            // Verificar si se ha cargado una nueva fotografía
            if ($request->hasFile('file')) {
                // Guardar la nueva fotografía y obtener su nombre
                // $file = $request->file('file')->store('public/imagenProductos');
                // $url = Storage::url($file);
                // Agregar el nombre de la nueva fotografía a los datos del producto
                //  $datosProducto['fotografia'] = $file;
                // Actualizar el producto con la nueva fotografía
                // $producto->update(['fotografia' => $url]);

                // Obtén el ID del usuario
                $userId = auth()->id();

                // Obtén la fecha y hora actual
                $now = Carbon::now()->format('YmdHis');

                // Genera un hash único
                $uniqueHash = Str::random(10);

                // Combina todo para generar un nombre de archivo único
                $fileName = "producto_{$userId}_{$now}_{$uniqueHash}.webp";

                $request->file('file')->move(public_path('imagenProductos'), $fileName);
                $producto->update(['fotografia' =>  asset('imagenProductos/' . $fileName)]);
            }


            // Obetener el primer id del precio del producto que este relacionado donde el estatus sea 1
            $preciosProductoActualizado = precios_productos::where('id_producto', $producto->id)
                ->where('estatus', 1)
                ->first();

            // Obtén el precio actual
            $precioActual = $preciosProductoActualizado->precio;
            //si el precio actual es txt precio es diferente al que esta en el campo txtprecio actualizalo
            if ($precioActual != $request->txtprecio) {
                //primero cambiamos el estatus del producto estatus
                $preciosProductoActualizado->update([
                    'estatus' => 0
                ]);
                //ahora creamos el nuevo precio
                $preciosProductoNuevo =  precios_productos::create([
                    'id_producto' => $producto->id,
                    'precio' => $request->txtprecio,
                    //'descripcion' => $request->txtdescripcion,
                    'estatus' => 1
                ]);
            } else {
                // Si el precio no ha cambiado, no crees un nuevo registro
                $preciosProductoNuevo = true; // Para que la comprobación final siga funcionando
            }


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            /*si retorna un error de sql lo veremos en pantalla*/
            return $th->getMessage();
            //y que la ultima consulta sea false para mandar msj que salio mal la consulta
            $preciosProductoActualizado = false;
        }
        if ($productoActualizado && $preciosProductoActualizado && $preciosProductoNuevo) {
            session()->flash("correcto", "Producto actualizado correctamente");
            return redirect()->route('productos.index');
        } else {
            session()->flash("incorrect", "Error al actualizar el registro");
            return redirect()->route('productos.index');
        }
    }

    public function desactivar(productos $id)
    {
        DB::beginTransaction(); //El código DB::beginTransaction(); en Laravel se utiliza para iniciar una nueva transacción de base de datos.
        try {
            //en este caso es id por que en la ruta asi dije que se llamaria PUT productos/{id}/desactivar ............. productos.desactivar › ProductosController@desactivar
            //conseguir el primer precio del producto que esten con estatus 1 y tengan el mismo id_producto
            $precioProducto = precios_productos::where('id_producto', $id->id)
                ->where('estatus', 1)
                ->first();
            //estatus de producto actualizarlo a 0 y la fecha de eliminacion tambien
            $id->estatus = 0;
            $id->deleted_at = now();
            $productoDesactivado = $id->save();
            //estatus de precio_producto actualizarlo a 0 y la fecha de eliminacion tambien
            $precioProducto->estatus = 0;
            $precioProducto->deleted_at = now();
            $precioProductoDesactivado = $precioProducto->save();


            DB::commit(); //El código DB::commit(); en Laravel se utiliza para confirmar todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack(); //El código DB::rollBack(); en Laravel se utiliza para revertir todas las operaciones de la base de datos que se han realizado dentro de la transacción actual.
            //si retorna un error de sql lo veremos en pantalla
            return $th->getMessage();
            $precioProductoDesactivado = false;
        }
        if ($productoDesactivado && $precioProductoDesactivado) {
            session()->flash("correcto", "Producto eliminado correctamente");
            return redirect()->route('productos.index');
        } else {
            session()->flash("incorrect", "Error al eliminar el registro");
            return redirect()->route('productos.index');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(productos $producto)
    {
    }
}
