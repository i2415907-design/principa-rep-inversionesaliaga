<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkingStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔄 Configurando estados de pedidos...');
        
        // Usar solo los estados que funcionan
        DB::statement("UPDATE pedidos SET estado_pedido = 'pendiente' WHERE id_pedido = 7");
        DB::statement("UPDATE pedidos SET estado_pedido = 'pendiente' WHERE id_pedido = 8");
        DB::statement("UPDATE pedidos SET estado_pedido = 'entregado' WHERE id_pedido = 9");
        
        $this->command->info('✅ Estados configurados');
        
        // Verificar los estados
        $pedidos = DB::table('pedidos')->get(['id_pedido', 'estado_pedido']);
        
        $this->command->info('Estados finales:');
        foreach($pedidos as $pedido) {
            $this->command->info("Pedido {$pedido->id_pedido}: {$pedido->estado_pedido}");
        }
        
        $this->command->info('');
        $this->command->info('💡 Nota: Solo se pueden usar los estados que están definidos en el ENUM de la base de datos');
        $this->command->info('🌐 Ve a /admin/pedidos para probar el sistema');
    }
}



