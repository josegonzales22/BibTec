<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LibrosController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){return Redirect::to('login');});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/libros', [LibrosController::class, 'index'])->name('libro.index')->middleware('auth');
Route::post('/libros', [LibrosController::class, 'index'])->name('libro.index')->middleware('auth');
Route::get('/libros/nuevo', [LibrosController::class, 'registerStore'])->name('libro.new')->middleware('auth');
Route::post('/libros/nuevo', [LibrosController::class, 'register'])->name('libro.new')->middleware('auth');
Route::get('/libros/edit/{libro}', [LibrosController::class, 'edit'])->name('libro.edit')->middleware('auth');
Route::put('/libros/{libro}', [LibrosController::class, 'update'])->name('libro.update');
Route::delete('/libros/delete/{id}', [LibrosController::class, 'delete'])->name('libro.delete');

Route::get('/autor', [AutorController::class, 'index'])->name('autor.index')->middleware('auth');
Route::post('/autor', [AutorController::class, 'index'])->name('autor.index')->middleware('auth');
Route::put('/autor', [AutorController::class, 'update'])->name('autor.update');
Route::delete('/autor/delete/{id}', [AutorController::class, 'delete'])->name('autor.delete');

Route::view('/prestamos', 'trabajador.prestamo.index')->name('prestamo.index')->middleware('auth');

Route::view('/devoluciones', 'trabajador.devolucion.index')->name('devolucion.index')->middleware('auth');

Route::view('/trabajador', 'trabajador.trabajador.index')->name('trabajador.index')->middleware('auth');

Route::view('/estudiante', 'trabajador.estudiante.index')->name('estudiante.index')->middleware('auth');

Route::view('/historial', 'trabajador.historial.index')->name('historial.index')->middleware('auth');
