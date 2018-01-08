<h4 class="card-title">Dados do Manifestante da Ouvidoria</h4>
<div class="content">
    <div class="container-fluid">
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
</div>
