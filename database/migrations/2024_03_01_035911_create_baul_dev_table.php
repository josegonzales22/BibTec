<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baul_dev', function (Blueprint $table) {
            $table->bigInteger('idUser')->unsigned();
            $table->bigInteger('idPres')->unsigned();
            $table->foreign('idPres')->references('id')->on('prestamo')->onDelete('cascade');
            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('baul_dev');
    }
};
