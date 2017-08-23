<script type="text/javascript">
    var idLicitacao = <?=$id?>;
</script>
<?= $this->Html->script('controller/noticias.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                            <?php
                            echo $this->Form->create($noticia, [
                                "url" => [
                                    "controller" => "noticias",
                                    "action" => "save",
                                    $id
                                ],
                                'enctype' => 'multipart/form-data',
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar a notícia',
                                'details' => ''
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('enviaArquivo', ["id" => "enviaArquivo"]) ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["id" => "titulo", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data", "Data") ?>
                                        <?= $this->Form->text("data", ["id" => "data", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                    <?= $this->Form->label("hora", "Hora") ?>
                                    <?= $this->Form->text("hora", ["id" => "hora", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("texto", "Texto da Notícia") ?>
                                        <?= $this->Form->textarea("texto", ["id" => "texto", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php if($id > 0): ?>
                                    <div id="panel_arquivo" style="background-color: ">
                                        <div class="col-md-3">
                                            <div class="form-group form-file-upload is-fileinput">
                                                <img src="<?='http://' . DS . $_SERVER['HTTP_HOST'] . DS . $noticia->foto?>" style="height: 150px; width: auto" class="img-rounded img-responsive img-raised">
                                            </div>
                                        </div>
                                        <div class="col-md-9" style="vertical-align: middle">
                                            <a class="btn btn-default btn-simple btn-wd btn-lg" href="#" rel="prettyPhoto">Ver Imagem Completa</a><br/>
                                            <button type="button" onclick="toggleArquivo()" style="vertical-align: middle" class="btn btn-default btn-simple btn-wd btn-lg">Substituir a Imagem</button>
                                        </div>
                                    </div>
                                    <div id="panel_envio" style="display: none">
                                        <div class="col-md-12">
                                            <div class="form-group form-file-upload is-fileinput">
                                                <?= $this->Form->label("arquivo", "Imagem em Destaque") ?>
                                                <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <div class="form-group form-file-upload is-fileinput">
                                            <?= $this->Form->label("arquivo", "Imagem em Destaque") ?>
                                            <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                            <span class="material-input"></span>
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
                                                <?= $this->Form->checkbox("destaque") ?> Destaque
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
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/noticias') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>