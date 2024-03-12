<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\DireccionesClientesController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\OrdenEntregaController;
use App\Http\Controllers\OrdenRecoleccionController;
use App\Http\Controllers\ordenServicioController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\VentasController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Stmt\Return_;

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

Route::get('/menu', function () {
    return view('menu');
});


Route::get('/dashboard', function () {
    return view('Principal.inicio');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Todo el proceso de venta
Route::resource('inicio', PrincipalController::class)->middleware(['auth', 'verified']);
Route::resource('orden_entrega', OrdenEntregaController::class)->middleware(['auth', 'verified']);
//generar pdf
Route::get('orden_entrega_pdf/{id}/generarpdf', [OrdenEntregaController::class, 'generarPdf'])->name('generarpdf.ordenentrega');
Route::post('registro', [PrincipalController::class, 'registro'])->name('inicio.registro')->middleware(['auth', 'verified']);

//estatus de las entregas
Route::resource('orden_recoleccion', OrdenRecoleccionController::class)->middleware(['auth', 'verified']);
Route::get('/orden_recoleccion/{id}/vistacancelar', [OrdenRecoleccionController::class, 'vistacancelar'])->name('orden_recoleccion.vistacancelar')->middleware(['auth', 'verified']);
Route::put('/orden_recoleccion/{id}/cancelar', [OrdenRecoleccionController::class, 'cancelar'])->name('orden_recoleccion.cancelar')->middleware(['auth', 'verified']);



Route::resource('orden_servicio', ordenServicioController::class)->middleware(['auth', 'verified']);
Route::post('orden_servicio_pdf', [ordenServicioController::class, 'generarPdf'])->name('generarpdf.ordenservicio');

//checar si sirve
Route::post('guardarProductoVenta', [PrincipalController::class, 'guardarProductoVenta'])->name('inicio.guardarProductoVenta')->middleware(['auth', 'verified']);




// lista de las rotuas de producto productos
Route::resource('productos', ProductosController::class)->middleware(['auth', 'verified']);
Route::put('/productos/{id}/desactivar', [ProductosController::class, 'desactivar'])->name('productos.desactivar')->middleware(['auth', 'verified']);


//Lista de las rutas de servicios
Route::resource('servicios', ServiciosController::class)->middleware(['auth', 'verified']);

//Lista de las rutas de empleados
Route::resource('empleados', EmpleadosController::class)->middleware(['auth', 'verified']);
Route::put('/empleados/{id}/desactivar', [EmpleadosController::class, 'desactivar'])->name('empleados.desactivar')->middleware(['auth', 'verified']);

//Lista de clientes
Route::resource('clientes', ClientesController::class)->middleware(['auth', 'verified']);
Route::put('/clientes/{id}/desactivar', [ClientesController::class, 'desactivar'])->name('clientes.desactivar')->middleware(['auth', 'verified']);


//Lista de direcciones
Route::resource('direcciones', DireccionesClientesController::class)->middleware(['auth', 'verified']);

//Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');

Route::resource('ventas', VentasController::class)->middleware(['auth', 'verified']);
//Lista de clientes
//Route::get('/venta', [VentasController::class, 'index'])->name('ventas.index');
require __DIR__ . '/auth.php';
