@extends('layouts.admin')

@section('titulo', 'Nuevo cliente')
@section('subtitulo', 'Registro de un nuevo cliente en el sistema')

@section('acciones')
    <a href="{{ route('admin.usuarios') }}"
       class="inline-flex items-center gap-2 px-4 py-[.45rem] border border-[rgba(255,255,255,.12)] rounded-full text-[.78rem] font-semibold text-[rgba(255,255,255,.5)] no-underline transition-all hover:border-[rgba(255,255,255,.35)] hover:text-white">
        <i class="bi bi-arrow-left"></i>
        Volver
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
    .field-input:invalid:not(:placeholder-shown) {
        border-color: rgba(204,2,71,.5);
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
</style>
@endpush

@section('content')

<div class="anim-up max-w-2xl mx-auto">

    <!-- Errores de validación -->
    @if ($errors->any())
        <div class="alert-err">
            @foreach ($errors->all() as $error)
                <p><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.usuarios.store') }}"
          class="bg-[rgba(255,255,255,.025)] border border-[rgba(255,255,255,.07)] rounded-2xl p-8">
        @csrf

        <!-- Datos personales -->
        <p class="section-label">Datos personales</p>

        <div class="grid grid-cols-2 gap-4">
            <!-- Nombre completo -->
            <div class="field-group col-span-2">
                <label class="field-label" for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="nombre"
                       class="field-input" placeholder="Ej. Ana García López"
                       value="{{ old('nombre') }}" required>
            </div>

            <!-- DNI -->
            <div class="field-group">
                <label class="field-label" for="dni">DNI</label>
                <input type="text" id="dni" name="dni"
                       class="field-input" placeholder="Ej. 12345678A"
                       value="{{ old('dni') }}">
            </div>

            <!-- Fecha de nacimiento -->
            <div class="field-group">
                <label class="field-label" for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                       class="field-input"
                       value="{{ old('fecha_nacimiento') }}">
            </div>
        </div>

        <!-- Contacto -->
        <p class="section-label mt-6">Contacto</p>

        <div class="grid grid-cols-2 gap-4">
            <!-- Email -->
            <div class="field-group col-span-2">
                <label class="field-label" for="email">Correo electrónico</label>
                <input type="email" id="email" name="email"
                       class="field-input" placeholder="cliente@ejemplo.com"
                       value="{{ old('email') }}" required>
            </div>

            <!-- Teléfono -->
            <div class="field-group col-span-2">
                <label class="field-label" for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono"
                       class="field-input" placeholder="Ej. 600 000 000"
                       value="{{ old('telefono') }}">
            </div>
        </div>

        <!-- Acceso -->
        <p class="section-label mt-6">Acceso</p>

        <div class="grid grid-cols-2 gap-4">
            <!-- Contraseña -->
            <div class="field-group">
                <label class="field-label" for="password">Contraseña</label>
                <input type="password" id="password" name="password"
                       class="field-input" placeholder="Mínimo 8 caracteres" required>
            </div>

            <!-- Confirmar contraseña -->
            <div class="field-group">
                <label class="field-label" for="password_confirmation">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="field-input" placeholder="Repite la contraseña" required>
            </div>

            <!-- Rol -->
            <div class="field-group col-span-2">
                <label class="field-label" for="rol">Rol</label>
                <select id="rol" name="rol" class="field-input" required>
                    <option value="cliente"   {{ old('rol','cliente') === 'cliente'   ? 'selected' : '' }}>Cliente</option>
                    <option value="empleado"  {{ old('rol') === 'empleado'            ? 'selected' : '' }}>Empleado</option>
                </select>
            </div>
        </div>

        <!-- Historial clínico -->
        <p class="section-label mt-6">Historial clínico</p>

        <div class="grid grid-cols-1 gap-4">
            <!-- Alergias -->
            <div class="field-group">
                <label class="field-label" for="alergias">Alergias conocidas</label>
                <textarea id="alergias" name="alergias"
                          class="field-input"
                          placeholder="Indica las alergias del paciente, o deja vacío si no tiene.">{{ old('alergias') }}</textarea>
            </div>

            <!-- Condiciones médicas -->
            <div class="field-group">
                <label class="field-label" for="condiciones_medicas">Condiciones médicas</label>
                <textarea id="condiciones_medicas" name="condiciones_medicas"
                          class="field-input"
                          placeholder="Condiciones relevantes para el tratamiento dental.">{{ old('condiciones_medicas') }}</textarea>
            </div>
        </div>

        <!-- Botón enviar -->
        <div class="flex justify-end mt-8">
            <button type="submit" class="btn-submit">
                <i class="bi bi-person-plus"></i>
                Crear cliente
            </button>
        </div>

    </form>
</div>

@endsection
