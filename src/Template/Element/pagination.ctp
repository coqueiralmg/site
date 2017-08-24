<?php
$opcao_paginacao_number = ['tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'modulus' => $this->Data->setting('Pagination.modulus')];
$opcao_paginacao_extra = ['tag' => 'li', 'disabledTag' => 'a'];

if(!isset($limit_pagination))
{
    $limit_pagination = $this->Data->setting('Pagination.limit');
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
                        <?php if(($qtd_total / $limit_pagination) > $this->Data->setting('Pagination.visiblePages')): ?>
                            <?= $this->Paginator->first('Início', $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                        <?= $this->Paginator->prev('Anterior', $opcao_paginacao_extra) ?>
                        <?= $this->Paginator->numbers($opcao_paginacao_number) ?>
                        <?= $this->Paginator->next('Próximo', $opcao_paginacao_extra) ?>
                        <?php if(($qtd_total / $limit_pagination) > $this->Data->setting('Pagination.visiblePages')): ?>
                            <?= $this->Paginator->last('Final', $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </center>
</div>
