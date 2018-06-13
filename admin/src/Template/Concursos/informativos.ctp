<?= $this->Html->script('controller/concursos.informativos.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->element('mnconcursos') ?>
                        <hr clear="all"/>
                    </div>
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <div class="form-group form-button">
                            <a href="<?= $this->Url->build(['controller' => 'Concursos', 'action' => 'informativo', 0, '?' => ['idConcurso' => $id]]) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if($qtd_total > 0):?>
                            <h4 class="card-title"><?=$subtitle?></h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Data</th>
                                        <th>Título</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($informativos as $informativo): ?>
                                        <tr>
                                            <td><?=$this->Format->date($informativo->data)?></td>
                                            <td><?=$informativo->titulo?></td>
                                            <td><?=$informativo->ativado?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("editar_concurso")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Concursos', 'action' => 'informativo', $informativo->id, '?' => ['idConcurso' => $id]]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_concurso")): ?>
                                                    <button type="button" onclick="excluirCargoConcurso(<?= $informativo->id ?>, '<?= $informativo->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Não existem informativos relativos a <?= $concurso->tipo == 'CP' ? 'concurso público' : 'processo seletivo' ?> <?= $concurso->numero ?> - <?= $concurso->titulo ?>. Para adicionar o novo informativo, <?=$this->Html->link("clique aqui", ["controller" => "concursos", "action" => "informativo", 0, '?' => ['idConcurso' => $id]])?>.</h3>
                        <?php endif; ?>
                    </div>
                     <div class="card-content">
                        <div class="material-datatables">
                            <div class="row">
                               <?=$this->element('pagination') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
