<?= $this->Html->script('controller/diarias.lista.js', ['block' => 'scriptBottom']) ?>
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
                        echo $this->Form->create("Diarias", [
                            "url" => [
                                "controller" => "diarias",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("beneficiario", "Beneficiário") ?> <br/>
                                        <?= $this->Form->text("beneficiario", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_inicial", "Data Inicial") ?> <br/>
                                        <?= $this->Form->text("data_inicial", ["id" => "data_inicial", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("data_final", "Data Final") ?> <br/>
                                        <?= $this->Form->text("data_final", ["id" => "data_final", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("destino", "Destino") ?> <br/>
                                        <?= $this->Form->text("destino", ["class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("placa", "Placa de Veículo") ?> <br/>
                                        <?= $this->Form->text("placa", ["id" => "placa", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Mostrar") ?> <br/>
                                        <?=$this->Form->select('mostrar', $combo_mostra, ['class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("adicionar_diaria")): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Diarias', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <a href="<?= $this->Url->build(['controller' => 'Diarias', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($diarias) > 0):?>
                            <h4 class="card-title">Relatórios de Diárias</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Beneficiário</th>
                                        <th>Destino</th>
                                        <th>Período Inicial</th>
                                        <th>Período Final</th>
                                        <th>Data de Autorização</th>
                                        <th>Valor</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($diarias as $diaria): ?>
                                        <tr>
                                            <td><?= $diaria->beneficiario ?></td>
                                            <td><?= $diaria->destino ?></td>
                                            <td><?= $this->Format->date($diaria->periodoInicio) ?></td>
                                            <td><?= $this->Format->date($diaria->periodoFim) ?></td>
                                            <td><?= $this->Format->date($diaria->dataAutorizacao) ?></td>
                                            <td>R$ <?= $this->Format->precision($diaria->valor, 2) ?></td>
                                            <td><?= $diaria->ativado ?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("editar_diaria")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Diarias', 'action' => 'edit', $diaria->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_diaria")): ?>
                                                    <button type="button" onclick="excluirRegistro(<?= $diaria->id ?>, '<?= $diaria->beneficiario ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <?php if ($this->Membership->handleRole("adicionar_diaria")): ?>
                                <h3>Nenhum item encontrado. Para adicionar um novo relatório de diárias, <?=$this->Html->link("clique aqui", ["controller" => "diarias", "action" => "add"])?>.</h3>
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
