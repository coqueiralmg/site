<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Consulta de Manifestações</h2>
            <p class="lead">Verifique aqui o andamento de todas as manifestações que você fez à Prefeitura Municipal de Coqueiral.</p>
            <a class="btn btn-primary" href="/ouvidoria">Nova Manifestação</a>
            <a class="btn btn-primary" href="/ouvidoria/logoff">Sair</a>
        </div>

        <div>
            <?php if(count($manifestacoes) > 0): ?>
                <?php for($i = 0; $i < count($manifestacoes); $i++): ?>
                    <?php
                        $manifestacao = $manifestacoes[$i];
                    ?>
                    <?php if($i % 2 == 0): ?>
                        <div class="row">
                    <?php endif; ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $this->Format->zeroPad($manifestacao->id) . ' : ' . $manifestacao->assunto ?></h3>
                        <p>Data: <?= $this->Format->date($manifestacao->data, true) ?></p>
                        <p>Prioridade: <?= $manifestacao->prioridade->nome ?></p>
                        <p>Status: <?= $manifestacao->status->nome ?></p>
                        <?= $this->Html->link('Detalhes', ['controller' => 'ouvidoria', 'action' =>  'manifestacao', $manifestacao->id], ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php if($i % 2 != 0): ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php else: ?>
                <p>Nenhuma licitação disponível!</p>
            <?php endif; ?>
        </div>

        <?php if($movel):?>
            <?=$this->element('pagination_mobile', $opcao_paginacao) ?>
        <?php else:?>
            <?=$this->element('pagination', $opcao_paginacao) ?>
        <?php endif;?>
    </div>
    <!--/.container-->
</section>
<!--/about-us-->