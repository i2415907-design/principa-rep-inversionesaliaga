<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NotificacionController;
use App\Http\Controllers\Api\DeviceTokenController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/auth/google', [AuthController::class, 'googleSignIn']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('api.key')->group(function () {
    Route::get('/mis-pedidos', [PedidoController::class, 'misPedidos']);
    Route::get('/distritos', [PedidoController::class, 'getDistritos']);
    // routes/api.php
    Route::post('/actualizar-ubicacion', [PedidoController::class, 'actualizarUbicacion']);
    Route::post('/actualizar-estado-pedido', [PedidoController::class, 'actualizarEstadoPedido']);
    Route::get('/seguimiento/{idPedido}', [PedidoController::class, 'getSeguimientoPedido']);
    Route::post('/resenas', [PedidoController::class, 'guardarResena']);
    Route::get('/perfil', [AuthController::class, 'getPerfil']);
    Route::post('/actualizar-password', [AuthController::class, 'actualizarPassword']);
    Route::get('/pedido-activo', [PedidoController::class, 'getPedidoEnCamino']);
    Route::get('/admin/pedidos', [PedidoController::class, 'todosLosPedidos']);
    Route::get('/admin/dashboard', [PedidoController::class, 'adminDashboard']);
Route::get('/notificaciones', [NotificacionController::class, 'index']);
    Route::post('/notificaciones/leer', [NotificacionController::class, 'marcarComoLeida']);
    Route::post('/device-token', [DeviceTokenController::class, 'store']);
    Route::delete('/device-token', [DeviceTokenController::class, 'destroy']);
    // Ruta para que el admin cambie estados (la usaremos en los botones)
    Route::prefix('vendedor')->group(function () {
        Route::get('/mis-pedidos', [PedidoController::class, 'pedidosAsignados']);
        Route::get('/mis-entregas', [PedidoController::class, 'historialEntregas']);
        Route::post('/iniciar-ruta', [PedidoController::class, 'iniciarRuta']);
        Route::post('/completar-pedido', [PedidoController::class, 'completarPedido']);
        Route::post('/cancelar-entrega', [PedidoController::class, 'cancelarEntrega']);
        Route::post('/ubicacion', [PedidoController::class, 'registrarUbicacionVendedor']);
    });
    
});