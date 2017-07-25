<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <a href="<?= $this->Url->build(['controller' => 'Log', 'action' => 'imprimir']) ?>" target="_blank" class="btn btn-fill btn-default pull-right">Imprimir<div class="ripple-container"></div></a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <h4 class="card-title">Log de Acesso ao Sistema</h4>
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>IP</th>
                                    <th>Data de Acesso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($log as $item): ?>
                                    <tr>
                                        <td><?= $item->ip ?></td>
                                        <td><?= date_format($item->data, 'd/m/Y H:i:s') ?></td>
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