<?php

namespace App\Http\Controllers;

use App\Models\Plantilla;
use App\Models\Prestamo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $busqueda = $request->busquedaInput;
        $prestamos = DB::table('prestamo as P')
            ->selectRaw('CONCAT(U.nombres, " ", U.apellidos) AS estudiante, L.titulo, P.cantidad, P.f_prestamo, P.estado')
            ->join('users as U', 'P.idUser', '=', 'U.id')
            ->join('libros as L', 'P.idLibro', '=', 'L.id')
            ->where(function($query) use($busqueda){
                $query->where('U.nombres', 'LIKE','%'.$busqueda.'%')
                ->orWhere('U.apellidos', 'LIKE','%'.$busqueda.'%')
                ->orWhere('L.titulo', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('P.cantidad', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('P.f_prestamo', 'LIKE', '%'.$busqueda.'%')
                ->orWhere('P.estado', 'LIKE', '%'.$busqueda.'%');
            })
            ->orderBy('P.id')
            ->paginate(5);
        return view('sistema.prestamo.index', ['prestamos' => $prestamos, 'busqueda' => $busqueda]);
    }

    public function viewBaul(){
        $libros = DB::table('libros as L')
            ->select('L.id', 'L.titulo', 'L.genero','L.numpag','L.idioma')
            ->join('baul_pres as BP', 'L.id', '=','BP.idLibro')
            ->orderBy('L.id')
            ->get();
        return view('sistema.prestamo.baul',['libros' => $libros]);
    }
    public function viewListPlantillas(Request $request){
        $plantillas = Plantilla::leftJoin('plantilla_libro', 'plantilla.id', '=', 'plantilla_libro.plantilla_id')
            ->select('plantilla.*')
            ->withCount('libros')
            ->groupBy('plantilla.id')
            ->orderBy('plantilla.id')
            ->get();
        return view('sistema.prestamo.plantillas.index', ['plantillas' => $plantillas]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function checkUserIsStudent($dni){
        $usuario = User::where('dni', $dni)->first();
        if($usuario && $usuario->roles->contains('slug', 'estudiante')){
            return true;
        }else{
            return false;
        }
    }
    public function obtainIdStudent($dni){
        $usuario = User::where('dni', $dni)->value('id');
        return $usuario;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if($this->checkUserIsStudent($request->dniEstudiante)){
                //echo "El estudiante existe";
                $idU=$this->obtainIdStudent($request->dniEstudiante);
                if($idU){
                    echo $idU;
                    $libros = DB::table('baul_pres')
                    ->where('idUser', Auth::user()->id)
                    ->get();
                    $fAct = Carbon::now();
                    foreach ($libros as $libro) {
                        Prestamo::create([
                            'idUser' => $idU,
                            'idLibro' => $libro->idLibro,
                            'cantidad' => 1,
                            'f_prestamo' => $fAct,
                            'estado' => 'Pendiente'
                        ]);
                        $this->deleteFromBaul(Auth::user()->id, $libro->idLibro);
                    }
                    return redirect()->route('prestamo.index')
                    ->with('status', 'Préstamo completado exitosamente');
                }else{
                    return redirect()->route('prestamo.index')
                    ->with('status', 'El usuario no existe o no tiene el rol de estudiante');
                }
            }else{
                return redirect()->route('prestamo.index')
                ->with('status', 'El usuario no existe o no tiene el rol de estudiante');
            }
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')
                ->with('status', $th->getMessage());
        }
    }
    public function countPlantillas(){
        try {
            $cant = DB::table('plantilla')->count();
            if($cant<10){return true;}
            else{return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function checkNamePlantilla($name){
        try {
            $cond = DB::table('plantilla')
            ->where('nombre', $name)->exists();
            if($cond){return true;}
            else{return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function savePlantilla(Request $request){
        try {
            $request->validate(['plantillaName' => 'required|max:50']);
            if($this->countPlantillas()){
                if($this->checkNamePlantilla($request->plantillaName)){
                    return redirect()->route('plantilla.index')->with('status', 'La plantilla ingresada ya existe');
                }else{
                    Plantilla::create(['nombre' => $request->plantillaName]);
                }

            }else{
                return redirect()->route('plantilla.index')->with('status', 'El límite es 10 plantillas');
            }
            return redirect()->route('plantilla.index')->with('status', 'Plantilla registrada exitosamente');
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.index')->with('status', $th->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo)
    {
        //
    }
    public function verStockLibro($idBook){
        $stock = DB::table('libros')->where('id', $idBook)->value('cantidad');
        return $stock;
    }
    public function removeReservaStockLibro($idBook){
        DB::table('libros')->where('id', $idBook)->update(['cantidad' => ($this->verStockLibro($idBook)+1)]);
    }
    public function deleteFromBaul($idUser, $idBook){
        try {
            DB::table('baul_pres')
            ->where('idUser', $idUser)
            ->where('idLibro', $idBook)
            ->delete();
            $this->removeReservaStockLibro($idBook);
            return redirect()->route('prestamo.baul')->with('status', 'Libro eliminado del baúl');
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.baul')->with('status', $th->getMessage());
        }
    }
    public function checkTablePlantillaIsNotEmpty(){
        try {
            $cant = DB::table('plantilla')->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
}
