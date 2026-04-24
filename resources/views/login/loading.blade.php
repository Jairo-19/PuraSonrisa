<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuraSonrisa — Cargando</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playwrite+NO:wght@100..400&display=swap');
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animaciones del loader — no reemplazables con utilidades Tailwind */
        .svg-stroke {
            fill: transparent;
            stroke-dasharray: 46.82, 93.64;
            stroke-dashoffset: 46.82;
            stroke: #cc0247;
            opacity: 1;
        }

        .circle { fill: #cc0247; }
        .circle-one { opacity: 0; }

        .svg-wrap .svg-stroke {
            animation: stroke-start 1.6s linear, stroke-end 1.6s 0.8s linear infinite;
        }

        .svg-wrap .circle-one {
            animation: dot-one 0s 0.8s, move-dot 1.6s 0.8s linear infinite;
        }

        .svg-wrap .circle-two,
        .svg-wrap .circle-three {
            animation: move-dot 1.6s 0.8s linear infinite;
        }

        @keyframes dot-one {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @keyframes stroke-start {
            50%  { stroke-dashoffset: 46.82; }
            100% { stroke-dashoffset: 0; }
        }

        @keyframes stroke-end {
            50%  { stroke-dasharray: 46.82, 93.64; stroke-dashoffset: 0;     transform: translateX(0); }
            100% { stroke-dasharray: 0, 93.64;      stroke-dashoffset: -46.82; transform: translateX(10px); }
        }

        @keyframes move-dot {
            50%  { transform: translateX(0); }
            100% { transform: translateX(10px); }
        }

        /* Fade-in para que la página no aparezca de golpe */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        /* 'both' = backwards (aplica el estado inicial durante el delay) + forwards (retiene estado final) */
        .fade-in { animation: fadeIn 0.5s ease-out both; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center gap-8" style="background-color: #fffbf4;">

    <!-- Loader SVG -->
    <div class="fade-in" style="animation-delay: 0.3s;">
        <svg class="svg-wrap" viewBox="0 0 100 50" xmlns="http://www.w3.org/2000/svg"
             width="220" height="110">
            <circle stroke-linecap="round" stroke-width="2" class="svg-stroke"
                    cy="25" cx="50" r="15"></circle>
            <circle class="circle circle-one"  cy="25" cx="35" r="1"></circle>
            <circle class="circle circle-two"  cy="25" cx="45" r="1"></circle>
            <circle class="circle circle-three" cy="25" cx="55" r="1"></circle>
        </svg>
    </div>

    <!-- Texto -->
    <p class="fade-in text-sm font-semibold tracking-widest uppercase text-gray-400"
       style="font-family: 'Open Sans', sans-serif; animation-delay: 0.5s;">
        Preparando tu acceso…
    </p>

    <!-- Redirigir según ?next: 'home' → inicio, cualquier otro → login -->
    <script>
        const allowed = { home: "{{ route('home') }}", login: "{{ route('login') }}" };
        const next    = new URLSearchParams(window.location.search).get('next');
        const destino = allowed[next] ?? allowed.login;
        setTimeout(function () {
            window.location.href = destino;
        }, 3000);
    </script>

</body>
</html>
