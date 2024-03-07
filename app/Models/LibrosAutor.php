<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibrosAutor extends Model
{
    use HasFactory;
    protected $table = 'libros_autor';
    protected $fillable = ['idLibro', 'idAutor'];
    public $timestamps = false;
}
