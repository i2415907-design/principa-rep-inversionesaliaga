<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Inversiones Aliaga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes pulse-glow {
            from { box-shadow: 0 0 20px rgba(220, 38, 38, 0.3); }
            to { box-shadow: 0 0 30px rgba(220, 38, 38, 0.5); }
        }
        
        .image-container {
            overflow: hidden;
            border-radius: 0.75rem;
            position: relative;
            cursor: pointer;
        }
        
        .image-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .image-modal.active {
            display: flex;
            opacity: 1;
        }
        
        .modal-image {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }
        
        .image-modal.active .modal-image {
            transform: scale(1);
        }
        
        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 40px;
            cursor: pointer;
            z-index: 1001;
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .tech-icon {
            opacity: 0.1;
            animation: tech-float 6s ease-in-out infinite;
        }
        
        @keyframes tech-float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(5deg); }
            66% { transform: translateY(10px) rotate(-3deg); }
        }
        
        .map-container {
            height: 300px;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Modal para imágenes -->
    <div class="image-modal" id="imageModal">
        <span class="close-modal" id="closeModal">&times;</span>
        <img src="" alt="" class="modal-image" id="modalImage">
    </div>

    <!-- Header Simple -->
    <header class="py-6">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3 group">
                <!-- Logo con contorno similar al botón -->
                <div class="bg-gray-900 hover:bg-gray-800 text-white p-3 rounded-xl transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-105 hover-lift">
                    <img src="/images/logo/logo1.png" alt="Logo" class="h-10 rounded hidden md:block">
                    <img src="/images/logo/solologo.png" alt="Logo móvil" class="h-8 rounded md:hidden">
                </div>
            </a>
            
            <a href="/" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center space-x-3 shadow-lg hover:shadow-xl transform hover:scale-105 hover:-rotate-1 hover-lift">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la Tienda</span>
            </a>
        </div>
    </header>

    <main>
        <!-- Hero Section Mejorado -->
        <section class="py-16 bg-white relative overflow-hidden">
            <!-- Círculos de colores -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-100 rounded-full -translate-y-32 translate-x-32 opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-blue-100 rounded-full -translate-x-24 translate-y-24 opacity-50"></div>
            
            <!-- Iconos de gadgets -->
            <i class="fas fa-mobile-alt text-6xl text-gray-300 tech-icon absolute top-1/4 left-1/4"></i>
            <i class="fas fa-headphones text-5xl text-gray-300 tech-icon absolute top-1/3 right-1/3" style="animation-delay: 1s;"></i>
            <i class="fas fa-laptop text-4xl text-gray-300 tech-icon absolute bottom-1/4 right-1/4" style="animation-delay: 2s;"></i>
            <i class="fas fa-tablet-alt text-5xl text-gray-300 tech-icon absolute bottom-1/3 left-1/3" style="animation-delay: 3s;"></i>
            <i class="fas fa-battery-full text-4xl text-gray-300 tech-icon absolute top-2/3 left-2/3" style="animation-delay: 4s;"></i>
            
            <div class="relative max-w-6xl mx-auto px-4 text-center">
                <h1 class="text-5xl md:text-6xl font-bold text-gray-800 mb-6">
                    Conoce <span class="text-red-600">Inversiones Aliaga</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Tu aliado tecnológico en Huancayo. Donde la innovación se encuentra con el servicio personalizado que mereces.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('paginas.catalogo') }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center space-x-2 hover-lift">
                        <i class="fas fa-rocket"></i>
                        <span>Descubre Más</span>
                    </a>
                    <a href="#contacto" class="border-2 border-gray-300 hover:border-red-600 text-gray-700 hover:text-red-600 px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 hover-lift">
                        <i class="fas fa-comments"></i>
                        <span>Hablemos</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Sección Nosotros Mejorada -->
        <section id="nosotros" class="py-20 bg-gray-50">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Nuestra Esencia</h2>
                    <div class="w-24 h-1 bg-red-600 mx-auto rounded-full"></div>
                    <p class="text-gray-600 mt-6 max-w-2xl mx-auto">
                        Más que una tienda, somos tu partner tecnológico de confianza
                    </p>
                </div>
                
                <!-- Tarjetas de Valores -->
                <div class="grid md:grid-cols-3 gap-8 mb-16">
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover border-l-4 border-red-600 hover-lift">
                        <div class="text-red-600 text-3xl mb-4 floating">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Pasión por Servir</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Cada cliente recibe atención personalizada y dedicada, porque tu satisfacción es nuestra prioridad.
                        </p>
                    </div>
                    
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover border-l-4 border-blue-600 hover-lift">
                        <div class="text-blue-600 text-3xl mb-4 floating" style="animation-delay: 0.5s;">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Innovación Constante</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Siempre a la vanguardia con los mejores productos tecnológicos y soluciones inteligentes.
                        </p>
                    </div>
                    
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover border-l-4 border-green-600 hover-lift">
                        <div class="text-green-600 text-3xl mb-4 floating" style="animation-delay: 1s;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Calidad Garantizada</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Productos seleccionados cuidadosamente para ofrecerte solo lo mejor del mercado.
                        </p>
                    </div>
                </div>
                
                <!-- Galería de 4 Imágenes con Modal -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-16">
                    <div class="aspect-square bg-white rounded-xl shadow-md overflow-hidden group cursor-pointer transform transition-all duration-300 image-container hover-lift" onclick="openModal('/images/imagesinversiones/tienda-principal.jpg')">
                        <img src="/images/imagesinversiones/tienda-principal.jpg" 
                             alt="Nuestra Tienda" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors duration-300 hidden">
                            <div class="text-center">
                                <i class="fas fa-store text-2xl text-gray-500 mb-2"></i>
                                <p class="text-sm text-gray-600">Nuestra Tienda</p>
                                <p class="text-xs text-gray-500 mt-1">Click para ampliar</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="aspect-square bg-white rounded-xl shadow-md overflow-hidden group cursor-pointer transform transition-all duration-300 image-container hover-lift" onclick="openModal('/images/imagesinversiones/equipo-trabajo.jpg')">
                        <img src="/images/imagesinversiones/equipo-trabajo.jpg" 
                             alt="Nuestro Equipo" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors duration-300 hidden">
                            <div class="text-center">
                                <i class="fas fa-users text-2xl text-gray-500 mb-2"></i>
                                <p class="text-sm text-gray-600">Nuestro Equipo</p>
                                <p class="text-xs text-gray-500 mt-1">Click para ampliar</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="aspect-square bg-white rounded-xl shadow-md overflow-hidden group cursor-pointer transform transition-all duration-300 image-container hover-lift" onclick="openModal('/images/imagesinversiones/productos-destacados.jpg')">
                        <img src="/images/imagesinversiones/productos-destacados.jpg"
                             alt="Productos Destacados" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors duration-300 hidden">
                            <div class="text-center">
                                <i class="fas fa-mobile-alt text-2xl text-gray-500 mb-2"></i>
                                <p class="text-sm text-gray-600">Productos</p>
                                <p class="text-xs text-gray-500 mt-1">Click para ampliar</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="aspect-square bg-white rounded-xl shadow-md overflow-hidden group cursor-pointer transform transition-all duration-300 image-container hover-lift" onclick="openModal('/images/imagesinversiones/servicios-instalacion.jpg')">
                        <img src="/images/imagesinversiones/servicios-instalacion.jpg" 
                             alt="Servicios de Instalación" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center group-hover:bg-gray-300 transition-colors duration-300 hidden">
                            <div class="text-center">
                                <i class="fas fa-tools text-2xl text-gray-500 mb-2"></i>
                                <p class="text-sm text-gray-600">Servicios</p>
                                <p class="text-xs text-gray-500 mt-1">Click para ampliar</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Misión y Visión Mejoradas -->
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover hover-lift">
                        <div class="flex items-center mb-6">
                            <div class="bg-red-100 text-red-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Nuestra Misión</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Ofrecer productos y servicios tecnológicos de alta calidad que superen las expectativas de nuestros clientes, 
                            brindando una atención cálida, respetuosa y comprometida que garantice experiencias positivas y personalizadas.
                        </p>
                    </div>
                    
                    <div class="bg-white p-8 rounded-2xl shadow-lg card-hover hover-lift">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 text-blue-600 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Visión 2027</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg">
                            Posicionarnos como líderes en el mercado tecnológico regional, expandiendo nuestra presencia en Huancayo 
                            con múltiples sucursales estratégicas, siendo reconocidos por nuestra innovación, servicio excepcional 
                            y competitividad en el ámbito laboral.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Servicios Interactivos -->
        <section class="py-20 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-800 mb-4">Lo que Ofrecemos</h2>
                    <div class="w-24 h-1 bg-red-600 mx-auto rounded-full"></div>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-gray-50 p-6 rounded-2xl text-center card-hover group cursor-pointer border-2 border-transparent hover:border-red-600 transition-all duration-300 hover-lift">
                        <div class="bg-red-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-mobile-alt text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Accesorios Mobile</h4>
                        <p class="text-gray-600 text-sm">Todo para tu smartphone y tablet</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-2xl text-center card-hover group cursor-pointer border-2 border-transparent hover:border-blue-600 transition-all duration-300 hover-lift">
                        <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-headphones text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Audio & Sonido</h4>
                        <p class="text-gray-600 text-sm">La mejor experiencia auditiva</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-2xl text-center card-hover group cursor-pointer border-2 border-transparent hover:border-green-600 transition-all duration-300 hover-lift">
                        <div class="bg-green-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-battery-full text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Energía Portátil</h4>
                        <p class="text-gray-600 text-sm">Power banks y cargadores</p>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-2xl text-center card-hover group cursor-pointer border-2 border-transparent hover:border-purple-600 transition-all duration-300 hover-lift">
                        <div class="bg-purple-600 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 transform group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-tools text-xl"></i>
                        </div>
                        <h4 class="font-bold text-gray-800 text-lg mb-2">Instalación</h4>
                        <p class="text-gray-600 text-sm">Servicio profesional incluido</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección Contacto Acogedora -->
        <section id="contacto" class="py-20 bg-gray-800 text-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4">¿Listo para Conectarte?</h2>
                    <p class="text-gray-300 text-xl mb-12 max-w-2xl mx-auto">
                        Estamos aquí para ayudarte con todo lo que necesites en tecnología
                    </p>
                </div>
                
                <!-- Diseño mejorado para contacto -->
                <div class="grid lg:grid-cols-3 gap-8 mb-12">
                    <!-- Ubicación con mapa grande -->
                    <div class="lg:col-span-2 bg-gray-700 p-8 rounded-2xl card-hover hover-lift">
                        <div class="flex items-center mb-6">
                            <div class="bg-red-600 text-white w-12 h-12 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">Visítanos en nuestra tienda</h3>
                                <p class="text-gray-300 mt-1">Calle Real N°833, Huancayo, Perú</p>
                            </div>
                        </div>
                        
                        <!-- Mapa de Google Maps mejorado -->
                        <div class="map-container mt-4">
