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

function getCacheSaveOption(controller) {
    if (!suporte) return false;
    var chave = "optioncache@" + controller;
    var salvo = sessionStorage.getItem(chave);
    var opcoes = JSON.parse(salvo);

    return opcoes;
}

function setCacheSaveOption(controller, options) {
    if (!suporte) return false;
    var chave = "optioncache@" + controller;
    var salvo = JSON.stringify(options);
    sessionStorage.setItem(chave, salvo);
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
            return a.id-b.id
        });

        salvo = JSON.stringify(colecao);
        localStorage.setItem(chave, salvo);
    } else {
        colecao = new Array();

        colecao.push(data);
        salvo = JSON.stringify(colecao);
        localStorage.setItem(chave, salvo);
    }
}
