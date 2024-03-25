function envForm() {
    var usu = document.getElementById("usu").value;
    var pass = document.getElementById('pass').value;
    var res = xajax.request({xjxfun: 'vUsuario'}, 
        {mode: 'synchronous', parameters: [usu, pass]});
    //var res = xajax_vUsuario(usu, pass);
    console.log(res);
    if(res==false) alert("1Credenciales Erróneas !!!");
    return res;
}
