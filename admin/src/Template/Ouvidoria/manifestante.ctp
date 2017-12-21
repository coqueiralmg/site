<?= $this->Html->script('controller/ouvidoria.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <legend>Dados do Manifestante</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("codigo", "Código") ?><br/>
                                    <b><?=$this->Format->zeroPad($manifestante->id)?></b>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("nome", "Nome") ?><br/>
                                    <?=$manifestante->nome?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("email", "E-mail") ?><br/>
                                    <?=$manifestante->email?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("endereco", "Endereço") ?><br/>
                                    <?= $manifestante->endereco?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $this->Form->label("telefone", "Telefone") ?><br/>
                                    <?=$manifestante->telefone?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("bloqueado", "Bloqueado") ?><br/>
                                    <?= $manifestante->bloqueado ? "Sim" : "Não"?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($manifestacoes) > 0):?>
                            <h4 class="card-title">Manifestações Enviadas</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Número</th>
                                        <th>Data</th>
                                        <th>Assunto</th>
                                        <th>Status</th>
                                        <th>Prioridade</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($manifestacoes as $manifestacao): ?>
                                        <tr style="
                                        <?=($manifestacao->prioridade->id == $this->Data->setting('Ouvidoria.prioridade.definicoes.urgente.id') 
                                             && $manifestacao->status->id != $this->Data->setting('Ouvidoria.status.fechado')
                                             && $manifestacao->status->id != $this->Data->setting('Ouvidoria.status.definicoes.recusado')) ? "font-weight: bold;" : ""?>
                                        <?=($manifestacao->atrasado) ? "color: red;" : ""?>
                                        ">
                                            <td><?=$this->Format->zeroPad($manifestacao->id)?></td>
                                            <td><?=$this->Format->date($manifestacao->data, true)?></td>
                                            <td><?=$manifestacao->assunto?></td>
                                            <td><?=$manifestacao->status->nome?></td>
                                            <td><?=$manifestacao->prioridade->nome?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                <?php if($manifestacao->status->id == $this->Data->setting('Ouvidoria.status.inicial')):?>
                                                    <?php if ($this->Membership->handleRole("responder_manifestacao")): ?>
                                                        <button type="button" onclick="verificarManifestacao(<?= $manifestacao->id ?>)" title="Verificar a manifestação" class="btn btn-primary btn-round"><i class="material-icons">insert_drive_file</i></button>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("recusar_manifestacao")): ?>
                                                        <button type="button" onclick="recusarManifestacao(<?= $manifestacao->id ?>)"  title="Recusar manifestação" class="btn btn-danger btn-round"><i class="material-icons">pan_tool</i></button>
                                                    <?php endif; ?>
                                                <?php elseif($manifestacao->status->id == $this->Data->setting('Ouvidoria.status.definicoes.recusado')):?>
                                                    <?php if ($this->Membership->handleRole("responder_manifestacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Ouvidoria', 'action' => 'manifestacao', $manifestacao->id]) ?>" title="Verificar a manifestação" class="btn btn-primary btn-round">
                                                            <i class="material-icons">insert_drive_file</i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("fechar_manifestacao")): ?>
                                                        <button type="button" onclick="fecharManifestacao(<?= $manifestacao->id ?>)"  title="Fechar manifestação" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                    <?php endif; ?>
                                                <?php else:?>
                                                    <?php if ($this->Membership->handleRole("responder_manifestacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Ouvidoria', 'action' => 'manifestacao', $manifestacao->id]) ?>" title="Verificar a manifestação" class="btn btn-primary btn-round">
                                                            <i class="material-icons">insert_drive_file</i>
                                                        </a>
                                                        <?php if ($this->Membership->handleRole("exibir_manifestante_ouvidoria")): ?>
                                                            <button type="button" onclick="exibirManifestante(<?= $manifestacao->manifestante->id ?>)"  title="Informações sobre o manifestante" class="btn btn-info btn-round"><i class="material-icons">face</i></button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Nenhuma manifestação encontrada.</h3>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                               <?=$this->element('short_pagination', $opcao_paginacao) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                    <div class="card-content">
                        <a href="<?= $this->Url->build(['controller' => 'Ouvidoria', 'action' => 'document', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                        <button type="button" onclick="window.location='<?= $this->Url->build('/ouvidoria/manifestantes') ?>'" class="btn btn-info pull-right">Voltar</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
