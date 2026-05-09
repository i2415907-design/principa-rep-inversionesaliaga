<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionHistorial extends Model
{
    protected $table = 'historial_notificaciones';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false; // Usamos nuestra columna 'fecha'

    protected $fillable = [
        'id_usuario',
        'titulo',
        'mensaje',
        'id_pedido',
        'leido',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'leido' => 'boolean',
    ];
}