<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d975.3991710919299!2d-75.20871599999998!3d-12.071246999999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTLCsDA0JzE2LjUiUyA3NcKwMTInMzEuNCJX!5e0!3m2!1ses!2spe!4v1762198667611!5m2!1ses!2spe" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        
                        <div class="mt-6 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="font-semibold text-red-400">📍 Dirección:</p>
                                <p>Calle Real N°833<br>Huancayo, Perú</p>
                            </div>
                            <div>
                                <p class="font-semibold text-red-400">🕒 Horario:</p>
                                <p>Lunes a Domingo<br>9:00 AM - 9:00 PM</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Teléfono y Email -->
                    <div class="space-y-8">
                        <div class="bg-gray-700 p-8 rounded-2xl card-hover pulse-glow hover-lift">
                            <div class="text-red-400 text-3xl mb-4">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Llámamos</h3>
                            <p class="text-white text-2xl font-bold mb-2">+51 998 404 055</p>
                            <p class="text-gray-300 text-sm mb-4">9:00 AM - 9:00 PM</p>
                            <a href="tel:+51998404055" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-phone mr-2"></i>Llamar ahora
                            </a>
                        </div>
                        
                        <div class="bg-gray-700 p-8 rounded-2xl card-hover hover-lift">
                            <div class="text-red-400 text-3xl mb-4">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">Escríbenos</h3>
                            <p class="text-gray-300 mb-4">pelpepe072@gmail.com</p>
                            <a href="mailto:pelpepe072@gmail.com" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                                <i class="fas fa-envelope mr-2"></i>Enviar email
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Redes Sociales -->
                <div class="bg-gray-700 rounded-2xl p-8 max-w-md mx-auto hover-lift">
                    <h3 class="text-2xl font-bold mb-6 text-center">Síguenos en redes sociales</h3>
                    <div class="flex justify-center space-x-6">
                        <a href="#" class="bg-gray-600 hover:bg-red-600 w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover-lift">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="bg-gray-600 hover:bg-pink-600 w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover-lift">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="bg-gray-600 hover:bg-green-600 w-14 h-14 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover-lift">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                    </div>
                    <p class="text-center text-gray-400 mt-4">Mantente al día con nuestras novedades</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
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
                    <li><a href="/" class="hover:text-white transition-colors">Inicio</a></li>
                    <li><a href="/" class="hover:text-white transition-colors">Productos</a></li>
                    <li><a href="#contacto" class="hover:text-white transition-colors">Contáctanos</a></li>
                    <li><a href="#nosotros" class="hover:text-white transition-colors">Nosotros</a></li>
                </ul>
            </div>

            <!-- Soporte -->
            <div>
                <h4 class="text-white font-semibold mb-3">Soporte</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/" class="hover:text-white transition-colors">Preguntas Frecuentes</a></li>
                    <li><a href="/" class="hover:text-white transition-colors">Política de Envíos</a></li>
                    <li><a href="/" class="hover:text-white transition-colors">Términos y Condiciones</a></li>
                    <li>
                        <a href="/" class="hover:text-white font-semibold text-red-400 transition-colors">
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
                    <a href="#" class="hover:text-white transition-colors" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="hover:text-white transition-colors" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="hover:text-white transition-colors" aria-label="WhatsApp">
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

    <script>
        // Script para desplazamiento suave
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar hash en la URL
            if (window.location.hash === '#contacto') {
                setTimeout(() => {
                    document.getElementById('contacto').scrollIntoView({ 
                        behavior: 'smooth' 
                    });
                }, 100);
            }
            
            // Agregar desplazamiento suave a todos los enlaces internos
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Modal para imágenes
        function openModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            
            modalImage.src = imageSrc;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Cerrar modal al hacer click en la X
        document.getElementById('closeModal').addEventListener('click', closeModal);

        // Cerrar modal al hacer click fuera de la imagen
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</body>
</html>