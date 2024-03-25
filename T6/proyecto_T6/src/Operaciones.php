<?php

namespace Clases;

use Clases\Familia;
use Clases\Producto;

class Operaciones
{

    private $requestMethod;
    private $var1 = null;
    private $codigo = null;
    private $var3 = null;
    private $tienda = null;
    private $stock = null;
    private $familia;
    private $producto;

    public function __construct($requestMethod, $var1, $codigo, $var3, $tienda, $stock)
    {
        $this->requestMethod = $requestMethod;
        $this->producto = new Producto();
        $this->familia = new Familia();
        $this->var1 = $var1;
        $this->codigo = $codigo;
        $this->var3 = $var3;
        $this->tienda = $tienda;
        $this->stock = $stock;
    }

    public function processRequest()
    {
        // Definir el switch para manejar las diferentes combinaciones de método y ruta
        switch ($this->requestMethod) {
            case 'GET':
                // Manejar las solicitudes GET
                switch ($this->var1) {
                    case 'productos':
                        if ($this->var3 === 'pvp') {
                            // Lógica para /productos/{codigo}/pvp
                            // Llamada al metodo "obtenerPVPproducto" para devolver el PVP del producto con el código proporcionado
                            $response = $this->obtenerPVPproducto($this->codigo);
                        } elseif ($this->var3 === 'tiendas') {
                            // Lógica para /productos/{codigo}/tiendas/{tienda}/stock
                            // Llamada al metodo "obtenerStockProducto" para devolver el stock del producto en la tienda proporcionada
                            $response = $this->obtenerStockProducto($this->codigo, $this->tienda);
                        }
                        break;
                    case 'familias':
                        if ($this->var3 === null) {
                            // Lógica para /familias
                            // Llamada al metodo "obtenerIDFamilias" para devolver un array JSON con los códigos de todas las familias
                            $response = $this->obtenerIDFamilias();
                        } elseif ($this->var3 === 'productos') {
                            // Lógica para /familias/{codigo}/productos
                            // Llamada al metodo "obtenerProductosFamilia" para devolver un array JSON con los códigos de los productos de la familia proporcionada
                            $response = $this->obtenerProductosFamilia($this->codigo);
                        }
                        break;

                    default:
                        // Mensaje de error
                        $response = $this->notFoundResponse();
                        break;
                }
                break;
            case 'PUT':
                // Manejar las solicitudes PUT
                switch ($this->var1) {
                    case 'familias':
                        // Lógica para /familias
                        // Llamada al metodo "insertarFamilia" para insertar una nueva familia con los datos proporcionados en el cuerpo de la solicitud
                        $response = $this->insertarFamilia();
                        break;
                    default:
                        // Mensaje de error
                        $response = $this->notFoundResponse();
                        break;
                }
                break;
            case 'DELETE':
                // Manejar las solicitudes DELETE
                switch ($this->var1) {
                    case 'familias':
                        // Lógica para /familias/{código}
                        // Llamada al metodo "borrarFamilia"  para eliminar la familia con el código proporcionado
                        $response = $this->borrarFamilia($this->codigo);
                        break;
                    default:
                        // Mensaje de error
                        $response = $this->notFoundResponse();
                        break;
                }
                break;
            default:
                // Mensaje de error
                $response = $this->notFoundResponse();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    //FUNCIONES PARA DAR LOS RESULTADOS COMO JSON, UTILIZARÁ LAS FUNCIONES DEFINIDAS QUE OPERAN CON LA BD EN FAMILIA Y PRODUCTO

    private function obtenerPVPproducto($idProducto)
    {
        // Obtener el PVP utilizando la función de la clase Producto
        $pvp = $this->producto->obtenerPVPproducto($idProducto);

        // Preparar la respuesta en formato JSON
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode(['pvp' => $pvp]);

        return $response;
    }

    private function obtenerIDFamilias()
    {
        // Lógica para obtener los códigos de todas las familias desde la Base de Datos
        $codigosFamilias = $this->familia->obtenerCodigosFamilias();

        if (is_array($codigosFamilias) && count($codigosFamilias) > 0) {
            // Si se obtuvieron datos, preparar la respuesta
            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = json_encode($codigosFamilias);
        } else {
            // Si no se encontraron datos, devolver un código de error
            $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
            $response['body'] = json_encode(["error" => "No se encontraron familias"]);
        }

        return $response;
    }

    private function obtenerProductosFamilia($idFamilia)
    {
        // Obtener los códigos de productos utilizando la función de la clase Familia
        $codigosProductos = $this->familia->obtenerProductosFamilia($idFamilia);

        // Preparar la respuesta en formato JSON
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($codigosProductos);

        return $response;
    }

    private function obtenerStockProducto($idProducto, $idTienda)
    {
        // Obtener el stock de productos en tienda utilizando la función de la clase Producto
        $stockProducto = $this->producto->obtenerStock($idProducto, $idTienda);
        // Preparar la respuesta en formato JSON
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($stockProducto);

        return $response;
    }

    private function insertarFamilia()
    {
        // Recogida datos desde el body
        $data = json_decode(file_get_contents("php://input"), true);

        // Validar los datos
        if (!$this->validateFamilia($data)) {
            return $this->unprocessableEntityResponse();
        }

        // Insertar la familia en la base de datos
        $resultado = $this->familia->insertarFamilia($data['cod'], $data['nombre']);

        // Preparar la respuesta en formato JSON
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = json_encode($resultado);

        return $response;
    }

    // Función de validación
    private function validateFamilia($data)
    {
        if (!isset($data['cod'])) {
            return false;
        }
        if (!isset($data['nombre'])) {
            return false;
        }
        return true;
    }

    // Función de respuesta para datos no procesables
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['error' => 'Invalid input']);
        return $response;
    }
    
    // Función de respuesta para si no hay datos
    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }

    private function borrarFamilia($idFamilia)
    {
        // Verificar si la familia existe antes de intentar borrarla
        if (!$this->familia->existeFamilia($idFamilia)) {
            return $this->notFoundResponse();
        }
        // Llama a la función borrarFamilia de la instancia de Familia
        $resultado = $this->familia->borrarFamilia($idFamilia);

        // Preparar la respuesta en formato JSON
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($resultado);

        return $response;
    }
}
