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

<!-- Sección: Catálogo de servicios -->
<section style="background: linear-gradient(to bottom, #fffbf4, #D1CBCB);" class="py-20 px-6">

    <!-- TOP 3 -->
    <div class="max-w-5xl mx-auto text-center mb-10">
        <h2 class="text-4xl font-bold text-gray-800">
            Nuestros 3 mejores <span class="text-[#cc0247]">servicios</span>
        </h2>
        <div class="mt-4 w-20 h-1 bg-gradient-to-r from-[#cc0247] to-[#08beff] mx-auto rounded-full"></div>
    </div>

    <!-- Tarjetas top 3: orden visual de podio → izquierda=2º, centro=1º, derecha=3º -->
    @php
        // $top3[0]=1º más pedido, $top3[1]=2º, $top3[2]=3º
        // Reordenamos para el podio: [1º visual izq, 2º visual centro, 3º visual der]
        $podio = [
            ['servicio' => $top3->get(1), 'pos' => 2, 'sombra' => 'hover:shadow-[0_18px_64px_rgba(192,192,192,0.95)]',  'badge' => '🥈', 'altura' => 'h-52'],
            ['servicio' => $top3->get(0), 'pos' => 1, 'sombra' => 'hover:shadow-[0_18px_56px_rgba(255,215,0,0.7)]',   'badge' => '🥇', 'altura' => 'h-64'],
            ['servicio' => $top3->get(2), 'pos' => 3, 'sombra' => 'hover:shadow-[0_18px_64px_rgba(205,127,50,0.95)]',  'badge' => '🥉', 'altura' => 'h-48'],
        ];
    @endphp
    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-3 gap-8 mb-20 items-end">
        @foreach($podio as $item)
            @if($item['servicio'])
            <div class="relative rounded-2xl overflow-hidden {{ $item['altura'] }}
                        shadow-[0_8px_36px_rgba(0,0,0,0.22)]
                        {{ $item['sombra'] }}
                        hover:-translate-y-1.5 transition-all duration-300 group">

                <!-- Foto -->
                @if($item['servicio']->imagen)
                    <img src="{{ asset('imagenes/' . $item['servicio']->imagen) }}"
                         alt="{{ $item['servicio']->nombre }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-[#fffbf4] flex items-center justify-center">
                        <i class="bi bi-tooth text-5xl text-[#cc0247]/30"></i>
                    </div>
                @endif

                <!-- Badge de posición -->
                <div class="absolute top-3 left-3 text-2xl drop-shadow-md">{{ $item['badge'] }}</div>

                <!-- Nombre: aparece al hover con overlay oscuro -->
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition-all duration-300 flex items-end justify-center pb-5">
                    <span class="text-white font-bold text-lg opacity-0 group-hover:opacity-100 translate-y-3 group-hover:translate-y-0 transition-all duration-300 drop-shadow-lg px-4 text-center">
                        {{ $item['servicio']->nombre }}
                    </span>
                </div>

            </div>
            @endif
        @endforeach
    </div>

    <!-- Separador -->
    <div class="max-w-5xl mx-auto border-t border-gray-300/60 mb-16"></div>

    <!-- Título de sección catálogo completo -->
    <div class="max-w-5xl mx-auto text-center mb-14">
        <span class="inline-block text-[#08beff] text-xs tracking-[0.3em] uppercase font-semibold mb-3">Lo que ofrecemos</span>
        <h2 class="text-4xl font-bold text-gray-800">
            Todos nuestros <span class="text-[#cc0247]">servicios</span>
        </h2>
        <div class="mt-4 w-20 h-1 bg-gradient-to-r from-[#cc0247] to-[#08beff] mx-auto rounded-full"></div>
    </div>

    <!-- Cards generadas dinámicamente desde la base de datos -->
    <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">

        @foreach($servicios as $servicio)
        <div class="flex flex-col rounded-2xl overflow-hidden bg-white
                    border border-gray-200
                    shadow-[0_8px_36px_rgba(0,0,0,0.22)]
                    hover:shadow-[0_18px_56px_rgba(0,0,0,0.35)]
                    hover:-translate-y-1.5 transition-all duration-300 h-full">

            <!-- Foto fija en altura -->
            <div class="h-44 w-full shrink-0 overflow-hidden">
                @if($servicio->imagen)
                    <img src="{{ asset('imagenes/' . $servicio->imagen) }}"
                         alt="{{ $servicio->nombre }}"
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full bg-[#fffbf4] flex items-center justify-center">
                        <i class="bi bi-tooth text-5xl text-[#cc0247]/30"></i>
                    </div>
                @endif
            </div>

            <!-- Línea de acento rosa→azul -->
            <div class="h-1 shrink-0 bg-gradient-to-r from-[#cc0247] to-[#08beff]"></div>

            <!-- Contenido -->
            <div class="flex flex-col flex-1 px-6 py-5 gap-2">
                <h3 class="text-base font-bold text-gray-800 leading-snug">{{ $servicio->nombre }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed flex-1">{{ $servicio->descripcion }}</p>
            </div>

        </div>
        @endforeach

    </div>
</section>

<style>
    .servicios-hero {
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
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .servicios-titulo {
        animation: slideUp 0.8s ease both;
    }
</style>
@endsection