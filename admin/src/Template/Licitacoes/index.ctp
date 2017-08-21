<?= $this->Html->script('controller/licitacoes.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <?=$this->element('message', [
                            'name' => 'lista_erro',
                            'type' => 'error',
                            'message' => 'Ocorreu um erro ao buscar as licitações',
                            'details' => ''
                        ]) ?>
                        <h4 class="card-title">Buscar</h4>
                        <?php
                        echo $this->Form->create("Licitacoes", [
                            "url" => [
                                "controller" => "licitacoes",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_inicial", "Data Inicial") ?>
                                        <?= $this->Form->text("data_inicial", ["id" => "data_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_final", "Data Inicial") ?>
                                        <?= $this->Form->text("data_final", ["id" => "data_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="form-group form-button">
                            <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <?php if ($this->Membership->handleRole("adicionar_licitacao")): ?>
                                <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                        <?php echo $this->Form->end(); ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($licitacoes) > 0): ?>
                            <h4 class="card-title">Licitações Cadastradas</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Título</th>
                                        <th>Data Início</th>
                                        <th>Data Término</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($licitacoes as $licitacao): ?>
                                        <tr>
                                            <td><?= $licitacao->titulo ?></td>
                                            <td style="width: 15%"><?= $this->Format->date($licitacao->dataInicio, true) ?></td>
                                            <td style="width: 15%"><?= $this->Format->date($licitacao->dataTermino, true) ?></td>
                                            <td><?= $licitacao->ativado ?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                <?php if ($this->Membership->handleRole("editar_licitacao")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'edit', $licitacao->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_licitacao")): ?>
                                                    <button type="button" onclick="excluirLicitacao(<?= $licitacao->id ?>, '<?= $licitacao->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_licitacao")): ?>
                                <h3>Nenhuma licitação encontrada. Para adicionar nova licitação, <?=$this->Html->link("clique aqui", ["controller" => "licitacoes", "action" => "add"])?>.</h3>
                            <?php else:?>
                                <h3>Nenhuma licitação encontrada.</h3>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                                <?=$this->element('pagination', $opcao_paginacao) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>