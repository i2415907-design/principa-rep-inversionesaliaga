<?php

namespace App\Models;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Model;


class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    public $timestamps = false; // No tienes columnas created_at / updated_at

    protected $fillable = [
        'nombre_cat',
        'descripcion_cat',
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}
