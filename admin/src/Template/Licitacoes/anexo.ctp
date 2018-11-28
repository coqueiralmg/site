<script type="text/javascript">
    var idAnexoLicitacao = <?=$id?>;
</script>
<?= $this->Html->script('controller/licitacoes.anexo.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($anexo, [
                                "url" => [
                                    "controller" => "anexos",
                                    "action" => "save",
                                    $id
                                ],
                                'enctype' => 'multipart/form-data',
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o documento ou anexo',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('enviaArquivo', ["id" => "enviaArquivo"]) ?>
                            <?= $this->Form->hidden('licitacao', ['value' => $licitacao->id]) ?>
                            <legend>Dados da Licitação</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("processo", "Processo") ?><br/>
                                        <b><?=$this->Format->zeroPad($licitacao->numprocesso, 3)?>/<?=$licitacao->ano?></b>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("modalidade", "Modalidade") ?><br/>
                                        <?=$licitacao->modalidade->nome?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("titulo", "Título") ?><br/>
                                        <?=$licitacao->titulo?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <hr/>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("numero", "Número") ?>
                                        <?= $this->Form->text("numero", ["id" => "numero", "class" => "form-control", "maxlength" => 32]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data", "Data") ?>
                                        <?= $this->Form->text("data", ["id" => "data", "class" => "form-control", "maxlength" => 20]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <?php if($id > 0): ?>
                                    <div id="panel_arquivo">
                                        <div class="col-md-9">
                                            <div class="form-group form-file-upload is-fileinput">
                                                Arquivo atual: <?=$this->Html->link(($anexo->numero != null ? $anexo->numero . ' ' : '') . $anexo->nome, '/../' . $anexo->arquivo, ['target' => '_blank'])?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" onclick="toggleArquivo()" class="btn btn-default btn-simple btn-wd btn-lg">Substituir Arquivo</button>
                                        </div>
                                    </div>
                                    <div id="panel_envio" style="display: none">
                                        <div class="col-md-12">
                                            <div class="form-group form-file-upload is-fileinput">
                                                <?= $this->Form->label("arquivo", "Arquivo") ?>
                                                <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <div class="form-group form-file-upload is-fileinput">
                                            <?= $this->Form->label("arquivo", "Arquivo") ?>
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
                                                <?= $this->Form->checkbox("ativo", ['id' => 'ativo']) ?> Ativo
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <?php if ($id > 0) :?>
                                <button type="button" onclick="window.location='<?= $this->Url->build(['action' => 'anexo', 0, '?' => ['idConcurso' => $licitacao->id]]) ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'anexos', $licitacao->id]) ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
