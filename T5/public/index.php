<!-- index.php, página inicial que controlará la existencia de datos en la BD, si no hay datos nos enviará a la página "instalación.php" para generarlos
si hay datos nos enviará a la página "inversiones.php" para mostrarlos. -->
<?php
session_start();
require '../vendor/autoload.php';

use Clases\Inversion;

// Verificar si la tabla inversiones tiene datos
$inversion = new Inversion();
$inversiones = $inversion->listarInversiones();

if (empty($inversiones)) {
    // Si no hay datos, redirigir a instalacion.php
    header('Location: instalacion.php');
    exit;
}else{
    //si los hay, ir a la pagina inversiones.php que los datos y los añadirá a la tabla con la vista
    header('Location: inversiones.php');
    exit;
}

?>
