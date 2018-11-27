<?= $this->Html->script('controller/licitacoes.informativos.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?= $this->element('mnlicitacoes') ?>
                        <hr clear="all"/>
                    </div>
                    <div class="card-content">
                        <?= $this->Flash->render() ?>
                        <div class="form-group form-button">
                            <a href="<?= $this->Url->build(['controller' => 'licitacoes', 'action' => 'informativo', 0, '?' => ['idLicitacao' => $id]]) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/licitacoes') ?>'" class="btn btn-info pull-right">Voltar</button>
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
                                    <?php foreach ($atualizacoes as $atualizacao): ?>
                                        <tr>
                                            <td><?=$this->Format->date($atualizacao->data, true)?></td>
                                            <td><?=$atualizacao->titulo?></td>
                                            <td><?=$atualizacao->ativado?></td>
                                            <td class="td-actions text-right">
                                            <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'informativo', $atualizacao->id, '?' => ['idLicitacao' => $id]]) ?>" class="btn btn-primary btn-round">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button type="button" onclick="excluirInformativoLicitacao(<?= $atualizacao->id ?>, '<?= $atualizacao->titulo ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Não existem informativos, extratos ou atualizações relativos a processo licitatório <b><?=$this->Format->zeroPad($licitacao->numprocesso, 0)?>/<?=$licitacao->ano?></b> da modalidade <b><?=$licitacao->modalidade->nome?></b>, sob o assunto <b><?=$licitacao->titulo?></b>.
                                Para adicionar o novo informativo, <?=$this->Html->link("clique aqui", ["controller" => "licitacoes", "action" => "informativo", 0, '?' => ['idLicitacao' => $id]])?>.</h3>
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
