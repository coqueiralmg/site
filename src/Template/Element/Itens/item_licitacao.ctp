<div class="item col-md-12 col-lg-6">
    <h3 class="media-heading" style="text-transform: uppercase;">Processo: <?= $this->Format->zeroPad($licitacao->numprocesso, 3) ?>/<?= $licitacao->ano ?> - <?= $licitacao->titulo ?></h3>
    <span style="font-style: italic"><?= $licitacao->modalidade->nome ?></span> | <span style="font-weight: bold"><?= $licitacao->situacao ?></span>
    <?php if($licitacao->modalidade->chave == 'PP' ||
            $licitacao->modalidade->chave == 'TP' ||
            $licitacao->modalidade->chave == 'CO' ||
            ($licitacao->modalidade->chave == 'IN' && $licitacao->dataSessao != '') ||
            ($licitacao->modalidade->chave == 'DI' && $licitacao->dataSessao != '')):?>
        <p>Data da Sessão: <?= $this->Format->date($licitacao->dataSessao, true) ?></p>
    <?php elseif(($licitacao->modalidade->chave == 'DI' && $licitacao->dataSessao == '') ||
                 ($licitacao->modalidade->chave == 'IN' && $licitacao->dataSessao == '')):?>
        <p>Data da Publicação: <?= $this->Format->date($licitacao->dataPublicacao, true) ?></p>
    <?php else: ?>
        <p>Período de <?= $this->Format->date($licitacao->dataPublicacao, true) ?> até <?= $this->Format->date($licitacao->dataFim, true) ?></p>
    <?php endif;?>
    <?php if($licitacao->retificado): ?>
        <span style="font-weight:bold; font-style: italic;">Licitação retificada</span>
    <?php endif;?>
    <?= $this->Html->link('Detalhes', ['controller' => 'licitacoes', 'action' =>  'licitacao', $licitacao->slug . '-' . $licitacao->id], ['class' => 'btn btn-success']) ?>
</div>
