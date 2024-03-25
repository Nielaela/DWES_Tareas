function envVoto(usu, pro) {
    $id = "spuntos_" + pro;
    var puntos = document.getElementById($id).value;
    console.log("antes votar");
    var res = xajax.request({ xjxfun: 'miVoto' }, { mode: 'synchronous', parameters: [usu, pro, puntos] });
    //var res = xajax_vUsuario(usu, pass);
    if (res == false) {
        alert("Ya has votado ese producto !!!");
        return res;
    }
    console.log("despues votar");
    var res2 = xajax.request({ xjxfun: 'pintarEstrellas' }, { mode: 'synchronous', parameters: [res, pro] });
    return res2;

}