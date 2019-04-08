<div class="item col-md-12 col-lg-6">
    <h3 class="media-heading" style="text-transform: uppercase;"><?= $publicacao->titulo ?></h3>
    <p><?= $publicacao->resumo ?></p>
    <?= $this->Html->link('Detalhes', ['controller' => 'legislacao', 'action' =>  'documento', $publicacao->id], ['class' => 'btn btn-success']) ?>
</div>
