<?= $this->Html->script('controller/legislacao.lista.js', ['block' => 'scriptBottom']) ?>
<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Legislação Municipal</h2>
            <p class="lead">Legislação do Município de Coqueiral do tipo <?=$tipo_legislacao->nome?></p>
        </div>
        <?php if($inicial): ?>
            <div id="loader" class="center">
                <?= $this->Html->image('loader.gif', ['alt' => 'Aguarde! Carregando...']) ?>
            </div>
            <div id="tabs" style="display: none">
                <ul>
                    <?php if(count($destaques) > 0): ?>
                        <li><a href="#destaques">Destaques</a></li>
                    <?php endif;?>
                    <li><a href="#assuntos">Assuntos</a></li>
                    <li><a href="#ano">Ano</a></li>
                </ul>
                <?php if(count($destaques) > 0): ?>
                    <div id="destaques">
                        <h5>Leis, decretos e outros documentos em destaque</h5>
                        <?php for($i = 0; $i < count($destaques); $i++): ?>
                            <?php
                                $publicacao = $destaques[$i];
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
                    </div>
                <?php endif; ?>
                <div id="assuntos">
                    <h5>Faça a busca de legislação municipal por assunto.</h5>
                    <?php foreach($assuntos as $assunto): ?>
                        <?= $this->Html->link($assunto->descricao, ['controller' => 'legislacao', 'action' =>  'assunto', $assunto->id, '?' => $data], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                    <?php endforeach; ?>
                </div>
                <div id="ano">
                    <h5>Faça a busca de legislação municipal por ano.</h5>
                    <?php foreach($anos as $ano): ?>
                        <?= $this->Html->link($ano->ano, ['controller' => 'legislacao', 'action' =>  'ano', $ano->ano, '?' => $data], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
                    <?php endforeach; ?>
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
                        "action" => "tipo",
                        $tipo_legislacao->id
                    ],
                    'idPrefix' => 'pesquisar-legislacao',
                    'type' => 'get',
                    'role' => 'form']);
                ?>
                <?php
                if(isset($data['ano']))
                {
                    $ano = $data['ano'];
                    echo $this->Form->hidden('ano', ['value' => $ano]);
                }
                if(isset($data['assunto']))
                {
                    $assunto = $data['assunto'];
                    echo $this->Form->hidden('assunto', ['value' => $assunto]);
                }
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
