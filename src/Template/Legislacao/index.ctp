<?= $this->Html->script('controller/legislacao.lista.js', ['block' => 'scriptBottom']) ?>
<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Legislação Municipal</h2>
            <p class="lead">Legislação do Município de Coqueiral</p>
        </div>
        <div id="loader" class="center">
            <?= $this->Html->image('loader.gif', ['alt' => 'Aguarde! Carregando...']) ?>
        </div>
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
                <?php else: ?>
                    <p>Nenhum destaque disponível!</p>
                <?php endif; ?>
            </div>
            <div id="tipo">
                <h5>Faça busca de legislação municipal por tipo</h5>
                <?php foreach($tipos_legislacao as $tipo_legislacao): ?>
                    <?= $this->Html->link($tipo_legislacao->nome, ['controller' => 'legislacao', 'action' =>  'tipo', $tipo_legislacao->id], ['class' => 'btn btn-success']) ?>
                <?php endforeach; ?>

            </div>
            <div id="assuntos">
                <h5>Faça a busca de legislação municipal por assunto.</h5>
                <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
            </div>
            <div id="ano">
                <h5>Faça a busca de legislação municipal por ano.</h5>
                <p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
            </div>
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
