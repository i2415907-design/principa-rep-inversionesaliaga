<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Intentar remover la FK antigua y crear la nueva apuntando a usuarios.id_usuario
        // Usamos sentencias directas para evitar dependencias en DBAL y manejamos excepciones si la FK no existe.
        try {
            DB::statement('ALTER TABLE `carritos` DROP FOREIGN KEY `carritos_user_id_foreign`');
        } catch (\Throwable $e) {
            // No hacer nada si no existe
        }

        try {
            // Asegurar que la columna user_id exista y sea unsigned BIGINT
            // Si es necesario cambiar el tipo, el usuario puede instalar doctrine/dbal y ejecutar el cambio manualmente.
            DB::statement('ALTER TABLE `carritos` MODIFY `user_id` BIGINT UNSIGNED NOT NULL');
        } catch (\Throwable $e) {
            // Ignorar errores de modificación de tipo (si ya tiene el tipo correcto)
        }

        try {
            DB::statement('ALTER TABLE `carritos` ADD CONSTRAINT `carritos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `usuarios`(`id_usuario`) ON DELETE CASCADE');
        } catch (\Throwable $e) {
            // Si no se puede crear la FK, registrar en el log no interrumpe la migración
            info('No se pudo crear FK carritos->usuarios: ' . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            DB::statement('ALTER TABLE `carritos` DROP FOREIGN KEY `carritos_user_id_foreign`');
        } catch (\Throwable $e) {
            // ignore
        }

        try {
            // Restaurar FK original apuntando a users(id)
            DB::statement('ALTER TABLE `carritos` ADD CONSTRAINT `carritos_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE');
        } catch (\Throwable $e) {
            info('No se pudo restaurar FK carritos->users: ' . $e->getMessage());
        }
    }
};
