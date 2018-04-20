<?php if($qtd_total > 0):?>
    <h4 class="card-title">Legislação Municipal</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Número</th>
                <th>Título</th>
                <th>Data</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($legislacao as $item): ?>
                <tr>
                    <td><?=$item->numero?></td>
                    <td><?=$item->titulo?></td>
                    <td><?= $this->Format->date($item->data) ?></td>
                    <td><?= $item->ativado ?></td>
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
    <h3>Nenhuma item encontrado.</h3>
<?php endif; ?>

