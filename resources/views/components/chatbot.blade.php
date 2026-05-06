<style>
    /* Zona de mensajes sin scrollbar visible */
    #chatbot-messages::-webkit-scrollbar { display: none; }
    #chatbot-messages { scrollbar-width: none; }

    /* Transición apertura/cierre del panel */
    #chatbot-panel {
        transform-origin: bottom right;
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    #chatbot-panel.chatbot-hidden {
        opacity: 0;
        transform: scale(0.92) translateY(8px);
        pointer-events: none;
    }

    /* Burbuja de mensaje del bot */
    .msg-bot {
        background: #ffffff;
        color: #1e2535;
        border-radius: 0 14px 14px 14px;
        align-self: flex-start;
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
    }
    /* Burbuja de mensaje del usuario */
    .msg-user {
        background: #08beff;
        color: #fff;
        border-radius: 14px 14px 0 14px;
        align-self: flex-end;
    }
</style>

<!-- ── BOTÓN FLOTANTE ── -->
<button
    id="chatbot-toggle"
    onclick="toggleChat()"
    title="Abrir asistente"
    class="fixed bottom-6 right-6 z-50 w-14 h-14 rounded-full shadow-2xl flex items-center justify-center
           text-white text-2xl transition-transform hover:scale-110 active:scale-95"
    style="background-color: #cc0247;"
>
    <i id="chatbot-icon-open"  class="bi bi-chat-dots-fill"></i>
    <i id="chatbot-icon-close" class="bi bi-x-lg hidden"></i>
</button>

<!-- ── PANEL DEL CHAT ── -->
<div
    id="chatbot-panel"
    class="chatbot-hidden fixed bottom-24 right-6 z-50 w-80 rounded-2xl shadow-2xl flex flex-col overflow-hidden"
    style="height: 480px; background: #f3f4f6;"
