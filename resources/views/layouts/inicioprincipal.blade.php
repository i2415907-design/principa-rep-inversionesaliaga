<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inversiones Aliaga</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body >
    
 {{-- <div class="min-h-screen flex items-center justify-center bg-gray-800 p-4">
    <div class="text-center">
        <a href="{{ route('paginas.nosotros') }}" class="inline-block hover:opacity-90 transition transform hover:scale-105">
            <img src="/images/logo/logo1.png" alt="Logo" class="h-24 md:h-32 lg:h-40 rounded hidden md:block mx-auto">
            <img src="/images/logo/solologo.png" alt="Logo móvil" class="h-20 rounded md:hidden mx-auto">
        </a>
        
    </div>
</div> --}} 

 @include('partials.inicioprincipal.headerclienteinversiones')

    <main class="p-8">
        @yield('contentinicioprincipal')  
    </main>

      @include('partials.inicioprincipal.footerclienteinversiones')  

    
    <script src="https://unpkg.com/alpinejs" defer></script>
    
    {{-- Script para manejar carrito después del login/logout --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Limpiar carrito si se hizo logout
            @if(session('limpiar_carrito'))
                localStorage.removeItem('carrito');
                console.log('🧹 Carrito limpiado después del logout');
            @endif

            // Sincronizar carrito si el usuario está autenticado
            @auth
                sincronizarCarritoPostLogin();
            @endauth
        });

        @auth
        function sincronizarCarritoPostLogin() {
            console.log('🔄 Sincronizando carrito después del login...');
            
            const carritoGuest = JSON.parse(localStorage.getItem('carrito') || '[]');

            fetch('/api/carrito/sincronizar-post-login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                credentials: 'same-origin',
                body: JSON.stringify({ carrito: carritoGuest })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('✅ Carrito sincronizado:', data.message);
                    
                    // Sobrescribir el localStorage con el carrito del usuario
                    if (data.carrito && data.carrito.length > 0) {
                        localStorage.setItem('carrito', JSON.stringify(data.carrito));
                        console.log('📦 Carrito cargado desde BD:', data.carrito);
                        
                        // Actualizar contador del carrito si existe
                        actualizarContadorCarrito();
                    } else {
                        // Si no hay carrito en BD, mantener el localStorage actual
                        console.log('ℹ️ No hay carrito en BD, manteniendo localStorage actual');
                    }
                }
            })
            .catch(error => {
                console.error('❌ Error al sincronizar carrito:', error);
            });
        }
        @endauth

        function actualizarContadorCarrito() {
            const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
            const totalItems = carrito.reduce((total, item) => total + item.cantidad, 0);
            
            // Actualizar contador en el header si existe
            const contador = document.getElementById('contador-carrito');
            if (contador) {
                contador.textContent = totalItems;
            }
        }
    </script>
