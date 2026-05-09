<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Inversiones Aliaga</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex">
    @include('partials.admindashp.sidebardashad') {{-- Sidebar Fijo --}}
    
    <div class="flex-1">
        @include('partials.admindashp.headerdashad')

        <main class="p-8 ml-48"> {{-- ml-48 para dar espacio al sidebar --}}
            @yield('dashhomeventas')
        </main>

        @include('partials.admindashp.footerdashad')
    </div>
</body>
</html>