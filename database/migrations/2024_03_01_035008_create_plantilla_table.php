<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plantilla', function (Blueprint $table) {
            $table->id();
            $table->integer('idTemp');
            $table->string('nombre', 50);
            $table->bigInteger('idLibro')->unsigned();
            $table->timestamps();
            $table->foreign('idLibro')->references('id')->on('libros')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('plantilla');
    }
};
