<?php if($qtd_total > 0):?>
    <h4 class="card-title">Perguntas e Respostas</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Questão</th>
                <th>Categoria</th>
                <th class="text-right">Visualizações</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($perguntas as $pergunta): ?>
                <tr>
                    <td><?=$pergunta->questao?></td>
                    <td><?=$pergunta->categoria->nome?></td>
                    <td class="text-right"><?=$pergunta->visualizacoes ?></td>
                    <td><?=$pergunta->ativado ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="material-datatables">
        <div class="row">
            <div class="col-sm-5">
                <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> questões</div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhuma questão encontrada.</h3>
<?php endif; ?>
