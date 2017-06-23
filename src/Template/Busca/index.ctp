<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Busca</h2>
            <p class="lead">Resultado de pesquisa em todo o site.</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php
                echo $this->Form->create("Busca", [
                    "url" => [
                        "controller" => "busca",
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
            <div class="wow fadeInDown">
                <h2 id="tipo_busca">Noticias</h2>
                <div class="col-md-12">
                    <div class="pull-left">
                        <img class="img-responsive" src="../img/slide/slider_historico1.jpg" width="250px"/>
                    </div>
                    <div class="media-body" style="padding-left: 10px">
                        <h3 class="media-heading">Um furo de reportagem</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                        <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-left">
                        <img class="img-responsive" src="../img/slide/slider_historico1.jpg" width="250px"/>
                    </div>
                    <div class="media-body" style="padding-left: 10px">
                        <h3 class="media-heading">Um furo de reportagem</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                        <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-left">
                        <img class="img-responsive" src="../img/slide/slider_historico1.jpg" width="250px"/>
                    </div>
                    <div class="media-body" style="padding-left: 10px">
                        <h3 class="media-heading">Um furo de reportagem</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                        <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-left">
                        <img class="img-responsive" src="../img/slide/slider_historico1.jpg" width="250px"/>
                    </div>
                    <div class="media-body" style="padding-left: 10px">
                        <h3 class="media-heading">Um furo de reportagem</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                        <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-left">
                        <img class="img-responsive" src="../img/slide/slider_historico1.jpg" width="250px"/>
                    </div>
                    <div class="media-body" style="padding-left: 10px">
                        <h3 class="media-heading">Um furo de reportagem</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                        <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                    </div>
                </div>
                
            </div>

            <div class="wow fadeInDown">
                <h2 id="tipo_busca">Licitações</h2>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
            </div>

            <div class="wow fadeInDown">
                <h2 id="tipo_busca">Publicações</h2>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
                <div class="col-md-12 col-lg-6">
                    <h3 class="media-heading">Lei nº 1234/2016</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut et dolore magna aliqua. Ut enim ad minim veniam</p>
                    <a href="legislacao_item.html" class="btn btn-success">Veja mais</a>
                </div>
            </div>
            <!--
            <?php if(count($licitacoes) > 0): ?>
                <?php foreach($licitacoes as $licitacao): ?>
                    <div class="item col-md-12 col-lg-6">
                        <h3 class="media-heading" style="text-transform: uppercase;"><?= $licitacao->titulo ?></h3>
                        <p>Início: <?= $this->Format->date($licitacao->dataInicio) ?></p>
                        <p>Término: <?= $this->Format->date($licitacao->dataTermino) ?></p>
                        <?= $this->Html->link('Veja mais', ['controller' => 'licitacoes', 'action' =>  'licitacao', $licitacao->slug . '-' . $licitacao->id], ['class' => 'btn btn-success']) ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhuma licitação disponível!</p>
            <?php endif; ?>
            -->
        </div>
    </div>
</section><!--/#error-->