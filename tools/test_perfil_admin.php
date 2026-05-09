<?php
// Script de prueba: crea un aviso de prueba y renderiza la vista del perfil admin
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Aviso;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

// Buscar admin existente
$admin = Usuario::where('rol', 'admin')->first();
if (! $admin) {
    echo "No hay usuario admin en la BD. Crea uno y vuelve a intentar.\n";
    exit(1);
}

// Crear aviso de prueba
$aviso = new Aviso();
$aviso->titulo = 'Aviso de prueba desde script';
$aviso->mensaje = 'Contenido de prueba generado automáticamente';
$aviso->tipo = 'general';
$aviso->id_admin = $admin->id_usuario;
$aviso->save();

$usuarios = Usuario::all();
$avisos = Aviso::orderBy('fecha_publicacion', 'desc')->get();

// Renderizar la vista padre
$usuario = $admin; // contexto para la vista
$view = view('perfiladm.perfildeadmn', compact('usuario', 'usuarios', 'avisos'));
$html = $view->render();

// Mostrar un fragmento del HTML para comprobar carga
echo "=== Render OK (primeras 1000 chars) ===\n";
echo substr($html, 0, 1000) . "\n";
echo "=== Aviso creado ID: " . ($aviso->id_aviso ?? 'n/a') . " ===\n";
