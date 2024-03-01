<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('libros_autor', function (Blueprint $table) {
            $table->bigInteger('idLibro')->unsigned();
            $table->bigInteger('idAutor')->unsigned();
            $table->foreign('idLibro')->references('id')->on('libros')->onDelete('cascade');
            $table->foreign('idAutor')->references('id')->on('autor')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('libros_autor');
    }
};
