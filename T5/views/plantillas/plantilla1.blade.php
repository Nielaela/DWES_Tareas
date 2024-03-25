{{-- plantilla base de la que partiran las vistas
tiene enlazada la ruta a la hoja de estilos de todo el proyecto
Se define en el head y body los @yield que aporta Blade para poder en cada vista modificar valores--}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="../views/plantillas/css/estilo.css">
</head>
<body>

    <header>
        <h1>@yield('encabezado')</h1>
    </header>

    <main>
        @yield('contenido')
    </main>

</body>
</html>
