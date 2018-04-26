<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Página em Construção</h2>
            <p class="lead">Site em construção. Aguarde.</p>
        </div>

        <div class="row text-center">
            <?= $this->Html->image('em_construcao.png', ['style' => 'width: 70%'])?>
            <br/><br/>
            <?php if($mensagem != ""):?>
                <h4><?=$mensagem?></h4>
                <?php if($link != null): ?>
                    <p><?=$this->Html->link($detalhes, $link->url, ['target' => isset($link->target) ? $link->target : '_self'])?></p>
                <?php else: ?>
                    <p><?=$detalhes?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <!--/.container-->
</section>
<!--/about-us-->
