<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamo', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idUser')->unsigned();
            $table->bigInteger('idLibro')->unsigned();
            $table->integer('cantidad');
            $table->date('f_prestamo');
            $table->string('estado');
            $table->timestamps();
            $table->foreign('idLibro')->references('id')->on('libros')->onDelete('cascade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('prestamo');
    }
};
