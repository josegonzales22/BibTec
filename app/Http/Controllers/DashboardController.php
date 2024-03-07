<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        return view('trabajador.dashboard');
    }
    public function contarLibros()
    {
        $conteoLibros = DB::table('libros')->count();
        return $conteoLibros;
    }
    public function contarEstudiante(){
        $conteo = DB::select('SELECT COUNT(*) AS total FROM users WHERE perfil_id=2')[0]->total;
        return $conteo;
    }
    public function contarPrestamo(){
        $conteo = DB::select('SELECT COUNT(*) AS total FROM prestamo')[0]->total;
        return $conteo;
    }
    public function contarDevolucion(){
        $conteo = DB::select('SELECT COUNT(*) AS total FROM devolucion')[0]->total;
        return $conteo;
    }
}
