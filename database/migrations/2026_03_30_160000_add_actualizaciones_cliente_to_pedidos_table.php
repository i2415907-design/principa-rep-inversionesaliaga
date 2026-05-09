<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (!Schema::hasColumn('pedidos', 'actualizaciones_cliente')) {
                $table->unsignedTinyInteger('actualizaciones_cliente')->default(0)->after('id_encargado');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            if (Schema::hasColumn('pedidos', 'actualizaciones_cliente')) {
                $table->dropColumn('actualizaciones_cliente');
            }
        });
    }
};
