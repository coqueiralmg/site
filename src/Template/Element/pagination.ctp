<?php
$opcao_paginacao_number = ['tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'modulus' => 6];
$opcao_paginacao_extra = ['tag' => 'li', 'disabledTag' => 'a'];

if(!isset($limit_pagination))
{
    $limit_pagination = Cake\Core\Configure::read('limitPagination');
}

if (!isset($name))
{
    $name = 'itens';
}

if (!isset($name_singular))
{
    $name_singular = 'item';
}

if (!isset($predicate))
{
    $predicate = 'encontrados';
}

if (!isset($singular))
{
    $singular = 'encontrado';
}
?>
<div class="row">
    <center>
        <?php if ($qtd_total > 0): ?>
            <p class="registros">
                <span class="pagination-info"><?= $qtd_total . " " . (($qtd_total == 1) ? $name_singular : $name) . " " . (($qtd_total == 1) ? $singular : $predicate) ?></span>
            </p>
            
            <?php if ($qtd_total > $limit_pagination): ?>
                <div class="paginacao">
                    <ul class="pagination">
                        <?php if(($qtd_total / $limit_pagination) > 7): ?>
                            <?= $this->Paginator->first('Início', $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                        <?= $this->Paginator->prev('Anterior', $opcao_paginacao_extra) ?>
                        <?= $this->Paginator->numbers($opcao_paginacao_number) ?>
                        <?= $this->Paginator->next('Próximo', $opcao_paginacao_extra) ?>
                        <?php if(($qtd_total / $limit_pagination) > 7): ?>
                            <?= $this->Paginator->last('Final', $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </center>
</div>
