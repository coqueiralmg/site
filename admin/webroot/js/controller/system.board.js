$(function () {
    obterDadosEvolucaoManifestos()
    obterDadosTiposManifestos();
});

function carregarGraficoManifestos(dados, datas){
    var ctx = document.getElementById("graficoEvolucao").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: datas,
            datasets: [{
                label: 'Manifestações geradas',
                data: dados,
                borderColor: "white",
                borderWidth: 3
            }]
        },
        options: {
            legend: {
                labels: {
                    fontColor: "white"
                }
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "white"
                    }
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "white",
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}

function carregarGraficoTipoManifestos(dados){
    var ctx = document.getElementById("graficoTipo").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Novo", "Aceito", "Recusado", "Atendido", "Em Atividade", "Concluído"],
            datasets: [{
                label: 'Chamados criados',
                data: dados,
                backgroundColor: [
                    "khaki",
                    "navy",
                    "red",
                    "moccasin",
                    "pink",
                    "green"
                ],
                borderWidth: 0
            }]
        },
        options: {
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
                    bottom: 10
                }
            },
            legend: {
                position: "right",
                labels: {
                    fontColor: "white"
                }
            }
        }
    });
}

function obterDadosTiposManifestos() {
    var data = null;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/admin/manifestacao/pietipo.json', true);

    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            if(xhr.response.sucesso){
                var dados = xhr.response.data;
                carregarGraficoTipoManifestos(dados);
            } else {
                escreverMensagemGrafico("graficoTipo", xhr.response.mensagem);
            }
          } else {
            escreverMensagemGrafico("graficoTipo", xhr.statusText);
          }
        }
    };

    xhr.responseType = "json";
    xhr.send(null);
}

function obterDadosEvolucaoManifestos() {
    var data = null;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/admin/manifestacao/evolution.json', true);

    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            if(xhr.response.sucesso){
                var dados = xhr.response.data;
                carregarGraficoManifestos(dados, obterDatasAmostragemEvolucao())
            } else {
                escreverMensagemGrafico("graficoEvolucao", xhr.response.mensagem);
            }
          } else {
            escreverMensagemGrafico("graficoEvolucao", xhr.statusText);
          }
        }
    };

    xhr.responseType = "json";
    xhr.send(null);
}

function obterDatasAmostragemEvolucao() {
    
    var a = Array();
    var b = Array();
    var i = 1;
    
    while (i <= 7 ) {
        var d = new Date();
        var j = d.getDate();
        
        d.setDate(j - i);
        a.push(d);

        i++;
    }

    a.forEach(function(k, n, c){
        var s = (k.getDate() < 10 ? "0" + k.getDate() : k.getDate()) + "/" + (k.getMonth() < 9 ? "0" + eval(k.getMonth() + 1) : eval(k.getMonth() + 1));
        b.push(s);
    });

    return b.reverse();
}

function escreverMensagemGrafico(htmlId, message) {
    var canvas = document.getElementById(htmlId);
    var ctx = canvas.getContext("2d");
    ctx.font = "12px Roboto";
    ctx.fillText(message,10,20);
}