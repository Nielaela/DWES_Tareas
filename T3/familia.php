<!-- El programa llamado familia.php mostrara una lista desplegable que permita seleccionar un registro de la tabla 'familias', junto a un botón "Mostrar
productos". Al pulsar el botón, se mostrará un listado de los productos que pertenecen a la familia elegida.
Por cada fila se muestra el nombre_corto, el precio y se genera un botón "Editar"
Al pulsar en el botón “Editar” se envía el formulario a la página cambios.php para poder modificar la ficha de datos del producto elegido. -->

<?php
// conexión a la BBDD
require_once('conexión.php');

//FUNCIONES
/**verFamilias, conectandose a la base de datos realizará una query que recogerá los valores (cod y nombre) de la tabla familia.
La función fetch recorre todas las filas obtenidos de la consulta (resultado), creando un array asociativo de cada fila
Finalmente se crean las opciones de familia mostrando el valor de nombre, para más tarde en la parte html mostrarlo dentro de la lista desplegable con select
Es importante tener en cuenta que se está enviando al servidor el valor "cod" de las familias, así mas tarde en la función "mostrarProductosFamilia", muestre los
que correspondan a esa familia.
*/
function verFamilias($conexion)
{
    $consulta = "SELECT cod, nombre FROM familias";
    $resultado = $conexion->query($consulta);

    if ($resultado) {
        while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$fila['cod']}'>{$fila['nombre']}</option>";
        }
    } else {
        echo "Error al obtener las familias.";
    }
}
/**mostrarProductosFamilia, realizará otra consulta en la que el valor de familia lo iguala a familiaSeleccionada, de esta forma tras vincualrlo (bindParam) con la variable codigoFamilia
más tarde podrá mostrar los productos de esa familia, porque la variable codigoFamilia recogerá en el formulario el valor que corresponderá con el codigo de la familia, que anteriormente se habia enviado al servidor.
Se crea el array asociativo de los productos correspondientes, y más tarde con echo se imprimen los valores que interesan (nombre y pvp) y se le adjuntara la funcion "editarProductos" que será el botón editar del formulario.
Existen familias que no tienen productos, se controlará mostrando un aviso en tal caso.
*/
function mostrarProductosFamilia($conexion, $codigoFamilia)
{
    $consultaF = "SELECT id, nombre, nombre_corto, pvp, familia FROM productos WHERE familia = :familiaSeleccionada";
    $statement = $conexion->prepare($consultaF);
    $statement->bindParam(':familiaSeleccionada', $codigoFamilia, PDO::PARAM_STR);
    $statement->execute();
    $productos = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "<h3>Productos de la familia: </h3>";

    //control de si existen productos o no de la familia indicada
    if (count($productos) > 0) {
        echo "<ul>";
        foreach ($productos as $fila) {
            echo "<li> Producto {$fila['nombre_corto']} - {$fila['pvp']} euros ";
            editarProductos($fila['id']);
            echo "</li>";
        }

        echo "</ul>";
    } else {
        echo "<p> No hay productos disponibles para esta familia. </p>";
    }
}
/**editarProductos, función que enviariá el codigo del producto a la siguiente página cambios.php
 */
function editarProductos($id)
{
    echo "<form action='cambios.php' method='post' style='display:inline'>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<input type='submit' name='editarProducto' value='Editar'>";
    echo "</form>";
}

?>
<!-- FORMULARIO -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div style="background-color:lightblue">
            <h2> Tarea: Listado de productos de una familia </h2>
            Familia: <select name='familia'> <?php verFamilias($conexion) ?> </select>
            <input type="submit" name="mostrarProductosFamilia" value="Mostrar Productos">
        </div>
    </form>
    <?php
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mostrarProductosFamilia'])) {
        $codigoFamilia = $_POST['familia'];
        mostrarProductosFamilia($conexion, $codigoFamilia);
    }
    ?>
</body>

</html>