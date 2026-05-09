<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MobileDeviceToken;
use Illuminate\Http\Request;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $usuario = $request->user();
        if (!$usuario) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'token' => 'required|string|max:255',
            'platform' => 'nullable|string|max:20',
        ]);

        MobileDeviceToken::updateOrCreate(
            ['token' => $request->token],
            [
                'id_usuario' => $usuario->id_usuario,
                'platform' => $request->platform,
                'last_seen_at' => now(),
            ]
        );

        return response()->json(['res' => true], 200);
    }

    public function destroy(Request $request)
    {
        $usuario = $request->user();
        if (!$usuario) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        $request->validate([
            'token' => 'required|string|max:255',
        ]);

        MobileDeviceToken::where('id_usuario', $usuario->id_usuario)
            ->where('token', $request->token)
            ->delete();

        return response()->json(['res' => true], 200);
    }
}

