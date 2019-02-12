<?= $this->Html->script('controller/legislacao.lista.js', ['block' => 'scriptBottom']) ?>
<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Dúvidas e Perguntas</h2>
            <p class="lead">Dúvidas e perguntas pertinentes, relativos a qualquer assunto sobre prefeitura e município de Coqueiral.</p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->Form->create("Duvidas", [
                    "url" => [
                        "controller" => "duvidas",
                        "action" => "busca"
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
            <?php if(count($perguntas) > 0): ?>
                <?php for($i = 0; $i < count($perguntas); $i++): ?>
                    <?php
                        $duvida = $perguntas[$i];
                    ?>
                    <?php if($i % 2 == 0): ?>

                        <div class="row">
                    <?php endif; ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $duvida->questao ?></h3>
                        <p><b>Categoria:</b> <?= $duvida->categoria->nome ?></p>
                        <?= $this->Html->link('Detalhes', ['controller' => 'duvidas', 'action' =>  'duvida', $duvida->slug . '-' . $duvida->id], ['class' => 'btn btn-success']) ?>
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
