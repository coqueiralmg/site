<?= $this->Html->script('controller/ouvidoria.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Buscar</h4>
                        
                        <?php
                        echo $this->Form->create("Ouvidoria", [
                            "url" => [
                                "controller" => "ouvidoria",
                                "action" => "manifestantes"
                            ],
                            'type' => 'get',
                            "role" => "form"]);
                        ?>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("nome", "Nome") ?>
                                        <?= $this->Form->text("nome", ["id" => "nome", "class" => "form-control"]) ?>
                                        <span class="material-input"></span></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-group-min">
                                        <?= $this->Form->label("exibir", "Exibir") ?> <br/>
                                        <?=$this->Form->select('exibir', $combo_mostra, ['empty' => 'Todos', 'class' => 'form-control'])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                            <button type="submit" onclick="return validar()" class="btn btn-fill btn-success pull-right">Buscar<div class="ripple-container"></div></button>
                            <a href="<?= $this->Url->build(['controller' => 'Ouvidoria', 'action' => 'imprimir', '?' => $data]) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                            </div>
                         <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($manifestantes) > 0):?>
                            <h4 class="card-title">Consulta de Manifestações</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>Bloqueado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($manifestantes as $manifestante): ?>
                                        <tr>
                                            <td><?=$manifestante->nome?></td>
                                            <td><?=$manifestante->email?></td>
                                            <td><?=$manifestante->telefone?></td>
                                            <td><?=$manifestante->impedido?></td>
                                            <td class="td-actions text-right" style="width: 8%">
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Nenhuma manifestante encontrado.</h3>
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