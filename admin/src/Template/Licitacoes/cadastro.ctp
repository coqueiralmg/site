<script type="text/javascript">
    var idLicitacao = <?=$id?>;
</script>
<?= $this->Html->script('select2.min', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/licitacoes.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($licitacao, [
                                "url" => [
                                    "controller" => "licitacoes",
                                    "action" => "save",
                                    $id
                                ],
                                'enctype' => 'multipart/form-data',
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar a licitação',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('lassuntos', ["id" => "lassuntos"]) ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["id" => "titulo", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("modalidade", "Modalidade") ?>
                                        <?= $this->Form->select("modalidade", $combo_modalidade, ["id" => "modalidade", "class" => "form-control", "empty" => true]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("numprocesso", "Número do Processo") ?>
                                        <?= $this->Form->number("numprocesso", ["id" => "numprocesso", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nummodalidade", "Número da Modalidade") ?>
                                        <?= $this->Form->number("nummodalidade", ["id" => "nummodalidade", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("numdocumento", "Número do Documento") ?>
                                        <?= $this->Form->number("numdocumento", ["id" => "numdocumento", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("status", "Status") ?>
                                        <?= $this->Form->select("status", $combo_status, ["id" => "status", "class" => "form-control", "empty" => true]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_publicacao", "Data Publicação") ?>
                                        <?= $this->Form->text("data_publicacao", ["id" => "data_publicacao", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("hora_publicacao", "Hora Publicação") ?>
                                        <?= $this->Form->text("hora_publicacao", ["id" => "hora_publicacao", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("ano", "Ano") ?>
                                        <?= $this->Form->text("ano", ["id" => "ano", "class" => "form-control", "maxlength" => 4]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("documento", "Nome ou Tipo do Documento") ?>
                                        <?= $this->Form->text("documento", ["id" => "documento", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_sessao", "Data da Sessão") ?>
                                        <?= $this->Form->text("data_sessao", ["id" => "data_sessao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("hora_sessao", "Hora da Sessão") ?>
                                        <?= $this->Form->text("hora_sessao", ["id" => "hora_sessao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data_fim", "Data Fim") ?>
                                        <?= $this->Form->text("data_fim", ["id" => "data_fim", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("hora_fim", "Hora Fim") ?>
                                        <?= $this->Form->text("hora_fim", ["id" => "hora_fim", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("descricao", "Descrição da Licitação") ?>
                                        <?= $this->Form->textarea("descricao", ["id" => "descricao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= $this->Form->label("assuntos", "Assuntos") ?>
                                    <?=$this->Form->select('assuntos', $assuntos, ['id' => 'assuntos', 'multiple' => true, 'value' => $assuntos_pivot, 'class' => 'form-control'])?>
                                    <span class="material-input"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("destaque", ['id' => 'destaque']) ?> Destaque
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("retificado", ['id' => 'retificado']) ?> Retificado
                                            </label>
                                        </div>
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
                                <button type="button" onclick="window.location='<?= $this->Url->build(['action' => 'add']) ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/licitacoes') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
