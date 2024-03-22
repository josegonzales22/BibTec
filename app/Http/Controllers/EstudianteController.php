<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Policies\UsuarioPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstudianteController extends Controller
{
    public function indexPrestamos(Request $request){
        $user = auth()->user();
        $policy = new UsuarioPolicy;
        if($policy->prestamoEstudiante($user)){
            $busqueda = $request->busquedaInput;
            $prestamos = DB::table('prestamo AS P')
                ->select('L.titulo', 'P.cantidad', 'P.f_prestamo', 'P.estado')
                ->join('libros AS L', 'P.idLibro', '=', 'L.id')
                ->where('P.idUser', '=', Auth()->user()->id)
                ->where(function($query) use ($busqueda) {
                    $query->where('L.titulo', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('P.cantidad', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('P.f_prestamo', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('P.estado', 'LIKE', '%'.$busqueda.'%');
                })
                ->groupBy('P.id')
                ->orderByDesc('P.id')
                ->paginate(5);
            return view('sistema.estudiante.prestamo', ['prestamos' => $prestamos, 'busqueda' => $busqueda]);
        }else{
            abort(403, 'No tienes permiso para esta operación');
        }
    }
    public function indexDevoluciones(Request $request){
        $user = auth()->user();
        $policy = new UsuarioPolicy;
        if($policy->devolucionEstudiante($user)){
            $busqueda = $request->busquedaInput;
            $devoluciones = DB::table('devolucion AS D')
                ->select('L.titulo', 'D.cantidad', 'D.f_prestamo', 'D.f_devolucion')
                ->join('libros AS L', 'D.idLibro', '=', 'L.id')
                ->where('D.idUser', '=', Auth()->user()->id)
                ->where(function($query) use ($busqueda) {
                    $query->where('L.titulo', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('D.cantidad', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('D.f_prestamo', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('D.f_devolucion', 'LIKE', '%'.$busqueda.'%');
                })
                ->groupBy('D.id')
                ->orderByDesc('D.id')
                ->paginate(5);
                return view('sistema.estudiante.devolucion', ['devoluciones' => $devoluciones, 'busqueda' => $busqueda]);
        }else{
            abort(403, 'No tienes permiso para esta operación');
        }
    }
    public function checkTablePrestamoIsNotEmpty(){
        try {
            $cant = DB::table('prestamo')
            ->where('idUser', Auth()->user()->id)
            ->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function checkTableDevolucionIsNotEmpty(){
        try {
            $cant = DB::table('devolucion')
            ->where('idUser', Auth()->user()->id)
            ->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
}
