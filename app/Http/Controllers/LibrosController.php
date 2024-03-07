<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveLibroRequest;
use App\Models\Autor;
use App\Models\Libro;
use App\Models\LibrosAutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibrosController extends Controller
{
    public function index(Request $request){
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
        return view('trabajador.libro.index', ['libros' => $libros2, 'busqueda' => $busqueda]);
    }

    public function registerStore(){
        return view('trabajador.libro.nuevo');
    }
    public function register(SaveLibroRequest $request){
        try {
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
                foreach ($autores as $info) {
                    $autor = Autor::firstOrcreate(['info' => $info]);
                    $autoresIds[] = $autor->id;
                }
                foreach ($autoresIds as $autorId) {
                    LibrosAutor::create(['idLibro' => $libroId,'idAutor' => $autorId]);
                }
                return redirect()->route('libro.index')->with('status', 'Libro registrado correctamente');
            }
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }

    public function edit($id) {
        $libro = Libro::find($id);
        return view('trabajador.libro.editar', compact('libro'));
    }
    public function update(SaveLibroRequest $request, Libro $libro){
        try {
            $libro->titulo = $request->input('titulo');
            $libro->editorial = $request->input('editorial');
            $libro->pub = $request->input('pub');
            $libro->genero = $request->input('genero');
            $libro->numpag = $request->input('numpag');
            $libro->idioma = $request->input('idioma');
            $libro->cantidad = $request->input('cantidad');
            $libro->save();
            return redirect()->route('libro.index')->with('status', 'Libro actualizado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }
    public function delete($id){
        try {
            $libro = Libro::findOrFail($id);
            $libro->delete();
            return redirect()->route('libro.index')->with('status', 'Libro eliminado correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('libro.index')->with('status', $th->getMessage());
        }
    }
}
