<!-- inversiones.php, página resultante tras comprobar que hay datos de inversiones, llamará a la función listarInversiones de la clase
y mostrará los resultados en una tabla definida en la vista "vinversiones.blade.php" -->
<?php
session_start();
require '../vendor/autoload.php';

use Clases\Inversion;
use Philo\Blade\Blade;

$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);

    // Crear una instancia de la clase Inversion
    $inversion = new Inversion();

    // Obtener la lista de inversiones
    $inversiones = $inversion->listarInversiones();
//carga de la vista vinversiones (que crea la tabla donde se guardarán todos los datos)
    echo $blade
        ->view()
        ->make('vinversiones', compact('inversiones'))
        ->render();

?>
