<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MobileSeguimiento extends Model
{
    protected $table = 'mobile_seguimiento';
    protected $primaryKey = 'seguimiento_id';
    public $timestamps = false; 

    protected $fillable = [
        'id_pedido',
        'codigo_seguimiento',
        'estado_app',
        'latitud',
        'longitud',
        'fecha_actualizacion'
    ];

    // Relación: Un seguimiento pertenece a un pedido
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    // Relación: Un seguimiento tiene muchos puntos de ubicación (historial)
    public function ubicaciones(): HasMany
    {
        return $this->hasMany(MobileUbicacion::class, 'seguimiento_id', 'seguimiento_id');
    }
}