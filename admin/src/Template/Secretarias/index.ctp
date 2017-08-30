<?= $this->Html->script('controller/secretarias.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php if ($this->Membership->handleRole("adicionar_secretaria")): ?>
                            <a href="<?= $this->Url->build(['controller' => 'Secretarias', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                        <?php endif; ?>
                        <a href="<?= $this->Url->build(['controller' => 'Secretarias', 'action' => 'imprimir']) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                    <?php if(count($secretarias) > 0):?>
                        <h4 class="card-title">Secretarias</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>Nome</th>
                                    <th>Responsável</th>
                                    <th>Ativo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($secretarias as $secretaria): ?>
                                    <tr>
                                        <td><?=$secretaria->nome?></td>
                                        <td><?=$secretaria->responsavel?></td>
                                        <td><?=$secretaria->ativado?></td>
                                        <td class="td-actions text-right">
                                            <?php if ($this->Membership->handleRole("editar_secretaria")): ?>
                                                <a href="<?= $this->Url->build(['controller' => 'Publicacoes', 'action' => 'edit', $secretaria->id]) ?>" class="btn btn-primary btn-round">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($this->Membership->handleRole("excluir_secretaria")): ?>
                                                <button type="button" onclick="excluirSecretaria(<?= $secretaria->id ?>, '<?= $secretaria->nome ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <?php if ($this->Membership->handleRole("adicionar_usuario")): ?>
                            <h3>Nenhuma secretaria encontrada. Para adicionar nova secretaria, <?=$this->Html->link("clique aqui", ["controller" => "secretarias", "action" => "add"])?>.</h3>
                        <?php else:?>
                            <h3>Nenhuma secretaria encontrada.</h3>
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