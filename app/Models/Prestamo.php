<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $table="prestamo";
    protected $fillable=[
        'idUser',
        'idLibro',
        'cantidad',
        'f_prestamo',
        'estado'
    ];
}
