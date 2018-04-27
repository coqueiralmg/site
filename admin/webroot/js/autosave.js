var suporte;

$(function () {
    suporte = (checkLocalStorage()) ? true : false;
});

function checkLocalStorage() {
    try {
      return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
      return false;
    }
}

function cacheSave(controller, data) {
    if (!suporte) return false;
    var colecao, salvo;
    var usuario = getCookie('Client.User');
    var chave = "datacache:" + controller + "@" + usuario;

    if(data.metadata == null)
    {
        data.metadata = {
            created: null,
            updated: null,
            author: usuario
        };
    }

    if(localStorage.getItem(chave)) {
        var atualizado = false;
        var pivot = data.id;
        salvo = localStorage.getItem(chave);
        colecao = JSON.parse(salvo);

        for(var i = 0; i < colecao.length; i++) {
            var item = colecao[i];

            if(item.id == pivot) {
                data.metadata.created = item.metadata.created;
                data.metadata.updated = new Date();
                colecao.splice(i, 1, data);
                atualizado = true;
                break;
            }
        }

        if(!atualizado) {
            data.metadata.created = new Date();
            colecao.push(data);
        }

        colecao.sort(function(a, b) {
            return a.id-b.id
        });

        salvo = JSON.stringify(colecao);
        localStorage.setItem(chave, salvo);
    } else {
        colecao = new Array();

        data.metadata.created = new Date();
        colecao.push(data);
        salvo = JSON.stringify(colecao);
        localStorage.setItem(chave, salvo);
    }
}
