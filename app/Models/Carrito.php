<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carritos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'estado',
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'fecha_actualizacion' => 'datetime'
    ];

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'user_id', 'id_usuario');
    }

    /**
     * Relación con los items del carrito
     */
    public function items()
    {
        return $this->hasMany(CarritoItem::class);
    }

    /**
     * Obtener carrito activo del usuario
     */
    public static function obtenerCarritoActivo($userId)
    {
        return static::where('user_id', $userId)
            ->where('estado', 'activo')
            ->first();
    }

    /**
     * Crear o obtener carrito activo
     */
    public static function crearObtenerCarrito($userId)
    {
        $carrito = static::obtenerCarritoActivo($userId);
        
        if (!$carrito) {
            $carrito = static::create([
                'user_id' => $userId,
                'estado' => 'activo'
            ]);
        }
        
        return $carrito;
    }
}

