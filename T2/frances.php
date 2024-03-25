<!-- Codifica el programa llamado frances.php que permita hacer el estudio contable del préstamo de un capital. Con los
datos de partida el programa presentará una tabla de amortización por el método francés o de cuotas constantes.
En este ejemplo: tenemos un préstamo de 5.000 €, que se espera amortizar en un plazo de 6 años, con un tipo de
interés del 5% TAE bajo el método de amortización francés, la cuota de amortización calculada será 985,09 euros. La
cuota destinada a amortizar el capital permanece constante durante todo el plazo del préstamo, cada período se va
reduciendo el capital a amortizar y los intereses a pagar. -->

<?php

//prueba commit
$capital = 5000;
$anios = 6;
$interesTAE = 0.05;
$capitalPendiente = $capital; //inicial
$cuota = calcularCuota($capital, $interesTAE, $anios);


function calcularCuota($capital, $interesTAE, $anios)
{
    return ($capital * $interesTAE) / (1 - pow((1 + $interesTAE), -$anios));
}

function calcularIntereses($capitalPendiente, $interesTAE)
{
    return $capitalPendiente * $interesTAE;
}

function calcularAmortizacion($cuota, $intereses)
{
    return  $cuota - $intereses;
}

function calcularCapitalPendiente($capitalPendiente, $amortizacion)
{
    return $capitalPendiente - $amortizacion;
}

echo "<h3 align ='center'>TABLA DE AMORTIZACIÓN POR EL MÉTODO FRANCÉS </h3>";
echo "<table border='1' align='center'>\n";
echo "<tr>\n";
echo "<th align='center'><b>Año</b></th>\n";
echo "<th align='center'><b>Cuota</b></th>\n";
echo "<th align='center'><b>intereses</b></th>\n";
echo "<th align='center'><b>Amortizacion</b></th>\n";
echo "<th align='center'><b>Capital pendiente</b></th>\n";
echo "</tr>\n";

echo "<tr>\n";
echo "<td>0</td>\n";
echo "<td> </td>\n";
echo "<td> </td>\n";
echo "<td> </td>\n";
echo "<td>$capitalPendiente €</td>\n";
echo "</tr>\n";


for ($i = 1; $i <= $anios; $i++) {

    $intereses = calcularIntereses($capitalPendiente, $interesTAE);
    $amortizacion = calcularAmortizacion($cuota, $intereses);
    $capitalPendiente = calcularCapitalPendiente($capitalPendiente, $amortizacion);

    $cuotaFormateada = number_format($cuota, 2, ',','.') . ' €';
    $interesesFormateada = number_format($intereses, 2, ',','.') . ' €';
    $amortizacionFormateada = number_format($amortizacion, 2, ',','.') . ' €';
    $capitalPendienteFormateada = number_format($capitalPendiente, 2, ',','.') . ' €';
    echo "<tr>\n";
    echo "<td>$i</td>\n";
    echo "<td>$cuotaFormateada</td>\n";
    echo "<td>$interesesFormateada</td>\n";
    echo "<td>$amortizacionFormateada</td>\n";
    echo "<td>$capitalPendienteFormateada</td>\n";
    echo "</tr>\n";
}
echo "</table>\n";

?>