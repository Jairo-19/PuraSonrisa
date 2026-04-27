@extends('layouts.master')

@section('title', 'Mi Perfil | PuraSonrisa')

@section('content')

<style>
    .perfil-hero {
        height: 38vh;
        min-height: 220px;
        background: linear-gradient(135deg, #0a0a0a 0%, #010e1a 50%, #0a0a0a 100%);
    }
</style>

<!-- Hero -->
<section class="perfil-hero relative flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 30% 50%, #08beff 0%, transparent 55%), radial-gradient(circle at 70% 50%, #cc0247 0%, transparent 55%)"></div>
    <div class="relative text-center px-4">
        <span class="block text-[#08beff] text-xs tracking-[0.4em] uppercase font-semibold mb-3">Mi cuenta</span>
        <h1 class="text-4xl font-bold text-white">Mi <span class="text-[#08beff]">Perfil</span></h1>
    </div>
</section>

<!-- Contenido -->
<section class="min-h-screen py-14 px-4" style="background: linear-gradient(to bottom, #fffbf4, #D1CBCB);">
    <div class="max-w-xl mx-auto">

        <!-- Tarjeta principal -->
        <div class="bg-white rounded-3xl shadow-[0_12px_48px_rgba(0,0,0,0.10)] overflow-hidden">

            <!-- Cabecera con avatar -->
            <div class="bg-gradient-to-r from-[#08beff]/10 to-[#cc0247]/10 px-8 py-8 flex items-center gap-5 border-b border-gray-100">
                <div class="w-16 h-16 rounded-full bg-[#cc0247] flex items-center justify-center shrink-0 shadow-[0_4px_18px_rgba(204,2,71,.35)]">
                    <span class="text-white font-bold text-2xl uppercase">
                        {{ mb_substr($usuario->nombre ?? $usuario->email, 0, 1) }}
                    </span>
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-800">{{ $usuario->nombre ?? '—' }}</p>
                    <p class="text-xs text-gray-400">{{ $usuario->email }}</p>
                    <span class="inline-block mt-1.5 px-2.5 py-0.5 rounded-full text-[0.65rem] font-bold uppercase tracking-wider
                                 {{ $usuario->rol === 'empleado' ? 'bg-[#08beff]/15 text-[#0a6b8a]' : 'bg-[#cc0247]/10 text-[#cc0247]' }}">
                        {{ ucfirst($usuario->rol) }}
                    </span>
                </div>
            </div>

            <!-- Datos -->
            <div class="divide-y divide-gray-50 px-8">

                @php
                    $campos = [
                        ['icon' => 'bi-telephone',      'label' => 'Teléfono',           'value' => $usuario->telefono],
                        ['icon' => 'bi-calendar3',      'label' => 'Fecha de nacimiento', 'value' => $usuario->fecha_nacimiento?->format('d/m/Y')],
                        ['icon' => 'bi-card-text',      'label' => 'DNI',                'value' => $usuario->dni],
                        ['icon' => 'bi-capsule',        'label' => 'Alergias',           'value' => $usuario->alergias],
                        ['icon' => 'bi-heart-pulse',    'label' => 'Condiciones médicas', 'value' => $usuario->condiciones_medicas],
                    ];
                @endphp

                @foreach($campos as $campo)
                <div class="py-4 flex items-start gap-4">
                    <div class="w-8 h-8 rounded-xl bg-gray-50 flex items-center justify-center shrink-0 mt-0.5">
                        <i class="bi {{ $campo['icon'] }} text-[#08beff] text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[0.65rem] text-gray-400 uppercase tracking-widest font-semibold">{{ $campo['label'] }}</p>
                        <p class="text-sm text-gray-700 font-medium mt-0.5">{{ $campo['value'] ?? '—' }}</p>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- Pie -->
            <div class="px-8 py-5 bg-gray-50 border-t border-gray-100"></div>

        </div>

    </div>
</section>

@endsection
