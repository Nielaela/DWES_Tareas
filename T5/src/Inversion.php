<?php
/**
 * Clase Inversión, que al heredar de la Clase de conexión obtiene todas las propiedades y métodos de Conexion.
 * Entonces, cuando se llame al constructor (parent::__construct) además se conectará a la BD, esta conexión a la BD
 * se debe a la propiedad conexión, de la clase Conexion.
 */


namespace Clases;

use PDO;
use PDOException;
use Exception;

class Inversion extends Conexion
{
    private $nombreFondo;
    private $categoria;
    private $valor;
    private $fecha;
    private $rentabilidad;
    private $tasaRetornoAnual;

    public function __construct()
    {
        parent::__construct();
    }

    //METODOS DE LA CLASE INVERSION
    /**listarInversiones, con una consulta SELECT a toda la tabla inversiones recogerá los datos y los guardará en el array
     * que más tarde se mostrará fila por fila con un foreach ejecutado en la vista "vinversiones"
     */
    function listarInversiones()
    {
        $consulta = "select * from inversiones";
        $stmt = $this->conexion->prepare($consulta);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar inversiones: " . $ex->getMessage());
        }
        $this->conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**crearInversion, formateará los valores numericos para evitar problemas y tendrá en cuenta la ausencia del valor "tasaretornoanual"
     * finalmente realizará la consulta de INSERT para añadir esta nueva instancia a la BD
     */
    function crearInversion($nombreFondo, $categoria, $valor, $fecha, $rentabilidad, $tasaRetornoAnual = null)
    {
        // Cambio de comas por puntos por la posibilidad de ingresar decimales con comas en el formulario.
        $valor = str_replace(',', '.', $valor);
        $rentabilidad = str_replace(',', '.', $rentabilidad);
        //control para cuando no se da valor a la tasa de retorno, en caso contrario, formatea los decimales.
        if($tasaRetornoAnual == null){
            $tasaRetornoAnual = null;
        }else{
            $tasaRetornoAnual = str_replace(',', '.', $tasaRetornoAnual);
        }
      

        $consulta = "INSERT INTO inversiones (nombre_fondo, categoria, valor_inversion, fecha_inversion, rentabilidad_esperada, tasa_retorno_anual) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($consulta);

        try {
            $stmt->execute([$nombreFondo, $categoria, $valor, $fecha, $rentabilidad, $tasaRetornoAnual]);
            return true;
        } catch (PDOException $ex) {
            throw new Exception("Error al crear inversión: " . $ex->getMessage());
            return false;
        }

        $this->conexion = null;
    }
/**existeFondo, realizará una consulta para comprobar si existe el mismo nombre de fondo, de esta forma evitaremos
 * duplicar el mismo nombre en la BD
 */
    function existeFondo($nombreFondo)
    {
        $consulta = "SELECT COUNT(*) as cantidad FROM inversiones WHERE nombre_fondo = ?";
        $stmt = $this->conexion->prepare($consulta);

        try {
            $stmt->execute([$nombreFondo]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si la cantidad es mayor que 0, el fondo ya existe
            return $resultado['cantidad'] > 0;
        } catch (PDOException $ex) {
            die("Error al verificar fondo existente: " . $ex->getMessage());
        }
    }
}
