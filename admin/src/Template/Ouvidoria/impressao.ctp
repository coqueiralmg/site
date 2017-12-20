<?php if($qtd_total > 0):?>
    <h4 class="card-title">Manifestantes da ouvidoria</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Bloqueado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($manifestantes as $manifestante): ?>
                <tr>
                    <td><?=$manifestante->nome?></td>
                    <td><?=$manifestante->email?></td>
                    <td><?=$manifestante->telefone?></td>
                    <td><?=$manifestante->impedido?></td> 
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> manifestantes</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhum manifestante encontrado.</h3>
<?php endif; ?>

    