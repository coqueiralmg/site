<?php if($qtd_total > 0):?>
    <h4 class="card-title">Categorias de Perguntas e Respostas</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Nome</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?=$categoria->nome?></td>
                    <td><?= $categoria->ativado ?></td>
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
    <h3>Nenhuma categoria encontrada.</h3>
<?php endif; ?>
