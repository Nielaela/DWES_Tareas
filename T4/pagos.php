<?php
//inicio sesion
session_start();

$formaPago = $_SESSION['forma_pago'];
$lugarRecogida = $_SESSION['lugar_recogida'];
$horaEntrega = $_SESSION['hora_entrega'];
$nToppins = $_SESSION['n_toppins'];

function calcularImporte($nToppins)
{
    $precioAdicional = 2;
    $importeFijo = 10;

    if ($nToppins <= 3) {
        $importeFinal = $importeFijo;
    } else {
        $importeFinal = $importeFijo + ($nToppins - 3) * $precioAdicional;
    }
    return $importeFinal;
}

function mostrarIngredientesPedido($pizza)
{
    foreach ($pizza as $ingrediente) {
        echo "$ingrediente";
        echo "<br>";
    }
}
//ENVIO Y RECOGIDA DE DATOS EN FORMULARIO
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //BOTON MODIFICAR
    if (isset($_POST['modificar'])) {
        //vuelta a la pagina anterior
        header('Location: datos.php');
        exit;
    }
    //BOTON PAGAR
    if (isset($_POST['pagar'])) {
        //reinicio de valores 
        $_SESSION['ingredientesSeleccionados'] = array();
        //pagina de inicio
        echo "<div style='color: blue; text-align:left; font-weight: bold; font-size: 25px'>*****PEDIDO REALIZADO****</div>";
        header("refresh:2; toppins.php");
        exit;
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
        h2 {
            color: red;
        }

        p {
            color: red;

        }

        fieldset {
            height: auto;
            width: 500px;
            border-color: blue;
            text-align: center;
            padding: 30px;
        }

        .datos_pedido {
            text-align: left;
        }

        .relacion_ingredientes {
            color: blue;
            text-align: left;
        }
    </style>

</head>

<body>
    <fieldset>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Servicio express (Resumen del pedido)</h2>
            <div class="datos_pedido">
                <div>
                    <p style='display:inline'><b>Lugar de recogida: </b></p> <?php echo $lugarRecogida ?>
                </div>
                <div>
                    <p style='display:inline'><b>Forma de pago </b></p> <?php echo $formaPago ?>
                </div>
                <div>
                    <p style='display:inline'><b>Hora de entrega </b></p> <?php echo $horaEntrega ?>
                </div>
                <div>
                    <p style='display:inline'><b>Total de ingredientes </b></p> <?php echo $nToppins ?>
                </div>
                <div>
                    <p style='display:inline'><b>Importe </b></p> <?php echo calcularImporte($nToppins) ?>€.
                </div>
            </div>

            <div class="relacion_ingredientes">
                <br>
                <b>RELACION DE INGREDIENTES:</b><br><?php mostrarIngredientesPedido($_SESSION['ingredientesSeleccionados']); ?>
                <br>
            </div>
            <div align='center' class="button">
                <input type="submit" value="Modificar" name="modificar" />
                <input type="submit" value="Pagar" name="pagar" />
            </div>
        </form>
    </fieldset>

</body>

</html>