<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobileUbicacion extends Model
{
    protected $table = 'mobile_ubicaciones';
    protected $primaryKey = 'ubicacion_id';
    public $timestamps = false;

    protected $fillable = [
        'seguimiento_id',
        'latitud',
        'longitud',
        'fecha_ubicacion'
    ];

    // Relación: La ubicación pertenece a un seguimiento
    public function seguimiento(): BelongsTo
    {
        return $this->belongsTo(MobileSeguimiento::class, 'seguimiento_id', 'seguimiento_id');
    }
}