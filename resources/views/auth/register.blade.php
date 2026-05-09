<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 p-8 bg-gray-800 text-white shadow-lg rounded-lg border border-gray-700">
        <h2 class="text-2xl font-bold text-center mb-6">Registro de Usuario</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Nombre')" class="text-white" />
                <x-text-input id="name" class="block mt-1 w-full bg-white text-black border-gray-300 shadow-sm rounded-md focus:ring-orange-500 focus:border-orange-500"
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Correo electrónico')" class="text-white" />
                <x-text-input id="email" class="block mt-1 w-full bg-white text-black border-gray-300 shadow-sm rounded-md focus:ring-orange-500 focus:border-orange-500"
                              type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Contraseña')" class="text-white" />
                <x-text-input id="password" class="block mt-1 w-full bg-white text-black border-gray-300 shadow-sm rounded-md focus:ring-orange-500 focus:border-orange-500"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="text-white" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white text-black border-gray-300 shadow-sm rounded-md focus:ring-orange-500 focus:border-orange-500"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
            </div>

            <!-- Botón -->
            <div class="flex items-center justify-between mt-6 flex-col gap-4">
                <a class="text-sm text-orange-400 hover:underline" href="{{ route('login') }}">
                    ¿Ya tienes cuenta?
                </a>
                
                <x-primary-button class="bg-orange-500 hover:bg-orange-600">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
