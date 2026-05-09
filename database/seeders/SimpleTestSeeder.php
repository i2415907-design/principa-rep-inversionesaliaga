<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Pedido;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SimpleTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usar SQL directo para evitar problemas con ENUMs
        DB::statement("INSERT INTO categorias (nombre_cat, descripcion_cat) VALUES 
            ('Electrónicos', 'Dispositivos electrónicos y tecnología'),
            ('Ropa', 'Vestimenta y accesorios')");

        // Obtener las categorías creadas
        $categoria1 = DB::table('categorias')->where('nombre_cat', 'Electrónicos')->first();
        $categoria2 = DB::table('categorias')->where('nombre_cat', 'Ropa')->first();

        // Insertar productos
        DB::statement("INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, stock_producto, fecha_registro, id_categoria, imagen, marca) VALUES 
            ('Smartphone Samsung Galaxy', 'Teléfono inteligente con cámara de alta resolución', 899.99, 50, NOW(), {$categoria1->id_categoria}, 'productos/smartphone.jpg', 'Samsung'),
            ('Laptop HP Pavilion', 'Laptop para trabajo y entretenimiento', 1299.99, 25, NOW(), {$categoria1->id_categoria}, 'productos/laptop.jpg', 'HP'),
            ('Camiseta Nike', 'Camiseta deportiva de algodón', 29.99, 100, NOW(), {$categoria2->id_categoria}, 'productos/camiseta.jpg', 'Nike')");

        // Obtener los productos creados
        $producto1 = DB::table('productos')->where('nombre_producto', 'Smartphone Samsung Galaxy')->first();
        $producto2 = DB::table('productos')->where('nombre_producto', 'Laptop HP Pavilion')->first();
        $producto3 = DB::table('productos')->where('nombre_producto', 'Camiseta Nike')->first();

        // Insertar usuarios (usando valores que sabemos que funcionan)
        DB::statement("INSERT INTO usuarios (nombre_usuario, email, contrasena, rol, fecha_registro, activo) VALUES 
            ('Carlos Mendoza', 'carlos@tienda.com', '$2y$12$tM5aNfQEkmu9/TZgptDeme8/0sFzG26hrvX4vTLZnx0rp0Oc6xJAe', 'vendedor', NOW(), 1),
            ('Ana García', 'ana@tienda.com', '$2y$12$tM5aNfQEkmu9/TZgptDeme8/0sFzG26hrvX4vTLZnx0rp0Oc6xJAe', 'repartidor', NOW(), 1),
            ('Admin Principal', 'admin@tienda.com', '$2y$12$tM5aNfQEkmu9/TZgptDeme8/0sFzG26hrvX4vTLZnx0rp0Oc6xJAe', 'admin', NOW(), 1)");

        // Obtener los usuarios creados
        $vendedor1 = DB::table('usuarios')->where('nombre_usuario', 'Carlos Mendoza')->first();
        $repartidor1 = DB::table('usuarios')->where('nombre_usuario', 'Ana García')->first();

        // Insertar clientes
        DB::statement("INSERT INTO clientes (doc_ident, nombre_cliente, apellido_cliente, email_cliente, telefono_cliente, direccion_cliente, fecha_registro) VALUES 
            ('12345678', 'Juan', 'Pérez', 'juan.perez@email.com', '987654321', 'Av. Principal 123, Lima', NOW()),
            ('87654321', 'María', 'González', 'maria.gonzalez@email.com', '912345678', 'Jr. Comercio 456, Arequipa', NOW()),
            ('11223344', 'Carlos', 'López', 'carlos.lopez@email.com', '955667788', 'Calle Real 789, Cusco', NOW())");

        // Obtener los clientes creados
        $cliente1 = DB::table('clientes')->where('doc_ident', '12345678')->first();
        $cliente2 = DB::table('clientes')->where('doc_ident', '87654321')->first();
        $cliente3 = DB::table('clientes')->where('doc_ident', '11223344')->first();

        // Insertar ventas
        DB::statement("INSERT INTO ventas (id_cliente, id_usuario, fecha_venta, total_venta, tipo) VALUES 
            ({$cliente1->id_cliente}, {$vendedor1->id_usuario}, DATE_SUB(NOW(), INTERVAL 2 DAY), 929.98, 'online'),
            ({$cliente2->id_cliente}, {$vendedor1->id_usuario}, DATE_SUB(NOW(), INTERVAL 1 DAY), 1329.98, 'online'),
            ({$cliente3->id_cliente}, {$vendedor1->id_usuario}, DATE_SUB(NOW(), INTERVAL 5 HOUR), 59.98, 'online')");

        // Obtener las ventas creadas
        $venta1 = DB::table('ventas')->where('id_cliente', $cliente1->id_cliente)->first();
        $venta2 = DB::table('ventas')->where('id_cliente', $cliente2->id_cliente)->first();
        $venta3 = DB::table('ventas')->where('id_cliente', $cliente3->id_cliente)->first();

        // Insertar detalles de venta
        DB::statement("INSERT INTO detalles_venta (id_venta, id_producto, cantidad, precio_unitario, subtotal) VALUES 
            ({$venta1->id_venta}, {$producto1->id_producto}, 1, 899.99, 899.99),
            ({$venta1->id_venta}, {$producto3->id_producto}, 1, 29.99, 29.99),
            ({$venta2->id_venta}, {$producto2->id_producto}, 1, 1299.99, 1299.99),
            ({$venta2->id_venta}, {$producto3->id_producto}, 1, 29.99, 29.99),
            ({$venta3->id_venta}, {$producto3->id_producto}, 2, 29.99, 59.98)");

        // Insertar pedidos
        DB::statement("INSERT INTO pedidos (id_venta, estado_pedido, total_pedido, fecha_pedido, fecha_entrega_estimada, id_distrito, referencia_ped, codigo_postal, id_cliente, recojo_tienda, id_encargado) VALUES 
            ({$venta1->id_venta}, 'pendiente', 929.98, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 3 DAY), 1, 'Cerca del parque central', '15001', {$cliente1->id_cliente}, 0, NULL),
            ({$venta2->id_venta}, 'Procesando', 1329.98, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 2 DAY), 2, 'Casa con portón azul', '04001', {$cliente2->id_cliente}, 0, {$repartidor1->id_usuario}),
            ({$venta3->id_venta}, 'enviado', 59.98, DATE_SUB(NOW(), INTERVAL 5 HOUR), DATE_ADD(NOW(), INTERVAL 1 DAY), 3, 'Oficina en el segundo piso', '08001', {$cliente3->id_cliente}, 0, {$repartidor1->id_usuario})");

        $this->command->info('✅ Datos de prueba creados exitosamente!');
        $this->command->info('📊 Resumen:');
        $this->command->info('- 2 Categorías creadas');
        $this->command->info('- 3 Productos creados');
        $this->command->info('- 3 Usuarios del sistema (vendedor, repartidor, admin)');
        $this->command->info('- 3 Clientes creados');
        $this->command->info('- 3 Ventas creadas');
        $this->command->info('- 3 Pedidos creados con diferentes estados');
    }
}

