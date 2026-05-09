<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MobileDeviceToken extends Model
{
    protected $table = 'mobile_device_tokens';

    protected $fillable = [
        'id_usuario',
        'token',
        'platform',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}

