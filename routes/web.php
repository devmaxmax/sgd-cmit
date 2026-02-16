<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FileController;

use App\Http\Controllers\ProyectosController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ModulosController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\AvancesController;

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
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/', [InicioController::class, 'index'])->name('inicio');

    //Proyectos
    Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos');
    Route::post('/proyectos', [ProyectosController::class, 'store'])->name('proyectos.store');
    Route::get('/proyectos/{id}', [ProyectosController::class, 'show'])->name('proyectos.show');
    Route::delete('/proyectos/eliminar/{id}', [ProyectosController::class, 'destroy'])->name('proyectos.destroy');
    Route::put('/proyectos/actualizar/{id}', [ProyectosController::class, 'update'])->name('proyectos.update');

    //Modulos
    Route::get('modulos', [ModulosController::class, 'index'])->name('modulos');
    Route::post('/modulos', [ModulosController::class, 'store'])->name('modulos.store');
    Route::get('/modulos/{id}', [ModulosController::class, 'show'])->name('modulos.show');
    Route::delete('/modulos/eliminar/{id}', [ModulosController::class, 'destroy'])->name('modulos.destroy');
    Route::put('/modulos/actualizar/{id}', [ModulosController::class, 'update'])->name('modulos.update');

    //Tickets
    Route::get('/tickets', [TicketsController::class, 'index'])->name('tickets');
    Route::post('/tickets', [TicketsController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{id}', [TicketsController::class, 'show'])->name('tickets.show');
    Route::delete('/tickets/eliminar/{id}', [TicketsController::class, 'destroy'])->name('tickets.destroy');
    Route::put('/tickets/actualizar/{id}', [TicketsController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/imagen/{id}', [TicketsController::class, 'destroyImagen'])->name('tickets.destroyImagen');
    Route::get('/tickets/ver/{id}', [TicketsController::class, 'verTicket'])->name('tickets.ver');

    Route::get('/avances', [AvancesController::class, 'index'])->name('avances');
    Route::post('/avances/{id}', [AvancesController::class, 'store'])->name('avances.store');
    Route::get('/tickets/{id}/avances', [AvancesController::class, 'obtenerAvances'])->name('avances.listado');
});

Route::get('/storage/assets/private/{filename}', [FileController::class, 'show'])
    ->where('filename', '.*')
    ->name('assets.private');

require __DIR__.'/auth.php';
