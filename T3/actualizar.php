<?php
require_once('conexión.php');
// Control para obtener los valores enviados anteriormente con el botón actualizar
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $nombreCorto_Modificado = $_GET["nombre_corto"];
    $nombre_Modificado = $_GET["nombre"];
    $descripcion_Modificado = $_GET["descripción"];
    $pvp_Modificado = $_GET["pvp"];
    try {
        //inicializar la transacción
        $conexion->beginTransaction();

        //se llaman los métodos para realziar los cambios e isnercciones
        actualizarProducto($conexion, $id, $nombreCorto_Modificado, $nombre_Modificado, $descripcion_Modificado, $pvp_Modificado);

        creaLogs($conexion, $nombreCorto_Modificado);

        $conexion->commit();
        echo "CORRECTO Se han actualizado los datos de $nombreCorto_Modificado";
    } catch (Exception $e) {
        //en caso de error se hace rollback
        $conexion->rollBack();
        echo "Error, la transacción no pudo completarse." . $e->getMessage();
    }
} else {
    // Manejar el caso en que id no está presente en $_POST
    echo "Error: El ID del producto modificado no está presente en el formulario.";
}

//FUNCIONES
/**actualizarProducto, realizará la consultaAct que se encargará de asignar los nuevos valores o cambios a los atributos de la tabla Productos.
 * 
 */

function actualizarProducto($conexion, $id, $nombreCortoProducto, $nombreProducto, $descripcionProducto, $pvpProducto)
{
    $consultaAct = "UPDATE productos SET nombre_corto = :codAct, nombre = :nombreAct, descripcion = :descripcionAct, pvp = :pvpAct WHERE id = :producto_id";
    $statementAct = $conexion->prepare($consultaAct);
    $statementAct->bindParam(':codAct', $nombreCortoProducto, PDO::PARAM_STR);
    $statementAct->bindParam(':nombreAct', $nombreProducto, PDO::PARAM_STR);
    $statementAct->bindParam(':descripcionAct', $descripcionProducto, PDO::PARAM_STR);
    $statementAct->bindParam(':pvpAct', $pvpProducto, PDO::PARAM_STR);
    $statementAct->bindParam(':producto_id', $id, PDO::PARAM_INT);
    $statementAct->execute();
}
/**creaLogs, tendrá una subfunción que aumentará el contador y con una consulta de INSERT añadirá los nuevos datos.
 * 
 */
function creaLogs($conexion, $idProducto)
{
    // Aumento del atributo contador, recoge el maximo valor de ese atributo y le suma 1, asi irá aumentando a medida que se hagan logs.
    $consultaContador = "SELECT MAX(contador) as num FROM log";
    $contador = $conexion->query($consultaContador)->fetch(PDO::FETCH_ASSOC)['num'];
    $numFinal = $contador + 1;

    // Insertar datos a la tabla log
    $consultaLog = "INSERT INTO log (contador, cod_producto, fecha) VALUES (:num, :idProducto, NOW())";
    $statementInsertLog = $conexion->prepare($consultaLog);
    $statementInsertLog->bindParam(':idProducto', $idProducto, PDO::PARAM_STR);
    $statementInsertLog->bindParam(':num', $numFinal, PDO::PARAM_INT);
    $statementInsertLog->execute();
}
/**mostrarTablaLogs, con una consulta buscará los logs anteriormente creados e imprimirá en orden de fecha (los más nuevos delante)
 * 
 */
function mostrarTablaLogs($conexion)
{
    $consultaMLogs = "SELECT contador, cod_producto, fecha FROM log ORDER BY fecha DESC";
    $statement = $conexion->prepare($consultaMLogs);
    $statement->execute();
    $logs = $statement->fetchall(PDO::FETCH_ASSOC);

    if (!empty($logs)) {
        echo "<table>";
        echo "<tr><th>Num.</th><th>Producto</th><th>Fecha cambio</th></tr>";
        foreach ($logs as $log) {
            echo "<tr><td>{$log['contador']}</td><td>{$log['cod_producto']}</td><td>{$log['fecha']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p> No hay logs registrados en la base de datos. </p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
            border-spacing: 10px;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>
    <form>
        <fieldset>
            <legend>Registro de cambios</legend>
            <?php mostrarTablaLogs($conexion); ?>
            <a href="familia.php">
                <p style="text-align: center;">Volver al inicio</p>
            </a>
        </fieldset>
    </form>
</body>

</html>