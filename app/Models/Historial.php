<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;
    protected $table = 'historial';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'fecha',
        'operacion',
        'libro_id'
    ];
}
