@extends('layouts.admin')

@section('titulo', 'Historial Clínico')
@section('subtitulo', $usuario->nombre)

@section('acciones')
    <a href="{{ route('admin.usuarios') }}"
       class="inline-flex items-center gap-2 px-4 py-[.45rem] bg-[rgba(255,255,255,.06)] border border-[rgba(255,255,255,.1)] rounded-full text-[.78rem] font-medium text-[rgba(255,255,255,.55)] no-underline transition-all hover:text-white hover:border-[rgba(255,255,255,.2)]">
        <i class="bi bi-arrow-left"></i>
        Volver a usuarios
    </a>
@endsection

@push('styles')
<style>
    .nota-card {
        position: relative;
        background: #fffbf4;
        border-radius: 10px;
        padding: 1.35rem 1.5rem 1.1rem;
        color: #1a1a1a;
    }
    .nota-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        border-radius: 10px 0 0 10px;
        background: linear-gradient(180deg, #08beff, #cc0247);
    }
    .nota-linea {
        width: 100%;
        height: 1px;
        background: repeating-linear-gradient(
            to right,
            rgba(8,190,255,.18) 0,
            rgba(8,190,255,.18) 30px,
            transparent 30px,
            transparent 40px
        );
        margin-top: .7rem;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(12px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .nota-anim { animation: slideIn .35s ease-out both; }
    .nota-anim:nth-child(2)  { animation-delay: .05s; }
    .nota-anim:nth-child(3)  { animation-delay: .10s; }
    .nota-anim:nth-child(4)  { animation-delay: .15s; }
    .nota-anim:nth-child(5)  { animation-delay: .20s; }
    .nota-anim:nth-child(6)  { animation-delay: .25s; }
    .nota-anim:nth-child(7)  { animation-delay: .30s; }
    .nota-anim:nth-child(8)  { animation-delay: .35s; }
    .nota-anim:nth-child(9)  { animation-delay: .40s; }
    .nota-anim:nth-child(10) { animation-delay: .45s; }
</style>
@endpush

@section('content')

<!-- ── Flash ──────────────────────────────────────────────── -->
@if(session('flash_success'))
<div id="flash-msg"
     class="flex items-center gap-3 mb-6 px-5 py-[.85rem] bg-[rgba(8,190,255,.08)] border border-[rgba(8,190,255,.2)] rounded-xl text-[.84rem] text-[#08beff] anim-up">
    <i class="bi bi-check-circle-fill text-base shrink-0"></i>
    {{ session('flash_success') }}
</div>
@endif

<!-- ── Ficha del paciente ─────────────────────────────────── -->
<div class="anim-up bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-2xl p-6 mb-8">

    <!-- Cabecera con nombre prominente -->
    <div class="flex items-center gap-4 mb-6 pb-5 border-b border-[rgba(255,255,255,.07)]">
        <div class="w-14 h-14 rounded-full shrink-0 flex items-center justify-center text-[1.15rem] font-bold text-white"
             style="background: linear-gradient(135deg, #cc0247, #08beff);">
            {{ strtoupper(substr($usuario->nombre, 0, 2)) }}
        </div>
        <div>
            <h2 class="font-['Cormorant_Garamond'] text-[1.8rem] font-bold text-white leading-none mb-[.25rem]">
                {{ $usuario->nombre }}
            </h2>
            <div class="flex flex-wrap items-center gap-4 text-[.78rem] text-[rgba(255,255,255,.4)]">
                @if($usuario->email)
                    <span class="inline-flex items-center gap-2"><i class="bi bi-envelope text-[#08beff]"></i>{{ $usuario->email }}</span>
                @endif
                @if($usuario->dni)
                    <span class="inline-flex items-center gap-2"><i class="bi bi-person-vcard text-[#08beff]"></i>{{ $usuario->dni }}</span>
                @endif
                @if($usuario->telefono)
                    <span class="inline-flex items-center gap-2"><i class="bi bi-telephone text-[#08beff]"></i>{{ $usuario->telefono }}</span>
                @endif
                @if($usuario->fecha_nacimiento)
                    <span class="inline-flex items-center gap-2"><i class="bi bi-calendar3 text-[#08beff]"></i>{{ $usuario->fecha_nacimiento->format('d/m/Y') }}</span>
                @endif
                <span class="inline-flex items-center gap-1 px-2 py-[.2rem] rounded-full text-[.7rem] font-semibold
                    {{ $usuario->rol === 'empleado'
                        ? 'bg-[rgba(8,190,255,.12)] text-[#08beff] border border-[rgba(8,190,255,.2)]'
                        : 'bg-[rgba(204,2,71,.1)] text-[#ff6b8a] border border-[rgba(204,2,71,.2)]' }}">
                    <i class="bi {{ $usuario->rol === 'empleado' ? 'bi-person-badge' : 'bi-person' }}"></i>
                    {{ ucfirst($usuario->rol) }}
                </span>
            </div>
        </div>
    </div>

    <!-- Datos médicos clave -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Alergias -->
        <div class="bg-[rgba(204,2,71,.06)] border border-[rgba(204,2,71,.15)] rounded-xl p-4">
            <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill text-[#cc0247] text-[.9rem]"></i>
                <span class="text-[.7rem] font-semibold tracking-[.1em] uppercase text-[#cc0247]">Alergias</span>
            </div>
            @if($usuario->alergias && trim($usuario->alergias) !== '')
                <p class="text-[.85rem] text-[rgba(255,255,255,.75)] leading-relaxed m-0">{{ $usuario->alergias }}</p>
            @else
                <p class="text-[.82rem] text-[rgba(255,255,255,.25)] italic m-0">Sin alergias registradas</p>
            @endif
        </div>

        <!-- Condición médica -->
        <div class="bg-[rgba(8,190,255,.06)] border border-[rgba(8,190,255,.15)] rounded-xl p-4">
            <div class="flex items-center gap-2 mb-2">
                <i class="bi bi-heart-pulse-fill text-[#08beff] text-[.9rem]"></i>
                <span class="text-[.7rem] font-semibold tracking-[.1em] uppercase text-[#08beff]">Situación médica</span>
            </div>
            @if($usuario->condiciones_medicas && trim($usuario->condiciones_medicas) !== '')
                <p class="text-[.85rem] text-[rgba(255,255,255,.75)] leading-relaxed m-0">{{ $usuario->condiciones_medicas }}</p>
            @else
                <p class="text-[.82rem] text-[rgba(255,255,255,.25)] italic m-0">Sin condiciones registradas</p>
            @endif
        </div>

    </div>
</div>

<!-- ── Zona principal: notas + formulario ───────────────────── -->
<div class="grid grid-cols-1 xl:grid-cols-[1fr_340px] gap-6 items-start">

    <!-- Lista de notas -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-['Cormorant_Garamond'] text-[1.3rem] font-bold text-white leading-none">
                Notas clínicas
            </h3>
            <span class="text-[.75rem] text-[rgba(255,255,255,.32)]">
                {{ $historial->count() }} {{ $historial->count() === 1 ? 'nota' : 'notas' }}
            </span>
        </div>

        @if($historial->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 bg-[rgba(255,255,255,.02)] border border-dashed border-[rgba(255,255,255,.1)] rounded-2xl text-[rgba(255,255,255,.25)]">
                <i class="bi bi-journal-text text-[2.8rem] mb-3 opacity-40"></i>
                <p class="text-[.88rem] m-0">Aún no hay notas para este paciente.</p>
                <p class="text-[.78rem] mt-1 m-0 opacity-60">Añade la primera nota en el formulario.</p>
            </div>
        @else
            <div class="flex flex-col gap-3">
                @foreach($historial as $i => $nota)
                <div class="nota-card nota-anim">
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <span class="inline-flex items-center gap-2 text-[.73rem] font-semibold text-[rgba(0,0,0,.45)]">
                            <i class="bi bi-calendar3"></i>
                            {{ $nota->fecha instanceof \Carbon\Carbon ? $nota->fecha->format('d/m/Y') : \Carbon\Carbon::parse($nota->fecha)->format('d/m/Y') }}
                        </span>
                        <form method="POST"
                              action="{{ route('admin.historial.destroy', $nota) }}"
                              onsubmit="return confirm('¿Eliminar esta nota?')"
                              class="shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-transparent border-0 p-[.2rem_.4rem] rounded text-[rgba(0,0,0,.25)] text-[.85rem] cursor-pointer transition-colors hover:text-[#cc0247]"
                                    title="Eliminar nota">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </form>
                    </div>
                    <p class="text-[.88rem] leading-[1.7] text-[#1a1a1a] m-0 whitespace-pre-wrap">{{ $nota->descripcion }}</p>

                    <!-- Imágenes adjuntas -->
                    @if($nota->imagenes->isNotEmpty())
                    <div class="nota-linea"></div>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach($nota->imagenes as $img)
                        <a href="{{ asset($img->ruta) }}" target="_blank" rel="noopener"
                           class="group relative w-20 h-20 rounded-lg overflow-hidden border-2 border-transparent hover:border-[#08beff] transition-all shrink-0">
                            <img src="{{ asset($img->ruta) }}" alt="{{ $img->nombre }}"
                                 class="w-full h-full object-cover">
                            <span class="absolute inset-0 bg-[rgba(0,0,0,.45)] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                <i class="bi bi-arrows-fullscreen text-white text-sm"></i>
                            </span>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div class="nota-linea"></div>
                    @endif
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Formulario nueva nota -->
    <div class="sticky top-[88px]">
        <div class="bg-[rgba(255,255,255,.03)] border border-[rgba(255,255,255,.07)] rounded-2xl p-5">
            <h3 class="font-['Cormorant_Garamond'] text-[1.2rem] font-bold text-white mb-4 leading-none">
                <i class="bi bi-pencil-square text-[#08beff] mr-2 text-[1rem]"></i>
                Añadir nota
            </h3>

            <form method="POST" action="{{ route('admin.historial.store', $usuario) }}"
                  enctype="multipart/form-data">
                @csrf

                <textarea
                    name="descripcion"
                    rows="8"
                    placeholder="Escribe aquí cualquier observación clínica, tratamiento aplicado, seguimiento…"
                    class="w-full bg-[rgba(255,255,255,.05)] border {{ $errors->has('descripcion') ? 'border-[#cc0247]' : 'border-[rgba(255,255,255,.1)]' }} rounded-xl px-4 py-3 text-[.85rem] text-[rgba(255,255,255,.85)] placeholder:text-[rgba(255,255,255,.2)] resize-none outline-none transition-colors focus:border-[#08beff] focus:bg-[rgba(8,190,255,.04)] leading-[1.7]"
                    autofocus>{{ old('descripcion') }}</textarea>

                @error('descripcion')
                    <p class="text-[.76rem] text-[#ff6b8a] mt-1 mb-0">{{ $message }}</p>
                @enderror

                <!-- Adjuntar fotos -->
                <div class="mt-3">
                    <label for="fotos"
                           class="flex items-center gap-2 w-full px-4 py-[.7rem] bg-[rgba(255,255,255,.03)] border border-dashed {{ $errors->has('fotos') || $errors->has('fotos.*') ? 'border-[#cc0247]' : 'border-[rgba(255,255,255,.12)]' }} rounded-xl cursor-pointer transition-colors hover:border-[#08beff] hover:bg-[rgba(8,190,255,.03)]">
                        <i class="bi bi-image text-[#08beff] text-base shrink-0"></i>
                        <span class="text-[.78rem] text-[rgba(255,255,255,.35)]" id="fotos-label">Adjuntar fotos (opcional, máx. 10)</span>
                        <input type="file" id="fotos" name="fotos[]" multiple accept="image/*"
                               class="hidden" onchange="actualizarLabel(this)">
                    </label>
                    @error('fotos')
                        <p class="text-[.76rem] text-[#ff6b8a] mt-1 mb-0">{{ $message }}</p>
                    @enderror
                    @error('fotos.*')
                        <p class="text-[.76rem] text-[#ff6b8a] mt-1 mb-0">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mt-3">
                    <span class="text-[.72rem] text-[rgba(255,255,255,.2)]">
                        <i class="bi bi-calendar-check mr-1"></i>
                        Fecha: hoy, {{ now()->format('d/m/Y') }}
                    </span>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-[.55rem] bg-[#08beff] hover:bg-[#06aaeb] active:bg-[#059fd8] rounded-full text-[.8rem] font-semibold text-white border-0 cursor-pointer transition-all hover:-translate-y-px active:translate-y-0"
                            style="box-shadow: 0 4px 18px rgba(8,190,255,.3);">
                        <i class="bi bi-plus-lg"></i>
                        Añadir nota
                    </button>
                </div>
            </form>
        </div>


    </div>

</div>

@endsection

@push('scripts')
<script>
    // Auto-ocultar flash a los 4s
    const flash = document.getElementById('flash-msg');
    if (flash) {
        setTimeout(() => {
            flash.style.transition = 'opacity .5s';
            flash.style.opacity = '0';
            setTimeout(() => flash.remove(), 500);
        }, 4000);
    }

    // Actualizar etiqueta del input de fotos
    function actualizarLabel(input) {
        const label = document.getElementById('fotos-label');
        if (input.files && input.files.length > 0) {
            label.textContent = input.files.length === 1
                ? input.files[0].name
                : `${input.files.length} fotos seleccionadas`;
            label.classList.add('text-[#08beff]');
        } else {
            label.textContent = 'Adjuntar fotos (opcional, máx. 10)';
            label.classList.remove('text-[#08beff]');
        }
    }
</script>
@endpush
