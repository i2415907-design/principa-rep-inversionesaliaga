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
        Schema::create('carritos', function (Blueprint $table) {
            $table->id();
            // Referenciar a la tabla 'usuarios' y su PK 'id_usuario'
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->enum('estado', ['activo', 'completado', 'abandonado'])->default('activo');
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index(['user_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
