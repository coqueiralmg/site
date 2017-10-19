<h4 class="card-title">Manifestação da Ouvidoria</h4>
<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group label-control">
                <?= $this->Form->label("numero", "Número") ?><br/>
                <b><?=$this->Format->zeroPad($manifestacao->id)?></b>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group label-control">
                <?= $this->Form->label("data", "Data") ?><br/>
                <?=$this->Format->date($manifestacao->data, true)?>
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group label-control">
                <?= $this->Form->label("autor", "Autor") ?><br/>
                <?=$manifestacao->manifestante->nome?>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group label-control">
                <?= $this->Form->label("email", "E-mail") ?><br/>
                <?=$manifestacao->manifestante->email?>
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <div class="form-group">
                    <?= $this->Form->label("assunto", "Assunto") ?><br/>
                    <?=$manifestacao->assunto?>
                    <span class="material-input"></span>
                </div>
           </div>
       </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= $this->Form->label("mensagem", "Mensagem") ?><br/>
                <?=$manifestacao->texto?>
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div> 
</div>
