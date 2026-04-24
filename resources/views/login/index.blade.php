<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PuraSonrisa — Iniciar sesión</title>

    <!-- Icono de la pestaña -->
    <link rel="icon" href="{{ asset('imagenes/LogoPuraSonrisa.webp') }}" type="image/webp">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root { --azul:#08beff; --rosa:#cc0247; --oscuro:#0d0d14; --borde:rgba(255,255,255,0.07); }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'DM Sans',sans-serif;background:var(--oscuro);min-height:100vh;display:flex;overflow:hidden}

        .blob{position:absolute;border-radius:60% 40% 55% 45%/45% 55% 40% 60%;filter:blur(90px);opacity:.16;pointer-events:none}

        .panel-left{position:relative;width:42%;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:3rem 4rem;overflow:hidden;border-right:1px solid var(--borde)}
        .bl1{width:440px;height:440px;background:var(--rosa);top:50%;left:50%;transform:translate(-50%,-50%)}
        .bl2{width:200px;height:200px;background:var(--azul);bottom:4%;right:-4%}
        .panel-left-inner{position:relative;z-index:2;text-align:center;animation:fadeUp .7s ease-out both}
        .panel-left-inner .logo{width:76px;margin-bottom:2.5rem;filter:drop-shadow(0 0 18px rgba(8,190,255,.4))}
        .panel-left-inner h2{font-family:'Cormorant Garamond',serif;font-size:2.8rem;font-weight:700;color:#fff;line-height:1.1;margin-bottom:1rem}
        .panel-left-inner p{font-size:.93rem;color:rgba(255,255,255,.5);line-height:1.75;max-width:260px;margin:0 auto 2.5rem}
        .btn-registro{display:inline-block;padding:.75rem 2.2rem;border:2px solid rgba(255,255,255,.28);border-radius:100px;color:#fff;font-size:.78rem;font-weight:600;letter-spacing:.12em;text-transform:uppercase;text-decoration:none;transition:border-color .3s,color .3s,box-shadow .3s}
        .btn-registro:hover{border-color:var(--azul);color:var(--azul);box-shadow:0 0 24px rgba(8,190,255,.2)}

        .panel-right{flex:1;display:flex;align-items:center;justify-content:center;padding:3rem 4rem;position:relative;overflow:hidden}
        .br1{width:360px;height:360px;background:var(--azul);top:-12%;right:-8%}
        .form-wrap{position:relative;z-index:2;width:100%;max-width:420px;animation:fadeUp .7s .15s ease-out both}
        .form-wrap h1{font-family:'Cormorant Garamond',serif;font-size:3.6rem;font-weight:700;color:#fff;line-height:1;margin-bottom:.4rem}
        .form-wrap .subtitle{font-size:.88rem;color:rgba(255,255,255,.36);margin-bottom:2.4rem}

        .field{position:relative;margin-bottom:1rem}
        .field input{width:100%;background:rgba(255,255,255,.05);border:1px solid var(--borde);border-radius:12px;padding:.95rem 3rem .95rem 3rem;font-family:'DM Sans',sans-serif;font-size:.9rem;color:#fff;outline:none;transition:border-color .25s,background .25s,box-shadow .25s}
        .field input::placeholder{color:rgba(255,255,255,.26)}
        .field input:focus{border-color:var(--azul);background:rgba(8,190,255,.06);box-shadow:0 0 0 3px rgba(8,190,255,.12)}
        .fi{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:rgba(255,255,255,.2);font-size:1rem;pointer-events:none;transition:color .25s}
        .field:focus-within .fi{color:var(--azul)}
        .btn-eye{position:absolute;right:1rem;top:50%;transform:translateY(-50%);background:none;border:none;color:rgba(255,255,255,.22);cursor:pointer;font-size:1rem;padding:0;transition:color .25s}
        .btn-eye:hover{color:var(--azul)}

        .row-remember{display:flex;align-items:center;justify-content:space-between;margin:.3rem 0 1.8rem}
        .check-label{display:flex;align-items:center;gap:.5rem;font-size:.82rem;color:rgba(255,255,255,.38);cursor:pointer;user-select:none}
        .check-label input[type=checkbox]{appearance:none;width:16px;height:16px;border:1.5px solid rgba(255,255,255,.16);border-radius:4px;background:transparent;cursor:pointer;transition:all .2s;position:relative;flex-shrink:0}
        .check-label input[type=checkbox]:checked{background:var(--rosa);border-color:var(--rosa)}
        .check-label input[type=checkbox]:checked::after{content:'';position:absolute;left:4px;top:1px;width:5px;height:9px;border:2px solid #fff;border-top:none;border-left:none;transform:rotate(40deg)}
        .link-forgot{font-size:.82rem;color:rgba(255,255,255,.3);text-decoration:none;transition:color .2s}
        .link-forgot:hover{color:var(--azul)}

        .btn-submit{width:100%;padding:1rem;background:var(--rosa);border:none;border-radius:12px;color:#fff;font-family:'DM Sans',sans-serif;font-size:.82rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;transition:background .25s,box-shadow .25s,transform .15s}
        .btn-submit:hover{background:#a8013b;box-shadow:0 8px 30px rgba(204,2,71,.42);transform:translateY(-1px)}
        .btn-submit:active{transform:translateY(0)}

        .alert-err{background:rgba(204,2,71,.1);border:1px solid rgba(204,2,71,.26);border-radius:10px;padding:.75rem 1rem;margin-bottom:1.2rem}
        .alert-err p{font-size:.82rem;color:#ff6b8a}

        @keyframes fadeUp{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}

        @media(max-width:768px){body{flex-direction:column;overflow:auto}.panel-left{width:100%;min-height:auto;padding:3rem 2rem;border-right:none;border-bottom:1px solid var(--borde)}.panel-right{padding:3rem 2rem}}
    </style>
</head>
<body>

    <!-- Panel izquierdo -->
    <div class="panel-left">
        <div class="blob bl1"></div>
        <div class="blob bl2"></div>
        <div class="panel-left-inner">
            <h2>¿Nuevo<br>por aquí?</h2>
            <p>Regístrate y accede a tu historial, citas y mucho más desde un solo lugar.</p>
            <!-- Enlace al registro (próximo paso) -->
            <a href="{{ route('registro') }}" class="btn-registro">Crear cuenta</a>
        </div>
    </div>

    <!-- Panel derecho -->
    <div class="panel-right">
        <div class="blob br1"></div>
        <div class="form-wrap">
            <h1>Ingresar</h1>
            <p class="subtitle">Accede a tu cuenta</p>

            <!-- Errores de validación -->
            @if ($errors->any())
                <div class="alert-err">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- Correo -->
                <div class="field">
                    <i class="bi bi-envelope fi"></i>
                    <input type="email" name="email" placeholder="Correo electrónico"
                           value="{{ old('email') }}" autocomplete="email" required>
                </div>

                <!-- Contraseña -->
                <div class="field">
                    <i class="bi bi-lock fi"></i>
                    <input type="password" id="pass-field" name="password"
                           placeholder="Contraseña" autocomplete="current-password" required>
                    <button type="button" class="btn-eye" id="toggle-pass" aria-label="Mostrar/ocultar contraseña">
                        <i class="bi bi-eye" id="eye-icon"></i>
                    </button>
                </div>

                <!-- Recordarme / Olvidé -->
                <div class="row-remember">
                    <label class="check-label">
                        <input type="checkbox" name="remember"> Recordarme
                    </label>
                    <a href="#" class="link-forgot">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-submit">Ingresar</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle mostrar/ocultar contraseña
        document.getElementById('toggle-pass').addEventListener('click', function () {
            const f = document.getElementById('pass-field');
            const i = document.getElementById('eye-icon');
            const v = f.type === 'password';
            f.type = v ? 'text' : 'password';
            i.className = v ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>

</body>
</html>