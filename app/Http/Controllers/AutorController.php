<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAutorRequest;
use App\Models\Autor;
use App\Policies\LibroPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutorController extends Controller
{
    public function index(Request $request){
        $user = auth()->user();
        $policy = new LibroPolicy();
        if($policy->checkRead($user)){
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
        }else{
            return redirect()->route('dashboard');
        }

    }
    public function update(SaveAutorRequest $request, Autor $autor){
        try {
            $this->authorize('update', $autor);
            $autor = Autor::findOrFail($request->input('id'));
            $autor->info = $request->input('info');
            $autor->save();
            return redirect()->route('autor.index')->with('status', 'Autor actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('autor.index')->with('status', $th->getMessage());
        }
    }
    public function delete($id){
        try {
            $user = auth()->user();
            $policy = new LibroPolicy();
            if($policy->delete($user)){
                $autor = Autor::findOrFail($id);
                $autor->delete();
                return redirect()->route('autor.index')->with('status', 'Autor eliminado correctamente');
            }else{
                abort(403, 'No tienes permiso para esta operación');
            }
        } catch (\Throwable $th) {
            return redirect()->route('autor.index')->with('status', $th->getMessage());
        }
    }
}
