<?= $this->Html->script('controller/feriado.lista.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <h4 class="card-title">Importar </h4>
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
                                        <?= $this->Form->label("mostrar", "Ano Origem") ?> <br/>
                                        <?=$this->Form->year('ano', ['minYear' => 1949, 'maxYear' => date('Y') + 10, 'orderYear' => 'asc', 'empty' => false, 'value' => $ano])?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-button">
                                <button type="submit" class="btn btn-fill btn-info pull-right">Buscar<div class="ripple-container"></div></button>
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
                                        <th></th>
                                        <th>Data</th>
                                        <th>Dia de Semana</th>
                                        <th>Descrição</th>
                                        <th>Tipo</th>
                                        <th>Ponto Facultativo</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($feriados as $feriado): ?>
                                        <tr>
                                            <td></td>
                                            <td><?=$this->Format->date($feriado->data)?></td>
                                            <td><?=$this->Format->dayWeek($feriado->data)?></td>
                                            <td><?=$feriado->descricao?></td>
                                            <td><?=$feriado->tipo?></td>
                                            <td><?=$feriado->opcional?></td>
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