var modificado = false;

$(function () {
    $('#ip').mask('099.099.099.099');

    $("input, textarea").change(function(){
        autosave();
        modificado = true;
    });

    if(hasCache('firewall', idRegistro)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('firewall', idRegistro);

    if (data != null) {
        $("#ip").val(data.object.ip);
        $("#motivo").val(data.object.motivo);
        $("#lista_branca").prop("checked", data.object.listaBranca);
        $("#ativo").prop("checked", data.object.ativo);
        $("#site").prop("checked", data.object.site);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idRegistro,
        object: {
            id: idRegistro,
            ip: $("#ip").val(),
            motivo: $("#motivo").val(),
            listaBranca: $("#lista_branca").is(':checked'),
            ativo: $("#ativo").is(':checked'),
            site: $("#site").is(':checked')
        }
    };

    cacheSave('firewall', data);
}

function removeCache() {
    removeData('firewall', idRegistro);
    modificado = false;
}

function validar() {
    var mensagem = "";

    if ($("#ip").val() === "") {
        mensagem += "<li> O endereço de IP é obrigatório.</li>";
        $("label[for='ip']").css("color", "red");
    } else {
        $("label[for='ip']").css("color", "#aaa");
    }

    if ($("#motivo").val() === "") {
        mensagem += "<li> O motivo do cadastro é obrigatório.</li>";
        $("label[for='motivo']").css("color", "red");
    } else {
        $("label[for='motivo']").css("color", "#aaa");
    }

    if (mensagem == "") {
        removeCache();
        return true;
    } else {
        $("#cadastro_erro").show('shake');
        $("#details").html("<ol>" + mensagem + "</ol>");
        return false;
    }
}
