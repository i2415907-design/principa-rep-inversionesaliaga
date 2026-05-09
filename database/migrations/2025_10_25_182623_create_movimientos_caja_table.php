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
Schema::create('movimientos_caja', function (Blueprint $table) {
    $table->id('id_movimiento'); 
    $table->enum('tipo', ['ingreso', 'egreso']);
    $table->decimal('monto', 10, 2);
    $table->string('concepto', 255);
    $table->date('fecha');
    
    // CAMBIO CLAVE: Usamos unsignedInteger para coincidir con la PK de tu tabla 'usuarios'
    $table->unsignedInteger('id_usuario'); 
    
    // Definición de la llave foránea
    $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
    
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos_caja');
    }
};
