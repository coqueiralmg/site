<?= $this->Html->script('controller/duvidas.lista.js', ['block' => 'scriptBottom']) ?>
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
                        "controller" => "licitacoes",
                        "action" => "busca"
                    ],
                    'idPrefix' => 'pesquisar-duvidas',
                    'type' => 'get',
                    'role' => 'form']);

                ?>

                <?= $this->Form->search('chave', ['id' => 'pesquisa', 'class' => 'form-control busca', 'placeholder' => 'Digite aqui para buscar']) ?>
                 <button type="submit" id="btn-pesquisar" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Buscar</button>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div>
            <?php if(count($licitacoes) > 0): ?>
                <?php for($i = 0; $i < count($licitacoes); $i++): ?>
                    <?php
                        $licitacao = $licitacoes[$i];
                    ?>
                    <?php if($i % 2 == 0): ?>
                        <div class="row">
                    <?php endif; ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $licitacao->titulo ?></h3>
                        <p>Início: <?= $this->Format->date($licitacao->dataInicio, true) ?></p>
                        <p>Término: <?= $this->Format->date($licitacao->dataTermino, true) ?></p>
                        <?= $this->Html->link('Detalhes', ['controller' => 'licitacoes', 'action' =>  'documento', $licitacao->id], ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php if($i % 2 != 0): ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php else: ?>
                <p>Nenhuma licitação disponível!</p>
            <?php endif; ?>
        </div>


    </div>
    <!--/.container-->
</section>
<!--/about-us-->
