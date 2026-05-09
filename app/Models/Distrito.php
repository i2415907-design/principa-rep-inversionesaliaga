<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $table = 'distrito';
    protected $primaryKey = 'id_distrito';
    public $timestamps = false;

    protected $fillable = [
        'nombre_distr',
        'precio_envio',
        'id_provincia',
        'fecha_estimada_llegada'
    ];

    protected $casts = [
        'precio_envio' => 'decimal:2',
        'fecha_estimada_llegada' => 'date'
    ];
}