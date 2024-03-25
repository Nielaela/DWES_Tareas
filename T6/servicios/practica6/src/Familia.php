<?php

namespace Clases;

use PDO;
use PDOException;
use Exception;

class Familia extends Conexion
{

    public function __construct()
    {
        parent::__construct();
    }

    //METODOS
    public function obtenerCodigosFamilias()
    {
        try {
            $consulta = "SELECT cod FROM familias";
            $stmt = $this->conexion->query($consulta);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $ex) {
            return ["error" => "Error al obtener los códigos de las familias: " . $ex->getMessage()];
        }
    }

    public function obtenerProductosFamilia($codigoFamilia)
    {
        try {
            $consulta = "SELECT id FROM productos WHERE familia = :codigoFamilia";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':codigoFamilia', $codigoFamilia, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $ex) {
            return ["error" => "Error al obtener los códigos de productos por familia: " . $ex->getMessage()];
        }
    }

    public function insertarFamilia($codigoNuevo, $nombreNuevo)
    {
        try {
            $query = "INSERT INTO familias (cod, nombre) VALUES (:codigoNuevo, :nombreNuevo)";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':codigoNuevo', $codigoNuevo, PDO::PARAM_STR);
            $stmt->bindParam(':nombreNuevo', $nombreNuevo, PDO::PARAM_STR);
            $stmt->execute();

            return ["success" => "Familia insertada correctamente"];
        } catch (PDOException $ex) {
            return ["error" => "Error al insertar la familia: " . $ex->getMessage()];
        }
    }

    public function borrarFamilia($codigoFamilia)
    {
        try {
            $query = "DELETE FROM familias WHERE cod = :codigoFamilia";
            $stmt = $this->conexion->prepare($query);
            $stmt->bindParam(':codigoFamilia', $codigoFamilia, PDO::PARAM_STR);
            $stmt->execute();

            return ["success" => "Familia borrada correctamente"];
        } catch (PDOException $ex) {
            return ["error" => "Error al borrar la familia: " . $ex->getMessage()];
        }
    }
    
    public function existeFamilia($codigoFamilia)
    {
        try {
            $consulta = "SELECT cod FROM familias WHERE cod = :codigoFamilia";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bindParam(':codigoFamilia', $codigoFamilia, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ($result !== false); // Devuelve true si la familia existe, false si no existe
        } catch (PDOException $ex) {
            return false; // En caso de error, consideramos que la familia no existe
        }
    }
}
