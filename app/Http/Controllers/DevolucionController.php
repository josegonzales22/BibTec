<?php

namespace App\Http\Controllers;

use App\Models\Devolucion;
use App\Models\Libro;
use App\Models\Prestamo;
use App\Policies\DevolucionPolicy;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    protected $historial;
    public function __construct(HistorialController $historial)
    {
        $this->historial = $historial;
    }
    public function index(Request $request)
    {
        $user = auth()->user();
        $policy = new DevolucionPolicy;
        if($policy->read($user)){
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
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function baulIndex(){
        $user = auth()->user();
        $policy = new DevolucionPolicy;
        if($policy->baul($user)){
            $prestamos = DB::table('baul_dev as BV')
            ->select('P.id', DB::raw("P.id AS IdPrestamo, CONCAT(U.nombres, ' ', U.apellidos) AS Estudiante"), 'L.titulo AS Libro', 'P.f_prestamo', 'P.estado')
            ->join('prestamo AS P', 'P.id', '=', 'BV.idPres')
            ->join('libros AS L', 'P.idLibro', '=', 'L.id')
            ->join('users AS U', 'P.idUser', '=', 'U.id')
            ->orderBy('P.id')
            ->get();
            return view('sistema.devolucion.baul' , ['prestamos'=> $prestamos]);
        }else{
            return redirect()->route('dashboard');
        }
    }
    public function escanerIndex(){
        $user = auth()->user();
        $policy = new DevolucionPolicy;
        if($policy->baul($user)){
            return view('sistema.devolucion.escaner');
        }else{
            return redirect()->route('dashboard');
        }
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
            $user = auth()->user();
            $policy = new DevolucionPolicy;
            if($policy->baul($user)){
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
                        $fecha = new DateTime();
                        $this->historial->store(Auth::user()->id, $fecha, 'Devolución de libro completado', $prestamo->idLibro);
                    DB::commit();
                }
                return redirect()->route('devolucion.index')->with('status', 'Devolución completada exitosamente');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('devolucion.index')->with('status', $th->getMessage());
        }
    }
    /*
    ========
    Escáner
    ========
    */
    public function obtenerEstadoPrestamo($id){
        $prestamo = Prestamo::findOrFail($id);
        return $prestamo->estado;
    }
    public function procesarInfoEscaner($cadena){
        try {
            $user = auth()->user();
            $policy = new DevolucionPolicy;
            if($policy->baul($user)){
                $checkText = substr($cadena, 0, 4);
                if($checkText=="pLe="){
                    preg_match_all("/pLe=(\d+);/", $cadena, $matches);
                    $numeros = $matches[1];
                    $pendientes = [];
                    foreach ($numeros as $numero) {
                        if($this->obtenerEstadoPrestamo($numero)=='Pendiente'){
                            $pendientes[] = $numero;
                        }
                    }
                    if(count($pendientes)>0){
                        $fAct = Carbon::now();
                        foreach ($pendientes as $pendiente) {
                            DB::beginTransaction();
                                $presTemp = Prestamo::findOrFail($pendiente);
                                $devTemp = Devolucion::create([
                                    'idUser' => $presTemp->idUser,
                                    'idLibro' => $presTemp->idLibro,
                                    'cantidad' => $presTemp->cantidad,
                                    'f_prestamo' => $presTemp->f_prestamo,
                                    'f_devolucion' => $fAct
                                ]);
                                $presTemp->estado='Completado';
                                $presTemp->save();
                                $fecha = new DateTime();
                                $this->historial->store(Auth::user()->id, $fecha, 'Devolución de libro completado', $presTemp->idLibro);
                            DB::commit();
                        }
                    }
                    return redirect()->route('devolucion.index')->with('status', 'Devoluciones pendientes completadas');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
            }else{
                return redirect()->route('devolucion.index')->with('status', 'No es un QR del sistema');
            }
        } catch (\Throwable $th) {
            return redirect()->route('devolucion.index')->with('status', $th->getMessage());
        }
    }
}
