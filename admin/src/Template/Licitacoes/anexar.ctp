<div class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Selecione o método de importação</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-content text-center">
                        <a href="<?=$this->Url->build([
                            'controller' => 'licitacoes',
                            'action' => 'anexo',
                            $id
                        ])?>">
                            <span>
                                <i class="material-icons" style="font-size: 116px">description</i>
                            </span>
                            <p><b>Arquivo Simples</b></p>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-content text-center">
                        <a href="<?=$this->Url->build([
                            'controller' => 'licitacoes',
                            'action' => 'grupo'
                        ])?>">
                            <span>
                                <i class="material-icons" style="font-size: 116px">description</i>
                            </span>
                            <p><b>Grupo de Arquivos</b></p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
