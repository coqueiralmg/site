<?php if($qtd_total > 0):?>
    <h4 class="card-title">Lista de licitações</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Título</th>
                <th>Data Início</th>
                <th>Data Término</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($licitacoes as $licitacao): ?>
                <tr>
                    <td><?= $licitacao->titulo ?></td>
                    <td style="width: 20%"><?= $this->Format->date($licitacao->dataInicio, true) ?></td>
                    <td style="width: 20%"><?= $this->Format->date($licitacao->dataTermino, true) ?></td>
                    <td><?= $licitacao->ativado ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> licitações</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhuma licitação encontrada.</h3>
<?php endif; ?>

    