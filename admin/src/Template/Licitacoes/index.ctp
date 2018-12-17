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
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("numprocesso", "Número do Processo") ?>
                                        <?= $this->Form->text("numprocesso", ["id" => "numprocesso", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("modalidade", "Modalidade") ?>
                                        <?= $this->Form->select("modalidade", $combo_modalidade, ["id" => "modalidade", "class" => "form-control", "empty" => "Todos"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("status", "Status") ?>
                                        <?= $this->Form->select("status", $combo_status, ["id" => "status", "class" => "form-control", "empty" => "Todos"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_publicacao_inicial", "Data Publicação Inicial") ?>
                                        <?= $this->Form->text("data_publicacao_inicial", ["id" => "data_publicacao_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_publicacao_final", "Data Publicação Final") ?>
                                        <?= $this->Form->text("data_publicacao_final", ["id" => "data_publicacao_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_sessao_inicial", "Data Sessão Inicial") ?>
                                        <?= $this->Form->text("data_sessao_inicial", ["id" => "data_sessao_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_sessao_final", "Data Sessão Final") ?>
                                        <?= $this->Form->text("data_sessao_final", ["id" => "data_sessao_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("formato", "Formatos") ?> <br/>
                                        <?=$this->Form->select('formato', $combo_formatos, ['class' => 'form-control'])?>
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
                                    <?php if($formato_exibicao == 'T'): ?>
                                        <tr>
                                            <th>Número</th>
                                            <th>Título</th>
                                            <th>Data Sessão</th>
                                            <th>Ativo</th>
                                            <th></th>
                                        </tr>
                                    <?php elseif($formato_exibicao == 'A'): ?>
                                        <tr>
                                            <th>Título</th>
                                            <th>Data Início</th>
                                            <th>Data Término</th>
                                            <th>Ativo</th>
                                            <th></th>
                                        </tr>
                                    <?php elseif($formato_exibicao == 'N'): ?>
                                        <tr>
                                            <th>Número</th>
                                            <th>Modalidade</th>
                                            <th>Título</th>
                                            <th>Visualizações</th>
                                            <th>Data Sessão</th>
                                            <th>Ativo</th>
                                            <th></th>
                                        </tr>
                                    <?php endif;?>
                                </thead>
                                <tbody>
                                    <?php foreach ($licitacoes as $licitacao): ?>
                                        <?php if($formato_exibicao == 'T'): ?>
                                            <tr>
                                                <td><?=$licitacao->numprocesso == null ? ' - ' : $this->Format->zeroPad($licitacao->numprocesso, 3) . '/' . $licitacao->ano ?></td>
                                                <td><?=$licitacao->titulo ?></td>
                                                <td style="width: 15%"><?= ($licitacao->antigo) ? $this->Format->date($licitacao->dataInicio, true) : $this->Format->date($licitacao->dataSessao, true) ?></td>
                                                <td><?= $licitacao->ativado ?></td>
                                                <td class="td-actions text-right" style="width: 8%">
                                                    <?php if ($this->Membership->handleRole("editar_licitacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'edit', $licitacao->id]) ?>" class="btn btn-primary btn-round">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("excluir_licitacao")): ?>
                                                        <button type="button" onclick="excluirLicitacao(<?= $licitacao->id ?>, '<?= $licitacao->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php elseif($formato_exibicao == 'A'): ?>
                                            <tr>
                                                <td><?= $licitacao->titulo ?></td>
                                                <td style="width: 15%"><?= $this->Format->date($licitacao->dataInicio, true) ?></td>
                                                <td style="width: 15%"><?= $this->Format->date($licitacao->dataTermino, true) ?></td>
                                                <td><?= $licitacao->ativado ?></td>
                                                <td class="td-actions text-right" style="width: 12%">
                                                    <?php if ($this->Membership->handleRole("editar_licitacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'edit', $licitacao->id]) ?>" class="btn btn-primary btn-round">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("migrar_licitacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'migracao', $licitacao->id]) ?>" class="btn btn-rose btn-round">
                                                            <i class="material-icons">unarchive</i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("excluir_licitacao")): ?>
                                                        <button type="button" onclick="excluirLicitacao(<?= $licitacao->id ?>, '<?= $licitacao->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php elseif($formato_exibicao == 'N'): ?>
                                            <tr>
                                                <td><?=$licitacao->numprocesso == null ? ' - ' : $this->Format->zeroPad($licitacao->numprocesso, 3) . '/' . $licitacao->ano ?></td>
                                                <td><?=$licitacao->modalidade->nome ?></td>
                                                <td><?=$licitacao->titulo ?></td>
                                                <td><?=$licitacao->visualizacoes ?></td>
                                                <td style="width: 15%"><?= ($licitacao->antigo) ? $this->Format->date($licitacao->dataInicio, true) : $this->Format->date($licitacao->dataSessao, true) ?></td>
                                                <td><?= $licitacao->ativado ?></td>
                                                <td class="td-actions text-right" style="width: 8%">
                                                    <?php if ($this->Membership->handleRole("editar_licitacao")): ?>
                                                        <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'edit', $licitacao->id]) ?>" class="btn btn-primary btn-round">
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if ($this->Membership->handleRole("excluir_licitacao")): ?>
                                                        <button type="button" onclick="excluirLicitacao(<?= $licitacao->id ?>, '<?= $licitacao->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endif;?>
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
