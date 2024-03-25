<?php
require_once('conexión.php');

// Obtener el valor de id si está presente en $_POST (emviado del formulario anterior en familia.php)
if (isset($_POST["id"])) {
    $id = $_POST["id"];
} else {
    // Manejar el caso en que id no está presente en $_POST
    echo "Error: El ID del producto no está presente en el formulario.";
}

// DECLARACIÓN VARIABLES GLOBALES
// Estas variables se utilizaran en la llamada de la función mostrarDatosProducto dentro del formulario, para así poder mostrar los valores obtenidos.
$nombre_corto;
$nombre;
$descripcion;
$pvp;
//FUNCIONES
/**mostrarDatosProductos, tiene como parametros de entrada el $id que traemos del anterior formulario, y otros cuatro parametros que los definiremos como variables de referencia (&).
con la variable $idProducto se hara una consulta a la tabla productos donde obtendremos los valores correspondientes a esa fila y aignaremos los resultados en las variables $nombreCortoProducto, $nombreProducto, 
$descripcionProducto y $pvpProducto, que como se definieron como variables de referencia podremos obtener fuera de la función esos valores. 
De esta forma ya en el formulario podremos ver los valores de estas variables correspondientes a las características de los productos.
 */

function mostrarDatosProducto($conexion, $idProducto, &$nombreCortoProducto, &$nombreProducto, &$descripcionProducto, &$pvpProducto)
{
    $consultaP = "SELECT id, nombre, nombre_corto, pvp, descripcion FROM productos WHERE id = :ID_producto";
    $statement = $conexion->prepare($consultaP);
    $statement->bindParam(':ID_producto', $idProducto, PDO::PARAM_STR);
    $statement->execute();
    $datosProducto = $statement->fetch(PDO::FETCH_ASSOC);

    //Asigno los valores obtenidos de la consulta a variables:
    $nombreCortoProducto = $datosProducto['nombre_corto'];
    $nombreProducto = $datosProducto['nombre'];
    $descripcionProducto = $datosProducto['descripcion'];
    $pvpProducto = $datosProducto['pvp'];
}

// Controles para los botones del formulario.
//Se guardaran y enviaran los valores modificados del producto a actualizar.php
if (isset($_POST["actualizar"])) {
    $id = $_POST["id"];
    $nombreCorto_Modificado = $_POST["nombre_corto"];
    $nombre_Modificado = $_POST["nombre"];
    $descripcion_Modificado = $_POST["descripción"];
    $pvp_Modificado = $_POST["pvp"];
    header("Location: actualizar.php?id=" . urlencode($id) . "&nombre_corto=" . urlencode($nombreCorto_Modificado) . "&nombre=" . urlencode($nombre_Modificado) . "&descripción=" . urlencode($descripcion_Modificado). "&pvp=" . urlencode($pvp_Modificado));    exit(); 
}
//Botón cancelar
if (isset($_POST["cancelar"])) {
    echo "Cancelando...";
    header("refresh:2; familia.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        textarea{
            overflow-y: scroll;
            width: 500px;
            height: 100px;
            resize: none;
        }

    </style>
</head>

<body>
    <?php
    mostrarDatosProducto($conexion, $id, $nombreCorto, $nombre, $descripcion, $pvp);
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div style="background-color:lightblue">
            <h2> Tarea: Edición de un producto</h2>
        </div>
        <div>
            <h2 style='display:inline'>Producto: </h2> <?php echo $id; ?>
            <input type='hidden' name='id' value="<?php echo $id; ?>">
        </div>
        <div>
            <div>
                <label for="nombre">Nombre:</label>
                <br>
                <textarea name="nombre"> <?php echo $nombre; ?></textarea>  
            </div>

            <div>
                <label for="producto"> Nombre corto:</label>
                <input type="text" name="nombre_corto" style='display:inline' value="<?php echo $nombreCorto; ?>" />
            </div>

            <div>
                <label for="descripción">Descripción:</label>
                <br>
                <textarea name="descripción"> <?php echo $descripcion; ?></textarea>  
            </div>
            <div>
                <label for="pvp">PVP:</label>
                <input type="text" name="pvp" style='display:inline' value="<?php echo $pvp; ?>" />
            </div>
        </div>

        <div align='left' class="button">
            <input type="submit" value="Actualizar" name="actualizar" />
            <input type="submit" value="Cancelar" name="cancelar" />
        </div>
    </form>

   
</form>
</body>

</html>

