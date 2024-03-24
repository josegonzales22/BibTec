<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Models\Libro;
use App\Models\Plantilla;
use App\Models\Prestamo;
use App\Models\User;
use App\Policies\LibroPolicy;
use App\Policies\PrestamosPolicy;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrestamoController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $policy = new PrestamosPolicy;
        if($policy->read($user)){
            $busqueda = $request->busquedaInput;
            $prestamos = DB::table('prestamo as P')
                ->selectRaw('P.id, CONCAT(U.nombres, " ", U.apellidos) AS estudiante, L.titulo, P.cantidad, P.f_prestamo, P.estado')
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
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function viewBaul(){
        try {
            $user = auth()->user();
            $policy = new PrestamosPolicy;
            if($policy->baul($user)){
                $libros = DB::table('libros as L')
                ->select('L.id', 'L.titulo', 'L.genero','L.numpag','L.idioma')
                ->join('baul_pres as BP', 'L.id', '=','BP.idLibro')
                ->orderBy('L.id')
                ->get();
                return view('sistema.prestamo.baul',['libros' => $libros]);
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
    public function viewListPlantillas(Request $request){
        try {
            $user = auth()->user();
            $policy = new PrestamosPolicy;
            if($policy->read($user)){
                $plantillas = Plantilla::leftJoin('plantilla_libro', 'plantilla.id', '=', 'plantilla_libro.plantilla_id')
                ->select('plantilla.*')
                ->withCount('libros')
                ->groupBy('plantilla.id')
                ->orderBy('plantilla.id')
                ->get();
                return view('sistema.prestamo.plantillas.index', ['plantillas' => $plantillas]);
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
    public function viewPlantilla($id){
        try {
            $user = auth()->user();
            $policy = new PrestamosPolicy;
            if($policy->read($user)){
                $plantilla = Plantilla::findOrFail($id);
                return view('sistema.prestamo.plantillas.view', ['plantilla' => $plantilla]);
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.index')->with('status', $th->getMessage());
        }
    }
    public function editPlantilla($id){
        try {
            $user = auth()->user();
            $policy = new PrestamosPolicy;
            if($policy->create($user)){
                $plantilla = Plantilla::findOrFail($id);
                return view('sistema.prestamo.plantillas.edit', ['plantilla' => $plantilla]);
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.index')->with('status', $th->getMessage());
        }
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
    public function obtenerStockLibro($idLibro){
        try {
            $libro = Libro::findOrFail($idLibro);
            return $libro->cantidad;
        } catch (\Throwable $th) {
            return redirect()->route('devolucion.index')->with('status', $th->getMessage());
        }
    }
    public function store(Request $request){
        try {
            $user = auth()->user();
            $policy = new PrestamosPolicy;
            if($policy->create($user)){
                if($this->checkUserIsStudent($request->dniEstudiante)){
                    $idU=$this->obtainIdStudent($request->dniEstudiante);
                    if($idU){
                        echo $idU;
                        $libros = DB::table('baul_pres')
                        ->where('idUser', Auth::user()->id)
                        ->get();
                        $fAct = Carbon::now();
                        foreach ($libros as $libro) {
                            DB::beginTransaction();
                                Prestamo::create([
                                    'idUser' => $idU,
                                    'idLibro' => $libro->idLibro,
                                    'cantidad' => 1,
                                    'f_prestamo' => $fAct,
                                    'estado' => 'Pendiente'
                                ]);
                                $this->deleteFromBaul(Auth::user()->id, $libro->idLibro);
                                $libroTemp = Libro::findOrFail($libro->idLibro);
                                $libroTemp->cantidad = $this->obtenerStockLibro($libro->idLibro)-1;
                                $libroTemp->save();
                                $fecha = new DateTime();
                                Historial::create([
                                    'user_id' => Auth::user()->id,
                                    'fecha' => $fecha,
                                    'operacion' => 'Préstamo de libro completado',
                                    'libro_id' => $libro->idLibro
                                ]);
                            DB::commit();
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
            }else{
                abort(403, 'No tienes permiso para esta operación');
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
            $user = auth()->user();
            $policy = new LibroPolicy;
            if($policy->create($user)){
                $request->validate(['plantillaName' => 'required|max:50']);
                if($this->countPlantillas()){
                    if($this->checkNamePlantilla($request->plantillaName)){
                        return redirect()->route('plantilla.index')->with('status', 'La plantilla ingresada ya existe');
                    }else{
                        DB::beginTransaction();
                            Plantilla::create(['nombre' => $request->plantillaName]);
                            $fecha = new DateTime();
                            Historial::create([
                                'user_id' => Auth::user()->id,
                                'fecha' => $fecha,
                                'operacion' => 'Plantilla creada',
                                'libro_id' => null
                            ]);
                        DB::commit();
                    }
                }else{
                    return redirect()->route('plantilla.index')->with('status', 'El límite es 10 plantillas');
                }
                return redirect()->route('plantilla.index')->with('status', 'Plantilla registrada exitosamente');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.index')->with('status', $th->getMessage());
        }
    }
    public function destroyPlantilla(Plantilla $plantilla){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy;
            if($policy->create($user)){
                DB::beginTransaction();
                    $plantilla->delete();
                    $fecha = new DateTime();
                    Historial::create([
                        'user_id' => Auth::user()->id,
                        'fecha' => $fecha,
                        'operacion' => 'Plantilla eliminada',
                        'libro_id' => null
                    ]);
                DB::commit();
                return redirect()->route('plantilla.index')->with('status', 'Plantilla eliminada exitosamente');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.index')->with('status', $th->getMessage());
        }
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
    public function checkBaulIsEmpty(){
        try {
            $cant = DB::table('baul_pres')
                ->where('idUser', Auth::user()->id)
                ->count();
            if($cant>0){return false;}
            else{return true;}
        } catch (\Throwable $th) {
            return true;
        }
    }
    public function updateNombrePlantilla(Request $request){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy;
            if($policy->update($user)){
                DB::beginTransaction();
                    $p = Plantilla::findOrFail($request->idP);
                    $p->nombre=$request->nombreP;
                    $p->save();
                    $fecha = new DateTime();
                    Historial::create([
                        'user_id' => Auth::user()->id,
                        'fecha' => $fecha,
                        'operacion' => 'Nombre de plantilla actualizada',
                        'libro_id' => null
                    ]);
                DB::commit();
                return redirect()->route('plantilla.edit', ['plantilla'=>$request->idP])->with('status', 'Plantilla modificada correctamente');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.edit', ['plantilla'=>$request->idP])->with('status', $th->getMessage());
        }
    }
    public function removeLibroFromPlantilla($plantilla, $libro){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy;
            if($policy->delete($user)){
                DB::beginTransaction();
                    DB::table('plantilla_libro')
                    ->where('plantilla_id', $plantilla)
                    ->where('libro_id',$libro)
                    ->delete();
                    $fecha = new DateTime();
                    Historial::create([
                        'user_id' => Auth::user()->id,
                        'fecha' => $fecha,
                        'operacion' => 'Libro eliminado de plantilla',
                        'libro_id' => $libro->idLibro
                    ]);
                DB::commit();
                return redirect()->route('plantilla.edit', ['plantilla' => $plantilla])->with('status', 'Libro eliminado de la plantilla');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.edit', ['plantilla'=>$plantilla])->with('status', $th->getMessage());
        }
    }
    public function verBaulVacio($idUser){
        try {
            $cond = DB::table('baul_pres')
            ->where('idUser', $idUser)
            ->exists();
            return $cond;
        } catch (\Throwable $th) {
            return true;
        }
    }
    public function verLibrosEnPlantilla($idP){
        try {
            $cant = DB::table('plantilla_libro')
            ->where('plantilla_id', $idP)
            ->count();
            return $cant != 0;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function usePlantilla(Plantilla $plantilla){
        try {
            $user = auth()->user();
            $policy = new PrestamosPolicy;
            if($policy->create($user)){
                if(!$this->verBaulVacio(Auth::user()->id)){
                    if($this->verLibrosEnPlantilla($plantilla->id)){
                        foreach($plantilla->libros as $libro){
                            DB::table('baul_pres')->insert([
                            'idUser' => Auth::user()->id,
                            'idLibro' => $libro->id
                            ]);
                        }
                        return redirect()->route('prestamo.baul');
                    }else{
                        return redirect()->route('plantilla.index')->with('status', 'La plantilla no contiene libros');
                    }
                }else{
                    return redirect()->route('plantilla.index')->with('status', 'El baúl no esta vacío');
                }
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('plantilla.index')->with('status', $th->getMessage());
        }
    }
    public function movePrestamoToBaul(Prestamo $prestamo){
        try {
            DB::table('baul_dev')->insert([
                'idUser' => Auth::user()->id,
                'idPres' => $prestamo->id
            ]);
            return redirect()->route('prestamo.index')->with('status', 'Prestamo agregado al baúl de devoluciones');
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
    public function removePrestamoFromBaul($idP){
        try {
            DB::table('baul_dev')
            ->where('idUser', Auth::user()->id)
            ->where('idPres', $idP)
            ->delete();
            return redirect()->route('prestamo.index')->with('status',
            'Prestamo eliminado del baúl');
        } catch (\Throwable $th) {
            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
        }
    }
    public function checkPrestamoFromBaul($idP){
        try {
            $cond = DB::table('baul_dev')
                ->where('idUser', Auth::user()->id)
                ->where('idPres', $idP)
                ->exists();
            return $cond;
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function procesarInfoPrestamo(Request $request){
        $dni = $request->dniEstudiante;
        $fecha = $request->fechaConsulta;
        try {
            $user = User::where('dni', $dni)->firstOrFail();
            $user2 = auth()->user();
            if($user){
                $policy = new PrestamosPolicy();
                if($policy->create($user2)){
                    $prestamos = Prestamo::where('idUser', $user->id)
                                        ->where('estado', 'Pendiente')
                                        ->where('f_prestamo', $fecha)
                                        ->get();
                    $count = $prestamos->count();
                    if($count > 0){
                        $textoTemp = "";
                        foreach ($prestamos as $prestamo){
                            $textoTemp = "pLe=".$prestamo->id.";".$textoTemp;
                        }
                        $emailUser = $user->email;
                        try {
                            return redirect()->route('prestamo.saveqr', ['text' => $textoTemp, 'email' => $emailUser]);
                        } catch (\Throwable $th) {
                            return redirect()->route('prestamo.index')->with('status', $th->getMessage());
                        }
                        return redirect()->route('prestamo.index')->with('status', 'Código qr enviado exitosamente');
                    }else{
                        return redirect()->route('prestamo.index')->with('status', 'No existen préstamos pendientes en la fecha ingresada');
                    }
                }else{
                    return redirect()->route('prestamo.index')->with('status', 'El usuario no es estudiante');
                }
            }else{
                return redirect()->route('prestamo.index')->with('status', 'El usuario no existe');
            }
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public function checkTablePrestamoIsNotEmpty(){
        try {
            $cant = DB::table('prestamo')->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
}
