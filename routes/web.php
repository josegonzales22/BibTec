<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\QrCodeGenerator;
use App\Http\Controllers\QrController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsuarioController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){return Redirect::to('login');});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/libros', [LibrosController::class, 'index'])->name('libro.index')->middleware('can:isAdminOrTrabajador');
Route::post('/libros', [LibrosController::class, 'index'])->name('libro.index')->middleware('can:isAdminOrTrabajador');
Route::get('/libros/nuevo', [LibrosController::class, 'registerStore'])->name('libro.new')->middleware('can:isAdminOrTrabajador');
Route::post('/libros/nuevo', [LibrosController::class, 'register'])->name('libro.new')->middleware('can:isAdminOrTrabajador');
Route::get('/libros/edit/{libro}', [LibrosController::class, 'edit'])->name('libro.edit')->middleware('can:isAdminOrTrabajador');
Route::put('/libros/{libro}', [LibrosController::class, 'update'])->name('libro.update')->middleware('can:isAdminOrTrabajador');
Route::delete('/libros/delete/{id}', [LibrosController::class, 'delete'])->name('libro.delete')->middleware('can:isAdminOrTrabajador');
Route::post('/libros/plantilla', [LibrosController::class, 'addToPlantilla'])->name('libro.plantilla');

Route::post('/libros/baul/{user}/{book}',[LibrosController::class, 'addToBaul'])->name('libro.addToBaul');
Route::post('/libros/dbaul/{user}/{book}',[LibrosController::class, 'deleteFromBaul'])->name('libro.deleteFromBaul');

Route::get('/autor', [AutorController::class, 'index'])->name('autor.index')->middleware('can:isAdminOrTrabajador');
Route::post('/autor', [AutorController::class, 'index'])->name('autor.index')->middleware('can:isAdminOrTrabajador');
Route::put('/autor', [AutorController::class, 'update'])->name('autor.update')->middleware('can:isAdminOrTrabajador');
Route::delete('/autor/delete/{id}', [AutorController::class, 'delete'])->name('autor.delete')->middleware('can:isAdminOrTrabajador');

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuario.index')->middleware('can:isAdmin');
Route::post('/usuarios', [UsuarioController::class, 'index'])->name('usuario.index')->middleware('can:isAdmin');
Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuario.create')->middleware('can:isAdmin');
Route::post('/usuarios/guardar',[UsuarioController::class, 'store'])->name('usuario.save')->middleware('can:isAdmin');
Route::get('/usuarios/roles', [RolesController::class, 'index'])->name('rol.index')->middleware('can:isAdmin');
Route::get('/usuarios/roles/crear', [RolesController::class, 'create'])->name('rol.create')->middleware('can:isAdmin');
Route::post('/usuarios/roles/new', [RolesController::class, 'store'])->name('rol.store')->middleware('can:isAdmin');
Route::get('/usuarios/roles/{rol}', [RolesController::class, 'show'])->name('rol.show')->middleware('can:isAdmin');
Route::get('/usuarios/roles/{rol}/edit', [RolesController::class, 'edit'])->name('rol.edit')->middleware('can:isAdmin');
Route::put('/usuarios/roles/{rol}', [RolesController::class, 'update'])->name('rol.update')->middleware('can:isAdmin');
Route::delete('/usuarios/roles/delete', [RolesController::class, 'destroy'])->name('rol.delete')->middleware('can:isAdmin');
Route::get('/usuarios/{user}', [UsuarioController::class, 'edit'])->name('usuario.edit')->middleware('can:isAdmin');
Route::put('/usuarios/update/{user}', [UsuarioController::class, 'update'])->name('usuario.update')->middleware('can:isAdmin');
Route::delete('/usuarios/delete/{user}', [UsuarioController::class, 'destroy'])->name('usuario.delete')->middleware('can:isAdmin');

Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamo.index')->middleware('can:isAdminOrTrabajadorOrProfesor');
Route::post('/prestamos', [PrestamoController::class, 'index'])->name('prestamo.index')->middleware('can:isAdminOrTrabajadorOrProfesor');
Route::get('/prestamos/baul',[PrestamoController::class, 'viewBaul'])->name('prestamo.baul');
Route::post('/prestamos/baul/finalizar', [PrestamoController::class, 'store'])->name('prestamo.store');
Route::post('/prestamos/dbaul/{user}/{book}',[PrestamoController::class,'deleteFromBaul'])->name('prestamo.deleteFromBaul');
Route::post('prestamos/atbd/{prestamo}', [PrestamoController::class, 'movePrestamoToBaul'])->name('prestamo.bauld');
Route::delete('/prestamos/dbaul/remove/{prestamo}', [PrestamoController::class, 'removePrestamoFromBaul'])->name('bauld.remove');
Route::get('/prestamos/plantillas',[PrestamoController::class, 'viewListPlantillas'])->name('plantilla.index');
Route::post('/prestamos/plantillas/save', [PrestamoController::class, 'savePlantilla'])->name('plantilla.save');
Route::get('/prestamos/plantillas/view/{plantilla}', [PrestamoController::class, 'viewPlantilla'])->name('plantilla.view');
Route::get('/prestamos/plantillas/edit/{plantilla}', [PrestamoController::class, 'editPlantilla'])->name('plantilla.edit');
Route::put('/prestamos/plantillas/update', [PrestamoController::class, 'updateNombrePlantilla'])->name('plantilla.update.nombre');
Route::post('/prestamos/plantillas/usar/{plantilla}', [PrestamoController::class, 'usePlantilla'])->name('plantilla.usar');
Route::delete('/prestamos/plantillas/libros/delete/{plantilla}/{libro}', [PrestamoController::class, 'removeLibroFromPlantilla'])->name('plantilla.delete.libro');
Route::delete('/prestamos/plantillas/delete/{plantilla}', [PrestamoController::class, 'destroyPlantilla'])->name('plantilla.delete');
Route::post('/prestamos/generarQR', [PrestamoController::class, 'procesarInfoPrestamo'])->name('prestamo.generarQR');

Route::get('/enviarQR/{text}/{email}', [QrController::class, 'generateQR'])->name('temp');
Route::get('/convertpng', [QrController::class, 'convertSVGtoPNG'])->name('convertPNG');
Route::post('/guardar-imagen', [QrController::class, 'guardarPNGPublic']);
Route::get('/enviar', [QrController::class, 'enviarCorreoConQR'])->name('enviarCorreoQR');

Route::get('/devoluciones', [DevolucionController::class, 'index'])->name('devolucion.index')->middleware('can:isAdminOrTrabajadorOrProfesor');

Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index')->middleware('can:isAdminOrTrabajador');
