<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?= $this->Flash->render() ?>
                            <legend>Mensagem</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data", "Data") ?><br/>
                                        <?=$this->Format->date($mensagem->data, true)?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("rementente", "Rementente") ?><br/>
                                        <?=$rementente->pessoa->nome?> [@<?=$rementente->usuario?>](<?=$rementente->email?>)
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("destinatario", "Destinatario") ?><br/>
                                        <?=$destinatario->pessoa->nome?> [@<?=$destinatario->usuario?>](<?=$destinatario->email?>)
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("assunto", "Assunto") ?><br/>
                                        <?=$mensagem->assunto?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("mensagem", "Mensagem") ?><br/>
                                        <?=$mensagem->mensagem?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                    </div>
                    <div class="card-content">
                        <a href="<?= $this->Url->build(['controller' => 'mensagens', 'action' => 'imprimir', $id]) ?>" class="btn btn-default btn-default pull-right" target="_blank">Imprimir<div class="ripple-container"></div></a>
                        <button type="button" onclick="excluirRegistro('<?= $id ?>')" class="btn btn-danger pull-right">Excluir</button>
                        <button type="button" onclick="window.location='<?= $this->Url->build('/mensagens') ?>'" class="btn btn-info pull-right">Voltar</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
