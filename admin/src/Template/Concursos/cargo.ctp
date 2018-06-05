<script type="text/javascript">
    var idCargoConcurso = <?=$id?>;
</script>
<?= $this->Html->script('controller/concursos.cargo.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($cargo, [
                                "url" => [
                                    "controller" => "cargos",
                                    "action" => "save",
                                    $id
                                ],
                                'enctype' => 'multipart/form-data',
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o cargo do concurso ou processo seletivo.',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('concurso', ['value' => $concurso->id]) ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("concurso", "Concurso") ?><br/>
                                        <?= $concurso->numero ?> - <?= $concurso->titulo ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 80]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("requisito", "Requisitos") ?>
                                        <?= $this->Form->textarea("requisito", ["id" => "requisito", "class" => "form-control", "rows" => 2, "maxlength" => 300]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("vagasTotal", "Total de Vagas") ?>
                                        <?= $this->Form->number("vagasTotal", ["id" => "vagasTotal", "class" => "form-control", "rows" => 2, "maxlength" => 3]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("vagaspcd", "Vagas PCD") ?>
                                        <?= $this->Form->number("vagaspcd", ["id" => "vagaspcd", "class" => "form-control", "rows" => 2, "maxlength" => 3]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("cargaHoraria", "Carga Horária (H/sem)") ?>
                                        <?= $this->Form->text("cargaHoraria", ["id" => "cargaHoraria", "class" => "form-control", "rows" => 2, "maxlength" => 300]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("vencimento", "Vencimento") ?>
                                        <?= $this->Form->text("vencimento", ["id" => "vencimento", "class" => "form-control", "rows" => 2, "maxlength" => 300]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("taxaInscricao", "Taxa de Inscrição") ?>
                                        <?= $this->Form->text("taxaInscricao", ["id" => "taxaInscricao", "class" => "form-control", "rows" => 2, "maxlength" => 300]) ?>
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
                                                <?= $this->Form->checkbox("reserva", ['id' => 'reserva']) ?> Cadastro de Reserva
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
                                <button type="button" onclick="window.location='<?= $this->Url->build(['action' => 'cargo', 0, '?' => ['idConcurso' => $concurso->id]]) ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build(['controller' => 'concursos', 'action' => 'cargos', $concurso->id]) ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
