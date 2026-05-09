<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔧 Verificando y corrigiendo estados...');
        
        // Verificar los estados actuales
        $pedidos = DB::table('pedidos')->get(['id_pedido', 'estado_pedido']);
        
        $this->command->info('Estados actuales:');
        foreach($pedidos as $pedido) {
            $this->command->info("Pedido {$pedido->id_pedido}: {$pedido->estado_pedido}");
        }
        
        // Intentar actualizar a estados válidos
        try {
            DB::statement("UPDATE pedidos SET estado_pedido = 'pendiente' WHERE id_pedido = 7");
            $this->command->info('✅ Pedido 7 actualizado a pendiente');
        } catch (\Exception $e) {
            $this->command->error('❌ Error actualizando pedido 7: ' . $e->getMessage());
        }
        
        try {
            DB::statement("UPDATE pedidos SET estado_pedido = 'enviado' WHERE id_pedido = 8");
            $this->command->info('✅ Pedido 8 actualizado a enviado');
        } catch (\Exception $e) {
            $this->command->error('❌ Error actualizando pedido 8: ' . $e->getMessage());
        }
        
        try {
            DB::statement("UPDATE pedidos SET estado_pedido = 'entregado' WHERE id_pedido = 9");
            $this->command->info('✅ Pedido 9 actualizado a entregado');
        } catch (\Exception $e) {
            $this->command->error('❌ Error actualizando pedido 9: ' . $e->getMessage());
        }
        
        // Verificar los estados finales
        $pedidos = DB::table('pedidos')->get(['id_pedido', 'estado_pedido']);
        
        $this->command->info('Estados finales:');
        foreach($pedidos as $pedido) {
            $this->command->info("Pedido {$pedido->id_pedido}: {$pedido->estado_pedido}");
        }
    }
}



