<?php
require '../vendor/autoload.php';
use GuzzleHttp\Client;

$apiUrl = 'http://localhost/servicios/practica6/public';
$client = new Client();

// Función para manejar las respuestas del servidor
function handleResponse($response)
{
    echo "<br>--- Response Start ---<br>";
    echo "HTTP Status Code: " . $response->getStatusCode() . "<br>";
    $body = $response->getBody();
    $decodedBody = json_decode($body, true);

    if ($decodedBody) {
        print_r($decodedBody);
    } else {
        echo "Response: " . $body . "<br>";
    }
    echo "<br>--- Response End ---<br><br>";
}

// Función para manejar los errores
function handleError($e)
{
    echo "<br>--- Error Start ---<br>";
    echo "Error Message: " . $e->getMessage() . "<br>";
    if (method_exists($e, 'hasResponse') && $e->hasResponse()) {
        $body = $e->getResponse()->getBody();
        $decodedBody = json_decode($body, true);

        if ($decodedBody) {
            print_r($decodedBody);
        } else {
            echo "Error Body: " . $body . "<br>";
        }
    }
    echo "<br>--- Error End ---<br><br>";
}
// Prueba pvp producto
echo "Testing GET /productos/{codigo}/pvp<br>";
try {
    $response = $client->get("$apiUrl/productos/1/pvp");
    handleResponse($response);
} catch (Exception $e) {
    handleError($e);
}

// Prueba ver familias
echo "Testing GET /familias<br>";
try {
    $response = $client->get("$apiUrl/familias");
    handleResponse($response);
} catch (Exception $e) {
    handleError($e);
}

// Prueba insertar familias
echo "Testing PUT /familias<br>";
try {
    $response = $client->put("$apiUrl/familias", [
        'json' => [
            'cod' => 'NUEVA',
            'nombre' => 'Nueva Familia',
        ]
    ]);
    handleResponse($response);
} catch (Exception $e) {
    handleError($e);
}

// Prueba ver stock producto tienda
echo "Testing GET /productos/{codigo}/tiendas/{tienda}/stock<br>";
try {
    $response = $client->get("$apiUrl/productos/26/tiendas/1/stock");
    handleResponse($response);
} catch (Exception $e) {
    handleError($e);
}

// Prueba borrar familias
echo "Testing DELETE /familias/{codigo}<br>";
try {
    $response = $client->delete("$apiUrl/familias/NUEVA");
    handleResponse($response);
} catch (Exception $e) {
    handleError($e);
}

//Pruebas comprobando previamente si existe o no el codigo de producto o familia***********

// Función para verificar si una familia existe
function familiaExists($client, $apiUrl, $codigo) {
    try {
        $response = $client->get("$apiUrl/familias/$codigo");
        $body = json_decode($response->getBody(), true);

        return !(isset($body['error']) && $body['error'] == "No se encontraron familias");
    } catch (Exception $e) {
        return false;
    }
}

// Prueba de borrado comprobando previamente si existe la familia
echo "Testing DELETE /familias/{codigo}<br>";
// Código a borrar
$codigoFamilia = "HOLA";

// Verificar la existencia antes de intentar borrar
if (familiaExists($client, $apiUrl, $codigoFamilia)) {
    // La familia existe, intentamos borrarla
    try {
        $response = $client->delete("$apiUrl/familias/$codigoFamilia");
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }
} else {
    // La familia no existe, imprimir un mensaje
    echo "La familia con código $codigoFamilia no existe.<br>";
}

// Función para verificar si un producto existe
function productoExists($client, $apiUrl, $codigo) {
    try {
        $response = $client->get("$apiUrl/productos/$codigo/pvp");
        $body = json_decode($response->getBody(), true);

        return !(isset($body['error']) && $body['error'] == "Producto no encontrado");
    } catch (Exception $e) {
        return false;
    }
}

// Prueba de ver precio producto teniendo en cuenta si existe el producto
echo "Testing GET /productos/{codigo}/pvp<br>";

// Código de producto a buscar
$codigoABuscar = "17";

// Verificar la existencia antes de intentar obtener el PVP
if (productoExists($client, $apiUrl, $codigoABuscar)) {
    // El producto existe, intentamos obtener el PVP
    try {
        $response = $client->get("$apiUrl/productos/$codigoABuscar/pvp");
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }
} else {
    // El producto no existe, imprimir un mensaje
    echo "El producto con código $codigoABuscar no existe.<br>";
}