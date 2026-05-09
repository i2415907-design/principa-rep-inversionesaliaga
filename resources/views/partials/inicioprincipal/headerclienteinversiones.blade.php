<header x-data="{ open: false, scrolled: false }" 
        x-init="window.addEventListener('scroll', () => { scrolled = (window.pageYOffset > 40) })"
        class="text-white sticky top-0 z-50 transition-all duration-300 ease-in-out bg-gray-800"
        :class="scrolled ? 'py-2 shadow-xl' : 'py-4 shadow-md'">
         
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between transition-all duration-300">

        <a href="/" class="flex items-center hover:opacity-90 transition-all duration-300 flex-shrink-0">
            <img src="/images/logo/logo1.png" alt="Logo" 
                 class="h-9 md:block transition-all duration-300"
                 :class="scrolled ? 'hidden' : 'hidden md:block'">
            <img src="/images/logo/solologo.png" alt="Logo móvil" 
                 class="h-8 rounded transition-all duration-300"
                 :class="scrolled ? 'block md:hidden h-7' : 'block md:hidden'">
        </a>

        <div class="flex-1 max-w-2xl mx-6">
            <div class="flex w-full group">
                <div class="flex w-full items-center bg-white rounded-full shadow-sm overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-orange-500 transition-all duration-200">
                    <input type="text" placeholder="¿Qué estás buscando?"
                        class="w-full py-2.5 px-5 text-gray-800 text-sm bg-transparent focus:outline-none">
    
                </div>
            </div>
        </div>

        <div class="hidden md:flex items-center space-x-5 flex-shrink-0">
            @include('components.header.menu-items')
        </div>

        <div class="flex md:hidden flex-shrink-0">
            <button @click="open = !open" 
                    class="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

    </div>

    <div x-show="open" 
         class="md:hidden bg-gray-800 rounded-b-xl p-4 space-y-1 border-t border-gray-700 shadow-2xl">
        <nav class="flex flex-col text-sm">
            @include('components.header.menu-items')
        </nav>
    </div>
</header>