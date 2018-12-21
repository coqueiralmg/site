<?= $this->Html->script('select2.min', ['block' => 'scriptBottom']) ?>
<?= $this->Html->script('controller/ouvidoria.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create("ouvidoria", [
                                "url" => [
                                    "controller" => "ouvidoria",
                                    "action" => "save"
                                ],
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar a manifestação da ouvidoria',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden("tipos", ["value" => $tipos_chamado]) ?>
                            <legend>Dados da Manifestação</legend>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("assunto", "Assunto") ?>
                                        <?= $this->Form->text("assunto", ["id" => "assunto", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <?= $this->Form->label("prioridade", "Prioridade") ?>
                                        <?=$this->Form->select('prioridade', $prioridades, ['id' => 'prioridade', 'class' => 'form-control', "empty" => true])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("tipo", "Tipo da Manifestação") ?>
                                        <?= $this->Form->select("tipo", $combo_tipo, ["id" => "tipo", "class" => "form-control", "empty" => true]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("mensagem", "Mensagem") ?>
                                        <?= $this->Form->textarea("mensagem", ["id" => "mensagem", "class" => "form-control", "placeholder" => "Digite aqui um texto ou uma mensagem da solicitação do manifestante.", "rows" => 10]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("observacao", "Observação") ?>
                                        <?= $this->Form->textarea("observacao", ["id" => "observacao", "class" => "form-control", "placeholder" => "Digite aqui uma observação adicional, se houver. Esta informação será gravada no histórico da manifestação."]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <legend>Dados do Manifestante</legend>
                            <div class="row">
                                <div id="panel_escolha">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <?= $this->Form->label("manifestante", "Manifestante") ?>
                                            <?=$this->Form->select('manifestante', $manifestantes, ['id' => 'manifestante', 'class' => 'form-control', "empty" => true])?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="button" onclick="toggleManifestante()" class="btn btn-default btn-simple btn-wd btn-lg">Novo Manifestante</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel_novo_geral" style="display: none">
                                    <div class="col-md-8">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("nome", "Nome") ?>
                                            <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 80]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="button" onclick="toggleManifestante()" class="btn btn-default btn-simple btn-wd btn-lg">Selecionar Manifestante Cadastrado</button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("email", "E-mail") ?>
                                            <?= $this->Form->text("email", ["id" => "email", "class" => "form-control", "maxlength" => 50]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("telefone", "Telefone") ?>
                                            <?= $this->Form->text("telefone", ["id" => "telefone", "class" => "form-control", "maxlength" => 15]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("endereco", "Endereço Completo") ?>
                                            <?= $this->Form->text("endereco", ["id" => "endereco", "class" => "form-control", "maxlength" => 150]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="panel_novo_iluminacao" style="display: none">
                                    <div class="col-md-8">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("nome", "Nome") ?>
                                            <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 80]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="button" onclick="toggleManifestante()" class="btn btn-default btn-simple btn-wd btn-lg">Selecionar Manifestante Cadastrado</button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("email", "E-mail") ?>
                                            <?= $this->Form->text("email", ["id" => "email", "class" => "form-control", "maxlength" => 50]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("telefone", "Telefone") ?>
                                            <?= $this->Form->text("telefone", ["id" => "telefone", "class" => "form-control", "maxlength" => 15]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("endereco", "Endereço") ?>
                                            <?= $this->Form->text("endereco", ["id" => "endereco", "class" => "form-control", "maxlength" => 150]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("numero", "Número") ?>
                                            <?= $this->Form->text("numero", ["id" => "numero", "class" => "form-control", "maxlength" => 15]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("complemento", "Complemento") ?>
                                            <?= $this->Form->text("complemento", ["id" => "complemento", "class" => "form-control", "maxlength" => 15]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group label-control">
                                            <?= $this->Form->label("bairro", "Bairro") ?>
                                            <?= $this->Form->text("bairro", ["id" => "bairro", "class" => "form-control", "maxlength" => 50]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
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
