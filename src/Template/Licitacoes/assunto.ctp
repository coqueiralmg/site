<?= $this->Html->script('controller/licitacoes.lista.js', ['block' => 'scriptBottom']) ?>
<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Licitações</h2>
            <p class="lead">Editais e outras informações sobre processos licitatórios do município.</p>
        </div>
        <?php if($inicial): ?>
            <div id="loader" class="center">
                <?= $this->Html->image('loader.gif', ['alt' => 'Aguarde! Carregando...']) ?>
            </div>
            <div class="container">
                <div id="tabs" style="display: none">
                    <ul>
                        <?php if(count($destaques) > 0): ?>
                            <li><a href="#destaques">Destaques</a></li>
                        <?php endif;?>
                        <li><a href="#populares">Mais vistas</a></li>
                        <li><a href="#modalidades">Modalidades</a></li>
                        <li><a href="#status">Status</a></li>
                        <li><a href="#ano">Ano</a></li>
                    </ul>
                    <?php if(count($destaques) > 0): ?>
                        <div id="destaques">
                            <h5>Licitações em Destaque</h5>
                            <div class="row">
                                <?php for($i = 0; $i < count($destaques); $i++): ?>
                                    <?php
                                        $licitacao = $destaques[$i];
                                    ?>
                                    <div class="item col-md-12 col-lg-6">
                                        <h3 class="media-heading" style="text-transform: uppercase;">Processo: <?= $this->Format->zeroPad($licitacao->numprocesso, 3) ?>/<?= $licitacao->ano ?> - <?= $licitacao->titulo ?></h3>
                                        <span style="font-style: italic"><?= $licitacao->modalidade->nome ?></span> | <span style="font-weight: bold"><?= $licitacao->status->nome ?></span>
                                        <?php if($licitacao->modalidade->chave == 'PP' ||
                                                $licitacao->modalidade->chave == 'TP'):?>
                                            <p>Data da Sessão: <?= $this->Format->date($licitacao->dataSessao, true) ?></p>
                                        <?php elseif($licitacao->modalidade->chave == 'DI' ||
                                                $licitacao->modalidade->chave == 'IN'):?>
                                            <p>Data da Publicação: <?= $this->Format->date($licitacao->dataPublicacao, true) ?></p>
                                        <?php else: ?>
                                            <p>Período de <?= $this->Format->date($licitacao->dataPublicacao, true) ?> até <?= $this->Format->date($licitacao->dataFim, true) ?></p>
                                        <?php endif;?>
                                        <?= $this->Html->link('Detalhes', ['controller' => 'licitacoes', 'action' =>  'licitacao', $licitacao->id], ['class' => 'btn btn-success']) ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div id="populares">
                        <h5>Licitações mais vistas</h5>
                        <?php if(count($populares) > 0): ?>
                            <div class="row">
                                <?php for($i = 0; $i < count($populares); $i++): ?>
                                    <?php
                                        $licitacao = $populares[$i];
                                    ?>
                                    <div class="item col-md-12 col-lg-6">
                                        <h3 class="media-heading" style="text-transform: uppercase;">Processo: <?= $this->Format->zeroPad($licitacao->numprocesso, 3) ?>/<?= $licitacao->ano ?> - <?= $licitacao->titulo ?></h3>
                                        <span style="font-style: italic"><?= $licitacao->modalidade->nome ?></span> | <span style="font-weight: bold"><?= $licitacao->status->nome ?></span>
                                        <?php if($licitacao->modalidade->chave == 'PP' ||
                                                $licitacao->modalidade->chave == 'TP'):?>
                                            <p>Data da Sessão: <?= $this->Format->date($licitacao->dataSessao, true) ?></p>
                                        <?php elseif($licitacao->modalidade->chave == 'DI' ||
                                                $licitacao->modalidade->chave == 'IN'):?>
                                            <p>Data da Publicação: <?= $this->Format->date($licitacao->dataPublicacao, true) ?></p>
                                        <?php else: ?>
                                            <p>Período de <?= $this->Format->date($licitacao->dataPublicacao, true) ?> até <?= $this->Format->date($licitacao->dataFim, true) ?></p>
                                        <?php endif;?>
                                        <?= $this->Html->link('Detalhes', ['controller' => 'licitacoes', 'action' =>  'licitacao', $licitacao->id], ['class' => 'btn btn-success']) ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div id="modalidades">
                        <h5>Faça busca de licitações por modalidade</h5>
                        <?php foreach($modalidades as $modalidade): ?>
                            <?= $this->Html->link($modalidade->nome, ['controller' => 'licitacoes', 'action' =>  'modalidade', $modalidade->chave], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                        <?php endforeach; ?>

                    </div>
                    <div id="status">
                        <h5>Faça a busca de licitações por status</h5>
                        <?php foreach($status as $item): ?>
                            <?= $this->Html->link($item->nome, ['controller' => 'licitacoes', 'action' =>  'status', $item->id], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                        <?php endforeach; ?>
                    </div>
                    <div id="ano">
                        <h5>Faça a busca de legislação municipal por ano.</h5>
                        <?php foreach($anos as $ano): ?>
                            <?= $this->Html->link($ano->ano, ['controller' => 'licitacoes', 'action' =>  'ano', $ano->ano], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr clear="all"/>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->Form->create("Licitacao", [
                    "url" => [
                        "controller" => "licitacoes",
                        "action" => "assunto",
                        $assunto
                    ],
                    'idPrefix' => 'pesquisar-licitacao',
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
                        <h3 class="media-heading" style="text-transform: uppercase;">Processo: <?= $this->Format->zeroPad($licitacao->numprocesso, 3) ?>/<?= $licitacao->ano ?> - <?= $licitacao->titulo ?></h3>
                        <span style="font-style: italic"><?= $licitacao->modalidade->nome ?></span> | <span style="font-weight: bold"><?= $licitacao->status->nome ?></span>
                        <?php if($licitacao->modalidade->chave == 'PP' ||
                                 $licitacao->modalidade->chave == 'TP'):?>
                            <p>Data da Sessão: <?= $this->Format->date($licitacao->dataSessao, true) ?></p>
                        <?php elseif($licitacao->modalidade->chave == 'DI' ||
                                 $licitacao->modalidade->chave == 'IN'):?>
                            <p>Data da Publicação: <?= $this->Format->date($licitacao->dataPublicacao, true) ?></p>
                        <?php else: ?>
                            <p>Período de <?= $this->Format->date($licitacao->dataPublicacao, true) ?> até <?= $this->Format->date($licitacao->dataFim, true) ?></p>
                        <?php endif;?>
                        <?= $this->Html->link('Detalhes', ['controller' => 'licitacoes', 'action' =>  'licitacao', $licitacao->slug . '-' . $licitacao->id], ['class' => 'btn btn-success']) ?>
                    </div>
                    <?php if($i % 2 != 0): ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
                <?php if($this->Paginator->current() == $this->Paginator->total()): ?>
                    <div id="malert">
                        <span>
                            Aqui encerra a lista de licitações, de acordo com o resultado da busca informado. Clique no botão abaixo para ver as licitações mais antigas.
                        </span>
                        <div class="buttons">
                            <a class="btn btn-primary" href="/licitacoes/antigas">Ver licitações antigas</a>
                        </div>
                    </div>
                <?php endif;?>
            <?php else: ?>
                <p>Não foi possível encontrar licitações de acordo com o resultado de busca encontrado. Você pode fazer consulta de processos antigos <?=$this->Html->link('clicando aqui', ['controller' => 'licitacoes', 'action' =>  'antigas'], ['style' => 'font-weight: bold; text-decoration: underline;'])?>.</p>
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
