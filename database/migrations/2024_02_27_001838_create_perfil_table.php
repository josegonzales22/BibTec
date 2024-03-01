<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 10);
            $table->timestamps();
        });
        DB::table('perfil')->insert(['tipo' => 'Trabajador']);
        DB::table('perfil')->insert(['tipo' => 'Estudiante']);
    }
    public function down(): void
    {
        Schema::dropIfExists('perfil');
    }
};
