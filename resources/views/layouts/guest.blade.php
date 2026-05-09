<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Iniciar sesión - Inversiones Aliaga</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative bg-gray-900 text-white antialiased">

    <!-- Fondo con imagen y desenfoque -->
    <div class="absolute inset-0">
        <img src="/images/fondos/tienda_fondo.jpg" alt="Fondo" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    </div>

    <!-- Contenido centrado -->
    <main class="relative z-10 min-h-screen flex items-center justify-center">
        <div class="bg-gray-800 bg-opacity-90 p-10 rounded-2xl shadow-2xl max-w-md w-full">
            <!-- Logo -->
            <div class="mb-6 text-center">
                <a href="/">
                    <img src="/images/logo/logo1.png" alt="Logo de la tienda" class="h-16 mx-auto hover:scale-105 transition-transform duration-200">
                </a>
            </div>

            <!-- Slot para contenido del login -->
            {{ $slot }}
        </div>
    </main>

</body>
</html>
