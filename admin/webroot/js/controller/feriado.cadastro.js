var modificado = false;

$(function () {
    $('#data').datepicker({
        language: 'pt-BR'
    });

    $('#data').mask('00/00/0000');

    $("input, select").change(function(){
        autosave();
        modificado = true;
    });

    if(hasCache('feriado', idFeriado)) {
        $("#cadastro_info").show('fade');
    }

    $(window).bind("beforeunload", function() {
        if(modificado){
            return "É possível que as alterações não estejam salvas.";
        }
    });
});

function restaurar() {
    var data = getDataCache('feriado', idFeriado);

    if (data != null) {
        $("#data").val(data.object.data);
        $("#descricao").val(data.object.descricao);
        $("#nivel").val(data.object.nivel);
        $("#facultativo").prop("checked", data.object.facultativo);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idFeriado,
        object: {
            id: idFeriado,
            data: $("#data").val(),
            descricao: $("#descricao").val(),
            nivel: $("#nivel").val(),
            facultativo: $("#facultativo").is(':checked'),
        }
    };

    cacheSave('feriado', data);
}

function removeCache() {
    removeData('feriado', idFeriado);
    modificado = false;
}

function validar() {
    var mensagem = "";

    if ($("#data").val() === "") {
        mensagem += "<li> É obrigatório informar a data de feriado.</li>";
        $("label[for='data']").css("color", "red");
    } else {
        $("label[for='data']").css("color", "#aaa");
    }

    if ($("#descricao").val() === "") {
        mensagem += "<li> É obrigatório informar a descrição do feriado.</li>";
        $("label[for='descricao']").css("color", "red");
    } else {
        $("label[for='descricao']").css("color", "#aaa");
    }

    if ($("#nivel").val() === "") {
        mensagem += "<li> É obrigatório informar o tipo do feriado.</li>";
        $("label[for='nivel']").css("color", "red");
    } else {
        $("label[for='nivel']").css("color", "#aaa");
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
