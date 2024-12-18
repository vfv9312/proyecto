<?php

use App\Http\Controllers\CancelacionesController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DescuentosController;
use App\Http\Controllers\DireccionesClientesController;
use App\Http\Controllers\DireccionesController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClaveEliminacionController;
use App\Http\Controllers\EliminacionController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\EnviarCorreoController;
use App\Http\Controllers\InfoTicketsController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\OrdenEntregaController;
use App\Http\Controllers\OrdenRecoleccionController;
use App\Http\Controllers\ordenServicioController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestablecerController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TiempoAproximadoController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\WhatsAppController;
use App\Http\Controllers\ColoniasController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\TiposController;
use App\Mail\correoMailable;
use App\Models\Info_tickets;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;
use PHPUnit\Framework\Attributes\Ticket;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\select;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->group(function () {
});
Route::get('/', function () {
    return view('welcome');
});


Route::get('/clear-cache', function () {
    if (Auth::check()) {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return 'Caché limpiada';
    }

    return redirect('login');
})->middleware('auth');

//generar pdf
Route::get('orden_entrega_pdf/{id}/generarpdf', [OrdenEntregaController::class, 'generarPdf'])->name('generarpdf.ordenentrega');
Route::get('orden_entrega_pdf/{id}/generarpdf2', [OrdenRecoleccionController::class, 'generarPdf2'])->name('generarpdf2.ordenServicio2');
Route::get('orden_servicio_pdf/{id}/generarpdf', [ordenServicioController::class, 'generarPdf'])->name('generarpdf.ordenservicio');


