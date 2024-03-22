<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $librosMasPrestados = $this->cincoLibrosMasPrestados();
        $totalEstudiantes = User::whereHas('roles', function ($query) {
            $query->where('name', 'Estudiante');
        })->count();
        $estudiantesConPrestamos = DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('prestamo')
                      ->whereRaw('prestamo.idUser = users.id');
            })
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('users_roles')
                      ->whereRaw('users_roles.user_id = users.id')
                      ->where('role_id', '=', 4);
            })
            ->count();

            return view('sistema.dashboard', [
            'librosMasPrestados' => $librosMasPrestados,
            'totalEstudiantes' => $totalEstudiantes,
            'estudiantesConPrestamos' => $estudiantesConPrestamos
        ]);
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
    public function cincoLibrosMasPrestados(){
        $librosMasPrestados = DB::table('prestamo')
            ->select('idLibro', DB::raw('COUNT(*) as total_prestamos'))
            ->groupBy('idLibro')
            ->orderByDesc('total_prestamos')
            ->limit(5)
            ->get();

        $libros = [];
        foreach ($librosMasPrestados as $libro) {
            $titulo = DB::table('libros')->where('id', $libro->idLibro)->value('titulo');
            if ($titulo) {
                $libros[] = [
                    'id' => $libro->idLibro,
                    'titulo' => $titulo,
                    'total_prestamos' => $libro->total_prestamos
                ];
            }
        }
        return $libros;
    }
}
