<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🔍 Verificando datos existentes...');
        
        // Verificar categorías
        $categorias = DB::table('categorias')->get();
        $this->command->info('Categorías existentes: ' . $categorias->count());
        foreach($categorias as $cat) {
            $this->command->info("- ID: {$cat->id_categoria}, Nombre: {$cat->nombre_cat}");
        }
        
        // Verificar productos
        $productos = DB::table('productos')->get();
        $this->command->info('Productos existentes: ' . $productos->count());
        
        // Verificar usuarios
        $usuarios = DB::table('usuarios')->get();
        $this->command->info('Usuarios existentes: ' . $usuarios->count());
        
        // Verificar clientes
        $clientes = DB::table('clientes')->get();
        $this->command->info('Clientes existentes: ' . $clientes->count());
        
        // Verificar ventas
        $ventas = DB::table('ventas')->get();
        $this->command->info('Ventas existentes: ' . $ventas->count());
        
        // Verificar pedidos
        $pedidos = DB::table('pedidos')->get();
        $this->command->info('Pedidos existentes: ' . $pedidos->count());
        
        $this->command->info('✅ Verificación completada');
    }
}

