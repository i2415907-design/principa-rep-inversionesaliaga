<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 p-8 bg-gray-800 text-white shadow-lg rounded-lg border border-gray-700">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h2 class="text-2xl font-bold text-center mb-6">Iniciar Sesión</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Correo electrónico')" class="text-white" />
                <x-text-input id="email"
                              class="block mt-1 w-full rounded-md bg-white text-black border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Contraseña')" class="text-white" />
                <x-text-input id="password"
                              class="block mt-1 w-full rounded-md bg-white text-black border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Recordarme y enlaces -->
            <div class="flex items-center justify-between mb-4">
                <label class="inline-flex items-center text-sm">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                    <span class="ml-2 text-white ">Recordarme</span>
                </label>


            </div>

            <!-- Botón Login -->
            <div class="mb-4">
                <x-primary-button class="w-full justify-center bg-orange-500 hover:bg-orange-600">
                    {{ __('Iniciar sesión') }}
                </x-primary-button>
            </div>

            <div class="mt-4">
            <a href="{{ route('google.login') }}"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-100 transition">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google" class="w-5 h-5">
                <span>Iniciar sesión con Google</span>
                </a>
            </div>
            <!-- Enlace a registro -->
            @if (Route::has('register'))
                <p class="text-sm text-center text-white">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}" class="text-orange-400 hover:underline">Regístrate aquí</a>
                </p>
            @endif
        </form>
    </div>
</x-guest-layout>
