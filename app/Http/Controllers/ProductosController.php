<?php

namespace App\Http\Controllers;

use App\Models\precios_productos;
use App\Models\productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /*
        $datos = DB::select('SELECT p.nombre_comercial, p.modelo, p.color, p.marca, p.fotografia, pp.precio
        FROM canacotu_tuxtla.productos AS p
        INNER JOIN canacotu_tuxtla.precios_productos AS pp
        ON p.id = pp.id_producto
        WHERE p.estatus = 1;');*/

        $productos = productos::join('precios_productos', 'productos.id', '=', 'precios_productos.id_producto')
            ->where('productos.estatus', 1)
            ->where('precios_productos.estatus', 1)
            ->select('productos.id', 'productos.nombre_comercial', 'productos.modelo', 'productos.color', 'productos.marca', 'productos.fotografia', 'precios_productos.precio')
            ->orderBy('productos.updated_at', 'desc')
            ->paginate(5); // Mueve paginate() aquí para que funcione correctamente

        return view('Productos.productos', compact('productos'));
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
                $file = $request->file('file')->store('public/imagenProductos');
                /**
                 * Genera la URL para un archivo almacenado en el almacenamiento.
                 *
                 * @param string $file La ruta del archivo.
                 * @return string La URL del archivo.
                 */
                $url = Storage::url($file);
                // Ahora puedes usar $filename para guardar el nombre del archivo en tu base de datos
            }

            // Insertar en la tabla 'productos'
            $producto = productos::create([
                'nombre_comercial' => $request->txtnombre,
                'modelo' => $request->txtmodelo,
                'color' => $request->txtcolor,
                'marca' => $request->txtmarca,
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
        //enviar los dos datos a la vista
        return view('Productos.edit', compact('producto', 'precioProducto'));
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
                'color' => $request->txtcolor,
                'marca' => $request->txtmarca,
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
                $file = $request->file('file')->store('public/imagenProductos');

                $url = Storage::url($file);

                // Agregar el nombre de la nueva fotografía a los datos del producto
                $datosProducto['fotografia'] = $file;

                // Actualizar el producto con la nueva fotografía
                $producto->update(['fotografia' => $url]);
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
