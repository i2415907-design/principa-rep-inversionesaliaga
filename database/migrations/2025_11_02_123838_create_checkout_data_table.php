<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('checkout_data', function (Blueprint $table) {
            $table->id();
            $table->string('external_reference')->unique();
            $table->integer('cliente_id');
            $table->json('productos');
            $table->integer('distrito_id')->default(2);
            $table->boolean('recojo_tienda')->default(false);
            $table->string('referencias')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamps();
            
            $table->index('external_reference');
            $table->index('cliente_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkout_data');
    }
};