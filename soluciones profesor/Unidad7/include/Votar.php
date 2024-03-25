<?php
spl_autoload_register(function ($clase) {
    if ($clase != 'xajax')
        include $clase . ".php";
});
require_once 'xajax_core/xajax.inc.php';

$xjax = new xajax();
$xjax->register(XAJAX_FUNCTION, 'miVoto');
$xjax->register(XAJAX_FUNCTION, 'pintarEstrellas');
$xjax->processRequest();

function miVoto($u, $p, $c)
 {

    $resp = new xajaxResponse();
    if (strlen($u) == 0 || strlen($p) == 0) {
        $resp->setReturnValue(false);
    } else {
        $voto = new Voto();
        if ($voto->puedeVotar($u, $p)) {
            $voto->setIdPr($p);
            $voto->setIdUs($u);
            $voto->setCantidad($c);
            $voto->create();
            $resp->setReturnValue($voto->getMedia($p));
        } else {
            $resp->setReturnValue(false);
        }
        $voto = null;
    }
    return $resp;
}
function pintarEstrellas($c, $p)
{
    $voto=new Voto();
    $total=$voto->getTotalVotos($p);
    $voto=null;
    $resp = new xajaxResponse();
    $en = intval($c);
    $dec = $c - $en;
    $estrellas = "$total Valoraciones. ";
    if ($en > 0) {
        for ($i = 1; $i <= $en; $i++) {
            $estrellas .= "<i class='fas fa-star'></i>";
        }
        if ($dec >= 0.5)
            $estrellas .= "<i class='fas fa-star-half-alt'></i>";
    }
    $resp->assign("votos_$p", "innerHTML", $estrellas);
    return $resp;
}
