<?= $this->Html->script('controller/legislacao.lista.js', ['block' => 'scriptBottom']) ?>
<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Legislação Municipal</h2>
            <p class="lead">Legislação do Município de Coqueiral</p>
        </div>
        <?php if($inicial): ?>
            <div id="loader" class="center">
                <?= $this->Html->image('loader.gif', ['alt' => 'Aguarde! Carregando...']) ?>
            </div>
            <div class="container">
                <div id="tabs" style="display: none">
                    <ul>
                        <li><a href="#destaques">Destaques</a></li>
                        <li><a href="#tipo">Tipo</a></li>
                        <li><a href="#assuntos">Assuntos</a></li>
                        <li><a href="#ano">Ano</a></li>
                    </ul>
                    <div id="destaques">
                        <h5>Leis, decretos e outros documentos em destaque</h5>
                        <?php if(count($destaques) > 0): ?>
                            <?php for($i = 0; $i < count($destaques); $i++): ?>
                                <?php if($i % 2 == 0): ?>
                                    <div class="row">
                                <?php endif; ?>
                                <?php
                                    $publicacao = $destaques[$i];
                                ?>
                                <?=$this->element('Itens/item_legislacao', ['publicacao' => $publicacao]) ?>
                                <?php if($i % 2 != 0 || $i == (count($destaques) - 1)): ?>
                                    </div>
                                <?php endif; ?>
                            <?php endfor; ?>
                        <?php else: ?>
                            <p>Nenhum destaque disponível!</p>
                        <?php endif; ?>
                    </div>
                    <div id="tipo">
                        <h5>Faça busca de legislação municipal por tipo</h5>
                        <?php foreach($tipos_legislacao as $tipo_legislacao): ?>
                            <?= $this->Html->link($tipo_legislacao->nome, ['controller' => 'legislacao', 'action' =>  'tipo', $tipo_legislacao->id], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                        <?php endforeach; ?>

                    </div>
                    <div id="assuntos">
                        <h5>Faça a busca de legislação municipal por assunto.</h5>
                        <?php foreach($assuntos as $assunto): ?>
                            <?= $this->Html->link($assunto->descricao, ['controller' => 'legislacao', 'action' =>  'assunto', $assunto->id], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                        <?php endforeach; ?>
                    </div>
                    <div id="ano">
                        <h5>Faça a busca de legislação municipal por ano.</h5>
                        <?php foreach($anos as $ano): ?>
                            <?= $this->Html->link($ano->ano, ['controller' => 'legislacao', 'action' =>  'ano', $ano->ano], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr clear="all"/>
        <?php endif; ?>
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
                    <?=$this->element('Itens/item_legislacao', ['publicacao' => $publicacao]) ?>
                    <?php if($i % 2 != 0): ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php else: ?>
                <p>Nenhuma publicação disponível!</p>
            <?php endif; ?>
        </div>

        <?=$this->element('pagination') ?>
    </div>
    <!--/.container-->
</section>
<!--/about-us-->
