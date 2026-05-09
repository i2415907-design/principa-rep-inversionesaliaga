<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, Notifiable;
    

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre_usuario',
        'email',
        'contrasena',
        'api_token',
        'rol',
        'fecha_registro',
        'activo',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
    // Si usas 'password' en vez de 'contrasena', ajusta aquí
    public function setPasswordAttribute($value)
    {
        $this->attributes['contrasena'] = bcrypt($value);
    }
    
    public function receivesBroadcastNotificationsOn() {
        return 'usuario.' . $this->id_usuario;
    }
public function getAuthIdentifierName()
{
    return 'id_usuario';
}

public function getAuthIdentifier()
{
    return $this->id_usuario;
}

public function getKey()
{
    return $this->id_usuario;
}

public function clientes()
{
    // Un usuario tiene muchos clientes vinculados por 'id_usuario'
    return $this->hasMany(Cliente::class, 'id_usuario', 'id_usuario');
}
}
