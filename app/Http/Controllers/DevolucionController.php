<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->busquedaInput;
        $devoluciones = DB::table('devolucion as D')
        ->selectRaw('D.id, CONCAT(U.nombres, " ", U.apellidos) AS estudiante, L.titulo, D.cantidad, D.f_prestamo, D.f_devolucion')
        ->join('users as U', 'D.idUser', '=', 'U.id')
        ->join('libros as L', 'D.idLibro', '=', 'L.id')
        ->where(function($query) use($busqueda){
            $query->where('U.nombres', 'LIKE','%'.$busqueda.'%')
            ->orWhere('U.apellidos', 'LIKE','%'.$busqueda.'%')
            ->orWhere('L.titulo', 'LIKE', '%'.$busqueda.'%')
            ->orWhere('D.cantidad', 'LIKE', '%'.$busqueda.'%')
            ->orWhere('D.f_prestamo', 'LIKE', '%'.$busqueda.'%')
            ->orWhere('D.f_devolucion', 'LIKE', '%'.$busqueda.'%');
        })
        ->orderBy('D.id')
        ->paginate(5);
        return view('sistema.devolucion.index', ['devoluciones' => $devoluciones, 'busqueda' => $busqueda]);
    }
    public function baulIndex(){
        $prestamos = DB::table('baul_dev as BV')
            ->select('P.id', DB::raw("P.id AS IdPrestamo, CONCAT(U.nombres, ' ', U.apellidos) AS Estudiante"), 'L.titulo AS Libro', 'P.f_prestamo', 'P.estado')
            ->join('prestamo AS P', 'P.id', '=', 'BV.idPres')
            ->join('libros AS L', 'P.idLibro', '=', 'L.id')
            ->join('users AS U', 'P.idUser', '=', 'U.id')
            ->orderBy('P.id')
            ->get();
        return view('sistema.devolucion.baul' , ['prestamos'=> $prestamos]);
    }
    public function escanerIndex(){
        return view('sistema.devolucion.escaner');
    }
    public function verCantBaulPres($idUser){
        try {
            $cant = DB::table('baul_dev')
            ->where('idUser', $idUser)
            ->count();
            return $cant;
        } catch (\Throwable $th) {
            $cant=-1;
            return $cant;
        }
    }
    public function checkTableDevolucionIsNotEmpty(){
        try {
            $cant = DB::table('devolucion')->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function checkBaulDevolucionIsEmpty(){
        try {
            $cant = DB::table('baul_dev')->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function deleteFromBaul($idUser, $idP){
        try {
            DB::table('baul_dev')
                ->where('idUser', $idUser)
                ->where('idPres', $idP)
                ->delete();
            return redirect()->route('devolucion.baul.index')->with('status', 'Préstamo eliminado del baúl');
        } catch (\Throwable $th) {
            return redirect()->route('devolucion.baul.index')->with('status', $th->getMessage());
        }
    }
    public function obtenerStockLibro($idLibro){
        try {
            $libro = Libro::findOrFail($idLibro);
            return $libro->cantidad;
        } catch (\Throwable $th) {
            return redirect()->route('devolucion.index')->with('status', $th->getMessage());
        }
    }
    public function procesarBaul($idUser){
        try {
            $prestamos = DB::table('baul_dev as BD')
                        ->select('P.id', 'P.idLibro', 'P.cantidad', 'P.f_prestamo', 'P.idUser')
                        ->join('prestamo AS P', 'BD.idPres', '=', 'P.id')
                        ->where('BD.idUser', $idUser)
                        ->where('P.estado', 'Pendiente')
                        ->get();
            foreach ($prestamos as $prestamo) {
                DB::beginTransaction();
                    Devolucion::create([
                        'idUser' => $prestamo->idUser,
                        'idLibro' => $prestamo->idLibro,
                        'cantidad' => $prestamo->cantidad,
                        'f_prestamo' => $prestamo->f_prestamo,
                        'f_devolucion' => today()
                    ]);
                    $libroTemp = Libro::findOrFail($prestamo->idLibro);
                    $libroTemp->cantidad = $this->obtenerStockLibro($prestamo->idLibro)+1;
                    $libroTemp->save();
                    $presTemp = Prestamo::findOrFail($prestamo->id);
                    $presTemp->estado = 'Completado';
                    $presTemp->save();
                    $this->deleteFromBaul($idUser, $prestamo->id);
                DB::commit();
            }
            return redirect()->route('devolucion.index')->with('status', 'Devolución completada exitosamente');
        } catch (\Throwable $th) {
            return redirect()->route('devolucion.index')->with('status', $th->getMessage());
        }
    }
    /*
    ========
    Escáner
    ========
    */
    public function procesarInfoEscaner($cadena){
        dd($cadena);
    }
}
