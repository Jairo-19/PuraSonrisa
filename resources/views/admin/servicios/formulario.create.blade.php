@extends('layouts.admin')

@section('titulo', 'Nuevo servicio')
@section('subtitulo', 'Añadir un nuevo servicio a la clínica')

@section('acciones')
    <a href="{{ route('admin.servicios.index') }}"
       class="inline-flex items-center gap-2 px-4 py-[.45rem] border border-[rgba(255,255,255,.12)] rounded-full text-[.78rem] font-semibold text-[rgba(255,255,255,.5)] no-underline transition-all hover:border-[rgba(255,255,255,.35)] hover:text-white">
        <i class="bi bi-arrow-left"></i>
        Volver
    </a>
@endsection

@push('styles')
<style>
    /* Toggle: cambia apariencia cuando el checkbox está marcado */
    .toggle-wrapper:has(input:checked) {
        border-color: rgba(8,190,255,.35);
        background: rgba(8,190,255,.06);
    }
    .toggle-wrapper:has(input:checked) .toggle-track { background: #08beff; }
    .toggle-wrapper:has(input:checked) .toggle-thumb { transform: translateX(18px); }
    .toggle-wrapper:has(input:checked) .toggle-text  { color: #fff; }

    /* Zona de subida: estado drag-over gestionado por JS */
    .upload-zone.drag-over {
        border-color: #08beff;
        background: rgba(8,190,255,.04);
    }

    /* Input file invisible superpuesto sobre toda la zona */
    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="anim-up max-w-2xl mx-auto">

    <!-- Errores de validación -->
    @if ($errors->any())
        <div class="bg-[rgba(204,2,71,.1)] border border-[rgba(204,2,71,.26)] rounded-[10px] px-4 py-3 mb-6">
            @foreach ($errors->all() as $error)
                <p class="text-[.82rem] text-[#ff6b8a] m-0 leading-[1.8]">
                    <i class="bi bi-exclamation-circle me-1"></i>{{ $error }}
                </p>
            @endforeach
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.servicios.store') }}"
          enctype="multipart/form-data"
          class="bg-[rgba(255,255,255,.025)] border border-[rgba(255,255,255,.07)] rounded-2xl p-8">
        @csrf

        <!-- Sección: información del servicio -->
        <p class="block text-[.65rem] font-bold tracking-[.16em] uppercase text-[rgba(255,255,255,.22)] pb-[.6rem] mb-[1.2rem] border-b border-[rgba(255,255,255,.06)]">
            Información del servicio
        </p>

        <!-- Campo: nombre del servicio -->
        <div class="mb-5">
            <label class="block text-[.75rem] font-semibold tracking-[.08em] uppercase text-[rgba(255,255,255,.38)] mb-[.45rem]"
                   for="nombre">
                Nombre del servicio
            </label>
            <input type="text"
                   id="nombre"
                   name="nombre"
                   class="w-full bg-[rgba(255,255,255,.04)] border border-[rgba(255,255,255,.08)] rounded-[10px] px-4 py-3 text-[.88rem] text-white outline-none transition-all placeholder:text-[rgba(255,255,255,.2)] focus:border-[#08beff] focus:bg-[rgba(8,190,255,.05)] focus:shadow-[0_0_0_3px_rgba(8,190,255,.1)]"
                   placeholder="Ej. Limpieza dental"
                   value="{{ old('nombre') }}"
                   required>
        </div>

        <!-- Campo: descripción del servicio -->
        <div class="mb-5">
            <label class="block text-[.75rem] font-semibold tracking-[.08em] uppercase text-[rgba(255,255,255,.38)] mb-[.45rem]"
                   for="descripcion">
                Descripción
            </label>
            <textarea id="descripcion"
                      name="descripcion"
                      class="w-full bg-[rgba(255,255,255,.04)] border border-[rgba(255,255,255,.08)] rounded-[10px] px-4 py-3 text-[.88rem] text-white outline-none transition-all resize-y min-h-[100px] placeholder:text-[rgba(255,255,255,.2)] focus:border-[#08beff] focus:bg-[rgba(8,190,255,.05)] focus:shadow-[0_0_0_3px_rgba(8,190,255,.1)]"
                      placeholder="Breve descripción del servicio ofrecido…">{{ old('descripcion') }}</textarea>
        </div>

        <!-- Campo: imagen del servicio -->
        <div class="mb-5">
            <label class="block text-[.75rem] font-semibold tracking-[.08em] uppercase text-[rgba(255,255,255,.38)] mb-[.45rem]">
                Imagen del servicio
            </label>
            <div class="upload-zone relative border-2 border-dashed border-[rgba(255,255,255,.1)] rounded-[12px] px-6 py-8 text-center cursor-pointer transition-all bg-[rgba(255,255,255,.02)] hover:border-[#08beff] hover:bg-[rgba(8,190,255,.04)]"
                 id="upload-zone">

                <input type="file" name="imagen" id="imagen" accept="image/*">

                <!-- Placeholder: se oculta al seleccionar imagen -->
                <div id="upload-placeholder">
                    <i class="bi bi-image text-[2rem] text-[rgba(255,255,255,.2)] block mb-2"></i>
                    <p class="text-[.82rem] text-[rgba(255,255,255,.35)] mb-1">
                        Arrastra una imagen o
                        <span class="text-[#08beff] font-semibold">haz clic</span>
                        para seleccionar
                    </p>
                    <p class="text-[.72rem] text-[rgba(255,255,255,.2)]">PNG, JPG, WEBP — máx. 2 MB</p>
                </div>

                <!-- Vista previa: se muestra al seleccionar imagen -->
                <img id="preview-img"
                     class="hidden max-h-[180px] rounded-lg object-cover mx-auto"
                     src=""
                     alt="Vista previa">
            </div>
        </div>

        <!-- Campo: estado activo / inactivo -->
        <div class="mb-5">
            <label class="block text-[.75rem] font-semibold tracking-[.08em] uppercase text-[rgba(255,255,255,.38)] mb-[.45rem]">
                Estado
            </label>
            <label class="toggle-wrapper flex items-center gap-[.85rem] px-4 py-3 bg-[rgba(255,255,255,.04)] border border-[rgba(255,255,255,.08)] rounded-[10px] cursor-pointer transition-all select-none">
                <input type="checkbox"
                       name="activo"
                       id="activo"
                       value="1"
                       class="sr-only"
                       {{ old('activo', '1') == '1' ? 'checked' : '' }}>

                <!-- Pista del toggle -->
                <span class="toggle-track w-10 h-[22px] bg-[rgba(255,255,255,.12)] rounded-full relative flex-shrink-0 transition-colors">
                    <!-- Pulgar del toggle -->
                    <span class="toggle-thumb w-4 h-4 bg-white rounded-full absolute top-[3px] left-[3px] transition-transform shadow-sm"></span>
                </span>

                <!-- Texto dinámico del estado -->
                <span class="toggle-text text-[.85rem] font-medium text-[rgba(255,255,255,.55)] transition-colors"
                      id="toggle-label">
                    Activo — visible en el catálogo
                </span>
            </label>
        </div>

        <!-- Barra de acciones: cancelar y enviar -->
        <div class="flex items-center justify-between mt-8 pt-6 border-t border-[rgba(255,255,255,.06)]">
            <a href="{{ route('admin.servicios.index') }}"
               class="text-[.82rem] text-[rgba(255,255,255,.35)] hover:text-white transition-colors no-underline">
                Cancelar
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-8 py-3 bg-[#cc0247] border-0 rounded-[10px] text-[.84rem] font-bold text-white cursor-pointer transition-all hover:bg-[#a8013b] hover:shadow-[0_6px_22px_rgba(204,2,71,.38)] hover:-translate-y-px active:translate-y-0">
                <i class="bi bi-plus-lg"></i>
                Crear servicio
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    /* Vista previa de la imagen seleccionada */
    const input       = document.getElementById('imagen');
    const preview     = document.getElementById('preview-img');
    const placeholder = document.getElementById('upload-placeholder');
    const zone        = document.getElementById('upload-zone');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    /* Retroalimentación visual al arrastrar archivos sobre la zona */
    zone.addEventListener('dragover',  () => zone.classList.add('drag-over'));
    zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));
    zone.addEventListener('drop',      () => zone.classList.remove('drag-over'));

    /* Actualiza el texto del toggle según el estado del checkbox */
    const toggle = document.getElementById('activo');
    const label  = document.getElementById('toggle-label');

    function actualizarEtiqueta() {
        label.textContent = toggle.checked
            ? 'Activo — visible en el catálogo'
            : 'Inactivo — no se mostrará en servicios';
    }

    toggle.addEventListener('change', actualizarEtiqueta);
    actualizarEtiqueta();
</script>
@endpush
