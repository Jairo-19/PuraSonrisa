@extends('layouts.master')

@section('title', 'Mis Citas | PuraSonrisa')

@section('content')

<style>
    .citas-hero {
        height: 36vh;
        min-height: 210px;
        background: linear-gradient(135deg, #0a0a0a 0%, #010e1a 50%, #0a0a0a 100%);
    }

    /* Tarjeta de cita */
    .cita-card {
        transition: transform .2s ease, box-shadow .2s ease;
        border-left: 4px solid transparent;
    }
    .cita-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 48px rgba(0,0,0,.12);
    }
    .cita-card.estado-confirmada { border-left-color: #08beff; }
    .cita-card.estado-completada { border-left-color: #10b981; }

    /* Badges de estado */
    .badge-confirmada { background: rgba(8,190,255,.12);  color: #0a6b8a; }
    .badge-completada { background: rgba(16,185,129,.12); color: #065f46; }

    /* Botón eliminar */
    .btn-eliminar {
        transition: background .18s, color .18s, transform .12s;
    }
    .btn-eliminar:hover {
        background: #cc0247;
        color: #fff;
        transform: scale(1.03);
    }
</style>

<!-- ═══════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════ -->
<section class="citas-hero relative flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 30% 50%, #cc0247 0%, transparent 55%), radial-gradient(circle at 70% 50%, #08beff 0%, transparent 55%)"></div>
    <div class="relative text-center px-4">
        <span class="block text-[#08beff] text-xs tracking-[0.4em] uppercase font-semibold mb-3">Mi cuenta</span>
        <h1 class="text-4xl font-bold text-white">Mis <span class="text-[#cc0247]">Citas</span></h1>
        <p class="mt-3 text-gray-400 text-sm">Consulta y gestiona todas tus citas programadas</p>
    </div>
</section>

<!-- ═══════════════════════════════════════════════
     CONTENIDO
═══════════════════════════════════════════════ -->
<section class="min-h-screen py-14 px-4" style="background: linear-gradient(to bottom, #fffbf4, #D1CBCB);">
    <div class="max-w-3xl mx-auto">

        <!-- Flash de éxito -->
        @if(session('flash_success'))
        <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-4 text-sm font-medium shadow-sm">
            <i class="bi bi-check-circle-fill text-emerald-500 text-lg shrink-0"></i>
            {{ session('flash_success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 rounded-2xl px-5 py-4 text-sm font-medium shadow-sm">
            <i class="bi bi-exclamation-circle-fill text-red-400 text-lg shrink-0"></i>
            {{ session('error') }}
        </div>
        @endif

        <!-- ── ESTADO VACÍO ── -->
        @if($citas->isEmpty())
        <div class="bg-white rounded-3xl shadow-[0_8px_40px_rgba(0,0,0,0.08)] px-8 py-16 text-center">
            <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-6"
                 style="background:linear-gradient(135deg,rgba(8,190,255,.1),rgba(204,2,71,.08))">
                <i class="bi bi-calendar-x text-4xl text-gray-300"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-700 mb-2">No tienes citas programadas</h2>
            <p class="text-gray-400 text-sm max-w-sm mx-auto leading-relaxed mb-7">
                Aún no has reservado ninguna cita. ¡Explora nuestros servicios y agenda tu primera visita!
            </p>
            <a href="{{ route('reservas') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white text-sm font-semibold shadow-md transition hover:scale-105"
               style="background:linear-gradient(135deg,#cc0247,#8f0131)">
                <i class="bi bi-plus-circle"></i> Reservar cita
            </a>
        </div>

        <!-- ── LISTADO DE CITAS ── -->
        @else
        <div class="space-y-4">
            @foreach($citas as $cita)
            @php
                $estadoClass = match($cita->estado) {
                    'confirmada' => 'estado-confirmada',
                    'completada' => 'estado-completada',
                    default      => '',
                };
                $badgeClass = match($cita->estado) {
                    'confirmada' => 'badge-confirmada',
                    'completada' => 'badge-completada',
                    default      => 'bg-gray-100 text-gray-500',
                };
                $estadoIcon = match($cita->estado) {
                    'confirmada' => 'bi-check2-circle',
                    'completada' => 'bi-patch-check',
                    default      => 'bi-question-circle',
                };
                $estadoLabel = match($cita->estado) {
                    'confirmada' => 'Confirmada',
                    'completada' => 'Completada',
                    default      => ucfirst($cita->estado),
                };
            @endphp

            <div class="cita-card {{ $estadoClass }} bg-white rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.07)] overflow-hidden">

                <!-- Cabecera de la tarjeta -->
                <div class="px-6 pt-5 pb-4 flex items-start justify-between gap-3 flex-wrap">

                    <!-- Servicio -->
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0"
                             style="background:linear-gradient(135deg,rgba(204,2,71,.1),rgba(204,2,71,.06))">
                            <i class="bi bi-bandaid text-[#cc0247] text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-bold text-gray-800 truncate leading-tight">
                                {{ $cita->servicio->nombre ?? '—' }}
                            </p>
                            <p class="text-[0.65rem] text-gray-400 uppercase tracking-wider mt-0.5">Servicio</p>
                        </div>
                    </div>

                    <!-- Badge estado -->
                    <span class="{{ $badgeClass }} inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide shrink-0">
                        <i class="bi {{ $estadoIcon }}"></i>{{ $estadoLabel }}
                    </span>
                </div>

                <!-- Datos de la cita -->
                <div class="px-6 pb-2 grid grid-cols-2 gap-x-4 gap-y-3 sm:grid-cols-4">

                    <!-- Día -->
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                             style="background:rgba(8,190,255,.09)">
                            <i class="bi bi-calendar3 text-[#08beff] text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-wider font-semibold">Día</p>
                            <p class="text-sm font-semibold text-gray-700">
                                {{ $cita->fecha->locale('es')->isoFormat('D MMM YYYY') }}
                            </p>
                        </div>
                    </div>

                    <!-- Día de la semana -->
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                             style="background:rgba(8,190,255,.09)">
                            <i class="bi bi-calendar-week text-[#08beff] text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-wider font-semibold">Jornada</p>
                            <p class="text-sm font-semibold text-gray-700 capitalize">
                                {{ $cita->fecha->locale('es')->isoFormat('dddd') }}
                            </p>
                        </div>
                    </div>

                    <!-- Hora -->
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                             style="background:rgba(8,190,255,.09)">
                            <i class="bi bi-clock text-[#08beff] text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-wider font-semibold">Hora</p>
                            <p class="text-sm font-semibold text-gray-700">
                                {{ \Illuminate\Support\Str::substr($cita->hora_inicio, 0, 5) }}
                                <span class="text-gray-400 font-normal">–</span>
                                {{ \Illuminate\Support\Str::substr($cita->hora_fin, 0, 5) }}
                            </p>
                        </div>
                    </div>

                    <!-- Dentista -->
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                             style="background:rgba(8,190,255,.09)">
                            <i class="bi bi-person-badge text-[#08beff] text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[0.6rem] text-gray-400 uppercase tracking-wider font-semibold">Dentista</p>
                            <p class="text-sm font-semibold text-gray-700 truncate">
                                {{ $cita->empleado->nombre ?? '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Motivo (si existe) -->
                @if($cita->motivo)
                <div class="mx-6 mb-4 mt-2 flex items-start gap-2.5 bg-gray-50 rounded-xl px-4 py-3">
                    <i class="bi bi-chat-left-text text-gray-300 mt-0.5 shrink-0"></i>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $cita->motivo }}</p>
                </div>
                @endif

                <!-- Pie de tarjeta: botón eliminar -->
                @if($cita->estado !== 'completada')
                <div class="px-6 pb-5 pt-3 border-t border-gray-50 flex justify-end">
                    <form method="POST" action="{{ route('citas.destroy', $cita) }}"
                          onsubmit="return confirm('¿Seguro que deseas eliminar esta cita? Esta acción no se puede deshacer.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn-eliminar inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-[#cc0247]/30 text-[#cc0247] text-xs font-semibold">
                            <i class="bi bi-trash3"></i> Eliminar cita
                        </button>
                    </form>
                </div>
                @else
                <div class="px-6 pb-5 pt-3 border-t border-gray-50 flex justify-end">
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-400">
                        <i class="bi bi-lock text-gray-300"></i> Cita ya completada — no se puede eliminar
                    </span>
                </div>
                @endif

            </div>
            @endforeach
        </div>

        <!-- Botón nueva cita -->
        <div class="mt-8 text-center">
            <a href="{{ route('reservas') }}"
               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl text-white text-sm font-semibold shadow-lg transition hover:scale-105"
               style="background:linear-gradient(135deg,#08beff,#0a6b8a)">
                <i class="bi bi-plus-circle-fill"></i> Reservar nueva cita
            </a>
        </div>
        @endif

    </div>
</section>

@endsection