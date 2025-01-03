<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained()->onDelete('cascade');
            $table->foreignId('questionario_id')->constrained()->onDelete('cascade');
            $table->integer('pontuacao');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('resultados');
    }
};
