<!-- Codifica el programa llamado correos.php en el que definimos un array asociativo con una colección de nombres de
alumnos y sus correos. Por ejemplo:
array("Juan" =>”juan@educantabria.es”,
“Pablo” =>”pablo@gmail.com”,
“Elena”=>”elena@yahoo.es”,
Etc
)
Completa el array con otros tres alumnos. Tendremos una función que muestre en una tabla los valores de la siguiente
forma: cada fila par e impar tendrá un color alternativo. Elige una gama de colores diferente a la del ejemplo
Codifica un formulario con dos cajas de textos y los siguientes botones:
• Ver correo: invoca a una función que devuelve el correo del alumno elegido. Da un mensaje de error si no está
almacenado el nombre.
• Añadir: se teclea un nuevo nombre y su correo y la función permite añadir estos datos al array existente.
(verifica que no exista el nombre que se quiere añadir)
El programa mostrará siempre los datos del array.
Verifica los casos de error al localizar los datos. Utiliza para ello funciones
específicas de búsqueda de claves y/o valores en un array como son
array_key_exists() y array_search (), in_array(), etc.
Observación: Tendrás el problema de que al recargar el programa se pierden los valores añadidos. Para conservarlos
se utilizan las variables de sesión, pero éstas se estudian en la unidad 4, por tanto, otro recurso con los elementos de
programación disponibles hasta este momento será enviar el array de datos ocultos en el formulario. Lo más efectivo
es serializar el array y enviarlo como elemento oculto (HIDDEN) en el formulario -->

<?php

$usuarios = array(
    "Juan" => "juan@educantabria.es", "Pablo" => "pablo@gmail.com", "Elena" => "elena@yahoo.es",
    "Daniela" => "danielarc@educantabria.es", "Pedro" => "pedro@gmail.com", "Nicolas" => "nicorc@hotmail.es"
);

//Inicialización del array o recuperación de la serialización 
if (isset($_POST["usuarios"])) {
    $usuarios = unserialize($_POST["usuarios"]);
}

//condiciones para controlar el envio de datos al formulario y uso de funciones.
if (isset($_POST["aniadirUsuario"])) {
    $nombreFormulario = $_POST["nombreFormulario"];
    $correoFormulario = $_POST["correoFormulario"];
    aniadirUsuario($nombreFormulario, $correoFormulario, $usuarios);
}

if (isset($_POST["verCorreo"])) {
    $nombreFormulario = $_POST["nombreFormulario"];
    verCorreo($usuarios, $nombreFormulario);
}



echo "<h3 align ='center'>TABLA USUARIOS </h3>";
echo "<table border='1' align='center'>\n";
echo "<tr bgcolor = 'grey'>\n";
echo "<td align='center'><b>Nombre</b></td>\n";
echo "<td align='center'><b>Correo</b></td>\n";
echo "</tr>\n";
mostrarTabla($usuarios);
echo "</table>\n";
echo "<br>";

//funcion mostrarTabla, se alternará el color con la ayuda de un contador y su modulo. Con echo se mostrará por pantalla los datos obtenidos por el foreach del array.
function mostrarTabla($usuarios)
{
    $color = 'pink';
    $x = 1;

    foreach ($usuarios as $nombre => $correo) {
        if ($x % 2 == 0) {
            $color = 'pink';
        } else {
            $color = 'lightgreen';
        }
        echo "<tr bgcolor = '$color'>\n";
        echo "<td align='center'><b>$nombre</b></td>\n";
        echo "<td align='center'><b>$correo</b></td>\n";
        echo "</tr>\n";
        $x++;
    }
}


//funciones para el formulario
//vercorreo, controlará si el campo esta vacio, si el nombre escrito coincide o no con los existentes.
function verCorreo($usuarios, $nombreFormulario)
{
    if (empty($nombreFormulario)) {
        echo "No ha indicado ningún nombre";
    } else {
        if (array_key_exists($nombreFormulario, $usuarios)) {
            echo "Correo de $nombreFormulario: " . $usuarios[$nombreFormulario];
        } else {
            echo "El usuario $nombreFormulario no está registrado en la Agenda.";
        }
    }
}
//añadirUsuario, controlará si los campos estan vacios, si el nombre existe anteriormente y en caso negativo agregará el usuario.
function aniadirUsuario($nombreFormulario, $correoFormulario, &$usuarios)
{
    if (empty($nombreFormulario) || empty($correoFormulario)) {
        echo "Para agregar un nuevo usuario tiene que rellenar los campos <b>nombre</b> y <b>correo</b>";
    } else {
        if (array_key_exists($nombreFormulario, $usuarios)) {
            echo "El usuario $nombreFormulario ya está registrado en la agenda ";
        } else {
            $usuarios[$nombreFormulario] = $correoFormulario;
            echo "El usuario $nombreFormulario se ha agregado en la Agenda.";
        }
    }
}


?>

<html>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h3> Agenda : Nombres y Correos </h3>
        Introduce un nombre: <input type="text" name="nombreFormulario"><br>
        Introduce una dirección de correo: <input type="mail" name="correoFormulario"><br>
        <br>
        <input type="submit" name="verCorreo" value="Ver el correo">
        <input type="submit" name="aniadirUsuario" value="Añadir">
        <!-- Array serializado como un valor oculto en el formulario -->
        <input type="hidden" name="usuarios" value='<?php echo serialize($usuarios); ?>'>

    </form>


</body>

</html>