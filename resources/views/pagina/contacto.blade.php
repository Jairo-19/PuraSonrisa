@extends('layouts.master')

<!-- Título de la pestaña del navegador para esta página -->
@section('title', 'Contacto | PuraSonrisa')

<!-- Contenido principal de la página de contacto -->
@section('content')

    <!-- Hero de contacto -->
    <section class="relative w-full overflow-hidden contacto-hero">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <h1 class="text-5xl font-bold text-white drop-shadow-xl tracking-wide text-center leading-tight contacto-titulo">
                Contacta con <span class="text-[#cc0247]">nosotros</span>
            </h1>
        </div>
    </section>

    <!-- Sección de información de contacto -->
    <section style="background: linear-gradient(to bottom, #fffbf4, #D1CBCB);" class="py-20 px-8">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-start gap-16">

            <!-- Bloque de texto — izquierda -->
            <div class="w-full lg:w-1/2 contact-text">
                <span class="inline-block text-[#08beff] text-xs tracking-[0.3em] uppercase font-semibold mb-4">Estamos aquí para ti</span>
                <h3 class="text-3xl md:text-4xl font-bold text-gray-800 leading-snug mb-6">
                    En Pura Sonrisa estamos encantados de ayudarte a mejorar tu sonrisa
                </h3>
                <div class="w-12 h-1 bg-[#cc0247] rounded mb-6"></div>
                <p class="text-gray-600 text-lg leading-relaxed">
                    En Clínica Dental Pura Sonrisa estamos especializados en ofrecer un servicio de calidad y confianza, combinando un trato humano y cercano con la tecnología más avanzada en el ámbito odontológico.
                </p>
            </div>

            <!-- Tabla de contacto — derecha -->
            <div class="w-full lg:w-1/2 contact-cards">
                <div class="flex flex-col gap-5">

                    <!-- Dirección -->
                    <div class="flex items-start gap-5 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#cc0247]/10 flex items-center justify-center">
                            <i class="bi bi-geo-alt-fill text-[#cc0247] text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-1">Dirección</h4>
                            <p class="text-gray-800 font-medium">Calle de la Sonrisa, 123<br>Ciudad Dental, CP 45678</p>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="flex items-start gap-5 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#08beff]/10 flex items-center justify-center">
                            <i class="bi bi-telephone-fill text-[#08beff] text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-1">Teléfono</h4>
                            <p class="text-gray-800 font-medium">+34 912 345 678</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start gap-5 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#cc0247]/10 flex items-center justify-center">
                            <i class="bi bi-envelope-fill text-[#cc0247] text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-1">Email</h4>
                            <p class="text-gray-800 font-medium">contacto@purasonrisa.com</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <style>

        /* Animación: sube y aparece desde abajo */
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Hero de contacto */
        .contacto-hero {
            height: 60vh;
            background-image: url("{{ asset('imagenes/ClinicaDental.jpg') }}");
            background-size: cover;
            background-position: center;
            animation: heroZoom 8s ease-out forwards;
        }
        @keyframes heroZoom {
            from { background-size: 115%; }
            to   { background-size: 100%; }
        }
        .contacto-titulo {
            animation: fadeSlideUp 0.8s ease both;
        }

        /* Animación: aparece con fade simple desde arriba */
        @keyframes fadeSlideDown {
            from { opacity: 0; transform: translateY(-16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Subtítulo: entra primero desde arriba */
        .hero-subtitle {
            opacity: 0;
            animation: fadeSlideDown 0.7s ease forwards;
            animation-delay: 0.2s;
        }

        /* Título principal: entra después desde abajo */
        .hero-title {
            opacity: 0;
            animation: fadeSlideUp 0.8s ease forwards;
            animation-delay: 0.55s;
        }

        /* Sección de info: bloque de texto entra desde la izquierda */
        .contact-text {
            opacity: 0;
            animation: fadeSlideRight 0.8s ease forwards;
            animation-delay: 0.2s;
        }

        /* Sección de info: tarjetas entran desde la derecha */
        .contact-cards {
            opacity: 0;
            animation: fadeSlideLeft 0.8s ease forwards;
            animation-delay: 0.45s;
        }

        @keyframes fadeSlideRight {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeSlideLeft {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }
    </style>

@endsection