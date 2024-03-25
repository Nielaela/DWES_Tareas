<!-- crearInversion.php, es la página resultante de activar el botón "Crear" del formulario en la vista "vcrear.blade.php"
Se recogen los datos enviados a tarves de POST y se crean las variables, tras eso seguirá una serie de validaciones para su correcta entrada,
una vez comprobado que todo este correcto, se llamará a la función "crearInversion" definida en la clase y creará la instancia.
Tras la inserción en la BD se redirige a la página principal. 
Se tiene en cuenta los rangos de cifras de los valores numéricos definidos en la Base de datos a la hora de validar-->
<?php
session_start();
require '../vendor/autoload.php';

use Clases\Inversion;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar datos del formulario
    $nombreFondo = $_POST['nombre_fondo'];
    $categoria = $_POST['categoria'];
    $valor = $_POST['valor_inversion'];
    $fecha = $_POST['fecha_inversion'];
    $rentabilidad = $_POST['rentabilidad_esperada'];
    $tasaRetornoAnual = $_POST['tasa_retorno_anual'];


    // Validar si el nombre del fondo ya existe
    $inversion = new Inversion();
    $existeFondo = $inversion->existeFondo($nombreFondo);
    if ($existeFondo) {
        // Almacenar el mensaje de error en la sesión
        $_SESSION['error'] = "**Nombre de fondo duplicado. Elige otro nombre.**";
        // Redirigir de nuevo al formulario
        header('Location: fcrear.php');
        exit;
    }

    // Validar valor de inversion
    if ($valor <= 0 || $valor > 99999999.99) {
        // Manejar el caso de valor de inversion fuera de rango o no numérica
        $_SESSION['error'] = '**Valor de inversión debe ser un valor numérico mayor a 0 y menor o igual a 99999999.99.**';
        header('Location: fcrear.php');
        exit;
    }
    // Validar rentabilidad_esperada
    if ($rentabilidad <= 0 || $rentabilidad > 99.99) {
        // Manejar el caso de rentabilidad_esperada fuera de rango o no numérica
        $_SESSION['error'] = '**Rentabilidad Esperada debe ser un valor numérico mayor a 0 y menor o igual a 99.99.**';
        header('Location: fcrear.php');
        exit;
    }
      // Validar tasa de retorno, importante tener en cuenta que puede estar vacio este valor en el formulario (empty)
      if (!empty($tasaRetornoAnual) && ($tasaRetornoAnual <= 0 || $tasaRetornoAnual > 99.99)) {
        // Manejar el caso de tasa de retorno fuera de rango o no numérica
        $_SESSION['error'] = '**La tasa de retorno debe ser un valor numérico mayor a 0 y menor o igual a 99.99.**';
        header('Location: fcrear.php');
        exit;
    }
    // Verificar si los campos obligatorios están completos (además de los required del formulario)
    if (empty($nombreFondo) || empty($categoria) || empty($valor) || empty($fecha) || empty($rentabilidad)) {
        // Almacenar el mensaje de error en la sesión
        $_SESSION['error'] = '**Los campos Nombre del Fondo, Categoría, Fecha y Rentabilidad Esperada son obligatorios.**';
        // Redirigir de nuevo al formulario
        header('Location: fcrear.php');
        exit;
    }

    // Crear una instancia de la clase Inversion
    $inversion = new Inversion();

    // Llamar a la función crearInversion con los datos del formulario
    $inversion->crearInversion($nombreFondo, $categoria, $valor, $fecha, $rentabilidad, $tasaRetornoAnual);

    // Redirección después de la inserción
    header('Location: index.php');
    exit;

    // Limpiar el mensaje de error
    if (isset($_SESSION['error'])) {
        echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
        unset($_SESSION['error']);  
    }
}
