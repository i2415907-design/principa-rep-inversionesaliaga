<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pedido extends Model
{
    // Define la tabla si no sigue el convenio de pluralización
    protected $table = 'pedidos'; 

    // Define la llave primaria
    protected $primaryKey = 'id_pedido';

    // Indica que no usamos los timestamps por defecto (si no están en la tabla)
    // Si tienes 'created_at' y 'updated_at', puedes omitir esta línea
    public $timestamps = false;
    
    protected $fillable = [
        'id_venta',
        'estado_pedido',
        'total_pedido', 
        'fecha_pedido',
        'fecha_entrega_estimada',
        'id_distrito', // Columna necesaria en la BD, aunque no se use la relación con el Modelo Distrito.
        'referencia_ped',
        'codigo_postal',
        'id_cliente',
        'recojo_tienda',
        'id_encargado', // Campo añadido a la BD
    ];

    // Relación: Un Pedido pertenece a una Venta
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }

    // Relación: Un Pedido pertenece a un Cliente
    public function cliente(): BelongsTo
    {
        // Asumiendo que tu modelo de clientes se llama Cliente
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /* // La relación con el Modelo 'Distrito' se ha eliminado/comentado
    // ya que indicaste que no utilizas ese modelo o relación actualmente.
    */
    
    // Relación: Un Pedido tiene un Usuario Encargado (el repartidor/vendedor)
    public function encargado(): BelongsTo
    {
        // El encargado es un usuario del sistema (Modelo Usuario)
        // Usamos id_encargado como clave foránea local, id_usuario como clave primaria remota
        return $this->belongsTo(Usuario::class, 'id_encargado', 'id_usuario');
    }
    public function distrito()
{
    return $this->belongsTo(Distrito::class, 'id_distrito', 'id_distrito');
}
}
