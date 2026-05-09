<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_device_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->string('token', 255)->unique();
            $table->string('platform', 20)->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();

            $table->index('id_usuario');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_device_tokens');
    }
};