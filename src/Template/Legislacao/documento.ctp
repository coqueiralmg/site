<?= $this->Html->script('controller/legislacao.documento.js', ['block' => 'scriptBottom']) ?>
<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $legislacao->titulo ?></h2>
            <p class="lead">Data: <?= $this->Format->date($legislacao->data) ?> | Número: <?= $legislacao->numero ?></p>
        </div>

        <div class="wow fadeInDown">
            <div class="col-md-12">
                <?= $legislacao->descricao ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <a onclick="lerEdital()" href="<?= '../../' . $legislacao->arquivo ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>&nbsp;Download</a>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
