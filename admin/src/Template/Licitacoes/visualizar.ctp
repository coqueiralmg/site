<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->element('mnlicitacoes') ?>
                        <hr clear="all"/>
                    </div>
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <legend>Dados do Processo Licitatório</legend>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("numprocesso", "Número do Processo") ?><br/>
                                    <b><?=$this->Format->zeroPad($licitacao->numprocesso, 3)?>/<?=$licitacao->ano?></b>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("modalidade", "Modalidade") ?><br/>
                                    <?=$licitacao->modalidade->nome?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("nummodalidade", "Número da Modalidade") ?><br/>
                                    <?=$this->Format->zeroPad($licitacao->nummodalidade, 3)?>/<?=$licitacao->ano?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("documento", "Documento") ?><br/>
                                    <?php if($licitacao->numdocumento != null && $licitacao->numdocumento != ""):?>
                                        <?=$licitacao->documento?> <?=$this->Format->zeroPad($licitacao->numdocumento, 3)?>/<?=$licitacao->ano?>
                                    <?php else:?>
                                        Não há
                                    <?php endif;?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("titulo", "Título") ?><br/>
                                    <?=$licitacao->titulo ?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("publicacao", "Data de Publicação") ?><br/>
                                    <?=$this->Format->date($licitacao->dataPublicacao, true)?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("publicacao", "Data da Última Atualização") ?><br/>
                                    <?=$this->Format->date($licitacao->dataAtualizacao, true)?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("Status", "Status") ?><br/>
                                    <?=$licitacao->status->nome?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("descricao", "Descrição") ?><br/>
                                    <?= $concurso->descricao?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("observacoes", "Observações") ?><br/>
                                    <?= $concurso->observacoes?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <?php
                    /*

                    <!--
                    <div class="card-content">
                        <legend>Cargos</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-content table-responsive">
                                        <?php if($cargos->count() > 0):?>
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>Cargo</th>
                                                        <th>Vagas Total</th>
                                                        <th>Vagas PCD</th>
                                                        <th>Carga Horária</th>
                                                        <th>Vencimento</th>
                                                        <th>Taxa de Inscrição</th>
                                                        <th>Ativo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($cargos as $cargo): ?>
                                                        <tr>
                                                            <td><?=$cargo->nome?></td>
                                                            <td><?=$cargo->vagas?></td>
                                                            <td><?=$cargo->PCD?></td>
                                                            <td><?=$cargo->cargaHoraria?></td>
                                                            <td><?=$this->Format->currency($cargo->vencimento)?></td>
                                                            <td><?=$this->Format->currency($cargo->taxaInscricao)?></td>
                                                            <td><?=$cargo->ativado?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <h3>Não existem cargos relativos a <?= $concurso->tipo == 'CP' ? 'concurso público' : 'processo seletivo' ?> <?= $concurso->numero ?> - <?= $concurso->titulo ?>.</h3>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">
                        <legend>Documentos</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-content table-responsive">
                                        <?php if($documentos->count() > 0):?>
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Descrição</th>
                                                        <th>Ativo</th>
                                                        <th style="width: 8%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($documentos as $documento): ?>
                                                        <tr>
                                                            <td><?=$this->Format->date($documento->data)?></td>
                                                            <td><?=$documento->descricao?></td>
                                                            <td><?=$documento->ativado?></td>
                                                            <td class="td-actions text-right">
                                                                <a href="<?= $this->Url->build('/../' . $documento->arquivo) ?>" title="Ver arquivo" target="_blank" class="btn btn-success btn-round">
                                                                    <i class="material-icons">archive</i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <h3>Não existem cargos relativos a <?= $concurso->tipo == 'CP' ? 'concurso público' : 'processo seletivo' ?> <?= $concurso->numero ?> - <?= $concurso->titulo ?>.</h3>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    -->
                    */
                    ?>
                    <div class="card-content">
                        <a href="<?= $this->Url->build(['controller' => 'Concursos', 'action' => 'documento', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                        <button type="button" onclick="window.location='<?= $this->Url->build('/concursos') ?>'" class="btn btn-info pull-right">Voltar</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
