<?php
    session_start();
    require '../vendor/autoload.php';

    use Clases\Inversion;

    function error($text)
    {
        $_SESSION['error'] = $text;
        header('Location:fcrear.php');
        die();
    }

    $nombre_fondo = trim($_POST['nombre_fondo']);
    $categoria = trim($_POST['categoria']);
    $valor_inversion = (float)$_POST['valor_inversion'];
    $fecha_inversion = $_POST['fecha_inversion'];
    $rentabilidad_esperada = (float)$_POST['rentabilidad_esperada'];

    if (strlen($nombre_fondo) == 0 || strlen($categoria) == 0) {
        error("Nombre del fondo y categoría deben contener algún carácter válido!!!");
    }

// No hay chequeos de códigos de barras o dorsales en inversiones
// Si hemos llegado aquí todo ha ido bien, procedemos a la inserción
    $inversion = new Inversion();
    $inversion->setNombreFondo($nombre_fondo);
    $inversion->setCategoria($categoria);
    $inversion->setValorInversion($valor_inversion);
    $inversion->setFechaInversion($fecha_inversion);
    $inversion->setRentabilidadEsperada($rentabilidad_esperada);

    $inversion->create();
    $inversion = null;
    $_SESSION['mensaje'] = "Inversión creada con éxito.";
    header('Location:inversiones.php');
?>