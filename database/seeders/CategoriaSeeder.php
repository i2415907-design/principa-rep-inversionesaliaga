<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre_cat' => 'Electrónicos',
            'descripcion_cat' => 'Productos electrónicos y tecnológicos'
        ]);

        Categoria::create([
            'nombre_cat' => 'Ropa',
            'descripcion_cat' => 'Vestimenta y accesorios'
        ]);

        Categoria::create([
            'nombre_cat' => 'Hogar',
            'descripcion_cat' => 'Productos para el hogar'
        ]);

        Categoria::create([
            'nombre_cat' => 'Deportes',
            'descripcion_cat' => 'Artículos deportivos'
        ]);
    }
}
