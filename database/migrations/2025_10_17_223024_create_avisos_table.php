<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('avisos', function (Blueprint $table) {
            $table->id('id_aviso');
            $table->string('titulo', 150);
            $table->text('mensaje');
            $table->enum('tipo', ['oferta', 'alerta', 'informativo'])->default('informativo');
            $table->timestamp('fecha_publicacion')->useCurrent();
            $table->unsignedBigInteger('id_usuario')->nullable(); // Admin que creó el aviso

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avisos');
    }
};
