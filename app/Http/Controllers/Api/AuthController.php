<?php

namespace App\Http\Controllers\Api;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Necesario para generar el token aleatorio

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validar que lleguen los datos
        $request->validate([
            'email' => 'required|email',
            'contrasena' => 'required',
        ]);

        // 2. Buscar al usuario por email
        $usuario = Usuario::where('email', $request->email)->first();

        // 3. Verificar si existe y si la contraseña coincide
        if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
            return response()->json([
                'error' => 'Credenciales incorrectas o usuario no encontrado.'
            ], 401);
        }

        // 4. MANEJO MANUAL DEL TOKEN (Adiós a Sanctum y al 403)
        // Generamos un token nuevo cada vez que inicia sesión por seguridad
        $token = Str::random(60); 
        
        $usuario->update([
            'api_token' => $token
        ]);

        // 5. Responder a Flutter
        return response()->json([
            'mensaje' => 'Bienvenido',
            'token' => $token, // Este es el que guardarás en Flutter
            'usuario' => [
                'id' => $usuario->id_usuario,
                'nombre' => $usuario->nombre_usuario,
                'rol' => $usuario->rol,
                'email' => $usuario->email
            ]
        ], 200);
    }
    
// En Laravel (AuthController.php)
public function register(Request $request) {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:usuarios',
        'password' => 'required|confirmed|min:8',
    ]);

    $user = Usuario::create([
        'nombre_usuario' => $request->name,
        'email' => $request->email,
        'contrasena' => Hash::make($request->password),
        'rol' => 'cliente',
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'type' => 'Bearer',
    ], 201);
}

public function googleSignIn(Request $request)
{
    $idToken = $request->input('id_token');

    try {
        // Validamos el token contra los servidores de Google
        $googleUser = Socialite::driver('google')->userFromToken($idToken);

        // Buscamos al usuario por email
        $usuario = Usuario::where('email', $googleUser->getEmail())->first();

        if (!$usuario) {
            // Si no existe, lo creamos con tus campos de base de datos
            $usuario = Usuario::create([
                'nombre_usuario' => $googleUser->getName(),
                'email'          => $googleUser->getEmail(),
                'api_token'      => Str::random(60),
                'rol'            => 'cliente',
                'activo'         => 1,
                'fecha_registro' => now(),
                // 'contrasena' no es necesaria para login social, 
                // pero puedes poner un random si tu DB lo exige como NOT NULL
                'contrasena'     => bcrypt(Str::random(16)), 
            ]);
        } else {
            // Si ya existe, opcionalmente actualizamos su token
            $usuario->update(['api_token' => Str::random(60)]);
        }

        return response()->json([
            'res'   => true,
            'token' => $usuario->api_token,
            'user'  => $usuario
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'res'     => false,
            'message' => 'Error de autenticación con Google',
            'error'   => $e->getMessage()
        ], 401);
    }
}
// app/Http/Controllers/Api/AuthController.php

// app/Http/Controllers/Api/AuthController.php

public function getPerfil(Request $request)
{
    // Si la ruta está dentro del middleware 'api.key', 
    // el usuario ya está disponible en el $request
    $user = $request->user(); 

    if (!$user) {
        return response()->json(['error' => 'Usuario no encontrado'], 401);
    }

    return response()->json([
        'nombre' => $user->nombre_usuario,
        'email'  => $user->email,
    ], 200);
}

public function actualizarPassword(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json(['mensaje' => 'No autorizado'], 401);
    }

    $request->validate([
        'password_actual' => 'required',
        'nueva_password'  => 'required|min:6',
    ]);

    // Validamos la contraseña actual usando el campo 'contrasena'
    if (!Hash::check($request->password_actual, $user->contrasena)) {
        return response()->json(['mensaje' => 'La contraseña actual no es correcta'], 401);
    }

    // Actualizamos el campo 'contrasena'
    $user->update([
        'contrasena' => Hash::make($request->nueva_password)
    ]);

    return response()->json(['mensaje' => 'Contraseña actualizada con éxito'], 200);
}

    
}