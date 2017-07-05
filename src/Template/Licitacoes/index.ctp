<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Licitações</h2>
            <p class="lead">Editais e outras informações sobre processos licitatórios do município.</p>
            <p>Você pode ver mais informações sobre licitações em vigor ou processos antigos, <a href="https://e-gov.betha.com.br/transparencia/01031-002/con_licitacoes.faces?mun=_fV0IsqgT0A_livlamqEHrXhxsPXsJ0O" target="_blank"> clicando aqui</a>.</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->Form->create("Licitacao", [
                    "url" => [
                        "controller" => "licitacoes",
                        "action" => "index"
                    ],
                    'idPrefix' => 'pesquisar-licitacao',
                    'type' => 'get',
                    'role' => 'form']);
                    
                ?>

                <?= $this->Form->search('chave', ['class' => 'form-control busca', 'placeholder' => 'Digite aqui para buscar']) ?>
                 <button type="submit" id="btn-pesquisar" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Buscar</button>

                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <div class="row">
            <?php if(count($licitacoes) > 0): ?>
                <?php foreach($licitacoes as $licitacao): ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $licitacao->titulo ?></h3>
                        <p>Início: <?= $this->Format->date($licitacao->dataInicio, true) ?></p>
                        <p>Término: <?= $this->Format->date($licitacao->dataTermino, true) ?></p>
                        <?= $this->Html->link('Veja mais', ['controller' => 'licitacoes', 'action' =>  'licitacao', $licitacao->slug . '-' . $licitacao->id], ['class' => 'btn btn-success']) ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma licitação disponível!</p>
            <?php endif; ?>
        </div>

        <?=$this->element('pagination', $opcao_paginacao) ?>
    </div>
    <!--/.container-->
</section>
<!--/about-us-->