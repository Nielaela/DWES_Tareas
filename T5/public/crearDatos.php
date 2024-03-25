<!-- crearDatos.php, resultante de accionar el botón de instalacion en la vista "vinstalacion", este mediante la biblioteca Fakerphp
especificando los criterios, creará aleatoriamente nuevos valores para después poder crear las instancias de inversiones.
Tras crear la instancia redirigirá a la página "inversiones.php" donde se muestra la tabla con los datos -->
<?php
session_start();
require '../vendor/autoload.php';

use Clases\Inversion;
use Faker\Factory;

// Crear datos de ejemplo para las inversiones usando Faker
$faker = Factory::create();
$inversion = new Inversion();

// En el bucle podemos indicar cuantas lineas de datos quiero añadir, en este caso he indicado 4
for ($i = 1; $i <= 4; $i++) {
    $nombreFondo = $faker->company; // Genera un nombre de empresa aleatorio
    $categoria = $faker->randomElement(['Renta Fija', 'Renta Variable', 'Renta Global', 'Otra']); // Elige aleatoriamente entre las categorías
    $valor = $faker->numberBetween(100, 10000); // Genera un valor aleatorio entre 100 y 10000
    $fecha = $faker->date; // Genera una fecha aleatoria
    $rentabilidad = $faker->randomFloat(2, 1, 10); // Genera una rentabilidad aleatoria con dos decimales entre 1 y 10
    $tasaRetornoAnual = $faker->randomFloat(2, 5, 15); // Genera una tasa de retorno anual aleatoria con dos decimales entre 5 y 15


    // Llamar a la función crearInversion con los datos generados
    $inversion->crearInversion($nombreFondo, $categoria, $valor, $fecha, $rentabilidad, $tasaRetornoAnual);
}

// Redirigir a la lista de inversiones o a donde desees
header('Location: inversiones.php');
exit;
