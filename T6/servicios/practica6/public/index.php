<?php
require '../vendor/autoload.php';

use Clases\Operaciones;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");

// Manejar la petición de verificación preliminar de CORS.
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // No hacer nada más y finalizar el script después de enviar los encabezados de CORS.
    exit(0);
}

//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//eliminamos la parte del path que no corresponde a los puntos de entrada del API
$BASE_URI = "/servicios/practica6/public";
$parsedURI = parse_url($_SERVER["REQUEST_URI"]);
$endpointName = str_replace($BASE_URI, "", $parsedURI["path"]);

$uri = explode( '/', $endpointName);
// los endpoints empezarán por familias o por productos, si no es asi mostrará el error 404
if (($uri[1] !== 'productos') && ($uri[1] !== 'familias')) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// variables de la uri para desglosarlas según el maximo de endpoint, sólo el primer bloque y el tercero entre "/" varia
//el primero puede ser familias o productos, y el tercero pvp, productos o tiendas. el resto de variables su nombre corresponderá 
//al codigo de producto/familia y al codigo de tienda.

//   /productos/{codigo}/tiendas/{tienda}/stock
//   /$var1/{$codigo}/$var3/{$tienda}/~stock
$var1 = null;
$codigo = null;
$var3 = null;
$tienda = null;
$stock = null;

// guardamos los valores del desglose de la uri en cada variable
if (isset($uri[1])) {
    $var1 = $uri[1];
}
if (isset($uri[2])) {
    $codigo = $uri[2];
}
if (isset($uri[3])) {
    $var3 = $uri[3];
}
if (isset($uri[4])) {
    $tienda = $uri[4];
}
if (isset($uri[5])) {
    $stock = $uri[5];
}

$requestMethod = $_SERVER["REQUEST_METHOD"];

//creamos un objeto operaciones que recogerá los datos de las variables 
$controller = new Operaciones($requestMethod, $var1, $codigo, $var3, $tienda, $stock);
//llamamos al metodo processRequest() definido en Operaciones que maneja todos los servicios API Rest
$controller->processRequest();