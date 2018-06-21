<section id="about-us">
    <div class="container">
        <div class="center wow fadeInDown">
            <h2><?= $concurso->numero . ' - ' . $concurso->titulo ?></h2>
            <p class="lead">Detalhes sobre o cargo <b><?=$cargo->nome?></b>.</p>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 blog-content">
                        <h3><?= $cargo->nome ?></h3>

                        <h5>Requisitos de Investidura do Cargo</h5>
                        <?= $cargo->requisito ?>

                        <?php if($cargo->atribuicoes != null && $cargo->atribuicoes != ''): ?>
                            <h5>Atribuições do Cargo</h5>
                            <?= $cargo->atribuicoes ?>
                        <?php endif;?>

                        <?php if($cargo->observacoes != null && $cargo->observacoes != ''): ?>
                            <h5>Informações e outras observações adicionais</h5>
                            <?= $cargo->observacoes ?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <!--/.col-md-8-->

            <aside class="col-md-3">
                <div class="widget categories">
                    <h3>Dados Gerais</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Vagas Total:</strong>
                            <span><?=$cargo->vagasTotal?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Vagas PCD:</strong>
                            <span><?= $cargo->vagaspcd ?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Carga Horária</strong>
                            <span><?= $cargo->cargaHoraria ?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Vencimento:</strong>
                            <span><?=$this->Format->currency($cargo->vencimento)?></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Taxa de Inscrição:</strong>
                            <span><?=$this->Format->currency($cargo->taxaInscricao)?></span>
                        </div>
                    </div>
                </div>
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
                        <div class="col-md-12" style="padding-top: 25px">
                            <?= $this->Html->link('Ver Detalhes', ['controller' => 'concursos', 'action' =>  'concurso', $concurso->slug . '-' . $concurso->id], ['class' => 'btn btn-success btn-sm pull-right']) ?>
                        </div>
                    </div>
                </div>
                <?php if(count($informativos) > 0): ?>
                    <div class="widget categories">
                        <h3>Informativo</h3>
                        <div class="col-sm-12">
                            <?php foreach($informativos as $informativo): ?>
                                <div class="single_comments">
                                    <p><?=$this->Html->link('[' . $this->Format->date($informativo->data, true) . '] ' . $informativo->titulo, ['controller' => 'concursos', 'action' =>  'informativo', $informativo->id])?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </aside>

        </div>
        <!--/.row-->
        <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>
    </div>
</section>
