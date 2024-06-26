<?php
require 'Conexion.php';
require 'Usuario.php';
require_once 'xajax_core/xajax.inc.php';

$xajax = new xajax();
$xajax->register(XAJAX_FUNCTION, 'vUsuario');
$xajax->processRequest();

function vUsuario($u, $p)
{
    $resp = new xajaxResponse();
    if (strlen($u) == 0 || strlen($p) == 0) {
        $resp->setReturnValue(false);
    } else {
        $usuario = new Usuario();
        if (!$usuario->isValido($u, $p)) {
            $resp->setReturnValue(false);
        } else {
            session_start();
            $_SESSION['usu'] = $u;
            $resp->setReturnValue(true);
        }
        $usuario = null;
    }
    return $resp;
}
