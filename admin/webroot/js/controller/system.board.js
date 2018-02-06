$(function () {
    inicializarGraficoManifestos();
    inicializarGraficoTipoManifestos();
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

function inicializarGraficoTipoManifestos(){
    var ctx = document.getElementById("graficoTipo").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Novo", "Aceito", "Recusado", "Atendido", "Em Atividade", "Concluído"],
            datasets: [{
                label: 'Chamados criados',
                data: [21, 12, 19, 3, 0, 15],
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