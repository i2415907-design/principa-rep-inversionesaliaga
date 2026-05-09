<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inversiones Aliaga</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    @include('partials.checkoutpartial.chekcoutheader')

    <main class="p-8">

        @yield('checkoutclientecompra')

  {{-- Aquí se inyecta el contenido de cada página --}}
    </main>

    @include('partials.checkoutpartial.chekoutfooter')
    <script src="https://unpkg.com/alpinejs" defer></script>
</body>
</html>