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
        Schema::create('carrito_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carritos')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id'); // Referencia a id_producto
            $table->integer('cantidad')->default(1);
            $table->decimal('precio', 10, 2);
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index(['carrito_id', 'producto_id']);
            $table->unique(['carrito_id', 'producto_id']); // Evitar duplicados
            
            // No agregamos foreign key por ahora para evitar problemas
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_items');
    }
};
