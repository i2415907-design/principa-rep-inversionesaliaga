<?php
namespace App\Events;

use App\Models\Pedido;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Services\FirebasePushService;

class PedidoNotificacion implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data; // Aquí irá todo el paquete de info

public function __construct(Pedido $pedido, $mensaje, $idDestinatario, $rolDestinatario)
{
    $productos = DB::table('detalles_venta')
        ->join('productos', 'detalles_venta.id_producto', '=', 'productos.id_producto')
        ->where('detalles_venta.id_venta', $pedido->id_venta)
        ->pluck('productos.nombre_producto')
        ->toArray();

    $listaProductos = implode(', ', $productos);
    $titulo = "Actualización de Pedido #{$pedido->id_pedido}";
    $mensajeCompleto = $mensaje . " (Productos: $listaProductos)";

    // 1. Guardar y obtener el ID
    $idInsertado = DB::table('historial_notificaciones')->insertGetId([
        'id_usuario' => $idDestinatario,
        'titulo'     => $titulo,
        'mensaje'    => $mensajeCompleto,
        'id_pedido'  => $pedido->id_pedido,
        'fecha'      => now(),
        'leido'      => 0
    ]);

    // 2. Armar la data EXACTAMENTE como la espera Flutter
    $this->data = [
        'id_notificacion' => $idInsertado, // Clave para marcar como leída después
        'titulo'          => $titulo,      // ¡FALTABA ESTO!
        'mensaje'         => $mensajeCompleto,
        'id_pedido'       => $pedido->id_pedido,
        'fecha'           => now()->toDateTimeString(),
        'rol'             => $rolDestinatario,
        'id_usuario'      => $idDestinatario,
        'leido'           => 0
    ];

    // Push real (FCM) para móvil (background/closed)
    try {
        app(FirebasePushService::class)->sendToUser(
            (int)$idDestinatario,
            (string)$titulo,
            (string)$mensajeCompleto,
            [
                'id_pedido' => $pedido->id_pedido,
                'rol' => $rolDestinatario,
            ]
        );
    } catch (\Throwable $e) {
        \Log::error("FCM init/send error: " . $e->getMessage());
    }
}

public function broadcastOn()
{
    if ($this->data['rol'] === 'admin') {
        // El Admin NO usa ID en el canal, usa un canal fijo.
        return new PrivateChannel('admins');
    }
    // Vendedores y Clientes sí usan su ID personal.
    return new PrivateChannel('usuario.' . $this->data['id_usuario']);
}

    public function broadcastAs()
    {
        return 'notificacion.pedido';
    }
}