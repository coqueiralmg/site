<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $pergunta->questao ?></h2>
            <p class="lead">Categoria: <?=$pergunta->categoria->nome ?> </p>
        </div>

        <div class="wow fadeInDown">
            <div class="col-md-12">
                <?= $pergunta->resposta ?>
            </div>
        </div>

        <div id="malert">
            <span>
                Ainda não conseguiu entender? Entre em contato conosco, clicando no botão abaixo.
            </span>
            <div class="buttons">
                <a class="btn btn-primary" href="/licitacoes/antigas">Ver licitações antigas</a>
            </div>
        </div>
    </div>
    <!--/.container-->
</section>
