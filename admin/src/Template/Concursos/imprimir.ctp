<?php if($qtd_total > 0):?>
    <h4 class="card-title">Concursos Públicos e Processos Seletivos</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Número</th>
                <th>Descrição</th>
                <th>Período de Inscrição</th>
                <th>Data da Prova</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($concursos as $concurso): ?>
                <tr>
                    <td><?=$concurso->numero?></td>
                    <td><?=$concurso->titulo?></td>
                    <td><?=$this->Format->date($concurso->inscricaoInicio)?> à <?=$this->Format->date($concurso->inscricaoFim)?></td>
                    <td><?=$this->Format->date($concurso->dataProva)?></td>
                    <td><?=$concurso->status->nome?></td>
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

