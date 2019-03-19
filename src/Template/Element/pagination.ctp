<?php
$opcao_paginacao_number = ['tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'modulus' => ($movel) ? $this->Data->setting('Pagination.short.modulus') : $this->Data->setting('Pagination.modulus')];
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

$visiblePages = ($movel) ? $this->Data->setting('Pagination.short.visiblePages') : $this->Data->setting('Pagination.visiblePages');

$texto = [
    'first' => ($movel) ? '<<' : 'Início',
    'prev' => ($movel) ? '<' : 'Anterior',
    'next' => ($movel) ? '>' : 'Próximo',
    'last' => ($movel) ? '>>' : 'Fim'
];
?>
<div class="row">
    <center>
        <?php if ($qtd_total > 0): ?>
            <p class="registros">
                <span class="pagination-info"><?= number_format($qtd_total, 0, ',', '.') . " " . (($qtd_total == 1) ? $name_singular : $name) . " " . (($qtd_total == 1) ? $singular : $predicate) ?></span>
            </p>

            <?php if ($qtd_total > $limit_pagination): ?>
                <div class="paginacao">
                    <ul class="pagination">
                        <?php if(($qtd_total / $limit_pagination) > $visiblePages): ?>
                            <?= $this->Paginator->first($texto['first'], $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                        <?php if($this->Paginator->current() != 1): ?>
                            <?= $this->Paginator->prev($texto['prev'], $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                        <?= $this->Paginator->numbers($opcao_paginacao_number) ?>
                        <?php if($this->Paginator->current() != $this->Paginator->total()): ?>
                            <?= $this->Paginator->next($texto['next'], $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                        <?php if(($qtd_total / $limit_pagination) > $visiblePages): ?>
                            <?= $this->Paginator->last($texto['last'], $opcao_paginacao_extra) ?>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </center>
</div>
