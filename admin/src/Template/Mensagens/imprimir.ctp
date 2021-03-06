<h4 class="card-title">Mensagem Interna do Sistema</h4>
<div class="content">
    <div class="container-fluid">
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
                <?php if ($mensagem->rementente == null): ?>
                    <i>Mensagem do Sistema</i>
                <?php else: ?>
                    <?=$rementente->pessoa->nome?> [@<?=$rementente->usuario?>](<?=$rementente->email?>)
                <?php endif;?>
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
    </div>
    <div class="clearfix"></div> 
</div>
