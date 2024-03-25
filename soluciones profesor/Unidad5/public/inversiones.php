<?php
    session_start();
    require '../vendor/autoload.php';
    use Philo\Blade\Blade;
    use Clases\Inversion;

    $views = '../views';
    $cache = '../cache';
    $blade = new Blade($views, $cache);

    $titulo = 'Inversiones';
    $encabezado = 'Listado de Inversiones';
    $inversiones = (new Inversion())->recuperarInversiones();

    if (isset($_SESSION['mensaje'])) {
        $mensaje = $_SESSION['mensaje'];
        unset($_SESSION['mensaje']); // para no volver a repetir el mensaje
        echo $blade
            ->view()
            ->make('vinversiones', compact('titulo', 'encabezado', 'inversiones', 'mensaje'))
            ->render();
    } else {
        echo $blade
            ->view()
            ->make('vinversiones', compact('titulo', 'encabezado', 'inversiones'))
            ->render();
    }