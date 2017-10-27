<?php if($qtd_total > 0):?>
    <h4 class="card-title">Manifestações da ouvidoria</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Número</th>
                <th>Data</th>
                <th>Manifestante</th>
                <th>Assunto</th>
                <th>Status</th>
                <th>Prioridade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($manifestacoes as $manifestacao): ?>
                <tr>
                    <td><?=$this->Format->zeroPad($manifestacao->id)?></td>
                    <td><?=$this->Format->date($manifestacao->data, true)?></td>
                    <td><?=$manifestacao->manifestante->nome?></td>
                    <td><?=$manifestacao->assunto?></td>
                    <td><?=$manifestacao->status->nome?></td>
                    <td><?=$manifestacao->prioridade->nome?></td>   
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> manifestações</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhuma manifestação encontrada.</h3>
<?php endif; ?>

    