<section id="about-us">
    <div class="container">

        <div class="center wow fadeInDown">
            <h2><?= $informativo->titulo ?></h2>
            <p class="lead">Data: <?= $this->Format->date($informativo->data, true) ?></p>
        </div>

        <div class="wow fadeInDown">
            <div class="col-md-9">
                <?= $informativo->texto ?>
            </div>
            <aside class="col-md-3">
                <div class="widget categories">
                    <h3><?=($concurso->tipo == 'CP' ? 'Dados do Concurso' : 'Dados do Processo Seletivo')?></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Status:</strong>
                            <span><?=$concurso->situacao?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Inscrições:</strong>
                            <span><?= $this->Format->date($concurso->inscricaoInicio) ?> à <?= $this->Format->date($concurso->inscricaoFim) ?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Data da Prova:</strong>
                            <span><?= $this->Format->date($concurso->dataProva) ?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Banca Organizadora:</strong>
                            <span><?= $this->Html->link($concurso->banca, $concurso->siteBanca, ['target' => '_blank', 'title' => 'Clique aqui para ir ao site da banca']) ?></span>
                        </div>
                    </div>
                </div>
                <?php if(count($informativos) > 0): ?>
                    <div class="widget categories">
                        <h3>Informativo</h3>
                        <div class="col-sm-12">
                            <?php foreach($informativos as $noticia): ?>
                                <div class="single_comments">
                                    <p><?=$this->Html->link('[' . $this->Format->date($noticia->data, true) . '] ' . $noticia->titulo, ['controller' => 'concursos', 'action' =>  'informativo', $noticia->id])?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </aside>
        </div>


    </div>
    <!--/.container-->
</section>
