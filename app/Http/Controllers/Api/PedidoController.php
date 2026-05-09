<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Venta;
use App\Models\Usuario;
use App\Models\MobileSeguimiento;
use App\Models\MobileUbicacion;
use App\Models\MobileResena;
use App\Events\PedidoNotificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PedidoController extends Controller
{
    /**
     * Lista de pedidos del usuario autenticado (Cliente/Vendedor)
     */
    public function misPedidos(Request $request)
    {
        $usuario = $request->user();

        $idsClientesDeVentas = Venta::where('id_usuario', $usuario->id_usuario)
                                    ->whereNotNull('id_cliente')
                                    ->pluck('id_cliente');

        if ($idsClientesDeVentas->isEmpty()) {
            return response()->json(['mensaje' => 'Sin ventas', 'datos' => []], 200);
        }

        $pedidos = Pedido::whereIn('pedidos.id_cliente', $idsClientesDeVentas)
            ->join('clientes', 'pedidos.id_cliente', '=', 'clientes.id_cliente')
            ->leftJoin('usuarios as encargado', 'pedidos.id_encargado', '=', 'encargado.id_usuario')
            ->leftJoin('mobile_resenas as mr', 'pedidos.id_pedido', '=', 'mr.id_pedido')
            ->select(
                'pedidos.*',
                'clientes.direccion_cliente',
                'encargado.nombre_usuario as nombre_encargado',
                'mr.calificacion',
                'mr.comentario',
                'mr.imagen_url as foto_evidencia'
            )
            ->with([
                'distrito', 
                'venta.detalles.producto'
            ]) 
            ->orderBy('fecha_pedido', 'desc')
            ->get();

        return response()->json([
            'usuario' => $usuario->nombre_usuario,
            'total_pedidos' => $pedidos->count(),
            'datos' => $pedidos
        ], 200);
    }

    /**
     * Actualizar ubicación y dirección del pedido/cliente
     */
    public function actualizarUbicacion(Request $request)
    {
        $request->validate([
            'id_pedido'         => 'required|exists:pedidos,id_pedido',
            'id_distrito'       => 'required|exists:distrito,id_distrito',
            'direccion_cliente' => 'required|string|max:255',
            'referencia'        => 'required|string|max:300',
            'codigo_postal'     => 'required|string|max:6',
        ]);

        $pedido = Pedido::find($request->id_pedido);

        if (!$pedido) {
            return response()->json(['mensaje' => 'Pedido no encontrado'], 404);
        }

        // Regla: solo puede actualizar en estado pendiente
        if ($pedido->estado_pedido !== 'pendiente') {
            return response()->json([
                'mensaje' => 'Solo se puede actualizar mientras el pedido está pendiente.'
            ], 403);
        }

        // Regla: máximo 2 actualizaciones
        $actualizacionesToSet = null;
        if (Schema::hasColumn('pedidos', 'actualizaciones_cliente')) {
            $actualizaciones = (int) ($pedido->actualizaciones_cliente ?? 0);
            if ($actualizaciones >= 2) {
                return response()->json([
                    'mensaje' => 'Límite alcanzado: solo se permiten 2 actualizaciones por pedido.'
                ], 403);
            }
            $actualizacionesToSet = $actualizaciones + 1;
        }
        
        $updateData = [
            'id_distrito'    => $request->id_distrito,
            'referencia_ped' => $request->referencia,
            'codigo_postal'  => $request->codigo_postal,
        ];
        if (!is_null($actualizacionesToSet)) {
            $updateData['actualizaciones_cliente'] = $actualizacionesToSet;
        }
        $pedido->update($updateData);

        if($pedido->id_cliente) {
            DB::table('clientes')
                ->where('id_cliente', $pedido->id_cliente)
                ->update(['direccion_cliente' => $request->direccion_cliente]);
        }

        // Notificar al vendedor encargado (si existe) que el cliente actualizó datos
        if ($pedido->id_encargado) {
            broadcast(new PedidoNotificacion(
                $pedido,
                "El cliente actualizó los datos de entrega del pedido #{$pedido->id_pedido}.",
                $pedido->id_encargado,
                'vendedor'
            ));
        }

        return response()->json(['mensaje' => 'Datos de entrega actualizados'], 200);
    }

    public function getDistritos() {
        $distritos = DB::table('distrito')->select('id_distrito', 'nombre_distr')->get();
        return response()->json($distritos);
    }

    /**
     * Obtener el pedido que está actualmente "enviado" para el usuario
     */
    public function getPedidoEnCamino(Request $request) {
        $usuario = Usuario::where('api_token', $request->query('token'))->first();
        if (!$usuario) return response()->json(['mensaje' => 'No autorizado'], 401);

        $idsClientesDeVentas = Venta::where('id_usuario', $usuario->id_usuario)
                                    ->whereNotNull('id_cliente')
                                    ->pluck('id_cliente');

        $pedido = Pedido::whereIn('pedidos.id_cliente', $idsClientesDeVentas)
                    ->join('clientes', 'pedidos.id_cliente', '=', 'clientes.id_cliente')
                    ->leftJoin('usuarios as encargado', 'pedidos.id_encargado', '=', 'encargado.id_usuario')
                    ->leftJoin('mobile_resenas as mr', 'pedidos.id_pedido', '=', 'mr.id_pedido')
                    ->where('pedidos.estado_pedido', 'enviado')
                    ->select(
                        'pedidos.*',
                        'clientes.direccion_cliente',
                        'encargado.nombre_usuario as nombre_encargado',
                        'mr.calificacion',
                        'mr.comentario',
                        'mr.imagen_url as foto_evidencia'
                    )
                    ->with(['venta.detalles.producto'])
                    ->first();

        if (!$pedido) return response()->json(['mensaje' => 'No hay pedidos en ruta'], 404);

        return response()->json([
            'id_pedido'         => $pedido->id_pedido,
            'estado_pedido'     => $pedido->estado_pedido,
            'total_pedido'      => (string)$pedido->total_pedido,
            'fecha_pedido'      => $pedido->fecha_pedido,
            'id_distrito'       => $pedido->id_distrito,
            'codigo_postal'     => $pedido->codigo_postal,
            'referencia_ped'    => $pedido->referencia_ped,
            'direccion_cliente' => $pedido->direccion_cliente,
            'foto_evidencia'    => $pedido->foto_evidencia,
            'venta' => [
                'detalles' => $pedido->venta->detalles->map(function($d) {
                    return [
                        'producto' => [
                            'nombre_producto' => $d->producto->nombre_producto,
                            'url_imagen'      => $d->producto->imagen,
                        ],
                        'cantidad'        => (int)$d->cantidad,
                        'precio_unitario' => (string)$d->precio_unitario,
                    ];
                })
            ]
        ]);
    }

    /**
     * Vista de Admin: Todos los pedidos con filtros
     */
    public function todosLosPedidos(Request $request) {
        $token = $request->query('token');
        $usuarioAuth = Usuario::where('api_token', $token)->first();

        if (!$usuarioAuth || !in_array($usuarioAuth->rol, ['admin', 'admin_general'])) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $estado = $request->query('estado');

        try {
            $query = Pedido::with(['distrito', 'venta.detalles.producto', 'cliente'])
                ->leftJoin('usuarios as encargado', 'pedidos.id_encargado', '=', 'encargado.id_usuario')
                ->leftJoin('clientes', 'pedidos.id_cliente', '=', 'clientes.id_cliente')
                ->leftJoin('mobile_resenas as mr', 'pedidos.id_pedido', '=', 'mr.id_pedido')
                ->select(
                    'pedidos.*', 
                    'encargado.nombre_usuario as nombre_encargado',
                    'clientes.direccion_cliente as direccion_emergencia',
                    'mr.calificacion',
                    'mr.comentario',
                    'mr.imagen_url as foto_evidencia'
                );

            if ($estado) {
                $query->where('pedidos.estado_pedido', $estado);
            }

            $query->orderBy('pedidos.fecha_pedido', 'desc');

            $perPage = (int) $request->query('per_page', 0);
            if ($perPage > 0) {
                $paginated = $query->paginate($perPage);
                return response()->json([
                    'res' => true,
                    'datos' => $paginated->items(),
                    'meta' => [
                        'current_page' => $paginated->currentPage(),
                        'last_page' => $paginated->lastPage(),
                        'per_page' => $paginated->perPage(),
                        'total' => $paginated->total(),
                    ],
                ], 200);
            }

            $pedidos = $query->get();
            return response()->json(['res' => true, 'datos' => $pedidos], 200);

        } catch (\Exception $e) {
            return response()->json(['res' => false, 'debug' => $e->getMessage()], 500);
        }
    }

    /**
     * Vista de Vendedor: Pedidos que tiene asignados para entregar
     */
    public function pedidosAsignados(Request $request) {
        $token = $request->query('token');
        $vendedor = Usuario::where('api_token', $token)->first();

        if (!$vendedor) return response()->json(['error' => 'No autorizado'], 401);

        $pedidos = Pedido::with(['distrito', 'venta.detalles.producto', 'cliente'])
            ->leftJoin('mobile_resenas as mr', 'pedidos.id_pedido', '=', 'mr.id_pedido')
            ->where('id_encargado', $vendedor->id_usuario)
            ->whereIn('estado_pedido', ['pendiente', 'enviado'])
            ->orderBy('fecha_pedido', 'asc')
            ->select('pedidos.*', 'mr.calificacion', 'mr.comentario', 'mr.imagen_url as foto_evidencia')
            ->get();

        return response()->json($pedidos, 200);
    }

    /**
     * Acción: Finalizar la entrega (Vendedor)
     */
    public function completarPedido(Request $request) {
        $request->validate([
            'id_pedido' => 'required|exists:pedidos,id_pedido'
        ]);

        $pedido = Pedido::find($request->id_pedido);
        if (!$pedido) return response()->json(['error' => 'No encontrado'], 404);

        // El PedidoObserver disparará las notificaciones al hacer 'update'
        $pedido->update([
            'estado_pedido' => 'entregado',
            'referencia_ped' => $pedido->referencia_ped . " | Confirmado",
        ]);

        // Evidencia en mobile_resenas: solo actualizar imagen_url si el vendedor sube archivo
        // (no guardar URL placeholder: rompe la app y oculta la foto real).
        $resenaAttrs = [
            'id_cliente' => $pedido->id_cliente,
            'fecha_creacion' => now(),
            'moderada' => 0,
        ];
        if ($request->hasFile('foto_evidencia')) {
            $file = $request->file('foto_evidencia');
            $nombreFoto = time() . '_' . $pedido->id_pedido . '.jpg';
            $file->move(public_path('evidencias'), $nombreFoto);
            $resenaAttrs['imagen_url'] = url('evidencias/' . $nombreFoto);
        }

        $urlFotoRespuesta = null;
        if ($pedido->id_cliente) {
            $resena = MobileResena::updateOrCreate(
                ['id_pedido' => $pedido->id_pedido],
                $resenaAttrs
            );
            $urlFotoRespuesta = $resena->imagen_url;
        }

        // Sincronizar seguimiento a entregado
        DB::table('mobile_seguimiento')->updateOrInsert(
            ['id_pedido' => $pedido->id_pedido],
            [
                'codigo_seguimiento' => 'PED-' . $pedido->id_pedido,
                'estado_app' => 'entregado',
                'fecha_actualizacion' => now()
            ]
        );

        return response()->json([
            'res' => true,
            'mensaje' => 'Pedido entregado con éxito',
            'foto' => $urlFotoRespuesta,
        ], 200);
    }

    /**
     * Acción: Iniciar el viaje de entrega (Vendedor)
     */
    public function iniciarRuta(Request $request) {
        $request->validate(['id_pedido' => 'required|exists:pedidos,id_pedido']);

        $pedido = Pedido::find($request->id_pedido);
        
        $pedido->update(['estado_pedido' => 'enviado']);

        DB::table('mobile_seguimiento')->updateOrInsert(
            ['id_pedido' => $pedido->id_pedido],
            [
                'codigo_seguimiento' => 'PED-' . $pedido->id_pedido,
                'estado_app' => 'en_camino',
                'fecha_actualizacion' => now()
            ]
        );

        return response()->json(['res' => true, 'mensaje' => 'Ruta iniciada correctamente']);
    }

    /**
     * Acción: Cancelar/Devolver pedido a la cola (Vendedor)
     */
    public function cancelarEntrega(Request $request) {
        $request->validate([
            'id_pedido' => 'required|exists:pedidos,id_pedido',
            'motivo' => 'required|string|max:500'
        ]);

        $pedido = Pedido::find($request->id_pedido);

        $pedido->update([
            'estado_pedido' => 'pendiente',
            'id_encargado' => null,
            'referencia_ped' => $pedido->referencia_ped . " (Cancelado: " . $request->motivo . ")"
        ]);

        DB::table('mobile_seguimiento')
            ->where('id_pedido', $pedido->id_pedido)
            ->update(['estado_app' => 'preparando']);

        return response()->json(['res' => true, 'mensaje' => 'Entrega cancelada']);
    }

    public function historialEntregas(Request $request) {
        $token = $request->query('token');
        $vendedor = Usuario::where('api_token', $token)->first();

        $pedidos = Pedido::with(['distrito', 'venta.detalles.producto', 'cliente'])
            ->leftJoin('mobile_resenas as mr', 'pedidos.id_pedido', '=', 'mr.id_pedido')
            ->where('id_encargado', $vendedor->id_usuario)
            ->where('estado_pedido', 'entregado')
            ->select('pedidos.*', 'mr.calificacion', 'mr.comentario', 'mr.imagen_url as foto_evidencia')
            ->get();

        return response()->json($pedidos, 200);
    }

    /**
     * Admin: métricas para dashboard (mobile)
     */
    public function adminDashboard(Request $request)
    {
        $token = $request->query('token');
        $admin = Usuario::where('api_token', $token)->first();
        if (!$admin || !in_array($admin->rol, ['admin', 'admin_general'])) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $totalesPorEstado = Pedido::select('estado_pedido', DB::raw('COUNT(*) as total'))
            ->groupBy('estado_pedido')
            ->pluck('total', 'estado_pedido');

        $entregadosHoy = Pedido::where('estado_pedido', 'entregado')
            ->whereDate('fecha_pedido', now()->toDateString())
            ->count();

        $topVendedores = DB::table('pedidos')
            ->join('usuarios', 'pedidos.id_encargado', '=', 'usuarios.id_usuario')
            ->leftJoin('mobile_resenas', 'pedidos.id_pedido', '=', 'mobile_resenas.id_pedido')
            ->whereNotNull('pedidos.id_encargado')
            ->where('usuarios.rol', '!=', 'admin')
            ->groupBy('usuarios.id_usuario', 'usuarios.nombre_usuario')
            ->select(
                'usuarios.id_usuario',
                'usuarios.nombre_usuario',
                DB::raw('COUNT(CASE WHEN pedidos.estado_pedido = "entregado" THEN 1 END) as entregados'),
                DB::raw('AVG(mobile_resenas.calificacion) as promedio_calificacion'),
                DB::raw('COUNT(mobile_resenas.resena_id) as total_resenas')
            )
            ->orderByDesc(DB::raw('COALESCE(AVG(mobile_resenas.calificacion), 0)'))
            ->orderByDesc('entregados')
            ->limit(5)
            ->get();

        return response()->json([
            'res' => true,
            'datos' => [
                'totales' => [
                    'pendiente' => (int)($totalesPorEstado['pendiente'] ?? 0),
                    'enviado' => (int)($totalesPorEstado['enviado'] ?? 0),
                    'entregado' => (int)($totalesPorEstado['entregado'] ?? 0),
                ],
                'entregados_hoy' => $entregadosHoy,
                'top_vendedores' => $topVendedores,
            ],
        ], 200);
    }

    /**
     * Admin: actualizar estado del pedido (para tabs mobile admin)
     */
    public function actualizarEstadoPedido(Request $request)
    {
        $token = $request->query('token');
        $admin = Usuario::where('api_token', $token)->first();
        if (!$admin || !in_array($admin->rol, ['admin', 'admin_general'])) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate([
            'id_pedido' => 'required|exists:pedidos,id_pedido',
            'estado' => 'required|in:pendiente,enviado,entregado',
        ]);

        $pedido = Pedido::find($request->id_pedido);
        if (!$pedido) return response()->json(['error' => 'No encontrado'], 404);

        $pedido->update(['estado_pedido' => $request->estado]);

        DB::table('mobile_seguimiento')->updateOrInsert(
            ['id_pedido' => $pedido->id_pedido],
            [
                'codigo_seguimiento' => 'PED-' . $pedido->id_pedido,
                'estado_app' => $request->estado === 'enviado' ? 'en_camino' : ($request->estado === 'entregado' ? 'entregado' : 'preparando'),
                'fecha_actualizacion' => now()
            ]
        );

        return response()->json(['res' => true, 'mensaje' => 'Estado actualizado'], 200);
    }

    /**
     * Seguimiento (Cliente/Admin): obtener el tracking del pedido con puntos.
     */
    public function getSeguimientoPedido(Request $request, int $idPedido)
    {
        $token = $request->query('token');
        $usuario = Usuario::where('api_token', $token)->first();
        if (!$usuario) return response()->json(['error' => 'No autorizado'], 401);

        $pedido = Pedido::with(['cliente', 'distrito', 'venta.detalles.producto', 'encargado'])
            ->where('id_pedido', $idPedido)
            ->first();
        if (!$pedido) return response()->json(['error' => 'No encontrado'], 404);

        // Si es cliente: validar que el pedido le pertenece (por ventas -> clientes)
        if (!in_array($usuario->rol, ['admin', 'admin_general', 'trabajador', 'vendedor'])) {
            $idsClientesDeVentas = Venta::where('id_usuario', $usuario->id_usuario)
                ->whereNotNull('id_cliente')
                ->pluck('id_cliente');
            if (!$idsClientesDeVentas->contains($pedido->id_cliente)) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
        }

        $seguimiento = MobileSeguimiento::with(['ubicaciones'])
            ->where('id_pedido', $pedido->id_pedido)
            ->first();

        $resena = MobileResena::where('id_pedido', $pedido->id_pedido)->first();

        return response()->json([
            'res' => true,
            'pedido' => $pedido,
            'seguimiento' => $seguimiento,
            'resena' => $resena,
        ], 200);
    }

    /**
     * Vendedor: registrar un punto GPS (para polyline en cliente/admin)
     */
    public function registrarUbicacionVendedor(Request $request)
    {
        $token = $request->query('token');
        $vendedor = Usuario::where('api_token', $token)->first();
        if (!$vendedor) return response()->json(['error' => 'No autorizado'], 401);

        $request->validate([
            'id_pedido' => 'required|exists:pedidos,id_pedido',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        $pedido = Pedido::find($request->id_pedido);
        if (!$pedido) return response()->json(['error' => 'No encontrado'], 404);

        if ((int)$pedido->id_encargado !== (int)$vendedor->id_usuario) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($pedido->estado_pedido !== 'enviado') {
            return response()->json(['error' => 'El pedido no está en ruta'], 403);
        }

        $seguimiento = MobileSeguimiento::where('id_pedido', $pedido->id_pedido)->first();
        if (!$seguimiento) {
            $seguimiento = MobileSeguimiento::create([
                'id_pedido' => $pedido->id_pedido,
                'codigo_seguimiento' => 'PED-' . $pedido->id_pedido,
                'estado_app' => 'en_camino',
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'fecha_actualizacion' => now(),
            ]);
        } else {
            $seguimiento->update([
                'estado_app' => 'en_camino',
                'latitud' => $request->latitud,
                'longitud' => $request->longitud,
                'fecha_actualizacion' => now(),
            ]);
        }

        MobileUbicacion::create([
            'seguimiento_id' => $seguimiento->seguimiento_id,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'fecha_ubicacion' => now(),
        ]);

        return response()->json(['res' => true], 200);
    }

    /**
     * Cliente: crear/actualizar reseña (opcional) una vez entregado.
     */
    public function guardarResena(Request $request)
    {
        $token = $request->query('token');
        $usuario = Usuario::where('api_token', $token)->first();
        if (!$usuario) return response()->json(['error' => 'No autorizado'], 401);

        $request->validate([
            'id_pedido' => 'required|exists:pedidos,id_pedido',
            'calificacion' => 'nullable|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:2000',
        ]);

        $pedido = Pedido::with(['venta'])->find($request->id_pedido);
        if (!$pedido) return response()->json(['error' => 'No encontrado'], 404);

        // Validar pertenencia por ventas -> clientes del usuario
        $idsClientesDeVentas = Venta::where('id_usuario', $usuario->id_usuario)
            ->whereNotNull('id_cliente')
            ->pluck('id_cliente');
        if (!$idsClientesDeVentas->contains($pedido->id_cliente)) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        if ($pedido->estado_pedido !== 'entregado') {
            return response()->json(['error' => 'Solo se puede reseñar cuando el pedido está entregado'], 403);
        }

        $resena = MobileResena::where('id_pedido', $pedido->id_pedido)->first();
        if ($resena) {
            $payload = $request->only(['calificacion', 'comentario']);
            $update = ['fecha_creacion' => now()];
            foreach (['calificacion', 'comentario'] as $field) {
                if (array_key_exists($field, $payload) && $payload[$field] !== null) {
                    $update[$field] = $payload[$field];
                }
            }
            $resena->update($update);
            $resena->refresh();
        } else {
            $resena = MobileResena::create([
                'id_pedido' => $pedido->id_pedido,
                'id_cliente' => $pedido->id_cliente,
                'calificacion' => $request->calificacion,
                'comentario' => $request->comentario,
                'fecha_creacion' => now(),
                'moderada' => 0,
            ]);
        }

        // Notificar al vendedor (si existe) que recibió una reseña
        if ($pedido->id_encargado && $resena->calificacion) {
            broadcast(new PedidoNotificacion(
                $pedido,
                "El cliente calificó el pedido #{$pedido->id_pedido} con {$resena->calificacion} estrellas.",
                $pedido->id_encargado,
                'vendedor'
            ));
        }

        return response()->json(['res' => true, 'datos' => $resena], 200);
    }
}