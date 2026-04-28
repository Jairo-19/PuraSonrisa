@extends('layouts.admin')

@section('titulo', 'Nueva cita')
@section('subtitulo', 'Crear una cita manualmente desde el panel')

@section('acciones')
    <a href="{{ route('admin.agenda') }}"
       class="inline-flex items-center gap-2 px-4 py-[.45rem] border border-[rgba(255,255,255,.12)] rounded-full text-[.78rem] font-semibold text-[rgba(255,255,255,.5)] no-underline transition-all hover:border-[rgba(255,255,255,.35)] hover:text-white">
        <i class="bi bi-arrow-left"></i>
        Volver a la agenda
    </a>
@endsection

@push('styles')
<style>
    .field-group { margin-bottom: 1.25rem; }

    .field-label {
        display: block;
        font-size: .75rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: rgba(255,255,255,.38);
        margin-bottom: .45rem;
    }

    .field-input {
        width: 100%;
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 10px;
        padding: .75rem 1rem;
        font-family: 'DM Sans', sans-serif;
        font-size: .88rem;
        color: #fff;
        outline: none;
        transition: border-color .2s, background .2s, box-shadow .2s;
        appearance: none;
    }
    .field-input::placeholder { color: rgba(255,255,255,.2); }
    .field-input:focus {
        border-color: #08beff;
        background: rgba(8,190,255,.05);
        box-shadow: 0 0 0 3px rgba(8,190,255,.1);
    }

    select.field-input option { background: #1a1a26; color: #fff; }
    textarea.field-input { resize: vertical; min-height: 90px; }

    .section-label {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: rgba(255,255,255,.22);
        padding-bottom: .6rem;
        margin-bottom: 1.2rem;
        border-bottom: 1px solid rgba(255,255,255,.06);
    }

    .btn-submit {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .8rem 2rem;
        background: #cc0247;
        border: none; border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: .84rem; font-weight: 700;
        color: #fff; cursor: pointer;
        transition: background .2s, box-shadow .2s, transform .15s;
    }
    .btn-submit:hover {
        background: #a8013b;
        box-shadow: 0 6px 22px rgba(204,2,71,.38);
        transform: translateY(-1px);
    }
    .btn-submit:active { transform: translateY(0); }

    .alert-err {
        background: rgba(204,2,71,.1);
        border: 1px solid rgba(204,2,71,.26);
        border-radius: 10px;
        padding: .75rem 1rem;
        margin-bottom: 1.5rem;
    }
    .alert-err p { font-size: .82rem; color: #ff6b8a; }

    .alert-warn {
        background: rgba(255,193,7,.08);
        border: 1px solid rgba(255,193,7,.22);
        border-radius: 10px;
        padding: .75rem 1rem;
        margin-bottom: 1.5rem;
        font-size: .82rem;
        color: #ffc107;
    }

    /* Hint bajo el select de servicio que muestra duración */
    .field-hint {
        font-size: .74rem;
        color: rgba(255,255,255,.28);
        margin-top: .3rem;
    }
</style>
@endpush

@section('content')

<div class="anim-up max-w-2xl mx-auto">

    {{-- Flash de error de disponibilidad --}}
    @if(session('error'))
    <div class="alert-warn">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
    </div>
    @endif

    {{-- Errores de validación --}}
    @if($errors->any())
    <div class="alert-err">
        @foreach($errors->all() as $error)
        <p><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('admin.citas.store') }}"
          class="bg-[rgba(255,255,255,.025)] border border-[rgba(255,255,255,.07)] rounded-2xl p-8">
        @csrf

        {{-- ── Paciente y servicio ──────────────────────── --}}
        <p class="section-label">Paciente y servicio</p>

        <div class="grid grid-cols-2 gap-4">

            <div class="field-group col-span-2">
                <label class="field-label" for="paciente_id">Paciente</label>
                <select id="paciente_id" name="paciente_id" class="field-input" required>
                    <option value="">Selecciona un paciente…</option>
                    @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ old('paciente_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->nombre }} — {{ $c->email }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="field-group col-span-2">
                <label class="field-label" for="servicio_id">Servicio</label>
                <select id="servicio_id" name="servicio_id" class="field-input" required>
                    <option value="">Selecciona un servicio…</option>
                    @foreach($servicios as $s)
                    <option value="{{ $s->id }}"
                            data-duracion="{{ $s->duracion_minutos }}"
                            {{ old('servicio_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nombre }} ({{ $s->duracion_minutos }} min)
                    </option>
                    @endforeach
                </select>
                <p class="field-hint" id="hint-duracion"></p>
            </div>

        </div>

        {{-- ── Fecha y horario ─────────────────────────── --}}
        <p class="section-label mt-2">Fecha y horario</p>

        <div class="grid grid-cols-3 gap-4">

            <div class="field-group col-span-3 sm:col-span-1">
                <label class="field-label" for="fecha">Fecha</label>
                <input type="date" id="fecha" name="fecha"
                       class="field-input"
                       value="{{ old('fecha', $fechaDefault) }}"
                       min="{{ now()->toDateString() }}"
                       required>
            </div>

            <div class="field-group">
                <label class="field-label" for="hora_inicio">Hora inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio"
                       class="field-input"
                       value="{{ old('hora_inicio', '08:00') }}"
                       min="08:00" max="19:30" step="900"
                       required>
            </div>

            <div class="field-group">
                <label class="field-label" for="hora_fin">Hora fin</label>
                <input type="time" id="hora_fin" name="hora_fin"
                       class="field-input"
                       value="{{ old('hora_fin', '08:30') }}"
                       min="08:00" max="20:00" step="900"
                       required>
            </div>

        </div>

        {{-- ── Motivo (opcional) ───────────────────────── --}}
        <p class="section-label mt-2">Observaciones</p>

        <div class="field-group">
            <label class="field-label" for="motivo">Motivo / notas (opcional)</label>
            <textarea id="motivo" name="motivo" class="field-input"
                      placeholder="Ej. Primera visita, revisión anual…">{{ old('motivo') }}</textarea>
        </div>

        {{-- ── Aviso auto-asignación ───────────────────── --}}
        <div class="flex items-start gap-2.5 px-4 py-3 bg-[rgba(8,190,255,.06)] border border-[rgba(8,190,255,.15)] rounded-xl mb-6 text-[.78rem] text-[rgba(255,255,255,.45)]">
            <i class="bi bi-info-circle-fill text-[#08beff] mt-[.15rem] shrink-0"></i>
            El sistema asignará automáticamente la consulta libre y el empleado con menos citas en ese tramo horario.
        </div>

        {{-- ── Botones ─────────────────────────────────── --}}
        <div class="flex items-center gap-3">
            <button type="submit" class="btn-submit">
                <i class="bi bi-calendar-plus-fill"></i>
                Crear cita
            </button>
            <a href="{{ route('admin.agenda') }}"
               class="inline-flex items-center gap-2 px-5 py-[.8rem] border border-[rgba(255,255,255,.1)] rounded-[10px] text-[.84rem] font-semibold text-[rgba(255,255,255,.4)] no-underline transition-all hover:border-[rgba(255,255,255,.3)] hover:text-white">
                Cancelar
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    var selServicio  = document.getElementById('servicio_id');
    var inputInicio  = document.getElementById('hora_inicio');
    var inputFin     = document.getElementById('hora_fin');
    var hintDuracion = document.getElementById('hint-duracion');

    /**
     * Dado HH:MM y minutos, devuelve HH:MM sumando la duración.
     * Si supera 20:00 (1200 min) devuelve null.
     */
    function sumarMinutos(hhmm, mins) {
        var parts = hhmm.split(':');
        var total = parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10) + mins;
        if (total > 20 * 60) return null;
        var h = Math.floor(total / 60);
        var m = total % 60;
        return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0');
    }

    function actualizarFin() {
        var opt = selServicio.options[selServicio.selectedIndex];
        var dur = opt ? parseInt(opt.dataset.duracion, 10) : NaN;

        if (!isNaN(dur) && dur > 0 && inputInicio.value) {
            hintDuracion.textContent = 'Duración: ' + dur + ' minutos';
            var fin = sumarMinutos(inputInicio.value, dur);
            if (fin) {
                inputFin.value = fin;
            }
        } else {
            hintDuracion.textContent = '';
        }
    }

    selServicio.addEventListener('change', actualizarFin);
    inputInicio.addEventListener('change', actualizarFin);

    // Ejecutar al cargar si ya hay valores seleccionados (vuelta con old())
    if (selServicio.value && inputInicio.value) {
        actualizarFin();
    }
}());
</script>
@endpush
