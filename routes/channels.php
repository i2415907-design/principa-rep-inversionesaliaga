<?php

use Illuminate\Support\Facades\Broadcast;

// Canal privado para cada usuario (Cliente o Vendedor)
Broadcast::channel('usuario.{id}', function ($user, $id) {
    return (int) $user->id_usuario === (int) $id;
});

// Canal para todos los Administradores
Broadcast::channel('admins', function ($user) {
    return in_array($user->rol, ['admin', 'admin_general']);
});