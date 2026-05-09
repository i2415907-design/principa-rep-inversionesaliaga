<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Exitoso - Inversiones Aliaga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animaciones de entrada suaves */
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
        
        @keyframes scale-in {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-scale-in { animation: scale-in 0.4s ease-out forwards; animation-delay: 0.2s; opacity: 0; }
        
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen flex items-center justify-center p-4">
        
        <!-- Tarjeta Principal -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm max-w-md w-full p-8 md:p-10 text-center animate-fade-in-up">
            
            <!-- Icono de Éxito (Círculo verde suave) -->
            <div class="mb-6 animate-scale-in">
                <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto border-4 border-green-100">
                    <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <!-- Título y Descripción -->
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight mb-2">
                ¡Pago Exitoso!
            </h1>
            
            <p class="text-gray-500 text-sm leading-relaxed mb-8">
                Tu pago ha sido procesado correctamente. Recibirás un correo de confirmación en breve.
            </p>

            <!-- Cajas de Información -->
            <div class="space-y-3 mb-8 text-left">
                <!-- Mensaje de Gracias -->
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-700 font-medium">
                        Gracias por tu compra en <span class="text-gray-900 font-bold">Inversiones Aliaga</span>.
                    </p>
                </div>
                
                <!-- Mensaje de Recibo -->
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-700 font-medium">
                        Su recibo será entregado junto a su producto.
                    </p>
                </div>
            </div>

            <!-- Botón de Acción Principal -->
            <a href="{{ url('/') }}" 
               class="inline-flex items-center justify-center gap-2 w-full bg-gray-900 text-white py-3.5 rounded-full font-semibold hover:bg-black transition-all duration-200 shadow-sm hover:shadow-lg text-sm">
                Volver al Inicio
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 00-1-1h-4a1 1 0 00-1 1v4a1 1 0 001 1h4z"/>
                </svg>
            </a>
            
        </div>
    </div>
</body>
</html>