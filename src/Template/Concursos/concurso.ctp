<section id="blog" class="container">
    <div class="blog">
        <div class="row">
            <div class="col-md-9">
                <div class="blog-item">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 blog-content">
                            <h2><?= $concurso->numero . ' - ' . $concurso->titulo ?></h2>
                            <?= $concurso->descricao ?>

                            <?php if($concurso->observacoes != null && $concurso->observacoes != ''): ?>
                                <legend>Observações</legend>
                                <?= $concurso->observacoes ?>
                            <?php endif;?>

                            <legend>Cargos</legend>
                            <?php if($cargos->count() > 0):?>
                                <table class="table table-striped">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Cargo</th>
                                            <th>Vagas Total</th>
                                            <th>Vagas PCD</th>
                                            <th>Carga Horária</th>
                                            <th>Vencimento</th>
                                            <th>Taxa de Inscrição</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($cargos as $cargo): ?>
                                            <tr>
                                                <td><?=$cargo->nome?></td>
                                                <td class="text-center"><?=$cargo->vagas?></td>
                                                <td class="text-center"><?=$cargo->PCD?></td>
                                                <td><?=$cargo->cargaHoraria?> (h/sem)</td>
                                                <td class="text-right"><?=$this->Format->currency($cargo->vencimento)?></td>
                                                <td class="text-right"><?=$this->Format->currency($cargo->taxaInscricao)?></td>
                                                <td class="td-actions text-right">
                                                    <a href="<?= $this->Url->build(['controller' => 'concursos', 'action' => 'cargo']) ?>" title="Ver Detalhes" class="btn btn-success btn-round">
                                                        <i class="fa fa-file-text"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4>Não existem cargos cadastrados para o <?= $concurso->tipo == 'CP' ? 'concurso público' : 'processo seletivo' ?> <?= $concurso->numero ?> - <?= $concurso->titulo ?>.</h4>
                            <?php endif; ?>

                            <legend>Documentos e Anexos</legend>
                            <?php if($documentos->count() > 0):?>
                                <table class="table table-striped">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Data</th>
                                            <th>Descrição</th>
                                            <th style="width: 8%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($documentos as $documento): ?>
                                            <tr>
                                                <td><?=$this->Format->date($documento->data)?></td>
                                                <td><?=$documento->descricao?></td>
                                                <td class="td-actions text-right">
                                                    <a href="<?= $this->Url->build($documento->arquivo) ?>" title="Download" target="_blank" class="btn btn-success btn-round">
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <h4>Não existem editais e documentos relacionados a <?= $concurso->tipo == 'CP' ? 'concurso público' : 'processo seletivo' ?> <?= $concurso->numero ?> - <?= $concurso->titulo ?>.</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--/.blog-item-->

                <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox"></div>
            </div>
            <!--/.col-md-8-->

            <aside class="col-md-3">

                <div class="widget categories">
                    <h3>Dados Gerais</h3>
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
                            <?php foreach($informativos as $informativo): ?>
                                <div class="single_comments">
                                    <p><?=$this->Html->link('[' . $this->Format->date($informativo->data, true) . '] ' . $informativo->titulo, ['controller' => 'concursos', 'action' =>  'informativo', $concurso->id])?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </aside>

        </div>
        <!--/.row-->

    </div>
    <!--/.blog-->

</section>
