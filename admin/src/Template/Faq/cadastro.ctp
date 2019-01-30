<script type="text/javascript">
    var idPergunta = <?=$id?>;
</script>
<?= $this->Html->script('controller/faq.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?php if ($id > 0) :?>
                        <div class="card-content">
                            <?= $this->element('mnfaq') ?>
                            <hr clear="all"/>
                        </div>
                    <?php endif; ?>
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($pergunta, [
                                "url" => [
                                    "controller" => "faq",
                                    "action" => "save",
                                    $id
                                ],
                                "role" => "form"]);
                            ?>
                             <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar a pergunta.',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("questao", "Questão") ?>
                                        <?= $this->Form->text("questao", ["id" => "questao", "class" => "form-control", "maxlength" => 160]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("resposta", "Resposta") ?>
                                        <?= $this->Form->textarea("resposta", ["id" => "resposta", "class" => "form-control", "maxlength" => 320]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $this->Form->label("categoria", "Categoria") ?>
                                        <?=$this->Form->select('categoria', $combo_categorias, ['id' => 'categoria', 'class' => 'form-control', 'empty' => true])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?= $this->Form->label("tipo_ouvidoria", "Gatilho de Ouvidoria") ?>
                                        <?=$this->Form->select('tipo_ouvidoria', $combo_ouvidoria, ['id' => 'tipo_ouvidoria', 'class' => 'form-control'])?>
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
                                                <?= $this->Form->checkbox("destaque", ["id" => "destaque"]) ?> Destaque
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("ativo", ["id" => "ativo"]) ?> Ativo
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <?php if ($id > 0) :?>
                                <button type="button" onclick="window.location='<?= $this->Url->build(['action' => 'insert']) ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/faq') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
