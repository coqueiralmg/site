<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Concursos Públicos e Processos Seletivos</h2>
            <p class="lead">Concursos Públicos e Processos Seletivos do Município de Coqueiral, e as novidades.</p>
        </div>
            <div class="blog">
                <div class="<?= count($informativos) > 0 ? 'col-md-9' : ''?>">
                    <?php if(count($concursos) > 0): ?>
                        <?php for($i = 0; $i < count($concursos); $i++): ?>
                            <?php
                                $concurso = $concursos[$i];
                            ?>
                            <?php if($i % 2 == 0): ?>
                                <div class="row">
                            <?php endif; ?>
                            <div class="item col-md-12 col-lg-6">
                                <h3 class="media-heading" style="text-transform: uppercase;"><?= $concurso->numero ?> - <?= $concurso->titulo ?></h3>
                                <p style="font-weight: bold"><?= $concurso->situacao ?></p>
                                <p>Inscrições: <?= $this->Format->date($concurso->inscricaoInicio) ?> à <?= $this->Format->date($concurso->inscricaoFim) ?></p>
                                <p>Data da Prova: <?= $this->Format->date($concurso->dataProva) ?></p>
                                <?= $this->Html->link('Detalhes', ['controller' => 'concursos', 'action' =>  'concurso', $concurso->slug . '-' . $concurso->id], ['class' => 'btn btn-success']) ?>
                            </div>
                            <?php if($i % 2 != 0): ?>
                                </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <br/>
                        <?php if($movel):?>
                            <?=$this->element('pagination_mobile', $opcao_paginacao) ?>
                        <?php else:?>
                            <?=$this->element('pagination', $opcao_paginacao) ?>
                        <?php endif;?>
                    <?php else: ?>
                        <p>Nenhum concurso disponível no momento!</p>
                    <?php endif; ?>
                </div>
                <?php if(count($informativos) > 0): ?>
                    <aside class="col-md-3">
                        <div class="widget categories">
                            <h3>Informativo</h3>
                            <div class="col-sm-12">
                                <?php foreach($informativos as $informativo): ?>
                                    <div class="single_comments">
                                        <p><?=$this->Html->link('[' . $this->Format->date($informativo->data, true) . '] ' . $informativo->titulo, ['controller' => 'concursos', 'action' =>  'informativo', $informativo->id])?></p>
                                        <div class="entry-meta small muted">
                                            <span>Em <?= $this->Html->link($informativo->concurso->numero . ' - ' . $informativo->concurso->titulo, ['controller' => 'concursos', 'action' =>  'concurso', $concurso->slug . '-' . $concurso->id]) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </aside>
                <?php endif; ?>
            </div>

        <!--/.row-->
        </div>
    <!--/.container-->
</section>
<!--/about-us-->
