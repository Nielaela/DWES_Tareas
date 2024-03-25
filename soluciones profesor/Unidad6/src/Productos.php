<?php
namespace Clases;


class Productos extends conexion{

    public function __construct()
    {
        parent::__construct();
    }

    public function getPvp($id)
    {
        $statement = "
            SELECT 
                pvp
            FROM
                productos
            WHERE id = ?;
        ";

        try {
            $statement = $this->conexion->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getStock($idProducto, $idTienda)
    {
        $statement = "
            SELECT 
                unidades
            FROM
                stocks 
            WHERE producto = ? and tienda = ?;
        ";

        try {
            $statement = $this->conexion->prepare($statement);
            $statement->execute(array($idProducto,$idTienda));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }



}