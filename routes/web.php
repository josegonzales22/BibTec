<?php

use App\Http\Controllers\AutorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsuarioController;
use App\Models\Devolucion;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){return Redirect::to('login');});

Auth::routes();

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/libros', [LibrosController::class, 'index'])->name('libro.index')->middleware('can:isAdmOrTrabOrProf');
Route::post('/libros', [LibrosController::class, 'index'])->name('libro.index')->middleware('can:isAdmOrTrabOrProf');
Route::get('/libros/nuevo', [LibrosController::class, 'registerStore'])->name('libro.new')->middleware('can:isTrabajador');
Route::post('/libros/nuevo', [LibrosController::class, 'register'])->name('libro.new')->middleware('can:isTrabajador');
Route::get('/libros/edit/{libro}', [LibrosController::class, 'edit'])->name('libro.edit')->middleware('can:isTrabajador');
Route::put('/libros/{libro}', [LibrosController::class, 'update'])->name('libro.update')->middleware('can:isTrabajador');
Route::delete('/libros/delete/{id}', [LibrosController::class, 'delete'])->name('libro.delete')->middleware('can:isTrabajador');
Route::post('/libros/plantilla', [LibrosController::class, 'addToPlantilla'])->name('libro.plantilla')->middleware('can:isTrabajador');

Route::post('/libros/baul/{user}/{book}',[LibrosController::class, 'addToBaul'])->name('libro.addToBaul')->middleware('can:isTrabOrProf');
Route::post('/libros/dbaul/{user}/{book}',[LibrosController::class, 'deleteFromBaul'])->name('libro.deleteFromBaul')->middleware('can:isTrabOrProf');

Route::get('/autor', [AutorController::class, 'index'])->name('autor.index')->middleware('can:isTrabajador');
Route::post('/autor', [AutorController::class, 'index'])->name('autor.index')->middleware('can:isTrabajador');
Route::put('/autor', [AutorController::class, 'update'])->name('autor.update')->middleware('can:isTrabajador');
Route::delete('/autor/delete/{id}', [AutorController::class, 'delete'])->name('autor.delete')->middleware('can:isTrabajador');

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuario.index')->middleware('can:isAdmin');
Route::post('/usuarios', [UsuarioController::class, 'index'])->name('usuario.index')->middleware('can:isAdmin');
Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuario.create')->middleware('can:isAdmin');
Route::post('/usuarios/guardar',[UsuarioController::class, 'store'])->name('usuario.save')->middleware('can:isAdmin');
Route::get('/usuarios/roles', [RolesController::class, 'index'])->name('rol.index')->middleware('can:isAdmin');
Route::post('/usuarios/roles', [RolesController::class, 'index'])->name('rol.index')->middleware('can:isAdmin');
Route::get('/usuarios/roles/crear', [RolesController::class, 'create'])->name('rol.create')->middleware('can:isAdmin');
Route::post('/usuarios/roles/new', [RolesController::class, 'store'])->name('rol.store')->middleware('can:isAdmin');
Route::get('/usuarios/roles/{rol}', [RolesController::class, 'show'])->name('rol.show')->middleware('can:isAdmin');
Route::get('/usuarios/roles/{rol}/edit', [RolesController::class, 'edit'])->name('rol.edit')->middleware('can:isAdmin');
Route::put('/usuarios/roles/{rol}', [RolesController::class, 'update'])->name('rol.update')->middleware('can:isAdmin');
Route::delete('/usuarios/roles/delete', [RolesController::class, 'destroy'])->name('rol.delete')->middleware('can:isAdmin');
Route::get('/usuarios/{user}', [UsuarioController::class, 'edit'])->name('usuario.edit')->middleware('can:isAdmin');
Route::put('/usuarios/update/{user}', [UsuarioController::class, 'update'])->name('usuario.update')->middleware('can:isAdmin');
Route::delete('/usuarios/delete/{user}', [UsuarioController::class, 'destroy'])->name('usuario.delete')->middleware('can:isAdmin');

