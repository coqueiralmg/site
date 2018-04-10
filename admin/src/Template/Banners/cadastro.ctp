<script type="text/javascript">
    var idBanner = <?=$id?>;
</script>
<?= $this->Html->script('controller/banners.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($banner, [
                                "url" => [
                                    "controller" => "banners",
                                    "action" => "save",
                                    $id
                                ],
                                'enctype' => 'multipart/form-data',
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o banner',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('enviaArquivo', ["id" => "enviaArquivo"]) ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 50]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["id" => "titulo", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("descricao", "Descrição do Banner") ?>
                                        <?= $this->Form->textarea("descricao", ["id" => "descricao", "class" => "form-control", "rows" => 2, "maxlength" => 384]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ordem", "Ordem") ?>
                                        <?= $this->Form->number("ordem", ["id" => "ordem", "min" => 0, "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("validade", "Data de Validade") ?>
                                        <?= $this->Form->text("validade", ["id" => "validade", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("acao", "Nome da Ação") ?>
                                        <?= $this->Form->text("acao", ["id" => "acao", "placeholder" => "Ex: Veja mais", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("destino", "Destino") ?>
                                        <?= $this->Form->text("destino", ["id" => "destino", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php if($id > 0): ?>
                                    <div id="panel_arquivo" style="background-color: ">
                                        <div class="col-md-4">
                                            <div class="form-group form-file-upload is-fileinput">
                                                <img src="<?=$this->Url->build('/../' . $banner->imagem)?>" style="height: 150px; width: auto" class="img-rounded img-responsive img-raised">
                                            </div>
                                        </div>
                                        <div class="col-md-8" style="vertical-align: middle">
                                            <a class="btn btn-default btn-simple btn-wd btn-lg" href="<?=$this->Url->build('/../' . $banner->imagem)?>" data-lightbox="destaque">Ver Imagem Completa</a><br/>
                                            <button type="button" onclick="toggleArquivo()" style="vertical-align: middle" class="btn btn-default btn-simple btn-wd btn-lg">Substituir a Imagem</button>
                                        </div>
                                    </div>
                                    <div id="panel_envio" style="display: none">
                                        <div class="col-md-12">
                                            <div class="form-group form-file-upload is-fileinput">
                                                <?= $this->Form->label("arquivo", "Imagem do Banner (A imagem deve ter obrigatoriamente o tamanho 1400 x 730)") ?>
                                                <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Opções de Imagem</label> <br/>
                                                <div class="togglebutton">
                                                    <label>
                                                        <?= $this->Form->checkbox("mantem_nome", ["id" => "mantem_nome", "checked" => true]) ?> Manter o nome original do arquivo
                                                    </label>
                                                </div>
                                                <div id="novo_nome_arquivo" style="display:none">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-file-upload is-fileinput">
                                                                <?= $this->Form->label("nome_arquivo", "Nome do Arquivo") ?>
                                                                <?= $this->Form->text("nome_arquivo", ["id" => "nome_arquivo", "class" => "form-control"]) ?>
                                                                <span class="material-input"></span>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="togglebutton">
                                                                <label>
                                                                    <?= $this->Form->checkbox("unique_id", ["id" => "unique_id"]) ?> Gerar código único (Unique ID), como nome do arquivo.
                                                                </label>
                                                            </div>
                                                            <span class="material-input"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <div class="form-group form-file-upload is-fileinput">
                                            <?= $this->Form->label("arquivo", "Imagem do Banner (A imagem deve ter obrigatoriamente o tamanho 1400 x 730)") ?>
                                            <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Opções de Imagem</label> <br/>
                                            <div class="togglebutton">
                                                <label>
                                                    <?= $this->Form->checkbox("mantem_nome", ["id" => "mantem_nome", "checked" => true]) ?> Manter o nome original do arquivo
                                                </label>
                                            </div>
                                            <div id="novo_nome_arquivo" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-file-upload is-fileinput">
                                                            <?= $this->Form->label("nome_arquivo", "Nome do Arquivo") ?>
                                                            <?= $this->Form->text("nome_arquivo", ["id" => "nome_arquivo", "class" => "form-control"]) ?>
                                                            <span class="material-input"></span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="togglebutton">
                                                            <label>
                                                                <?= $this->Form->checkbox("unique_id", ["id" => "unique_id"]) ?> Gerar código único (Unique ID), como nome do arquivo.
                                                            </label>
                                                        </div>
                                                        <span class="material-input"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("blank") ?> Abrir o destino em nova janela
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("ativo") ?> Ativo
                                            </label>
                                        </div>
                                        <span class="material-input"></span>

                                    </div>
                                </div>
                            </div>

                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <?php if ($id > 0) :?>
                                <button type="button" onclick="window.location='<?= $this->Url->build(['action' => 'add']) ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/banners') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>