$(function () {
    $('#documento').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/admin/legislacao/list.json',
                dataType: 'json',
                data: {
                    chave: request.term
                },
                success: function (data) {
                    response(data.resultado);
                }
            });
        },
        select: function (event, ui) {

        },
        minLength: 3,
    }).autocomplete("instance")._renderItem = function (ul, item) {
        return $("<li>")
            .append('<span>' + item.titulo.trim() + '</span>')
            .appendTo(ul);
    };
});
