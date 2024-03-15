<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    use HasFactory;
    protected $table = 'plantilla';
    protected $fillable = ['nombre'];
    public $timestamps = false;
    public function libros(){
        return $this->belongsToMany(Libro::class, 'plantilla_libro');
    }
}
