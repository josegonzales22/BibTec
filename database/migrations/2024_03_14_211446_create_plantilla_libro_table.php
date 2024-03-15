<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plantilla_libro', function (Blueprint $table) {
            $table->unsignedBigInteger('plantilla_id');
            $table->unsignedBigInteger('libro_id');
            $table->foreign('plantilla_id')->references('id')->on('plantilla')->onDelete('cascade');
            $table->foreign('libro_id')->references('id')->on('libros')->onDelete('cascade');
            $table->primary(['plantilla_id', 'libro_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_libro');
    }
};
