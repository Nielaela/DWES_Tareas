<?php
    session_start();
    require '../vendor/autoload.php';

    use Clases\Inversion;
// Create a new instance of Faker to generate sample data
    $faker = Faker\Factory::create();

// Create an instance of the Inversion class to operate with the database
    $inversion = new Inversion();

// Generate and insert sample data
    for ($i = 0; $i < 10; $i++) {
        // Generate example data for a new indexed fund
        $inversion->setNombreFondo($faker->company . ' Index Fund');
        $inversion->setCategoria(  $faker->randomElement(['Renta Fija', 'Renta Variable', 'Internacional', 'Emergentes']));
        $inversion->setValorInversion($faker->randomFloat(2, 1000, 100000)); // random value between 1,000 and 100,000
        $inversion->setFechaInversion($fecha_inversion = $faker->date());
        $inversion->setRentabilidadEsperada($faker->randomFloat(2, 1, 15)); // random percentage between 1 and 15

        $inversion->create();

     }
$SESSION['mensaje'] =" Datos de ejemplo creados correctamente";
    header('Location:inversiones.php');
