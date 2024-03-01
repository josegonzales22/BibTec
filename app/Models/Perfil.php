<?php
// app/Models/Profile.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = "perfil";
    protected $fillable = ['tipo'];
}
