<?= $this->Html->script('controller/faq.categorias.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                         <?= $this->Flash->render() ?>
                        <div class="form-group form-button">
                        <?php if ($this->Membership->handleRole("adicionar_categorias_perguntas")): ?>
                            <a href="<?= $this->Url->build(['controller' => 'faq', 'action' => 'insert']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                        <?php endif; ?>
                        <a href="<?= $this->Url->build(['controller' => 'faq', 'action' => 'lista']) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($categorias) > 0):?>
                            <h4 class="card-title">Lista de Categorias</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categorias as $categoria): ?>
                                        <tr>
                                            <td><?=$categoria->nome?></td>
                                            <td><?= $categoria->ativado ?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                <?php if ($this->Membership->handleRole("editar_categorias_perguntas")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'faq', 'action' => 'editar', $categoria->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_categorias_perguntas")): ?>
                                                    <button type="button" onclick="excluirCategoriaPergunta(<?= $categoria->id ?>, '<?= $categoria->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_categorias_perguntas")): ?>
                                <h3>Nenhum item encontrado. Para adicionar a nova categoria de perguntas, <?=$this->Html->link("clique aqui", ["controller" => "faq", "action" => "insert"])?>.</h3>
                            <?php else:?>
                                <h3>Nenhum item encontrado.</h3>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                               <?=$this->element('pagination') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