>
    <!-- HEADER -->
    <div class="flex items-center justify-between px-4 py-3" style="background: #08beff;">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                <i class="bi bi-robot text-white text-sm"></i>
            </div>
            <div>
                <p class="text-white font-semibold text-sm leading-none">PuraSonrisa</p>
                <p class="text-white/80 text-xs">Asistente virtual</p>
            </div>
        </div>
        <button onclick="toggleChat()" class="text-white/80 hover:text-white transition-colors">
            <i class="bi bi-x-lg text-lg"></i>
        </button>
    </div>

    <!-- ZONA DE MENSAJES -->
    <div
        id="chatbot-messages"
        class="flex-1 overflow-y-auto flex flex-col gap-3 px-4 py-4"
    >
        <!-- Mensaje inicial del bot -->
        <div class="msg-bot text-sm px-3 py-2 max-w-[85%]">
            ¡Hola! 👋 Soy tu asistente virtual.<br>¿En qué puedo ayudarte hoy?
        </div>
    </div>

    <!-- OPCIONES RÁPIDAS -->
    <div id="chatbot-quick" class="px-4 pb-3">
        <p class="text-gray-400 text-xs font-semibold tracking-widest uppercase mb-2">Opciones rápidas:</p>
        <div class="flex flex-wrap gap-2">
            <button onclick="quickOption(this, 'Horarios')"
                class="chatbot-chip flex items-center gap-1 text-xs px-3 py-1.5 rounded-full border border-gray-300
                       text-gray-600 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors">
                <i class="bi bi-clock"></i> Horarios
            </button>

            <button onclick="quickOption(this, 'Servicios y precios')"
                class="chatbot-chip flex items-center gap-1 text-xs px-3 py-1.5 rounded-full border border-gray-300
                       text-gray-600 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors">
                <i class="bi bi-grid"></i> Servicios y precios
            </button>
    
            <button onclick="quickOption(this, 'Ubicación')"
                class="chatbot-chip flex items-center gap-1 text-xs px-3 py-1.5 rounded-full border border-gray-300
                       text-gray-600 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors">
                <i class="bi bi-geo-alt"></i> Ubicación
            </button>

            <button onclick="quickOption(this, 'Contacto')"
                class="chatbot-chip flex items-center gap-1 text-xs px-3 py-1.5 rounded-full border border-gray-300
                       text-gray-600 hover:border-[#cc0247] hover:text-[#cc0247] transition-colors">
                <i class="bi bi-telephone"></i> Contacto
            </button>
        </div>
    </div>


</div>

<script>
    // ── TOGGLE ABRIR / CERRAR ──────────────────────────────────────
    function toggleChat() {
        const panel = document.getElementById('chatbot-panel');
        const iconOpen  = document.getElementById('chatbot-icon-open');
        const iconClose = document.getElementById('chatbot-icon-close');

        panel.classList.toggle('chatbot-hidden');

        const isOpen = !panel.classList.contains('chatbot-hidden');
        iconOpen.classList.toggle('hidden', isOpen);
        iconClose.classList.toggle('hidden', !isOpen);

        if (isOpen) scrollMessages();
    }

    // ── AÑADIR BURBUJA ────────────────────────────────────────────
    // Llama a esta función desde tus onclick para mostrar mensajes
    function addMessage(text, tipo = 'bot') {
        const container = document.getElementById('chatbot-messages');
        const div = document.createElement('div');
        div.className = (tipo === 'user' ? 'msg-user' : 'msg-bot') + ' text-sm px-3 py-2 max-w-[85%]';
        div.innerHTML = text;
        container.appendChild(div);
        scrollMessages();
    }

    // ── SCROLL AL ÚLTIMO MENSAJE ──────────────────────────────────
    function scrollMessages() {
        const container = document.getElementById('chatbot-messages');
        container.scrollTop = container.scrollHeight;
    }

    // ── OPCIÓN RÁPIDA ─────────────────────────────────────────────
    function quickOption(btn, opcion) {
        // 1. Mostrar el mensaje del usuario
        addMessage(opcion, 'user');

        // 2. Esperar 500ms para que parezca natural
        setTimeout(() => {
            // 3. Si es "Servicios y precios", hacer fetch a la BD
            if (opcion === 'Servicios y precios') {
                // Mostrar mensaje de carga
                addMessage('⏳ <i>Cargando servicios...</i>', 'bot');
                
                // Hacer petición AJAX a la ruta /api/chatbot/servicios
                fetch('{{ route('chatbot.servicios') }}')
                    .then(response => {
                        // Verificar si la respuesta es correcta (status 200)
                        if (!response.ok) {
                            throw new Error(`Error HTTP: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Construir el mensaje con los servicios
                        let servicios = '<b>💰 Servicios y Precios:</b><br>';
                        
                        // Recorrer cada servicio y agregarlo al formato HTML
                        data.forEach(servicio => {
                            servicios += `• ${servicio.nombre}: $${parseFloat(servicio.precio).toFixed(2)}<br>`;
                        });
                        
                        // Mostrar los servicios en el chat
                        addMessage(servicios, 'bot');
                    })
                    .catch(error => {
                        // Mostrar el error completo para debugging
                        console.error('Error en fetch:', error);
                        addMessage('❌ <b>Error:</b> No pude cargar los servicios.<br><small>' + error.message + '</small>', 'bot');
                    });
            } else {
                // Diccionario de respuestas estáticas
                const respuestas = {
                    'Horarios': '📅 <b>Horarios:</b><br>Lunes-Viernes: 8:00-18:00<br>Sábado: 9:00-13:00',
                    'Ubicación': '📍 Calle Principal 123<br>Tel: +1-800-SONRISA',
                    'Contacto': '📧 info@purasonrisa.com<br>📞 +1-800-SONRISA',
                };

                // Obtener la respuesta (o usar la por defecto si no existe)
                const respuesta = respuestas[opcion] || '¿Podrías reformular tu pregunta?';

                // Mostrar la respuesta del bot
                addMessage(respuesta, 'bot');
            }
        }, 500);
    }
</script>
