<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔍 Verificando estados de pedidos...');
        
        $pedidos = DB::table('pedidos')->get(['id_pedido', 'estado_pedido']);
        
        foreach($pedidos as $pedido) {
            $this->command->info("Pedido {$pedido->id_pedido}: {$pedido->estado_pedido}");
        }
        
        $this->command->info('✅ Verificación completada');
    }
}



