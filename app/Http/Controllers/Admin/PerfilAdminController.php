<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class PerfilAdminController extends Controller
{

    public function edit(Request $request)
    {
        $usuario = Auth::user();

        // Si es admin, carga también todos los usuarios
        $usuarios = [];
        if ($usuario->rol === 'admin') {
            $usuarios = \App\Models\Usuario::all();
        }

        // Cargar avisos y pasarlos siempre para evitar errores en la partial
        $avisos = [];
        if ($usuario->rol === 'admin') {
            $avisos = \App\Models\Aviso::orderBy('fecha_publicacion', 'desc')->get();
        }

        return view('perfiladm.perfildeadmn', compact('usuario', 'usuarios', 'avisos'));
    }
    public function update(Request $request)
    {
        $usuario = Auth::user();

        // Reglas base (válidas para todos)
        $rules = [
            'nombre_usuario' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email,' . $usuario->id_usuario . ',id_usuario',
            'password' => 'nullable|string|min:8|confirmed',
        ];

        // Validar
        $validated = $request->validate($rules);

        $usuario->nombre_usuario = $validated['nombre_usuario'];
        $usuario->email = $validated['email'];

        if (!empty($validated['password'])) {
            $usuario->contrasena = bcrypt($validated['password']);
        }

        // 🔒 Control de roles
        if ($usuario->rol === 'admin') {
            // El admin puede cambiar roles o activar usuarios
            if ($request->filled('rol')) {
                $usuario->rol = $request->rol;
            }
            if ($request->has('activo')) {
                $usuario->activo = (bool)$request->activo;
            }
        }
        if ($usuario->rol !== 'admin') {
            return redirect()->back()->with('error', 'No tienes permisos para modificar tu perfil.');
        }

        
        // Gerente, cajero y vendedor NO pueden tocar roles ni estado

        
        $usuario->save();

        return Redirect::route('perfiladm.perfildeadmn')->with('status', 'Perfil actualizado correctamente.');
    }

        public function store(Request $request)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,gerente,cajero,vendedor',
        ]);

        $usuario = new Usuario();
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->email = $request->email;
        $usuario->contrasena = Hash::make($request->password);
        $usuario->rol = $request->rol;
        $usuario->activo = 1;
        $usuario->fecha_registro = now();
        $usuario->save();

        return redirect()->back()->with('status', 'Usuario creado correctamente.');
    }

    // Actualizar usuario
    public function updateUser(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id_usuario . ',id_usuario',
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|in:admin,gerente,cajero,vendedor',
        ]);

        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        if ($request->filled('password')) {
            $usuario->contrasena = Hash::make($request->password);
        }

        $usuario->activo = $request->has('activo') ? 1 : 0;
        $usuario->save();

        return redirect()->back()->with('status', 'Usuario actualizado correctamente.');
    }

    // Activar / desactivar usuario
    public function toggleStatus($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->activo = !$usuario->activo;
        $usuario->save();
        return redirect()->back()->with('status', 'Estado de usuario actualizado.');
      
}

}