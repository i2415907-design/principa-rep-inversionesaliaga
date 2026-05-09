-- =============================================
-- CONSULTAS SQL PARA PROBAR EL SISTEMA DE PEDIDOS
-- =============================================

-- 1. Verificar que los datos de prueba existen
SELECT 'PEDIDOS' as tabla, COUNT(*) as cantidad FROM pedidos
UNION ALL
SELECT 'CLIENTES', COUNT(*) FROM clientes
UNION ALL
SELECT 'PRODUCTOS', COUNT(*) FROM productos
UNION ALL
SELECT 'VENTAS', COUNT(*) FROM ventas
UNION ALL
SELECT 'DETALLES_VENTA', COUNT(*) FROM detalles_venta;

-- 2. Ver los pedidos con información completa
SELECT 
    p.id_pedido,
    p.estado_pedido,
    p.total_pedido,
    p.fecha_pedido,
    c.nombre_cliente,
    c.apellido_cliente,
    c.telefono_cliente,
    v.total_venta,
    u.nombre_usuario as encargado
FROM pedidos p
LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
LEFT JOIN ventas v ON p.id_venta = v.id_venta
LEFT JOIN usuarios u ON p.id_encargado = u.id_usuario
ORDER BY p.fecha_pedido DESC;

-- 3. Ver los productos de cada pedido
SELECT 
    p.id_pedido,
    pr.nombre_producto,
    pr.imagen,
    dv.cantidad,
    dv.precio_unitario,
    dv.subtotal
FROM pedidos p
JOIN ventas v ON p.id_venta = v.id_venta
JOIN detalles_venta dv ON v.id_venta = dv.id_venta
JOIN productos pr ON dv.id_producto = pr.id_producto
ORDER BY p.id_pedido, pr.nombre_producto;

-- 4. Verificar usuarios disponibles para asignar como encargados
SELECT 
    id_usuario,
    nombre_usuario,
    rol,
    activo
FROM usuarios 
WHERE rol IN ('vendedor', 'repartidor', 'admin')
AND activo = 1;

-- 5. Consulta para probar la vista de pedidos (simula lo que hace el controlador)
SELECT 
    p.*,
    c.nombre_cliente,
    c.apellido_cliente,
    c.telefono_cliente,
    c.email_cliente,
    c.doc_ident,
    c.direccion_cliente,
    v.total_venta,
    u.nombre_usuario as encargado_nombre
FROM pedidos p
LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
LEFT JOIN ventas v ON p.id_venta = v.id_venta
LEFT JOIN usuarios u ON p.id_encargado = u.id_usuario
ORDER BY p.fecha_pedido DESC;

-- =============================================
-- CONSULTAS PARA CREAR MÁS DATOS DE PRUEBA
-- =============================================

-- Insertar más productos
INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, stock_producto, fecha_registro, id_categoria, imagen, marca) VALUES 
('Auriculares Sony', 'Auriculares inalámbricos con cancelación de ruido', 199.99, 30, NOW(), 14, 'productos/auriculares.jpg', 'Sony'),
('Zapatillas Adidas', 'Zapatillas deportivas para running', 89.99, 75, NOW(), 15, 'productos/zapatillas.jpg', 'Adidas');

-- Insertar más clientes
INSERT INTO clientes (doc_ident, nombre_cliente, apellido_cliente, email_cliente, telefono_cliente, direccion_cliente, fecha_registro) VALUES 
('99887766', 'Laura', 'Martínez', 'laura.martinez@email.com', '944556677', 'Av. Libertad 321, Trujillo', NOW()),
('55443322', 'Roberto', 'Silva', 'roberto.silva@email.com', '933445566', 'Jr. Unión 654, Piura', NOW());

-- =============================================
-- CONSULTAS PARA LIMPIAR DATOS DE PRUEBA
-- =============================================

-- CUIDADO: Estas consultas eliminan todos los datos de prueba
-- DELETE FROM pedidos WHERE id_pedido > 0;
-- DELETE FROM detalles_venta WHERE id_detalle > 0;
-- DELETE FROM ventas WHERE id_venta > 0;
-- DELETE FROM clientes WHERE id_cliente > 0;
-- DELETE FROM productos WHERE id_producto > 0;



