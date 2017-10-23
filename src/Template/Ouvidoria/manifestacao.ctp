<section id="about-us">
    <div class="container">
        
        <div class="center wow fadeInDown">
            <h2><?= $this->Format->zeroPad($manifestacao->id) . ' : ' . $manifestacao->assunto ?></h2>
            <p class="lead">Data: <?= $this->Format->date($publicacao->data) ?> | Número: <?= $publicacao->numero ?></p>
        </div>

        <div class="wow fadeInDown">
            <div class="col-md-12">
                <?= $publicacao->descricao ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10">
            </div>
            <div class="col-md-2">
                <a onclick="lerEdital()" href="<?= '../../' . $publicacao->arquivo ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i>&nbsp;Download</a>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>