<?php if($qtd_total > 0):?>
    <h4 class="card-title">Lista de licitações</h4>
    <table class="table table-striped">
        <thead class="text-primary">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Data da Postagem</th>
                <th>Data da Alteração</th>
                <th>Visto</th>
                <th>Destaque</th>
                <th>Ativo</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($noticias as $noticia): ?>
                <tr>
                    <td><?= $noticia->post->titulo ?></td>
                    <td style="width: 15%"><?= $noticia->post->autor->pessoa->nome ?></td>
                    <td style="width: 14%"><?= $this->Format->date($noticia->post->dataPostagem) ?></td>
                    <td style="width: 14%"><?= $this->Format->date($noticia->post->dataAlteracao) ?></td>
                    <td><?= $noticia->post->visualizacoes ?></td>
                    <td><?= $noticia->post->destacado ?></td>
                    <td><?= $noticia->post->ativado ?></td>
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
    <h3>Nenhuma licitação encontrada.</h3>
<?php endif; ?>

    