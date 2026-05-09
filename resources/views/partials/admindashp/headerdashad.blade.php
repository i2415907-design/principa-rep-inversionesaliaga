<header class="bg-gray-800 text-white py-3 shadow-md sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between flex-wrap gap-4">

        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2 hover:opacity-90 transition">
            <img src="/images/logo/logo1.png" alt="Logo" class="h-10 rounded hidden md:block">
            <img src="/images/logo/solologo.png" alt="Logo móvil" class="h-8 rounded md:hidden">
        </a>

        <!-- Bienvenida en desktop -->
        <div class="hidden md:flex items-center bg-gray-300 text-black px-4 py-2 rounded-md shadow-md space-x-4 flex-1 mx-4 max-w-2xl">
            <!-- Imagen -->

            <!-- Texto -->
            <div class="flex flex-col w-full space-y-1 overflow-hidden">
                <h2 class="text-xs uppercase font-semibold tracking-wider text-gray-800">Bienvenido</h2>
                <div class="flex justify-between items-center w-full text-sm text-gray-700 flex-wrap">
                    <span class="font-bold text-black truncate">{{ Auth::user()->nombre_usuario ?? 'Ana Maria' }}</span>
                    <div class="flex space-x-4 text-xs">
                        <span>Code: {{ Auth::user()->id_usuario ?? '000001' }}</span>
                        <span>Rol: {{ Auth::user()->rol ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nombre en móvil (compacto y sin ocupar espacio de más) -->
        <div class="md:hidden text-sm text-center text-white flex-1">
            <span class="block font-semibold">{{ Auth::user()->nombre_usuario ?? 'Ana Maria' }}</span>
        </div>

        <!-- Íconos desktop -->
        <div class="hidden md:flex items-center space-x-6">
            @include('components.header.menu-dashboard')
        </div>

        <!-- Botón hamburguesa móvil -->
        <button @click="open = !open" class="md:hidden bg-gray-700 px-3 py-2 rounded-lg focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Menú desplegable móvil -->
    <div x-show="open" x-transition class="md:hidden bg-gray-700 rounded-lg p-4 space-y-4">
        <nav class="flex flex-col space-y-3 text-sm">
            @include('components.header.menu-dashboard')
        </nav>
    </div>
</header>
