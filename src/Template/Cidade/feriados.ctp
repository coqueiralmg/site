<section id="about-us">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Feriados</h2>
            <p class="lead">Feriados Nacionais, Estaduais e Municipais no Município de Coqueiral, para o ano de <?=$ano?></p>
        </div>

        <div class="wow fadeInDown">
            <table class="table table-striped">
                <thead class="text-primary">
                    <tr>
                        <th>Data</th>
                        <th>Dia de Semana</th>
                        <th>Feriado</th>
                        <th>Nível</th>
                        <th>Ponto Facultativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feriados as $feriado): ?>
                        <tr>
                            <td><?=$this->Format->date($feriado->data)?></td>
                            <td><?=$this->Format->dayWeek($feriado->data)?></td>
                            <td><?=$feriado->descricao?></td>
                            <td><?=$feriado->tipo?></td>
                            <td><?=$feriado->opcional?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox"></div>

            </div>
        </div>

    </div>
    <!--/.container-->
</section>
