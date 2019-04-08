<div class="item col-md-12 col-lg-6">
    <h3 class="media-heading" style="text-transform: uppercase;"><?= $concurso->numero ?> - <?= $concurso->titulo ?></h3>
    <p style="font-weight: bold"><?= $concurso->situacao ?></p>
    <p>Inscrições: <?= $this->Format->date($concurso->inscricaoInicio) ?> à <?= $this->Format->date($concurso->inscricaoFim) ?></p>
    <p>Data da Prova: <?= $this->Format->date($concurso->dataProva) ?></p>
    <?= $this->Html->link('Detalhes', ['controller' => 'concursos', 'action' =>  'concurso', $concurso->slug . '-' . $concurso->id], ['class' => 'btn btn-success']) ?>
</div>
