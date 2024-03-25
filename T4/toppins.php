<!-- //CODIGO PHP -->
<?php
//inicio sesion
session_start();

if (!isset($_SESSION['pedidos'])) {
    $_SESSION['pedidos'] = 1;
}

//array asociativo con ingredientes sus cantidades e imagenes
$toppins = array(
    'Queso de cabra' => array('cantidad' => 12, 'imagen' => 'queso_cabra.jpg'),
    'Pollo' => array('cantidad' => 7, 'imagen' => 'pollo.jpg'),
    'Pimiento' => array('cantidad' => 11, 'imagen' => 'pimiento.jpg'),
    'Alcaparras' => array('cantidad' => 6, 'imagen' => 'alcaparras.jpg'),
    'Anchoa' => array('cantidad' => 5, 'imagen' => 'anchoa.jpg'),
    'Aceitunas' => array('cantidad' => 18, 'imagen' => 'aceitunas.jpg'),
    'Carne' => array('cantidad' => 15, 'imagen' => 'carne.jpg'),
    'Pepperoni' => array('cantidad' => 10, 'imagen' => 'pepperoni.jpg'),
    'Cebolla' => array('cantidad' => 13, 'imagen' => 'cebolla.jpg'),
    'Piña' => array('cantidad' => 9, 'imagen' => 'piña.jpg'),
    'Jamon York' => array('cantidad' => 14, 'imagen' => 'jamon_york.jpg'),
    'Atún' => array('cantidad' => 8, 'imagen' => 'atun.jpg'),
    'Cebolla crujiente' => array('cantidad' => 30, 'imagen' => 'cebolla_crujiente.jpg'),
    'Salchichas' => array('cantidad' => 18, 'imagen' => 'salchichas.jpg'),
    'Berenjena' => array('cantidad' => 23, 'imagen' => 'berenjena.jpg'),

);

//control para comprobar si ya existia el array ingredientesSeleccionados en la sesion.
//si existe hacer una copia y si no existe, inicializar la copia vacia
if (isset($_SESSION['ingredientesSeleccionados']) && is_array($_SESSION['ingredientesSeleccionados'])) {
    $copiaingredientesSeleccionados = $_SESSION['ingredientesSeleccionados'];
} else {
    $copiaingredientesSeleccionados = array();
}

//se llamará en el formulario para mostrar todos los ingredientes, se controlará la existencia previa de ingredientes seleccionados en la sesion (volver de datos.php)
function listarIngredientes($toppins, $ingredientesSeleccionados)
{
    foreach ($toppins as $toppin => $datos) {
        //creo variables para los datos del array
        $cantidad = $datos['cantidad'];
        $imagen = $datos['imagen'];

        if ($cantidad > 0) {
            echo "<div class= 'ingrediente'>";
            echo "<label>";
            echo "<img src='toppingsFotos/$imagen' alt='$toppin'>";
            //control para el checkbox, si no existia un array de ingredientesSeleccionados en la sesión anteriormente muestra los ingredientes para elegir,
            //si existia ya el array en la sesión, activa los ingredientes que estaban seleccionados.
            if(in_array($toppin,$ingredientesSeleccionados)){
                echo "<input type='checkbox' name='ingredientes_seleccionados[$toppin]' value='$toppin' checked>";
            }else{
                echo "<input type='checkbox' name='ingredientes_seleccionados[$toppin]' value='$toppin'>";
                }
            echo "$toppin";
            echo "</label>";
            echo "</div>";
        }
    }
}

//conteo de los pedidos, la función se utiliza al enviar un pedido (función enviarIngredientes)
function contarEncargos()
{
    //control del contador, si no existe la variable pedidos en la sesión la iniciamos a 1, y si existe se aumenta en 1.
    if (!isset($_SESSION['pedidos'])) {
        $_SESSION['pedidos'] = 1;
    } else {
        $_SESSION['pedidos']++;

        //control de maximo de pizzas, tras llegar al maximo se reinicia la sesion
        if ($_SESSION['pedidos'] >= 50) {
            session_destroy();
            session_start();
            $_SESSION['pedidos'] = 1;
        }
    }
}

//se crea el array de ingredientes seleccionados en la session, la función se llama al darle al botón Siguiente.
function enviarIngredientes($ingredientes_seleccionados)
{
    //array para guardar los ingredientes elegidos en la sesion desde el formulario
    if (!isset($_SESSION['ingredientesSeleccionados'])) {
        $_SESSION['ingredientesSeleccionados'] = array();
    }
    //se añaden los ingredientes elegidos a la sesion
    $_SESSION['ingredientesSeleccionados'] = $ingredientes_seleccionados;
    //contar el pedido
    contarEncargos();
}


//ENVIO Y RECOGIDA DE DATOS EN FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //BOTON CERRAR
    if (isset($_POST['cerrar'])) {
        //cierro sesion y reinicio de numero de pedidos
        session_destroy();
        session_start();
        $_SESSION['pedidos'] = 1;
        //vuelta a la pagian de inicio
        header('Location: toppins.php');
        exit;
    }
    //BOTON SIGUIENTE
    if (isset($_POST['siguiente'])) {
        //funcion envio de ingredientes seleccionados
        if (!isset($_POST['ingredientes_seleccionados'])) {
            echo "<div style='color: blue; text-align:left; font-weight: bold; font-size: 25px'>***¡Por favor, selecciona algún ingrediente!***</div>";
            header("refresh:2; toppins.php");
        } else {
            enviarIngredientes($_POST['ingredientes_seleccionados']);
            //avance pagina siguiente
            header('Location: Datos.php');
            exit;
        }
    }
}
?>
<!-- FORMULARIO -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Aquí puedes escribir tus estilos CSS */
        body {
            text-align: center;
        }

        h1,
        h2,
        h3 {
            color: red;

        }

        hr {
            color: red;
            border-width: 4px;
        }

        .ingrediente {
            display: inline-block;
            margin: 10px;
            text-align: center;
        }

        img {
            display: block; 
            max-width: 150px;
            max-height: 150px;         
            height: auto;
        }

        fieldset {
            height: 800px;
            width: 1000px;
            border-color: blue;
            text-align: center;
            padding: 30px;
        }
    </style>

</head>

<body>
    <fieldset>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>SISTEMA DE ENCARGO DE PIZZA ONLINE</h2>
            <hr>
            <h3>Número de encargo: <?php echo $_SESSION['pedidos'] ?></h3>
            <hr>
            <h2>Personaliza la pizza: elige tus ingredientes</h2>
            <div>
                <?php listarIngredientes($toppins,$copiaingredientesSeleccionados) ?>
                <br>
            </div>

            <div align='center' class="button">
                <input type="submit" value="CERRAR" name="cerrar" />
                <input type="submit" value="Siguiente" name="siguiente" />
            </div>
        </form>
    </fieldset>

</body>

</html>