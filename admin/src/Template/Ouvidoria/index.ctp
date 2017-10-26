<?= $this->Html->script('controller/ouvidoria.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                         <?=$this->element('message', [
                            'name' => 'lista_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao buscar as manifestações',
                            'details' => ''
                        ]) ?>
                        <h4 class="card-title">Buscar</h4>
                        
                        <?php
                        echo $this->Form->create("Ouvidoria", [
                            "url" => [
                                "controller" => "ouvidoria",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_inicial", "Data Inicial") ?>
                                        <?= $this->Form->text("data_inicial", ["id" => "data_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_final", "Data Inicial") ?>
                                        <?= $this->Form->text("data_final", ["id" => "data_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("prioridade", "Prioridade") ?> <br/>
                                        <?=$this->Form->select('prioridade', $combo_prioridade, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("status", "Status") ?> <br/>
                                        <?=$this->Form->select('status', $combo_status, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                            <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <a href="<?= $this->Url->build(['controller' => 'Ouvidoria', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                         <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($manifestacoes) > 0):?>
                            <h4 class="card-title">Consulta de Manifestações</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Número</th>
                                        <th>Data</th>
                                        <th>Manifestante</th>
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
                                             && $manifestacao->status->id != $this->Data->setting('Ouvidoria.status.definicoes.recusado')) ? "font-weight: bold" : ""?>
                                        ">
                                            <td><?=$this->Format->zeroPad($manifestacao->id)?></td>
                                            <td><?=$this->Format->date($manifestacao->data, true)?></td>
                                            <td><?=$manifestacao->manifestante->nome?></td>
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
                               <?=$this->element('pagination', $opcao_paginacao) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>