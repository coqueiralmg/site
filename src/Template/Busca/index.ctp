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
                
                <div class="center">
                    <h5><?= "Sua pesquisa retornou $total_geral resultados." ?></h5>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if($total_noticias > 0): ?>
                <div class="wow fadeInDown" style="display: block">
                    <h2 id="tipo_busca">Noticias</h2>
                    <?php foreach($noticias as $noticia): ?>
                    <div class="col-md-12">
                        <div class="pull-left">
                            <a href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>">
                                <img class="img-responsive" src="<?= '../' . $noticia->foto ?>" width="250px"/>
                            </a>
                        </div>
                        <div class="media-body" style="padding-left: 10px">
                            <h3 class="media-heading"><?= $noticia->post->titulo ?></h3>
                            <p><?= $noticia->parte ?></p>
                            <a href="<?= 'noticias/noticia/' . $noticia->post->slug . '-' . $noticia->id ?>" class="btn btn-success">Veja mais</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <?php if($total_licitacoes > 0): ?>
                <div class="wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Licitações</h2>
                    <?php foreach($licitacoes as $licitacao): ?>
                        <div class="col-md-12 col-lg-6">
                            <h3 class="media-heading"><?= $licitacao->titulo ?></h3>
                            <p>Início: <?= $this->Format->date($licitacao->dataInicio, true) ?></p>
                            <p>Término: <?= $this->Format->date($licitacao->dataTermino, true) ?></p>
                            <?= $this->Html->link('Veja mais', ['controller' => 'licitacoes', 'action' =>  'licitacao', $licitacao->slug . '-' . $licitacao->id], ['class' => 'btn btn-success']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if($total_publicacoes > 0): ?>
                <div class="wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Publicações</h2>
                    <?php foreach($publicacoes as $publicacao): ?>
                        <div class="col-md-12 col-lg-6">
                            <h3 class="media-heading"><?= $publicacao->titulo ?></h3>
                            <p><?= $publicacao->resumo ?></p>
                            <?= $this->Html->link('Veja mais', ['controller' => 'publicacoes', 'action' =>  'publicacao', $publicacao->id], ['class' => 'btn btn-success']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section><!--/#error-->