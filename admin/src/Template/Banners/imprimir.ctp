<?php if($qtd_total > 0):?>
    <h4 class="card-title">Lista de Banners da Página Inicial</h4>
    <table class="table  table-striped">
        <thead class="text-primary">
            <tr>
                <th style="width: 15%"></th>
                <th>Nome</th>
                <th>Título/Descrição</th>
                <th>Destino</th>
                <th>Ordem</th>
                <th>Validade</th>
                <th>Ativo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($banners as $banner): ?>
                <tr>
                    <td>
                        <img src="<?=$this->Url->build('/../' . $banner->imagem)?>" style="height: 75px; width: auto" class="img-rounded img-responsive img-raised">
                    </td>
                    <td class="td-name">
                        <?=$banner->nome?>
                    </td>
                    <td class="td-name">
                        <?=$banner->titulo?><br/>
                        <small><?=$banner->descricao?></small>
                    </td>
                    <td class="td-name">
                        <?=$banner->destino?>
                    </td>
                    <td>
                        <?=$banner->ordem?>
                    </td>
                    <td>
                        <?=$this->Format->date($banner->validade)?>
                    </td>
                    <td>
                        <?=$banner->ativado?>
                    </td>
                </tr>   
            <?php endforeach; ?>
        </tbody>
    </table>

    </div>
        <div class="material-datatables">
            <div class="row">
                <div class="col-sm-5">
                    <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> itens</div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <h3>Nenhum banner encontrado.</h3>
<?php endif; ?>
    