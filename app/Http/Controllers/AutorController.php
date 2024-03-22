<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAutorRequest;
use App\Models\Autor;
use App\Policies\LibroPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HistorialController;
use DateTime;
use Illuminate\Support\Facades\Auth;

class AutorController extends Controller
{
    protected $historial;
    public function __construct(HistorialController $historial)
    {
        $this->historial = $historial;
    }
    public function index(Request $request){
        /*
        $user = auth()->user();
        $policy = new LibroPolicy();
        if($policy->checkRead($user)){

        }else{
            return redirect()->route('dashboard');
        }
        */
        $busqueda = $request->busquedaInput;
            $autores = Autor::selectRaw('autor.*, COALESCE(COUNT(L.idAutor), 0) AS cantidad_libros')
                ->leftJoin('libros_autor as L', 'autor.id', '=', 'L.idAutor')
                ->where(function ($query) use ($busqueda) {
                    $query->where('autor.id', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('autor.info', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('autor.created_at', 'LIKE', '%' . $busqueda . '%')
                        ->orWhere('autor.updated_at', 'LIKE', '%' . $busqueda . '%');
                })
            ->groupBy('autor.id')
            ->paginate(5);
        return view('sistema.autor.index', ['autores' => $autores, 'busqueda' => $busqueda]);
    }
    public function update(SaveAutorRequest $request, Autor $autor){
        try {
            /*
            $user = auth()->user();
            $policy = new LibroPolicy();
            if($policy->updateAutor($user)){

            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
            */
            $autor = Autor::findOrFail($request->input('id'));
            $autor->info = $request->input('info');
            $autor->save();
            $fecha = new DateTime();
            $this->historial->store(Auth::user()->id, $fecha, 'Autor actualizado', null);
            return redirect()->route('autor.index')->with('status', 'Autor actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('autor.index')->with('status', $th->getMessage());
        }
    }
    public function delete($id){
        try {
            /*
            $user = auth()->user();
            $policy = new LibroPolicy();
            if($policy->delete($user)){

            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
            */
            DB::beginTransaction();
                    DB::table('libros_autor')->where('idAutor', $id)->delete();
                    $autor = Autor::findOrFail($id);
                    $autor->delete();
                    $fecha = new DateTime();
                    $this->historial->store(Auth::user()->id, $fecha, 'Autor eliminado', null);
            DB::commit();
            return redirect()->route('autor.index')->with('status', 'Autor eliminado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('autor.index')->with('status', $th->getMessage());
        }
    }
    public function checkTableAutorIsNotEmpty(){
        try {
            $cant = DB::table('autor')->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
}
