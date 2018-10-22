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
            <div id="tabs" style="display: none">
                <ul>
                    <?php if(count($destaques) > 0): ?>
                        <li><a href="#destaques">Destaques</a></li>
                    <?php endif;?>
                    <li><a href="#tipo">Tipo</a></li>
                    <li><a href="#ano">Ano</a></li>
                </ul>
                <?php if(count($destaques) > 0): ?>
                   <div id="destaques">
                        <h5>Leis, decretos e outros documentos em destaque</h5>
                        <?php if(count($destaques) > 0): ?>
                            <div class="row">
                                <?php for($i = 0; $i < count($destaques); $i++): ?>
                                    <?php
                                        $publicacao = $destaques[$i];
                                    ?>
                                    <div class="item col-md-12 col-lg-6">
                                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $publicacao->titulo ?></h3>
                                        <p><?= $publicacao->resumo ?></p>
                                        <?= $this->Html->link('Detalhes', ['controller' => 'legislacao', 'action' =>  'documento', $publicacao->id], ['class' => 'btn btn-success']) ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        <?php else: ?>
                            <p>Nenhum destaque disponível!</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div id="tipo">
                    <h5>Faça busca de legislação municipal por tipo</h5>
                    <?php foreach($tipos_legislacao as $tipo_legislacao): ?>
                        <?= $this->Html->link($tipo_legislacao->nome, ['controller' => 'legislacao', 'action' =>  'tipo', $tipo_legislacao->id, '?' => $data], ['class' => 'btn btn-success', 'style' => 'margin: 10px 5px']) ?>
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
                        "action" => "index"
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
                if(isset($data['tipo']))
                {
                    $tipo = $data['tipo'];
                    echo $this->Form->hidden('tipo', ['value' => $tipo]);
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
