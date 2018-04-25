<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2>Relatório de Diária</h2>
            <p class="lead">Beneficiário: <?= $diaria->beneficiario ?></p>
        </div>

        <div class="wow fadeInDown">
            <div class="col-md-12">
                <p><b>Beneficiário: </b><?= $diaria->beneficiario ?></p>
                <p><b>Destino: </b><?= $diaria->destino ?></p>
                <p><b>Data de Autorização: </b><?= $this->Format->date($diaria->dataAutorizacao) ?></p>
                <p><b>Período: </b><?= $this->Format->date($diaria->periodoInicio) ?> à <?= $this->Format->date($diaria->periodoFim) ?></p>
                <p><b>Valor: </b>R$ <?= $this->Format->precision($diaria->valor, 2) ?></p>
                <hr/>
                <h5>Objetivo</h5>
                <?= nl2br($diaria->objetivo) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <a href="<?= '../../' . $diaria->documento ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>&nbsp;Download</a>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
