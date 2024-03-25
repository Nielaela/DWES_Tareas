<!-- Creación del objeto conexión para el uso en el resto de archivos PHP -->
<?php
$error = false;
$host = "localhost";
$db = "dwes23";
$user = "gestor";
$pass = "secreto";
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

//Manejo de errores y captura de excepciones
try {
    $conexion = new PDO($dsn, $user, $pass);

    // Configurar PDO para lanzar excepciones en caso de error
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $ex) {
    //manejo del error de conexion
    $mensaje = "Error de conexión: " . $ex->getMessage();
    $error = true;
}
?>