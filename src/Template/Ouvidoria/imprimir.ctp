<h4 class="card-title">Manifestação da Ouvidoria</h4>
<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group label-control">
                <?= $this->Form->label("numero", "Número") ?><br/>
                <b><?=$this->Format->zeroPad($manifestacao)?></b>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group label-control">
                <?= $this->Form->label("data", "Data") ?><br/>
                23/08/2017 15:13:27
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group label-control">
                <?= $this->Form->label("autor", "Autor") ?><br/>
                Mislene de Oliveira
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group label-control">
                <?= $this->Form->label("email", "E-mail") ?><br/>
                missoliveira@gmail.com
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
                <div class="form-group">
                    <?= $this->Form->label("assunto", "Assunto") ?><br/>
                    Lâmpada Queimada
                    <span class="material-input"></span>
                </div>
           </div>
       </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= $this->Form->label("mensagem", "Mensagem") ?><br/>
                Favor consertar iluminação na Rua Duque de Caxias que está um breu!
                <span class="material-input"></span>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div> 
</div>
