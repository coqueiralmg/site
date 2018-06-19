<section id="legislacao">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2>Concursos Públicos e Processos Seletivos</h2>
            <p class="lead">Concursos Públicos e Processos Seletivos do Município de Coqueiral, e as novidades.</p>
        </div>
            <div class="blog">
                <div class="<?= count($informativos) > 0 ? 'col-md-10' : ''?>">
                    <?php if(count($concursos) > 0): ?>
                        <?php for($i = 0; $i < count($concursos); $i++): ?>
                            <?php
                                $concurso = $concursos[$i];
                            ?>
                            <?php if($i % 2 == 0): ?>
                                <div class="row">
                            <?php endif; ?>
                            <div class="<?= count($informativos) > 0 ? 'item col-md-10 col-lg-5' : 'item col-md-12 col-lg-6'?>">
                                <h3 class="media-heading" style="text-transform: uppercase;"><?= $concurso->numero ?> - <?= $concurso->titulo ?></h3>
                                <p>Inscrições: <?= $this->Format->date($concurso->inscricaoInicio) ?> à <?= $this->Format->date($concurso->inscricaoFim) ?></p>
                                <p>Data da Prova: <?= $this->Format->date($concurso->dataProva) ?></p>
                                <?= $this->Html->link('Detalhes', ['controller' => 'licitacoes', 'action' =>  'licitacao', $concurso->slug . '-' . $concurso->id], ['class' => 'btn btn-success']) ?>
                            </div>
                            <?php if($i % 2 != 0): ?>
                                </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    <?php else: ?>
                        <p>Nenhum concurso disponível!</p>
                    <?php endif; ?>
                </div>

            </div>
            <?php if(count($informativos) > 0): ?>
                    <aside class="col-md-2">
                        <div class="widget categories">
                            <h3>Informativo</h3>

                        </div>
                    </aside>
                <?php endif; ?>
        <!--/.row-->
        </div>

    <!--/.container-->
</section>
<!--/about-us-->
