<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveLibroRequest;
use App\Models\Autor;
use App\Models\Libro;
use App\Models\LibrosAutor;
use App\Models\Plantilla;
use App\Policies\LibroPolicy;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibrosController extends Controller
{
    protected $historial;
    public function __construct(HistorialController $historial)
    {
        $this->historial = $historial;
    }
    public function index(Request $request){
        $user = auth()->user();
        $policy = new LibroPolicy();
        if($policy->read($user)){
            $busqueda = $request->busquedaInput;
            $libros2 = Libro::select('libros.*', DB::raw('GROUP_CONCAT(autor.info SEPARATOR "; ") AS Autores'))
                ->leftJoin('libros_autor', 'libros.id', '=', 'libros_autor.idLibro')
                ->leftJoin('autor', 'libros_autor.idAutor', '=', 'autor.id')
                ->where(function ($query) use ($busqueda) {
                    $query->where('titulo', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('editorial', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('pub', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('genero', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('numpag', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('idioma', 'LIKE', '%'.$busqueda.'%')
                        ->orWhere('cantidad', 'LIKE', '%'.$busqueda.'%');
                })
                ->groupBy('libros.id')
                ->orderByDesc('libros.id')
                ->paginate(5);
            $plantillas = Plantilla::all();
            return view('sistema.libro.index', [
                'libros' => $libros2,
                'busqueda' => $busqueda,
                'plantillas' => $plantillas
            ]);
        }else{
            return redirect()->route('dashboard');
        }
    }

    public function registerStore(){
        return view('sistema.libro.nuevo');
    }
    public function register(SaveLibroRequest $request){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy();
            if($policy->create($user)){
                $titulo = $request->input('titulo');
                $editorial = $request->input('editorial');
                $pub = $request->input('pub');
                $genero = $request->input('genero');
                $numpag = $request->input('numpag');
                $idioma = $request->input('idioma');
                $cantidad = $request->input('cantidad');
                $libro = Libro::create([
                    'titulo' =>$titulo,
                    'editorial' => $editorial,
                    'pub' => $pub,
                    'genero' => $genero,
                    'numpag' => $numpag,
                    'idioma' => $idioma,
                    'cantidad' => $cantidad
                ]);
                $libroId = $libro->id;
                $autoresIds = [];
                $autores = $request->input('autores');
                if ($autores !== null) {
                    DB::beginTransaction();
                        foreach ($autores as $info) {
                            $autor = Autor::firstOrcreate(['info' => $info]);
                            $autoresIds[] = $autor->id;
                        }
                        foreach ($autoresIds as $autorId) {
                            LibrosAutor::create(['idLibro' => $libroId,'idAutor' => $autorId]);
                        }
                        $fecha = new DateTime();
                        $this->historial->store(Auth::user()->id, $fecha, 'Libro registrado', null);
                    DB::commit();
                    return redirect()->route('libro.index')->with('status', 'Libro registrado correctamente');
                }
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }

    public function edit($id) {
        $libro = Libro::find($id);
        return view('sistema.libro.editar', compact('libro'));
    }
    public function update(SaveLibroRequest $request, Libro $libro){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy();
            if($policy->update($user)){
                DB::beginTransaction();
                    $libro->titulo = $request->input('titulo');
                    $libro->editorial = $request->input('editorial');
                    $libro->pub = $request->input('pub');
                    $libro->genero = $request->input('genero');
                    $libro->numpag = $request->input('numpag');
                    $libro->idioma = $request->input('idioma');
                    $libro->cantidad = $request->input('cantidad');
                    $libro->save();
                    $fecha = new DateTime();
                    $this->historial->store(Auth::user()->id, $fecha, 'Libro actualizado', $libro->id);
                DB::commit();
                return redirect()->route('libro.index')->with('status', 'Libro actualizado correctamente');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }
    public function delete($id){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy();
            if($policy->delete($user)){
                DB::beginTransaction();
                    $libro = Libro::findOrFail($id);
                    $libro->delete();
                    $fecha = new DateTime();
                    $this->historial->store(Auth::user()->id, $fecha, 'Libro eliminado', null);
                DB::commit();
                return redirect()->route('libro.index')->with('status', 'Libro eliminado correctamente');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }
    public function addToPlantilla(Request $request){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy();
            if($policy->create($user)){
                if($request->plantilla!=0){
                    if($this->checkLibroExistsInPlantilla($request->idLibro, $request->plantilla)){
                        return redirect()->route('libro.index')->with('status', 'El libro ya existe en la plantilla');
                    }else{
                        if($this->checkCantLibrosInPlantilla($request->plantilla)){
                            DB::beginTransaction();
                                DB::table('plantilla_libro')->insert([
                                    'plantilla_id' => $request->plantilla,
                                    'libro_id' => $request->idLibro
                                ]);
                                $fecha = new DateTime();
                                $this->historial->store(Auth::user()->id, $fecha, 'Libro agregado a plantilla', $request->idLibro);
                            DB::commit();
                            return redirect()->route('libro.index')->with('status', 'Libro agregado a la plantilla');
                        }else{
                            return redirect()->route('libro.index')->with('status', 'Límite de libros alcanzado en la plantilla');
                        }
                    }
                }else{
                    return redirect()->route('libro.index')->with('status', 'Por favor, seleccione una plantilla');
                }
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }
    /*******************
    ====================
        Funciones
    ====================
    ********************/
    public function checkCantLibrosInPlantilla($idPlantilla){
        try {
            $cond = DB::table('plantilla_libro')
            ->where('plantilla_id', $idPlantilla)
            ->count();
            if($cond<10){return true;}
            else{return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function checkLibroExistsInPlantilla($idLibro, $idPlantilla){
        try {
            $cond = DB::table('plantilla_libro')
            ->where('plantilla_id', $idPlantilla)
            ->where('libro_id', $idLibro)
            ->exists();
            if($cond){return true;}
            else{return false;}
        } catch (\Throwable $th) {
            return true;
        }
    }
    public function verCantBaulLibro($idUser){
        try {
            $cant = DB::table('baul_pres')
            ->where('idUser', $idUser)
            ->count();
            return $cant;
        } catch (\Throwable $th) {
            $cant=-1;
            return $cant;
        }
    }
    public function verStockLibro($idBook){
        $stock = DB::table('libros')->where('id', $idBook)->value('cantidad');
        return $stock;
    }
    public function reservarLibro($idBook){
        DB::table('libros')->where('id', $idBook)->update(['cantidad' => ($this->verStockLibro($idBook)-1)]);
    }
    public function removeReservaStockLibro($idBook){
        DB::table('libros')->where('id', $idBook)->update(['cantidad' => ($this->verStockLibro($idBook)+1)]);
    }
    public function addToBaul($idUser, $idBook){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy;
            if($policy->baul($user)){
                if($this->verCantBaulLibro($idUser)<10){
                    if($this->verStockLibro($idBook)>0){
                        $this->reservarLibro($idBook);
                        DB::table('baul_pres')->insert([
                            'idUser' => $idUser,
                            'idLibro' => $idBook
                        ]);
                        return redirect()->route('libro.index')->with('status', 'Libro agregado al baúl');
                    }else{
                        return redirect()->route('libro.index')->with('status', 'No hay stock del libro');
                    }
                }else if($this->verCantBaulLibro($idUser, $idBook)==-1){
                    return redirect()->route('libro.index')->with('status', 'Ocurrió un problema');
                }else{
                    return redirect()->route('libro.index')->with('status', 'No es posible agregar más libros al baúl');
                }
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }
    public function libroExistsInBaul($idUser, $idBook){
        $resultado = DB::table('baul_pres')
                    ->where('idUser', $idUser)
                    ->where('idLibro', $idBook)
                    ->exists();
        return $resultado;
    }
    public function deleteFromBaul($idUser, $idBook){
        try {
            DB::table('baul_pres')
            ->where('idUser', $idUser)
            ->where('idLibro', $idBook)
            ->delete();
            $this->removeReservaStockLibro($idBook);
            return redirect()->route('libro.index')->with('status', 'Libro eliminado del baúl');
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }
    public function checkTableLibroIsNotEmpty(){
        try {
            $cant = DB::table('libros')->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
}
