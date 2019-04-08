<?= $this->Html->script('controller/busca.resultado.js', ['block' => 'scriptBottom']) ?>
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

                <?= $this->Form->search('chave', ['id' => 'pesquisa', 'class' => 'form-control busca', 'placeholder' => 'Digite aqui para buscar']) ?>
                 <button type="submit" id="btn-pesquisar" class="btn btn-success"><i class="fa fa-search"></i>&nbsp;Buscar</button>

                <?php echo $this->Form->end(); ?>

                <?php if($total_geral > 0) : ?>
                    <div class="center">
                        <h5><?= "Sua pesquisa retornou $total_geral resultados." ?></h5>
                    </div>
                <?php endif; ?>
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
                                <img id="busca_noticia" class="img-responsive" src="<?= '../' . $noticia->foto ?>" width="250px"/>
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
        </div>
        <div class="row">
            <?php if($total_duvidas > 0): ?>
                <div class="col-md-12 wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Dúvidas e Perguntas</h2>
                    <?php for($i = 0; $i < count($duvidas); $i++): ?>
                        <?php $item = $duvidas[$i]; ?>
                        <?php if($i % 2 == 0): ?>
                            <div class="row">
                        <?php endif; ?>
                        <div class="col-md-12 col-lg-6">
                            <h3 class="media-heading"><?= $item->questao ?></h3>
                            <p><b>Categoria:</b> <?= $item->categoria->nome ?></p>
                            <?= $this->Html->link('Detalhes', ['controller' => 'duvidas', 'action' =>  'duvida', $item->slug . '-' . $item->id], ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php if($i % 2 != 0): ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php if($total_licitacoes > 0): ?>
                <div class="col-md-12 wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Licitações</h2>
                    <?php for($i = 0; $i < count($licitacoes); $i++): ?>
                        <?php $licitacao = $licitacoes[$i] ?>
                        <?php if($i % 2 == 0): ?>
                            <div class="row">
                        <?php endif; ?>
                        <?php if($licitacao->antigo): ?>
                            <div class="col-md-12 col-lg-6">
                                <h3 class="media-heading"><?= $licitacao->titulo ?></h3>
                                <p>Início: <?= $this->Format->date($licitacao->dataInicio, true) ?></p>
                                <p>Término: <?= $this->Format->date($licitacao->dataTermino, true) ?></p>
                                <?= $this->Html->link('Veja mais', ['controller' => 'licitacoes', 'action' =>  'documento', $licitacao->slug . '-' . $licitacao->id], ['class' => 'btn btn-success']) ?>
                            </div>
                        <?php else: ?>
                            <?=$this->element('Itens/item_licitacao', ['licitacao' => $licitacao]) ?>
                        <?php endif;?>
                        <?php if($i % 2 != 0): ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php if($total_concursos > 0): ?>
                <div class="col-md-12 wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Concursos e Processos Seletivos</h2>
                    <?php for($i = 0; $i < count($concursos); $i++): ?>
                        <?php $concurso = $concursos[$i] ?>
                        <?php if($i % 2 == 0): ?>
                            <div class="row">
                        <?php endif; ?>
                        <?=$this->element('Itens/item_concurso', ['concurso' => $concurso]) ?>
                        <?php if($i % 2 != 0): ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor?>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php if($total_informativos_concursos > 0): ?>
                <div class="col-md-12 wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Novidades Sobre Concursos e Processos Seletivos</h2>
                    <?php for($i = 0; $i < count($informativos); $i++): ?>
                        <?php $informativo = $informativos[$i]; ?>
                        <?php if($i % 2 == 0): ?>
                            <div class="row">
                        <?php endif; ?>
                        <div class="col-md-12 col-lg-6">
                            <h3 class="media-heading" style="text-transform: uppercase;"><?= $informativo->titulo ?></h3>
                            <p style="font-weight: bold"><?= $this->Format->Date($informativo->data, true) ?></p>
                            <p><?=$informativo->resumo?></p>
                            <?= $this->Html->link('Detalhes', ['controller' => 'concursos', 'action' =>  'informativo', $informativo->id], ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php if($i % 2 != 0): ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor?>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php if($total_legislacao > 0): ?>
                <div class="col-md-12 wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Legislação</h2>
                    <?php for($i = 0; $i < count($legislacao); $i++): ?>
                        <?php $item = $legislacao[$i]; ?>
                        <?php if($i % 2 == 0): ?>
                            <div class="row">
                        <?php endif; ?>
                        <?=$this->element('Itens/item_legislacao', ['publicacao' => $item]) ?>
                        <?php if($i % 2 != 0): ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor?>
                </div>
            <?php endif; ?>
        </div>
        <div class="row">
            <?php if($total_publicacoes > 0): ?>
                <div class="col-md-12 wow fadeInDown" style="display: inline-block">
                    <h2 id="tipo_busca">Publicações</h2>
                    <?php for($i = 0; $i < count($publicacoes); $i++): ?>
                        <?php $item = $publicacoes[$i]; ?>
                        <?php if($i % 2 == 0): ?>
                            <div class="row">
                        <?php endif; ?>
                        <div class="col-md-12 col-lg-6">
                            <h3 class="media-heading"><?= $item->titulo ?></h3>
                            <p><?= $item->resumo ?></p>
                            <?= $this->Html->link('Veja mais', ['controller' => 'legislacao', 'action' =>  'documento', $item->id], ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php if($i % 2 != 0): ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
