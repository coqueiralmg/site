var suporte;

$(function () {
    if (checkLocalStorage()) {
        suporte = true;
    } else {
        suporte = false;
    }
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
    var chave = "datacache@" + controller;

    if(localStorage.getItem(chave)) {
        var atualizado = false;
        var pivot = data.id;
        salvo = localStorage.getItem(chave);
        colecao = JSON.parse(salvo);

        for(var i = 0; i < colecao.length; i++) {
            var item = colecao[i];

            if(item.id == pivot) {
                colecao.splice(i, 1, data);
                atualizado = true;
                break;
            }
        }

        if(!atualizado) {
            colecao.push(data);
        }

        colecao.sort(function(a, b) {

        });

    } else {
        colecao = new Array();

        colecao.push(data);
        salvo = JSON.stringify(data);

        localStorage.setItem(chave, salvo);
    }
}
