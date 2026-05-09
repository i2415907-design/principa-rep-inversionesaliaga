<!-- Botón flotante abajo a la izquierda -->
<div x-data="{ sidebarOpen: false }">
    <button 
        @click="sidebarOpen = true"
        class="fixed bottom-4 left-4 bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-full shadow-lg z-[9999]"
    >
        <!-- Icono hamburguesa -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- SIDEBAR flotante -->
    <div 
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-start items-center z-[9998]"
        @click.away="sidebarOpen = false"
    >
{{-- route('carrito.carritocliente')--}}
        <div class="bg-gray-900 w-64 rounded-r-lg py-8 px-6 shadow-xl text-white space-y-6 mx-2">
            <h2 class="text-xl font-bold text-center">Menú</h2>
            <a href="{{ route('admin.dashboard') }}" class="block text-center hover:bg-gray-700 py-2 rounded">DASHBOARD</a>
            <a href="{{ route('admin.productos') }}" class="block text-center hover:bg-gray-700 py-2 rounded">PRODUCTOS</a>
            <a href="{{ route('admin.ventas') }}" class="block text-center hover:bg-gray-700 py-2 rounded">VENTAS</a>
            <a href="{{ route('admin.pedidos') }}" class="block text-center hover:bg-gray-700 py-2 rounded">PEDIDOS</a>
            <a href="{{ route('admin.reportes') }}" class="block text-center hover:bg-gray-700 py-2 rounded">REPORTES</a>
            <a href="{{ route('admin.ingresosEgresos') }}" class="block text-center hover:bg-gray-700 py-2 rounded">INGRESOS Y EGRESOS</a>
        </div>
    </div>
</div>
