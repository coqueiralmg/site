<?= $this->Html->script('controller/faq.lista.js', ['block' => 'scriptBottom']) ?>
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
                            'message' => 'Ocorreu um erro ao buscar as publicações',
                            'details' => ''
                        ]) ?>
                        <h4 class="card-title">Buscar</h4>

                        <?php
                        echo $this->Form->create("Faq", [
                            "url" => [
                                "controller" => "faq",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("questao", "Questão") ?>
                                        <?= $this->Form->text("questao", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("categoria", "Categoria") ?>
                                        <?=$this->Form->select('categoria', $combo_categorias, ['class' => 'form-control', 'empty' => 'Todas as categorias'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                            <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <?php if ($this->Membership->handleRole("adicionar_perguntas")): ?>
                                <a href="<?= $this->Url->build(['controller' => 'faq', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                            <?php endif; ?>
                            <a href="<?= $this->Url->build(['controller' => 'faq', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                         <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($perguntas) > 0):?>
                            <h4 class="card-title">Lista de Publicações</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Questão</th>
                                        <th>Categoria</th>
                                        <th class="text-right">Visualizações</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($perguntas as $pergunta): ?>
                                        <tr>
                                            <td><?=$pergunta->questao?></td>
                                            <td><?=$pergunta->categoria->nome?></td>
                                            <td class="text-right"><?=$pergunta->visualizacoes ?></td>
                                            <td><?=$pergunta->ativado ?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                <?php if ($this->Membership->handleRole("editar_perguntas")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'faq', 'action' => 'edit', $pergunta->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_perguntas")): ?>
                                                    <button type="button" onclick="excluirPergunta(<?= $pergunta->id ?>, '<?= $pergunta->questao ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_perguntas")): ?>
                                <h3>Nenhuma pergunta encontrada. Para adicionar nova pergunta, <?=$this->Html->link("clique aqui", ["controller" => "faq", "action" => "add"])?>.</h3>
                            <?php else:?>
                                <h3>Nenhuma pergunta encontrada.</h3>
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
