<?php

    namespace Clases;

    use PDO;
    use PDOException;

    class Inversion extends Conexion
    {
        private $id;
        private $nombre_fondo;
        private $categoria;
        private $valor_inversion;
        private $fecha_inversion;
        private $rentabilidad_esperada;

        public function __construct()
        {
            parent::__construct();
        }

        public function recuperarInversiones()
        {
            $consulta = "SELECT * FROM inversiones ORDER BY fecha_inversion DESC";
            $stmt = $this->conexion->prepare($consulta);
            try {
                $stmt->execute();
            } catch (PDOException $ex) {
                die("Error al recuperar inversiones: " . $ex->getMessage());
            }
            $this->conexion = null;
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function create()
        {
            $insert = "INSERT INTO inversiones(nombre_fondo, categoria, valor_inversion, fecha_inversion, rentabilidad_esperada) VALUES (:nf, :c, :vi, :fi, :re)";
            $stmt = $this->conexion->prepare($insert);
            try {
                $stmt->execute([
                    ':nf' => $this->nombre_fondo,
                    ':c' => $this->categoria,
                    ':vi' => $this->valor_inversion,
                    ':fi' => $this->fecha_inversion,
                    ':re' => $this->rentabilidad_esperada
                ]);
                return $stmt->rowCount();
            } catch (PDOException $ex) {
                die("Error al insertar la inversión: " . $ex->getMessage());
                return 0;
            }
        }

        public function borrarTodo()
        {
            $borrado = "DELETE FROM inversiones";
            $stmt = $this->conexion->prepare($borrado);
            try {
                $stmt->execute();
            } catch (PDOException $ex) {
                die("Error al borrar inversiones: " . $ex->getMessage());
            }
        }

        public function tieneDatos()
        {
            $consulta = "SELECT * FROM inversiones";
            $stmt = $this->conexion->prepare($consulta);
            try {
                $stmt->execute();
            } catch (PDOException $ex) {
                die("Error al comprobar si hay datos de inversiones: " . $ex->getMessage());
            }

            if ($stmt->rowCount() == 0) return false;

            return true;
        }

        // Setters ------------------------------

        public function setId($id)
        {
            $this->id = $id;
        }

        public function setNombreFondo($nombre_fondo)
        {
            $this->nombre_fondo = $nombre_fondo;
        }

        public function setCategoria($categoria)
        {
            $this->categoria = $categoria;
        }

        public function setValorInversion($valor_inversion)
        {
            $this->valor_inversion = $valor_inversion;
        }

        public function setFechaInversion($fecha_inversion)
        {
            $this->fecha_inversion = $fecha_inversion;
        }

        public function setRentabilidadEsperada($rentabilidad_esperada)
        {
            $this->rentabilidad_esperada = $rentabilidad_esperada;
        }
    }