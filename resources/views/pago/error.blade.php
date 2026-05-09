<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error en Pago - Inversiones Aliaga</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
            <div class="text-red-500 text-6xl mb-4">❌</div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Error en el Pago</h1>
            <p class="text-gray-600 mb-6">Ha ocurrido un error al procesar tu pago. Por favor, intenta nuevamente.</p>
            
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <p class="text-red-800 font-semibold">Si el problema persiste, contacta con soporte.</p>
            </div>
            
            <div class="flex space-x-4 justify-center">
                <a href="{{ url('/carrito') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition duration-200">
                    Volver al Carrito
                </a>
                <a href="{{ url('/') }}" class="bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition duration-200">
                    Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</body>
</html>