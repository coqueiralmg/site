<?php if($qtd_total > 0):?>
    <h4 class="card-title">Relatórios de Diárias</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Beneficiário</th>
                <th>Destino</th>
                <th>Período Inicial</th>
                <th>Período Final</th>
                <th>Data de Autorização</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($diarias as $diaria): ?>
                <tr>
                    <td><?= $diaria->beneficiario ?></td>
                    <td><?= $diaria->destino ?></td>
                    <td><?= $this->Format->date($destino->periodoInicial) ?></td>
                    <td><?= $this->Format->date($destino->periodoFinal) ?></td>
                    <td><?= $this->Format->date($destino->dataAutorizacao) ?></td>
                    <td><?= $destino->ativado ?></td>
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

