<?php
namespace App\Observers;

use App\Models\Pedido;
use App\Events\PedidoNotificacion;
use Illuminate\Support\Facades\Auth;

class PedidoObserver
{

public function updated(Pedido $pedido)
{
    try {
        $pedido->loadMissing(['venta', 'encargado']);
        $quienCambio = auth()->user();
        $nombreEjecutor = $quienCambio ? $quienCambio->nombre_usuario : 'Sistema';

        // --- 1. NOTIFICAR AL VENDEDOR (CUANDO SE LE ASIGNA) ---
        if ($pedido->isDirty('id_encargado') && $pedido->id_encargado) {
            broadcast(new PedidoNotificacion(
                $pedido,
                "Se te ha asignado el pedido #{$pedido->id_pedido}",
                $pedido->id_encargado, // ID real del vendedor
                'vendedor'
            ));
        }

        // --- 2. CAMBIOS DE ESTADO ---
        if ($pedido->isDirty('estado_pedido')) {
            $idCliente = $pedido->venta->id_usuario ?? null;
            
            // A. Para el Cliente
            if ($idCliente) {
                $msjCliente = match($pedido->estado_pedido) {
                    'enviado'   => "¡Tu pedido #{$pedido->id_pedido} ya salió!",
                    'entregado' => "Tu pedido #{$pedido->id_pedido} ha sido entregado.",
                    default     => "El pedido #{$pedido->id_pedido} cambió a {$pedido->estado_pedido}.",
                };
                broadcast(new PedidoNotificacion($pedido, $msjCliente, $idCliente, 'cliente'));
            }

            // B. Para los Admins (Usamos el ID del que cambió para el historial, o un ID admin fijo)
            $msjAdmin = "$nombreEjecutor cambió el pedido #{$pedido->id_pedido} a {$pedido->estado_pedido}.";
            // IMPORTANTE: En lugar de 0, pasamos el ID de quien hizo el cambio o el ID del admin principal
            $idParaHistorial = $quienCambio ? $quienCambio->id_usuario : 1; 
            broadcast(new PedidoNotificacion($pedido, $msjAdmin, $idParaHistorial, 'admin'));

            // C. Para el Vendedor Encargado (Si el estado cambió y él no fue quien lo hizo)
            if ($pedido->id_encargado && (!$quienCambio || $quienCambio->id_usuario != $pedido->id_encargado)) {
                $msjVendedor = "Tu entrega #{$pedido->id_pedido} fue marcada como {$pedido->estado_pedido}.";
                broadcast(new PedidoNotificacion($pedido, $msjVendedor, $pedido->id_encargado, 'vendedor'));
            }
        }
    } catch (\Exception $e) {
        \Log::error("Error en PedidoObserver: " . $e->getMessage());
    }
}
}