Route::get('/dashboard', function () {
    return view('Principal.inicio');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //Todo el proceso de orden entrega
    Route::resource('inicio', PrincipalController::class)->middleware(['verified']); //aqui se muestra dos iconos si quiere una orden de servicio o una orden de entrega
    Route::resource('orden_entrega', OrdenEntregaController::class)->middleware(['verified']); //index: muestra la vista con todos los datos para hacer una orden de entrega, show: muestra una vista previa
    Route::get('orden_entrega/{id}/vistaprevia', [OrdenEntregaController::class, 'VistaPrevioOrdenEntrega'])->name('ordenEntrega.vistaGeneral')->middleware(['verified']); //muestra el contenido
    Route::get('ordenes/{idproducto}/{idservicio}', [OrdenEntregaController::class, 'vistaPreviaTickets'])->name('orden_recoleccion.vistaPreviaTickets')->middleware(['verified']); //muestra el contenido
    Route::get('/detallesproducto', [OrdenEntregaController::class, 'detallesproducto'])->name('orden_recoleccion.detallesproducto');
    Route::post('/guardarproducto', [OrdenEntregaController::class, 'guardarProducto'])->name('ordenEntrega.guardarProducto');


    Route::post('/cambiarProductoRecarga', [OrdenEntregaController::class, 'cambiarProductoRecarga'])->name('product.Recarga');

    //rutas para restablecer informacion eliminada
    Route::prefix('restablecer')->group(function () {
        Route::get('/', [RestablecerController::class, 'index'])->name('Restablecer.index')->middleware(['verified', 'rol']);
        Route::get('cancelaciones', [RestablecerController::class, 'cancelaciones'])->name('Restablecer.cancelaciones')->middleware(['verified', 'rol']);
        Route::get('clientes', [RestablecerController::class, 'clientes'])->name('Restablecer.clientes')->middleware(['verified', 'rol']);
        Route::get('servicios', [RestablecerController::class, 'servicios'])->name('Restablecer.servicios')->middleware(['verified', 'rol']);
        Route::get('productos', [RestablecerController::class, 'productos'])->name('Restablecer.productos')->middleware(['verified', 'rol']);
        Route::get('marcas', [RestablecerController::class, 'marcas'])->name('Restablecer.marcas')->middleware(['verified', 'rol']);
        Route::get('categorias', [RestablecerController::class, 'categorias'])->name('Restablecer.categorias')->middleware(['verified', 'rol']);
        Route::put('cancelaciones/{id}', [RestablecerController::class, 'actualizarCancelacion'])->name('Restablecer.actualizarcancelacion')->middleware(['verified', 'rol']);
        Route::put('clientes/{id}', [RestablecerController::class, 'actualizarCliente'])->name('Restablecer.actualizarcliente')->middleware(['verified', 'rol']);
        Route::put('productos/{id}', [RestablecerController::class, 'actualizarProducto'])->name('Restablecer.actualizarProducto')->middleware(['verified', 'rol']);
        Route::put('servicios/{id}', [RestablecerController::class, 'actualizarServicio'])->name('Restablecer.actualizarServicio')->middleware(['verified', 'rol']);
        Route::put('marcas/{id}', [RestablecerController::class, 'actualizarMarcas'])->name('Restablecer.actualizarMarcas')->middleware(['verified', 'rol']);
        Route::put('categorias/{id}', [RestablecerController::class, 'actualizarCategorias'])->name('Restablecer.actualizarCategorias')->middleware(['verified', 'rol']);
    });


    Route::resource('TiempoAproximado', TiempoAproximadoController::class)->middleware(['verified']);
    Route::get('enviar-correo/{id}/correo', [EnviarCorreoController::class, 'enviarCorreos'])->name('Correo.enviar');
    Route::get('enviar-correo/{error}/{id}/estatus', [EnviarCorreoController::class, 'vistaPrevia'])->name('Correo.vistaPrevia');
    Route::get('enviar-mensaje/{id}/{telefono}/whatsapp', [WhatsAppController::class, 'enviarMensaje'])->name('WhatsApp.enviar');

    //estatus de las entregas
    Route::get('/orden_recoleccion/generarexcel', [OrdenRecoleccionController::class, 'generarExcel'])->name('ordenentrega.generarExcel'); //hay que ponerlo antes del resource para que jale
    Route::resource('orden_recoleccion', OrdenRecoleccionController::class)->middleware(['verified']);
    Route::get('/orden_recoleccion/{id}/vistacancelar', [OrdenRecoleccionController::class, 'vistacancelar'])->name('orden_recoleccion.vistacancelar')->middleware(['verified']);
    Route::put('/orden_recoleccion/{id}/cancelar', [OrdenRecoleccionController::class, 'cancelar'])->name('orden_recoleccion.cancelar')->middleware(['verified']);

    // servicios
    Route::resource('orden_servicio', ordenServicioController::class)->middleware(['verified']);
    Route::get('orden_serviciof/{id}/vistaPrevia', [ordenServicioController::class, 'vistaPrevia'])->name('vistaPrevia.ordenservicio');
    Route::get('/orden-servicio/{id}/vista-general', [OrdenServicioController::class, 'vistaGeneral'])->name('ordenServicio.vistaGeneral');


    //OrdenServicio
    Route::get('/orden-servicio/{id}/vistaPreviaordenservicio',[ordenServicioController::class, 'vistaOrdenServicio'])->name('ordenServicio.vistaOrdenServicio');
    Route::get('/orden-servicio/{id}/vista-general-ordenservicio',[OrdenServicioController::class,'vistaGeneralOrdenServicio'])->name('ordenServicio.vistaGeneralOrdenServicio');

    Route::resource('cancelar', CancelacionesController::class)->middleware(['verified']);
    Route::put('/cancelar/{id}/desactivar', [CancelacionesController::class, 'desactivar'])->name('cancelar.desactivar')->middleware(['verified']);

    Route::resource('descuentos', DescuentosController::class)->middleware(['verified', 'rol']);
    Route::put('/descuentos/{descuento}/desactivar', [DescuentosController::class, 'desactivar'])->name('descuentos.desactivar')->middleware(['verified']);


    // lista de las rotuas de producto productos
    Route::resource('productos', ProductosController::class)->middleware(['verified']);
    Route::put('/productos/{id}/desactivar', [ProductosController::class, 'desactivar'])->name('productos.desactivar')->middleware(['verified']);


    //Lista de las rutas de servicios
    Route::resource('servicios', ServiciosController::class)->middleware(['verified']);
    Route::put('/servicios/{id}/desactivar', [ServiciosController::class, 'desactivar'])->name('servicios.desactivar')->middleware(['verified']);


    //Lista de las rutas de empleados
    Route::resource('empleados', EmpleadosController::class)->middleware(['verified', 'rol']);
    Route::put('/empleados/{id}/desactivar', [EmpleadosController::class, 'desactivar'])->name('empleados.desactivar')->middleware(['verified']);

    //Lista de clientes
    Route::resource('clientes', ClientesController::class)->middleware(['verified']);
    Route::put('/clientes/{id}/desactivar', [ClientesController::class, 'desactivar'])->name('clientes.desactivar')->middleware(['verified']);


    //Direccion del ticket
    Route::resource('infoticket', InfoTicketsController::class)->middleware(['verified', 'rol']);

    //Categorias
    Route::resource('categorias', CategoriaController::class)->middleware(['verified']);
    Route::put('/categorias/{id}/desactivar', [CategoriaController::class, 'desactivar'])->name('categorias.desactivar')->middleware(['verified']);

    //Marcas
    Route::resource('marcas', MarcasController::class)->middleware(['verified']);
    Route::put('/marcas/{id}/desactivar', [MarcasController::class, 'desactivar'])->name('marcas.desactivar')->middleware(['verified']);


    //Direcciones
    Route::resource('direcciones', DireccionesClientesController::class)->middleware(['verified']);

    Route::resource('eliminacion', ClaveEliminacionController::class)->middleware(['verified', 'rol']);

    Route::resource('ordeneliminacion', EliminacionController::class)->middleware(['verified']);

    Route::resource('ventas', VentasController::class)->middleware(['verified']);
    //Lista de clientes
    //Route::get('/venta', [VentasController::class, 'index'])->name('ventas.index');
    
    //Colonias
    Route::resource('colonias', ColoniasController::class)->middleware(['verified', 'rol']);

    Route::resource('metodopago', MetodoPagoController::class)->middleware(['verified', 'rol']);
    Route::put('/metodopago/{id}/desactivar', [MetodoPagoController::class, 'desactivar'])->name('metodopago.desactivar')->middleware(['verified']);

    //Tipos
    Route::resource('tipos', TiposController::class)->middleware(['verified', 'rol']);
});
require __DIR__ . '/auth.php';
