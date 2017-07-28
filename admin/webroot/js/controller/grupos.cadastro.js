function marcarTodos() {
    $("#funcoes input").each(function () {
        $(this).prop("checked", true);
    });
}

function desmarcarTodos() {
    $("#funcoes input").each(function () {
        $(this).prop("checked", false);
    });
}