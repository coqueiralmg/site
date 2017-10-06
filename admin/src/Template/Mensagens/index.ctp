<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                         <?= $this->Flash->render() ?>
                        <a href="<?= $this->Url->build(['controller' => 'Mensagens', 'action' => 'escrever']) ?>" class="btn btn-warning btn-default pull-right">Escrever<div class="ripple-container"></div></a>
                        <a href="<?= $this->Url->build(['controller' => 'Mensagens', 'action' => 'enviados']) ?>" class="btn btn-fill btn-default pull-right">Ver Enviados<div class="ripple-container"></div></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <?php if(count($mensagens) > 0):?>
                            <h4 class="card-title">Caixa de Entrada de Mensagens</h4>
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Rementente</th>
                                        <th>Assunto</th>
                                        <th>Data</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mensagens as $mensagem): ?>
                                        <tr style="font-weight: <?= ($mensagem->lido) ? 'lighter' : 'bold' ?>">
                                            <td><?= ($mensagem->rementente == null) ? '<i>Mensagem do Sistema</i>' : $mensagem->rementente->pessoa->nome ?></td>
                                            <td><?= $mensagem->assunto ?> </td>
                                            <td><?= $this->Format->date($mensagem->data, true) ?></td>
                                            <td  class="td-actions text-right" style="width: 10%">
                                                <a href="<?= $this->Url->build(['controller' => 'mensagens', 'action' => 'mensagem', $mensagem->id]) ?>" class="btn btn-info btn-round">
                                                    <i class="material-icons">pageview</i>
                                                </a>
                                                <button type="button" onclick="excluirRegistro('<?= $mensagem->id ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Não há mensagens na sua caixa de entrada.</h3>
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