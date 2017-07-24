<div class="content">
    <div class="container-fluid">
        <div class="row">
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
                                <div class="col-sm-5">
                                    <div class="dataTables_paginate paging_full_numbers" id="datatables_info">5 itens encontrados</div>
                                </div>
                                <div class="col-sm-7 text-right">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>