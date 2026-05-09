<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobileResena extends Model
{
    protected $table = 'mobile_resenas';
    protected $primaryKey = 'resena_id';
    public $timestamps = false;

    protected $fillable = [
        'id_pedido',
        'id_cliente',
        'calificacion',
        'comentario',
        'imagen_url',
        'fecha_creacion',
        'moderada',
    ];

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
}

