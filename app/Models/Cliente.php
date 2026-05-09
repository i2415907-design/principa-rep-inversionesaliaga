<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'doc_ident',
        'nombre_cliente',
        'apellido_cliente',
        'email_cliente',
        'telefono_cliente',
        'direccion_cliente',
        'fecha_registro'
    ];

    protected $casts = [
        'fecha_registro' => 'datetime'
    ];

    public function pedidos()
{
    return $this->hasMany(Pedido::class, 'id_cliente', 'id_cliente');
}
}