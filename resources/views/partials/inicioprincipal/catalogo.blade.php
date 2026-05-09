<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo Inversiones Aliaga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        .tab-active { background-color: #111133 !important; color: white !important; border-color: #111133 !important; }
        .price-circle { background-color: #bef264; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .tab-pane { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @media print { .no-print { display: none !important; } }
        .smooth-transition { transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
    </style>
</head>
<body class="bg-slate-100 flex flex-col min-h-screen">

    <header class="py-6 bg-white shadow-sm no-print">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-3 group">
                <div class="bg-gray-900 text-white p-3 rounded-xl transition-all flex items-center space-x-3 shadow-lg hover:scale-105">
                    <img src="/images/logo/logo1.png" alt="Logo" class="h-10 rounded hidden md:block">
                    <img src="/images/logo/solologo.png" alt="Logo móvil" class="h-8 rounded md:hidden">
                </div>
            </a>
            <div class="flex gap-4">
                <button onclick="downloadPDF()" class="bg-gray-800 hover:bg-black text-white px-5 py-3 rounded-xl font-semibold transition-all flex items-center space-x-2">
                    <i class="fas fa-file-pdf"></i>
                    <span class="hidden sm:inline">Descargar PDF</span>
                </button>
                <a href="/" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-semibold transition-all flex items-center space-x-3">
                    <i class="fas fa-arrow-left"></i>
                    <span>Volver</span>
                </a>
            </div>
        </div>
    </header>

    <main id="catalog-content" class="flex-grow max-w-6xl mx-auto w-full px-6 py-10 bg-white shadow-xl my-6 rounded-3xl">
        
        <div class="text-center mb-10">
            <h1 class="text-5xl font-black text-[#111133] tracking-tighter uppercase">CATÁLOGO DE <span class="text-blue-600">PRODUCTOS</span></h1>
            <p class="text-gray-400 font-bold tracking-widest mt-2 uppercase">Inversiones Aliaga • Huancayo</p>
        </div>

        <div class="flex flex-wrap justify-center gap-4 mb-14 no-print">
            <button onclick="openTab(event, 'moviles')" class="tab-btn border-2 border-black px-10 py-3 rounded-lg font-bold uppercase tracking-wider transition-all tab-active">Móviles</button>
            <button onclick="openTab(event, 'audio')" class="tab-btn border-2 border-black px-10 py-3 rounded-lg font-bold uppercase tracking-wider transition-all bg-white">Audio</button>
            <button onclick="openTab(event, 'energia')" class="tab-btn border-2 border-black px-10 py-3 rounded-lg font-bold uppercase tracking-wider transition-all bg-white">Energía</button>
            <button onclick="openTab(event, 'instalacion')" class="tab-btn border-2 border-black px-10 py-3 rounded-lg font-bold uppercase tracking-wider transition-all bg-white">Instalación</button>
        </div>

        <div id="tab-content">
            
            <div id="moviles" class="tab-pane block">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-blue-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 group-hover:scale-110 smooth-transition"></div>
                            <img src="/images/imagesinversiones/ProtectorIphone16ProMax.png" alt="Producto" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 group-hover:bg-yellow-400 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 35</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <span class="text-blue-600 font-bold text-xs uppercase tracking-widest group-hover:text-blue-400">Seguridad</span>
                            <h3 class="text-2xl font-black text-gray-800 uppercase leading-none mt-1 group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Protector Iphone 16 Pro Max</h3>
                            <p class="text-gray-500 text-sm mt-3 leading-relaxed group-hover:text-gray-300">Case de alta resistencia color Gris x Naranja.</p>
                        </div>
                    </div>
                                        <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-blue-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 group-hover:scale-110 smooth-transition"></div>
                            <img src="/images/imagesinversiones/ProtectoS25Ultra.png" alt="Producto" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 group-hover:bg-yellow-400 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 45</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <span class="text-blue-600 font-bold text-xs uppercase tracking-widest group-hover:text-blue-400">Seguridad</span>
                            <h3 class="text-2xl font-black text-gray-800 uppercase leading-none mt-1 group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Protector Samsung S25 Ultra</h3>
                            <p class="text-gray-500 text-sm mt-3 leading-relaxed group-hover:text-gray-300">Case para celular Samsung S25 Ultra tipo madera.</p>
                        </div>
                    </div>
                                        <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-blue-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 group-hover:scale-110 smooth-transition"></div>
                            <img src="/images/imagesinversiones/PROTECTORIPHONEAMARILLO16PROMAX.png" alt="Producto" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 group-hover:bg-yellow-400 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 35</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <span class="text-blue-600 font-bold text-xs uppercase tracking-widest group-hover:text-blue-400">Seguridad</span>
                            <h3 class="text-2xl font-black text-gray-800 uppercase leading-none mt-1 group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Protector Iphone 16 Pro Max</h3>
                            <p class="text-gray-500 text-sm mt-3 leading-relaxed group-hover:text-gray-300">Case para celular Iphone 16 Pro Max color amarillo.</p>
                        </div>
                    </div>
                    
                                        <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-blue-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 group-hover:scale-110 smooth-transition"></div>
                            <img src="/images/imagesinversiones/REDMINWATCH5ACTIVE.png" alt="Producto" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 group-hover:bg-yellow-400 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 220</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <span class="text-blue-600 font-bold text-xs uppercase tracking-widest group-hover:text-blue-400">Reloj inteligente</span>
                            <h3 class="text-2xl font-black text-gray-800 uppercase leading-none mt-1 group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Smartwatch Redmi REDMIWATCH 5 ACTIVE</h3>
                            <p class="text-gray-500 text-sm mt-3 leading-relaxed group-hover:text-gray-300">Pantalla gigante, llamadas Bluetooth y batería de 18 días al mejor precio.</p>
                        </div>
                    </div>
                    
                                        <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-blue-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 group-hover:scale-110 smooth-transition"></div>
                            <img src="/images/imagesinversiones/REDDSmartwatch.png" alt="Producto" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 group-hover:bg-yellow-400 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 120</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <span class="text-blue-600 font-bold text-xs uppercase tracking-widest group-hover:text-blue-400">Reloj inteligente</span>
                            <h3 class="text-2xl font-black text-gray-800 uppercase leading-none mt-1 group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Smartwatch REDD SMARTWACH</h3>
                            <p class="text-gray-500 text-sm mt-3 leading-relaxed group-hover:text-gray-300">Versatilidad y elegancia con funciones de salud y llamadas al alcance de tu mano.</p>
                        </div>
                    </div>
                    
                </div>
            </div>


    

            <div id="audio" class="tab-pane hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-green-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/WAVEFLEXJBL.png"alt="Audio" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 300</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Audífonos JBL WAVEFLEX</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Sonido envolvente y bajos potentes.</p>
                        </div>
                    </div>
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-green-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/VIBEBEAM2JBL.png"alt="Audio" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 250</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Audífonos JBL VIBE BEAM 2</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Sonidos profundos, comodidad garantizada.</p>
                        </div>
                    </div>
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-green-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/TUNE720JBL.png"alt="Audio" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 350</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Audífonos JBL TUNE 720 BT</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Bajos profundos y potentes.</p>
                        </div>
                    </div>
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-green-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/TourProJBL.png"alt="Audio" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 120</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Audífonos JBL TOUR PRO 3</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Potencia sonora e innovación inteligente en un estuche único.</p>
                        </div>
                    </div>
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-green-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/MovisunT10.png"alt="Audio" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 90</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Audífonos Movisun T10</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Sonido práctico y económico para tu día a día.</p>
                        </div>
                    </div>
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-green-400 rounded-3xl rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/Buds2Pro-Photoroom.png"alt="Audio" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 120</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Audífonos Samsung Bads2Pro</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Sonido premium de alta fidelidad con el ajuste más cómodo de Samsung.</p>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div id="energia" class="tab-pane hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-yellow-400 rounded-3xl -rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/UGREEN30W.png" alt="Energía" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 120</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">UGREEN Nexode RG</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">El cargador con personalidad que combina carga rápida de 30W o 65W con un diseño robótico adorable.</p>
                        </div>
                    </div>
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-yellow-400 rounded-3xl -rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/TRANYCOFIT55W.png" alt="Energía" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 35</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">TRANYCO Fit 55W</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Carga súper rápida de 55W y cable de 2 metros para máxima flexibilidad y potencia.</p>
                        </div>
                    </div>
                    
                     <div class="group relative flex flex-row items-center gap-6 p-6 rounded-3xl bg-white hover:bg-gray-900 smooth-transition cursor-pointer overflow-hidden border border-slate-100">
                        <div class="w-1/2 relative z-10">
                            <div class="absolute inset-0 bg-yellow-400 rounded-3xl -rotate-3 opacity-20 group-hover:rotate-12 smooth-transition"></div>
                            <img src="/images/imagesinversiones/ONCE100W.png" alt="Energía" class="relative z-10 w-full rounded-3xl shadow-md object-cover group-hover:scale-110 smooth-transition">
                            <div class="price-circle absolute -top-4 -right-4 w-20 h-20 rounded-full flex flex-col items-center justify-center z-20 group-hover:scale-125 smooth-transition">
                                <span class="text-sm font-black text-gray-900">S/ 450</span>
                            </div>
                        </div>
                        <div class="w-1/2 relative z-10">
                            <h3 class="text-2xl font-black text-gray-800 uppercase group-hover:text-white group-hover:scale-105 origin-left smooth-transition">Cargador ONCE 1OOW</h3>
                            <p class="text-gray-500 text-sm mt-3 group-hover:text-gray-300">Potencia masiva de 100W en un diseño compacto para cargar tu laptop y celular simultáneamente.</p>
                        </div>
                    </div>
                    
                </div>
            </div>

<div id="instalacion" class="tab-pane hidden">
    <div class="flex flex-col lg:flex-row gap-10 bg-slate-50 p-8 rounded-[40px] border border-slate-200">
        
        <div class="lg:w-1/3 flex flex-col gap-6">
            <div class="relative group overflow-hidden rounded-3xl shadow-lg">
                <img src="/images/imagesinversiones/instalacion.jpg" alt="Instalación profesional" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-[#111133]/80 to-transparent flex items-end p-6">
                    <p class="text-white font-bold italic text-sm">Precisión en cada detalle.</p>
                </div>
            </div>
            <div class="relative group overflow-hidden rounded-3xl shadow-lg">
                <img src="/images/imagesinversiones/maquina.jpg" alt="Soporte técnico" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-gradient-to-t from-blue-600/80 to-transparent flex items-end p-6">
                    <p class="text-white font-bold italic text-sm">Garantía de calidad Aliaga.</p>
                </div>
            </div>
        </div>

        <div class="lg:w-2/3 space-y-8">
            <div>
                <h2 class="text-4xl font-black text-[#111133] uppercase leading-tight">
                    Mucho más que accesorios: <br>
                    <span class="text-blue-600">Servicio Técnico Especializado</span>
                </h2>
                <p class="text-gray-600 mt-4 text-lg leading-relaxed">
                    En <span class="font-bold text-[#111133]">Inversiones Aliaga</span>, entendemos que tu dispositivo es una inversión. Por ello, ofrecemos un soporte diseñado para que personalices tu equipo con precisión profesional.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-600 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="bg-blue-100 p-3 rounded-xl text-blue-600">
                            <i class="fas fa-vial text-xl"></i>
                        </div>
                        <h4 class="font-black text-[#111133] uppercase text-sm">Pruebas en Vivo</h4>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed">Realizamos pruebas de rendimiento real frente a ti. Verificamos velocidad y compatibilidad antes de tu compra.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="bg-green-100 p-3 rounded-xl text-green-600">
                            <i class="fas fa-shield-halved text-xl"></i>
                        </div>
                        <h4 class="font-black text-[#111133] uppercase text-sm">Protección Pro</h4>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed">Instalación experta de micas de vidrio templado y láminas de Hidrogel para pantallas curvas.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-yellow-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="bg-yellow-100 p-3 rounded-xl text-yellow-600">
                            <i class="fas fa-wand-magic-sparkles text-xl"></i>
                        </div>
                        <h4 class="font-black text-[#111133] uppercase text-sm">Cero Burbujas</h4>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed">Garantizamos una adherencia perfecta sin partículas de polvo ni burbujas de aire molestas.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="bg-purple-100 p-3 rounded-xl text-purple-600">
                            <i class="fas fa-user-gear text-xl"></i>
                        </div>
                        <h4 class="font-black text-[#111133] uppercase text-sm">Asesoría Técnica</h4>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed">¿No sabes qué material elegir? Te explicamos las diferencias técnicas según tu uso diario.</p>
                </div>
            </div>

            <div class="bg-[#111133] p-8 rounded-3xl flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <h3 class="text-white font-bold text-xl italic">¿Listo para proteger tu equipo?</h3>
                    <p class="text-blue-300 text-sm">Agenda tu instalación hoy mismo.</p>
                </div>
                <a href="https://wa.me/51998404055" class="bg-white text-[#111133] px-8 py-4 rounded-2xl font-black uppercase tracking-widest hover:bg-blue-400 hover:text-white transition-all flex items-center gap-3">
                    <i class="fab fa-whatsapp text-2xl"></i>
                    Chatear con un técnico
                </a>
            </div>
        </div>
    </div>
</div>

        </div>
    </main>

    <footer class="bg-gray-900 text-gray-300 py-12 no-print">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-xs">&copy; 2026 Inversiones Aliaga. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function openTab(evt, tabName) {
            const panes = document.querySelectorAll('.tab-pane');
            panes.forEach(p => { 
                p.classList.add('hidden'); 
                p.classList.remove('block'); 
            });
            
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(b => { 
                b.classList.remove('tab-active'); 
                b.classList.add('bg-white'); 
            });

            const targetTab = document.getElementById(tabName);
            if (targetTab) {
                targetTab.classList.remove('hidden');
                targetTab.classList.add('block');
                evt.currentTarget.classList.add('tab-active');
                evt.currentTarget.classList.remove('bg-white');
            }
        }

        function downloadPDF() {
            const element = document.getElementById('catalog-content');
            const opt = {
                margin: 0.3,
                filename: 'Catalogo_Aliaga.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>