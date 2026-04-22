<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PuraSonrisa')</title>

    <!-- Fuente de Google Fonts -->
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Playwrite+NO:wght@100..400&display=swap');
    body { font-family: "Open Sans", sans-serif; }
        h1, h2, h3 { font-family: "Playwrite NO", sans-serif; }
    </style>

    <!-- Icono de la pestaña -->
     <link rel="icon" href="{{ asset('images/LogoPuraSonrisa.webp') }}" type="image/png">

    <!-- Esto es para incluir los archivos de Vite y equivale al enlace de tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    <!-- Aqui incluyo el header y el footer para que se muestren en todas las páginas-->
    @include('layouts.header')
    
    <!-- Y aqui va el contenido principal de la página es decir lo diferente en cada página -->
    <main>
        @yield('content')
    </main>

   @include('layouts.footer')

</body>
</html>