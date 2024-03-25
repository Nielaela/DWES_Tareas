<?php
/**Similar a Validar.php, uso de XAJAX para realizar una serie de funciones asincronas desde cliente/servidor
 * Esta la funcion miVoto que controlará la insercion de votos
 * Y la funcion pintarEstrellas, que al usar XAJAX mostramos de forma asincrona los datos, en este caso
 * se quiere mostrar al momento la puntuacion en estrellas tras realizar un voto
 * las estrellas se pintan gracias a classes importadas por "fontawesome"
 */
require 'Voto.php';
require_once 'xajax_core/xajax.inc.php';

$xjax=new xajax();

$xjax->register(XAJAX_FUNCTION, 'miVoto');
function miVoto($cantidad, $idPr, $idUs){
    $resp=new xajaxResponse();
    $voto = new Voto();   
    
    if (!$voto->isValido($idPr, $idUs)) {
        $resp->setReturnValue(false);
    } else {
        $voto->insertarVoto($cantidad, $idPr, $idUs);
        $resp->setReturnValue(true);
    }
    return $resp;
}


$xjax->register(XAJAX_FUNCTION, 'pintarEstrellas');
function pintarEstrellas(){
    $resp=new xajaxResponse();
    $voto = new Voto();
    $resultado = $voto->pintarEstrellas();
    
    foreach ($resultado as $key => $value) {
        $id = $value['id'];
        $mediaVotos = $value['mediaVotos'];
        $numVotos = $value['numVotos'];
        $innerHTML = '';
        if($numVotos == 0){
            $innerHTML = 'Sin valoración';
        }else{
            $innerHTML .= '<p>' . $numVotos . ' valoraciones: ';
            if(floor($mediaVotos) != $mediaVotos){
                for ($i=0; $i < $mediaVotos - 1; $i++) { 
                    $innerHTML .= '<i class="fas fa-star"></i>';
                }
                $decimal = $mediaVotos - floor($mediaVotos);
                if($decimal >= 0.5){
                    $innerHTML .= '<i class="fas fa-star-half"></i>';
                }
            }else{
                for ($i=0; $i < $mediaVotos; $i++) { 
                    $innerHTML .= '<i class="fas fa-star"></i>';
                }
            }

            $innerHTML .= '</p>';
        }
        //enlace con el id "votos_" para luego usarse en el HTML donde se muestra la tabla con cada producto
        $resp->assign("votos_" . $id, "innerHTML", $innerHTML);
    }

    $resp->setReturnValue(true);
    $voto = null;
    return $resp;

}

$xjax->processRequest();