@extends('layouts.master')

@section('title', 'Mis Citas | PuraSonrisa')

@section('content')

<style>
    .citas-hero {
        height: 38vh;
        min-height: 220px;
        background: linear-gradient(135deg, #0a0a0a 0%, #1a0510 50%, #0a0a0a 100%);
    }
</style>

<!-- Hero -->
<section class="citas-hero relative flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 20% 50%, #cc0247 0%, transparent 50%), radial-gradient(circle at 80% 50%, #08beff 0%, transparent 50%)"></div>
    <div class="relative text-center px-4">
        <span class="block text-[#08beff] text-xs tracking-[0.4em] uppercase font-semibold mb-3">Mi cuenta</span>
        <h1 class="text-4xl font-bold text-white">Mis <span class="text-[#cc0247]">Citas</span></h1>
    </div>
</section>

<!-- Contenido -->
<section class="min-h-screen py-14 px-4" style="background: linear-gradient(to bottom, #fffbf4, #D1CBCB);">
    <div class="max-w-3xl mx-auto">

        @if($citas->isEmpty())
            <!-- Sin citas -->
            <div class="flex flex-col items-center justify-center py-24 text-gray-300 gap-4">
                <i class="bi bi-calendar2-x text-6xl"></i>
                <p class="text-lg font-semibold text-gray-400">Todavía no tienes citas</p>
                <a href="{{ route('reservas') }}"
                   class="mt-2 inline-flex items-center gap-2 px-6 py-3 bg-[#cc0247] hover:bg-[#a8013b] text-white text-sm font-bold rounded-2xl transition-all shadow-[0_4px_18px_rgba(204,2,71,.3)]">
                    <i class="bi bi-plus-circle"></i> Reservar ahora
                </a>
            </div>
        @else
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-gray-800">
                    {{ $citas->count() }} {{ $citas->count() === 1 ? 'cita' : 'citas' }}
                </h2>
                <a href="{{ route('reservas') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#cc0247] hover:bg-[#a8013b] text-white text-xs font-bold rounded-xl transition-all shadow-[0_4px_14px_rgba(204,2,71,.3)]">
                    <i class="bi bi-plus"></i> Nueva cita
                </a>
            </div>

            <div class="flex flex-col gap-4">
                @foreach($citas as $cita)
                @php
                    $esProxima = $cita->fecha >= now()->toDateString();
                    $badgeColor = match($cita->estado) {
                        'confirmada' => 'bg-green-100 text-green-700',
                        'pendiente'  => 'bg-yellow-100 text-yellow-700',
                        'cancelada'  => 'bg-red-100 text-red-600',
                        default      => 'bg-gray-100 text-gray-500',
                    };
                    $badgeIcon = match($cita->estado) {
                        'confirmada' => 'bi-check-circle-fill',
                        'pendiente'  => 'bi-clock-fill',
                        'cancelada'  => 'bi-x-circle-fill',
                        default      => 'bi-dash-circle',
                    };
                @endphp

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex flex-col sm:flex-row sm:items-center gap-4
                            {{ $esProxima ? 'border-l-4 border-l-[#cc0247]' : 'opacity-75' }}">

                    <!-- Fecha cuadro -->
                    <div class="shrink-0 w-16 h-16 rounded-2xl flex flex-col items-center justify-center
                                {{ $esProxima ? 'bg-[#cc0247]' : 'bg-gray-100' }}">
                        <span class="text-xs font-semibold uppercase leading-none {{ $esProxima ? 'text-white/80' : 'text-gray-400' }}">
                            {{ $cita->fecha->translatedFormat('M') }}
                        </span>
                        <span class="text-2xl font-bold leading-tight {{ $esProxima ? 'text-white' : 'text-gray-400' }}">
                            {{ $cita->fecha->format('d') }}
                        </span>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-800 text-sm truncate">
                            {{ $cita->servicio->nombre ?? 'Servicio' }}
                        </p>
                        <div class="flex items-center gap-3 mt-1 flex-wrap">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="bi bi-clock text-[#08beff]"></i>
                                {{ \Carbon\Carbon::parse($cita->hora_inicio)->format('H:i') }} – {{ \Carbon\Carbon::parse($cita->hora_fin)->format('H:i') }}
                            </span>
                            @if($cita->empleado)
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <i class="bi bi-person text-[#cc0247]"></i>
                                {{ $cita->empleado->nombre }}
                            </span>
                            @endif
                            <span class="text-xs text-gray-400 flex items-center gap-1">
                                <i class="bi bi-calendar3"></i>
                                {{ $cita->fecha->translatedFormat('l, d \d\e F \d\e Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-[0.7rem] font-semibold {{ $badgeColor }}">
                            <i class="bi {{ $badgeIcon }}"></i>
                            {{ ucfirst($cita->estado) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection
