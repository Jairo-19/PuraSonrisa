@extends('layouts.master')

<!-- Título de la pestaña del navegador para esta página -->
@section('title', 'Servicios | PuraSonrisa')

<!-- Contenido principal de la página de servicios -->
@section('content')

<!-- Portada de servicios -->
<section class="relative w-full overflow-hidden servicios-hero">

    <!-- Capa oscura degradada para legibilidad del texto -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>

    <!-- Texto centrado sobre la imagen -->
    <div class="absolute inset-0 flex items-center justify-center">
        <h2 class="text-5xl font-bold text-white drop-shadow-xl tracking-wide text-center leading-tight servicios-titulo">
            Nuestros <span class="text-[#cc0247]">Servicios</span>
        </h2>
    </div>

</section>



<!-- Sección: Servicios más populares -->
<section class="bg-[#fffbf4] py-20 px-6">

    <!-- Título -->
    <div class="max-w-5xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-800">
            Nuestros servicios más <span class="text-[#cc0247]">populares</span>
        </h2>
        <div class="mt-3 w-20 h-1 bg-[#cc0247] mx-auto rounded-full"></div>
    </div>

      

    </div>
</section>





<style>
    .servicios-hero {
        height: 60vh;
        background-image: url("{{ asset('imagenes/ClinicaDental.jpg') }}");
        background-size: cover;
        background-position: center;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .servicios-titulo {
        animation: slideUp 0.8s ease both;
    }
</style>
@endsection