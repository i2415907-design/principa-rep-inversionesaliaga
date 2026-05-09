<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔄 Actualizando estados de pedidos...');
        
        // Usar SQL directo para evitar problemas con ENUMs
        DB::statement("UPDATE pedidos SET estado_pedido = 'pendiente' WHERE id_pedido = 7");
        DB::statement("UPDATE pedidos SET estado_pedido = 'enviado' WHERE id_pedido = 8");
        DB::statement("UPDATE pedidos SET estado_pedido = 'entregado' WHERE id_pedido = 9");
        
        $this->command->info('✅ Estados actualizados');
        
        // Verificar los estados
        $pedidos = DB::table('pedidos')->get(['id_pedido', 'estado_pedido']);
        
        foreach($pedidos as $pedido) {
            $this->command->info("Pedido {$pedido->id_pedido}: {$pedido->estado_pedido}");
        }
    }
}



