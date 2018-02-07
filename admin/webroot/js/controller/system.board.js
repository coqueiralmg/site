$(function () {
    inicializarGraficoManifestos();
    obterDadosTiposManifestos();
});

function inicializarGraficoManifestos(){
    var ctx = document.getElementById("graficoEvolucao").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["30/01", "31/01", "01/02", "02/02", "03/02", "04/02", "05/02"],
            datasets: [{
                label: 'Manifestos gerados',
                data: [21, 12, 19, 3, 5, 2, 15],
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

function obterDadosTiposManifestos()
{
    var data = null;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/admin/manifestacao/pietipo.json', true);

    xhr.onload = function (e) {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
             var dados = xhr.response.data;
             carregarGraficoTipoManifestos(dados);
            
          } else {
            escreverMensagemGrafico("graficoTipo", xhr.statusText);
          }
        }
    };

    xhr.responseType = "json";
    xhr.send(null);
}

function escreverMensagemGrafico(htmlId, message) {
    var canvas = document.getElementById(htmlId);
    var ctx = canvas.getContext("2d");
    ctx.font = "30px Roboto";
    ctx.fillText(message,10,50);
}