<?php
namespace Clases;


class Familias extends conexion{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        $statement = "
            SELECT 
                *
            FROM
                familias;
        ";

        try {
            $statement = $this->conexion->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getProductos($familiaCod)
    {
        $statement = "
            SELECT 
                *
            FROM
                productos
            WHERE familia = ?;
        ";

        try {
            $statement = $this->conexion->prepare($statement);
            $statement->execute(array($familiaCod));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(Array $input)
    {
        $statement = "
            INSERT INTO familias 
                (cod, nombre)
            VALUES
                (:cod, :nombre);
        ";

        try {
            $statement = $this->conexion->prepare($statement);
            $statement->execute(array(
                'cod' => $input['cod'],
                'nombre'  => $input['nombre'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($cod)
    {
        $statement = "
            DELETE FROM familias
            WHERE cod = :cod;
        ";

        try {
            $statement = $this->conexion->prepare($statement);
            $statement->execute(array('cod' => $cod));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}