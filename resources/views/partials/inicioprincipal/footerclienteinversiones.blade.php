<footer class="bg-gray-900 text-gray-300 py-10">
  <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

    <!-- Logo y descripción -->
    <div>
      <a href="/" class="flex items-center space-x-2 mb-4">
        <img src="/images/logo/solologo.png" alt="Logo" class="h-10">
        <span class="text-white font-bold text-lg">Inversiones Aliaga</span>
      </a>
      <p class="text-sm">
        Tu tienda de confianza. Encuentra lo mejor en tecnología, gadgets y accesorios, con envíos alrededor de Huancayo.
      </p>
    </div>

    <!-- Navegación -->
<div>
    <h4 class="text-white font-semibold mb-3">Navegación</h4>
    <ul class="space-y-2 text-sm">
        <li><a href="/" class="hover:text-white">Inicio</a></li>
        <li><a href="/" class="hover:text-white">Productos</a></li>
        <li><a href="{{ route('paginas.nosotros') }}#contacto" class="hover:text-white">Contáctanos</a></li>
        <li><a href="{{ route('paginas.nosotros') }}" class="hover:text-white">Nosotros</a></li>
    </ul>
</div>

    <!-- Soporte -->
    <div>
      <h4 class="text-white font-semibold mb-3">Soporte</h4>
      <ul class="space-y-2 text-sm">
        <li><a href="/" class="hover:text-white">Preguntas Frecuentes</a></li>
        <li><a href="/" class="hover:text-white">Política de Envíos</a></li>
        <li><a href="/" class="hover:text-white">Términos y Condiciones</a></li>
        <li>
          <a href="/" class="hover:text-white font-semibold text-red-400">
            Libro de Reclamaciones
          </a>
        </li>
      </ul>
    </div>

    <!-- Contacto y redes -->
    <div>
      <h4 class="text-white font-semibold mb-3">Contáctanos</h4>
      <p class="text-sm mb-2">📍 Huancayo, Perú</p>
      <p class="text-sm mb-2">📞 +51 998 404 055</p>
      <p class="text-sm mb-4">✉️ pelpepe072@gmail.com</p>
      
      <div class="flex space-x-4">
        <a href="#" class="hover:text-white" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="#" class="hover:text-white" aria-label="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="#" class="hover:text-white" aria-label="WhatsApp">
          <i class="fab fa-whatsapp"></i>
        </a>
      </div>
    </div>

  </div>

  <!-- Línea divisoria -->
  <div class="border-t border-gray-700 mt-10 pt-6">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between text-sm space-y-4 md:space-y-0">
      <p>&copy; 2025 Inversiones Aliaga. Todos los derechos reservados.</p>

      <!-- Métodos de pago -->
      <div class="flex space-x-4">
        <img src="/images/payments/Mp.png" alt="Mercado pago" class="h-6">
      </div>
    </div>
  </div>
</footer>
