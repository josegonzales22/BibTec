<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sistema.historial.index');
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
}
