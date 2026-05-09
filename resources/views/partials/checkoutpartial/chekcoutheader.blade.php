<header class="bg-gray-800 text-white py-3 shadow-md sticky top-0 z-50" x-data="{ open: false }">
  <div class="max-w-7xl mx-auto px-4 flex flex-col space-y-3">
    
    <!-- Fila de Logo centrado -->
    <div class="flex justify-center w-full">
      <a href="/" class="hover:opacity-90 transition">
        <!-- Logo desktop -->
        <img src="/images/logo/logo1.png" alt="Logo" class="h-10 rounded hidden md:block mx-auto">
        <!-- Logo móvil -->
        <img src="/images/logo/solologo.png" alt="Logo móvil" class="h-8 rounded md:hidden mx-auto">
      </a>
    </div>

  </div>



        <!-- Menú desplegable mobile -->
        <div x-show="open" x-transition class="md:hidden bg-gray-700 rounded-lg p-4 space-y-4">
            <nav class="flex flex-col space-y-3 text-sm">
                @include('components.header.menu-items')
            </nav>
        </div>

    </div>
</header>
