<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    use HasFactory;

    protected $table = 'carrito_items';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'carrito_id',
        'producto_id',
        'cantidad',
        'precio',
        'fecha_agregado'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_agregado' => 'datetime'
    ];

    /**
     * Relación con el carrito
     */
    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }

    /**
     * Relación con el producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id_producto');
    }

    /**
     * Calcular subtotal del item
     */
    public function getSubtotalAttribute()
    {
        return $this->precio * $this->cantidad;
    }

    /**
     * Actualizar o crear item del carrito
     */
public static function updateOrCreateItem($carritoId, $productoId, $cantidad, $precio = null)
{
    // Si no se pasa el precio, lo buscamos desde el producto
    if (is_null($precio)) {
        $producto = Producto::find($productoId);
        if (!$producto) {
            throw new \Exception("El producto con ID {$productoId} no existe.");
        }
        $precio = $producto->precio;
    }

    return static::updateOrCreate(
        [
            'carrito_id' => $carritoId,
            'producto_id' => $productoId
        ],
        [
            'cantidad' => $cantidad,
            'precio' => $precio,
            'fecha_agregado' => now()
        ]
    );
}

}

