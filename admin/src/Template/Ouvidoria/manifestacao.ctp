<?= $this->Html->script('controller/ouvidoria.manifestacao.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Dados da Manifestação</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("numero", "Número") ?><br/>
                                        <b><?=$this->Format->zeroPad($manifestacao->id)?></b>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data", "Data") ?><br/>
                                        <?=$this->Format->date($manifestacao->data, true)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("status", "Status") ?><br/>
                                        <?=$manifestacao->status->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("prioridade", "Prioridade") ?><br/>
                                        <?=$manifestacao->prioridade->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ip", "Endereço de IP") ?><br/>
                                        <?= $manifestacao->ip?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <?= $this->Form->label("assunto", "Assunto") ?><br/>
                                        <?=$manifestacao->assunto?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("mensagem", "Mensagem") ?><br/>
                                        <?= $manifestacao->texto?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="clearfix"></div>
                    </div>
                                        
                    <div class="card-content">
                        <legend>Dados do Manifestante</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("codigo", "Código") ?><br/>
                                    <b><?=$this->Format->zeroPad($manifestacao->manifestante->id)?></b>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("nome", "Nome") ?><br/>
                                    <?=$manifestacao->manifestante->nome?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("email", "E-mail") ?><br/>
                                    <?=$manifestacao->manifestante->email?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("endereco", "Endereço") ?><br/>
                                    <?= $manifestacao->manifestante->endereco?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= $this->Form->label("telefone", "Telefone") ?><br/>
                                    <?=$manifestacao->manifestante->telefone?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-control">
                                    <?= $this->Form->label("bloqueado", "Bloqueado") ?><br/>
                                    <?= $manifestacao->manifestante->bloqueado ? "Sim" : "Não"?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="card-content">
                        <legend>Histórico da Manifestação</legend>
                        <?php foreach($historico as $item): ?>
                            <?php if($item->resposta):?>
                                <div class="timeline-panel resposta" >
                                    <div class="timeline-heading">
                                        <span class="label label-success"><?=$this->Format->date($item->data, true)?> | Status: <?=$item->status->nome?></span>
                                    </div>
                                    <div class="timeline-body">
                                        <p><?=$item->mensagem?></p>
                                    </div>
                                </div>
                            <?php else:?>    
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <span class="label label-warning"><?=$this->Format->date($item->data, true)?> | Status: <?=$item->status->nome?></span>
                                    </div>
                                    <div class="timeline-body">
                                        <p><?=$item->mensagem?></p>
                                    </div>
                                </div>
                            <?php endif;?>
                        <?php endforeach; ?>
                        <div class="clearfix"></div>
                    </div>

                   
                    <div class="card-content">
                        <button type="button" onclick="window.location='<?= $this->Url->build('/ouvidoria') ?>'" class="btn btn-info pull-right">Voltar</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
