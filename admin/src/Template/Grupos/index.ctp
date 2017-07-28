<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <a href="<?= $this->Url->build(['controller' => 'Grupos', 'action' => 'add']) ?>" class="btn btn-fill btn-warning pull-right">Novo<div class="ripple-container"></div></a>
                        <a href="<?= $this->Url->build(['controller' => 'Grupos', 'action' => 'imprimir']) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Lista de Grupos de Usuários</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th style="width: 70%">Nome</th>
                                    <th>Ativo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($grupos as $grupo): ?>
                                    <tr>
                                        <td><?= $grupo->nome ?></td>
                                        <td><?= $grupo->ativado ?></td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" class="btn btn-primary btn-round" title="">
                                                <i class="material-icons">edit</i>
                                            </button>
                                            <button type="button" rel="tooltip" class="btn btn-danger btn-round" title="">
                                                <i class="material-icons">close</i>
                                            </button>
                                        </td>
                                    </tr>   
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
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