<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Nombre real de la tabla
    protected $table = 'productos';

    // Nombre real de la PK
    protected $primaryKey = 'id_producto';

    // Laravel no usará timestamps porque no tienes `created_at` ni `updated_at`
    public $timestamps = false;

    // Campos que puedes llenar con create() o update()
    protected $fillable = [
        'nombre_producto',
        'descripcion_producto',
        'precio_producto',
        'stock_producto',
        'fecha_registro',
        'id_categoria',
        'estado_producto',
        'imagen',
        'marca',
    ];
    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'id_categoria');
}

protected $appends = ['url_imagen'];

public function getUrlImagenAttribute() {
    if ($this->imagen) {
        // Como tu base de datos ya dice "productos/nombre.png", 
        // solo necesitamos apuntar a la carpeta storage
        return asset('storage/' . $this->imagen);
    }
    return asset('storage/productos/default.png');
}

}
