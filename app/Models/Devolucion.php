<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
    use HasFactory;
    protected $table = 'devolucion';
    protected $fillable = [
        'idUser', 'idLibro', 'cantidad', 'f_prestamo', 'f_devolucion'
    ];
}
