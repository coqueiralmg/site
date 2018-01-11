<?= $this->Html->script('controller/feriado.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Buscar</h4>
                        <?php
                        echo $this->Form->create("Feriado", [
                            "url" => [
                                "controller" => "feriado",
                                "action" => "index"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("mostrar", "Ano") ?> <br/>
                                        <?=$this->Form->year('ano', ['minYear' => 1949, 'maxYear' => date('Y') + 10, 'orderYear' => 'asc', 'empty' => false, 'value' => $ano])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                                <?php if ($this->Membership->handleRole("adicionar_ips_firewall")): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Feriado', 'action' => 'add']) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                                <?php endif; ?>
                                <a href="<?= $this->Url->build(['controller' => 'Feriado', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if($qtd_total > 0):?>
                            <h4 class="card-title">Feriados do Ano <?=$ano?></h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Data</th>
                                        <th>Dia de Semana</th>
                                        <th>Descrição</th>
                                        <th>Tipo</th>
                                        <th>Ponto Facultativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($feriados as $feriado): ?>
                                        <tr>
                                            <td><?=$this->Format->date($feriado->data)?></td>
                                            <td><?=$this->Format->dayWeek($feriado->data)?></td>
                                            <td><?=$feriado->descricao?></td>
                                            <td><?=$feriado->tipo?></td>
                                            <td><?=$feriado->opcional?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("editar_feriados")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Feriado', 'action' => 'edit', $feriado->id]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_feriados")): ?>
                                                    <button type="button" onclick="excluirFeriado(<?= $feriado->id ?>, '<?= $feriado->descricao ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>   
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Nenhum item encontrado.</h3>
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