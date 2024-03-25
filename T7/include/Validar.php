<?php
/** Uso de XAJAX para realizar una llamada asincrona al sercidor y validar las credenciales de usuario
 * Es necesario crear una instancia XAJAX y registrar la funcion que vamos a definir (vUsuario)
 * Luego "Validar.php" tendrá que ser llamada desde "login.php" y junto con el script "validar.js"para que realice esta validacion
 */
require 'Usuario.php';
require_once 'xajax_core/xajax.inc.php';

$xjax=new xajax();
$xjax->register(XAJAX_FUNCTION, 'vUsuario');
$xjax->processRequest();

function vUsuario($u, $p){

        $resp=new xajaxResponse();
        if(strlen($u)==0 || strlen($p)==0){
            $resp->setReturnValue(false);
        }
        else {
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