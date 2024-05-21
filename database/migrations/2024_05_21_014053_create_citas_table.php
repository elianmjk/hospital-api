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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->integer('paciente_id');
            $table->integer('medico_id');
            $table->enum('tipo', ['consulta', 'revision', 'urgencia']);
            $table->enum('estado', ['programada', 'completada', 'cancelada']);
            $table->dateTime('fecha_hora');
        
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
