<!-- CODIGO PHP -->
<?php
//inicio sesion
session_start();
//indico la zona horaria del servidor 
date_default_timezone_set('Europe/Madrid');

//funciones
//control de las variables de sesion de lugar de recogida y forma de pago, si existian que las añadan a esta pagina

if (isset($_SESSION['lugar_recogida'])) {
    $copialugarRecogida = $_SESSION['lugar_recogida'];
} else {
    $copialugarRecogida = "";
}

if (isset($_SESSION['forma_pago'])) {
    $copiaformaPago = $_SESSION['forma_pago'];
} else {
    $copiaformaPago = "";
}


function verFormasPago($pagoSeleccionado)
{
    $formasPago = array("Contado", "MasterCard", "Visa", "American Express");
    foreach ($formasPago as $tipo) {
        if ($tipo == $pagoSeleccionado) {
            echo "<option value='$tipo' selected>$tipo</option>";
        } else {
            echo "<option value='$tipo' >$tipo</option>";
        }
    }
}

function verLugarRecogida($lugarSeleccionado)
{
    $lugares = array("B.Pesquero", "Sardinero", "Bahia", "Cazoña");
    foreach ($lugares as $lugar) {
        if ($lugar == $lugarSeleccionado) {
            echo "<input type='radio' name='lugar_recogida' value='$lugar' checked >$lugar";
        } else {
            echo "<input type='radio' name='lugar_recogida' value='$lugar'>$lugar";
        }
    }
}

function calcularHoraEntrega()
{
    $horaActual = new DateTime();
    $horaEntrega = $horaActual->add(new DateInterval('PT30M'));   //(PT30M es 30min, si fueese (PT1H15M es 1hora y 15min))
    $horaEntregaFinal = $horaEntrega->format('H:i');
    return $horaEntregaFinal;
}

function mostrarNToppins()
{
    // primero comprobamos si se envio algun ingrediente 
    if (isset($_SESSION['ingredientesSeleccionados'])) {
        // funcion .count para contar la cantidad de toppins elegidos
        return count($_SESSION['ingredientesSeleccionados']);
    } else {
        // Si el array no está definido, retornar 0
        return 0;
    }
}

//ENVIO Y RECOGIDA DE DATOS EN FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //BOTON ANTERIOR
    if (isset($_POST['anterior'])) {
        //vuelta a la pagian de inicio
        $_SESSION['pedidos']--;
        header('Location: toppins.php');
        exit;
    }
    //BOTON CONFIRMAR
    if (isset($_POST['confirmar'])) {
        //control para comprobar si ha seleccionado una forma de pago y un lugar de recogida.
        if (!isset($_POST['forma_pago']) || !isset($_POST['lugar_recogida'])) {
            echo "<div style='color: blue; text-align:left; font-weight: bold; font-size: 25px'>***¡Tiene que seleccionar una forma de pago y un lugar de recogida!***</div>";
            header("refresh:2; Datos.php");
        } else {
            //se enviarán todos los datos mostrados en esta pagina a traves de session
            //primero asignaremos los valores recogidos del formulario
            $formaPago = $_POST['forma_pago'];
            $lugarRecogida = $_POST['lugar_recogida'];
            $horaEntrega = calcularHoraEntrega();
            $nToppins = mostrarNToppins();

            //segundo los almacenamos en la sesion;
            $_SESSION['forma_pago'] = $formaPago;
            $_SESSION['lugar_recogida'] = $lugarRecogida;
            $_SESSION['hora_entrega'] = $horaEntrega;
            $_SESSION['n_toppins'] = $nToppins;

            //avance pagina siguiente
            header('Location: pagos.php');
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

        p {
            color: red;

        }

        fieldset {
            height: 300px;
            width: 500px;
            border-color: blue;
            text-align: center;
            padding: 30px;
        }

        label {
            color: red;
        }

        select {
            margin-bottom: 120px;
        }
    </style>

</head>

<body>
    <fieldset>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div>
                <p style='display:inline'><b>Selecciona la forma de pago: </b></p> <select name='forma_pago'> <?php verFormasPago($copiaformaPago); ?> </select>

                <br>
            </div>

            <div>
                <p style='display:inline'><b>Lugar de recogida: </b></p><?php verLugarRecogida($copialugarRecogida); ?>
                <!-- <input type="hidden" name="lugar_recogida" value="lugar_recogida">  -->
                <br>
            </div>

            <div>
                <br>
                <p style='display:inline'><b>Hora de entrega: </b></p><?php echo calcularHoraEntrega(); ?>
                <input type="hidden" name="hora_entrega" value="hora">
            </div>

            <div>
                <br>
                <p style='display:inline'><b>Número de toppins: </b></p><?php echo mostrarNToppins(); ?>
                <input type="hidden" name="n_toppins" value="n_toppins">
            </div>
            <br>

            <div align='center' class="button">
                <input type="submit" value="Anterior" name="anterior" />
                <input type="submit" value="Confirmar" name="confirmar" />
            </div>
        </form>
    </fieldset>

</body>

</html>