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

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear categorías
        $categoria1 = Categoria::create([
            'nombre_cat' => 'Electrónicos',
            'descripcion_cat' => 'Dispositivos electrónicos y tecnología'
        ]);

        $categoria2 = Categoria::create([
            'nombre_cat' => 'Ropa',
            'descripcion_cat' => 'Vestimenta y accesorios'
        ]);

        // 2. Crear productos
        $producto1 = Producto::create([
            'nombre_producto' => 'Smartphone Samsung Galaxy',
            'descripcion_producto' => 'Teléfono inteligente con cámara de alta resolución',
            'precio_producto' => 899.99,
            'stock_producto' => 50,
            'fecha_registro' => now(),
            'id_categoria' => $categoria1->id_categoria,
            'imagen' => 'productos/smartphone.jpg',
            'marca' => 'Samsung'
        ]);

        $producto2 = Producto::create([
            'nombre_producto' => 'Laptop HP Pavilion',
            'descripcion_producto' => 'Laptop para trabajo y entretenimiento',
            'precio_producto' => 1299.99,
            'stock_producto' => 25,
            'fecha_registro' => now(),
            'id_categoria' => $categoria1->id_categoria,
            'imagen' => 'productos/laptop.jpg',
            'marca' => 'HP'
        ]);

        $producto3 = Producto::create([
            'nombre_producto' => 'Camiseta Nike',
            'descripcion_producto' => 'Camiseta deportiva de algodón',
            'precio_producto' => 29.99,
            'stock_producto' => 100,
            'fecha_registro' => now(),
            'id_categoria' => $categoria2->id_categoria,
            'imagen' => 'productos/camiseta.jpg',
            'marca' => 'Nike'
        ]);

        // 3. Crear usuarios del sistema (vendedores, repartidores)
        $vendedor1 = Usuario::create([
            'nombre_usuario' => 'Carlos Mendoza',
            'email' => 'carlos@tienda.com',
            'contrasena' => Hash::make('password123'),
            'rol' => 'vendedor',
            'fecha_registro' => now(),
            'activo' => true
        ]);

        $repartidor1 = Usuario::create([
            'nombre_usuario' => 'Ana García',
            'email' => 'ana@tienda.com',
            'contrasena' => Hash::make('password123'),
            'rol' => 'repartidor',
            'fecha_registro' => now(),
            'activo' => true
        ]);

        $admin1 = Usuario::create([
            'nombre_usuario' => 'Admin Principal',
            'email' => 'admin@tienda.com',
            'contrasena' => Hash::make('password123'),
            'rol' => 'admin',
            'fecha_registro' => now(),
            'activo' => true
        ]);

        // 4. Crear clientes (quienes compran)
        $cliente1 = Cliente::create([
            'doc_ident' => '12345678',
            'nombre_cliente' => 'Juan',
            'apellido_cliente' => 'Pérez',
            'email_cliente' => 'juan.perez@email.com',
            'telefono_cliente' => '987654321',
            'direccion_cliente' => 'Av. Principal 123, Lima',
            'fecha_registro' => now()
        ]);

        $cliente2 = Cliente::create([
            'doc_ident' => '87654321',
            'nombre_cliente' => 'María',
            'apellido_cliente' => 'González',
            'email_cliente' => 'maria.gonzalez@email.com',
            'telefono_cliente' => '912345678',
            'direccion_cliente' => 'Jr. Comercio 456, Arequipa',
            'fecha_registro' => now()
        ]);

        $cliente3 = Cliente::create([
            'doc_ident' => '11223344',
            'nombre_cliente' => 'Carlos',
            'apellido_cliente' => 'López',
            'email_cliente' => 'carlos.lopez@email.com',
            'telefono_cliente' => '955667788',
            'direccion_cliente' => 'Calle Real 789, Cusco',
            'fecha_registro' => now()
        ]);

        // 5. Crear ventas
        $venta1 = Venta::create([
            'id_cliente' => $cliente1->id_cliente,
            'id_usuario' => $vendedor1->id_usuario,
            'fecha_venta' => now()->subDays(2),
            'total_venta' => 929.98,
            'tipo' => 'online'
        ]);

        $venta2 = Venta::create([
            'id_cliente' => $cliente2->id_cliente,
            'id_usuario' => $vendedor1->id_usuario,
            'fecha_venta' => now()->subDays(1),
            'total_venta' => 1329.98,
            'tipo' => 'online'
        ]);

        $venta3 = Venta::create([
            'id_cliente' => $cliente3->id_cliente,
            'id_usuario' => $vendedor1->id_usuario,
            'fecha_venta' => now()->subHours(5),
            'total_venta' => 59.98,
            'tipo' => 'online'
        ]);

        // 6. Crear detalles de venta
        DetalleVenta::create([
            'id_venta' => $venta1->id_venta,
            'id_producto' => $producto1->id_producto,
            'cantidad' => 1,
            'precio_unitario' => 899.99,
            'subtotal' => 899.99
        ]);

        DetalleVenta::create([
            'id_venta' => $venta1->id_venta,
            'id_producto' => $producto3->id_producto,
            'cantidad' => 1,
            'precio_unitario' => 29.99,
            'subtotal' => 29.99
        ]);

        DetalleVenta::create([
            'id_venta' => $venta2->id_venta,
            'id_producto' => $producto2->id_producto,
            'cantidad' => 1,
            'precio_unitario' => 1299.99,
            'subtotal' => 1299.99
        ]);

        DetalleVenta::create([
            'id_venta' => $venta2->id_venta,
            'id_producto' => $producto3->id_producto,
            'cantidad' => 1,
            'precio_unitario' => 29.99,
            'subtotal' => 29.99
        ]);

        DetalleVenta::create([
            'id_venta' => $venta3->id_venta,
            'id_producto' => $producto3->id_producto,
            'cantidad' => 2,
            'precio_unitario' => 29.99,
            'subtotal' => 59.98
        ]);

        // 7. Crear pedidos
        Pedido::create([
            'id_venta' => $venta1->id_venta,
            'estado_pedido' => 'pendiente',
            'total_pedido' => 929.98,
            'fecha_pedido' => now()->subDays(2),
            'fecha_entrega_estimada' => now()->addDays(3),
            'id_distrito' => 1,
            'referencia_ped' => 'Cerca del parque central',
            'codigo_postal' => '15001',
            'id_cliente' => $cliente1->id_cliente,
            'recojo_tienda' => false,
            'id_encargado' => null
        ]);

        Pedido::create([
            'id_venta' => $venta2->id_venta,
            'estado_pedido' => 'Procesando',
            'total_pedido' => 1329.98,
            'fecha_pedido' => now()->subDays(1),
            'fecha_entrega_estimada' => now()->addDays(2),
            'id_distrito' => 2,
            'referencia_ped' => 'Casa con portón azul',
            'codigo_postal' => '04001',
            'id_cliente' => $cliente2->id_cliente,
            'recojo_tienda' => false,
            'id_encargado' => $repartidor1->id_usuario
        ]);

        Pedido::create([
            'id_venta' => $venta3->id_venta,
            'estado_pedido' => 'enviado',
            'total_pedido' => 59.98,
            'fecha_pedido' => now()->subHours(5),
            'fecha_entrega_estimada' => now()->addDays(1),
            'id_distrito' => 3,
            'referencia_ped' => 'Oficina en el segundo piso',
            'codigo_postal' => '08001',
            'id_cliente' => $cliente3->id_cliente,
            'recojo_tienda' => false,
            'id_encargado' => $repartidor1->id_usuario
        ]);

        $this->command->info('✅ Datos de prueba creados exitosamente!');
        $this->command->info('📊 Resumen:');
        $this->command->info('- 3 Categorías creadas');
        $this->command->info('- 3 Productos creados');
        $this->command->info('- 3 Usuarios del sistema (vendedor, repartidor, admin)');
        $this->command->info('- 3 Clientes creados');
        $this->command->info('- 3 Ventas creadas');
        $this->command->info('- 3 Pedidos creados con diferentes estados');
    }
}