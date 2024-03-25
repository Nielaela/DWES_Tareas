<?php
require '../vendor/autoload.php';

use Clases\Inversion;

$inversion = new Inversion();
if ($inversion->tieneDatos()) {
    $inversion = null;
    header('Location: inversiones.php');
} else {
    $inversion = null;
    header('Location: instalacion.php');
}
