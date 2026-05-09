<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Venta;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleVenta;

class ReporteController extends Controller
{
    public function index()
    {
        return view('admin.reportes');
    }

    // 🔥 REPORTE DE PEDIDOS
    public function obtenerPedidos(Request $request)
    {
        $query = Pedido::with(['venta', 'cliente', 'distrito'])
            ->select('pedidos.*');

        // Filtros
        if ($request->fecha) {
            $query->whereDate('pedidos.fecha_pedido', $request->fecha);
        }

        if ($request->estado) {
            $query->where('pedidos.estado_pedido', $request->estado);
        }

        if ($request->cliente) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nombre_cliente', 'like', "%{$request->cliente}%")
                  ->orWhere('apellido_cliente', 'like', "%{$request->cliente}%");
            });
        }

        $pedidos = $query->orderBy('pedidos.fecha_pedido', 'desc')->get();

        return response()->json([
            'success' => true,
            'pedidos' => $pedidos->map(function($pedido) {
                return [
                    'codigo' => $pedido->id_pedido,
                    'cliente' => $pedido->cliente ? 
                        "{$pedido->cliente->nombre_cliente} {$pedido->cliente->apellido_cliente}" : 
                        'N/A',
                    'detalles' => $this->obtenerDetallesPedido($pedido->id_venta),
                    'fecha_pedido' => $pedido->fecha_pedido,
                    'fecha_entrega' => $pedido->fecha_entrega_estimada,
                    'estado' => $pedido->estado_pedido,
                    'monto_total' => $pedido->total_pedido,
                    'distrito' => $pedido->distrito ? $pedido->distrito->nombre_distr : 'N/A',
                    'recojo_tienda' => $pedido->recojo_tienda ? 'Sí' : 'No'
                ];
            })
        ]);
    }

    // 🔥 REPORTE DE VENTAS
    public function obtenerVentas(Request $request)
    {
        $query = Venta::with(['cliente', 'detalles.producto', 'usuario'])
            ->where('tipo', 'venta');

        if ($request->fecha) {
            $query->whereDate('fecha_venta', $request->fecha);
        }

        if ($request->cliente) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nombre_cliente', 'like', "%{$request->cliente}%")
                  ->orWhere('apellido_cliente', 'like', "%{$request->cliente}%");
            });
        }

        if ($request->producto) {
            $query->whereHas('detalles.producto', function($q) use ($request) {
                $q->where('nombre_producto', 'like', "%{$request->producto}%");
            });
        }

        $ventas = $query->orderBy('fecha_venta', 'desc')->get();

        return response()->json([
            'success' => true,
            'ventas' => $ventas->map(function($venta) {
                $productos = $venta->detalles->map(function($detalle) {
                    return "{$detalle->producto->nombre_producto} (x{$detalle->cantidad})";
                })->implode(', ');

                return [
                    'fecha' => $venta->fecha_venta,
                    'codigo' => "V-{$venta->id_venta}",
                    'cliente' => $venta->cliente ? 
                        "{$venta->cliente->nombre_cliente} {$venta->cliente->apellido_cliente}" : 
                        'N/A',
                    'producto' => $productos,
                    'cantidad' => $venta->detalles->sum('cantidad'),
                    'total' => $venta->total_venta,
                    'vendedor' => $venta->usuario ? $venta->usuario->nombre_usuario : 'N/A',
                    'estado' => $venta->estado_venta
                ];
            })
        ]);
    }

    // 🔥 REPORTE DE INVENTARIO - ACTUALIZADO CON ESTADO INTELIGENTE
    public function obtenerInventario(Request $request)
    {
        $query = Producto::with('categoria');

        // Filtro por estado calculado (no por estado_producto)
        if ($request->estado) {
            if ($request->estado === 'agotado') {
                $query->where('stock_producto', 0);
            } elseif ($request->estado === 'poco_stock') {
                $query->whereBetween('stock_producto', [1, 4]);
            } elseif ($request->estado === 'disponible') {
                $query->where('stock_producto', '>=', 5);
            } else {
                // Para otros estados (descontinuado) usar el estado original
                $query->where('estado_producto', $request->estado);
            }
        }

        if ($request->producto) {
            $query->where('nombre_producto', 'like', "%{$request->producto}%");
        }

        if ($request->stock_minimo) {
            $query->where('stock_producto', '<=', $request->stock_minimo);
        }

        $productos = $query->orderBy('nombre_producto')->get();

        return response()->json([
            'success' => true,
            'inventario' => $productos->map(function($producto) {
                // 🔥 CALCULAR ESTADO INTELIGENTE BASADO EN STOCK
                $estadoCalculado = $this->calcularEstadoProducto($producto->stock_producto, $producto->estado_producto);
                
                return [
                    'codigo' => "P-{$producto->id_producto}",
                    'producto' => $producto->nombre_producto,
                    'descripcion' => $producto->descripcion_producto,
                    'precio' => $producto->precio_producto,
                    'stock' => $producto->stock_producto,
                    'estado' => $estadoCalculado, // 🔥 USAR ESTADO CALCULADO
                    'estado_original' => $producto->estado_producto, // Mantener original para referencia
                    'categoria' => $producto->categoria ? $producto->categoria->nombre_cat : 'N/A',
                    'marca' => $producto->marca
                ];
            })
        ]);
    }

    // 🔥 FUNCIÓN PARA CALCULAR ESTADO INTELIGENTE DEL PRODUCTO
    private function calcularEstadoProducto($stock, $estadoOriginal)
    {
        $stockNum = (int) $stock;
        
        // Si está descontinuado, mantener ese estado
        if ($estadoOriginal === 'descontinuado') {
            return 'descontinuado';
        }
        
        // Lógica basada en stock
        if ($stockNum === 0) {
            return 'agotado';
        } elseif ($stockNum >= 1 && $stockNum <= 4) {
            return 'poco_stock';
        } else {
            return 'disponible';
        }
    }

    // 🔥 REPORTE DE CLIENTES (TOP COMPRADORES) - CORREGIDO
    public function obtenerClientes(Request $request)
    {
        // 🔥 CONSULTA CORREGIDA: Usamos join directo en lugar de relaciones Eloquent
        $query = Cliente::select(
                'clientes.id_cliente',
                'clientes.doc_ident',
                'clientes.nombre_cliente',
                'clientes.apellido_cliente',
                'clientes.email_cliente',
                'clientes.telefono_cliente',
                'clientes.fecha_registro',
                DB::raw('COUNT(ventas.id_venta) as cantidad_compras'),
                DB::raw('COALESCE(SUM(ventas.total_venta), 0) as total_gastado')
            )
            ->leftJoin('ventas', function($join) {
                $join->on('clientes.id_cliente', '=', 'ventas.id_cliente')
                     ->where('ventas.tipo', 'venta');
            })
            ->groupBy(
                'clientes.id_cliente',
                'clientes.doc_ident',
                'clientes.nombre_cliente',
                'clientes.apellido_cliente',
                'clientes.email_cliente',
                'clientes.telefono_cliente',
                'clientes.fecha_registro'
            );

        // Filtros
        if ($request->busqueda) {
            $query->where(function($q) use ($request) {
                $q->where('clientes.nombre_cliente', 'like', "%{$request->busqueda}%")
                  ->orWhere('clientes.apellido_cliente', 'like', "%{$request->busqueda}%")
                  ->orWhere('clientes.doc_ident', 'like', "%{$request->busqueda}%");
            });
        }

        if ($request->min_compras) {
            $query->having('cantidad_compras', '>=', $request->min_compras);
        }

        $clientes = $query->orderBy('total_gastado', 'desc')->get();

        return response()->json([
            'success' => true,
            'clientes' => $clientes->map(function($cliente) {
                return [
                    'codigo' => "C-{$cliente->id_cliente}",
                    'cliente' => "{$cliente->nombre_cliente} {$cliente->apellido_cliente}",
                    'dni' => $cliente->doc_ident,
                    'cantidad_compras' => $cliente->cantidad_compras,
                    'total_gastado' => $cliente->total_gastado,
                    'email' => $cliente->email_cliente,
                    'telefono' => $cliente->telefono_cliente,
                    'fecha_registro' => $cliente->fecha_registro
                ];
            })
        ]);
    }

    // 🔥 REPORTE TOP PRODUCTOS
    public function obtenerTopProductos(Request $request)
    {
        // 🔥 LIMITAR A 20 PRODUCTOS Y ORDENAR POR CANTIDAD VENDIDA
        $topProductos = DetalleVenta::join('ventas', 'detalles_venta.id_venta', '=', 'ventas.id_venta')
            ->join('productos', 'detalles_venta.id_producto', '=', 'productos.id_producto')
            ->where('ventas.tipo', 'venta')
            ->select(
                'productos.id_producto',
                'productos.nombre_producto',
                DB::raw('SUM(detalles_venta.cantidad) as total_vendido'),
                DB::raw('SUM(detalles_venta.subtotal) as ingresos_generados'),
                DB::raw('MAX(ventas.fecha_venta) as fecha_ultima_venta')
            )
            ->groupBy('productos.id_producto', 'productos.nombre_producto')
            ->orderBy('total_vendido', 'desc')
            ->limit(20) // 🔥 SOLO 20 PRODUCTOS
            ->get();

        return response()->json([
            'success' => true,
            'top_productos' => $topProductos->map(function($producto) {
                return [
                    'codigo' => "P-{$producto->id_producto}",
                    'producto' => $producto->nombre_producto,
                    'cantidad_vendida' => $producto->total_vendido,
                    'fecha_ultima_venta' => $producto->fecha_ultima_venta,
                    'ingresos_generados' => $producto->ingresos_generados
                ];
            })
        ]);
    }

    // 🔥 FUNCIÓN AUXILIAR PARA DETALLES DE PEDIDO
    private function obtenerDetallesPedido($idVenta)
    {
        $detalles = DetalleVenta::with('producto')
            ->where('id_venta', $idVenta)
            ->get();

        return $detalles->map(function($detalle) {
            return "{$detalle->producto->nombre_producto} (x{$detalle->cantidad})";
        })->implode(', ');
    }

    // 🔥 ESTADÍSTICAS GENERALES PARA DASHBOARD (las usaremos después)
    public function obtenerEstadisticas()
    {
        $hoy = now()->format('Y-m-d');
        $mesActual = now()->format('Y-m');
        
        return response()->json([
            'ventas_hoy' => Venta::whereDate('fecha_venta', $hoy)
                            ->where('tipo', 'venta')
                            ->sum('total_venta'),
            'total_ventas_mes' => Venta::where('fecha_venta', 'like', "{$mesActual}%")
                                 ->where('tipo', 'venta')
                                 ->sum('total_venta'),
            'pedidos_pendientes' => Pedido::where('estado_pedido', 'pendiente')->count(),
            'clientes_nuevos_mes' => Cliente::where('fecha_registro', 'like', "{$mesActual}%")->count(),
            'productos_bajo_stock' => Producto::where('stock_producto', '<=', 5)->count()
        ]);
    }
}