Route::get('/prestamos', [PrestamoController::class, 'index'])->name('prestamo.index')->middleware('can:isAdmOrTrabOrProf');
Route::post('/prestamos', [PrestamoController::class, 'index'])->name('prestamo.index')->middleware('can:isAdmOrTrabOrProf');
Route::get('/prestamos/baul',[PrestamoController::class, 'viewBaul'])->name('prestamo.baul')->middleware('can:isTrabOrProf');
Route::post('/prestamos/baul/finalizar', [PrestamoController::class, 'store'])->name('prestamo.store')->middleware('can:isTrabOrProf');
Route::post('/prestamos/dbaul/{user}/{book}',[PrestamoController::class,'deleteFromBaul'])->name('prestamo.deleteFromBaul')->middleware('can:isTrabOrProf');
Route::post('prestamos/atbd/{prestamo}', [PrestamoController::class, 'movePrestamoToBaul'])->name('prestamo.bauld')->middleware('can:isTrabOrProf');
Route::delete('/prestamos/dbaul/remove/{prestamo}', [PrestamoController::class, 'removePrestamoFromBaul'])->name('bauld.remove')->middleware('can:isTrabOrProf');
Route::get('/prestamos/plantillas',[PrestamoController::class, 'viewListPlantillas'])->name('plantilla.index')->middleware('can:isTrabOrProf');
Route::post('/prestamos/plantillas/save', [PrestamoController::class, 'savePlantilla'])->name('plantilla.save')->middleware('can:isTrabOrProf');
Route::get('/prestamos/plantillas/view/{plantilla}', [PrestamoController::class, 'viewPlantilla'])->name('plantilla.view')->middleware('can:isTrabOrProf');
Route::get('/prestamos/plantillas/edit/{plantilla}', [PrestamoController::class, 'editPlantilla'])->name('plantilla.edit')->middleware('can:isTrabajador');
Route::put('/prestamos/plantillas/update', [PrestamoController::class, 'updateNombrePlantilla'])->name('plantilla.update.nombre')->middleware('can:isTrabajador');
Route::post('/prestamos/plantillas/usar/{plantilla}', [PrestamoController::class, 'usePlantilla'])->name('plantilla.usar')->middleware('can:isTrabOrProf');
Route::delete('/prestamos/plantillas/libros/delete/{plantilla}/{libro}', [PrestamoController::class, 'removeLibroFromPlantilla'])->name('plantilla.delete.libro')->middleware('can:isTrabajador');
Route::delete('/prestamos/plantillas/delete/{plantilla}', [PrestamoController::class, 'destroyPlantilla'])->name('plantilla.delete')->middleware('can:isTrabajador');
Route::post('/prestamos/generarQR', [PrestamoController::class, 'procesarInfoPrestamo'])->name('prestamo.generarQR')->middleware('can:isTrabOrProf');
Route::get('/save-qr-code/{text}/{email}', [QrController::class, 'saveQRCode'])->name('prestamo.saveqr')->middleware('can:isTrabOrProf');
Route::get('/ecorreo/{email}', [QrController::class, 'enviarCorreoConQR'])->name('prestamo.enviarQR')->middleware('can:isTrabOrProf');

Route::get('/devoluciones', [DevolucionController::class, 'index'])->name('devolucion.index')->middleware('can:isAdmOrTrabOrProf');
Route::post('/devoluciones', [DevolucionController::class, 'index'])->name('devolucion.index')->middleware('can:isAdmOrTrabOrProf');
Route::get('/devoluciones/baul', [DevolucionController::class, 'baulIndex'])->name('devolucion.baul.index')->middleware('can:isTrabOrProf');
Route::post('/devoluciones/baul/delete/{user}/{prestamo}', [DevolucionController::class, 'deleteFromBaul'])->name('dbaul.delete')->middleware('can:isTrabOrProf');
Route::post('/devoluciones/baul/save/{user}', [DevolucionController::class, 'procesarBaul'])->name('dbaul.process')->middleware('can:isTrabOrProf');
Route::get('/devoluciones/escaner', [DevolucionController::class, 'escanerIndex'])->name('devolucion.escaner')->middleware('can:isTrabOrProf');
Route::post('/devoluciones/escaner/{cadena}', [DevolucionController::class, 'procesarInfoEscaner'])->name('devolucion.escaner.info')->middleware('can:isTrabOrProf');

Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index')->middleware('can:isAdmOrTrabOrProf');
Route::post('/historial', [HistorialController::class, 'index'])->name('historial.index')->middleware('can:isAdmOrTrabOrProf');
Route::post('/historial/report/{op}', [HistorialController::class, 'exportCSVInfo'])->name('historial.export')->middleware('can:isAdmOrTrabOrProf');
