<?= $this->Html->script('controller/secretarias.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                        echo $this->Form->create($secretaria, [
                            "url" => [
                                "controller" => "secretarias",
                                "action" => "save",
                                $id
                            ],
                            'enctype' => 'multipart/form-data',
                            "role" => "form"]);
                        ?>
                        <?=$this->element('message', [
                            'name' => 'cadastro_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao salvar a secretaria',
                            'details' => ''
                        ]) ?>
                        <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("responsavel", "Responsavel") ?>
                                        <?= $this->Form->text("responsavel", ["id" => "responsavel", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("endereco", "Endereço") ?>
                                        <?= $this->Form->text("endereco", ["id" => "endereco", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("telefone", "Telefone") ?>
                                        <?= $this->Form->text("telefone", ["id" => "telefone", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("email", "E-mail") ?>
                                        <?= $this->Form->email("email", ["id" => "email", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $this->Form->label("descricao_responsavel", "Informações sobre o Responsável pelo Departamento ou Secretaria") ?>
                                        <?= $this->Form->textarea("descricao_responsavel", ["id" => "descricao_responsavel", "rows" => "3", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $this->Form->label("expediente", "Expediente    ") ?>
                                        <?= $this->Form->textarea("expediente", ["id" => "expediente", "rows" => "3", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("descricao", "Descrição da Secretaria") ?>
                                        <?= $this->Form->textarea("descricao", ["id" => "descricao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
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
                            <button type="button" onclick="window.location='<?= $this->Url->build('/secretarias') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>