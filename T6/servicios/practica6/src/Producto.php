<?php

namespace Clases;

use PDO;
use PDOException;
use Exception;

class Producto extends Conexion
{

    public function __construct()
    {
        parent::__construct();
    }

    //MÉTODOS
    public function obtenerPVPproducto($idProducto)
    {
        $consulta = "SELECT pvp FROM productos WHERE id = :idProducto";
        $stmt = $this->conexion->prepare($consulta);
        $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['pvp'];
            } else {
                return "Producto no encontrado";
            }
        } catch (PDOException $ex) {
            return "Error al obtener el PVP: " . $ex->getMessage();
        }
    }

    public function obtenerStock($idProducto, $idTienda)
    {
        $consulta = "SELECT unidades FROM stocks WHERE producto = :idProducto AND tienda = :idTienda";
        $stmt = $this->conexion->prepare($consulta);
        $stmt->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);
        $stmt->bindParam(':idTienda', $idTienda, PDO::PARAM_INT);
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result['unidades'];
            } else {
                return "Stock no encontrado";
            }
        } catch (PDOException $ex) {
            return "Error al obtener el stock: " . $ex->getMessage();
        }
    }
}
