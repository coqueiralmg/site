<?= $this->Html->script('controller/legislacao.lista.js', ['block' => 'scriptBottom']) ?>
<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Legislação Municipal</h2>
            <p class="lead">Legislação do Município de Coqueiral</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->Form->create("Legislacao", [
                    "url" => [
                        "controller" => "legislacao",
                        "action" => "index"
                    ],
                    'idPrefix' => 'pesquisar-legislacao',
                    'type' => 'get',
                    'role' => 'form']);
                ?>

                <?= $this->Form->search('chave', ['id' => 'pesquisa', 'class' => 'form-control busca', 'placeholder' => 'Digite aqui para buscar']) ?>
                 <button type="submit" id="btn-pesquisar" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Buscar</button>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div>
            <?php if(count($legislacao) > 0): ?>
                <?php for($i = 0; $i < count($legislacao); $i++): ?>
                    <?php
                        $publicacao = $legislacao[$i];
                    ?>
                    <?php if($i % 2 == 0): ?>
                        <div class="row">
                    <?php endif; ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $publicacao->titulo ?></h3>
                        <p><?= $publicacao->resumo ?></p>
                        <?= $this->Html->link('Detalhes', ['controller' => 'legislacao', 'action' =>  'documento', $publicacao->id], ['class' => 'btn btn-success']) ?>
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
