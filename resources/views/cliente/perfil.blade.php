@extends('layouts.master')

@section('title', 'Mi Perfil | PuraSonrisa')

@section('content')

<style>
    .perfil-hero {
        height: 36vh;
        min-height: 210px;
        background: linear-gradient(135deg, #0a0a0a 0%, #010e1a 50%, #0a0a0a 100%);
    }
    .campo-fila {
        transition: background .18s;
    }
    .campo-fila:hover {
        background: #f8fafc;
    }
    .aviso-admin {
        border-left: 4px solid #08beff;
        background: linear-gradient(90deg, rgba(8,190,255,.06) 0%, rgba(255,251,244,.8) 100%);
    }
    .badge-rol-cliente  { background: rgba(204,2,71,.1);  color: #cc0247; }
    .badge-rol-empleado { background: rgba(8,190,255,.13); color: #0a6b8a; }
    .seccion-medica-header {
        background: linear-gradient(90deg, rgba(204,2,71,.06) 0%, rgba(255,251,244,0) 100%);
        border-bottom: 2px solid rgba(204,2,71,.12);
    }
</style>

<!-- Hero -->
<section class="perfil-hero relative flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 30% 50%, #08beff 0%, transparent 55%), radial-gradient(circle at 70% 50%, #cc0247 0%, transparent 55%)"></div>
    <div class="relative text-center px-4">
        <span class="block text-[#08beff] text-xs tracking-[0.4em] uppercase font-semibold mb-3">Mi cuenta</span>
        <h1 class="text-4xl font-bold text-white">Mi <span class="text-[#08beff]">Perfil</span></h1>
        <p class="mt-3 text-gray-400 text-sm">Consulta toda la información asociada a tu cuenta</p>
    </div>
</section>

<!-- Contenido -->
<section class="min-h-screen py-14 px-4" style="background: linear-gradient(to bottom, #fffbf4, #e8e2d9);">
    <div class="max-w-2xl mx-auto space-y-6">

        {{-- ══════════════════════════════════════════
             TARJETA IDENTIDAD
        ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl shadow-[0_8px_40px_rgba(0,0,0,0.09)] overflow-hidden">

            {{-- Cabecera avatar --}}
            <div class="px-8 py-7 flex items-center gap-5 border-b border-gray-100"
                 style="background: linear-gradient(100deg, rgba(8,190,255,.07) 0%, rgba(204,2,71,.07) 100%)">
                <div class="w-18 h-18 rounded-full flex items-center justify-center shrink-0
                            shadow-[0_4px_22px_rgba(204,2,71,.30)]"
                     style="width:72px;height:72px;background:linear-gradient(135deg,#cc0247,#8f0131)">
                    <span class="text-white font-bold text-3xl uppercase select-none">
                        {{ mb_substr($usuario->nombre ?? $usuario->email, 0, 1) }}
                    </span>
                </div>
                <div class="min-w-0">
                    <p class="text-xl font-bold text-gray-800 truncate leading-tight">{{ $usuario->nombre ?? '—' }}</p>
                    <p class="text-sm text-gray-400 truncate mt-0.5">
                        <i class="bi bi-envelope mr-1 text-[#08beff]"></i>{{ $usuario->email }}
                    </p>
                    <span class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                 {{ $usuario->rol === 'empleado' ? 'badge-rol-empleado' : 'badge-rol-cliente' }}">
                        <i class="bi {{ $usuario->rol === 'empleado' ? 'bi-briefcase' : 'bi-person' }}"></i>
                        {{ ucfirst($usuario->rol) }}
                    </span>
                </div>
            </div>

            {{-- Datos personales --}}
            <div class="px-8 pt-2 pb-4">
                <p class="text-[0.6rem] uppercase tracking-[0.22em] text-gray-400 font-semibold pt-5 pb-2">
                    Datos personales
                </p>

                @php
                    $personales = [
                        ['icon' => 'bi-person-badge',   'color' => '#08beff', 'label' => 'Nombre completo',    'value' => $usuario->nombre],
                        ['icon' => 'bi-envelope',        'color' => '#08beff', 'label' => 'Correo electrónico', 'value' => $usuario->email],
                        ['icon' => 'bi-telephone',       'color' => '#08beff', 'label' => 'Teléfono',           'value' => $usuario->telefono],
                        ['icon' => 'bi-calendar3',       'color' => '#08beff', 'label' => 'Fecha de nacimiento','value' => $usuario->fecha_nacimiento?->format('d/m/Y')],
                        ['icon' => 'bi-card-text',       'color' => '#08beff', 'label' => 'DNI / NIF',          'value' => $usuario->dni],
                    ];
                @endphp

                <div class="divide-y divide-gray-50 rounded-2xl border border-gray-100 overflow-hidden">
                    @foreach($personales as $campo)
                    <div class="campo-fila px-5 py-3.5 flex items-center gap-4">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                             style="background:rgba(8,190,255,.09)">
                            <i class="bi {{ $campo['icon'] }} text-[#08beff] text-base"></i>
                        </div>
                        <div class="flex-1 min-w-0 flex items-center justify-between gap-2">
                            <p class="text-[0.68rem] text-gray-400 uppercase tracking-widest font-semibold whitespace-nowrap">{{ $campo['label'] }}</p>
                            <p class="text-sm text-gray-700 font-medium truncate text-right">{{ $campo['value'] ?? '—' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
             TARJETA HISTORIAL MÉDICO
        ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-3xl shadow-[0_8px_40px_rgba(0,0,0,0.09)] overflow-hidden">

            <div class="seccion-medica-header px-8 py-5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                     style="background:rgba(204,2,71,.10)">
                    <i class="bi bi-clipboard2-pulse text-[#cc0247] text-base"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-sm leading-tight">Historial Médico</p>
                    <p class="text-[0.65rem] text-gray-400">Información clínica registrada en tu ficha</p>
                </div>
            </div>

            <div class="px-8 py-5 space-y-4">

                {{-- Alergias --}}
                <div class="rounded-2xl border overflow-hidden
                            {{ $usuario->alergias ? 'border-[#cc0247]/20' : 'border-gray-100' }}">
                    <div class="px-5 py-3 flex items-center gap-3"
                         style="{{ $usuario->alergias ? 'background:rgba(204,2,71,.05)' : 'background:#f9fafb' }}">
                        <i class="bi bi-capsule text-lg {{ $usuario->alergias ? 'text-[#cc0247]' : 'text-gray-300' }}"></i>
                        <p class="text-[0.68rem] uppercase tracking-widest font-semibold text-gray-500">Alergias</p>
                    </div>
                    <div class="px-5 py-4">
                        @if($usuario->alergias)
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $usuario->alergias }}</p>
                        @else
                            <div class="flex items-center gap-2.5 text-gray-400">
                                <i class="bi bi-check-circle text-green-400 text-lg shrink-0"></i>
                                <p class="text-sm">No se han registrado alergias conocidas.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Condiciones médicas --}}
                <div class="rounded-2xl border overflow-hidden
                            {{ $usuario->condiciones_medicas ? 'border-[#cc0247]/20' : 'border-gray-100' }}">
                    <div class="px-5 py-3 flex items-center gap-3"
                         style="{{ $usuario->condiciones_medicas ? 'background:rgba(204,2,71,.05)' : 'background:#f9fafb' }}">
                        <i class="bi bi-heart-pulse text-lg {{ $usuario->condiciones_medicas ? 'text-[#cc0247]' : 'text-gray-300' }}"></i>
                        <p class="text-[0.68rem] uppercase tracking-widest font-semibold text-gray-500">Condiciones médicas</p>
                    </div>
                    <div class="px-5 py-4">
                        @if($usuario->condiciones_medicas)
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $usuario->condiciones_medicas }}</p>
                        @else
                            <div class="flex items-center gap-2.5 text-gray-400">
                                <i class="bi bi-check-circle text-green-400 text-lg shrink-0"></i>
                                <p class="text-sm">No se han registrado condiciones médicas.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- ══════════════════════════════════════════
             AVISO ACTUALIZACIÓN
        ══════════════════════════════════════════ --}}
        <div class="aviso-admin rounded-2xl px-6 py-5 flex items-start gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 mt-0.5"
                 style="background:rgba(8,190,255,.13)">
                <i class="bi bi-info-circle text-[#08beff] text-lg"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-gray-700 mb-0.5">¿Necesitas actualizar tus datos?</p>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Si deseas modificar cualquier dato de tu perfil, como tu teléfono, DNI, alergias o condiciones médicas,
                    por favor <span class="font-semibold text-[#08beff]">contacta con la administración de la clínica</span>.
                    Nuestro equipo realizará los cambios de forma segura.
                </p>
            </div>
        </div>

    </div>
</section>

@endsection
