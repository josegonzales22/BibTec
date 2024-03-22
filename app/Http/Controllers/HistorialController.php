<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use App\Policies\HistorialPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $policy = new HistorialPolicy;
        if($policy->read($user)){
            $busqueda = $request->busquedaInput;
            $resultados = DB::table('bibtec.historial as H')
            ->select(DB::raw("H.id, CONCAT(U.nombres, ' ', U.apellidos) AS usuario"), 'H.fecha', 'H.operacion', 'L.titulo')
            ->join('bibtec.users as U', 'H.user_id', '=', 'U.id')
            ->leftJoin('bibtec.libros as L', 'H.libro_id', '=', 'L.id')
            ->where(function ($query) use ($busqueda) {
                $query->where('H.id', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('U.nombres', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('U.apellidos', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('H.fecha', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('H.operacion', 'LIKE', '%'.$busqueda.'%')
                    ->orWhere('L.titulo', 'LIKE', '%'.$busqueda.'%');
            })
            ->groupBy('H.id')
            ->orderByDesc('H.id')
            ->paginate(5);
            return view('sistema.historial.index', ['resultados' => $resultados, 'busqueda' => $busqueda]);
        }else{
            return redirect()->route('dashboard');
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store($user_id, $fecha, $operacion, $libro_id)
    {
        DB::beginTransaction();
            Historial::create([
                'user_id' => $user_id,
                'fecha' => $fecha,
                'operacion' => $operacion,
                'libro_id' => $libro_id
            ]);
        DB::commit();
    }
    public function checkTableHistorialIsNotEmpty(){
        try {
            $cant = DB::table('historial')->count();
            if($cant>0){return true;}
            else {return false;}
        } catch (\Throwable $th) {
            return false;
        }
    }
    public function exportCSVInfo($op){
        $user = auth()->user();
        $policy = new HistorialPolicy;
        if($policy->read($user)){
            $resultados = "";
            switch ($op) {
                case '1':
                    $resultados = $this->exportarUsuarios();
                    $filename = 'usuarios.csv';
                    break;
                case '2':
                    $resultados = $this->exportarHistorial();
                    $filename = 'historial.csv';
                    break;
                case '3':
                    $resultados = $this->exportarLibros();
                    $filename = 'libros.csv';
                    break;
                case '4':
                    $resultados = $this->exportarPrestamos();
                    $filename = 'prestamos.csv';
                    break;
                case '5':
                    $resultados = $this->exportarDevoluciones();
                    $filename = 'devoluciones.csv';
                    break;
                default:
                    abort(404, 'Opción no válida');
                    break;
            }
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];
            return response()->streamDownload(
                function () use ($resultados) {
                    echo $resultados;
                },
                $filename,
                $headers
            );
        }else{
            abort(403, 'No tienes permiso para esta operación');
        }
    }
    public function exportarUsuarios(){
        $resultados = DB::table('users AS U')
        ->select('U.dni', 'U.nombres', 'U.apellidos', 'U.email', 'R.name AS Rol')
        ->join('users_roles AS UR', 'U.id', '=', 'UR.user_id')
        ->join('roles AS R', 'UR.role_id', '=', 'R.id')
        ->get();
        $headers = ['DNI', 'Nombres', 'Apellidos', 'Email', 'Rol'];
        $csv = $this->convertToCSV($resultados, $headers);
        return $csv;
    }
    public function exportarHistorial(){
        $resultados = DB::table('historial as H')
        ->select(DB::raw("CONCAT(U.nombres, ' ', U.apellidos) AS usuario"), 'H.fecha', 'H.operacion', 'L.titulo')
        ->join('users as U', 'H.user_id', '=', 'U.id')
        ->leftJoin('libros as L', 'H.libro_id', '=', 'L.id')
        ->get();
        $headers = ['Usuario', 'Fecha', 'Operación', 'Libro'];
        $csv = $this->convertToCSV($resultados, $headers);
        return $csv;
    }
    public function exportarLibros(){
        $resultados = DB::table('libros AS L')
        ->select('L.titulo', 'L.editorial', 'L.pub AS Publicación', 'L.genero AS Género', 'L.numpag AS Páginas', 'L.idioma AS Idioma', 'L.cantidad AS Stock', DB::raw('GROUP_CONCAT(A.info SEPARATOR \'; \') AS Autores'))
        ->join('libros_autor AS LA', 'L.id', '=', 'LA.idLibro')
        ->join('autor AS A', 'LA.idAutor', '=', 'A.id')
        ->groupBy('L.id')
        ->get();
        $headers = ['Título', 'Editorial', 'Publicación', 'Género', 'Páginas', 'Idioma', 'Stock', 'Autor(es)'];
        $csv = $this->convertToCSV($resultados, $headers);
        return $csv;
    }
    public function exportarPrestamos(){
        $resultados = DB::table('prestamo AS P')
        ->select(DB::raw("CONCAT(U.nombres, ' ', U.apellidos) AS Usuario"), 'L.titulo', 'P.cantidad', 'P.f_prestamo', 'P.estado')
        ->join('users AS U', 'P.idUser', '=', 'U.id')
        ->join('libros AS L', 'P.idLibro', '=', 'L.id')
        ->get();
        $headers = ['Usuario', 'Libro', 'Cantidad', 'Préstamo', 'Estado'];
        $csv = $this->convertToCSV($resultados, $headers);
        return $csv;
    }
    public function exportarDevoluciones(){
        $resultados = DB::table('devolucion AS D')
        ->select(DB::raw("CONCAT(U.nombres, ' ', U.apellidos) AS Usuario"), 'L.titulo AS Libro', 'D.cantidad', 'D.f_prestamo AS Préstamo', 'D.f_devolucion AS Devolución')
        ->join('users AS U', 'D.idUser', '=', 'U.id')
        ->join('libros AS L', 'D.idLibro', '=', 'L.id')
        ->get();
        $headers = ['Usuario', 'Libro', 'Cantidad', 'Préstamo', 'Devolución'];
        $csv = $this->convertToCSV($resultados, $headers);
        return $csv;
    }
    public function convertToCSV($data, $headers = []){
        $output = fopen('php://temp', 'w');
        fputs($output, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        fputcsv($output, $headers);
        foreach ($data as $row) {
            fputcsv($output, (array)$row);
        }
        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);
        return $csv;
    }
}
