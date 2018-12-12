<?= $this->Html->script('controller/licitacoes.licitacao.js', ['block' => 'scriptBottom']) ?>
<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $licitacao->titulo ?></h2>
            <p class="lead">Início: <?= $this->Format->date($licitacao->dataInicio, true) ?> | Término: <?= $this->Format->date($licitacao->dataTermino, true) ?></p>
        </div>

        <div class="wow fadeInDown">
            <div class="col-md-12">
                <?= $licitacao->descricao ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <a onclick="lerEdital()" href="<?= '../../' . $licitacao->edital ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>&nbsp;Download</a>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
