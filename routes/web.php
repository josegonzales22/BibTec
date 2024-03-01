<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){return Redirect::to('login');});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::view('/dashboard', 'trabajador.dashboard')->name('dashboard')->middleware('auth');

Route::view('/libros', 'trabajador.libro.index')->name('libro.index')->middleware('auth');

Route::view('/prestamos', 'trabajador.prestamo.index')->name('prestamo.index')->middleware('auth');

Route::view('/devoluciones', 'trabajador.devolucion.index')->name('devolucion.index')->middleware('auth');

Route::view('/trabajador', 'trabajador.trabajador.index')->name('trabajador.index')->middleware('auth');

Route::view('/estudiante', 'trabajador.estudiante.index')->name('estudiante.index')->middleware('auth');

Route::view('/historial', 'trabajador.historial.index')->name('historial.index')->middleware('auth');
