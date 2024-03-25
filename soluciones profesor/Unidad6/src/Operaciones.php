<?php

namespace Clases;


class Operaciones
{
    private $requestMethod;
    private $uri;
    private $action;
    private $params;
    private $productoId;
    private $tiendaId;
    private $productos;
    private $familias;
    private $familiaCod;

    // Define una función para manejar respuestas y errores
    function handleResponse($data, $errorCode = null, $errorMessage = '')
    {
        header('Content-Type: application/json');
        if ($errorCode) {
            http_response_code($errorCode);
            echo json_encode(['error' => $errorMessage]);
        } else {
            http_response_code(200); // OK
            echo json_encode($data);
        }
        exit;
    }

    public function __construct($requestMethod, $uri)
    {
        $this->requestMethod = $requestMethod;
        $this->uri = $uri;
        $this->action = $uri[4] ?? null; // Asignar el segmento de acción de la URI basado en tu estructura
        $this->params = array_slice($uri, 5); // Extraer parámetros adicionales en la URI

        $this->productos= new Productos();
        $this->familias= new Familias();

    }

    public function processRequest()
    {

        try {
            // El enrutamiento simple basado en la acción y el método HTTP.
            switch ($this->action) {
                case 'productos':
                    $response = $this->procesaProductos();
                    break;

                case 'familias':
                    $response = $this->procesaFamilias();
                    break;
                default:
                    $response = $this->notFoundResponse();
                    break;
            }
            header($response['status_code_header']);
            if ($response['body']) {
                echo $response['body'];
            }
        }catch ( \Exception $e){
            $this->handleResponse(null,500,$e->getMessage());
        }
    }

    private function procesaProductos()
    {

        switch ($this->requestMethod) {
            case 'GET':
                if (isset($this->params[0]) && isset($this->params[1]) && $this->params[1] == 'pvp') {
                    // Ruta /productos/{codigo}/pvp
                    $this->productoId = $this->params[0];
                    $result= $this->productos->getPvp($this->productoId);
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                } elseif (isset($this->params[0]) && isset($this->params[1]) && $this->params[1] == 'tiendas' &&
                         isset($this->params[2]) && isset($this->params[3]) && $this->params[3]== 'stock') {
                    // Ruta /productos/{codigo}/tiendas/{tienda}/stock
                    $this->productoId = $this->params[0];
                    $this->tiendaId = $this->params[2];
                    $result= $this->productos->getStock($this->productoId, $this->tiendaId);
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                } else{
                    $response = $this->notFoundResponse();
                }
                break;

            case 'OPTIONS':
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
            default:
                $response = $this->notFoundResponse();
                break;
        }

        return $response;

    }

    private function procesaFamilias()
    {

        switch ($this->requestMethod) {
            case 'GET':
                if (!isset($this->params[0]) ) {
                    // Ruta /familias:
                    $result= $this->familias->getAll();
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                } elseif (isset($this->params[0]) && isset($this->params[1]) && $this->params[1] == 'productos') {
                    // Ruta /familias/{codigo}/productos:
                    $this->familiaCod = $this->params[0];
                    $result= $this->familias->getProductos($this->familiaCod);
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = json_encode($result);
                } else{
                    $response = $this->notFoundResponse();
                }
                break;
            case 'PUT':
                $input = (array) json_decode(file_get_contents('php://input'), TRUE);
                $this->familias->insert($input);
                $response['status_code_header'] = 'HTTP/1.1 201 Created';
                $response['body'] = "Familia creada con éxito";
                break;
            case 'DELETE':
                if (isset($this->params[0])){
                        // Ruta /familias/{codigo}
                    $this->familiaCod = $this->params[0];
                    $result = $this->familias->delete($this->familiaCod);
                    $response['status_code_header'] = 'HTTP/1.1 200 OK';
                    $response['body'] = "Familia borrada con éxito";
                }
                break;
            case 'OPTIONS':
                $response['status_code_header'] = 'HTTP/1.1 200 OK';
            default:
                $response = $this->notFoundResponse();
                break;
        }

        return $response;

    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

}