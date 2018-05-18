<?= $this->Html->script('controller/concursos.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Buscar</h4>
                        <?php
                        echo $this->Form->create("Concursos", [
                            "url" => [
                                "controller" => "concursos",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("numero", "Número") ?>
                                        <?= $this->Form->text("numero", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("banca", "Banca") ?>
                                        <?= $this->Form->text("banca", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("tipo", "Tipo de Concurso") ?>
                                        <?=$this->Form->select('tipo', $tipo_concurso, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("inscricao_inicial", "Data de Inscrição Inicial") ?>
                                        <?= $this->Form->text("inscricao_inicial", ["id" => "inscricao_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("inscricao_final", "Data de Inscrição Final") ?>
                                        <?= $this->Form->text("inscricao_final", ["id" => "inscricao_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("prova_inicial", "Data da Prova Inicial") ?>
                                        <?= $this->Form->text("prova_inicial", ["id" => "prova_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("prova_final", "Data da Prova Final") ?>
                                        <?= $this->Form->text("prova_final", ["id" => "prova_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $status_concurso, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("adicionar_concurso")): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Concursos', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <a href="<?= $this->Url->build(['controller' => 'Concursos', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if($qtd_total > 0):?>
                            <h4 class="card-title">Lista de Concursos Públicos e Processos Seletivos</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Número</th>
                                        <th>Descrição</th>
                                        <th>Período de Inscrição</th>
                                        <th>Data da Prova</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($concursos as $concurso): ?>
                                        <tr>
                                            <td><?=$concurso->numero?></td>
                                            <td><?=$concurso->titulo?></td>
                                            <td><?=$this->Format->date($concurso->inscricaoInicio)?> à <?=$this->Format->date($concurso->inscricaoFim)?></td>
                                            <td><?=$this->Format->date($concurso->dataProva)?></td>
                                            <td><?=$concurso->status->nome?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("editar_concurso")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Concursos', 'action' => 'edit', $concurso->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_concurso")): ?>
                                                    <button type="button" onclick="excluirConcurso(<?= $concurso->id ?>, '<?= $concurso->numero ?>', '<?= $concurso->titulo ?>', '<?= $concurso->tipo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_concurso")): ?>
                                <h3>Nenhum item encontrado. Para cadastrar um novo concurso público ou processo seletivo, <?=$this->Html->link("clique aqui", ["controller" => "concursos", "action" => "add"])?>.</h3>
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
