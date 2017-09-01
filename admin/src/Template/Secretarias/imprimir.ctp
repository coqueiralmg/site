<?php if($qtd_total > 0):?>
    <h4 class="card-title">Lista de secretarias</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Nome</th>
                <th>Responsável</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($secretarias as $secretaria): ?>
                <tr>
                    <td><?=$secretaria->nome?></td>
                    <td><?=$secretaria->responsavel?></td>
                    <td><?=$this->Format->phone($secretaria->telefone)?></td>
                    <td><?=$secretaria->email?></td>
                    <td><?=$secretaria->ativado?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> secretarias</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhuma secretaria encontrada.</h3>
<?php endif; ?>

    