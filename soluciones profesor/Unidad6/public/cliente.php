<?php

    require '../vendor/autoload.php';

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Exception\ClientException;

    $apiUrl = 'http://localhost/23_24/Unidad6/public';

    $client = new Client();

    // Función para manejar las respuestas del servidor
    function handleResponse($response) {
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
    function handleError($e) {
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

    echo "Testing GET /productos/{codigo}/pvp<br>";
    try {
        $response = $client->get("$apiUrl/productos/1/pvp");
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }

    echo "Testing GET /familias<br>";
    try {
        $response = $client->get("$apiUrl/familias");
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }

    echo "Testing GET /familias/{codigo}/productos<br>";
    try {
        $response = $client->get("$apiUrl/familias/camara/productos");
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }

    echo "Testing GET /productos/{codigo}/tiendas/{tienda}/stock<br>";
    try {
        $response = $client->get("$apiUrl/productos/1/tiendas/2/stock");
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }

    echo "Testing PUT /familias/<br>";
    try {
        $response = $client->put("$apiUrl/familias", [
            'json' => ['cod' => 'Beacon', 'nombre' => 'Balizas Bluetooth']
        ]);
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }

    echo "Testing DELETE /familias/{codigo}<br>";
    try {
        $response = $client->delete("$apiUrl/familias/Beacon");
        handleResponse($response);
    } catch (Exception $e) {
        handleError($e);
    }