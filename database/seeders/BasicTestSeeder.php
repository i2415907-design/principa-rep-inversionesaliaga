<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasicTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar datos existentes
        DB::statement("DELETE FROM pedidos");
        DB::statement("DELETE FROM detalles_venta");
        DB::statement("DELETE FROM ventas");
        DB::statement("DELETE FROM clientes");
        DB::statement("DELETE FROM productos");
        DB::statement("DELETE FROM categorias");
        DB::statement("DELETE FROM usuarios WHERE rol IN ('vendedor', 'repartidor', 'admin')");

        // 1. Crear categorías
        DB::statement("INSERT INTO categorias (nombre_cat, descripcion_cat) VALUES 
            ('Electrónicos', 'Dispositivos electrónicos y tecnología'),
            ('Ropa', 'Vestimenta y accesorios')");

        // 2. Crear productos
        DB::statement("INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, stock_producto, fecha_registro, id_categoria, imagen, marca) VALUES 
            ('Smartphone Samsung Galaxy', 'Teléfono inteligente con cámara de alta resolución', 899.99, 50, NOW(), 1, 'productos/smartphone.jpg', 'Samsung'),
            ('Laptop HP Pavilion', 'Laptop para trabajo y entretenimiento', 1299.99, 25, NOW(), 1, 'productos/laptop.jpg', 'HP'),
            ('Camiseta Nike', 'Camiseta deportiva de algodón', 29.99, 100, NOW(), 2, 'productos/camiseta.jpg', 'Nike')");

        // 3. Crear usuarios
        DB::statement("INSERT INTO usuarios (nombre_usuario, email, contrasena, rol, fecha_registro, activo) VALUES 
            ('Carlos Mendoza', 'carlos@tienda.com', 'password123', 'vendedor', NOW(), 1),
            ('Ana García', 'ana@tienda.com', 'password123', 'repartidor', NOW(), 1),
            ('Admin Principal', 'admin@tienda.com', 'password123', 'admin', NOW(), 1)");

        // 4. Crear clientes
        DB::statement("INSERT INTO clientes (doc_ident, nombre_cliente, apellido_cliente, email_cliente, telefono_cliente, direccion_cliente, fecha_registro) VALUES 
            ('12345678', 'Juan', 'Pérez', 'juan.perez@email.com', '987654321', 'Av. Principal 123, Lima', NOW()),
            ('87654321', 'María', 'González', 'maria.gonzalez@email.com', '912345678', 'Jr. Comercio 456, Arequipa', NOW()),
            ('11223344', 'Carlos', 'López', 'carlos.lopez@email.com', '955667788', 'Calle Real 789, Cusco', NOW())");

        // 5. Crear ventas
        DB::statement("INSERT INTO ventas (id_cliente, id_usuario, fecha_venta, total_venta, tipo) VALUES 
            (1, 1, DATE_SUB(NOW(), INTERVAL 2 DAY), 929.98, 'online'),
            (2, 1, DATE_SUB(NOW(), INTERVAL 1 DAY), 1329.98, 'online'),
            (3, 1, DATE_SUB(NOW(), INTERVAL 5 HOUR), 59.98, 'online')");

        // 6. Crear detalles de venta
        DB::statement("INSERT INTO detalles_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES 
            (1, 1, 1, 899.99, 899.99),
            (1, 3, 1, 29.99, 29.99),
            (2, 2, 1, 1299.99, 1299.99),
            (2, 3, 1, 29.99, 29.99),
            (3, 3, 2, 29.99, 59.98)");

        // 7. Crear pedidos
        DB::statement("INSERT INTO pedidos (id_venta, estado_pedido, total_pedido, fecha_pedido, fecha_entrega_estimada, id_distrito, referencia_ped, codigo_postal, id_cliente, recojo_tienda, id_encargado) VALUES 
            (1, 'pendiente', 929.98, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 3 DAY), 1, 'Cerca del parque central', '15001', 1, 0, NULL),
            (2, 'Procesando', 1329.98, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 2 DAY), 2, 'Casa con portón azul', '04001', 2, 0, 2),
            (3, 'enviado', 59.98, DATE_SUB(NOW(), INTERVAL 5 HOUR), DATE_ADD(NOW(), INTERVAL 1 DAY), 3, 'Oficina en el segundo piso', '08001', 3, 0, 2)");

        $this->command->info('✅ Datos de prueba básicos creados exitosamente!');
        $this->command->info('📊 Resumen:');
        $this->command->info('- 2 Categorías creadas');
        $this->command->info('- 3 Productos creados');
        $this->command->info('- 3 Usuarios del sistema (vendedor, repartidor, admin)');
        $this->command->info('- 3 Clientes creados');
        $this->command->info('- 3 Ventas creadas');
        $this->command->info('- 3 Pedidos creados con diferentes estados');
        $this->command->info('');
        $this->command->info('🔑 Credenciales de prueba:');
        $this->command->info('- Vendedor: carlos@tienda.com / password123');
        $this->command->info('- Repartidor: ana@tienda.com / password123');
        $this->command->info('- Admin: admin@tienda.com / password123');
    }
}

