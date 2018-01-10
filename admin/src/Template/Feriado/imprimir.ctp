<?php if($qtd_total > 0):?>
    <h4 class="card-title">Feriados do Ano <?=$ano?></h4>
    <table class="table table-striped">
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
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> itens</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhum item encontrado.</h3>
<?php endif; ?>

    