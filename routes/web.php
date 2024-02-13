<?php

use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProfileController;
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

Route::get('/Inicio', [PrincipalController::class, 'index'])->name('inicio.index');

// lista de productos
Route::get('/Productos', [ProductosController::class, 'index'])->name('productos.index');
//crear productos
Route::post('/registrar_producto', [ProductosController::class, 'create'])->name('productos.create');

//eliminar productos
Route::post('/eliminar_producto', [ProductosController::class, 'destroy'])->name('productos.destroy');
require __DIR__ . '/auth.php';
