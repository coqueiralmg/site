function validar() {
    if ($("#usuario").val() == "") {
        $("#erro").html("É obrigatório informar nome do usuário ou e-mail.");
        return false;
    }

    if ($("#senha").val() == "") {
        $("#erro").html("É obrigatório informar a senha de acesso ao sistema.");
        return false;
    }

    setCookie("Client.User", $("#usuario").val());

    return true;
}

function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (6*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires;
}
