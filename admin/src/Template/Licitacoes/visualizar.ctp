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
                                    <?php if($licitacao->modalidade->chave == 'CC' ||
                                             $licitacao->modalidade->chave == 'CN' ||
                                             $licitacao->modalidade->chave == 'CR' ||
                                             $licitacao->modalidade->chave == 'CO' ||
                                             $licitacao->modalidade->chave == 'PE' ||
                                             $licitacao->modalidade->chave == 'LE'):?>
                                        <?= $this->Form->label("sessao", "Data de Início") ?><br/>
                                    <?php else: ?>
                                        <?= $this->Form->label("sessao", "Data da Sessão") ?><br/>
                                    <?php endif;?>
                                    <?=$this->Format->date($licitacao->dataSessao, true)?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <?php if($licitacao->modalidade->chave != 'PP' &&
                                     $licitacao->modalidade->chave != 'TP'):?>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("sessao", "Data Fim") ?><br/>
                                        <?=$this->Format->date($licitacao->dataFim, true)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            <?php endif;?>
                            <div class="col-md-4">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("Status", "Status") ?><br/>
                                    <?=$licitacao->status->nome?> (<span title="O status escrito entre parênteses, é o que será exibido no site"><?=$licitacao->situacao?></span>)
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("descricao", "Descrição") ?><br/>
                                    <?= $licitacao->descricao?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <?php if($atualizacoes->count() > 0): ?>
                        <div class="card-content">
                            <legend>Extratos e Atualizações</legend>
                            <?php foreach($atualizacoes as $atualizacao): ?>
                                <div class="timeline-panel resposta" >
                                    <div class="timeline-heading">
                                        <span class="label label-success"><?=$this->Format->date($atualizacao->data, true)?> | <?=$atualizacao->titulo?></span>
                                    </div>
                                    <div class="timeline-body">
                                        <p><?=$atualizacao->texto?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="clearfix"></div>
                        </div>
                    <?php endif; ?>

                    <div class="card-content">
                        <legend>Documentos e Anexos</legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-content table-responsive">
                                        <?php if($anexos->count() > 0):?>
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Número</th>
                                                        <th>Nome</th>
                                                        <th>Ativo</th>
                                                        <th>Arquivo</tr>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($anexos as $anexo): ?>
                                                        <tr>
                                                            <td><?=$this->Format->date($anexo->data)?></td>
                                                            <td><?=$anexo->codigo?></td>
                                                            <td><?=$anexo->nome?></td>
                                                            <td><?=$anexo->ativado?></td>
                                                            <td class="td-actions text-right">
                                                                <a href="<?= $this->Url->build('/../' . $anexo->arquivo) ?>" title="Ver arquivo" target="_blank" class="btn btn-success btn-round">
                                                                    <i class="material-icons">archive</i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <h3>Não existem documentos ou anexos relativos a esta licitação.</h3>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-content">
                        <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'documento', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                        <button type="button" onclick="window.location='<?= $this->Url->build('/licitacoes') ?>'" class="btn btn-info pull-right">Voltar</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
