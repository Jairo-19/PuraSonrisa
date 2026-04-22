@extends('layouts.master')

<!-- Título de la pestaña del navegador para esta página -->
@section('title', 'Inicio | PuraSonrisa')

<!-- Contenido principal de la página de inicio -->
@section('content')

    <!--Sección de inicio -->
    <section class="relative h-screen w-full overflow-hidden">

        <!-- Imagen de fondo definida en .hero-bg del bloque <style> al final de la vista -->
        <div class="hero-bg absolute inset-0"></div>

        <!-- Capa semitransparente negra degradada para que el texto sea legible sobre la imagen -->
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

        <!-- Título y subtítulo posicionados en la esquina inferior izquierda con animación de entrada -->
        <div class="absolute bottom-16 left-12 animate-[slideUp_0.8s_ease_both]">
            <h1 class="text-5xl font-bold text-[#cc0247] drop-shadow-lg leading-tight">
                Pura Sonrisa
            </h1>
            <p class="text-white text-xl mt-2 drop-shadow font-light tracking-wide">
                Donde nacen las mejores sonrisas
            </p>
        </div>

    </section>

    <!--Sección de experiencia -->
    <section class="bg-[#fffbf4] py-20 px-8">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12">

            <!-- Imagen de la sección experiencia -->
            <div class="w-full md:w-1/2">
                <img src="{{ asset('imagenes/Sonrisa.jpg') }}"
                     alt="Dentista"
                     class="w-full h-auto rounded-2xl shadow-xl object-cover">
            </div>

            <!-- Texto descriptivo de la experiencia de la clínica -->
            <div class="w-full md:w-1/2">
                <h2 class="text-3xl font-bold text-[#cc0247] mb-4 leading-snug">
                    Más de 25 años trabajando para tu salud bucodental.
                </h2>
                <p class="text-gray-900 text-lg leading-relaxed">
                    En PuraSonrisa llevamos más de 25 años cuidando la salud bucodental de nuestros pacientes. Nuestro equipo de especialistas combina experiencia y tecnología de vanguardia para ofrecerte el mejor tratamiento con la máxima comodidad.
                </p>
            </div>

        </div>
    </section>

    <!--Sección de 2 -->
    <section class="bg-white py-20 px-8">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-12">

            <!-- Texto introductorio -->
            <div class="w-full md:w-1/2">
                <h2 class="text-3xl font-bold text-[#cc0247] mb-4 leading-snug">
                    Tu sonrisa, nuestra prioridad.
                </h2>
                <p class="text-gray-900 text-lg leading-relaxed">
                    Desde revisiones preventivas hasta tratamientos de ortodoncia y estética dental, en PuraSonrisa encontrarás todo lo que necesitas para lucir una sonrisa sana y bonita. Reserva tu cita hoy y da el primer paso.
                </p>
            </div>

            <!-- Imagen -->
            <div class="w-full md:w-1/2">
                <img src="{{ asset('imagenes/Dentista.jpg') }}"
                     alt="Dentista PuraSonrisa"
                     class="w-full h-auto rounded-2xl shadow-xl object-cover border border-[#cc0247]/30">
            </div>

        </div>
    </section>

    <!-- Seccion de servicios generales -->
    <section class="bg-[#78767c] py-20 px-8">

        <div class="max-w-5xl mx-auto text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800">Nuestros <span class="text-[#cc0247]">servicios</span></h2>
            <p class="text-white mt-3 text-lg">Todo lo que necesitas para una sonrisa perfecta</p>
        </div>

        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Carta servicio 1: Ortodoncia -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="overflow-hidden h-48">
                    <img src="{{ asset('imagenes/ortodoncia.jpg') }}"
                         alt="Ortodoncia"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Ortodoncia</h3>
                    <p class="text-gray-900 text-sm leading-relaxed">Alineamos tu dentadura con los tratamientos más modernos, desde brackets hasta alineadores invisibles.</p>
                </div>
            </div>

            <!-- Carta servicio 2: Estética dental -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="overflow-hidden h-48">
                    <img src="{{ asset('imagenes/estetica.jpg') }}"
                         alt="Estética dental"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Estética dental</h3>
                    <p class="text-gray-900 text-sm leading-relaxed">Blanqueamientos, carillas y diseño de sonrisa para que luzcas tu mejor versión cada día.</p>
                </div>
            </div>

            <!-- Carta servicio 3: Implantes -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="overflow-hidden h-48">
                    <img src="{{ asset('imagenes/Implantes.jpg') }}"
                         alt="Implantes"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Implantes</h3>
                    <p class="text-gray-900 text-sm leading-relaxed">Recupera tu sonrisa completa con implantes dentales de alta calidad, duraderos y con aspecto natural.</p>
                </div>
            </div>

        </div>
    </section>

    <style>
        /* Imagen de fondo : fija, cubre toda la pantalla */
        .hero-bg {
            background-image: url("{{ asset('imagenes/ClinicaDental.jpg') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        /* Animación de entrada: el texto sube suavemente desde abajo al cargar */
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

@endsection
