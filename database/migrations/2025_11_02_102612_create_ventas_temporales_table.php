<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_ventas_temporales_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventas_temporales', function (Blueprint $table) {
            $table->id();
            $table->string('external_reference')->unique();
            $table->unsignedBigInteger('cliente_id');
            $table->json('productos');
            $table->decimal('total', 10, 2);
            $table->json('datos_cliente');
            $table->string('distrito_id')->nullable();
            $table->boolean('recojo_tienda')->default(false);
            $table->timestamps();
            
            $table->index('external_reference');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas_temporales');
    }
};