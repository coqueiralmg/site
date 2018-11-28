<?= $this->Html->script('controller/licitacoes.anexos.js', ['block' => 'scriptBottom']) ?>
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
                            <a href="<?= $this->Url->build(['controller' => 'Licitacoes', 'action' => 'anexo', 0, '?' => ['idLicitacao' => $id]]) ?>" class="btn btn-warning btn-default pull-right">Novo<div class="ripple-container"></div></a>
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
                                        <th>Descrição</th>
                                        <th>Ativo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($anexos as $anexo): ?>
                                        <tr>
                                            <td><?=$this->Format->date($anexo->data)?></td>
                                            <td><?=$anexo->descricao?></td>
                                            <td><?=$anexo->ativado?></td>
                                            <td class="td-actions text-right">
                                                <?php if ($this->Membership->handleRole("editar_concurso")): ?>
                                                    <a href="<?= $this->Url->build(['controller' => 'Concursos', 'action' => 'anexo', $anexo->id, '?' => ['idLicitacao' => $id]]) ?>" class="btn btn-primary btn-round">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($this->Membership->handleRole("excluir_concurso")): ?>
                                                    <button type="button" onclick="excluirDocumentoConcurso(<?= $anexo->id ?>, '<?= $anexo->descricao ?>')" class="btn btn-danger btn-round"><i class="material-icons">close</i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h3>Não existem documentos e anexos relativos ao processo licitatório <b><?=$this->Format->zeroPad($licitacao->numprocesso, 0)?>/<?=$licitacao->ano?></b> da modalidade <b><?=$licitacao->modalidade->nome?></b>, sob o assunto <b><?=$licitacao->titulo?></b>.
                                Para adicionar o novo informativo, <?=$this->Html->link("clique aqui", ["controller" => "licitacoes", "action" => "anexo", 0, '?' => ['idLicitacao' => $id]])?>.</h3>
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
