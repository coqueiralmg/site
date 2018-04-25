<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Relatórios de Diárias de Viagens</h2>
        </div>

        <div>
            <?php if(count($diarias) > 0): ?>
                <?php for($i = 0; $i < count($diarias); $i++): ?>
                    <?php
                        $diaria = $diarias[$i];
                    ?>
                    <?php if($i % 2 == 0): ?>
                        <div class="row">
                    <?php endif; ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;">Beneficiário: <?= $diaria->beneficiario ?></h3>
                        <p>Destino: <?= $diaria->destino ?></p>
                        <p>Período: <?= $this->Format->date($diaria->periodoInicio) ?> à <?= $this->Format->date($diaria->periodoFim)  ?></p>
                        <p>Objetivo: <?= $diaria->objetivo ?></p>
                        <?= $this->Html->link('Detalhes', ['controller' => 'legislacao', 'action' =>  'documento', $diaria->id], ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php if($i % 2 != 0): ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php else: ?>
                <p>Nenhuma publicação disponível!</p>
            <?php endif; ?>
        </div>
        <?php if($movel):?>
            <?=$this->element('pagination_mobile') ?>
        <?php else:?>
            <?=$this->element('pagination') ?>
        <?php endif;?>

    </div>
    <!--/.container-->
</section>
<!--/about-us-->
