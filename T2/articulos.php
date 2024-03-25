<!-- Codifica el programa “articulos.php” que tenga un formulario de entrada de datos para registrar un artículo
en un almacén. Se introducirá la descripción, la clave de categoría, el precio, y el stock así como una colección
de recargos que puede tener la nueva prenda.
La descripción, el precio y el stock: se introducen mediante cajas de texto. La clave de categoría será una
lista desplegable que se crea dinámicamente a partir de un array que contiene: INF, JUV, VET, ALE, CLASE_A,
CLASE_B, CLASE_C
Los recargos que tiene la prenda se eligen mediante checkbox: importación=>10%, diseño=>12%,
temporada=>8%, piel=>15%. Una prenda puede contener varios conceptos.
Los datos de entrada se reciben del formulario y se harán las siguientes operaciones:
• Validar que no estén vacíos el PVP ni el stock.
• Codifica la función calcula_recargo() que calcula el importe de los recargos que tiene la prenda.
• Codifica la función calcula_total() que calcula el importe total a pagar
(precio+recargos), y aplica un descuento del 5%.
• Visualiza detalladamente los datos de la prenda y de su coste. -->

<?php
function categoria()
{
    $categorias = array("INF", "JUV", "VET", "ALE", "CLASE_A", "CLASE_B", "CLASE_C");
    foreach ($categorias as $cat) {
        echo "<option value='$cat' >$cat</option>";
    }
}

//operaciones
$recargoPorcentajes = array("importacion" => 0.1, "diseño" => 0.12, "temporada" => 0.08, "piel" => 0.15);

//funcion calcula_recargo, dependiendo de los recargos seleccionados en el checkbox del formulario (name="recargos[]") genera un array.
//de esta forma busca la equivalencia en el array que creamos con los tipos de recargo y su valor ("recargoPorcentajes")
//finalmente devuelve el valor del precio por el recargo final.
function calcula_recargo($recargos,$precio, $recargoPorcentajes)
{
    $recargo_total = 0;

    foreach ($recargos as $opcion) {
        if (array_key_exists($opcion, $recargoPorcentajes)) {
            $recargo_total += $recargoPorcentajes[$opcion];
        }
    }

    return $recargo_total*$precio;
}
//funcion calcula_total, con una serie de operaciones se obtiene el valor del descuento final del producto y su precio final teniendo en cuenta el recargo.
function calcula_total($precio, $recargos, $recargoPorcentajes)
{
    $descuento = 0.05;
    $productoDescuento = ($precio * $descuento);
    $recargo_total = calcula_recargo($recargos,$precio, $recargoPorcentajes);
    $PVP = ($precio + $recargo_total) - $productoDescuento;

    return $PVP;
}
//funcion visualizar, mostrará por pantalla mediante echo una plantilla que da la información de todos los datos solicitados con los calculos finales.
 function visualizar($descripcion,$categoria,$stock,$recargos,$recargoPorcentajes,$precio,$productoDescuento,$PVP){
    echo "<h3 align ='center'>Producto guardado </h3>";
    echo "<p align = 'center'> Descripción: $descripcion";
    echo "<p align = 'center'> Categoría: $categoria";
    echo "<p align = 'center'> Stock: $stock";
    echo "<p align = 'center'> Recargos:" . implode(", ", $recargos);
    echo "<p align = 'center'> Precio: $precio €.+ Recargo:". calcula_recargo($recargos,$precio, $recargoPorcentajes) . "€.- Descuento: $productoDescuento €. = PVP: $PVP €."; 
 }  

//envio de datos al formulario
if (isset($_POST['guardar'])) {
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    //control del valor de recargos, si no hay deja el array en vacio
    if (isset($_POST['recargos'])) {
        $recargos = $_POST['recargos'];
    } else {
        $recargos = [];
    }

//Validación de los campos precio y stock (el formulario tendrá atributo "required" ademas)
//se llamará al metodo visualizar para mostrar los datos finales (para que funcione ese metodo necesita el valor del $productodescuento y del $PVP, se calculan previamente.)
    if (empty($precio) || empty($stock)) {
        echo "<b>Precio y Stock no pueden estar vacios</b>" ;
    } else {
        $productoDescuento = $precio * 0.05;
        $PVP = calcula_total($precio, $recargos, $recargoPorcentajes);
        visualizar($descripcion,$categoria,$stock,$recargos,$recargoPorcentajes,$precio,$productoDescuento,$PVP);
    }
    
}
?>

<!-- FORMULARIO -->
<style>
    fieldset div {
        margin-bottom: 10px;
    }
</style>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <h2 align='center'> Registro de productos </h2>
    <fieldset style="width:50%; height:auto; margin:auto">

        <div>
            <br><label for="descripcion">Descripcion:</label>
            <input type="text" name="descripcion" />

        </div>
        <div>
            <label for="categoria">Clave de categoria:</label>
            <select name="categoria">
                <?php
                categoria();
                ?>
            </select>
        </div>
        <div>
            <label for="precio">Precio:</label>
            <input type="text" name="precio" required /> €.
        </div>

        <div>
            <label for="stock">Stock:</label>
            <input type="text" name="stock" required />Ud.
        </div>
        <div>
            <br> <label for="recargos"><b>Recargos:</b></label><br><br>

            <input type="checkbox" name="recargos[]" value="importacion"> Importación

            <input type="checkbox" name="recargos[]" value="diseño"> Diseño

            <input type="checkbox" name="recargos[]" value="temporada"> Temporada

            <input type="checkbox" name="recargos[]" value="piel"> Piel

        </div>

        <br>
        <div align='right' class="button"> <input type="submit" value="Guardar" name="guardar" />
        </div>
    </fieldset>
</form>

