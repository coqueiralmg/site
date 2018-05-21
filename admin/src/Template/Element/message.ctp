<?php

$class = '';
$icon = '';

switch($type)
{
    case 'info':
        $class = 'alert alert-info alert-with-icon';
        $icon = 'info_outline';
        break;

    case 'error':
        $class = 'alert alert-danger alert-with-icon';
        $icon = 'error';
        break;

    case 'success':
        $class = 'alert alert-success alert-with-icon';
        $icon = 'thumb_up';
        break;

    case 'warning':
        $class = 'alert alert-warning alert-with-icon';
        $icon = 'warning';
        break;
}

?>
<div id="<?=$name?>" class="<?=$class?>" data-notify="container" style="display: none">
    <i class="material-icons" data-notify="icon"><?=$icon?></i>

    <?php if(isset($restore) && $restore == true): ?>
        <button type="button" aria-hidden="true" rel="tooltip" title="Descartar" class="close" onclick="$(this).parent().hide(); cancelarRestauracao()" style="cursor: pointer; padding: 3px">
            <i class="material-icons">close</i>
        </button>
        <button type="button" aria-hidden="true" rel="tooltip" title="Restaurar" class="close" onclick="$(this).parent().hide(); restaurar()" style="cursor: pointer; padding: 3px">
            <i class="material-icons">unarchive</i>
        </button>
    <?php else: ?>
        <button type="button" aria-hidden="true" rel="tooltip" title="Fechar" class="close" onclick="$(this).parent().hide()" style="cursor: pointer;">
            <i class="material-icons">close</i>
        </button>
    <?php endif; ?>
    <?php if(isset($details)): ?>
        <span data-notify="message">
            <?= h($message) ?>
            &nbsp;&nbsp;&nbsp;&nbsp;<a style="cursor: pointer;" onclick="$('#details').toggle('blind');">Detalhes</a>
        </span>
        <div id="details" class="detalhes">
            <?= h($details) ?>
        </div>
    <?php else: ?>
        <span data-notify="message">
            <?= h($message) ?>
        </span>
    <?php endif; ?>
</div>
