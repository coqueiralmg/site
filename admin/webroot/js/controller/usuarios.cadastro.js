$(function () {
    $('#data_nascimento').datepicker({
        language: 'pt-BR'
    });

    $('#data_nascimento').mask('00/00/0000');

    $("#senha").val("");
    $("#confirma_senha").val("");

    $("input[type='password']").change(function () {
        $("#mudasenha").val("true");
    });

    $("input, select, #ativo, #verificar").change(function(){
        autosave();
    });

    if(hasCache('usuario', idUsuario)) {
        $("#cadastro_info").show('fade');
    }
});

function restaurar() {
    var data = getDataCache('usuario', idUsuario);

    if (data != null) {
        $("#nome").val(data.object.nome);
        $("#apelido").val(data.object.apelido);
        $("#data_nascimento").val(data.object.dataNascimento);
        $("#email").val(data.object.email);
        $("#usuario").val(data.object.usuario);
        $("#mudasenha").val(data.object.mudaSenha);
        $("#grupo").val(data.object.grupo);
        $("#ativo").prop("checked", data.object.ativo);
        $("#verificar").prop("checked", data.object.verificar);
    }

    notificarUsuario("Os dados em cache foram restaurados com sucesso!", "success")
}

function cancelarRestauracao() {
    removeCache();
    notificarUsuario("Você acabou de descartar dados que estão em cache.", "warning")
}

function autosave() {
    var data = {
        id: idUsuario,
        object: {
            id: idUsuario,
            nome: $("#nome").val(),
            apelido: $("#apelido").val(),
            dataNascimento: $("#data_nascimento").val(),
            email: $("#email").val(),
            usuario: $("#usuario").val(),
            mudaSenha: $("#mudasenha").val(),
            grupo: $("#grupo").val(),
            ativo: $("#ativo").is(':checked'),
            verificar: $("#verificar").is(':checked')
        }
    };

    cacheSave('usuario', data);
}

function removeCache() {
    removeData('usuario', idUsuario);
}

function validar() {
    var mensagem = "";

    if ($("#nome").val() === "") {
        mensagem += "<li> O nome do usuário é obrigatório.</li>";
        $("label[for='pessoa-nome']").css("color", "red");
    } else {
        $("label[for='pessoa-nome']").css("color", "#aaa");
    }

    if ($("#data_nascimento").val() === "") {
        mensagem += "<li> É obrigatório informa a data de nascimento.</li>";
        $("label[for='pessoa-datanascimento']").css("color", "red");
    } else {
        $("label[for='pessoa-datanascimento']").css("color", "#aaa");
    }

    if ($("#email").val() === "") {
        mensagem += "<li> O e-mail do usuário é obrigatório.</li>";
        $("label[for='email']").css("color", "red");
    } else {
        $("label[for='email']").css("color", "#aaa");
    }

    if ($("#usuario").val() === "") {
        mensagem += "<li> É obrigatório informar o login do usuário.</li>";
        $("label[for='usuario']").css("color", "red");
    } else {
        $("label[for='usuario']").css("color", "#aaa");
    }

    if ($("#mudasenha").val() == "true") {
        if ($("#senha").val() === "") {
            mensagem += "<li> É obrigatório informar a senha do usuário.</li>";
            $("label[for='senha']").css("color", "red");
        } else {
            $("label[for='senha']").css("color", "#aaa");
        }

        if ($("#confirma_senha").val() === "") {
            mensagem += "<li> É obrigatório informar a confirmação da senha.</li>";
            $("label[for='confirma-senha']").css("color", "red");
        } else {
            $("label[for='confirma-senha']").css("color", "#aaa");
        }
    }

    if ($("#grupo").val() === "") {
        mensagem += "<li> É obrigatório informar o grupo de usuário.</li>";
        $("label[for='grupo']").css("color", "red");
    } else {
        $("label[for='grupo']").css("color", "red");
    }

    if ($("#mudasenha").val() == "true") {
        if ($("#senha").val() != "" && $("#confirma_senha").val() != "") {
            if ($("#senha").val() !== $("#confirma_senha").val()) {
                mensagem += "<li>A senha e a confirmação estão diferentes.</li>";
                $("label[for='senha']").css("color", "red");
                $("label[for='confirma-senha']").css("color", "red");
            } else {
                $("label[for='senha']").css("color", "#aaa");
                $("label[for='confirma-senha']").css("color", "#aaa");
            }
        }
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
