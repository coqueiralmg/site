<script type="text/javascript">
    var idGrupoUsuario = <?=$id?>;
</script>
<?= $this->Html->script('controller/grupos.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($grupo_usuario, [
                                "url" => [
                                    "controller" => "grupos",
                                    "action" => "save",
                                    $id
                                ],
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar o grupo de usuário.',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <legend>Dados Cadastrais</legend>
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control", "maxlength" => 50]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="funcoes" class="col-md-12">
                                    <legend>Funções</legend>
                                    <?php foreach ($grupos_funcoes as $grupo): ?>
                                        <div class="col-md-3">
                                            <div class="form-group form-group-min">
                                                <label><?=$grupo->nome?></label> <br/>
                                                <?php foreach ($funcoes as $funcao): ?>
                                                    <?php if($funcao->grupo == $grupo->id && $funcao->ativo):?>
                                                        <div class="togglebutton">
                                                            <label>
                                                                <?= $this->Form->checkbox('chk_' . $funcao->chave, [
                                                                    'checked' => array_key_exists($funcao->chave, $funcoes_grupo)
                                                                ]) ?> <?=$funcao->nome?>
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" onclick="marcarTodos()" class="btn btn-default btn-simple">Marcar Todos<div class="ripple-container"></div></button>
                                    <button type="button" onclick="desmarcarTodos()" class="btn btn-default btn-simple">Desmarcar Todos<div class="ripple-container"></div></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <legend>Outros</legend>
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("ativo", ["id" => "ativo"]) ?> Ativo
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("integrado", ["id" => "integrado"]) ?> Permitir integração com outros sistemas da prefeitura
                                            </label>
                                        </div>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("administrativo", ["id" => "administrativo"]) ?> Grupo Administrativo
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
                            <button type="button" onclick="window.location='<?= $this->Url->build('/grupos') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
