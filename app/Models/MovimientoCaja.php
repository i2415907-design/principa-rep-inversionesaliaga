<?php

// app/Models/MovimientoCaja.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoCaja extends Model
{
    use HasFactory;

    protected $table = 'movimientos_caja';
    protected $primaryKey = 'id_movimiento'; 
    
    // Columnas que pueden ser asignadas masivamente (bulk assigned)
    protected $fillable = [
        'tipo', 
        'monto', 
        'concepto', 
        'fecha', 
        'id_usuario',
    ];
    
    // Relación: Un movimiento es registrado por un usuario
    public function usuario()
    {
        // Conexión a tu modelo de autenticación. Asegúrate de que este modelo exista y apunte a tu tabla 'usuarios'.
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); 
    }
}