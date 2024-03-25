<?php
// Carga el autoloader de Composer para poder utilizar las clases sin requerir manualmente cada archivo.
require_once __DIR__ . '/../vendor/autoload.php';

use Clases\Operaciones;

// Habilitar CORS y establecer cabeceras.
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


// Analizar la URL para obtener la acción solicitada y los parámetros.
$requestMethod = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);


// Función para manejar la petición preflight de CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('HTTP/1.1 204 No Content');
    exit;
}


// Instanciar las clases controller
$operaciones = new Operaciones($requestMethod, $uri);
$operaciones->processRequest();