<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index(){
        return view('sistema.dashboard');
    }
    public function contarLibros()
    {
        $conteoLibros = DB::table('libros')->count();
        return $conteoLibros;
    }
    public function contarEstudiante(){
        $conteo = User::whereHas('roles', function ($query) {
            $query->where('name', 'Estudiante');
        })->count();
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
