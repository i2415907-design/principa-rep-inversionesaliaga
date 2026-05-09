<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class PedidoEntregadoNotification extends Notification
{
    use Queueable;

    protected $producto;
    protected $mensaje;

    public function __construct($producto, $mensaje)
    {
        $this->producto = $producto;
        $this->mensaje = $mensaje;
    }

    public function via($notifiable)
    {
        return ['database']; // puedes agregar 'mail' si quieres correo también
    }

    public function toDatabase($notifiable)
    {
        return [
            'mensaje' => $this->mensaje,
            'producto' => $this->producto,
        ];
    }
}
