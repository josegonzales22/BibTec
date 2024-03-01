<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autor', function (Blueprint $table) {
            $table->id();
            $table->string('info', 200);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('autor');
    }
};
