<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EmpleadosController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\VentasController;
use App\Models\servicios;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
    $datos = DB::select('SELECT * FROM canacotu_tuxtla.productos;');
    return view('dashboard')->with("datos", $datos);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('inicio', PrincipalController::class)->middleware(['auth', 'verified']);
//Route::get('/Inicio', [PrincipalController::class, 'index'])->name('inicio.index');

// lista de productos
//Route::get('/Productos', [ProductosController::class, 'index'])->name('productos.index');
//crear productos
//Route::post('/registrar_producto', [ProductosController::class, 'create'])->name('productos.create');
//editar producto
//Route::('/editar_producto', [ProductosController::class, 'edit'])->name('productos.edit');
//eliminar productos
//Route::post('/eliminar_producto', [ProductosController::class, 'destroy'])->name('productos.destroy');
// productos
Route::resource('productos', ProductosController::class)->middleware(['auth', 'verified']);
Route::put('/productos/{id}/desactivar', [ProductosController::class, 'desactivar'])->name('productos.desactivar')->middleware(['auth', 'verified']);


//servicios
Route::resource('servicios', ServiciosController::class)->middleware(['auth', 'verified']);
//Lista de servicios
//Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
//Crear servicios
//Route::post('/registrar_servicios', [ServiciosController::class, 'create'])->name('servicios.create');

//empleados
Route::resource('empleados', EmpleadosController::class)->middleware(['auth', 'verified']);

//Lista de empleados
//Route::get('/empleados', [EmpleadosController::class, 'index'])->name('empleados.index');

Route::resource('clientes', ClientesController::class)->middleware(['auth', 'verified']);
//Lista de clientes
//Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes.index');

Route::resource('ventas', VentasController::class)->middleware(['auth', 'verified']);
//Lista de clientes
//Route::get('/venta', [VentasController::class, 'index'])->name('ventas.index');
require __DIR__ . '/auth.php';
