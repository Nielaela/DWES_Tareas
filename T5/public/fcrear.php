<!-- fcrear.php, página resultante del botón "Nuevo Fondo" definido en la vista "vinversiones", llamará a la vista
que contiene el formulario "vcrear.blade.php".
los errores de validación se mostrarán siempre que se refresque la página fcrear, avisando al usuario del motivo de fallo -->
<?php
session_start();
require '../vendor/autoload.php';

use Philo\Blade\Blade;

$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);

// Mostrar el mensaje de error si existe
if (isset($_SESSION['error'])) {
    echo '<p class="mensaje_error">' . $_SESSION['error'] . '</p>';
    unset($_SESSION['error']);  // Limpiar el mensaje de error
}

//carga de la vista vcrear que mostrará el formulario a rellenar con sus botones
echo $blade->view()->make('vcrear')->render();
?>
