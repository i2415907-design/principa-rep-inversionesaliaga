<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            if (!Schema::hasColumn('avisos', 'id_admin')) {
                $table->unsignedBigInteger('id_admin')->nullable()->after('fecha_publicacion');
                $table->index('id_admin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('avisos', function (Blueprint $table) {
            if (Schema::hasColumn('avisos', 'id_admin')) {
                $table->dropIndex(['id_admin']);
                $table->dropColumn('id_admin');
            }
        });
    }
};
