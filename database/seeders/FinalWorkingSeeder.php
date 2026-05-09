<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinalWorkingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🚀 Creando datos de prueba...');
        
        // Limpiar datos existentes de prueba
        DB::statement("DELETE FROM pedidos WHERE id_pedido > 0");
        DB::statement("DELETE FROM detalles_venta WHERE id_detalle > 0");
        DB::statement("DELETE FROM ventas WHERE id_venta > 0");
        DB::statement("DELETE FROM clientes WHERE id_cliente > 0");
        DB::statement("DELETE FROM productos WHERE id_producto > 0");

        // 1. Crear productos usando las categorías existentes (ID 14 y 15)
        DB::statement("INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, stock_producto, fecha_registro, id_categoria, imagen, marca) VALUES 
            ('Smartphone Samsung Galaxy', 'Teléfono inteligente con cámara de alta resolución', 899.99, 50, NOW(), 14, 'productos/smartphone.jpg', 'Samsung'),
            ('Laptop HP Pavilion', 'Laptop para trabajo y entretenimiento', 1299.99, 25, NOW(), 14, 'productos/laptop.jpg', 'HP'),
            ('Camiseta Nike', 'Camiseta deportiva de algodón', 29.99, 100, NOW(), 15, 'productos/camiseta.jpg', 'Nike')");

        // 2. Crear clientes
        DB::statement("INSERT INTO clientes (doc_ident, nombre_cliente, apellido_cliente, email_cliente, telefono_cliente, direccion_cliente, fecha_registro) VALUES 
            ('12345678', 'Juan', 'Pérez', 'juan.perez@email.com', '987654321', 'Av. Principal 123, Lima', NOW()),
            ('87654321', 'María', 'González', 'maria.gonzalez@email.com', '912345678', 'Jr. Comercio 456, Arequipa', NOW()),
            ('11223344', 'Carlos', 'López', 'carlos.lopez@email.com', '955667788', 'Calle Real 789, Cusco', NOW())");

        // Obtener IDs creados
        $producto1 = DB::table('productos')->where('nombre_producto', 'Smartphone Samsung Galaxy')->first();
        $producto2 = DB::table('productos')->where('nombre_producto', 'Laptop HP Pavilion')->first();
        $producto3 = DB::table('productos')->where('nombre_producto', 'Camiseta Nike')->first();
        
        // Usar un usuario existente (el primero que encontremos)
        $usuario = DB::table('usuarios')->first();
        
        $cliente1 = DB::table('clientes')->where('doc_ident', '12345678')->first();
        $cliente2 = DB::table('clientes')->where('doc_ident', '87654321')->first();
        $cliente3 = DB::table('clientes')->where('doc_ident', '11223344')->first();

        // 3. Crear ventas
        DB::statement("INSERT INTO ventas (id_cliente, id_usuario, fecha_venta, total_venta) VALUES 
            ({$cliente1->id_cliente}, {$usuario->id_usuario}, DATE_SUB(NOW(), INTERVAL 2 DAY), 929.98),
            ({$cliente2->id_cliente}, {$usuario->id_usuario}, DATE_SUB(NOW(), INTERVAL 1 DAY), 1329.98),
            ({$cliente3->id_cliente}, {$usuario->id_usuario}, DATE_SUB(NOW(), INTERVAL 5 HOUR), 59.98)");

        // Obtener las ventas creadas
        $venta1 = DB::table('ventas')->where('id_cliente', $cliente1->id_cliente)->first();
        $venta2 = DB::table('ventas')->where('id_cliente', $cliente2->id_cliente)->first();
        $venta3 = DB::table('ventas')->where('id_cliente', $cliente3->id_cliente)->first();

        // 4. Crear detalles de venta
        DB::statement("INSERT INTO detalles_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES 
            ({$venta1->id_venta}, {$producto1->id_producto}, 1, 899.99, 899.99),
            ({$venta1->id_venta}, {$producto3->id_producto}, 1, 29.99, 29.99),
            ({$venta2->id_venta}, {$producto2->id_producto}, 1, 1299.99, 1299.99),
            ({$venta2->id_venta}, {$producto3->id_producto}, 1, 29.99, 29.99),
            ({$venta3->id_venta}, {$producto3->id_producto}, 2, 29.99, 59.98)");

        // 5. Verificar distritos existentes
        $distritos = DB::table('distrito')->get();
        $this->command->info('Distritos existentes: ' . $distritos->count());
        
        if ($distritos->count() > 0) {
            $distritoId = $distritos->first()->id_distrito;
            $this->command->info("Usando distrito ID: {$distritoId}");
        } else {
            // Crear un distrito por defecto
            DB::statement("INSERT INTO distrito (id_distrito) VALUES (1)");
            $distritoId = 1;
            $this->command->info("Creado distrito por defecto con ID: {$distritoId}");
        }

        // 6. Crear pedidos
        DB::statement("INSERT INTO pedidos (id_venta, estado_pedido, total_pedido, fecha_pedido, fecha_entrega_estimada, id_distrito, referencia_ped, codigo_postal, id_cliente, recojo_tienda, id_encargado) VALUES 
            ({$venta1->id_venta}, 'pendiente', 929.98, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 3 DAY), {$distritoId}, 'Cerca del parque central', '15001', {$cliente1->id_cliente}, 0, NULL),
            ({$venta2->id_venta}, 'Procesando', 1329.98, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 2 DAY), {$distritoId}, 'Casa con portón azul', '04001', {$cliente2->id_cliente}, 0, NULL),
            ({$venta3->id_venta}, 'enviado', 59.98, DATE_SUB(NOW(), INTERVAL 5 HOUR), DATE_ADD(NOW(), INTERVAL 1 DAY), {$distritoId}, 'Oficina en el segundo piso', '08001', {$cliente3->id_cliente}, 0, NULL)");

        $this->command->info('✅ Datos de prueba creados exitosamente!');
        $this->command->info('📊 Resumen:');
        $this->command->info('- 3 Productos creados');
        $this->command->info('- 3 Clientes creados');
        $this->command->info('- 3 Ventas creadas');
        $this->command->info('- 3 Pedidos creados con diferentes estados');
        $this->command->info('');
        $this->command->info('🌐 Para probar la vista, ve a: /admin/pedidos');
        $this->command->info('💡 Los pedidos aparecerán como tarjetas con imágenes de productos');
    }
}

