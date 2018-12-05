<?php if($qtd_total > 0):?>
    <h4 class="card-title">Lista de licitações</h4>
    <table class="table table-striped">
        <thead class="text-primary">
           <?php if($formato_exibicao == 'T'): ?>
                <tr>
                    <th>Número</th>
                    <th>Título</th>
                    <th>Data Sessão</th>
                    <th>Ativo</th>
                    <th></th>
                </tr>
            <?php elseif($formato_exibicao == 'A'): ?>
                <tr>
                    <th>Título</th>
                    <th>Data Início</th>
                    <th>Data Término</th>
                    <th>Ativo</th>
                    <th></th>
                </tr>
            <?php elseif($formato_exibicao == 'N'): ?>
                <tr>
                    <th>Número</th>
                    <th>Título</th>
                    <th>Visualizações</th>
                    <th>Data Sessão</th>
                    <th>Ativo</th>
                    <th></th>
                </tr>
            <?php endif;?>
        </thead>
        <tbody>
            <?php foreach ($licitacoes as $licitacao): ?>
                <?php if($formato_exibicao == 'T'): ?>
                    <tr>
                        <td><?=$licitacao->numprocesso == null ? ' - ' : $this->Format->zeroPad($licitacao->numprocesso, 3) . '/' . $licitacao->ano ?></td>
                        <td><?=$licitacao->titulo ?></td>
                        <td style="width: 20%"><?= ($licitacao->antigo) ? $this->Format->date($licitacao->dataInicio, true) : $this->Format->date($licitacao->dataSessao, true) ?></td>
                        <td><?= $licitacao->ativado ?></td>
                    </tr>
                <?php elseif($formato_exibicao == 'A'): ?>
                    <tr>
                        <td><?= $licitacao->titulo ?></td>
                        <td style="width: 20%"><?= $this->Format->date($licitacao->dataInicio, true) ?></td>
                        <td style="width: 20%"><?= $this->Format->date($licitacao->dataTermino, true) ?></td>
                        <td><?= $licitacao->ativado ?></td>
                    </tr>
                <?php elseif($formato_exibicao == 'N'): ?>
                    <tr>
                        <td><?=$licitacao->numprocesso == null ? ' - ' : $this->Format->zeroPad($licitacao->numprocesso, 3) . '/' . $licitacao->ano ?></td>
                        <td><?=$licitacao->titulo ?></td>
                        <td><?=$licitacao->visualizacoes ?></td>
                        <td style="width: 20%"><?= ($licitacao->antigo) ? $this->Format->date($licitacao->dataInicio, true) : $this->Format->date($licitacao->dataSessao, true) ?></td>
                        <td><?= $licitacao->ativado ?></td>
                    </tr>
                <?php endif;?>

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

