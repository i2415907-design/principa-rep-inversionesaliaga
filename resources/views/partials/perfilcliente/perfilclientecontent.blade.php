<h1>Bienvenido, {{ $usuario->nombre_usuario }}</h1>

<form method="POST" action="{{ route('perfil.update') }}">
    @csrf

    <label>Nombre de usuario:</label>
    <input type="text" name="nombre_usuario" value="{{ $usuario->nombre_usuario }}">

    <label>Email:</label>
    <input type="email" name="email" value="{{ $usuario->email }}">

    <label>Nueva contraseña:</label>
    <input type="password" name="password">

    <label>Confirmar nueva contraseña:</label>
    <input type="password" name="password_confirmation">


    <button type="submit">Actualizar</button>
</form>




