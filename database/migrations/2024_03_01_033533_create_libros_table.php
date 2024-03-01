<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 100);
            $table->string('editorial', 100);
            $table->year('pub');
            $table->string('genero', 50);
            $table->integer('numpag');
            $table->string('idioma', 50);
            $table->integer('cantidad');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
