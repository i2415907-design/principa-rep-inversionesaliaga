<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id('id_aviso');
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('tipo')->default('informativo'); // Ej: urgente, informativo, etc.
            $table->date('fecha_publicacion')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
