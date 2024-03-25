<!-- instalacion.php, página resultante de la falta de datos en la BD, cargará automáticamente la vista "vinstalacion.blade.php" 
esta vista ofrecerá un botón que al activarlo nos redigirá a "crearDatos.php" que generará aleatoriamente datos nuevos. -->
<?php
session_start();
require '../vendor/autoload.php';

use Philo\Blade\Blade;

$views = '../views';
$cache = '../cache';
$blade = new Blade($views, $cache);
//carga de la vista vinstalación para crear datos aleatorios.
echo $blade->view()->make('vinstalacion')->render();
?>
