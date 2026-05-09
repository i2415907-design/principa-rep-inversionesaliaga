<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function estadisticas()
    {
        try {
            $hoy = Carbon::today();
            $inicioMes = Carbon::now()->startOfMonth();
            $finMes = Carbon::now()->endOfMonth();

            // Ventas de hoy
            $ventasHoy = DB::table('ventas')
                ->whereDate('fecha_venta', $hoy)
                ->where('tipo', 'venta')
                ->get();

            $totalVentasHoy = $ventasHoy->sum('total_venta');
            $cantidadVentasHoy = $ventasHoy->count();

            // Ventas del mes
            $ventasMes = DB::table('ventas')
                ->whereBetween('fecha_venta', [$inicioMes, $finMes])
                ->where('tipo', 'venta')
                ->get();

            $ingresosMes = $ventasMes->sum('total_venta');
            $ventasMesCount = $ventasMes->count();

            // Pedidos
            $pedidosPendientes = DB::table('pedidos')->where('estado_pedido', 'pendiente')->count();
            $pedidosEnviados = DB::table('pedidos')->where('estado_pedido', 'enviado')->count();
            $pedidosEntregados = DB::table('pedidos')->where('estado_pedido', 'entregado')->count();

            $totalPedidos = $pedidosPendientes + $pedidosEnviados + $pedidosEntregados;
            $tasaEntrega = $totalPedidos > 0 ? round(($pedidosEntregados / $totalPedidos) * 100, 1) : 0;

            // Clientes
            $totalClientes = DB::table('clientes')->count();
            $clientesNuevosMes = DB::table('clientes')
                ->whereBetween('fecha_registro', [$inicioMes, $finMes])
                ->count();

            // Productos
            $totalProductos = DB::table('productos')->count();
            $productosBajoStock = DB::table('productos')
                ->where('stock_producto', '<', 5)
                ->where('estado_producto', 'disponible')
                ->count();

            // Recaudación total (todas las ventas)
            $recaudacionTotal = DB::table('ventas')
                ->where('tipo', 'venta')
                ->sum('total_venta');

            return response()->json([
                'success' => true,
                'estadisticas' => [
                    'ventas_hoy' => (float) $totalVentasHoy,
                    'cantidad_ventas_hoy' => $cantidadVentasHoy,
                    'ingresos_mes' => (float) $ingresosMes,
                    'ventas_mes' => $ventasMesCount,
                    'pedidos_pendientes' => $pedidosPendientes,
                    'pedidos_enviados' => $pedidosEnviados,
                    'pedidos_entregados' => $pedidosEntregados,
                    'total_clientes' => $totalClientes,
                    'clientes_nuevos_mes' => $clientesNuevosMes,
                    'total_productos' => $totalProductos,
                    'productos_bajo_stock' => $productosBajoStock,
                    'tasa_entrega' => $tasaEntrega,
                    'recaudacion_total' => (float) $recaudacionTotal
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function pedidosRecientes()
    {
        try {
            $pedidos = DB::table('pedidos as p')
                ->join('ventas as v', 'p.id_venta', '=', 'v.id_venta')
                ->join('clientes as c', 'p.id_cliente', '=', 'c.id_cliente')
                ->select(
                    'p.id_pedido as id',
                    'p.id_pedido as codigo',
                    DB::raw("CONCAT(c.nombre_cliente, ' ', c.apellido_cliente) as cliente"),
                    'p.estado_pedido as estado',
                    'p.total_pedido as total',
                    'p.fecha_pedido'
                )
                ->orderBy('p.fecha_pedido', 'desc')
                ->limit(5)
                ->get();

            return response()->json([
                'success' => true,
                'pedidos' => $pedidos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function stockBajo()
    {
        try {
            $productos = DB::table('productos')
                ->select(
                    'id_producto as id',
                    'nombre_producto as nombre',
                    'id_producto as codigo',
                    'stock_producto as stock',
                    'precio_producto as precio'
                )
                ->where('stock_producto', '<', 5)
                ->where('estado_producto', 'disponible')
                ->orderBy('stock_producto', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'productos' => $productos
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}